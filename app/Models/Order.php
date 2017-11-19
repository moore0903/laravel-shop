<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'serial', 'address','realname','phone','stat','total','discount','totalpay','paytype','trade_no','notify_time','memo','totalget','giftcode_id','pay_order_id','progress','express_company','express_no','remark','postage'
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 前置任务
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $old_order = Order::find($model->id);
            if($old_order){
                if($old_order->stat <=0 && $model->stat > 0){
                    foreach($model->details as $detail){
                        \DB::table('shop_item')->where('id','=',$detail->shop_item_id)->increment('sellcount_real',$detail->product_num);
                    }
                }
            }
        });
    }

    /**
     * 查看当前订单是否所有商品都已经评价过
     * @return bool
     */
    public function evaluationStat(){
        foreach($this->details as $detail){
            if(Comment::getCommentCountByOrderDetail(\Auth::user()->id,$detail->shop_item_id,$this->id,$detail->id) <= 0){
                return false;
            }
        }
        return true;
    }

    public function payed($payorder) {
//        $this->pay_order_id = $payorder->id;
        $this->paytype = $payorder->paytype;
        $this->trade_no = $payorder->trade_no;
        $this->notify_time = $payorder->notify_time;
        $this->totalget = $payorder->totalget;
        if($this->stat == Order::STAT_NOTPAY)  $this->stat = Order::STAT_PAYED;
        $this->save();
    }

    public static function NotHandleOrder(){
        $user = \Auth::user();
        return Order::where('user_id',$user->id)->where('stat', Order::STAT_NOTPAY)->count();
    }


    /**
     * 订单状态简短介绍
     * @param $stat
     * @return string
     */
    public static function statString($stat) {
        switch($stat) {
            case Order::STAT_NOTPAY:
                return '待支付';
                break;
            case Order::STAT_PAYED:
                return '已支付';
                break;
            case Order::STAT_EXPRESS:
                return '快递中';
                break;
            case Order::STAT_FINISH:
                return '已完成';
                break;
            case Order::STAT_CANCEL:
                return '已取消';
                break;
            default:
                return '未知';
                break;
        }
    }

    /**
     * 订单状态描述
     * @param $stat
     * @return string
     */
    public static function statDescribe($stat){
        switch($stat) {
            case Order::STAT_NOTPAY:
                return '订单提交成功';
                break;
            case Order::STAT_PAYED:
                return '商家已收到货款';
                break;
            case Order::STAT_EXPRESS:
                return '商家已经发货';
                break;
            case Order::STAT_FINISH:
                return '商品已收到';
                break;
            case Order::STAT_CANCEL:
                return '已取消';
                break;
            default:
                return '未知';
                break;
        }
    }

    /**
     * 根据流程状态返回中文解释
     * @param $str
     * @return string
     */
    public function progressString($str) {
        $type = intval($str);
        switch($type) {
            case Order::PROGRESS_CREATE:
                return '创建订单';
                break;
            case Order::PROGRESS_PAY_GET:
                return '确认收款';
                break;
            case Order::PROGRESS_PRODUCING:
                return '生产中';
                break;
            case Order::PROGRESS_PACKING:
                return '正在出库';
                break;
            case Order::PROGRESS_EXPRESS:
                $arr = preg_split('/\s+/', $str);
                if(count($arr)>1)
                    return "快递中 <a class='_viewexpress' data-expcompany='{$arr[1]}' data-expno='{$arr[2]}'>【".$arr[1].'】单号 '.$arr[2]."</a>";
                else
                    return '快递中';
                break;
            case Order::PROGRESS_EXPRESS_FINISH:
                return '确认收货';
                break;
            case Order::PROGRESS_CANCEL:
                return '取消订单';
                break;
            case Order::PROGRESS_PAY_START:
                return '开始付款';
                break;
            case Order::PROGRESS_REFUND_START:
                return '开始退款';
                break;
            case Order::PROGRESS_REFUND_END:
                return '退款完成';
                break;
            default:
                return $str;
                break;
        }
    }

    /**
     * 根据支付状态返回中文解释
     * @param $paytype
     * @return string
     */
    public static function paytypeString($paytype){
        switch ($paytype){
            case 'WechatPay':
                return '微信支付';
                break;
            case 'Alipay':
                return '支付宝支付';
                break;
            default:
                return '未支付';
                break;
        }
    }


    /**
     * 订单状态键
     * @var array
     */
    public static $stat_keys = [
        Order::STAT_NOTPAY,
        Order::STAT_PAYED,
        Order::STAT_EXPRESS,
        Order::STAT_FINISH,
        Order::STAT_CANCEL,
    ];

    /**
     * 订单状态值
     * @var array
     */
    public static $stat_values = [
        '订单提交成功',
        '商家已收到货款',
        '商家已经发货',
        '商品已收到',
        '已取消',
    ];

    /**
     * 状态对应的中文
     * @var array
     */
    public static $stat = [
        Order::STAT_NOTPAY => '订单提交成功',
        Order::STAT_PAYED => '商家已收到货款',
        Order::STAT_EXPRESS => '商家已经发货',
        Order::STAT_FINISH => '商品已收到',
        Order::STAT_CANCEL => '已取消',
    ];

    public static $pay = [
        '未支付' => '未支付',
        'WechatPay' => '微信支付',
        'Alipay' => '支付宝支付',
        'ToPublic' => '对公账户',
        'UnionPay' => '银联转账',
        'Other' => '其他'
    ];

    /**
     * 快递公司
     * @var array
     */
    public static $express_company = [
        '自提' => '自提',
        '顺丰' => '顺丰',
        '中通' => '中通',
        '圆通' => '圆通',
        '韵达' => '韵达',
        '国通' => '国通',
        'EMS' => 'EMS',
        '申通' => '申通',
    ];

    /**
     * 订单状态简短介绍
     * @param $stat
     * @return string
     */
    public static function express_coding($stat) {
        switch($stat) {
            case '顺丰':
                return 'shunfeng';
                break;
            case '中通':
                return 'zhongtong';
                break;
            case '圆通':
                return 'yuantong';
                break;
            case '韵达':
                return 'yunda';
                break;
            case '国通':
                return 'guotongkuaidi';
                break;
            case 'EMS':
                return 'ems';
                break;
            case '申通':
                return 'shentong';
                break;
            default:
                return '自提';
                break;
        }
    }


    const  STAT_NOTPAY = 0;   //未支付
    const  STAT_PAYED = 1;  //已支付
    const  STAT_EXPRESS = 2;  //快递中
    const  STAT_EVALUATE = 3;   //待评价
    const  STAT_FINISH = 4;   //已完成
    const  STAT_CANCEL = -1;   //已取消
    const  STAT_SERVICE = 99;
    const PROGRESS_CREATE = 1;
    const PROGRESS_PAY_GET = 2;
    const PROGRESS_PRODUCING = 3;
    const PROGRESS_PACKING = 4;
    const PROGRESS_EXPRESS = 5;
    const PROGRESS_EXPRESS_FINISH = 6;
    const PROGRESS_CANCEL = 7;
    const PROGRESS_PAY_START = 8;
    const PROGRESS_REFUND_START = 9;
    const PROGRESS_REFUND_END = 10;
}

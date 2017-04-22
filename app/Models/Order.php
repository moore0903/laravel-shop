<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';


    public function details()
    {
        return $this->hasMany(OrderDetail::class,'order_id');
    }


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
            case Order::STAT_SERVICE:
                return '售后中';
                break;
            default:
                return '未知';
                break;
        }
    }

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

    public static function paytypeString($paytype){
        switch ($paytype){
            case 'WechatPay_Js':
                return '微信支付';
                break;
            case 'Alipay_WapExpress':
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
        Order::STAT_SERVICE
    ];

    /**
     * 订单状态值
     * @var array
     */
    public static $stat_values = [
        '未支付',
        '已支付',
        '快递中',
        '已完成',
        '已取消',
        '售后中'
    ];

    public static $stat = [
        Order::STAT_NOTPAY => '未支付',
        Order::STAT_PAYED => '已支付',
        Order::STAT_EXPRESS => '快递中',
        Order::STAT_FINISH => '已完成',
        Order::STAT_CANCEL => '已取消',
        Order::STAT_SERVICE => '售后中',
    ];

    public static $express_company = [
        '自提' => '自提',
        '顺丰' => '顺丰',
        '中通' => '中通',
        '圆通' => '圆通',
        '韵达' => '韵达',
        '国通' => '国通',
        'EMS' => 'EMS',
        '百世汇通' => '百世汇通',
    ];

    const  STAT_NOTPAY = 0;   //未支付
    const  STAT_PAYED = 1;  //已支付
    const  STAT_EXPRESS = 2;  //快递中
    const  STAT_FINISH = 3;   //已完成
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
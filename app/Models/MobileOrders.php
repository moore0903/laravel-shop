<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileOrders extends Model
{
    protected $table = 'mobile_orders';

    protected $fillable = [
        'user_id', 'avatar', 'realname','nick_name','phone','color','address','university','brand','model','order_time','problem','stat','engineer','remark'
    ];

    public static function datatime(){
        $weekarray = array("日","一","二","三","四","五","六");
        $datatime = [];
        for($i=0;$i<7;$i++){
            $tomorrow = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
            switch ($i){
                case 0:
                    $datatime[] = date("Y-m-d", $tomorrow).' 周'.$weekarray[date("w",$tomorrow)].'(今天)';
                    break;
                case 1:
                    $datatime[] = date("Y-m-d", $tomorrow).' 周'.$weekarray[date("w",$tomorrow)].'(明天)';
                    break;
                case 2:
                    $datatime[] = date("Y-m-d", $tomorrow).' 周'.$weekarray[date("w",$tomorrow)].'(后天)';
                    break;
                default:
                    $datatime[] = date("Y-m-d", $tomorrow).' 周'.$weekarray[date("w",$tomorrow)];
                    break;
            }
        }
        return $datatime;
    }

    /**
     * 订单状态键
     * @var array
     */
    public static $stat_keys = [
        MobileOrders::STAT_ORDER,
        MobileOrders::STAT_RECEIVE,
        MobileOrders::STAT_REPAIR,
        MobileOrders::STAT_FINISH
    ];

    /**
     * 订单状态值
     * @var array
     */
    public static $stat_values = [
        '预约成功',
        '工作人员上门中',
        '维修中',
        '已完成'
    ];

    /**
     * 状态对应的中文
     * @var array
     */
    public static $stat = [
        MobileOrders::STAT_ORDER => '预约成功',
        MobileOrders::STAT_RECEIVE => '工作人员上门中',
        MobileOrders::STAT_REPAIR => '维修中',
        MobileOrders::STAT_FINISH=>'已完成'
    ];

    const  STAT_ORDER = 0;   //预约成功
    const  STAT_RECEIVE = 1;  //工作人员上门中
    const  STAT_REPAIR = 2;  //维修中
    const  STAT_FINISH = 3;   //已完成
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayOrder extends Model
{
    protected $table = 'pay_order';

    protected $fillable = [
        'order_id', 'subject', 'total','discount','totalpay','paytype','trade_no','totalget'
    ];

    public static $aliFundChannel=[
        'COUPON'=>'支付宝红包',
        'ALIPAYACCOUNT'=>'支付宝余额',
        'POINT'=>'集分宝',
        'DISCOUNT'=>'折扣券',
        'PCARD'=>'预付卡',
        'FINANCEACCOUNT'=>'余额宝',
        'MCARD'=>'商家储值卡',
        'MDISCOUNT'=>'商户优惠券',
        'MCOUPON'=>'商户红包',
        'PCREDIT'=>'蚂蚁花呗',
    ];

    public function payNotify($trade_no,$notify_time,$total_fee){
        if($this->notify_time>0)    return;
        $this->trade_no = $trade_no;
        $this->notify_time = $notify_time;
        $this->totalget = $total_fee;
        $this->order->payed($this);
        $this->save();
    }
}

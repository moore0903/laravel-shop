<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/18
 * Time: 11:20
 */

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PayOrder;
use Illuminate\Http\Request;
use Payment\Common\PayException;
use Payment\Client\Charge;

class PayController extends Controller
{
    public function aliPay(Request $request){
        $order = Order::find($request['order_id']);
        $config = require_once('/config/aliconfig.php');
        $channel = 'ali_wap';
        $payData = [
            'body' => '订单编号:'.$order->serial,
            'subject' => '牛逼公司--付款吧',
            'order_no' => $order->serial,
            'timeout_express' => time(data('Y-m-d h:i:s',strtotime('+1 day'))),
            'amount' => $order->totalpay,
            'return_param' => 'buy some',
            'goods_type' => 1,
            'store_id' => '',// 没有就不设置
        ];

        try {
            $payUrl = Charge::run($channel, $config, $payData);
        } catch (PayException $e) {
            // 异常处理
            exit;
        }

        echo htmlspecialchars($payUrl);
    }

    /**
     * 支付宝回调
     * @param Request $request
     */
    public function aliReturnPay(Request $request){
        $fund_bill_list = json_decode($request['fund_bill_list'],true);
        $serial = $request['out_trade_no'];
        $order = Order::where('serial','=',$serial)->first();
        $order->stat = Order::STAT_PAYED;
        $order->trade_no = $request['trade_no'];
        $order->notify_time = $request['notify_time'];
        $order->totalget = $request['receipt_amount'];
        $order->save();
        PayOrder::insert([
            'order_id'=>$order->id,
            'subject'=>'订单号'.$order->serial,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'totalpay'=>$order->totalpay,
            'paytype'=>PayOrder::$aliFundChannel[$fund_bill_list['fundChannel']],
            'trade_no'=>$request['trade_no'],
            'totalget'=>$request['receipt_amount'],
        ]);
    }



}
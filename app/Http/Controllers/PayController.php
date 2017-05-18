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
use Omnipay\Omnipay;
use Payment\Common\PayException;
use Payment\Client\Charge;

class PayController extends Controller
{
    public function aliPay(Request $request){
        $order = Order::find($request['order_id']);
        $gateway = Omnipay::create('Alipay_AopPage');
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setReturnUrl(config('aliconfig.return_url'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));

        $response = $gateway->purchase()->setBizContent([
            'subject'      => '订单编号:'.$order->serial,
            'out_trade_no' => date('YmdHis') . mt_rand(1000, 9999),
            'total_amount' => $order->totalpay,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ])->send();

        $response->redirect();
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
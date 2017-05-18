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

class PayController extends Controller
{
    public function aliPay(Request $request){
        $order = Order::find($request['order_id']);

        $order->stat = Order::STAT_PAYED;
        $order->notify_time = new \Carbon\Carbon();
        $order->save();

        $inMobile = preg_match('/iPad|iPhone|iPod|iOS|Android|Windows Phone|Mobile/i',$_SERVER['HTTP_USER_AGENT']??'');
        $paytype = 'Alipay_LegacyExpress';
        if($inMobile) {
            $paytype = 'Alipay_LegacyWap';
        }

        $gateway = Omnipay::create($paytype);
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setReturnUrl(config('aliconfig.return_url'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));

        $subject = '订单号：'.$order->serial;

        $payorder = PayOrder::firstOrCreate([
            'order_id'=>$order->id,
            'order_serial'=>$order->serial,
            'subject'=>$subject,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'totalpay'=>$order->totalpay,
            'paytype'=>$paytype,
            'payaccount'=>$gateway->getPartner(),
        ]);

        $response = $gateway->purchase()->setBizContent([
            'subject'      => '订单编号:'.$order->serial,
            'out_trade_no' => $payorder->order_serial.'_'.$payorder->id,
            'total_amount' => $order->totalpay,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ])->send();

        $response->redirect();
    }

    /**
     * 支付宝回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function aliReturnPay(Request $request){

        $inMobile = preg_match('/iPad|iPhone|iPod|iOS|Android|Windows Phone|Mobile/i',$_SERVER['HTTP_USER_AGENT']??'');
        $paytype = 'Alipay_LegacyExpress';
        if($inMobile) {
            $paytype = 'Alipay_LegacyWap';
        }

        $gateway = Omnipay::create($paytype);
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setReturnUrl(config('aliconfig.return_url'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));

        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE

        /**
         * @var AopCompletePurchaseResponse $response
         */
        try {
            $response = $request->send();

            if($response->isPaid()){
                $out_trade_no = explode('_',$_REQUEST['out_trade_no']);
                $payorder = PayOrder::find(intval($out_trade_no[1]));
                $payorder->payNotify($_REQUEST['trade_no'], $_REQUEST['notify_time'], $_REQUEST['total_fee']);

                die('success'); //The notify response should be 'success' only
            }else{
                /**
                 * Payment is not successful
                 */
                die('fail'); //The notify response
            }
        } catch (Exception $e) {
            /**
             * Payment is not successful
             */
            die('fail'); //The notify response
        }

        return redirect('/order/list');
    }



}
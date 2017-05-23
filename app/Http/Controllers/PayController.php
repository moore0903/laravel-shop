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

class PayController extends Controller
{
    public function aliPay(Request $request){
        $order = Order::find($request['order_id']);

        $gateway = Omnipay::create('Alipay_AopWap');
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));
        $gateway->setReturnUrl(config('aliconfig.return_url'));

        $subject = '订单号：'.$order->serial;

        $payorder = PayOrder::firstOrCreate([
            'order_id'=>$order->id,
            'subject'=>$subject,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'totalpay'=>$order->totalpay,
            'paytype'=>'Alipay_AopWap',
        ]);

        $response = $gateway->purchase()->setBizContent([
            'subject'      => '订单编号:'.$order->serial,
            'out_trade_no' => $payorder->order_id.'_'.$payorder->id,
            'total_amount' => $order->totalpay,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ])->send();

        $response->redirect();
    }

    /**
     * 微信支付
     * @param Request $request
     */
    public function wechatPay(Request $request){
        $order = Order::find($request['order_id']);

        $gateway    = Omnipay::create('WechatPay_Js');
        $gateway->setAppId(config('wxconfig.app_id'));
        $gateway->setMchId(config('wxconfig.mch_id'));
        $gateway->setApiKey(config('wxconfig.api_key'));

        $subject = '订单号：'.$order->serial;

        $payorder = PayOrder::firstOrCreate([
            'order_id'=>$order->id,
            'subject'=>$subject,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'totalpay'=>$order->totalpay,
            'paytype'=>'WechatPay_Js',
        ]);



        $order = [
            'body'              => '订单编号:'.$order->serial,
            'out_trade_no'      => $payorder->order_id.'_'.$payorder->id,
            'total_fee'         => $order->totalpay/100, //=0.01
            'spbill_create_ip'  => 'ip_address',
            'fee_type'          => 'CNY'
        ];

        $request  = $gateway->purchase($order);
        $response = $request->send();

        $response->isSuccessful();
        \Log::debug($response->getData());
        $response->getJsOrderData();
    }

    /**
     * 支付宝回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function aliReturnPay(Request $request){
        $gateway = Omnipay::create('Alipay_AopWap');
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));
        $gateway->setReturnUrl(config('aliconfig.return_url'));

        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET));
        try {
            $response = $request->send();
            if($response->isPaid()){
                $out_trade_no = explode('_',$_REQUEST['out_trade_no']);

                $payorder = PayOrder::find(intval($out_trade_no[1]));
                $payorder->payNotify($_REQUEST['trade_no'], $_REQUEST['notify_time'], $_REQUEST['receipt_amount']);
                return redirect('/order/list');
            }else{
                return redirect('/order/list');
            }
        } catch (Exception $e) {
            \Log::debug($e);
            return redirect('/order/list');
        }
    }

    /**
     * 支付宝回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function aliNotifyPay(Request $request){
        $gateway = Omnipay::create('Alipay_AopWap');
        $gateway->setSignType(config('aliconfig.sign_type')); // RSA/RSA2/MD5
        $gateway->setAppId(config('aliconfig.app_id'));
        $gateway->setPrivateKey(config('aliconfig.rsa_private_key'));
        $gateway->setAlipayPublicKey(config('aliconfig.ali_public_key'));
        $gateway->setNotifyUrl(config('aliconfig.notify_url'));

        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET));
        try {
            $response = $request->send();
            if($response->isPaid()){
                $out_trade_no = explode('_',$_REQUEST['out_trade_no']);

                $payorder = PayOrder::find(intval($out_trade_no[1]));
                $payorder->payNotify($_REQUEST['trade_no'], $_REQUEST['notify_time'], $_REQUEST['receipt_amount']);
                //return redirect('/order/list');
                die('success');
            }else{
                die('fail');
                //return redirect('/order/list');
            }
        } catch (Exception $e) {
            \Log::debug($e);
            die('fail');
            //return redirect('/order/list');
        }
    }

    /**
     * 微信支付回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function wechatReturnPay(Request $request){
        $gateway    = Omnipay::create('WechatPay');
        $gateway->setAppId(config('wxconfig.app_id'));
        $gateway->setMchId(config('wxconfig.mch_id'));
        $gateway->setApiKey(config('wxconfig.api_key'));

        $response = $gateway->completePurchase([
            'request_params' => file_get_contents('php://input')
        ])->send();

        if ($response->isPaid()) {
            $out_trade_no = explode('_',$_REQUEST['out_trade_no']);

            $payorder = PayOrder::find(intval($out_trade_no[1]));
            $payorder->payNotify($_REQUEST['transaction_id'],Carbon::createFromFormat('YmdHis', $_REQUEST['time_end']), $_REQUEST['total_fee']/100);
            \Log::debug($response->getData());
            return redirect('/order/list');
        }else{
            return redirect('/order/list');
        }
    }



}
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PayController extends Controller
{
    public function aliPay(Request $request){
        $order = Order::find($request['order_id']);
//        $paytype = 'Alipay_AopPage';
//        $inMobile = preg_match('/iPad|iPhone|iPod|iOS|Android|Windows Phone|Mobile/i',$_SERVER['HTTP_USER_AGENT']??'') ;
//        if($inMobile){
        $paytype = 'Alipay_AopWap';
//        }
        $gateway    = Omnipay::create($paytype);
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
            'out_trade_no' => $payorder->order_id.'_'.$payorder->id.'_'.$paytype,
            'total_amount' => $order->totalpay,
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
        ])->send();

        $response->redirect();
    }

    /**
     * 微信支付
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wechatPay(Request $request){
        $order = Order::find($request['order_id']);
        $paytype = 'WechatPay_Native';
        $inMobile = preg_match('/iPad|iPhone|iPod|iOS|Android|Windows Phone|Mobile/i',$_SERVER['HTTP_USER_AGENT']??'') ;// strpos(($_SERVER['HTTP_USER_AGENT']??''),'MicroMessenger')!==FALSE;
        $inWechat = strpos(($_SERVER['HTTP_USER_AGENT']??''),'MicroMessenger')!==FALSE;
        if($inWechat){
            $paytype = 'WechatPay_Js';
            $openid = $request->session()->get('openid');
            if(empty($openid)){
                return redirect('oauth/wechat');
            }
            $gateway    = Omnipay::create('WechatPay_Js');
        }else{
            $gateway    = Omnipay::create('WechatPay_Native');
        }
        $gateway->setAppId(config('wxconfig.app_id'));
        $gateway->setMchId(config('wxconfig.mch_id'));
        $gateway->setApiKey(config('wxconfig.api_key'));
        $gateway->setNotifyUrl(config('wxconfig.notify_url'));

        $subject = '订单号：'.$order->serial;
        $payorder = PayOrder::firstOrCreate([
            'order_id'=>$order->id,
            'subject'=>$subject,
            'total'=>$order->total,
            'discount'=>$order->discount,
            'totalpay'=>$order->totalpay,
            'paytype'=>$paytype,
        ]);

        $order = [
            'body'              => '订单编号:'.$order->serial,
            'out_trade_no'      => $payorder->order_id.'_'.$payorder->id,
            'total_fee'         => intval($payorder->totalpay*100), //=0.01
            'spbill_create_ip'  => $_SERVER['SERVER_ADDR']??(isset($_SERVER['HOSTNAME'])?gethostbyname($_SERVER['HOSTNAME']):'127.0.0.1'),
            'fee_type'          => 'CNY',
        ];

        if($inWechat) {
            $order['openid'] = $openid;
        }
        $request  = $gateway->purchase($order);
        $response = $request->send();

        return view('wechatPay',['response'=>$response,'inWechat'=>$inWechat,'inMobile'=>$inMobile]);



    }

    /**
     * 支付宝回调(同步)
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
                $order = Order::find($out_trade_no[0]);
                $order->paytype = '支付宝支付';
                $order->notify_time = $_REQUEST['timestamp'];
                $order->save();
                $payorder = PayOrder::find(intval($out_trade_no[1]));
                $payorder->payNotify($_REQUEST['trade_no'], $_REQUEST['timestamp'], $_REQUEST['total_amount']);
                if(\Auth::check()){
                    \Log::debug(\Auth::user());
                }else{
                    \Log::debug(\Auth::user());
                }
//                die('success');
                return redirect('/order/list');
            }else{
//                die('fail');
                return redirect('/order/list');
            }
        } catch (Exception $e) {
            \Log::debug($e);
//            die('fail');
            return redirect('/order/list');
        }
    }

    /**
     * 支付宝回调(异步)
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
                $order = Order::find($out_trade_no[0]);
                $order->paytype = '支付宝支付';
                $order->notify_time = $_REQUEST['notify_time'];
                $order->save();
                $payorder = PayOrder::find(intval($out_trade_no[1]));
                $payorder->payNotify($_REQUEST['trade_no'], $_REQUEST['notify_time'], $_REQUEST['receipt_amount']);
                die('success');
            }else{
                die('fail');
            }
        } catch (Exception $e) {
            \Log::debug($e);
            die('fail');
        }
    }

    /**
     * 微信支付回调
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function wechatNotifyPay(Request $request){
        $gateway    = Omnipay::create('WechatPay_Native');
        $gateway->setAppId(config('wxconfig.app_id'));
        $gateway->setMchId(config('wxconfig.mch_id'));
        $gateway->setApiKey(config('wxconfig.api_key'));
        $gateway->setNotifyUrl(config('wxconfig.notify_url'));
        $params = file_get_contents('php://input');
        $request = $gateway->completePurchase([
            'request_params' =>$params
        ]);
        $response = $request->send();

        if ($response->isPaid()) {
            $data = $request->getData();
            $out_trade_no = explode('_',$data['out_trade_no']);
            $order = Order::find($out_trade_no[0]);
            $order->paytype = '微信支付';
            $order->notify_time = Carbon::createFromFormat('YmdHis', $data['time_end']);
            $order->save();
            $payorder = PayOrder::find(intval($out_trade_no[1]));
            $payorder->payNotify($data['transaction_id'],Carbon::createFromFormat('YmdHis', $data['time_end']), $data['total_fee']/100);
            return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        }else{
            return '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[error]]></return_msg></xml>';
        }
    }



}
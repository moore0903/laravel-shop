<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/4/25
 * Time: 11:24
 */

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info(){

    }

    /**
     * 登录或注册
     * @param Request $request
     * @return array
     */
    public function bindphone(Request $request){
        if($request['phone']!=session('verifykey'))
            return back()->withInput($request->toArray())
                ->withErrors(['用户名错误']);
        if(!session('verifycode'))
            return back()->withInput($request->toArray())
                ->withErrors(['验证码已过期']);
        if($request['verifycode']!=session('verifycode'))
            return back()->withInput($request->toArray())
                ->withErrors(['验证码错误']);
        $old_user = User::where('phone',$request['phone'])->first();
        if($old_user) {
            \Auth::loginUsingId($old_user->id);
        }else{
            $user = User::create([
                'name' => $request['phone'],
                'email' => $request['phone'].'@'.$request['phone'],
                'password' => bcrypt($request['phone']),
                'phone' => $request['phone'],
                'headimage' => '',
            ]);
            \Auth::loginUsingId($user->id);
        }
        return \Redirect::intended(\Session::pull('url.intended', '/'));
    }

    /**
     * 发送验证码
     * @param Request $request
     * @return array
     */
    public function sendSMSVerify(Request $request){
        if(empty($request['phone'])) {
            return array('stat'=> 0, 'msg'=>'手机号不能为空');
        }
        require_once app_path() . '/../thirdlib/ZhongZhenSMS.php';
        $code = ''.mt_rand(0,9999);
        $code = str_repeat('0',4-strlen($code)).$code;
//        $msg = '您好，您的验证码是'.$code.'【久诚久酒业】';
//        $resstr = NewSms($request['phone'], $msg);
//        if($resstr < 0) {
//            return array('stat'=>0,'msg'=>'短信发送失败.');
//        }
//        \Log::debug($resstr);
//        \Log::debug($code);
        $request->session()->put('verifycode', $code);
        $request->session()->put('verifykey', $request['phone']);
//        return array('stat'=>1);
        return array('stat'=>1,'code'=>$code);   //TODO 上线前将验证码打开
    }
}
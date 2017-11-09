<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ThirdUser;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Overtrue\LaravelSocialite\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers{
        login as _login;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function redirectTo()
    {
        return '/user/info';
    }

    public function showLoginForm(){
        if(isset($_REQUEST['intend'])) {
            session()->put('url.intended', $_REQUEST['intend']);
        }
        return view('auth.login',['route'=>'login','src'=>captcha_src()]);
    }

    public function login(Request $request){
        if(preg_match("/^\d{11,11}$/",$request['username'])) {
            $this->username = 'phone';
        }
        else {
            $this->username = 'email';
        }
        $request[$this->username] = $request['username'];

        $rules = [
            'captcha' => 'required|captcha'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return ['status'=>'n','info'=>'验证码不正确'];
        }
        $user = User::where('name',$request->username)->first();
        if(empty($user)){
            return ['status'=>'n','info'=>'找不到该用户'];
        }
        if (!\Auth::attempt([$this->username => $request['username'], 'password' => $request['password']], true)) {
            return ['stat'=>'n','msg'=>'用户名或密码错误'];
        }
        return ['status'=>'y','info'=>'登录成功'];
    }

    public function logout(){
        \Auth::logout();
        Session::flush();
        return \Redirect::to('/');
    }

}

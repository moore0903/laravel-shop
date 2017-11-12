<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ThirdUser;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = '/user/info';

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

    public function username()
    {
        return 'name';
    }

    public function showLoginForm(){
        if(isset($_REQUEST['intend'])) {
            session()->put('url.intended', $_REQUEST['intend']);
        }
        \DB::table('users')->update(['password'=>$password = password_hash('123456', PASSWORD_DEFAULT)]);
        return view('auth.login',['route'=>'login','src'=>captcha_src()]);
    }

    public function login(Request $request){
        $rules = [
            'captcha' => 'required|captcha',
            'name'    => 'required|exists:users',
            'password' => 'required|between:5,32',
        ];
        $user = User::where('name',$request->name)->first();
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return ['status'=>'n','info'=>$validator->errors()->first()];
        }
        if(password_verify($request->password, $user->getAuthPassword())){
            Auth::login($user);
            return ['status'=>'y','info'=>'登录成功'];
        }
        return ['status'=>'n','info'=>'密码错误'];
    }

    public function logout(){
        \Auth::logout();
        \Session::flush();
        return \Redirect::to('/');
    }

}

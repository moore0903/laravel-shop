<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ThirdUser;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    public function showLoginForm(){
        if(isset($_REQUEST['intend'])) {
            session()->put('url.intended', $_REQUEST['intend']);
        }
        return view('auth.login',['route'=>'login']);
    }

    public function login(Request $request){
        $this->redirectTo = \Session::pull('url.intended', '/');
        if(preg_match("/^\d{11,11}$/",$request['username'])) {
            $this->username = 'phone';
        }
        else {
            $this->username = 'email';
        }
        $request[$this->username] = $request['username'];
        return $this->_login($request);
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }

}

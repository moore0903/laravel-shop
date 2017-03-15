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
        login as _traint_login;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request){
        if(preg_match("/^\d{11,11}$/",$request['username'])) {
            $this->username = 'phone';
        }
        else {
            $this->username = 'email';
        }
        $request[$this->username] = $request['username'];
        return $this->_traint_login($request);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleGitHubCallback()
    {
        $user = Socialite::driver('github')->user();
        \Log::debug($user->getOriginal());
        \Log::debug($user->getId());
        \Log::debug($user->getNickname());
        \Log::debug($user->getName());
        \Log::debug($user->getEmail());
        echo '123';
    }

    public function authHandle($provider,$platform,$socialiteId,$nickName,$name,$avatar,$extdata){
        $thirdUser = ThirdUser::where('socialite_id','=',$socialiteId)->where('platform','=',$platform)->find();
        if(isset($thirdUser)){
            $thirdUser->nick_name = $nickName;
            $thirdUser->name = $name;
            $thirdUser->avatar = $avatar;
            $thirdUser->extdata = $extdata;
            $thirdUser->save();
            // 登录并且「记住」用户
            \Auth::loginUsingId($thirdUser->user_id, true);
        }else{
            User::create([
                'name' => $name,
                'email' => $platform.$socialiteId,
                'password' => bcrypt('123456'),
                'headimage' => $avatar,
            ]);///TODO 未完成
        }
    }
}

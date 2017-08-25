<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/3/16
 * Time: 13:55
 */

namespace App\Http\Controllers;


use App\Models\ThirdUser;
use App\User;
use Illuminate\Http\Request;
use Overtrue\LaravelSocialite\Socialite;

class OAuthController extends Controller
{

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
        $this->authHandle('github',$user->getId(),$user->getName(),$user->getNickname(),$user->getAvatar(),$user->getOriginal());
        return \Redirect::intended(\Session::pull('url.intended', '/'));
    }

    /**
     * Redirect the user to the Wechat authentication page.
     *
     * @return Response
     */
    public function redirectToWechat()
    {
        return Socialite::driver('wechat')->scopes(['snsapi_userinfo'])->redirect();
    }

    /**
     * Obtain the user information from Wechat.
     *
     * @return Response
     */
    public function handleWechatCallback(Request $request)
    {
        $user = Socialite::driver('wechat')->user();
        $this->authHandle('wechat',$user->getId(),$user->getName(),$user->getNickname(),$user->getAvatar(),$user->getOriginal());
        $request->session()->put('openid', $user->getId());
        return \Redirect::intended(\Session::pull('url.intended', '/'));
    }

    public function authHandle($platform,$standardId,$nickName,$name,$avatar,$extdata){
        $thirdUser = ThirdUser::where('standard_id','=',$standardId)->where('platform','=',$platform)->first();
        if(isset($thirdUser)){
            $thirdUser->nick_name = $nickName;
            $thirdUser->name = $name;
            $thirdUser->avatar = $avatar;
            $thirdUser->extdata = json_encode($extdata);
            $thirdUser->save();
            // 登录并且「记住」用户
            \Auth::loginUsingId($thirdUser->user_id, true);
        }else{
            $user = User::create([
                'name' => $name,
                'email' => $platform.$standardId,
                'password' => bcrypt('123456'),
                'headimage' => $avatar,
            ]);
            ThirdUser::create([
                'user_id' => $user->id,
                'standard_id' => $standardId,
                'platform' => $platform,
                'nick_name' => $nickName,
                'name' => $name,
                'avatar' => $avatar,
                'extdata' => json_encode($extdata),
            ]);
            // 登录并且「记住」用户
            \Auth::loginUsingId($user->id, true);
        }

    }

}
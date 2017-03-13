<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/3/13
 * Time: 14:57
 */

namespace App\Http\Controllers;


use Overtrue\LaravelSocialite\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        \Log::debug($user->getId());
        \Log::debug($user->getNickname());
        \Log::debug($user->getName());
        \Log::debug($user->getEmail());
        echo '123';
    }

}
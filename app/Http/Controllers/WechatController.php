<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/3/22
 * Time: 19:45
 */

namespace App\Http\Controllers;


class WechatController extends Controller
{

    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });

        \Log::debug('return response.');

        return $wechat->server->serve();
    }


    public function profile(){
        $oauth = \EasyWeChat::oauth();

        // 未登录
        if (empty($_SESSION['wechat_user'])) {
            $_SESSION['target_url'] = 'user/profile';
            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        // 已经登录过
        $user = $_SESSION['wechat_user'];
    }

}
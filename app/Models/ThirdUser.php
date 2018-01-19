<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdUser extends Model
{
    protected $table = 'users_third';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'standard_id', 'platform','nick_name','name','avatar','extdata'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    static $templateType = [
        '1' => [   //新订单通知
            'templateId'=>'FcWAAsXeYuwaxsDpmnVxIb7jmtRdhBUL0eavWaR3SBk',
            'openid'=>[
				'o6GH4v2dM2NSSo4PT2LshVXI932c',  //大锤
                'o6GH4vymyzAGQhgUkx50n50o7-j4',  //贺大
                'o6GH4v1YXzA6YvNJFYoibfKXRRfg',  //老李
                'o6GH4v9DZZlHm3fGYpo0DjXPYQvQ',  //cc
                'o6GH4v31rMIrpXiOglrFhWu6r4qA',  //胡雅琪
            ],
            'url'=>'http://www.jcj979.com/'
        ]
    ];


    /**
     * 发送模板消息
     * @param $templateType
     * @param $data
     */
    public static function templateNotice($templateType,$data){
        $notice = \EasyWeChat::notice();
        $template = ThirdUser::$templateType[$templateType];
        foreach($template['openid'] as $openid){
            $result = $notice->to($openid)->uses($template['templateId'])->andUrl($template['url'])->data($data)->send();
            \Log::debug($result);
        }

    }
}

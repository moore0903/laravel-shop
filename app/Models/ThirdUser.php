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
        '1' => [   //新预约通知
            'templateId'=>'ddvgO7TJBmJqdktxiRAxXU4_QbPkZdFcitxc3IDSzwc',
            'openid'=>[
                'o9MrhwZW4ux04BH_doYoY_H7NVy0',  //大锤
                'o9MrhwXND-d8zv3QFQCkq2REGHhA',  //全蛋
            ],
            'url'=>'http://gaoxiaoxiu.qinfengyunxun.com/admin'
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

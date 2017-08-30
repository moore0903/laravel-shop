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
        ],
    ];
    /**
     * 发送模板消息
     * @param $templateType
     * @param $data
     */
    public static function templateNotice($templateType,$data,$url=''){
        $notice = \EasyWeChat::notice();
        $template = ThirdUser::$templateType[$templateType];
        foreach($template['openid'] as $openid){
            $result = $notice->to($openid)->uses($template['templateId'])->andUrl($url??$template['url'])->data($data)->send();
            \Log::debug($result);
        }
    }

    /**
     * 维修模板消息
     * @param $openid
     */
    public static function repairTemplateNotice($openid){
        $notice = \EasyWeChat::notice();
        $data = [
            'first'=>'有一条新报修,请注意查看',
            'keyword1'=>'手机/电脑报修',
            'keyword2'=>'需要维修',
            'keyword3'=>date('Y-m-d H:i:s',time()),
            'remark'=>'有一条新报修,请注意查看'
        ];
        $result = $notice->to($openid)->uses('ddvgO7TJBmJqdktxiRAxXU4_QbPkZdFcitxc3IDSzwc')->andUrl('http://gaoxiaoxiu.qinfengyunxun.com/admin')->data($data)->send();
        \Log::debug($result);
    }

    /**
     * 根据用户标签获取用户
     * @return array
     */
    public static function wxUserTags(){
        $result['0'] = '暂无';
        $user_tag = \EasyWeChat::user_tag();
        foreach($user_tag->lists()->tags as $tag){
            if($tag['name'] == '工程师'){
                $data = $user_tag->usersOfTag($tag['id'], $nextOpenId = '');
                break;
            }
        }
        if(!empty($data)){
            foreach($data->data['openid'] as $openid){
                $thirdUser = ThirdUser::where('standard_id','=',$openid)->first();
                if(!empty($thirdUser)){
                    $result[$openid] = $thirdUser->nick_name;
                }else{
                    $user = \EasyWeChat::user();
                    $userInfo = $user->get($openid);
                    $result[$openid] = $userInfo->nickname;
                }
            }
        }
        return $result;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/4/19
 * Time: 17:10
 */

namespace App\Http\Controllers;


use App\Models\Giftcode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiftcodeController extends Controller
{

    /**
     * 可用优惠劵列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function availableGiftcodes(){
        $now = Carbon::now();
        $giftCodes = Giftcode::where('usecountmax','>','usecount')
            ->where('start_time','<',$now)
            ->where('end_time','>',$now)
            ->where('user_id','=','0')
            ->groupBy('title','discountn','discountnlimit','usecountmax','start_time','end_time')
            ->get();

        return view('receiveGiftcodes',[
            'giftcodes' => $giftCodes
        ]);
    }

    /**
     * 领取优惠劵
     * @param Request $request
     * @return array
     */
    public function receiveGiftcode(Request $request){
        if(!\Auth::check()) return ['stat'=>0,'msg'=>'请登录后领取!','url'=>url('/login')];
        $is_gift = Giftcode::where('title',$request['title'])
            ->where('discountn',$request['discountn'])
            ->where('discountnlimit',$request['discountnlimit'])
            ->where('usecountmax',$request['usecountmax'])
            ->where('start_time',$request['start_time'])
            ->where('end_time',$request['end_time'])
            ->first();
        if(!$is_gift) return ['stat'=>0,'msg'=>'没有该优惠劵,请核实'];
        //查看当前用户是否存在该优惠劵领取过的情况
        $is_receive = Giftcode::where('title',$request['title'])
            ->where('discountn',$request['discountn'])
            ->where('discountnlimit',$request['discountnlimit'])
            ->where('start_time',$request['start_time'])
            ->where('end_time',$request['end_time'])
            ->where('user_id','=',\Auth::user()->id)
            ->first();
        if($is_receive) return ['stat'=>0,'msg'=>'你已领取过该优惠劵,请不要重复领取'];
        //避免优惠劵存在重复领取,该查询查除ID及优惠码其他数据,并随机返回一条数据
        $giftcode = Giftcode::where('title',$request['title'])
            ->where('discountn',$request['discountn'])
            ->where('discountnlimit',$request['discountnlimit'])
            ->where('usecountmax',$request['usecountmax'])
            ->where('start_time',$request['start_time'])
            ->where('end_time',$request['end_time'])
            ->inRandomOrder()
            ->first();
        //判断该优惠劵是否可以多次使用,如果可以多次使用则新增一条该优惠劵,如果不能多次使用则修改user_id
        if($giftcode->usecountmax > 1){
            Giftcode::insert([
                'title' => $giftcode->title,
                'code' => '',
                'discountn' => $giftcode->discountn,
                'discountnlimit' => $giftcode->discountnlimit,
                'usecountmax' => 1,
                'codecount' => 1,
                'usecount' => 0,
                'user_id' => \Auth::user()->id,
                'p_id' => $giftcode->id,
                'start_time' => $giftcode->start_time,
                'end_time' => $giftcode->end_time,
                'net' => $giftcode->net??url('/'),
            ]);
        }else{
            $giftcode->user_id = \Auth::user()->id;
            $giftcode->save();
        }
        return ['stat'=>1,'成功领取优惠劵'];
    }



}
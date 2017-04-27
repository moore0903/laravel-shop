<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/4/25
 * Time: 11:24
 */

namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\Collection;
use App\Models\Giftcode;
use App\Models\Order;
use App\Models\ShopItem;
use App\Models\Browse;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 用户中心首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(){
        $order_list = Order::where('user_id','=',\Auth::user()->id)->get();
        $recomment_shop = ShopItem::where('recommend','=','1')->get();
        return view('user_info',[
            'recomment_shop' => $recomment_shop->count() > 4 ? $recomment_shop->random(4): $recomment_shop,
            'order_no_pay_count' => $order_list->filter(function($order){return $order->stat == Order::STAT_NOTPAY;})->count(),
            'order_express_count' => $order_list->filter(function($order){return $order->stat == Order::STAT_EXPRESS || $order->stat == Order::STAT_PAYED;})->count(),
            'order_finish_count' => $order_list->filter(function($order){return $order->stat == Order::STAT_FINISH;})->count(),
            'order_service_count' => $order_list->filter(function($order){return $order->stat == Order::STAT_SERVICE;})->count(),
        ]);
    }

    public function myGift(){
        return view('user_gift',[
            'gift_list'=>Giftcode::where('user_id','=',\Auth::user()->id)->get(),
        ]);
    }

    public function myCollection(){
        return view('user_collection',[
            'collection_list'=>Collection::where('user_id','=',\Auth::user()->id)->with('shopItem')->get()
        ]);
    }

    public function myBrowse(){
        return view('user_browse',[
            'browse_list'=>Browse::where('user_id','=',\Auth::user()->id)->with('shopItem')->get()
        ]);
    }

    /**
     * 添加收货地址
     * @param Request $request
     * @return array
     */
    public function addAddress(Request $request)
    {
        $validator = $this->addressValidator($request->all());
        if ($validator->fails()) {
            return ['stat' => 0, 'msg' => $validator->getMessageBag()->first()];
        }
        $data = [
            'user_id' => \Auth::user()->id,
            'realname' => $request['realname'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        ];
        $id = Address::insertGetId($data);
        if (!empty($id)) return ['stat' => 1, 'data' => Address::find($id),'address_list'=>Address::where('user_id','=',\Auth::user()->id)->get()];
        else return ['stat' => 0, 'msg' => '添加收货地址失败,请联系管理员!'];
    }

    /**
     * 删除收货地址
     * @param Request $request
     * @return array
     */
    public function delAddress(Request $request){
        $address = Address::where('user_id','=',\Auth::user()->id)->where('id','=',$request['id'])->first();
        if(empty($address)) return ['stat'=>0,'msg'=>'不能删除不属于自己的收货地址或不存在的收货地址!'];
        $address->delete();
        return ['stat'=>'1','address_list'=>Address::where('user_id','=',\Auth::user()->id)->get()];
    }

    /**
     * 修改收货地址
     * @param Request $request
     * @return array
     */
    public function updateAddress(Request $request)
    {
        $validator = $this->addressValidator($request->all());
        if ($validator->fails()) {
            return ['stat' => 0, 'msg' => $validator->getMessageBag()->first()];
        }
        $address = Address::find($request['id']);
        if(empty($address)) return ['stat'=>0,'msg'=>'找不到该收货地址'];
        $address->realname = $request['realname'];
        $address->address = $request['address'];
        $address->phone = $request['phone'];
        $address->save();
        $data = [
            'user_id' => \Auth::user()->id,
            'realname' => $request['realname'],
            'address' => $request['address'],
            'c' => $request['phone'],
        ];
        Address::where('id','=',$request['id'])->update($data);
        return ['stat' => 1, 'data' => Address::find($request['id']),'address_list'=>Address::where('user_id','=',\Auth::user()->id)->get()];
    }

    /**
     * 添加收货地址的验证
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function addressValidator(array $data)
    {
        return \Validator::make($data, [
            'realname' => 'required|max:191',
            'address' => 'required|max:191',
            'phone' => 'required|digits:11',
        ]);
    }

    /**
     * 登录或注册
     * @param Request $request
     * @return array
     */
    public function bindphone(Request $request){
        if($request['phone']!=session('verifykey'))
            return back()->withInput($request->toArray())
                ->withErrors(['用户名错误']);
        if(!session('verifycode'))
            return back()->withInput($request->toArray())
                ->withErrors(['验证码已过期']);
        if($request['verifycode']!=session('verifycode'))
            return back()->withInput($request->toArray())
                ->withErrors(['验证码错误']);
        $old_user = User::where('phone',$request['phone'])->first();
        if($old_user) {
            \Auth::loginUsingId($old_user->id);
        }else{
            $user = User::create([
                'name' => $request['phone'],
                'email' => $request['phone'].'@'.$request['phone'],
                'password' => bcrypt($request['phone']),
                'phone' => $request['phone'],
                'headimage' => '',
            ]);
            \Auth::loginUsingId($user->id);
        }
        return \Redirect::intended(\Session::pull('url.intended', '/'));
    }

    /**
     * 发送验证码
     * @param Request $request
     * @return array
     */
    public function sendSMSVerify(Request $request){
        if(empty($request['phone'])) {
            return array('stat'=> 0, 'msg'=>'手机号不能为空');
        }
        require_once app_path() . '/../thirdlib/ZhongZhenSMS.php';
        $code = ''.mt_rand(0,9999);
        $code = str_repeat('0',4-strlen($code)).$code;
//        $msg = '您好，您的验证码是'.$code.'【久诚久酒业】';
//        $resstr = NewSms($request['phone'], $msg);
//        if($resstr < 0) {
//            return array('stat'=>0,'msg'=>'短信发送失败.');
//        }
//        \Log::debug($resstr);
//        \Log::debug($code);
        $request->session()->put('verifycode', $code);
        $request->session()->put('verifykey', $request['phone']);
//        return array('stat'=>1);
        return array('stat'=>1,'code'=>$code);   //TODO 上线前将验证码打开
    }
}
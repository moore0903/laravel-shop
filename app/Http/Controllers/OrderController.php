<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/4/17
 * Time: 17:17
 */

namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\Config;
use App\Models\Giftcode;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cartsubmitquick(Request $request){
        if($request->method() == 'GET') {
            return \Redirect::intended('cart/list');
        }
        $address_list = Address::where('user_id','=',\Auth::user()->id)->get();
        $gift_list = Giftcode::where('user_id','=',\Auth::user()->id)->get();
        $cart_list = [];
        $cartids = explode(',',$request['rowids']);
        foreach($cartids as $cartid){
            $cart_list[$cartid] = \Cart::get($cartid);
        }
        $dillCart = collect(\Cart::all())->diffKeys(collect($cart_list));
        foreach($dillCart as $raw_id => $cart){
            \Cart::remove($raw_id);
        }
        //物流费用
        $configs = \App\Models\Config::all();
        $post_price = $configs->where('key','post_price')->first();
        $include_postage = $configs->where('key','include_postage')->first();
        $postage = 0.00;
        if(!empty($post_price) && (empty($include_postage) && \Cart::totalPrice < $include_postage->value)){
            $postage = $post_price->value;
        }
        return view('cartsubmitquick',[
            'address_list' => $address_list,
            'gift_list' => $gift_list,
            'cart_list' => \Cart::all(),
            'cart_count'=>\Cart::count(),
            'cart_totalPrice'=>\Cart::totalPrice(),
            'postage'=>$postage
        ]);
    }

    /**
     * 加入订单
     * @param Request $request
     */
    public function addOrder(Request $request){
        DB::transaction(function () use($request){
            //获取收货地址
            $address = Address::where('id', $request['useraddress'])->where('user_id', Auth::user()->id)->first();
            if (!$address) {
                return back()->withInput()->withErrors(['msg' => '请选择一个地址']);
            }

            //获取优惠券
            if (!empty($request['gift'])) {
                $gift = Giftcode::where('id', $request['gift'])->first();
                if (!$gift) return back()->withInput()->withErrors(['msg' => '优惠券不存在']);
                $now = new \Carbon\Carbon();
                if (!$now->between($gift->start_time, $gift->end_time)) return back()->withInput()->withErrors(['msg' => '优惠券不在有效期']);
                if ($gift->usecount >= $gift->usecountmax) return back()->withInput()->withErrors(['msg' => '优惠券已被使用']);
                if ($gift->discountnlimit < \Cart::totalPrice()) return back()->withInput()->withErrors(['msg' => '购物车内商品不满足该优惠券']);
                $gift->usecount += 1;
                $gift->save();
            }

            if (\Cart::count() <= 0) return back()->withInput()->withErrors(['msg' => '由于长时间未操作,购物车已过期,请重新下单']);

            $orders = $shopItems = [];
            $cartids = json_decode($request['rowids'], true);
            $configs = Config::all();
            $post_price = $configs->where('key','post_price')->first();
            $include_postage = $configs->where('key','include_postage')->first();
            $total = \Cart::totalPrice();
            $discount = 0;

            foreach ($cartids as $rowId) {
                if (empty($rowId)) continue;
                $cartitem = \Cart::get($rowId);
                if (!$cartitem) continue;
                $shopItem = ShopItem::find($cartitem->id);
                if (!$shopItem) continue;
                if (!$shopItem->count <= 0 && $shopItem->show) return back()->withInput()->withErrors(['msg' => '商品[' . $shopItem->title . ']已下架或库存不足，不能购买！']);
                if ($shopItem->count < $cartitem->qty) return back()->withInput()->withErrors(['msg' => '商品[' . $shopItem->title . ']库存不足，不能购买！']);
                $detail = new OrderDetail([
                    'shop_item_id' => $shopItem->id,
                    'product_title' => $shopItem->title,
                    'product_num' => $cartitem->qty,
                    'thumbnail' => $shopItem->img,
                    'product_price' => $shopItem->price,
                    'shop_item_catalog' => $shopItem->catalog->title,
                ]);

                $details[] = $detail;
                $shopItems[$shopItem->id]['count'] = $shopItem->count - $cartitem->qty;

                foreach ($cartids as $rowId) {
                    \Cart::remove($rowId);
                }
            }

            $order = Order::create([
                'user_id' => \Auth::user()->id,
                'serial' => date('YmdHis') . str_random(6),
                'address' => $address->area.' '.$address->address,
                'realname' => $address->realname,
                'phone' => $address->phone,
                'stat' => Order::STAT_NOTPAY,
                'remark' => $request['remark']??'',
                'giftcode_id'=>$gift?$gift->id:0,
                'memo'=>'',
                'post_price'=>!empty($post_price) ? $post_price->value : '0.00'
            ]);

            foreach($details as $detail) {
                $detail->order_id = $order->id;
            }

            if($gift){
                $order->memo .= '(优惠券ID='.$gift->id.')满'+$gift->discountnlimit+'元减'+$gift->discountn+'元。';
                $discount = $gift->discountn;
            }

            $order->details()->saveMany($details);
            $order->total = $total;
            $order->discount = $discount;
            $order->totalpay = max(0, $total - $order->discount + !empty($post_price) ? $post_price->value : '0.00' - !empty($include_postage) && $include_postage->value >= ($total - $order->discount) ? $include_postage->value : '0.00');
            if ($order->totalpay == 0) $order->stat = Order::STAT_PAYED;

            $order->save();

        });
    }

    /**
     * 添加邮寄地址
     * @param Request $request
     * @return array
     */
    public function addAddress(Request $request){
        $validator = $this->addressValidator($request->all());
        if ($validator->fails()) {
            return ['stat'=>0,'msg'=>$validator->getMessageBag()->first()];
        }
        $data = [
            'user_id' => \Auth::user()->id,
            'realname' => $request['realname'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'area' => $request['area'],
        ];
        $id = Address::insertGetId($data);
        if(!empty($id)) return ['stat'=>1,'data'=>$data];
        else return ['stat'=>0,'msg'=>'添加邮寄地址失败,请联系管理员!'];
    }

    /**
     * 添加邮寄地址的验证
     * @param array $data
     * @return \Illuminate\Validation\Validator
     */
    protected function addressValidator(array $data){
        return \Validator::make($data,[
            'realname' => 'required|max:191',
            'address' => 'required|max:191',
            'phone' => 'required|digits:11',
            'area' => 'required|max:191',
        ]);
    }

}
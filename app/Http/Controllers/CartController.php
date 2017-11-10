<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/3/20
 * Time: 20:47
 */

namespace App\Http\Controllers;


use App\Models\SecKill;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Overtrue\LaravelShoppingCart\Cart;
use Vinkla\Hashids\Facades\Hashids;

class CartController extends Controller
{

    public function cartAll(){
        return \Cart::all();
    }

    public function submitCartQuick(Request $request){
        $shop_item_id = $request['shop_item_id'];
        $quantity = $request['qty']??'1';
        $cartitem = \Cart::search(['id'=>$shop_item_id]);
        $shopItem = ShopItem::find($shop_item_id);
        if($cartitem->count()<1) $cartitem = null;
        else $cartitem = $cartitem->first();
        if($cartitem){
            \Cart::remove($cartitem->__raw_id);
        }
        $time = date('Y-m-d h:i:s');
        $secKill = SecKill::where('shop_item_id','=',$shopItem->id)->where('start_time','<',$time)->where('end_time','>',$time)->first();
        if(!empty($secKill)) $price = $secKill->sec_kill_price;
        else $price = $shopItem->price;
        $cartitem = \Cart::add($shopItem->id,$shopItem->title,$quantity,$price,['imgUrl'=>asset('upload/'.$shopItem->img),'url'=>url('/shop_item/detail/'.$shopItem->hashid),'hashid'=>\Hashids::encode($shopItem->id)]);
        $cartitems[$cartitem->__raw_id] = $cartitem;
        return view('cart_list',[
            'cart_lists'=>collect($cartitems),
            'cart_count'=>$quantity,
            'cart_totalPrice'=>$price,
            'cart_raw_count' => '1'
        ]);

    }

    public function list(){
        return view('cart_list',[
            'cart_lists'=>\Cart::all(),
            'cart_count'=>\Cart::count(),
            'cart_totalPrice'=>\Cart::totalPrice(),
            'cart_raw_count' => \Cart::count(false),
            'user' => \Auth::user()
        ]);
    }

    /**
     * 加入购物车
     * @param Request $request
     * @return array
     */
    public function addCart(Request $request){
        $shopItem = ShopItem::where('id','=',$request->id)->first();
        $stat = 0;
        if(isset($shopItem)){
            $user = \Auth::user();
            \Cart::add($shopItem->id,$shopItem->title,$request->qty??1,$shopItem->price*$user->discount,[
                'title'=>$shopItem->title,
                'price'=>$shopItem->price,
                'id'=>$shopItem->id,
                'discount' => $user->discount,
                'discount_price' => $shopItem->price * $user->discount
            ]);
            $stat = 1;
        }
        return ['stat'=>$stat,'cart_lists'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_totalPrice'=>\Cart::totalPrice(),'cart_raw_count' => \Cart::count(false)];
    }

    /**
     * 修改购物车
     * @param Request $request
     * @return array
     */
    public function updateCart(Request $request){
        \Log::debug($request->all());
//        $cart_item = \Cart::get($request['raw_id']);
//        if(!empty($cart_item)){
//            $qty = empty($request['qty']) ? $cart_item->qty - 1 : $request['qty'];
//            \Cart::update($request['raw_id'],$qty);
//        }
        return ['stat'=>1,'cart_lists'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_totalPrice'=>\Cart::totalPrice(),'cart_raw_count' => \Cart::count(false)];
    }

    /**
     * 删除购物车中某商品
     * @param Request $request
     * @return array
     */
    public function delCart(Request $request){
        \Cart::remove($request['raw_id']);
        return ['stat'=>1,'cart_lists'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_totalPrice'=>\Cart::totalPrice(),'cart_raw_count' => \Cart::count(false)];
    }
}
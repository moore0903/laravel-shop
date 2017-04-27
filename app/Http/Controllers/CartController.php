<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 2017/3/20
 * Time: 20:47
 */

namespace App\Http\Controllers;


use App\Models\ShopItem;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class CartController extends Controller
{

    public function cartAll(){
        return \Cart::all();
    }

    public function submitCartQuick(Request $request){
        session()->put('url.intended', url('cart/list'));
        $shop_item_id = $request['shop_item_id'];
        $quantity = $request['qty']??'1';
        $cartitem = \Cart::search(['id'=>$shop_item_id]);
        $shopItem = ShopItem::find($shop_item_id);
        if(!empty($cartitem)){
            $cartitem = $cartitem->first();
            \Cart::remove($cartitem->__raw_id);
        }
        $cartitem = \Cart::add($shopItem->id,$shopItem->title,$quantity,$shopItem->price,['imgUrl'=>asset('upload/'.$shopItem->img),'url'=>url('/shop_item/detail/'.$shopItem->hashid),'hashid'=>\Hashids::encode($shopItem->id)]);
        $cartitems[$cartitem->__raw_id] = $cartitem;
        return view('cart_list',[
            'cart_lists'=>collect($cartitems),
            'cart_count'=>$quantity,
            'cart_totalPrice'=>$shopItem->price,
            'cart_raw_count' => '1'
        ]);

    }

    public function list(){
        session()->put('url.intended', url('cart/list'));
        \Log::debug(\Cart::all()->toArray());
        return view('cart_list',[
            'cart_lists'=>\Cart::all(),
            'cart_count'=>\Cart::count(),
            'cart_totalPrice'=>\Cart::totalPrice(),
            'cart_raw_count' => \Cart::count(false),
        ]);
    }

    /**
     * 加入购物车
     * @param Request $request
     * @return array
     */
    public function addCart(Request $request){
        $id = Hashids::decode($request['hash_id']);
        $shopItem = ShopItem::where('id','=',$id)->first();
        $stat = 0;
        if(isset($shopItem)){
            \Cart::add($shopItem->id,$shopItem->title,$request['qty'],$shopItem->price,['imgUrl'=>asset('upload/'.$shopItem->img),'url'=>url('/shop_item/detail/'.$shopItem->hashid),'hashid'=>\Hashids::encode($shopItem->id)]);
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
        $cart_item = \Cart::get($request['raw_id']);
        if(!empty($cart_item)){
            $qty = empty($request['qty']) ? $cart_item->qty - 1 : $request['qty'];
            \Cart::update($request['raw_id'],$qty);
        }
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
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
    public function addCart(Request $request){
        $id = Hashids::decode($request['has_id']);
        $shopItem = ShopItem::where('id','=',$id)->first();
        $stat = 0;
        if(isset($shopItem)){
            \Cart::add($shopItem->id,$shopItem->title,$request['qty'],$shopItem->price,[]);
            $stat = 1;
        }
        return ['stat'=>$stat,'cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()];
    }

    public function updateCart(Request $request){
        switch ($request['type']){
            case 'minus':
                $cart_item = \Cart::get($request['row_id']);
                if(!empty($cart_item)){
                    $qty = empty($request['qty']) ? $cart_item->qty - 1 : $request['qty'];
                    \Cart::update($request['row_id'],$qty);
                }
            break;
        }
        return ['stat'=>1,'cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()];
    }
}
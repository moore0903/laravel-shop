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
        $row = collect([]);
        $stat = 0;
        if(isset($shopItem)){
            $row = \Cart::add($shopItem->id,$shopItem->title,$request['qty'],$shopItem->price,[]);
            $stat = 1;
        }
        return ['stat'=>$stat,'qty'=>$row->qty];
    }
}
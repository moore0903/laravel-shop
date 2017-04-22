<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function welcome(){
        return view('welcome');
    }

    public function detail($has_id){
        $id = Hashids::decode($has_id);
        $shopItem = ShopItem::where('id','=',$id)->first();
        $shopItem->hashid = Hashids::encode($shopItem->id);
        return view('detail',[
            'item' => $shopItem,
            'comments'=>$shopItem->comments,
            'commentCount'=>$shopItem->comments->count(),
            'itemStar'=>$shopItem->comments->avg('pivot.star')??0,
            'cart'=>collect(['cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()])
        ]);
    }


    public function good_list(Request $request){
        $catalogs = Catalog::where('parent_id','=','0')->get();
        $catalogs = $catalogs->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $value->attr = Catalog::where('parent_id','=',$value->id)->get();
            return $value;
        });
        $shopItem = ShopItem::all();
        $shopItem = $shopItem->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $row = \Cart::search(['id'=>$value->id]);
            $row = $row->first();
            $value->rows = $row??'';
            return $value;
        });
        $returnData = [
            'catalogs' => $catalogs,
            'shopItem' => $shopItem,
            'cart'=>collect(['cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()])
        ];

        if(!empty($request['is_api'])) return $returnData;
        return view('good_list',$returnData);
    }

    public function ajax_catalog(Request $request){
        if(empty($request['cata_id'])){
            $catalogs = Catalog::all();
        }else{
            $catalogs = Catalog::where('id','=',$request['cata_id'])->first();
        }
        return ['catalogs'=>$catalogs];
    }


}

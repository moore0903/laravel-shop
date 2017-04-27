<?php

namespace App\Http\Controllers;

use App\Models\Browse;
use App\Models\Catalog;
use App\Models\Collection;
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
        return view('welcome');
    }

    public function welcome(){
        return view('welcome');
    }

    /**
     * 进入详情页
     * @param $hash_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($hash_id){
        $id = Hashids::decode($hash_id);
        $shopItem = ShopItem::where('id','=',$id)->first();
        $shopItem->hashid = Hashids::encode($shopItem->id);
        if(\Auth::check()){
            Browse::recording(\Auth::user()->id,$shopItem->id);
            $is_collection = Collection::where('user_id','=',\Auth::user()->id)->where('shop_item_id','=',$shopItem->id)->first();
        }
        return view('detail',[
            'item' => $shopItem,
            'comments'=>$shopItem->comments,
            'commentCount'=>$shopItem->comments->count(),
            'itemStar'=>$shopItem->comments->avg('pivot.star')??0,
            'cart'=>collect(['cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()]),
            'is_collection'=>empty($is_collection)?0:1,
        ]);
    }


    /**
     * 进入商品列表
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            $value->url = url('/shop_item/detail/'.$value->hashid);
            $value->imgUrl = asset('upload/'.$value->img);
            $row = \Cart::search(['id'=>$value->id]);
            $row = $row->first();
            $value->rows = $row??'';
            return $value;
        });
        $returnData = [
            'catalogs' => $catalogs,
            'shopItem' => $shopItem,
            'subCatalogs'=>$catalogs->first()->attr,
            'cart'=>collect(['cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()])
        ];

        if(!empty($request['is_api'])) return $returnData;
        return view('good_list',$returnData);
    }

    /**
     * ajax 请求获取下级栏目分类
     * @param Request $request
     * @return array
     */
    public function ajax_sub_catalog(Request $request){
        if(empty($request['hash_id'])){
            $catalogs = Catalog::all();
        }else{
            $catalog_id = Hashids::decode($request['hash_id']);
            $catalogs = Catalog::where('parent_id','=',$catalog_id)->first();
        }
        $catalogs = $catalogs->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            return $value;
        });
        return ['stat'=>1,'catalogs'=>$catalogs->toJson()];
    }

    /**
     *ajax 请求获取栏目下商品
     * @param Request $request
     * @return array
     */
    public function ajax_shop_item(Request $request){
        $catalog_id = Hashids::decode($request['hash_id']);
        $catalog_ids = Catalog::where('id','=',$catalog_id)->orWhere('parent_id','=',$catalog_id)->select('id')->get();
        $shopItems = ShopItem::whereIn('catalog_id',array_flatten($catalog_ids->toArray()))->where('show','=','1')->orderBy('sort')->get();
        $shopItems = $shopItems->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $value->url = url('/shop_item/detail/'.$value->hashid);
            $value->imgUrl = asset('upload/'.$value->img);
            $row = \Cart::search(['id'=>$value->id]);
            $row = $row->first();
            $value->rows = $row??'';
            return $value;
        });
        return ['stat'=>1,'shopItems'=>$shopItems->toJson()];
    }


}

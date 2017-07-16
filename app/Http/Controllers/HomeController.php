<?php

namespace App\Http\Controllers;

use App\Models\Browse;
use App\Models\Catalog;
use App\Models\Collection;
use App\Models\SecKill;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * 进入详情页
     * @param $hash_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($hash_id){
        $id = Hashids::decode($hash_id);
        $shopItem = ShopItem::where('id','=',$id)->first();
        $shopItem->hashid = Hashids::encode($shopItem->id);
        $secKill = SecKill::where('shop_item_id','=',$shopItem->id)->where('start_time','<',date('Y-m-d h:i:s'))->where('end_time','>',date('Y-m-d h:i:s'))->first();
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
            'secKill'=>$secKill
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
            $value->attr = $value->attr->map(function($attr){
                $attr->url = url('/shop_item/good_list').'?catalog_id='.\Hashids::encode($attr->id);
                return $attr;
            });
            return $value;
        });
        $maxid = 0xffffffff;
        $shopItemQuery = ShopItem::where('id','<',$maxid)->where('show','=','1');
        if($request['search']){
            $shopItemQuery = $shopItemQuery->where('title','like','%'.$request['search'].'%')->where('detail','like','%'.$request['search'].'%');
        }
        if($request['catalog_id']){
            $catalog_id = Hashids::decode($request['catalog_id']);
            $catalog_ids = Catalog::where('id','=',$catalog_id)->orWhere('parent_id','=',$catalog_id)->select('id')->get();
            $shopItemQuery = $shopItemQuery->whereIn('catalog_id',array_flatten($catalog_ids->toArray()));
        }
        if($request['lowestPrice']){
            $shopItemQuery = $shopItemQuery->where('price','>',$request['lowestPrice']);
        }
        if($request['highestPrice']){
            $shopItemQuery = $shopItemQuery->where('price','<',$request['highestPrice']);
        }
        if($request['filterProduction']){
            $shopItemQuery = $shopItemQuery->where('production','=',$request['filterProduction']);
//        }else{
//            $shopItem = ShopItem::all();
        }
        $shopItem = $shopItemQuery->get();
        $shopItem = $shopItem->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $value->url = url('/shop_item/detail/'.$value->hashid);
            $value->imgUrl = asset('upload/'.$value->img);
            $row = \Cart::search(['id'=>$value->id]);
            $row = $row->first();
            $value->rows = $row??'';
            $value->raw_id = $row?$row->__raw_id:'';
            $secKill = SecKill::where('shop_item_id','=',$value->id)->where('start_time','<',date('Y-m-d h:i:s'))->where('end_time','>',date('Y-m-d h:i:s'))->first();
            if(!empty($secKill)) $value->sec_kill_price = $secKill->sec_kill_price;
            return $value;
        });
        $configs = \App\Models\Config::all();
        $search_key = $configs->where('key','search_key')->first();
        $search = [];
        if(!empty($search_key)) $search = explode(',',$search_key->value);
        $returnData = [
            'catalogs' => $catalogs,
            'shopItem' => $shopItem,
            'subCatalogs'=>$catalogs->first()->attr,
            'cart'=>collect(['cart_items'=>\Cart::all(),'cart_count'=>\Cart::count(),'cart_price_count'=>\Cart::totalPrice()]),
            'searches' => collect($search),
            'filter' => collect(['lowestPrice'=>$request['lowestPrice'],'highestPrice'=>$request['highestPrice'],'filterProduction'=>$request['filterProduction']])
        ];
        \Log::debug($shopItem->toArray());

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
            $catalogs = Catalog::where('parent_id','=',$catalog_id)->get();
        }
        if(empty($catalogs->toArray())) return ['stat'=>0,'msg'=>'该栏目无下级栏目'];
        $catalogs = $catalogs->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            return $value;
        });

        return ['stat'=>1,'catalogs'=>$catalogs->toArray()];
    }

    /**
     *ajax 请求获取栏目下商品
     * @param Request $request
     * @return array
     */
    public function ajax_shop_item(Request $request){
        switch ($request['sortType']){
            case 'sell':
                $orderBy = \DB::raw('sellcount_real+sellcount_false');
                $orderType = \DB::raw('desc');
                break;
            case 'priceDesc':
                $orderBy = \DB::raw('price');
                $orderType = \DB::raw('desc');
                break;
            case 'priceAsc':
                $orderBy = \DB::raw('price');
                $orderType = \DB::raw('asc');
                break;
            default:
                $orderBy = \DB::raw('sellcount_real+sellcount_false');
                $orderType = \DB::raw('desc');
                break;
        }
        if(empty($request['hash_id'])){
            $shopItems = ShopItem::where('show','=','1')->orderBy($orderBy,$orderType)->get();
        }else{
            $catalog_id = Hashids::decode($request['hash_id']);
            $catalog_ids = Catalog::where('id','=',$catalog_id)->orWhere('parent_id','=',$catalog_id)->select('id')->get();
            if(empty($catalog_ids)) return ['stat'=>0,'msg'=>'找不到该栏目'];
            $shopItems = ShopItem::whereIn('catalog_id',array_flatten($catalog_ids->toArray()))->where('show','=','1')->orderBy($orderBy,$orderType)->get();
        }
        if(empty($shopItems->toArray())) return ['stat'=>0,'msg'=>'该栏目下无商品'];
        $shopItems = $shopItems->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $value->url = url('/shop_item/detail/'.$value->hashid);
            $value->imgUrl = asset('upload/'.$value->img);
            $row = \Cart::search(['id'=>$value->id]);
            $row = $row->first();
            $value->rows = $row??'';
            $secKill = SecKill::where('shop_item_id','=',$value->id)->where('start_time','<',date('Y-m-d h:i:s'))->where('end_time','>',date('Y-m-d h:i:s'))->first();
            if(!empty($secKill)) $value->sec_kill_price = $secKill->sec_kill_price;
            return $value;
        });
        return ['stat' => '1','shopItems' => $shopItems->toArray()];
    }

    public function imageUpload(Request $request){
        if(!$request->hasFile('image')) return ['stat'=>0,'msg'=>'没有选中上传文件'];
        $path = \Storage::putFile('public/comment', $request->file('image'));
        return ['stat'=>1,'imgUrl'=>\Storage::url($path),'path'=>$path];
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Browse;
use App\Models\Catalog;
use App\Models\Collection;
use App\Models\MobileBrand;
use App\Models\MobileModel;
use App\Models\MobileOrders;
use App\Models\SecKill;
use App\Models\ShopItem;
use App\Models\ThirdUser;
use App\Models\Universities;
use Carbon\Carbon;
use Encore\Admin\Form\Field\Mobile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vinkla\Hashids\Facades\Hashids;
use EasyWeChat\Foundation\Application;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        \Auth::loginUsingId(1);
        return view('welcome');
    }

    public function welcome(){
        return view('home');
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

    /**
     * 获取所有的手机品牌
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mobileBrand(){
        $mobileBrands = MobileBrand::orderBy('sort','asc')->get();
        return view('mobileBrand',['mobileBrands'=>$mobileBrands]);
    }

    /**
     * 根据手机品牌获取手机型号
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mobileModel(Request $request){
        $mobileModels = MobileModel::where('brand_id','=',$request['brand_id'])->orderBy('sort','asc')->get();
        return view('mobileModel',['mobileModels'=>$mobileModels]);
    }

    /**
     * 选择出现的问题
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mobileProblem(Request $request){
        $mobileModel = MobileModel::with('brand')->find($request['model_id']);
        return view('mobileProblem',['mobileModel'=>$mobileModel]);
    }

    /**
     * 手机订单下单确认页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mobileConfirm(Request $request){
        $problem = $request['problem'];
        $mobileModel = MobileModel::with('brand')->find($request['model_id']);
        $universities = Universities::orderBy('sort','asc')->get();
        $js = \EasyWeChat::js();
        return view('mobileConfirm',[
            'problems'=>$problem,
            'mobileModel' => $mobileModel,
            'universities' => $universities,
            'js' => $js
        ]);
    }

    public function mobileAddOrders(Request $request){
        $thirdUser = ThirdUser::find(\Auth::user()->id);
        $mobileModel = MobileModel::with('brand')->find($request['model_id']);
        MobileOrders::create([
            'user_id' => \Auth::user()->id,
            'avatar' => $thirdUser->avatar,
            'realname' => $request['s_user_name'],
            'nick_name' => $thirdUser->nick_name,
            'phone' => $request['s_user_tel'],
            'color' => $request['s_phone_color'],
            'address' => $request['s_user_site'].$request['s_house_number'],
            'university' => $request['s_user_school'],
            'brand' => $mobileModel->brand->brand_name,
            'model' => $mobileModel->model_name,
            'order_time' => $request['s_date'].$request['s_date_time'],
            'problem' => $request['problem'],
            'remark' => $request['s_phone_desc'],
            'stat' => MobileOrders::STAT_ORDER,
            'progress' => date('Y-m-d H:i:s',time()).' '.MobileOrders::STAT_ORDER,
            'type' => 1
        ]);

        return redirect('/user/info');
    }

    /**
     * 电脑订单下单确认页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pcConfirm(){
        $universities = Universities::orderBy('sort','asc')->get();
        $js = \EasyWeChat::js();
        return view('pcConfirm',[
            'universities' => $universities,
            'js' => $js
        ]);
    }

    public function pcAddOrders(Request $request){
        $thirdUser = ThirdUser::find(\Auth::user()->id);
        MobileOrders::create([
            'user_id' => \Auth::user()->id,
            'avatar' => $thirdUser->avatar,
            'realname' => $request['pc_user_name'],
            'nick_name' => $thirdUser->nick_name,
            'phone' => $request['pc_user_tel'],
            'address' => $request['pc_user_site'].$request['pc_house_number'],
            'university' => $request['pc_user_school'],
            'order_time' => $request['pc_date'].$request['pc_date_time'],
            'remark' => $request['pc_desc'],
            'stat' => MobileOrders::STAT_ORDER,
            'progress' => date('Y-m-d H:i:s',time()).' '.MobileOrders::STAT_ORDER,
            'type' => 2
        ]);

        return redirect('/user/info');
    }

    /**
     * ajax 根据经纬度获取当前位置信息
     * @param Request $request
     * @return mixed
     */
    public function ajaxGetGeocoder(Request $request){
        $txMapKey = env('TX_MAP_KEY','WDQBZ-G5R36-RD3S4-MVWML-SBGB6-4WBGQ');
        $ch = curl_init();
        $url = "http://apis.map.qq.com/ws/geocoder/v1/?location=$request[latitude],$request[longitude]&key=$txMapKey&get_poi=0";
        \Log::debug("http://apis.map.qq.com/ws/geocoder/v1/?location=$request[latitude],$request[longitude]&key=$txMapKey&get_poi=0");
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        $result = json_decode($res);
        if($result->status > 0){
            return $result->message;
        }else{
            return $result->result->formatted_addresses->recommend;
        }
    }


}

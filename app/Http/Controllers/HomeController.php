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
        return view('detail',[
            'item' => $shopItem,
        ]);
    }


    public function good_list(){
        $catalogs = Catalog::where('parent_id','=','0')->get();
        $catalogs = $catalogs->map(function($value){
            $value->hashid = \Hashids::encode($value->id);
            $value->attr = Catalog::where('parent_id','=',$value->id)->get();
            return $value;
        });
        return view('good_list',[
            'catalogs' => $catalogs
        ]);
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

<?php

namespace App\Http\Controllers;

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

    public function detail($has_id){
        $id = Hashids::decode($has_id);
        $shopItem = ShopItem::where('id','=',$id)->first();
        return view('detail',[
            'item' => $shopItem
        ]);
    }
}

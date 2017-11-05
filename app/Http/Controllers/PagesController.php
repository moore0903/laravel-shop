<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/5
 * Time: 10:49
 */

namespace App\Http\Controllers;


use App\Models\Catalog;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 获取企业文化下单页
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCulture($id = 0){
        $catalog = Catalog::where('title','企业文化')->first();
        if($id == 0){
            $page = $catalog->page()->orderBy('created_at','desc')->first();
        }else{
            $page = Page::find($id);
        }
        return view('culture',['info'=>$page,'pages'=>$catalog->page]);
    }
}
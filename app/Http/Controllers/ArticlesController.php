<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/3/9
 * Time: 17:33
 */

namespace App\Http\Controllers;


use App\Models\Article;
use App\Models\Catalog;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{

    public function getMarket($catalog_id = 0){
        if(empty($catalog_id)){
            $marketCatalog = Catalog::where('title','采暖市场')->first();
            $catalog = Catalog::where('parent_id',$marketCatalog->id)->orderBy('order','desc')->first();
            $catalog_id = $catalog->id;
        }else{
            $catalog = Catalog::find($catalog_id);
        }
        $articles = Article::where('catalog_id',$catalog_id)->orderBy('sort','desc')->paginate(6);
        return view('market',[
            'articles' => $articles,
            'catalogs' => Catalog::where('parent_id',$catalog->parent_id)->orderBy('order','desc')->get(),
            'catalog' => $catalog
        ]);
    }

    public function getMarketDetail($id){
        $article = Article::find($id);
        $catalogs = Catalog::where('parent_id',$article->catalog->parent_id)->orderBy('order','desc')->get();
        return view('marketDetail',[
            'info' => $article,
            'catalogs' => $catalogs,
            'catalog' => $article->catalog
        ]);
    }
}
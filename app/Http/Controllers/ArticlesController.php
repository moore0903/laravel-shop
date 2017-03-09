<?php
/**
 * Created by PhpStorm.
 * User: hg
 * Date: 2017/3/9
 * Time: 17:33
 */

namespace App\Http\Controllers;


use App\Models\Article;

class ArticlesController extends Controller
{
    public function detail($id){
        \Log::debug(Article::find($id));
        return '123';
    }
}
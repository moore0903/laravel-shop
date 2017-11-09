<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Browse;
use App\Models\Cases;
use App\Models\Catalog;
use App\Models\Collection;
use App\Models\Messages;
use App\Models\Page;
use App\Models\SecKill;
use App\Models\ShopItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Mews\Captcha\Captcha;
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
        return view('home');
    }

    /**获取栏目主页
     * @param $catalog_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalog($catalog_id){
        $catalog = Catalog::find($catalog_id);
        if(empty($catalog->parent_id)){
            $catalog_set = Catalog::where('parent_id',$catalog_id)->orderBy('order','desc')->get();
            $top_catalog = $catalog;
            $top_catalog_id = $catalog_id;
            $catalog_id = $catalog_set->first()->id;
        }else{
            $catalog_set = Catalog::where('parent_id',$catalog->parent_id)->orderBy('order','desc')->get();
            $top_catalog = Catalog::find($catalog->parent_id);
            $top_catalog_id = $catalog->parent_id;
        }
        if($catalog->type == 1){  //单页
            $catalog = Catalog::find($catalog_id);
            return view('page',[
                'info' => $catalog,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }elseif($catalog->type == 2){  //案例
            $list = Cases::where('catalog_id',$catalog_id)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->paginate(6);
            return view('case',[
                'list' => $list,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);

        }elseif($catalog->type == 3){  //新闻
            $list = Article::where('catalog_id',$catalog_id)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->paginate(6);
            return view('article',[
                'list' => $list,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }elseif($catalog->type == 4){  //图片集合
            $catalog = Catalog::find($catalog_id);
            return view('image_set',[
                'info' => $catalog,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }

    }

    /**
     * 获取案例详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function caseDetail($id){
        $case = Cases::find($id);
        $catalog_set = Catalog::where('parent_id',$case->catalog->parent_id)->orderBy('order','desc')->get();
        $top_catalog = Catalog::find($case->catalog->parent_id);
        return view('caseDetail',[
            'info' => $case,
            'catalog_set' => $catalog_set,
            'catalog' => $case->catalog,
            'top_catalog' => $top_catalog,
            'set_nev' => Catalog::$set_nev[$top_catalog->id]
        ]);
    }

    /**
     * 获取文章详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function articleDetail($id){
        $article = Article::find($id);
        $catalog_set = Catalog::where('parent_id',$article->catalog->parent_id)->orderBy('order','desc')->get();
        $top_catalog = Catalog::find($article->catalog->parent_id);
        return view('articleDetail',[
            'info' => $article,
            'catalog_set' => $catalog_set,
            'catalog' => $article->catalog,
            'top_catalog' => $top_catalog,
            'set_nev' => Catalog::$set_nev[$top_catalog->id]
        ]);
    }

    /**
     * 留言
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message(){
        $catalog_id = 29;
        $catalog = Catalog::find($catalog_id);
        $catalog_set = Catalog::where('parent_id',$catalog_id)->orderBy('order','desc')->get();
        $top_catalog = $catalog;
        $top_catalog_id = $catalog_id;
        return view('message',[
            'catalog' => $catalog,
            'catalog_set' => $catalog_set,
            'top_catalog' => $top_catalog,
            'set_nev' => Catalog::$set_nev[$top_catalog_id],
            'src' => captcha_src()
        ]);
    }

    /**
     * 提交留言
     * @param Request $request
     * @return array
     */
    public function message_submit_ajax(Request $request){
        $rules = [
            'captcha' => 'required|captcha'
        ];
        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return ['status'=>'n','info'=>'验证码不正确'];
        }
        Messages::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'area' => $request->area,
            'content' => $request->contents,
            'ip' => $request->ip(),
        ]);
        return ['status'=>'y','info'=>'提交成功'];

    }

    /**
     * 刷新验证码
     * @return array
     */
    public function captcha_re(){
        return ['src'=>captcha_src()];
    }


    public function product(){

    }


    public function imageUpload(Request $request){
        if(!$request->hasFile('image')) return ['stat'=>0,'msg'=>'没有选中上传文件'];
        $path = \Storage::putFile('public/comment', $request->file('image'));
        return ['stat'=>1,'imgUrl'=>\Storage::url($path),'path'=>$path];
    }


}

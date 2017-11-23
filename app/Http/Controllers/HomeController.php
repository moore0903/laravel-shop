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
use App\User;
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
        return view('home',[
            'banners' => Article::where('catalog_id',35)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'case_recommend' => Cases::where('recommend','1')->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->limit(5)->get(),
            'article_hot' => Article::where('hot','1')->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->first(),
            'article_recommend' => Article::where('recommend','1')->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->limit(3)->get()
        ]);
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
        if($catalog->id == 20 || $catalog->parent_id == 20){
            if($catalog->id == 20){
                $list = $catalog->subCataShopitem()->orderByDesc('sort')->orderByDesc('created_at')->paginate(9);
            }else{
                $list = ShopItem::where('catalog_id',$catalog_id)->orderByDesc('sort')->orderByDesc('created_at')->paginate(9);
            }
            $catalog = Catalog::find(20);
            $catalog_set = Catalog::where('parent_id',$catalog->parent_id)->orderBy('order','desc')->get();
            $top_catalog = Catalog::find($catalog->parent_id);
            $top_catalog_id = $catalog->parent_id;
            return view('product_list',[
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
                'list' => $list,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id],
                'three_catalog' => $catalog->subCata,
                'three_catalog_id' => $catalog_id
            ]);
        }
        if($catalog->type == 1){  //单页
            $catalog = Catalog::find($catalog_id);
            return view('page',[
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
                'info' => $catalog,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }elseif($catalog->type == 2){  //案例
            $list = Cases::where('catalog_id',$catalog_id)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->paginate(9);
            return view('case',[
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
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
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
                'list' => $list,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }elseif($catalog->type == 4){  //图片集合
            $catalog = Catalog::find($catalog_id);
            return view('image_set',[
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
                'info' => $catalog,
                'catalog' => $catalog,
                'catalog_set' => $catalog_set,
                'top_catalog' => $top_catalog,
                'set_nev' => Catalog::$set_nev[$top_catalog_id]
            ]);
        }elseif($catalog->type == 5){  //产品
            if(!\Auth::check()){
                return \Redirect::to('/');
            }
            $list = ShopItem::where('catalog_id',$catalog_id)->orderByDesc('sort')->orderByDesc('created_at')->paginate(9);
            return view('product',[
                'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                    ->orderBy('created_at','desc')->get(),
                'list' => $list,
                'user' => \Auth::user()
            ]);
        }elseif($catalog->type == 6){  //公告

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
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
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
        $article->increment('browse');
        return view('articleDetail',[
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'info' => $article,
            'catalog_set' => $catalog_set,
            'catalog' => $article->catalog,
            'top_catalog' => $top_catalog,
            'set_nev' => Catalog::$set_nev[$top_catalog->id]
        ]);
    }

    public function productDetail($id){
        if(!\Auth::check()){
            return \Redirect::to('/');
        }
        $product = ShopItem::find($id);
        return view('productDetail',[
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'info' => $product,
            'catalog' => $product->catalog,
            'user' => \Auth::user()
        ]);
    }

    public function notice(){
        $catalog_id = 36;
        if(!\Auth::check()){
            return \Redirect::to('/');
        }
        $list = Article::where('catalog_id',$catalog_id)->where('is_display',1)->orderBy('sort','desc')
            ->orderBy('created_at','desc')->paginate(6);
        return view('notice',[
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'list' => $list
        ]);
    }

    public function noticeDetail($id){
        if(!\Auth::check()){
            return \Redirect::to('/');
        }
        $article = Article::find($id);
        return view('noticeDetail',[
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'info' => $article,
            'catalog' => $article->catalog,
            'user' => \Auth::user()
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
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
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


    public function productSearch(Request $request){
        if(!\Auth::check()){
            return \Redirect::to('/');
        }
        $search_title = $request->search_title;
        $catalog_ids = Catalog::subCatalogIds(32);
        if($search_title){
            $list = ShopItem::where('title','like','%'.$search_title.'%')->whereIn('catalog_id',$catalog_ids)->orderByDesc('sort')->orderByDesc('created_at')->paginate(9);
        }else{
            $list = ShopItem::whereIn('catalog_id',$catalog_ids)->orderByDesc('sort')->orderByDesc('created_at')->paginate(9);
        }
        return view('product',[
            'banners' => Article::where('catalog_id',37)->where('is_display',1)->orderBy('sort','desc')
                ->orderBy('created_at','desc')->get(),
            'list' => $list,
            'user' => \Auth::user()
        ]);
    }

    public function resetPassword(Request $request){
        if($request->method() == 'GET'){
            return view('reset_password');
        }else{
            $user = User::find($request->user()->id);
            if(!password_verify($request->old_password, $user->getAuthPassword())){
                return ['status'=>'n','info'=>'旧密码不正确'];
            }
            if($request->new_password != $request->confirm_password){
                return ['status'=>'n','info'=>'新密码不一致'];
            }
            $password = password_hash($request->confirm_password, PASSWORD_DEFAULT);
//            \Auth::logout();
            \Session::flush();
            \DB::table('users')->where('name',$user->name)->update(['password'=>$password]);
            return ['status'=>'y','info'=>'密码修改成功,请重新登录'];
        }
    }


    public function logout(){
//        \Auth::logout();
        \Session::flush();
        return \Redirect::to('/');
    }




    public function imageUpload(Request $request){
        if(!$request->hasFile('image')) return ['stat'=>0,'msg'=>'没有选中上传文件'];
        $path = \Storage::putFile('public/comment', $request->file('image'));
        return ['stat'=>1,'imgUrl'=>\Storage::url($path),'path'=>$path];
    }


}

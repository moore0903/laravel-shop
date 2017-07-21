<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $table = 'shop_item';

    protected $fillable = [
        'title', 'catalog_id', 'count','price','img','short_title','show','detail','sort',
        'images','shipping','original_price','units','unit_number','recommend','sellcount_real','sellcount_false',
        'production'
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'catalog_id');
    }

    /**
     * 收藏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(User::class,'collection','shop_item_id','user_id');
    }

    /**
     * 评论
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments(){
        return $this->belongsToMany(User::class,'comment','shop_item_id','user_id')->withPivot('content','images','star','created_at');
    }

    /**
     * 访问记录
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function browses()
    {
        return $this->belongsToMany(User::class,'browse','shop_item_id','user_id');
    }

    public function setImagesAttribute($images)
    {
        if (is_array($images)) {
            $this->attributes['images'] = json_encode($images);
        }
    }

    public function getImagesAttribute($images)
    {
        return json_decode($images, true);
    }

    /**
     * 查询商品分类
     * @param int $catalog_id 栏目ID
     * @param bool $recommend 是否推荐
     * @param bool $is_page 是否分页
     * @param int $page 每页多少条
     * @return mixed
     */
    public static function shopItemList($catalog_id=0,$recommend=false,$is_page=false,$page=15){
        $shopItemQuery = ShopItem::where('show','=',true);

        //根据栏目ID查询
        if(!empty($catalog_id)){
            $shopItemQuery = $shopItemQuery->where('catalog_id','=',$catalog_id);
        }

        // 是否推荐
        if($recommend === true){
            $shopItemQuery = $shopItemQuery->where('recommend','=',true);
        }elseif($recommend === false){
            $shopItemQuery = $shopItemQuery->where('recommend','=',false);
        }

        //是否分页及一页多少条
        if($is_page === false){
            $shopItemList = $shopItemQuery->take($page)->get();
        }else{
            $shopItemList = $shopItemQuery->paginate($page);
        }

        return $shopItemList;
    }

    public static function sellCountOrder($page=15){
        return ShopItem::where('show','=',1)->orderBy(\DB::raw('sellcount_real+sellcount_false'),\DB::raw('desc'))->take($page)->get();
    }

    public static function like($page=15){
        if(\Auth::check()){
            $browse_ids = Browse::where('user_id','=',\Auth::user()->id)->inRandomOrder()->take($page)->select('shop_item_id')->get();
            $catalog_ids = ShopItem::whereIn('id',$browse_ids->toArray())->select('catalog_id')->get();
            return ShopItem::whereIn('catalog_id',$catalog_ids->toArray())->distinct()->inRandomOrder()->take($page)->get();
        }else{
            return ShopItem::distinct()->inRandomOrder()->take($page)->get();
        }
    }

    public static function getUnitsById($id){
        return ShopItem::find($id)->units;
    }

    public static $units = [
        '瓶'=>'瓶',
        '箱'=>'箱',
        '件'=>'件',
        '克'=>'克',
        '斤'=>'斤',
        '个'=>'个',
    ];

    public static $productions = [
        '未知' => '未知',
        '法国' => '法国',
        '俄罗斯' => '俄罗斯',
        '波尔多' => '波尔多',
    ];
}

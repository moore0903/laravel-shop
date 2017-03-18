<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $table = 'shop_item';

    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'catalog_id');
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
     * @param string $recommend 是否推荐
     * @param bool $is_page 是否分页
     * @param int $page 每页多少条
     * @return mixed
     */
    public static function shopItemList($catalog_id=0,$recommend='all',$is_page=false,$page=15){
        
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
            $shopItemList = $shopItemQuery->get($page);
        }else{
            $shopItemList = $shopItemQuery->paginate($page);
        }

        return $shopItemList;
    }

    public static $units = [
        '克'=>'克',
        '斤'=>'斤',
        '个'=>'个',
        '箱'=>'箱',
        '件'=>'件',
    ];
}

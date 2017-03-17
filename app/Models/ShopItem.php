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

    public static function shopItemList($catalog_id=0){
        if(!$catalog_id){
            return ShopItem::paginate(15);
        }else{
            return ShopItem::where('catalog_id','=',$catalog_id)->paginate(15);
        }
    }
}

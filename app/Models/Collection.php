<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';

    protected $fillable = [
        'user_id', 'shop_item_id'
    ];

    public function shopItem() {
        return $this->belongsTo(ShopItem::class,'shop_item_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 根据商品ID查询出当前商品收藏的条数
     * @param $shop_item_id
     * @return mixed
     */
    public static function shopItemCollectionCount($shop_item_id){
        return Collection::where('shop_item_id','=',$shop_item_id)->count();
    }
}

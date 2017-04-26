<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = [
        'user_id', 'shop_item_id', 'content','images','star'
    ];

    public function shopItem() {
        return $this->belongsTo(ShopItem::class,'shop_item_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 根据商品ID获取当前商品的评论总数
     * @param $shop_item_id
     * @return mixed
     */
    public static function shopItemCommentCount($shop_item_id){
        return Comment::where('shop_item_id','=',$shop_item_id)->count();
    }
}

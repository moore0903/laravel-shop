<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    protected $fillable = [
        'user_id', 'shop_item_id', 'content','images','star','order_id','order_detail_id'
    ];

    public function shopItem() {
        return $this->belongsTo(ShopItem::class,'shop_item_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function detail()
    {
        return $this->belongsTo(OrderDetail::class,'order_detail_id');
    }

    /**
     * 根据商品ID获取当前商品的评论总数
     * @param $shop_item_id
     * @return mixed
     */
    public static function shopItemCommentCount($shop_item_id){
        return Comment::where('shop_item_id','=',$shop_item_id)->count();
    }

    /**
     * 获取是否有评论内容
     * @param $user_id
     * @param $shop_item_id
     * @param $order_id
     * @param $order_detail_id
     * @return mixed
     */
    public static function getCommentCountByOrderDetail($user_id,$shop_item_id,$order_id,$order_detail_id){
        return Comment::where('user_id','=',$user_id)->where('shop_item_id','=',$shop_item_id)->where('order_id','=',$order_id)->where('order_detail_id','=',$order_detail_id)->count();
    }
}

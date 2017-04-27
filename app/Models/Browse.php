<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\New_;

class Browse extends Model
{
    protected $table = 'browse';

    protected $fillable = [
        'user_id', 'shop_item_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function shopItem() {
        return $this->belongsTo(ShopItem::class,'shop_item_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * 记录用户的访问足迹
     * @param $user_id
     * @param $shopItem_id
     */
    public static function recording($user_id,$shopItem_id){
        $browse_list = Browse::where('user_id','=',$user_id)->orderBy('id','desc')->get();
        $is_existence = $browse_list->contains('shop_item_id',$shopItem_id);
        if(!$is_existence){
            if($browse_list->count() >= 10){
                $pop_id = $browse_list->pop();
                Browse::where('id','=',$pop_id->id)->delete();
            }
            $browse = new Browse;
            $browse->user_id = $user_id;
            $browse->shop_item_id = $shopItem_id;
            $browse->save();
        }

    }
}

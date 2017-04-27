<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Browse extends Model
{
    protected $table = 'collection';

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

    public static function recording($user_id,$shopItem_id){
        $browse_list = Browse::where('user_id','=',$user_id)->selct('id');
        if($browse_list->count() > 10){
            
        }
    }
}

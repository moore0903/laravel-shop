<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecKill extends Model
{
    protected $table = 'sec_kill';

    protected $fillable = [
        'shop_item_id', 'start_time','end_time','sec_kill_price'
    ];

    public function shopItem() {
        return $this->belongsTo(ShopItem::class,'shop_item_id');
    }
}

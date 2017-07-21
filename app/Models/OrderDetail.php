<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'shop_item_id', 'product_title','product_num','thumbnail','product_price','shop_item_catalog','units'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}

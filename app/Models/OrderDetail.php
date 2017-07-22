<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id', 'shop_item_id', 'product_title','product_num','thumbnail','product_price','shop_item_catalog','units'
    ];

    /**
     * 后置任务
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $old_order_detail = OrderDetail::find($model->id);
            if($old_order_detail){
                $order = Order::with('details')->find($old_order_detail->order_id);
                $totalpay = 0;
                foreach($order->details as $detail){
                    $totalpay += $detail->product_num * $detail->product_price;
                }
                $order->totalpay = $totalpay;
                $order->save();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileModel extends Model
{
    protected $table = 'mobile_model';

    protected $fillable = [
        'brand_id', 'model_name', 'sort'
    ];

    public function brand()
    {
        return $this->belongsTo(MobileBrand::class,'brand_id');
    }

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            return redirect('admin/model'.'?brand_id='.$model->brand_id);
        });
    }
}

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

    public static $problems = [
        '外屏损坏',
        '屏幕总成损坏',
        '电池问题',
        '前摄像头问题',
        '后摄像头问题',
        '充电口损坏',
        '听筒无声音',
        '麦克风损坏',
        'home键失灵',
        '扬声器损坏',
        '软件问题',
        '其它故障'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileBrand extends Model
{
    protected $table = 'mobile_brand';

    protected $fillable = [
        'brand_name', 'sort'
    ];

    public function model()
    {
        return $this->hasMany(MobileModel::class, 'brand_id');
    }

}

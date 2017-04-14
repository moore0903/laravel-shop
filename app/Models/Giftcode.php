<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Giftcode extends Model
{
    protected $table = 'giftcodes';

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            for ($i = 0; $i < $model->codecount - 1; $i++) {
                Giftcode::insert([
                    'title' => $model->title,
                    'code' => Str::upper(Str::random(10)),
                    'discountn' => $model->discountn,
                    'discountnlimit' => $model->discountnlimit,
                    'usecountmax' => $model->usecountmax,
                    'codecount' => 1,
                    'usecount' => 0,
                    'start_time' => $model->start_time,
                    'end_time' => $model->end_time,
                    'net' => $model->net??url('/'),
                ]);
            }
            $model->code = Str::upper(Str::random(10));
            $model->net = $model->net??url('/');
            $model->codecount = 1;
            $model->usecountmax = 1;
        });
    }
}

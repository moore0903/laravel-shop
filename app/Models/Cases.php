<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cases extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'title', 'content', 'img','author','browse','is_display','catalog_id','sort'
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'catalog_id');
    }

    public function setOptionsAttribute($options)
    {
        if (is_array($options)) {
            $this->attributes['options'] = join(',', $options);
        }
    }

    public function getOptionsAttribute($options)
    {
        if (is_string($options)) {
            return explode(',', $options);
        }

        return $options;
    }




}

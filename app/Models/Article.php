<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title', 'content', 'img','author','browse','hot','new','recommend','content_tpl','is_display','catalog_id'
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

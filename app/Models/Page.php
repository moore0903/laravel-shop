<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{

    protected $table = 'pages';

    protected $fillable = [
        'title', 'content', 'catalog_id','en_title'
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class,'catalog_id');
    }

    
}

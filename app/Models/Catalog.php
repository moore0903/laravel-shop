<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;


class Catalog extends Model
{
    use ModelTree, AdminBuilder;

    protected $table = 'catalogs';

    public function article()
    {
        return $this->hasMany(Article::class,'catalog_id');
    }

    public function shopitem()
    {
        return $this->hasMany(ShopItem::class,'catalog_id');
    }

    /**
     * 读取活动的模板文件
     * @return array
     */
    static public function dirToArray() {
        $result = array();
        $cdir = scandir(resource_path("views/theme/"));
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                $filename = explode('.',$value);
                $result['theme/'.$filename[0]] = $value;
            }
        }
        return $result;
    }
    

    
}

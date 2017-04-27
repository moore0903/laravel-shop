<?php

namespace App;

use App\Models\ShopItem;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','headimage','sex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 收藏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(ShopItem::class,'collection','user_id','shop_item_id');
    }

    /**
     * 评论
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function comments(){
        return $this->belongsToMany(ShopItem::class,'comment','user_id','shop_item_id')->withPivot('content','images','star','created_at');;
    }

    /**
     * 收藏
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function browses()
    {
        return $this->belongsToMany(ShopItem::class,'browse','user_id','shop_item_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $table = 'sell';
    protected $primaryKey = 'id_sell';
    protected $guarded = [];

    public function member()
    {
        return $this->hasOne(Member::class, 'id_member', 'id_member');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function detail(){
        return $this->hasMany(SellDetail::class,'id_sell','id_sell');
    }
    // public function products(){
    //     return $this->hasManyThrough(Product::class,SellDetail::class,'id_product','id_product','id','id_product');
    // }
}

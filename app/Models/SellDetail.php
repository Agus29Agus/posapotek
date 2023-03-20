<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellDetail extends Model
{
    use HasFactory;

    protected $table = 'sell_detail';
    protected $primaryKey = 'id_sell_detail';
    protected $guarded = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id_product', 'id_product');
    }
}

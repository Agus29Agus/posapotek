<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'category';
    protected $guarded = [];
    protected $primaryKey = 'id_category';
    use HasFactory, SoftDeletes;
}

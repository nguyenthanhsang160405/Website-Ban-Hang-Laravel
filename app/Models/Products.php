<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryProduct;
use App\Models\Size;


class Products extends Model
{
    /** @use HasFactory<\Database\Factories\ProductsFactory> */
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'category_id'
    ];
    public function categories(){
        return $this->belongsTo(CategoryProduct::class,'category_id');
    }
    public function sizes(){
        return $this->hasMany(Size::class,'product_id');
    }
}

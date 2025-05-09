<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class CategoryProduct extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryProductFactory> */
    use HasFactory;
    protected $table = 'category_products';
    protected $fillable = ['name'];
    public function products(){
        return $this->hasMany(Products::class,'category_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Models\Color;

class Size extends Model
{
    /** @use HasFactory<\Database\Factories\SizeFactory> */
    use HasFactory;
    protected $table = 'sizes';
    protected $fillable = ['ten_size','product_id'];

    public function products(){
        return $this->belongsTo(Products::class);
    }
    public function colors(){
        return $this->hasMany(Color::class,'size_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory,SoftDeletes;
    // use SoftDeletes;
    protected $table = 'products';

    // protected $primaryKey = 'id';
    // public $incrementing = true;

    // protected $atributes = [
    //     'name' => 'default',
    //     'image' => 'default',
    //     'price' => 0,
    //     'describe' => 'default',
    // ];
    protected $fillable = [
        'name',
        'image',
        'price',
        'quantity',
        'size',
        'describe',
        'category_id'
    ];

    protected $attributes = [
        'special_id' => 1,
    ];
    protected static function boot()
    {
        parent::boot();
        static::updating(function ($product){
            Cart::where('product_id','=',$product->id)
            ->update([
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
            ]);
            DetaiOrder::where('product_id','=',$product->id)
            ->update([
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
            ]);
        });
    }
    
    public function category(){

        return $this->belongsTo(CategoryProduct::class,'category_id');

    }

    public function comment(){

        return $this->hasMany(Comment::class,'product_id');

    }




    // public function size(){

    //     return $this->hasMany();

    // }
    
    


    
}

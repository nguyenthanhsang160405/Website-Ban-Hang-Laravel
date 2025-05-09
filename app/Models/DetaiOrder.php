<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class DetaiOrder extends Model
{
    /** @use HasFactory<\Database\Factories\DetaiOrderFactory> */
    use HasFactory;
    protected $table = 'detai_orders';

    protected  $fillable = ['name','image','price','quantity','size','order_id','product_id'];

    public function orders(){
        return $this->belongsTo(Order::class,'order_id');
    }
}

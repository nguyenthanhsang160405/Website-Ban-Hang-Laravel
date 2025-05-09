<?php

namespace App\Models;

use App\Models\User;
use App\Models\DetaiOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'total_order',
        'status_order',
        'status_payments',
        'user_id',
        'method_payment_id',
        'paypal_transaction_id',
        'paypal_response',
        'transaction_id',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function detaiOrders(){
        return $this->hasMany(DetaiOrder::class,'order_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodPayment extends Model
{
    /** @use HasFactory<\Database\Factories\MethodPaymentFactory> */
    use HasFactory;
    protected $table = 'method_payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'describe'
    ];
}

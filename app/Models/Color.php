<?php

namespace App\Models;
use App\Models\Size;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    /** @use HasFactory<\Database\Factories\ColorFactory> */
    use HasFactory;

    protected $table = 'colors';
    protected $fillable = ['ten','ma_mau','quantity','size_id'];

    public function colors(){
        return $this->belongsTo(Size::class,'size_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'food';	//Định nghĩa tên bảng
    protected $primaryKey = 'id';	//Chỉ định khóa chính
    public $timestamps = false; 	//Bật/tắt created_at & updated_at
    protected $fillable = ['name','email','password'];	//Cho phép gán dữ liệu hàng loạt vào các cột cụ thể
    // protected $guarded;	//Chặn gán dữ liệu hàng loạt vào các cột cụ thể
    // protected $hidden;//Ẩn cột khi trả về JSON
    // protected $visible;	//Chỉ hiển thị các cột cụ thể khi trả về JSON
    // protected $casts;	//Ép kiểu dữ liệu khi lấy từ database
    // protected $appends;	//Thêm thuộc tính ảo (không có trong database)
    // protected $connection;	//Chỉ định database connection
    // protected $dateFormat = 'h:m:s';	//Định dạng ngày tháng

    
}

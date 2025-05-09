<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        for($i = 0 ; $i < 5 ; $i++){
            DB::table('category_products')->insert(
                ['name'=>'Danh mục' .$i],
            );
        }
        for($i = 0 ; $i < 20 ; $i++){
            DB::table('products')->insert(
                ['name'=>'Sản phẩm ' .$i, 'price' => rand(100000,500000),'category_id' => rand(1,4)],
            );
        }

        $products = DB::table('products')->get();
        foreach($products as $index => $product){
            DB::table('sizes')->insert([
                ['ten_size'=>'Size 1 của sản phẩm ' . $product->name, 'product_id' => $product->id ],
                ['ten_size'=>'Sản 2 của sản phẩm' . $product->name,'product_id' => $product->id],
            ]);
        }

        $sizes = DB::table('sizes')->get();
        foreach($sizes as $index => $size){
            DB::table('colors')->insert([
                ['ten'=>'Màu 1 của size ' . $size->ten_size,'ma_mau' => '#123456' ,'quantity' => rand(1,20), 'size_id' => $size->id ],
                ['ten'=>'Màu 2 của size' . $size->ten_size, 'ma_mau' => '#123456', 'quantity' => rand(1,20) , 'size_id' => $size->id],
            ]);
        }
    }
}

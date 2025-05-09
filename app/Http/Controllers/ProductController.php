<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    
    // public function index(){
    //     print_r(route('products'));
    //     $name = "Sang";
    //     $name2 = "Sang2";
    //     return view('products.product',compact('name','name2'));
    // }
    // public function showProduct(){
    //     $product = [
    //         'name' => 'Iphone 12',
    //         'price' => 1200,
    //         'description' => 'New product from Apple'
    //     ];
    //     $sang = 'Sang';
    //     return view('products.detail_product',['product'=>$product,'sang2'=>$sang]);
    // }
    // public function getIdPro($name,$id){
        
    //    return 'Name: '.$name.' Product ID: '.$id;
       
    // }
    public function getDetailProduct($id){
        $product = Products::with([ 
            [
                'categories',
                'sizes',
                'colors'
            ]
        ])->find($id);


    }
}

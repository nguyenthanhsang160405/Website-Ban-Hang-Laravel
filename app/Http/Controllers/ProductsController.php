<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $product = Products::with([
            'categories',
            'sizes',
            'sizes.colors',
        ])->find($id);


        // $product = Products::with([
        //     'categories',
        //     'sizes' => function ($size) {
        //         $size->where('id',2)->with([
        //             'colors' => function ($colors) {
        //                 $colors->where('id', 3);
        //             }
        //         ]);
        //     },
        //     'sizes.colors' => function ($colors) {

        //     }
        // ])->find($id);


        // dd($product);
        $data = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => $product->price,
            "categories" => $product->categories,
            "size" => [],
        ];
        $sizes = $product->sizes;

        $sizeAndQuantity = [];

        foreach ($sizes as $size) {
            $sizeArr = ["size_name" => $size->ten_size];
            $colors = $size->colors;
            // dd($colors);
            foreach($colors as $color){
                
                $sizeArr["color"][] = ["name_color" => $color->ten , "ma_mau" => $color->ma_mau, "so_luong" => $color->quantity];
                
            }

            $sizeAndQuantity[] = $sizeArr;

        }
        $data['size'] = $sizeAndQuantity;

        return response()->json($data,200);
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}

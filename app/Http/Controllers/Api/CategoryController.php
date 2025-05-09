<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = CategoryProduct::with([
            'products'
        ])->get();

        $response =  [
            "status" => true,
            "message" => "Lấy dữ liệu thành công",
            "data" => $category,
        ];
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
        ],
        [
            'title.required' => 'Tiêu đề không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Lỗi dữ liệu",
                "data" => $validator->errors(),
            ], 400);
        }

        $category = CategoryProduct::create([
            'title' => $request->title,
            'describe' => $request->describe,
         ]);

         return response()->json([
            "status" => true,
            "message" => "Thêm danh mục thành công",
            "data" => $category,
        ], 400); 


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //


        $category = CategoryProduct::with([
            'products', 
        ])->find($id);

        if(!$category){
            return response()->json([
                "status" => false,
                "message" => "Danh mục không tồn tại",
            ], 404);     
        }

        $response =  [
            "status" => true,
            "message" => "Lấy dữ liệu thành công",
            "data" => $category,
        ];

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
        ],
        [
            'title.required' => 'Tiêu đề không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Lỗi dữ liệu",
                "data" => $validator->errors(),
            ], 400);
        }

        $category = CategoryProduct::find($id);

        if(!$category){
            return response()->json([
                "status" => false,
                "message" => "Danh mục không tồn tại",
            ], 404);
        }

        $category->update([
            'title' => $request->title,
            'describe' => $request->describe,
        ]);

        $response =  [
            "status" => true,
            "message" => "Cập nhật sản phẩm thành công",
            "data" => $category,
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = CategoryProduct::with([
            'products', 
        ])->find($id);

        if(!$category){
            return response()->json([
                "status" => false,
                "message" => "Danh mục không tồn tại",
            ], 404);     
        }

        $category->delete();

        $response =  [
            "status" => true,
            "message" => "Xóa dữ liệu thành công",
        ];

        return response()->json($response);
    }
}

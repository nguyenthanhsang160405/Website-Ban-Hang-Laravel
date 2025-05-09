<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $product = Product::with([
            'category'
        ])->get()
        ->map(function($product){
            return [
                'product' => $product,
                'category' => $product->category->title
            ];
        });

        if($product->isEmpty()){
            return response()->json([
               'success' => false,
               'message' => 'Không tìm thấy sản phẩm nào',
                'data' => $product,
               
            ],404,[],JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy sản phẩm thành công',
            'data' => $product,
            
        ],200,[],JSON_UNESCAPED_UNICODE); 
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'image' => 'image',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
        ],
        [
            'name.required' => 'Tên sản phẩm không được bỏbỏ trống',
            'image.image' => 'Ảnh phải là file ảnh',
            'price.required' => 'Giá sản phẩm không được bỏ trống',
            'price.integer' => 'Giá sản phẩm phải là số nguyên',
            'quantity.required' => 'Số lượng sản phẩm không được bỏ trống',
            'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'category_id.required' => 'Loại sản phẩm không được bỏ trống',
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => 'Thêm sản phẩm thất bại',
                'errors' => $validator->errors()
            ],422,[],JSON_UNESCAPED_UNICODE);
        }

        if($request->hasFile('image')){
            $fileName = time().'.'. $request->file('image')->getClientOriginalExtension();
            // \Log::info('Ảnh nhận được: ' . $request->file('image')->getClientOriginalName());
            $request->file('image')->storeAs('',$fileName,'public');
        }else{
            $fileName = null;
        }

        $product = Product::create([
            'name' => $request->name,
            'image' => $fileName,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'describe' => $request->describe,
            'category_id' => $request->category_id
        ]);
        

        // Trả về phản hồi JSON
        return response()->json([
            'success' => true,
            'message' => 'Tạo sản phẩm thành công',
            'data' => $product,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $product = Product::with('category')->find($id);

        if(!$product){
            return response()->json([
               'success' => false,
               'message' => 'Không tìm thấy sản phẩm nào',
                'data' => null,
            ],404,[],JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
           'success' => true,
            'message' => 'Lấy sản phẩm thành công',
            'data' => $product,
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'image' => 'image',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
        ],
        [
            'name.required' => 'Tên sản phẩm không được để trống',
            'image.image' => 'Ảnh phải là file ảnh',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.integer' => 'Giá sản phẩm phải là số nguyên',
            'quantity.required' => 'Số lượng sản phẩm không được để trống',
            'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên',
            'category_id.required' => 'Loại sản phẩm không được để trống',
        ]);


        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => 'Lỗi kiểm tra dữ liệu',
               'errors' => $validator->errors()
            ],422,[],JSON_UNESCAPED_UNICODE);
        }

        $product = Product::find($id);

        if(!$product){
            return response()->json([
               'success' => false,
               'message' => 'Không tìm thấy sản phẩm nào',
                'data' => null,
            ],404,[],JSON_UNESCAPED_UNICODE);
        }

        if($request->hasFile('image')){
            $fileName = time(). '.' . $request->file('image')->getClientOriginalExtension(); 
            $request->file('image')->storeAs('',$fileName,'public');
            Storage::disk('public')->delete($product->image);
        }else{
            $fileName = $product->image;
        }

        $product->update([
            'name' => $request->name,
            'image' => $fileName,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'describe' => $request->describe,
            'category_id' => $request->category_id
        ]);
        

        // Trả về phản hồi JSON
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công',
            'data' => $product,
        ], 201);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::with('category')->find($id);

        if(!$product){
            return response()->json([
               'success' => false,
               'message' => 'Không tìm thấy sản phẩm nào',
                'data' => null,
            ],404,[],JSON_UNESCAPED_UNICODE);
        }

        $product->delete();

        return response()->json([
           'success' => true,
            'message' => 'Xóa sản phẩm thành công',
        ],200,[],JSON_UNESCAPED_UNICODE);
    }
}

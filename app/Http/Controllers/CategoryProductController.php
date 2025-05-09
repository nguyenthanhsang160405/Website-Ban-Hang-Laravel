<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPage=1)
    {
        //
        $categoryProducts = CategoryProduct::query()
        
        ->paginate(20,['*'],'page',$idPage);

        $data = [
            'totalPage' => $categoryProducts->lastPage(),
            'categories' => $categoryProducts->reverse()->values(),
            'idPage' => $idPage,
        ];

        return view('admin.listcateproduct', $data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.addcategory');

;    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
        ],[
            'title.required' => 'Tên danh mục không được để trống',
        ]);

        $category = CategoryProduct::create([
            'title' => $request->title,
            'describe' => $request->description,
        ]);

        return redirect('/addcategory')->with('tb','Thêm sản phẩm thành công');

    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryProduct $category)
    {
        //
        $data = [
            'categoryProduct' => $category,
        ];

        return view('admin.editcategory', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryProduct $category)
    {
        //
        $request->validate([
            'title' => 'required',
        ],[
            'title.required' => 'Tên danh mục không được để trống',
        ]);

        $category->update([
            'title' => $request->title,
            'describe' => $request->description,
        ]);

        return redirect('/category/edit/'.$category->id)->with('tb','Sửa danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryProduct $category,$idPage = 1)
    {
        //
        $product = Product::where('category_id',$category->id)->count();

        if($product > 0){

            return redirect('/listcategory/'.$idPage)->with('error','Danh mục còn sản phẩm không thể xóa');

        }

        $category->delete();


        return redirect('/listcategory/'.$idPage)->with('success','Xóa danh mục thành công');
    }
}

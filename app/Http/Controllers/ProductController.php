<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PDOException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // $signedUrl = URL::signedRoute('contact');
        // return redirect($signedUrl);

        $products = Product::all();
        return view('index',['products' => $products]);
        
        
    }

    public function pageProduct(Request $request, $idPage){

        $products = Product::query();

        if($request->has('sort') && !empty($request->input('sort'))){            

            $sort = $request->input('sort');

            switch( $sort ){

                case 'low-high':

                    $products = $products->orderBy('price','asc');
                    break;

                case 'high-low':
                    
                    $products = $products->orderBy('price','desc');
                    break;

                case 'a-z':

                    $products = $products->orderBy('name','asc');
                    break;

                case 'z-a':

                    $products = $products->orderBy('name','desc');
                    break;

            }
        }

        $products = $products->paginate(8,['*'],'page',$idPage);

        return view('products.product',[
            'productInPage' => $products, 
            'numberPage' => $products->lastPage(), 
            'idPage' => $idPage
            ]  
        );   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function pageAdminProducts(Request $request,$idPage = 1){

        if(!Auth::check()){
            
            return redirect('/login');

        }

        $user = Auth::user();

        if(  $user->role !== 'admin' ){

            
            return redirect('/accountUser');

        }

        $products = Product::query();

        if(!empty($request->category_id)){

            $products = $products->where('category_id',$request->category_id);

        }

        if(!empty($request->keyword)){

            $products = $products->where('name','like','%'.$request->keyword.'%');

        }

        if(!empty($request->sort)){
            
            $sort = $request->sort;

            switch($sort){
                case 'name_asc':
                    $products = $products->orderBy('name','asc');
                    break;
                case 'name_desc':
                    $products = $products->orderBy('name','desc');
                    break;
                case 'price_asc':
                    $products = $products->orderBy('price','asc');
                    break;
                case 'price_desc':
                    $products = $products->orderBy('price','desc');
                    break;

            }

        }


        $products = $products->paginate(10,["*"],"trang",$idPage);

        if($idPage > $products->lastPage()){

            return "Trang không tồn tại";

        }

        $categories = CategoryProduct::all();

        return view('admin.listproduct',['products' => $products, 'totalPage' => $products->lastPage() ,'idPage' => $idPage,'categories' => $categories]);
        
    }
    public function create()
    {
        //
        if(!Auth::check()){
            
            return redirect('/login');

        }

        $user = Auth::user();

        if( !$user->role === 'admin' ){

            return redirect('/accountUser');

        }
        
        $categories = CategoryProduct::all();

        if($categories->isEmpty()){

            $categories = '';

        }

        $data = [
            'categories' => $categories,
        ];

        return view('admin.addproduct',$data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        $request->validated();

        if($request->hasFile('image')){

            $fileNameNew = time().'.'.$request->file('image')->getClientOriginalExtension();

            $request->file('image')->storeAs('',$fileNameNew,'public');

            Product::create([
                'name' => $request->name,
                'image' => $fileNameNew,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'describe' => $request->describe,
                'category_id' => $request->category_id
            ]);

            return redirect('/addproduct')->with('tb','Thêm sản phẩm thành công');

        }

        return redirect('/addproduct')->with('tb','Lỗi ảnh không tồn tại');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $product_cate = Product::query()
        ->where('category_id','=',$product->category_id)
        ->where('id','!=',$product->id)
        ->limit(3)
        ->get();

        if(Auth::check() && Auth::user()->role === 'admin'){

            return view('admin.updateproduct',['product' => $product ]);

        }

        $commentss = Comment::where('product_id','=',$product->id)->get();


        // dd($commentss);

        return view('products.detail',['product' => $product, 'product_cate' => $product_cate ,'commentss' => $commentss]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        if(!$product){

            return "Sản phẩm không tồn tại";

        }

        $categories = CategoryProduct::all();

        return view('admin.editproduct',['product' => $product,'categories' => $categories]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
            $request->validated();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->describe = $request->describe;
            $product->category_id = $request->category_id;
            if($request->hasFile('image')){
                $fileName = time() .'.'.$request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs('',$fileName,'public');
                Storage::disk('public')->delete($product->image);
                $product->image = $fileName;
            }
            $product->save();
            return redirect('/product/edit/'.$product->id)->with('success','Cập nhật sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if(!$product){

            return redirect('/listproduct')->with('error','Sản phẩm không tồn tại');
        }

        $product->delete();

        return redirect('/listproduct')->with('success','Xóa sản phẩm thành công');

    }
}

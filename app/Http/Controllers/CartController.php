<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
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

    public function deleteCart($position){

        if(Auth::check() && Auth::user()->role === 'user'){

            $cart = Cart::find($position);

            if(!$cart){

                return redirect('/cart')->withErrors(['error' => 'Sản phẩm không tồn tại trong giỏ hàng!']);

            }

            $cart->delete();

            return redirect('/cart');

        }

        $carts =Session::get('cart');

        if(!isset($carts[$position])){

            return redirect('/cart')->withErrors(['error_cart' => 'Sản phẩm không tồn tại trong giỏ hàng']);

        }

        unset($carts[$position]);

        Session::put('cart',$carts);

        return redirect('/cart');

    }

    public function addToCart(Request $request){

        $idProduct = $request->id_pro;

        $name = $request->name;

        $price = $request->price;

        $image = $request->image;

        $quantity = $request->quantity;

        $size = $request->size;

        if(Auth::check() && Auth::user()->role === 'user'){

            $idUser = Auth::user()->id;

            $cartsUser = Cart::where('user_id',$idUser)->get();

            if( $cartsUser->isEmpty()){

                $cart = Cart::create([

                    'name' => $name,

                    'image' => $image,

                    'price' => $price,

                    'quantity' => $quantity,

                    'size' => $size,

                    'user_id' => $idUser,

                    'product_id' => $idProduct,
    
                ]);
    
                return redirect('/cart');
            }

            $flag = 0;

            foreach( $cartsUser as $cart ){

                if( $cart->product_id == $idProduct && $cart->size == $size ){

                    $quantityNew = $cart->quantity + $quantity;

                    $cart->update([

                        'quantity' => $quantityNew,

                    ]);

                    $flag = 1;

                    break;

                }

            }

            if( $flag == 0 ){
                
                $cart = Cart::create([

                    'name' => $name,

                    'image' => $image,

                    'price' => $price,

                    'quantity' => $quantity,

                    'size' => $size,

                    'user_id' => $idUser,

                    'product_id' => $idProduct,

                ]);

            }

        }

        $cart = [

                'name' => $name,

                'image' => $image,

                'price' => $price,

                'quantity' => $quantity,

                'size' => $size,

                'product_id' => $idProduct,

        ];


        //
        $flag = 0;

        $carts = Session::get('cart',[]);

        for($i = 0 ; $i < count($carts) ; $i++ ){
            
            if( $idProduct == $carts [$i] ['product_id'] && $size == $carts [$i] ['size'] ){

                $flag = 1;

                $carts [$i] ['quantity'] += $quantity;

                break;

            }
        }

        //
        if($flag == 0){

            $carts[] = $cart;

        }

        Session::put('cart', $carts);

        return redirect('/cart');
        


    }
    public function updateCart(Request $request){

        $id = $request->cart_id;

        $quantity = $request->quantity;


        if(Auth::check()){
            
            $cart = Cart::where('id',$id)->get()->first();

            $cart->quantity = $quantity;

            $cart->save();

            return response()->json(['message'=> 'Cập nhật thành công']);

        }

        $carts = Session::get('cart');

        $carts[$id]['quantity'] = $quantity;

        Session::put('cart',$carts);

        return response()->json(['message'=> 'Cập nhật thành công']);

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
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}

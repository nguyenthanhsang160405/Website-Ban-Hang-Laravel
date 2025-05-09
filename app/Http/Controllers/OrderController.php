<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DetaiOrder;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use PDOException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $orders_pending = Order::where('status_order','=','pending')
        ->where('method_payment_id','!=',2)
        ->where('status_payments','=','completed')
        ->get();

        $orders_pending_push = Order::where('status_order','=','pending')
        ->where('method_payment_id','=',2)
        ->get();

        $orders_pending = $orders_pending->merge($orders_pending_push);


        $orders_processing = Order::where('status_order','!=','pending')
        ->where('status_order','!=','completed')->get();

        $orders_completed = Order::where('status_order','=','completed')
        ->get();

        return view('admin.listorder',['orders_pending'=> $orders_pending,'orders_processing' => $orders_processing, 'orders_completed' => $orders_completed ]);
    }

    
    public function Accept(Order $order) {

        $order->status_order = 'processing';

        $order->save();

        return redirect('/listorder')->with('success', 'Đã chấp nhận đơn hàng');
    }

    public function UpdateStatus(Request $request, Order $order){
        
        $order->status_order = $request->status;

        if($request->status == 'cancelled'){

            $detailOrders = DetaiOrder::where('order_id','=',$order->id)->get();

            foreach($detailOrders as $detailOrder){

                $product = Product::find($detailOrder->product_id);

                $product->quantity += $detailOrder->quantity;

                $product->save();

            }

            $order->delete();

            return redirect('/listorder')->with('success', 'Đã cập nhật trạng thái đơn hàng');

        }

        $order->save();

        return redirect('/listorder')->with('success', 'Đã cập nhật trạng thái đơn hàng');
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

        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => "required|regex:/^0[0-9]{9}$/",
                'address' => 'required|min:10',
                'payment' => 'required',
                'user_id' => 'required',
                'total_order' => 'required'
                ],
                [
                    'name.required' => 'Tên không được để trống', 
                    'email.required' => 'Email không được để trống',
                    'email.email' => 'Email không được để trống',
                    'phone.required' => 'Số điện thoại không được để trống',
                    'phone.regex' => 'Không đúng định dạng số điện thoại',
                    'address.required' => 'Địa chỉ không được để trống',
                    'address.min' => 'Không được nhỏ hơn 10 kí tự',
                    'payment.required' => 'Phương thức thanh toán không được để trống',
                    'user_id.required' => 'Mã khách hàng không được để trống',
                    'total_order.required' => 'Giá tổng đơn hàng không được để trống'
                ]
            );

            $name =$request->name;
            $email = $request->email;
            $phone = $request->phone;
            $address = $request->address;
            $payment = $request->payment;
            $userId = $request->user_id;
            $totalOrder = $request->total_order;

            $order = Order::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'total_order' => $totalOrder,
                'user_id' => $userId,
                'method_payment_id' => $payment,
            ]);

            

            if(!$order){

                redirect('/cart')->withCookies(['error_cart' => 'Tạo đơn hàng không thành công vui lòng thử lại']);
                
            }

            $allCartOfUser = Cart::where('user_id',$userId)->get();

            if($allCartOfUser->isEmpty()){

                $order->delete();

                return redirect('/cart')->withErrors(['error_cart' => 'Bạn vui lòng thêm sản phẩm để thực hiện thanh toán']);

            }
            foreach ($allCartOfUser as $cart){

                DetaiOrder::create([
                    'name' => $cart->name,
                    'image' => $cart->image,
                    'price' => $cart->price,
                    'quantity' => $cart->quantity,
                    'size' => $cart->size,
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                ]);

                $product = Product::find($cart->product_id);

                $quantity_product = $product->quantity - $cart->quantity;

                if($quantity_product < 0){

                    $quantity_product = 0;
                }

                $product->quantity = $quantity_product;

                $product->save();

                $cart->delete();

            }

        

            switch($payment){
                case 1:
                    $paymentPayPal = new PayPalController();
                    $paymentPayPal->createPayment($order);
                    break;
                case 3:
                    $url = URL::signedRoute('vnpay',['order_id'=> $order->id]);
                    $order->paypal_response = $url;
                    $order->save();
                    return redirect($url);
                default:
                    return redirect('/accountUser');
            }
                
            
            
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $detailOrders = DetaiOrder::where('order_id', '=',$order->id)->get();

        if(Auth::check() && Auth::user()->role === 'admin'){

            return view('admin.detailorder',['detailOrders' => $detailOrders, 'order' => $order]);

        }

        return view('users.detailorder',['detailOrders' => $detailOrders , 'order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
    
}

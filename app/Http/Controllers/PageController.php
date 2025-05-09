<?php

namespace App\Http\Controllers;


use App\Mail\ContactController;
use App\Mail\FogetPassWordEmail;
use App\Models\Cart;
use App\Models\MethodPayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class PageController extends Controller
{
    public function pagePayment(){

        if(!Auth::check()){

            $carts = Session::get('cart',[]);

            if(empty($carts)){

                return redirect('/cart')->withErrors(['error_cart' => 'Bạn vui lòng thêm sản phẩm vào giỏ hàng để thanh toán']);

            }

            return redirect('/login');
            
        }
        
        $user = Auth::user();

        $idUser =$user->id;

        $carts = Cart::where('user_id',$idUser)->get();

        if($carts->isEmpty()){

            return redirect('/cart')->withErrors(['error_cart' => 'Bạn vui lòng lựa chọn thêm sản phẩm để thanh toán']);

        }

        $methodPayment = MethodPayment::all();

        $allCarts = Cart::where('user_id',$idUser)->get();

        $quantity = $allCarts->count();


        $totalPrice = $allCarts->sum(function($cart){

            return $cart->price * $cart->quantity;
            
        });
    

        return view('payment',['methodPayment' => $methodPayment ,'quantity' => $quantity , 'totalPrice' => $totalPrice]);

    }
    //
    public function contact(){
        
       return  view('contact');

    }

    public function confirmCode(Request $request){

        $request->validate(

            [
                'email' => 'required|exists:users,email'
            ],
            [
                'email.required' => 'Email không đuộc để trống',
                'email.exists' => 'Email này chưa được đăng ký',
            ]
            );

        $email = $request->email;

        $code = rand(100000,999999);

        $user = User::where('email',$email)->first();

        $user->code_password = $code;

        $user->save();

        if(!Mail::to($email)->send(new FogetPassWordEmail($email,$code))){

            return redirect()->back()->withInput()->withErrors(['error' => 'Gửi email không thành công']);

        }
        
        return redirect('/confirm')->with('email',$email);
           
    }

    public function cart(){

        if(Auth::check() && Auth::user()->role === 'user'){

            $idUser = Auth::user()->id;

            $carts = Cart::where('user_id',$idUser)->get();

            if($carts->isEmpty()){

                return view('cart',data: ['carts' => '']);

            }

            return view('cart',['carts' => $carts]);
        }

        $carts = Session::get('cart');

        return view('cart',['carts' => $carts]);

    }

    public function checkCodePassWord(Request $request){

        $request->validate(
            [
                'code' => 'required|max:6|min:6',
                'passwordd' => 'required',
                'confirmpassword' => 'required|same:passwordd'
            ],
            [
                'code.required' => 'Vui lòng nhập mã khôi phục',
                'code.min' => 'Mã khôi phục phải là 6 chữ số',
                'code.max' => 'Mã khôi phục phải là 6 chữ số',
                'passwordd.required' => 'Vui lòng nhập mật khẩu',
                'confirmpassword.required' => 'Vui lòng nhập xác nhận lại mật khẩu',
                'confirmpassword.same' => 'Mật khẩu không trùng khớp',
            ]
        );


        $email = $request->email;

        $code = $request->code;

        $password = $request->passwordd;

        if(empty($email)){

            return redirect('/forgetPassword')->withErrors(['error' => 'Vui lòng nhập email trước khi gửi mã']);

        }

        $user = User::where('email',$email)->first();
        

        if($user->code_password != $code){

            return redirect()->back()->withInput()->withErrors(['error' => 'Mã khôi phục không chính xác']);

        }

        $user->password = Hash::make($password);

        $user->code_password = null;

        $user->save();

        Auth::login($user);

        if($user->role === 'admin'){

            return redirect('/admin');

        }

        return redirect('/accountUser');

    }

    public function forgetPassword(){

        return view('forgotpassword');

    }

    public function pageConfirm(){
        return view('confirm');
    }

    public function pageVNPay(Request $request){

        $id_order = $request->query('order_id');

        $order = Order::find($id_order);

        return view('payment.pageVNPay',['order' => $order]);
    }

    


    public function sendEmail(Request $request){
            $request->validate(
                [   
                    'name' => 'required',
                    'email' => 'required|email',
                    // 'subject' => 'required',
                    'content' => 'required'
                ],
                [
                    'name.required' => 'Tên không được để trống',
                    'email.required' => 'Email không được để trống',
                    'email_KhachHang.email' => 'Email không đúng định dạng',
                    // 'subject.required' => 'Chủ đề không được để trống',
                    'content.required' => 'Nội dung không được để trống'
                ]
                );
    
                $name = $request->name;
                $subject = 'Thư Cảm Ơn';
                $email_KhachHang = $request->email;
                $phone = $request->phone;
                $content = '<!DOCTYPE html>
                                <html>
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Phản hồi liên hệ từ [Tên công ty]</title>
                                    <style>
                                        body {
                                            font-family: Arial, sans-serif;
                                            background-color: #f4f4f4;
                                            margin: 0;
                                            padding: 0;
                                        }
                                        .email-container {
                                            max-width: 600px;
                                            margin: 20px auto;
                                            background: #ffffff;
                                            padding: 20px;
                                            border-radius: 8px;
                                            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                                        }
                                        .email-header {
                                            text-align: center;
                                            background: #007bff;
                                            color: white;
                                            padding: 10px 0;
                                            border-radius: 8px 8px 0 0;
                                        }
                                        .email-content {
                                            padding: 20px;
                                            color: #333;
                                            line-height: 1.6;
                                        }
                                        .email-footer {
                                            text-align: center;
                                            padding: 10px;
                                            font-size: 12px;
                                            color: #777;
                                        }
                                        .btn {
                                            display: inline-block;
                                            padding: 10px 15px;
                                            background: #007bff;
                                            color: white;
                                            text-decoration: none;
                                            border-radius: 5px;
                                            margin-top: 10px;
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div class="email-container">
                                        <div class="email-header">
                                            <h2>Phản hồi từ Nguyễn Thanh Sang</h2>
                                        </div>
                                        <div class="email-content">
                                            <p>Chào '.$name.',</p>
                                            <p>Chúng tôi đã nhận được yêu cầu liên hệ của bạn và sẽ phản hồi trong thời gian sớm nhất. Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ lại với chúng tôi qua thông tin dưới đây:</p>
                                            <p><strong>Email:</strong> support@example.com</p>
                                            <p><strong>Hotline:</strong> 0123-456-789</p>
                                            <p>Cảm ơn bạn đã liên hệ với chúng tôi!</p>
                                        </div>
                                        <div class="email-footer">
                                            <p>&copy; 2025 [Tên công ty]. Mọi quyền được bảo lưu.</p>
                                        </div>
                                    </div>
                                </body>
                                </html>';
                if(!Mail::to($email_KhachHang)->send(new ContactController($email_KhachHang,$subject,$content))){
                    return back()->withInput();
                }
           
        

            return redirect('/contact')->with('success','Gửi emailemail thành công!');
    }
    public function pageReport(){

        $totalRevenue = Order::query()->where('status_order','completed')->sum('total_order');

        $totalProduct = Product::query()->count();

        $totalUser = User::query()->count();

        $totalOrder = Order::query()->where('status_order','completed')->count();

        

        $now = now();

        $year = $now->year;

        $month = $now->month;

        $day = $now->day;

        $week = $now->weekOfYear();


        $revenueByDay = Order::query()
        ->where('status_order','completed')
        ->whereDay('created_at',$day)
        ->whereMonth('created_at',$month)
        ->whereYear('created_at',$year)
        ->get()
        ->sum('total_order');

        $revenueByWeek = Order::query()
        ->whereYear('created_at',$year)
        //  DATE(), YEAR(), MONTH(), WEEK(), DAY()  MAX() và MIN()  AVG() SUM() COUNT() DATE_FORMAT(created_at, '%Y-%m')
        ->whereRaw('WEEK(created_at,1) = ?',[$week])
        ->get()->sum('total_order');

        $revenueByMonth = Order::query()
        ->where('status_order','completed')
        ->whereMonth('created_at',$month)
        ->whereYear('created_at',$year)
        ->get()
        ->sum('total_order');

        $revenueByYear = Order::query()
        ->where('status_order','completed')
        ->whereYear('created_at',$year)
        ->get()
        ->sum('total_order');


        $productSellByMonth = Order::query()->selectRaw('COUNT(*) as total_order,MONTH(created_at) as month')
        ->whereYear('created_at',$year)
        ->where('status_order','completed')
        ->groupBy('month')
        ->orderBy('month','asc')
        ->get()
        ->toArray();

        $productSellByYear = Order::query()
        ->selectRaw('COUNT(*) as total_order, YEAR(created_at) as year')
        ->where('status_order','completed')
        ->groupBy('year')
        ->get()
        ->toArray();

        $totalYearMonth = Order::query()
        ->where('status_order','completed')
        ->selectRaw('MONTH(created_at) as month , YEAR(created_at) as year, SUM(total_order) as total_order')
        ->groupBy('month','year')
        ->get()
        ->toArray();
        
        // dd($productSellByYear);


        $data = [

            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProduct,
            'totalUsers' => $totalUser,
            'totalOrders' => $totalOrder,

            'revenueByDay' => $revenueByDay,
            'revenueByWeek' => $revenueByWeek,
            'revenueByMonth' => $revenueByMonth,
            'revenueByYear' => $revenueByYear,
            'productSellByMonth' => $productSellByMonth,
            'productSellByYear' => $productSellByYear,

            'totalYearMonth' => $totalYearMonth,
        ];

        return view('admin.baocao',$data);

    }
}

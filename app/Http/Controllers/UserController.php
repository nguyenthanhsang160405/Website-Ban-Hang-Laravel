<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Laravel\Socialite\Facades\Socialite;
use PDOException;
use Termwind\Components\Ul;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function pageLogin(){
        return view('login');
    }



    public function pageRegister(){
        return view('register');
    }

    public function loginWithGoogle(){
        
        $user = Socialite::driver('google')->user();

        $u = User::where('email',$user->getEmail())->first();

        if(!$u){
            $user = User::updateOrCreate(
                [
                    'email' => $user->getEmail()
                ],
                [
                    'name' => $user->getName(),
                    'password' => Hash::make($user->getId()),
                    'google_id' => $user->getId(),
                ]
            );
        }else{
            $user = User::updateOrCreate(
                [
                    'email' => $user->getEmail()
                ],
                [
                    'name' => $user->getName(),
                    'google_id' => $user->getId(),
                ]
            );
        }

        

        Auth::login($user);

        $user = Auth::user();

        if($user->role === 'admin'){

            return redirect('/admin');

        }

        $carts = Session::get('cart',[]);

        foreach($carts as $cart){

            Cart::create([
                'name' => $cart['name'],
                'image' => $cart['image'],
                'price' => $cart['price'],
                'size' => $cart['size'],
                'quantity' => $cart['quantity'],
                'user_id' => $user->id,
                'product_id' => $cart['product_id'],
            ]);

        }   

        Session::forget('cart');

        return redirect('/accountUser');
    }



    public function actionLogin(Request $request){

        $auth = $request->validate([
            
            'email' => 'required|email',

            'password' => 'required'
        ],

[
            'email.required' => 'Email không được để trống',

            'email.email' => 'Email không đúng định dạng',

            'password.required' => 'Mật khẩu không được để trống'
        ]);


        if( Auth::attempt($auth) ){

            $user = Auth::user();

            $carts = Session::get('cart',[]);

            foreach($carts as $cart){

                Cart::create([
                    'name' => $cart['name'],
                    'image' => $cart['image'],
                    'price' => $cart['price'],
                    'size' => $cart['size'],
                    'quantity' => $cart['quantity'],
                    'user_id' => $user->id,
                    'product_id' => $cart['product_id'],
                ]);

            }

            Session::forget('cart');

            // $user->hasVerifiedEmail();

            $token = $user->createToken('api-token')->plainTextToken;  

            // dd($token);

            $request->session()->regenerate(); // Tạo session mới để bảo mật

            if( $user->role === 'admin' ){

                return redirect('/admin');

            }

            return redirect()->intended('/accountUser');

        }

        return redirect()->back()->withErrors(['chung' => 'Email hoặc mật khẩu không đúng'])->withInput();

    }


    public function actionRegister(Request $request){

        $request->validate(

            [
                'name' => 'required',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|min:5',

                'password_confirm' => 'required|min:5|same:password',
            ],
            [
                'name.required' => 'Tên không được để trống',

                'email.required' => 'Email không được để trống',

                'email.email' => 'Email không đúng định dạng',

                'email.unique' => 'Email đã tồn tại',

                'password.required' => 'Mật khẩu không được để trống',

                'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự',

                'password_confirm.required' => 'Mật khẩu xác nhận không được để trống',

                'password_confirm.min' => 'Mật khẩu xác nhận phải có ít nhất 5 ký tự',

                'password_confirm.same' => 'Mật khẩu xác nhận không trùng khớp',
            ]
        );

        $user = User::create(
            [
                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),
            ]
        );

        Auth::login($user);

        // $user->sendEmailVerificationNotification();

        return redirect('/accountUser');    

    }




    public function pageAccountUser(){

        $user = Auth::user();

        if( $user ){

            $orders = Order::where('user_id',$user->id)->get();

            if($orders->isEmpty()){

                $orders = '';
                
            }

            return view('users.accountUser', ['user' => $user, 'orders' => $orders]);

        }

        return redirect('/login');

    }

    public function pageAddUser(){

        return view('admin.adduser');
    }




    public function actionLogout(){

        auth()->user()->tokens()->delete();

        Auth::logout();

        return redirect('/login');
    }


    public function pageIndexAdmin(){

        if( Auth::check() && Auth::user()->role === 'admin' ){

            $users = User::all()->reverse();

            return view('admin.index_admin', ['users' => $users]);

        }

        return redirect('/accountUser');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = User::update([

                'name' => 'admin',

                'email' => 'Sang'

            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(

            [
                'name' => 'required',

                'email' => 'required|email|unique:users,email',

                'password' => 'required|min:5',

                'password_confirm' => 'required|min:5|same:password',
            ],
            [
                'name.required' => 'Tên không được để trống',

                'email.required' => 'Email không được để trống',

                'email.email' => 'Email không đúng định dạng',

                'email.unique' => 'Email đã tồn tại',

                'password.required' => 'Mật khẩu không được để trống',

                'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự',

                'password_confirm.required' => 'Mật khẩu xác nhận không được để trống',

                'password_confirm.min' => 'Mật khẩu xác nhận phải có ít nhất 5 ký tự',

                'password_confirm.same' => 'Mật khẩu xác nhận không trùng khớp',
            ]
        );

        $user = User::create(
            [
                'name' => $request->name,

                'email' => $request->email,

                'password' => Hash::make($request->password),

                'role' => $request->role,
            ]
        );

        return redirect('/admin')->with('success','Thêm người dùng thành công');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        if(!$user){

            return "Người dùng không tồn tại";

        }

        return view('admin.edituser', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //

        $request->validate(

            [
                'name' => 'required',

                'phone' => 'regex:/^0[0-9]{9}$/',

                // 'password' => 'required|min:5',
            ],
            [
                'name.required' => 'Tên không được để trống',

                'phone.regex' => 'Không đúng định dạng số điện thoại',

                // 'password.required' => 'Mật khẩu không được để trống',

                // 'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự',

                // 'password_confirm.required' => 'Mật khẩu xác nhận không được để trống',

                // 'password_confirm.min' => 'Mật khẩu xác nhận phải có ít nhất 5 ký tự',

                // 'password_confirm.same' => 'Mật khẩu xác nhận không trùng khớp',
            ]
        );

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
        ]);

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        

        

        return redirect('/user/'.$user->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // xóa nhiều người dùng
        // $ids =  [4,5];

        // User::destroy($ids);

        $user->delete();

        return redirect('/admin');
    }
    public function updateImformation(UserRequest $request , User $user){

        if(!$request->isMethod('POST')){

            return redirect('/accountUser');

        }

        $request->validated();

        // print_r($request->all());
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect('/accountUser');


    }
    public function updatePassword(Request $request , User $user){
        $request->validate(
            [
                    'password_old' => ['required',new Password],
                    'password_new' => ['required'],
                    'password_confirm' => ['required','same:password_new'],
                    ],
        [
            'password_old.required' => 'Mật khẩu cũ không được để trống',
            'password_new.required' => 'Mật khẩu mới không được để trống',
            'password_confirm.required' => 'Xác nhận mật khẩu không được để trống',
            'password_confirm.same' => 'Mật khẩu không khớp nhau',
        ]
        );

        $user->update([

        'password' => Hash::make($request->password_new),

        ]);

        $request->session()->regenerate();

        Auth::login($user);

        return redirect('/accountUser');   
        
    }

    // public function testUserApi($id){
    //     $users = User::with([
    //         'orders',
    //         'orders.detaiOrders'
    //     ])->find($id);

        
    //     $data = [
    //         "users" => $users,
    //     ];

    //     return response()->json($data,200);
    // }
}

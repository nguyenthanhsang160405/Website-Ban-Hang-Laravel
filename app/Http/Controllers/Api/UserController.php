<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::with('orders')->get();

        if($users->isEmpty()){
            $response = [
                "status" => false,
                'message' => "Không tìm thấy user nào",
            ];
            return response()->json($response, 404);
        }

        $reponse = [
            "status" => true,
            'message' => "Lấy user thành công",
            'data' => $users,
        ];

        return response()->json($reponse, 200,[]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'email|unique:users,email|',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable',
            'password' => 'required',
            'role' => 'required',
        ],
        [
            'name.required' => 'Tên người dùng không được b�� trống',
            'email.email' => 'Email không đúng đ��nh dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone.regex' => 'Số điện thoại phải là 10 chữ số bắt đầu b��ng 0',
            'password.required' => 'Mật khẩu không được b�� trống',
            'role.required' => 'Vai trò không được b�� trống',
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => 'Thêm sản phẩm thất bại',
                'errors' => $validator->errors()
            ],422,[],JSON_UNESCAPED_UNICODE);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $response = [
            "status" => true,
            'message' => "Thêm user thành công",
            'data' => $user,
        ];

        return response()->json($response, 201,[]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);

        if(!$user){
            $response = [
                "status" => false,
                'message' => "User không tồn tại",
            ];
            return response()->json($response, 404);
        }

        $response = [
            "status" => true,
            'message' => "Lấy user thành công",
            'data' => $user,
        ];
        return response()->json($response, 200,[]);
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
            'email' => 'email',
            'phone' => 'nullable|regex:/^0[0-9]{9}$/',
            'address' => 'nullable',
            'role' => 'required',
        ],
        [
            'name.required' => 'Tên người dùng không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.regex' => 'Số điện thoại phải là 10 chữ số bắt đầu bắt đầu từ 0',
            'role.required' => 'Vai trò không được để trống',
        ]);

        if($validator->fails()){
            return response()->json([
               'success' => false,
               'message' => 'Lỗi dữ liệu vào',
                'errors' => $validator->errors()
            ],422,[],JSON_UNESCAPED_UNICODE);
        }

        $user = User::find($id);

        if(!$user){
            $response = [
                "status" => false,
                'message' => "User không tồn tại",
            ];
            return response()->json($response, 404);
        }

        $user->name = $request->name;

        $user->email = $request->email;

        if($request->has('password')){

            $user->password = Hash::make($request->password);

        }
        if($request->has('phone')){

            $user->phone = $request->phone;

        }
        if($request->has('address')){

            $user->address = $request->address;

        }

        $user->role = $request->role;

        $user->save();

        $response = [
            "status" => true,
            'message' => "Cập nhật user thành công",
            'data' => $user,
        ];

        return response()->json($response, 201,[]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);

        if(!$user){
            $response = [
                "status" => false,
                'message' => "User không tồn tại",
            ];
            return response()->json($response, 404);
        }

        $user->delete();

        $response = [
            "status" => true,
            'message' => "Xóa user thành công",
        ];
        return response()->json($response, 200,[]);
    }
}

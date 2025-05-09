<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $response = FacadesValidator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if($response->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Lỗi dữ liệu',
                'data' => $response->errors(),
            ], 400,[],JSON_UNESCAPED_UNICODE);
        }

        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
        [
            'data' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer'
        ], 200,[],JSON_UNESCAPED_UNICODE);
    }
    public function login(Request $request){

        $response = FacadesValidator::make($request->all(),[
            'email' => 'required|email|ends_with:@gmail.com',
            'password' => 'required'
        ]);

        if($response->fails()){

            return response()->json([
                'status' => false,
                'message' => 'Lỗi dữ liệu',
                'data' => $response->errors(), 
            ],404,[],JSON_UNESCAPED_UNICODE);

        }
        
        $check = FacadesAuth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if(!$check){
            return response()->json([
                'status' => false,
                'message' => 'Sai tài khoản hoặc mật khẩu',
            ], 401,[],JSON_UNESCAPED_UNICODE);
        }

        $token = FacadesAuth::user()->createToken('auth_token')->plainTextToken; 

        return response()->json([
            'status' => true,
            'message' => 'Đăng nhập thành công',
            'id_user' => FacadesAuth::user()->id,
            'token_type' => 'Bearer', 
            'access_token' => $token
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE);
    }

    public function logout(Request $request){

        $id_user = $request->id_user;
        
        User::find($id_user)->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Đăng xuất thành công',
        ], 200,[],JSON_UNESCAPED_UNICODE);

    }

    
}

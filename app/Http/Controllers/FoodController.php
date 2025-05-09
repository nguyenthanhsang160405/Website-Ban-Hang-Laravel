<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Validation\Rules\Email;
use Illuminate\Support\Facades\Validator;
use App\Rules\Uppercase;

class FoodController extends Controller
{
    //
    public function index(){
        return "Danh sách món ăn";
    }
    public function getAllFood(){
        $foods = Food::all();
        return view('food.food',['foods'=>$foods]);
    }
    public function pageAddFood(){
        return view('food.add_food');
    }
    public function addFood(Request $request){

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:foods,email',
            'password' => 'required|min:6',
        ],
        [
            'name.required'     => 'Vui lòng nhập tên món ăn.',
            'name.string'       => 'Tên món ăn phải là chuỗi ký tự.',
            'name.max'          => 'Tên món ăn không được vượt quá 255 ký tự.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email này đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $food = Food::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        
        $food->save();
        return redirect('/foods');
    }
    public function addFood2(Request $request){

        $request->validate([
            'name'     => new Uppercase,
            'email'    => 'required|email|unique:foods,email',
            'password' => 'required|min:6',
        ]);

        $food = Food::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        
        $food->save();
        return redirect('/foods');
    }
    public function addFood3(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:foods,email',
            'password' => 'required|min:6',
        ], [
            'name.required'     => 'Vui lòng nhập tên món ăn.',
            'name.string'       => 'Tên món ăn phải là chuỗi ký tự.',
            'name.max'          => 'Tên món ăn không được vượt quá 255 ký tự.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email này đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);
    
        // Kiểm tra nếu có lỗi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        Food::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
    
        return redirect('/foods')->with('success', 'Món ăn đã được thêm thành công!');
    }
}

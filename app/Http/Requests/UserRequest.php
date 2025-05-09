<?php

namespace App\Http\Requests;

use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' =>['required'],
            'email' => [''],
            'phone' => ['required','regex:/^0[0-9]{9}$/'],
            'address' => ['required'],
            'gender' => [''],
            'role' => [''],
        ];
    }
    public function messages(): array {
        return [
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Không đúng định dạng số điện thoại.',
            'address.required' => 'Địa chỉ không được để trống',
        ];
    }
}

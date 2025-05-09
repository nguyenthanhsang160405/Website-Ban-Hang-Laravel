<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['required'],
            'image' => ['image','max:2048'],
            'price' => ['required','integer','min:0'],
            'quantity' => ['min:1','integer'],
            'category_id' => ['required','exists:category_products,id'],
        ];
    }

    public function messages(): array
    {
        return [
            //
            'name.required' => 'Tên không được để trống',
            'image.image' => 'File phải là 1 ảnh',
            'image.max' => 'Kích thước ảnh quá lớn',
            'price.required' => 'Giá không được để trống',
            'price.integer' => 'Giá phải là số',
            'price.min' => 'Giá không được âm',
            'quantity.integer' => 'Số lượng phải là số',
            'quantity.min' => 'Số lượng phải ít nhất là 1',
            'category_id.required' => 'Danh mục không được để trống',
            'category_id.exists' => 'Danh mục không tồn tại',
        ];
    }
}

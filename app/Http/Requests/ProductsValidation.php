<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    // Validation Rules
    public function rules()
    {
        return [
            'product_name' =>'required|unique:products|max:25',
            'section_id' =>'required' ,
            'description'  => 'required'
        ];
    }
    // Validation Messages
    public function messages()
    {
        return [
            'product_name.required' => 'برجاء إدخال اسم المنتج'     ,
            'product_name.unique'   => ' اسم المنتج مُسجل مسبقاً'     ,
            'product_name.max'      => 'اسم المنتج لا يتعدي 25 حرف'  ,
            'section_id.required'   => 'برجاء إدخال اسم القسم'      ,
            'description.required'  => 'برجاء إدخال وصف القسم'
        ];
    }
}

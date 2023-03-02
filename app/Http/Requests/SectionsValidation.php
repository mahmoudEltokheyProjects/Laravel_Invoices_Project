<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SectionsValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'section_name' =>'required|unique:sections|max:25',
            'description'  => 'required'
        ];
    }
    public function messages()
    {
        return [
            'section_name.required' => 'برجاء إدخال اسم القسم'     ,
            'section_name.unique'   => ' اسم القسم مُسجل مسبقاً'     ,
            'section_name.max'      => 'اسم القسم لا يتعدي 25 حرف'  ,
            'description.required'  => 'برجاء إدخال وصف القسم'
        ];
    }
}

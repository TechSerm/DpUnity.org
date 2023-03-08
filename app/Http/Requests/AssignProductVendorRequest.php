<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignProductVendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_vendor.*' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'product_vendor.*.required' => 'বিক্রেতা সিলেক্ট করুন',
            'product_vendor.*.exists' => 'সঠিক বিক্রেতা সিলেক্ট করুন',
        ];
    }
}

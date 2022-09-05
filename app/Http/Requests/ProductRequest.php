<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'market_sale_price' => 'required|min:0',
            'wholesale_price' => 'required|integer|min:0',
            'profit' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
            'image' => 'image|mimes:jpg,png,jpeg,webp',
            'status' => 'required'
        ];
    }
}

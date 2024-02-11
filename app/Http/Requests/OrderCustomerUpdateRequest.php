<?php

namespace App\Http\Requests;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class OrderCustomerUpdateRequest extends FormRequest
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
            'phone' => 'required|regex:/^[01]{2}[0-9]{9}+$/',
            'address' => 'required',
            'delivery_fee' => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
        $order = Order::findOrFail(request()->order);
        return [
            'name' => 'required',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
        ];
    }
}

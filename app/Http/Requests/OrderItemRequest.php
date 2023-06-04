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
            'unit_quantity' => 'required',
            'unit' => 'required',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|integer|min:0',
            'wholesale_price' => 'required|integer|min:0',
            'total' => 'required|integer|min:0',
            'wholesale_price_total' => 'required|integer|min:0',
            'profit' => 'required|integer',
            'delivery_fee' => 'required|integer|min:0',
            'vendor_id' => $order->is_vendor_assign ? 'required|exists:users,id' : ''
        ];
    }
}

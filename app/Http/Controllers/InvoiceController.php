<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {

        return view('invoice.index');
    }

    public function print($orderId)
    {
        if (auth()->user()) {
            $order = Order::where(['id' => $orderId])->firstOrFail();
        } else {
            $order = Order::where(['id' => $orderId, 'is_delivery_complete' => false, 'is_cancelled' => false, 'is_delivery_start' => false])->firstOrFail();
        }

        return view('invoice.print', [
            'order' => $order
        ]);
    }
}

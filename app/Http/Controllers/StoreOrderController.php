<?php

namespace App\Http\Controllers;

use App\Cart\Cart;
use App\Facades\Order\OrderFacade;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreOrderController extends Controller
{
    public function index()
    {
        if (Cart::isEmpty()) {
            return view('store.order.no_product');
        }

        return view('store.order.index', [
            'items' => Cart::items()
        ]);
    }

    public function orderList()
    {
        $orders = OrderFacade::userOrder()->all();
        return view('store.order.list', [
            'orders' => $orders
        ]);
    }

    public function create()
    {
        return OrderFacade::newOrder()->create();
    }

    public function show($uuid)
    {
        $order = Order::where(['uuid' => request()->uuid])->firstOrFail();
        return view('store.order.show.index', ['order' => $order]);
    }
}
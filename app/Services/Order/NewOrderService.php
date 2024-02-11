<?php

namespace App\Services\Order;

use App\Cart\Cart;
use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderFacade;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Services\DeviceToken\DeviceTokenService;
use Illuminate\Support\Facades\Log;

class NewOrderService
{
    public function create()
    {
        $responseValidate = $this->validate();
        if (!empty($responseValidate)) {
            return response()->json($responseValidate, 422);
        }

        $shippingDetails = OrderShippingDetails::get();

        $deviceTokenService = new DeviceTokenService();

        $order = Order::create([
            'total' =>  Cart::totalPrice(),
            'discount_total' =>  0,
            'delivery_fee' =>  Cart::getDeliveryFee(),
            'name' => $shippingDetails->fullName,
            'address' =>  $shippingDetails->address,
            'phone' =>  $shippingDetails->phone,
            'ip_address' =>  request()->ip(),
            'user_agent' =>  request()->server('HTTP_USER_AGENT'),
            'status' => OrderStatusEnum::PROCESSING,
            
        ]);

        $this->createItems($order);
        $order = $order->updateTotalCalculation();
        $order->addCookie();
        

        return response()->json([
            'message' => 'অর্ডার করার জন্য আপনাকে অভিনন্দন।',
            'url' => route('store.order.show', ['uuid' => $order->uuid])
        ]);
    }

    public function validate()
    {
        if (OrderShippingDetails::isValidateFails()) {
            return [
                'body' => view("store.order.checkout.body_livewire", ['checkValidate' => true])->render(),
            ];
        }

        if (Cart::isEmpty()) {
            return [
                'message' => "আপনার ব্যাগে কোন পণ্য নেই।",
            ];
        }

        return [];
    }

    public function createStatus(Order $order)
    {
        $orderStatusList = array_diff(OrderStatusEnum::getValues(), ['pending', 'canceled']);
        foreach ($orderStatusList as $key => $status) {
            OrderStatus::create([
                'order_id' => $order->id,
                'name' => $status
            ]);
        }
    }

    public function createItems(Order $order)
    {
        $items = Cart::items();
        foreach ($items as $item) {
            $product = Product::where(['id' => $item->id])->first();
            if (!$product) continue;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product ? $product->id : null,

                'name' => $product->name,

                'quantity' => $item->cart_quantity,
                'price' => $product->sale_price,
            ]);
        }

        Cart::clear();
    }
}

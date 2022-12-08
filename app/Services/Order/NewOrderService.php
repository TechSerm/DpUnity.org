<?php

namespace App\Services\Order;

use App\Cart\Cart;
use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;

class NewOrderService
{
    public function create()
    {
        $responseValidate = $this->validate();
        if (!empty($responseValidate)) {
            return response()->json($responseValidate, 422);
        }

        $shippingDetails = OrderShippingDetails::get();
        $order = Order::create([
            'total' =>  Cart::totalPrice(),
            'discount_total' =>  0,
            'delivery_fee' =>  19,
            'name' => $shippingDetails->fullName,
            'address' =>  $shippingDetails->address,
            'phone' =>  $shippingDetails->phone,
            'ip_address' =>  request()->ip(),
            'user_agent' =>  request()->server('HTTP_USER_AGENT'),
            'status' => OrderStatusEnum::PENDING
        ]);

        $this->createItems($order);
        $this->createStatus($order);
        $order = $order->updateTotalCalculation();
        $this->sendOrderNotification($order);

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

        // return response()->json([
        //     'message' => "আপনার দুইটি অর্ডার পেন্ডিং এ আছে। আরও অর্ডার করতে আমাদের হট লাইনে যোগাযোগ করুন। আমাদের হটলাইন নম্বর 01777564786।",
        // ], 400);

        return [];
    }

    public function createStatus(Order $order){
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
                'unit' => $product->unit,
                'unit_quantity' => $product->quantity,

                'quantity' => $item->cart_quantity,
                'price' => $product->price,
                'wholesale_price' => $product->wholesale_price,
                'wholesale_price_update_time' => $product->wholesale_price_last_update
            ]);
        }

        Cart::clear();
    }

    private function sendOrderNotification(Order $order)
    {
        $body = "🔖 আপনার অর্ডার নম্বর : " . bnConvert()->number($order->id);
        $body .= "\n🛒 সর্বমোট বাজার: ৳ " . bnConvert()->number($order->subtotal);
        $body .= "\n🚑 ডেলিভারি মূল্য: ৳ " . bnConvert()->number($order->delivery_fee);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($order->total);
        $body .= "\n📌 আমরা ২ থেকে ৩ ঘন্টার মধ্যে আপনার অর্ডারটি ডেলিভারি দেয়ার চেষ্টা করবো। ডেলিভারি এর সময় আপনাকে " . bnConvert()->number($order->total) . " টাকা পরিশোধ করতে হবে।";
        PushNotificationFacade::notifyByIp($order->ip_address, [
            'title' => "বিবিসানায় অর্ডার করার জন্য আপনাকে অভিনন্দন 💐\n",
            'body' => $body,
            "url" => route('store.order.show', ['uuid' => $order->uuid]),
        ]);
    }
}

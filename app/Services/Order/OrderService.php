<?php

namespace App\Services\Order;

use App\Cart\Cart;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class OrderService
{
    public function create()
    {
        $responseValidate = $this->validateOrder();
        if (!empty($responseValidate)) {
            return response()->json($responseValidate, 422);
        }

        $shippingDetails = OrderShippingDetails::get();
        $order = Order::create([
            'total' =>  Cart::totalPrice(),
            'discount_total' =>  0,
            'shipping_total' =>  19,
            'customer_name' => $shippingDetails->fullName,
            'customer_address' =>  $shippingDetails->address,
            'customer_phone' =>  $shippingDetails->phone,
            'customer_ip_address' =>  request()->ip(),
            'customer_user_agent' =>  request()->server('HTTP_USER_AGENT'),
            'order_date' =>  Carbon::now(),
            'order_status' => 'pending'
        ]);

        $this->createItems($order);
        $this->sendOrderNotification($order);

        return response()->json([
            'message' => 'অর্ডার করার জন্য আপনাকে অভিনন্দন।',
            'url' => route('store.order.show', ['uuid' => $order->uuid])
        ]);
    }

    public function validateOrder()
    {
        if (OrderShippingDetails::isValidateFails()) {
            return [
                'body' => view("store.order.confirm_details", ['checkValidate' => true])->render(),
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

    public function createItems(Order $order)
    {
        $items = Cart::items();
        $totalWholesalePrice = 0;
        $totalProfit = 0;
        $subtotal = 0;

        foreach ($items as $item) {
            $product = Product::where(['id' => $item->id])->first();

            $wholesalePrice = $product ? $product->wholesale_price : $item->price;
            $itemProfit =  $this->profitCalculation($item->price, $wholesalePrice, $item->cart_quantity);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product ? $product->id : null,
                'name' => $item->name,
                'unit' => $item->unit,
                'unit_quantity' => $item->quantity,
                'quantity' => $item->cart_quantity,
                'price' => $item->price,
                'total' => $item->cart_total_price,
                'wholesale_price' => $wholesalePrice,
                'wholesale_price_last_update' => $product ? $product->wholesale_price_last_update : null,
                'profit' => $itemProfit
            ]);

            $subtotal += $item->cart_total_price;
            $totalProfit += $itemProfit;
            $totalWholesalePrice += $wholesalePrice * $item->cart_quantity;
        }

        $order->update([
            'wholesale_total' => $totalWholesalePrice,
            'profit' => $totalProfit,
            'subtotal' => $subtotal
        ]);

        //Cart::clear();
    }

    public function profitCalculation($price, $wholesalePrice, $quantity)
    {
        return ($price * $quantity) - ($wholesalePrice * $quantity);
    }

    private function sendOrderNotification(Order $order)
    {
        $body = "🔖 আপনার অর্ডার নম্বর : " . bnConvert()->number($order->id);
        $body .= "\n🛒 সর্বমোট বাজার: ৳ " . bnConvert()->number($order->total - $order->shipping_total);
        $body .= "\n🚑 ডেলিভারি মূল্য: ৳ " . bnConvert()->number($order->shipping_total);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($order->total);
        $body .= "\n📌 আমরা ২ থেকে ৩ ঘন্টার মধ্যে আপনার অর্ডারটি ডেলিভারি দেয়ার চেষ্টা করবো। ডেলিভারি এর সময় আপনাকে " . bnConvert()->number($order->total) . " টাকা পরিশোধ করতে হবে।";
        PushNotificationFacade::notifyByIp($order->customer_ip_address, [
            'title' => "বিবিসানায় অর্ডার করার জন্য আপনাকে অভিনন্দন 💐\n",
            'body' => $body,
            "url" => route('store.order.show', ['uuid' => $order->uuid]),
        ]);
    }

    public function userOrder()
    {
        return new UserOrderService();
    }
}

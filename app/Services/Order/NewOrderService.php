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
        $order = Order::create([
            'total' =>  Cart::totalPrice(),
            'discount_total' =>  0,
            'delivery_fee' =>  Cart::getDeliveryFee(),
            'name' => $shippingDetails->fullName,
            'address' =>  $shippingDetails->address,
            'phone' =>  $shippingDetails->phone,
            'ip_address' =>  request()->ip(),
            'user_agent' =>  request()->server('HTTP_USER_AGENT'),
            'status' => OrderStatusEnum::PENDING,
            'device_token' => deviceInfo()->getDeviceToken(),
            'app_version' => deviceInfo()->getAppVersion()
        ]);

        $this->createItems($order);
        $this->createStatus($order);
        $order = $order->updateTotalCalculation();
        $order->addCookie();
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

        $activeOrders = OrderFacade::userOrder()->active();

        if (count($activeOrders) >= 3 && !auth()->check()) {
            return [
                'message' => "আপনার ইতিমধ্যে তিনটি অর্ডার পেন্ডিং এ আছে। আরও অর্ডার করতে আমাদের হট লাইনে যোগাযোগ করুন। আমাদের হটলাইন নম্বর " . config('bibisena.mobile_number') . "।",
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
                'unit' => $product->unit,
                'unit_quantity' => $product->quantity,

                'quantity' => $item->cart_quantity,
                'price' => $product->price,
                'wholesale_price' => $product->wholesale_price,
                'wholesale_price_update_time' => $product->wholesale_price_last_update,
                'delivery_fee' => is_null($product->delivery_fee) ? config('bibisena.default_delivery_fee') : $product->delivery_fee
            ]);
        }

        Cart::clear();
    }

    private function sendOrderNotification(Order $order)
    {
        $this->sendCustomerNotification($order);
        $this->sendAdminNotification($order);
    }

    private function sendCustomerNotification(Order $order)
    {
        if (!deviceInfo()->hasDeviceToken()) return;

        $body = "🔖 আপনার অর্ডার নম্বর : " . bnConvert()->number($order->id);
        $body .= "\n🛒 পণ্যের মূল্য: ৳ " . bnConvert()->number($order->subtotal);
        $body .= "\n🚑 ডেলিভারি ফী: ৳ " . bnConvert()->number($order->delivery_fee);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($order->total);
        $body .= "\n📌 আমরা ২ থেকে ৩ ঘন্টার মধ্যে আপনার অর্ডারটি ডেলিভারি দেয়ার চেষ্টা করবো। ডেলিভারি এর সময় আপনাকে " . bnConvert()->number($order->total) . " টাকা পরিশোধ করতে হবে।";
        
        PushNotificationFacade::sendNotification([deviceInfo()->getDeviceToken()], [
            'title' => "বিবিসানায় অর্ডার করার জন্য আপনাকে অভিনন্দন 💐\n",
            'body' => $body,
            "url" => route('store.order.show', ['uuid' => $order->uuid]),
        ]);
    }

    private function sendAdminNotification(Order $order)
    {
        $tokens = OrderFacade::getManagerDeviceToken();
        if(empty($tokens))return;

        $body = "🔖 অর্ডার নম্বর : " . bnConvert()->number($order->id);
        $body .= "\n🛒 পণ্যের মূল্য: ৳ " . bnConvert()->number($order->subtotal);
        $body .= "\n🚑 ডেলিভারি ফী: ৳ " . bnConvert()->number($order->delivery_fee);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($order->total);
        $body .= "\n⏰ সময় : " . bnConvert()->date($order->created_at->format('d M Y, H:i'));
        
        PushNotificationFacade::sendNotification($tokens, [
            'title' => "বিবিসেনায় নতুন একটি অর্ডার এসেছে। অর্ডারটি প্রসেসিং করুন।💐\n",
            'body' => $body,
            "url" => route('orders.show', ['order' => $order->id]),
        ]);
    }
}

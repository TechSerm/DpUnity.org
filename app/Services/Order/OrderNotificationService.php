<?php

namespace App\Services\Order;

use App\Facades\Order\OrderFacade;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderNotificationService
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    private function notify($tokens, $body)
    {
        if (empty($tokens)) return;
        PushNotificationFacade::sendNotification($tokens, [
            'title' => "অর্ডার #" . $this->order->id . "\n",
            'body' => $body,
            "url" => route('orders.show', ['order' => $this->order->id]),
        ]);
    }

    public function notifyStatusChange()
    {
    }

    public function admin($message)
    {
        $body = $this->getAdminNotification($message);
        $tokens = OrderFacade::getManagerDeviceToken();
        $this->notify($tokens, $body);
    }

    public function vendor($message, $orderVendor)
    {
        $body = $this->getVendorNotification($message, $orderVendor);
        $tokens = OrderFacade::getManagerDeviceToken([$orderVendor->user_id]);
        $this->notify($tokens, $body);
    }

    public function customer($message)
    {
        $body = $this->getAdminNotification($message);
        $tokens = [];
        if ($this->order->device_token) {
            $tokens[] = $this->order->device_token;
        }
        $this->notify($tokens, $body);
    }

    public function allVendors($message)
    {
        $orderVendors = $this->order->vendors;
        foreach ($orderVendors as $orderVendor) {
            $this->vendor($message, $orderVendor);
        }
    }

    private function getVendorNotification($message, $orderVendor)
    {
        $body = $message . "\n";
        $body .= "🔖 অর্ডার নম্বর : " . bnConvert()->number($this->order->id);
        $body .= "\n🛒 পণ্যের মূল্য: ৳ " . bnConvert()->number($orderVendor->wholesale_total);
        $body .= "\n⏰ সময় : " . bnConvert()->date($this->order->created_at->format('d M Y, h:i a'));

        return $body;
    }

    private function getAdminNotification($message)
    {
        $body = $message . "\n";
        $body .= "🔖 অর্ডার নম্বর : " . bnConvert()->number($this->order->id);
        $body .= "\n🛒 পণ্যের মূল্য: ৳ " . bnConvert()->number($this->order->subtotal);
        $body .= "\n🚑 ডেলিভারি ফী: ৳ " . bnConvert()->number($this->order->delivery_fee);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($this->order->total);
        $body .= "\n⏰ সময় : " . bnConvert()->date($this->order->created_at->format('d M Y, h:i a'));

        return $body;
    }
}

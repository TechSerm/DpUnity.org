<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderStatusService
{
    public function changeOrderStatus(Order $order, $status)
    {
        if ($order->is_cancelled) {
            return response()->json([
                'message' => 'Order Already Cancelled'
            ], 400);
        }

        if (isset(request()->vendor)) {
            $this->updateVendorStatusAndNotify($order, $status);
        } else {
            $this->updateOrderStatusAndNotify($status, $order);
        }

        return response()->json([
            'message' => 'Successfully Change Status'
        ]);
    }

    /**
     * @param $status
     * @param Order $order
     * @return void
     */
    private function updateOrderStatusAndNotify($status, Order $order): void
    {
        $statusUpdates = [
            OrderStatusEnum::APPROVED => [
                'field' => 'is_approved',
                'notificationMessages' => [
                    'admin' => 'অর্ডারটি গ্রহণ করা হয়েছে।',
                    'customer' => 'আপনার অর্ডারটি গ্রহণ করা হয়েছে।'
                ]
            ],
            OrderStatusEnum::PACK_COMPLETE => [
                'field' => 'is_pack_complete',
                'notificationMessages' => [
                    'admin' => 'অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে।',
                    'customer' => 'আপনার অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে।'
                ]
            ],
            OrderStatusEnum::START_DELIVERY => [
                'field' => 'is_delivery_start',
                'notificationMessages' => [
                    'admin' => 'অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।',
                    'allVendors' => 'অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।',
                    'customer' => 'আপনার অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।'
                ]
            ],
            OrderStatusEnum::DELIVERY_COMPLETED => [
                'field' => 'is_delivery_complete',
                'notificationMessages' => [
                    'admin' => 'অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।',
                    'allVendors' => 'অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।',
                    'customer' => 'আপনার অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।'
                ]
            ],
            OrderStatusEnum::CANCELED => [
                'field' => 'is_cancelled',
                'notificationMessages' => [
                    'admin' => 'অর্ডারটি বাতিল করা হয়েছে।',
                    'allVendors' => 'অর্ডারটি বাতিল করা হয়েছে।',
                    'customer' => 'আপনার অর্ডারটি বাতিল করা হয়েছে।'
                ]
            ],
        ];

        if (isset($statusUpdates[$status])) {
            $order->update([
                $statusUpdates[$status]['field'] => true,
                'status' => $status
            ]);

            $this->sendNotification($statusUpdates[$status]['notificationMessages'], $order);
        }
    }

    /**
     * @param mixed $notificationMessages
     * @param Order $order
     * @return void
     */
    private function sendNotification(mixed $notificationMessages, Order $order): void
    {
        foreach ($notificationMessages as $key => $notificationMessage) {
            switch ($key) {
                case 'admin':
                    $order->notify()->admin($notificationMessage);
                    break;
                case 'customer':
                    $order->notify()->customer($notificationMessage);
                    break;
                case 'allVendors':
                    $order->notify()->allVendors($notificationMessage);
                    break;
            }
        }
    }

    /**
     * @param Order $order
     * @param $status
     * @return void
     */
    private function updateVendorStatusAndNotify(Order $order, $status): void
    {
        $orderVendor = $order->vendors()->where(['uuid' => request()->vendor])->first();
        if (!$orderVendor) return;

        $orderVendorData = [];
        $notifyMessage = "";

        if ($status == 'vendor_received') {
            $orderVendorData['is_received'] = true;
            $notifyMessage = $orderVendor->user->name . " অর্ডারটি গ্রহণ করেছে";
        } else if ($status == 'vendor_pack_complete') {
            $orderVendorData['is_pack_complete'] = true;
            $notifyMessage = $orderVendor->user->name . " এর প্রস্তুতি সম্পন্ন হয়েছে";
        }

        $orderVendor->update($orderVendorData);

        if ($notifyMessage != "") {
            $order->notify()->Admin($notifyMessage);
        }
    }
}

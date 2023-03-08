<?php

namespace App\Services\VendorPayment;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class VendorPaymentService
{
    public function getAllVendorData()
    {
        $orders = Order::leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id')
            ->leftJoin('users', 'users.id', '=', 'order_vendors.vendor_id')
            ->where(['is_delivery_complete' => true, 'orders.is_vendor_payment_complete' => false, 'order_vendors.is_vendor_payment_complete' => false])
            ->select(DB::raw('order_vendors.*, orders.created_at ,users.name'))->get();
        $orderVendorData = [];

        foreach ($orders as $order) {
            $isVendorPaymentSend = $order->is_vendor_payment_send;
            $wholeSaleTotal = $order->wholesale_total;
            $orderId = $order->order_id;
            $vendorId = $order->vendor_id;
            if (!isset($orderVendorData[$vendorId])) {
                $orderVendorData[$vendorId] = [
                    'vendor_id' => $vendorId,
                    'name' => $order->name,
                    'not_send' => 0,
                    'send' => 0,
                    'not_send_ids' => [],
                    'send_ids' => []
                ];
            }

            $orderVendorData[$vendorId][$isVendorPaymentSend ? 'send' : 'not_send'] += $wholeSaleTotal;
            $orderVendorData[$vendorId][($isVendorPaymentSend ? 'send_ids' : 'not_send_ids')][] = [
                'total' => $wholeSaleTotal,
                'date' => $order->created_at,
                'order_id' => $orderId,
                'uuid' => $order->uuid,
                'payment_id' => $order->vendor_payment_id
            ];
        }

        return collect($orderVendorData);
    }
}

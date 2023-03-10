<?php

namespace App\Services\Order;

use App\Cart\Cart;
use App\Facades\Order\OrderShippingDetails;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderVendor;
use App\Models\Product;
use App\Models\User;
use App\Services\Order\NewOrderService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function newOrder()
    {
        return (new NewOrderService());
    }

    public function updateTotalCalculation(Order $order)
    {
        $orderTotalCalculations = $order->items()->select([
            DB::raw("sum(total) as subtotal"),
            DB::raw("sum(wholesale_price_total) as wholesale_total"),
            DB::raw("sum(profit) as products_profit"),
            DB::raw("max(delivery_fee) as delivery_fee"),
        ])->first();

        $order->delivery_fee = is_null($orderTotalCalculations->delivery_fee) ? config('bibisena.default_delivery_fee') : $orderTotalCalculations->delivery_fee;
        $order->subtotal = $orderTotalCalculations->subtotal;
        $order->wholesale_total = $orderTotalCalculations->wholesale_total;
        $order->products_profit = $orderTotalCalculations->products_profit;
        $order->total_profit = $orderTotalCalculations->products_profit + $order->delivery_fee;
        $order->total = $order->subtotal + $order->delivery_fee;

        $order->save();

        return $order;
    }

    public function userOrder()
    {
        return new UserOrderService();
    }

    public function getManagerDeviceToken()
    {
        $users = User::whereIn('id', [1, 2, 4])->whereNotNull('device_token')->get()->pluck(['device_token'])->toArray();
        return $users;
    }

    public function getVendorDeviceToken($vendorId = null)
    {
        $users = User::whereIn('id', [$vendorId])->whereNotNull('device_token')->get()->pluck(['device_token'])->toArray();
        return $users;
    }

    public function updateOrderVendor(Order $order)
    {
        $items = $order->items()->get();

        $vendorData = [];


        foreach ($items as $item) {
            if (!isset($vendorData[$item->vendor_id])) {
                $vendorData[$item->vendor_id] = [
                    'total' => 0,
                    'wholesale_total' => 0,
                    'profit' => 0
                ];
            }

            $vendorData[$item->vendor_id]['total'] += $item->total;
            $vendorData[$item->vendor_id]['wholesale_total'] += $item->wholesale_price_total;
            $vendorData[$item->vendor_id]['profit'] += $item->profit;
        }

        foreach ($vendorData as $key => $data) {
            $vendor = $order->vendors()->where(['vendor_id' => $key])->first();
            if (!$vendor) {
                $vendor = OrderVendor::create([
                    'order_id' => $order->id,
                    'vendor_id' => $key,
                    'total' => $data['total'],
                    'wholesale_total' => $data['wholesale_total'],
                    'profit' => $data['profit']
                ]);
                $order->notify()->vendor("আপনার একটি নতুন অর্ডার এসেছে।", $vendor);
            } else {
                if ($vendor->total != $data['total'] || $vendor->wholesale_total != $data['wholesale_total'] || $vendor->profit != $data['profit']) {
                    $vendor->update([
                        'total' => $data['total'],
                        'wholesale_total' => $data['wholesale_total'],
                        'profit' => $data['profit']
                    ]);
                    $order->notify()->vendor("আপনার অর্ডারটিতে কিছু পরিবর্তন করা হয়েছে।", $vendor);
                }
            }
        }

        $extraVendor = $order->vendors()->whereNotIn('vendor_id', array_keys($vendorData))->get();

        foreach ($extraVendor as $key => $vendor) {
            $order->notify()->vendor("অর্ডারটি আপনার দোকান থেকে সরিয়ে ফেলা হয়েছে।", $vendor);
            $vendor->delete();
        }
    }
}

<?php

namespace App\Services\UpgradeSystem;

use App\Models\Order;
use App\Enums\OrderStatusEnum;

class UpgradeMultiVendorOrderService
{
    public function __construct()
    {
        $this->updateOrder();
    }

    public function updateOrder()
    {
        $orders = Order::where('vendor_id', '!=', null)->get();

        foreach ($orders as $order) {
            echo "\n==========================================================================";
            echo "\n--------------- Update Order : " . $order->id . " ------------------------";
            echo "\n==========================================================================\n";
            if ($order->vendor_id) {
                $this->updateVendor($order);
            }

            if ($order->is_delivery_complete) {
                $this->updateOrderStatus($order);
                $this->updateVendorStatus($order);
            }
        }
    }

    private function updateVendor(Order $order)
    {
        $this->startCmd("Update Vendor");
        $items = $order->items;
        foreach ($items as $item) {
            if($item->vendor_id)continue;
            $item->update([
                'vendor_id' => $order->vendor_id
            ]);
        }
        $order->updateVendor();

        $this->endCmd(count($items)." items vendor and assign vendor");
    }

    private function updateOrderStatus(Order $order)
    {
        $this->startCmd("Update Order Status");
        
        $order->update([
            'is_vendor_assign' => true,
            'is_pack_complete' => true,
            'is_delivery_start' => true,
            'is_vendor_payment_complete' => false,
            'status' => OrderStatusEnum::DELIVERY_COMPLETED
        ]);

        $this->endCmd("");
    }

    private function updateVendorStatus(Order $order)
    {
        $this->startCmd("Update Vendor Status");
        $vendors = $order->vendors;
        foreach ($vendors as $vendor) {
            if($vendor->is_received && $vendor->is_pack_complete)continue;
            $vendor->update([
                'is_received' => true,
                'is_pack_complete' => true,
            ]);
        }

        $this->updateOrderPaymentStatus($order);

        $this->endCmd("");
    }

    private function updateOrderPaymentStatus(Order $order)
    {
        if (!$order->vendors()->where(['is_vendor_payment_complete' => false])->exists()) {
            $order->update([
                'is_vendor_payment_complete' => true
            ]);
        }
    }

    private function startCmd($title){
        echo "\n =>$title \n----------------------\n - processing...\n";
    }

    private function endCmd($title){
        echo " - successfully done $title\n";
    }
}

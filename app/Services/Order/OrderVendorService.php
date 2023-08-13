<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Http\Requests\AssignProductVendorRequest;
use App\Models\Order;

class OrderVendorService
{

    public function updateAssignProductVendorList(AssignProductVendorRequest $request, Order $order)
    {
        if ($order->is_cancelled) {
            return response()->json([
                'message' => 'Order Already Cancelled'
            ], 400);
        }

        $productVendor = $request->product_vendor;
        $orderItems = $order->items()->whereIn('uuid', array_keys($productVendor))->get();

        if (count($order->items) != count($orderItems)) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        foreach ($orderItems as $orderItem) {
            $orderItem->update([
                'vendor_id' => $productVendor[$orderItem->uuid] ?? null
            ]);
        }

        $order->update([
            'is_vendor_assign' => true,
            'status' => OrderStatusEnum::ASSIGN_STORE
        ]);

        $order->notify()->admin("অর্ডারটি বিক্রেতার কাছে পাঠানো হয়েছে।");
        $order->notify()->customer("আপনার অর্ডারটির প্রস্তুতি চলছে।");

        $order->updateVendor();

        return response()->json([
            'message' => 'Successfully Vendor Assign'
        ]);
    }
}

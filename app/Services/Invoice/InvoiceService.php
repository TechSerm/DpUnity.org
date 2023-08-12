<?php

namespace App\Services\Invoice;

use App\Models\Order;

class InvoiceService
{
    public function isPrintable(Order $order)
    {
        return auth()->check() ? true : $this->isOrderPrintableForGuest($order);
    }

    private function isOrderPrintableForGuest(Order $order)
    {
        if ($order->is_cancelled) return false;
        return !$order->is_delivery_complete || !$order->is_delivery_start;
    }
}

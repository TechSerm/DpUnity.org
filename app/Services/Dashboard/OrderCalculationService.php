<?php

namespace App\Services\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderCalculationService
{

    private $startDate;
    private $endDate;
    private $vendorId;

    public function __construct()
    {
        $this->startDate = new Carbon(request()->start_date ??  Carbon::now()->startOfMonth());
        $this->endDate = new Carbon(request()->end_date ??  Carbon::now());
    }

    public function getOrderData()
    {
        return [
            'total_order' => $this->getTotalOrder(),
            'pending' => $this->getTotalPending(),
            'processing' => $this->getTotalProcessing(),
            'canceled' => $this->getTotalCancel(),
            'complete' => $this->getTotalComplete(),
            'vendor_payment_pending' => $this->getTotalVendorPaymentPending(),
            'vendor_payment_complete' => $this->getTotalVendorPaymentComplete(),
            'vendor_payment_send' => $this->getTotalVendorPaymentSend(),
        ];
    }

    private function getOrderQuery()
    {
        $query = Order::where([]);
        if (isset(request()->vendor) && request()->vendor != "") {
            $query->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
            $query->where(['order_vendors.vendor_id' => request()->vendor]);
            $query->select(DB::raw('orders.*, order_vendors.is_received, order_vendors.is_pack_complete as vendor_is_pack_complete, order_vendors.is_vendor_payment_complete as vendor_is_vendor_payment_complete, order_vendors.wholesale_total as vendor_wholesale_total'));
        }
        $query->whereBetween('orders.created_at', [$this->startDate->format('Y-m-d 00:00:00'), $this->endDate->format('Y-m-d 23:59:00')]);


        return $query;
    }

    public function getTotalOrder()
    {
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalPending()
    {
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_approved' =>  false, 'is_cancelled' =>  false])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalProcessing()
    {
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_approved' => true, 'is_cancelled' =>  false,  'is_delivery_complete' =>  false])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalComplete()
    {
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalVendorPaymentPending()
    {
        $orders = $this->getOrderQuery();
        if (!(isset(request()->vendor) && request()->vendor != "")) {
            $orders->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
            // $orders->select(DB::raw('orders.*,   order_vendors.wholesale_total as vendor_wholesale_total, order_vendors.wholesale_total as vendor_wholesale_total'));
        }

        return $this->getOrderShowFormat(
            $orders->where(['is_delivery_complete' =>  true, 'order_vendors.is_vendor_payment_send' =>  false, 'order_vendors.is_vendor_payment_complete' =>  false])->select(
                $this->getOrderSelectQuery("order_vendors.wholesale_total", true)
            )->first()
        );
    }

    public function getTotalVendorPaymentSend()
    {
        $orders = $this->getOrderQuery();
        if (!(isset(request()->vendor) && request()->vendor != "")) {
            $orders->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
        }

        return $this->getOrderShowFormat(
            $orders->where(['is_delivery_complete' =>  true, 'order_vendors.is_vendor_payment_send' =>  true, 'order_vendors.is_vendor_payment_complete' =>  false])->select(
                $this->getOrderSelectQuery("order_vendors.wholesale_total", true)
            )->first()
        );
    }

    public function getTotalVendorPaymentComplete()
    {
        $orders = $this->getOrderQuery();
        if (!(isset(request()->vendor) && request()->vendor != "")) {
            $orders->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
        }

        return $this->getOrderShowFormat(
            $orders->where(['order_vendors.is_vendor_payment_complete' =>  true])->select(
                $this->getOrderSelectQuery("order_vendors.wholesale_total", true)
            )->first()
        );
    }

    public function getTotalCancel()
    {
        return $this->getOrderShowFormat(
            $this->getOrderQuery()->where(['is_cancelled' =>  true])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    private function getOrderShowFormat($order)
    {
        if ($order->amount == 0 && $order->count == 0) return "-";
        return bnConvert()->number($order->amount) . " টাকা (" . bnConvert()->number($order->count) . ")";
    }

    private function getOrderSelectQuery($key, $isKeyImportant = false)
    {
        $orderType = request()->order_type;
        if (request()->vendor) {
            if($orderType == "subtotal")$orderType = "total";
            if($orderType != "delivery_fee")$orderType = 'order_vendors.' . $orderType;
        }
        if ($isKeyImportant == false) $key = $orderType != "" ? $orderType : "total";
        return DB::raw("SUM($key) as amount, COUNT(DISTINCT(orders.id)) as count");
    }
}

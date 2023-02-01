<?php 

namespace App\Services\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderCalculationService {
    
    private $startDate;
    private $endDate;
    private $vendorId;

    public function __construct()
    {
        $this->startDate = new Carbon(request()->start_date ??  Carbon::now()->startOfMonth());
        $this->endDate = new Carbon(request()->end_date ??  Carbon::now());
    }

    public function getOrderData(){
        return [
            'total_order' => $this->getTotalOrder(),
            'pending' => $this->getTotalPending(),
            'processing' => $this->getTotalProcessing(),
            'canceled' => $this->getTotalCancel(),
            'complete' => $this->getTotalComplete(),
            'vendor_payment_pending' => $this->getTotalVendorPaymentPending(),
            'vendor_payment_complete' => $this->getTotalVendorPaymentComplete(),
        ];
    }

    private function getOrderQuery(){
        $query = Order::whereBetween('created_at', [$this->startDate->format('Y-m-d 00:00:00'), $this->endDate->format('Y-m-d 23:59:00')]);
        if(isset(request()->vendor) && request()->vendor != ""){
            $query->where(['vendor_id' => request()->vendor]);
        }

        return $query;
    }

    public function getTotalOrder(){
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalPending(){
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_approved' =>  false, 'is_cancelled' =>  false])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalProcessing(){
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_approved' => true, 'is_cancelled' =>  false,  'is_delivery_complete' =>  false])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalComplete(){
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalVendorPaymentPending(){
        $orders = $this->getOrderQuery();
        return $this->getOrderShowFormat(
            $orders->where(['is_delivery_complete' =>  true, 'is_vendor_payment_complete' =>  false])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalVendorPaymentComplete(){
        return $this->getOrderShowFormat(
            $this->getOrderQuery()->where(['is_vendor_payment_complete' =>  true])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getTotalCancel(){
        return $this->getOrderShowFormat(
            $this->getOrderQuery()->where(['is_cancelled' =>  true])->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    private function getOrderShowFormat($order)
    {
        if($order->amount == 0 && $order->count == 0)return "-";
        return bnConvert()->number($order->amount) . " টাকা (" . bnConvert()->number($order->count) . ")";
    }

    private function getOrderSelectQuery($key)
    {
        $key = request()->order_type != "" ? request()->order_type : "total";
        return DB::raw("SUM($key) as amount, COUNT(id) as count");
    }

    
}
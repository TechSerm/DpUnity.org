<?php 

namespace App\Services\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitCalculationService {
    
    private $startDate;
    private $endDate;
    private $vendorId;

    public function __construct()
    {
        $this->startDate = new Carbon(request()->start_date ??  Carbon::now()->startOfMonth());
        $this->endDate = new Carbon(request()->end_date ??  Carbon::now());
    }

    public function getOrderProfitData(){
        return [
            'total_profit' => $this->getTotalProfit(),
            'product_profit' => $this->getTotalProductProfit(),
            'delivery_profit' => $this->getTotalDeliveryFee(),
            'profit_percent' => $this->getTotalProfitPercent()
        ];
    }

    private function getOrderProfitQuery(){
        $query = Order::where([]);
        if (isset(request()->vendor) && request()->vendor != "") {
            $query->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
            $query->where(['order_vendors.vendor_id' => request()->vendor]);
        }
        $query->whereBetween('orders.created_at', [$this->startDate->format('Y-m-d 00:00:00'), $this->endDate->format('Y-m-d 23:59:00')]);


        return $query;
    }

    public function getTotalProfit(){
        return $this->getOrderProfitShowFormat(
            $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery("total_profit")
            )->first()
        );
    }

    public function getTotalProductProfit(){
        $hasVendor = isset(request()->vendor) && request()->vendor != "";
        return $this->getOrderProfitShowFormat(
            $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery($hasVendor ? "profit":"products_profit")
            )->first()
        );
    }

    public function getTotalDeliveryFee(){
        return $this->getOrderProfitShowFormat(
            $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery("delivery_fee")
            )->first()
        );
    }

    public function getTotalProfitPercent(){
        $hasVendor = isset(request()->vendor) && request()->vendor != "";
        $productProfit = $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
            $this->getOrderSelectQuery($hasVendor ? "profit":"products_profit")
        )->first();

        $totalWholeSale = $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
            $this->getOrderSelectQuery($hasVendor ? "order_vendors.wholesale_total" : "wholesale_total")
        )->first();
        
        $percent = ($productProfit->amount * 100 )/($totalWholeSale->amount == 0 ? 1 : $totalWholeSale->amount);

        return bnConvert()->floatNumber($percent, 1) . '%';
    }

    private function getOrderProfitShowFormat($order)
    {
        return bnConvert()->number($order->amount) . " টাকা";
    }

    private function getOrderSelectQuery($key)
    {
        return DB::raw("SUM($key) as amount");
    }

    
}
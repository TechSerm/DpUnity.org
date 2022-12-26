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
        ];
    }

    private function getOrderProfitQuery(){
        $query = Order::whereBetween('created_at', [$this->startDate->format('Y-m-d 00:00:00'), $this->endDate->format('Y-m-d 23:59:00')]);
        if(isset(request()->vendor) && request()->vendor != ""){
            $query->where(['vendor_id' => request()->vendor]);
        }

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
        return $this->getOrderProfitShowFormat(
            $this->getOrderProfitQuery()->where(['is_delivery_complete' =>  true])->select(
                $this->getOrderSelectQuery("products_profit")
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

    private function getOrderProfitShowFormat($order)
    {
        return bnConvert()->number($order->amount) . " টাকা";
    }

    private function getOrderSelectQuery($key)
    {
        return DB::raw("SUM($key) as amount");
    }

    
}
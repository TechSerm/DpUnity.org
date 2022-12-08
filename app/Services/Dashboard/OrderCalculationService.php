<?php 

namespace App\Services\Dashboard;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderCalculationService {
    
    private $startDate;
    private $endDate;
    private $vendorId;
    private $orders;

    public function __construct()
    {
        $this->startDate = new Carbon(request()->start_date ??  Carbon::now()->startOfMonth());
        $this->endDate = new Carbon(request()->end_date ??  Carbon::now());
        $this->orders =  Order::whereBetween('created_at', [$this->startDate->format('Y-m-d 00:00:00'), $this->endDate->format('Y-m-d 23:59:00')]);
       // dd($this->orders->toSql(), $this->startDate, $this->endDate);
    }

    public function getOrderData(){
        return [
            'total_order' => $this->getTotalOrder(),
        ];
    }

    public function getTotalOrder(){
        return $this->getOrderShowFormat(
            $this->orders->select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    private function getOrderShowFormat($order)
    {
        return $order->amount . " (" . $order->count . ")";
    }

    private function getOrderSelectQuery($key)
    {
        return DB::raw("SUM($key) as amount, COUNT(id) as count");
    }

    
}
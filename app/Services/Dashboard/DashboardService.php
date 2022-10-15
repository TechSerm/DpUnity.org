<?php

namespace App\Services\Dashboard;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getDashboardData()
    {
        return [
            'totalProduct' => $this->getTotalProduct(),
            'totalActiveProduct' => $this->getTotalPublishProduct(),
            'totalCategory' => $this->getTotalCategory(),
            'totalOrder' => $this->getTotalOrder()
        ];
    }

    public function getTotalProduct()
    {
        return Product::count();
    }

    public function getTotalPublishProduct()
    {
        return Product::where(['status' => 'publish'])->count();
    }

    public function getTotalCategory()
    {
        return Category::count();
    }

    public function getTotalOrder()
    {
        return $this->getOrderShowFormat(
            Order::select(
                $this->getOrderSelectQuery("total")
            )->first()
        );
    }

    public function getOrderSelectQuery($key)
    {
        return DB::raw("SUM($key) as amount, COUNT(id) as count");
    }

    public function getOrderShowFormat($order)
    {
        return $order->amount . " (" . $order->count . ")";
    }
}

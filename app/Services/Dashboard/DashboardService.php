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
        $orderService = new OrderCalculationService();
        
        return [
            'totalProduct' => $this->getTotalProduct(),
            'totalActiveProduct' => $this->getTotalPublishProduct(),
            'totalCategory' => $this->getTotalCategory(),
            'totalOrder' => $orderService->getTotalOrder()
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
}

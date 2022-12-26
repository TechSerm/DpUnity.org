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
        $orderCalculationService = new OrderCalculationService();
        $orderProfitCalculationService = new ProfitCalculationService();
        
        return [
            'totalProduct' => $this->getTotalProduct(),
            'totalActiveProduct' => $this->getTotalPublishProduct(),
            'totalCategory' => $this->getTotalCategory(),
            'order' => $orderCalculationService->getOrderData(),
            'profit' => $orderProfitCalculationService->getOrderProfitData(),
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

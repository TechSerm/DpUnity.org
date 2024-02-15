<?php

namespace App\Services\Dashboard;

use App\Models\Brand;
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
            'totalBrand' => $this->getTotalBrand(),
            'totalHotDealProducts' => $this->getTotalHotDealProducts(),
        ];
    }

    private function getProductQuery(){
        $query = Product::where([]);
        return $query;
    }

    public function getTotalProduct()
    {
        return $this->getProductQuery()->count();
    }

    public function getTotalPublishProduct()
    {
        return $this->getProductQuery()->active()->count();
    }

    public function getTotalCategory()
    {
        return Category::count();
    }

    public function getTotalBrand()
    {
        return Brand::count();
    }

    public function getTotalHotDealProducts()
    {
        return $this->getProductQuery()->hotDeals()->count();
    }
}

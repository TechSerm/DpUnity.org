<?php

namespace App\Services\Cache;

use App\Services\HomePageProduct\HomePageProductService;

class HomePageProductCacheService extends CacheService
{
    protected $cacheKey = "home_page_products";
    protected $cacheTime = "120";

    protected function data()
    {
        $homePageProductService = new HomePageProductService();
        return $homePageProductService->getProductCollection();
    }
}

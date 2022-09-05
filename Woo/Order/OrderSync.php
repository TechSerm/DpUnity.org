<?php

namespace Woo\Order;

use App\Services\Order\OrderService;
use App\Services\WooCommerce\WooCommerceService;

class OrderSync
{

    protected $woocommerce;
    protected $orderService;

    public function __construct()
    {
        $this->woocommerce = WooCommerceService::connect();
        $this->orderService = new OrderService();
    }

    public function syncAllOrder($pageNo = 1)
    {
        $orders = $this->getWooOrderPageData($pageNo);

        if (empty($orders)) return;

        foreach ($orders as $order) {
            if (!$this->syncOrder($order)) return;
        }

        $this->syncAllOrder($pageNo + 1);
    }

    public function getWooOrderPageData($pageNo)
    {
        return $this->woocommerce->get("orders?page=" . $pageNo);
    }

    public function syncOrder($wooData)
    {
        $order = $this->orderService->create($wooData);
        return empty($order) ? false : true;
    }
}

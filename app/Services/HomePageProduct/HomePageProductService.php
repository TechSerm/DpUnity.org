<?php

namespace App\Services\HomePageProduct;

use App\Models\HomePageProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomePageProductService
{
    public function get()
    {
        $mxSerialNo = HomePageProduct::max('serial_no') + 1;

        $products = Product::with(['imageTable'])->leftJoin('home_page_products', function ($join) {
            $join->on('products.id', '=', 'home_page_products.product_id');
        })->leftJoin($this->getOrderSaleQueryTable(), function ($join) {
            $join->on('products.id', '=', 'sale_count_table.product_id');
        })->select([
            'products.*',
            DB::raw('IFNULL(serial_no, ' . $mxSerialNo . ') as serial_no'),
            DB::raw('IFNULL(total_sale , 0) as total_sale')
        ])->orderByRaw('serial_no asc, total_sale desc')->paginate(6);

        return $products;
    }

    public function getOrderSaleQueryTable()
    {
        return DB::raw("(select order_items.product_id, sum(quantity) as total_sale from order_items JOIN orders on orders.id = order_items.order_id WHERE orders.is_delivery_complete=true GROUP by order_items.product_id order by total_sale desc) sale_count_table");
    }
}

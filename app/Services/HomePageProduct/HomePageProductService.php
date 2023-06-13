<?php

namespace App\Services\HomePageProduct;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\HomePageProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomePageProductService
{
    public function get()
    {
        $mxSerialNo = HomePageProduct::max('serial_no') + 1;

        $products = [];
        $productsId = [];

        $topProducts = Product::with(['imageTable'])->where(['status' => 'publish', 'has_stock' => true])->leftJoin('home_page_products', function ($join) {
            $join->on('products.id', '=', 'home_page_products.product_id');
        })->leftJoin($this->getOrderSaleQueryTable(), function ($join) {
            $join->on('products.id', '=', 'sale_count_table.product_id');
        })->select([
            'products.*',
            DB::raw('IFNULL(serial_no, ' . $mxSerialNo . ') as serial_no'),
            DB::raw('IFNULL(total_sale , 0) as total_sale')
        ])->orderByRaw('serial_no asc, total_sale desc')->limit(18)->get();

        foreach ($topProducts as $key => $product) {
            if ($key == 0) $product->category_name = "জনপ্রিয় পণ্য";
            $products[] = $product;
            $productsId[] = $product->id;
        }

        $categories = Category::with(['products' => function ($query) {
            $query->where('has_stock', true);
            $query->where('status', 'publish');
            $query->orderBy('serial', 'asc');
        }, 'products.imageTable'])->get();
        foreach ($categories as $category) {
            $categoryProducts = $category->products;
            foreach ($categoryProducts as $key => $product) {
                if ($key == 0) $product->category_name = $category->name;
                $products[] = $product;
                $productsId[] = $product->id;
            }
        }

        $allProducts = Product::whereNotIn('id', $productsId)->where(['has_stock' => true, 'status' => 'publish'])->with(['imageTable'])->get();
        foreach ($allProducts as $key => $product) {
            if ($key == 0) $product->category_name = 'ক্যাটাগরি বিহীন';
            $products[] = $product;
        }

        $products = collect($products);

        return new LengthAwarePaginator(
            $products->forPage(request()->page, 12),
            $products->count(),
            12,
            request()->page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        // return collect($products)->paginate();
    }

    public function getOrderSaleQueryTable()
    {
        return DB::raw("(select order_items.product_id, sum(quantity) as total_sale from order_items JOIN orders on orders.id = order_items.order_id WHERE orders.is_delivery_complete=true GROUP by order_items.product_id order by total_sale desc) sale_count_table");
    }
}

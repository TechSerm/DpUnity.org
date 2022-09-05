<?php

namespace App\Services\Product;

use App\Services\WooCommerce\WooCommerceService;
use App\Models\Product;

class ProductService
{

    private $woocommerce;

    public function __construct(WooCommerceService $wooCommerceService)
    {
        $this->woocommerce = $wooCommerceService->connect();
    }

    public function createProduct($wooProductId)
    {
        $product = Product::where(['woo_id' => $wooProductId])->first();
        if ($product) return $product;

        $productData = $this->getWooProduct($wooProductId);
        return Product::create([
            'woo_id' => $productData->id,
            'woo_product_details' => json_encode($productData)
        ]);
    }

    public function updateProductWholesalePrice(Product $product, $wholesalePrice, $profit = null)
    {
        $profit = $profit ?? $product->profit;
        $newPrice = $profit + $wholesalePrice;

        $wooProductData = $product->woo_product_details;
        $updatedWooData = $this->updateWooProduct($product->woo_id, ['regular_price' => (string)$newPrice]);

        if (!empty($updatedWooData)) {
            $wooProductData->price = $newPrice;

            $product->update([
                'woo_product_details' => json_encode($wooProductData),
                'wholesale_price' => $wholesalePrice,
                'profit' => $profit
            ]);
            return true;
        }

        return false;
    }

    public function getWooProduct($wooProductId)
    {
        return $this->woocommerce->get('products/' . $wooProductId);
    }

    public function updateWooProduct($wooProductId, $data)
    {
        return $this->woocommerce->put('products/' . $wooProductId, $data);
    }
}

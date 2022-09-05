<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderService
{
    public function create($wooData)
    {
        if (Order::where(['woo_id' => $wooData->id])->exists()) return [];

        $order = Order::create([
            'woo_id' =>  $wooData->id,
            'total' =>  $wooData->total,
            'discount_total' =>  $wooData->discount_total,
            'shipping_total' =>  $wooData->shipping_total,
            'customer_name' => isset($wooData->meta_data[0]) ? $wooData->meta_data[0]->value : '',
            'customer_address' =>  $wooData->billing->address_1,
            'customer_area' =>  $wooData->billing->state,
            'customer_phone' =>  $wooData->billing->phone,
            'customer_ip_address' =>  $wooData->customer_ip_address,
            'customer_user_agent' =>  $wooData->customer_user_agent,
            'order_date' =>  $wooData->date_created,
            'status' => 'pending'
        ]);

        $this->createItems($order, $wooData->line_items);

        return $order;
    }

    public function createItems(Order $order, $items)
    {

        $totalWholesalePrice = 0;
        $totalProfit = 0;
        $subtotal = 0;

        foreach ($items as $item) {
            $product = Product::where(['woo_id' => $item->product_id])->first();
            $wholesalePrice = $product ? $product->wholesale_price : $item->price;
            $profit =  $this->profitCalculation($item->price, $wholesalePrice, $item->quantity);

            $subtotal += $item->price * $item->quantity;
            $totalWholesalePrice += $wholesalePrice * $item->quantity;
            $totalProfit += $profit;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product ? $product->id : null,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->total,
                'wholesale_price' => $wholesalePrice,
                'wholesale_price_last_update' => $product ? $product->wholesale_price_last_update : null,
                'profit' => $profit
            ]);
        }

        $order->update([
            'wholesale_total' => $totalWholesalePrice,
            'profit' => $totalProfit,
            'subtotal' => $subtotal
        ]);
    }

    public function profitCalculation($price, $wholesalePrice, $quantity)
    {
        return ($price * $quantity) - ($wholesalePrice * $quantity);
    }
}

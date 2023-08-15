<?php

namespace App\Services\Order\OrderCreation;

use App\Cart\Cart;
use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderShippingDetails;
use App\Models\Order;

class OrderCreationService
{
    private OrderValidationService $orderValidationService;
    private OrderItemCreationService $orderItemCreationService;

    public function __construct(OrderValidationService $orderValidationService, OrderItemCreationService $orderItemCreationService)
    {
        $this->orderValidationService = $orderValidationService;
        $this->orderItemCreationService = $orderItemCreationService;
    }

    /**
     * @param array $orderData
     * @param $productList
     * @return void
     */
    public function create($orderData, $productList)
    {
        $responseValidate = $this->orderValidationService->validate($orderData, $productList);
        if (!empty($responseValidate)) {
            return response()->json($responseValidate, 422);
        }

        $orderData = array_merge($orderData, [
            'total' => Cart::totalPrice(),
            'discount_total' => 0,
            'delivery_fee' => Cart::getDeliveryFee(),
            'status' => OrderStatusEnum::PENDING,
        ]);

        $order = Order::create($orderData);
        $this->orderItemCreationService->create($order, $productList);

        $this->createItems($order);
        $this->createStatus($order);
        $order = $order->updateTotalCalculation();
        $order->addCookie();
        $this->sendOrderNotification($order);

        return response()->json([
            'message' => 'অর্ডার করার জন্য আপনাকে অভিনন্দন।',
            'url' => route('store.order.show', ['uuid' => $order->uuid])
        ]);
    }
}

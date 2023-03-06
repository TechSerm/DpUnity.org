<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Http\Requests\OrderItemRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Search\SearchService;
use App\Services\Vendor\VendorService;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getProductSelect2Data()
    {

        $products = SearchService::getSearchProduct(request()->q)->get();

        $products = $products->map(function ($product) {
            $product->price = bnConvert()->number($product->price, true);
            $product->quantity = bnConvert()->number($product->quantity);
            $product->unit = bnConvert()->unit($product->unit);
            return $product->only(['id', 'name', 'image', 'price', 'quantity', 'unit']);
        });

        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($orderId)
    {
        return view('order.show.order_item.create_primary');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderItemRequest $request, $orderId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }
        $orderItem = $order->items()->where(['product_id' => $request->product_id])->first();
        if ($orderItem) {
            return response()->json([
                'message' => 'Product already added'
            ], 419);
        }

        $product = Product::where(['id' => $request->product_id])->firstOrFail();

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product ? $product->id : null,

            'name' => $request->name,
            'unit' => $request->unit,
            'unit_quantity' => $request->unit_quantity,

            'quantity' => $request->quantity,
            'price' => $request->price,
            'wholesale_price' => $request->wholesale_price,
            'total' => $request->total,
            'wholesale_price_total' => $request->wholesale_price_total,
            'profit' => $request->profit,
            'delivery_fee' => $request->delivery_fee,
            'vendor_id' => $request->vendor_id
        ]);

        $order->updateTotalCalculation();

        $order->updateVendor();

        // activity()
        // ->performedOn($order)
        // ->log('New product added');

        if ($order->is_vendor_assign) {
            $order->updateVendor();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function productCreateForm($orderId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $orderItem = $order->items()->where(['product_id' => request()->product_id])->first();

        if ($orderItem) {
            return redirect()->route('order_items.edit', array_merge(request()->route()->parameters(), [
                'order_item' => $orderItem->uuid,
                'already_exists' => true
            ]));
        }

        $product = Product::where(['id' => request()->product_id])->firstOrFail();
        return view('order.show.order_item.create', [
            'order' => $order,
            'item' => $product,
            'units' => Constant::UNITS,
            'vendors' => (new VendorService())->getList()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($orderId,  $orderItemId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();

        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $orderItem = $order->items()->where(['uuid' => $orderItemId])->firstOrFail();
        return view('order.show.order_item.edit', [
            'order' => $order,
            'item' => $orderItem,
            'units' => Constant::UNITS,
            'vendors' => (new VendorService())->getList()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderItemRequest $request, $orderId,  $orderItemId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();

        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $orderItem = $order->items()->where(['uuid' => $orderItemId])->firstOrFail();

        $orderItem->update($request->except(['product_id']));

        $order->updateTotalCalculation();

        if ($order->is_vendor_assign) {
            $order->updateVendor();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($orderId,  $orderItemId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();

        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $orderItem = $order->items()->where(['uuid' => $orderItemId])->firstOrFail();

        $orderItem->delete();
        $order->updateTotalCalculation();
        if ($order->is_vendor_assign) {
            $order->updateVendor();
        }
    }
}

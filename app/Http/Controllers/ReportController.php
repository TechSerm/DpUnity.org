<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Facades\Dashboard\DashboardFacade;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class ReportController extends Controller
{
    public function overview()
    {
        return view('report.overview', DashboardFacade::getDashboardData());
    }

    public function product(Request $request)
    {

        $completedOrderQuery = Order::where('status', OrderStatusEnum::COMPLETED)
            ->with('items.product');

        if ($request->start_date && $request->end_date) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $completedOrderQuery->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($request->start_date) {
            $start_date = $request->input('start_date');
            $completedOrderQuery->where('created_at', '>=', $start_date);
        } elseif ($request->end_date) {
            $end_date = $request->input('end_date');
            $completedOrderQuery->where('created_at', '<=', $end_date);
        }

        $completedOrders = $completedOrderQuery->get();

        $products = $completedOrders->flatMap(function ($order) {
            return $order->items->map(function ($orderItem) {
                return [
                    'product' => $orderItem->product,
                    'product_id' => $orderItem->product->id,
                    'product_name' => $orderItem->product->name,
                    'total_quantity_sold' => $orderItem->quantity,
                    'total_amount_sold' => $orderItem->total,
                ];
            });
        });

        $products = $products->groupBy('product_id')
            ->map(function ($items) {
                return (object)[
                    'product' => $items[0]['product'],
                    'total_quantity_sold' => $items->sum('total_quantity_sold'),
                    'total_amount_sold' => $items->sum('total_amount_sold'),
                ];
            })->sortByDesc('total_amount_sold')
            ->values();

        if ($request->has('category')) {
            $category = Category::where('id', $request->category)->first();
            if ($category) {
                $productIds = $category->products->pluck('id')->toArray();
                $products = $products->filter(function ($item) use ($products, $productIds) {
                    return in_array($item->product->id, $productIds);
                });
            }
        }

        $page = request('page', 1);
        $perPage = 10;

        $offset = ($page - 1) * $perPage;
        $currentPageItems = array_slice($products->toArray(), $offset, $perPage);

        $products = new LengthAwarePaginator(
            $currentPageItems,
            count($products),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $categories = Category::all();

        return view('report.product', compact('products', 'categories'));
    }

    public function orders(Request $request)
    {
        $orderQuery = Order::where([]);

        if ($request->start_date && $request->end_date) {
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $orderQuery->whereBetween('created_at', [$start_date, $end_date]);
        } elseif ($request->start_date) {
            $start_date = $request->input('start_date');
            $orderQuery->where('created_at', '>=', $start_date);
        } elseif ($request->end_date) {
            $end_date = $request->input('end_date');
            $orderQuery->where('created_at', '<=', $end_date);
        }

        if ($request->status) {
            $orderQuery->where('status', '=', strtolower($request->status));
        }
        $ordersCount = $orderQuery->get();
        $orders = $orderQuery->orderBy('id', 'desc')->paginate(10);
        

        $totalOrder = $orderQuery->count();
        $totalSuccessfullOrder = $ordersCount->where('status', '=', OrderStatusEnum::COMPLETED)->count();
        $totalProcessingOrder = $ordersCount->where('status', '=',  OrderStatusEnum::PROCESSING)->count();
        $totalCanceledOrder = $ordersCount->where('status', '=', OrderStatusEnum::CANCELED)->count();

        $orderStatus = OrderStatusEnum::asSelectArray();

        return view('report.orders', compact('orders', 'orderStatus', 'totalOrder', 'totalSuccessfullOrder', 'totalProcessingOrder', 'totalCanceledOrder' ));
    }
}

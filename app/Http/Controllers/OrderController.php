<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Facades\Order\OrderFacade;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Http\Requests\AssignProductVendorRequest;
use App\Http\Requests\OrderCustomerUpdateRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\Order\OrderNotificationService;
use App\Services\Order\OrderService;
use App\Services\Order\OrderStatusService;
use App\Services\Order\OrderVendorService;
use App\Services\Vendor\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Facades\CauserResolver;
use Woo\Order\OrderSync;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    private OrderStatusService $orderStatusService;
    private OrderVendorService $orderVendorService;

    public function __construct(OrderStatusService $orderStatusService, OrderVendorService $orderVendorService)
    {
        $this->middleware('order_show_page_check', ['only' => ['show']]);
        $this->orderStatusService = $orderStatusService;
        $this->orderVendorService = $orderVendorService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    public function activeOrders()
    {
        $this->authorize('active_orders.index');
        $orders = Order::where(['is_cancelled' => false]);
        if (auth()->user()->isVendor()) {
            $orders->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
            $orders->where(['order_vendors.vendor_id' => auth()->user()->id]);
            $orders->where(['order_vendors.is_vendor_payment_complete' => false]);
        } else {
            $orders->where(['is_vendor_payment_complete' => false]);
        }

        if (auth()->user()->isVendor()) {
            $orders->select(DB::raw('orders.*, order_vendors.is_received, order_vendors.is_pack_complete as vendor_is_pack_complete, order_vendors.wholesale_total as vendor_wholesale_total'));
        } else {
            $orders->select(DB::raw('orders.*'));
        }

        return view('order.active_orders', ['orders' => $orders->orderBy('id', 'desc')->get()]);
    }

    public function getData(Request $request)
    {
        $orderQuery = Order::where([]);
        if (auth()->user()->isVendor()) {
            $orderQuery->leftJoin('order_vendors', 'orders.id', '=', 'order_vendors.order_id');
            $orderQuery->where(['order_vendors.vendor_id' => auth()->user()->id]);
        }


        if (auth()->user()->isVendor()) {
            $orderQuery->select(DB::raw('orders.*, order_vendors.is_received, order_vendors.is_pack_complete as vendor_is_pack_complete, order_vendors.wholesale_total as vendor_wholesale_total'));
        } else {
            $orderQuery->select(DB::raw('orders.*'));
        }


        if (!request()->get('order')) {
            $orderQuery = $orderQuery->orderBy('id', 'desc');
        }

        return Datatables::of($orderQuery)
            ->filter(function ($query) use ($request) {
            })
            ->editColumn('name', function ($model) {
                return '<span style="font-size: 12px; font-weight: bold; display:block;">' . $model->name . '</span>';
            })
            ->editColumn('phone', function ($model) {
                return '<span class="badge">' . $model->phone . '</span>';
            })
            ->editColumn('id', function ($model) {
                return bnConvert()->number($model->id);
            })
            ->editColumn('subtotal', function ($model) {
                return $this->addPriceLabel($model->subtotal);
            })
            ->editColumn('delivery_fee', function ($model) {
                return $this->addPriceLabel($model->delivery_fee);
            })
            ->editColumn('total', function ($model) {
                return $this->addPriceLabel($model->total);
            })
            ->editColumn('wholesale_total', function ($model) {
                $total = auth()->user()->isVendor() ? $model->vendor_wholesale_total : $model->wholesale_total;
                return $this->addPriceLabel($total);
            })
            ->editColumn('delivery_fee', function ($model) {
                return $this->addPriceLabel($model->delivery_fee);
            })
            ->editColumn('products_profit', function ($model) {
                return $this->addPriceLabel($model->products_profit);
            })
            ->editColumn('created_at', function ($model) {
                return "<span style='font-size: 12px'>" . $model->created_at->format('d M Y H:i:s') . " (" . $model->created_at->diffForHumans() . ")</span>";
            })
            ->editColumn('status', function ($model) {
                $statusColor = $model->status_color;
                return "<span class = 'badge' style='background-color: $statusColor; color: #ffffff'>" . $model->status_bn_name . "</span>";
            })

            ->addColumn('action', function ($model) {

                $content = "<a href='" . route('orders.show', ['order' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' ><i class='fa fa-eye'></i> View</a>";

                return $content;
            })
            ->make(true);
    }

    private function addPriceLabel($price)
    {
        return '<span class="badge"><span style="font-size: 14px;">' . bnConvert()->number($price) . '</span><span style="color:#636e72;"> ৳ </span></span>';
    }

    public function show(Order $order)
    {
        $order->activityLogService()->createShowActivity();

        return view('order.show', compact('order'));
    }

    public function history($id)
    {
        $order = Order::with(['items'])->findOrFail($id);
        return view('order.show.activity', ['order' => $order]);
    }

    public function showUpdateCustomer(Order $order)
    {
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        return view('order.show.update_customer', compact('order'));
    }

    public function updateCustomer(OrderCustomerUpdateRequest $request, Order $order)
    {
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $order->update($request->only('name', 'phone', 'address'));

        return response()->json([
            'message' => 'Customer Update Successfully'
        ]);
    }

    public function changeOrderStatus(Order $order, $status)
    {
        return $this->orderStatusService->changeOrderStatus($order, $status);
    }

    public function printOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('order.show.print_order', ['order' => $order]);
    }

    public function assignProductVendorList(Order $order, VendorService $vendorService)
    {
        return view('order.show.product_vendor_list', [
            'order' => $order,
            'vendors' => $vendorService->getList()
        ]);
    }

    public function updateAssignProductVendorList(AssignProductVendorRequest $request, Order $order)
    {
        return $this->orderVendorService->updateAssignProductVendorList($request, $order);
    }
}

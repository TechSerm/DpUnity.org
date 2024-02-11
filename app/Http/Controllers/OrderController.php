<?php

namespace App\Http\Controllers;

use App\Enums\OrderPaymentStatusEnum;
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

        $status = $request->ref;

        if(OrderStatusEnum::hasValue($status)) {
            $orderQuery->where(['status' => $status]);
        }

        
        if (!request()->get('order')) {
            $orderQuery = $orderQuery->orderBy('id', 'desc');
        }

        return Datatables::of($orderQuery)
            ->filter(function ($query) use ($request) {
            })
            

            ->editColumn('total', function ($model) {
                return $this->addPriceLabel($model->total);
            })

            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d M Y H:i:s') . " (" . $model->created_at->diffForHumans() . ")</span>";
            })
            ->editColumn('status', function ($model) {
                return $model->status->badge();
            })
            ->editColumn('payment_status', function ($model) {
                return $model->payment_status->badge();
            })

            ->addColumn('action', function ($model) {
                $content = "<a href='" . route('orders.show', ['order' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' ><i class='fa fa-eye'></i> View</a>";

                return $content;
            })
            ->make(true);
    }

    private function addPriceLabel($price)
    {
        return $price;
    }

    public function show(Order $order)
    {
        return view('order.show', compact('order'));
    }

    public function history($id)
    {
        $order = Order::with(['items'])->findOrFail($id);
        return view('order.show.activity', ['order' => $order]);
    }

    public function showUpdateCustomer(Order $order)
    {
        $orderStatus = OrderStatusEnum::asSelectArray();
        $orderPaymentStatus = OrderPaymentStatusEnum::asSelectArray();
        return view('order.show.update_customer', compact('order','orderStatus', 'orderPaymentStatus'));
    }

    public function updateCustomer(OrderCustomerUpdateRequest $request, Order $order)
    {
        $fields = ['name', 'phone', 'address','delivery_fee'];
        if(isset($request->status) && OrderStatusEnum::hasValue($request->status) && !$order->isOrderStatusDisabled()) {
            array_push($fields, "status");
        }

        if(isset($request->payment_status) && OrderPaymentStatusEnum::hasValue($request->payment_status)) {
            array_push($fields, "payment_status");
        }

        $order->update($request->only($fields));

        $order->updateTotalCalculation();

        return response()->json([
            'message' => 'Successfully Updated Order'
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

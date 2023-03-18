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
use App\Services\Vendor\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Woo\Order\OrderSync;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('order_show_page_check', ['only' => ['show']]);
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $order = Order::with(['items'])->findOrFail($id);
        return view('order.show', ['order' => $order]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
    }

    public function updateStatus()
    {
    }

    public function showUpdateCustomer($id)
    {
        $order = Order::findOrFail($id);
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }
        return view('order.show.update_customer', ['order' => $order]);
    }

    public function updateCustomer(OrderCustomerUpdateRequest $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }
        $order->update($request->all());
        return response()->json([
            'message' => 'Customer Update Successfully'
        ]);
    }

    public function changeOrderStatus($orderId, $status)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();

        $orderNotificationService = new OrderNotificationService($order);

        if ($order->is_cancelled) {
            return response()->json([
                'message' => 'Order Already Cancelled'
            ], 400);
        }

        if ($status == 'approved') {
            $order->update([
                'is_approved' => true,
                'status' => OrderStatusEnum::APPROVED
            ]);
            $order->notify()->admin("অর্ডারটি গ্রহণ করা হয়েছে।");
            $order->notify()->customer("আপনার অর্ডারটি গ্রহণ করা হয়েছে।");
        }

        if ($status == 'pack_complete') {
            $order->update([
                'is_pack_complete' => true,
                'status' => OrderStatusEnum::PACK_COMPLETE
            ]);
            $order->notify()->admin("অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে।");
            $order->notify()->customer("আপনার অর্ডারটির প্রস্তুতি সম্পন্ন হয়েছে।");
        }

        if ($status == 'start_delivery') {
            $order->update([
                'is_delivery_start' => true,
                'status' => OrderStatusEnum::START_DELIVERY
            ]);
            $order->notify()->admin("অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।");
            $order->notify()->allVendors("অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।");
            $order->notify()->customer("আপনার অর্ডারটির ডেলিভারির জন্য রওনা হয়েছে।");
        }

        if ($status == 'delivery_complete') {
            $order->update([
                'is_delivery_complete' => true,
                'status' => OrderStatusEnum::DELIVERY_COMPLETED
            ]);
            $order->notify()->admin("অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।");
            $order->notify()->allVendors("অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।");
            $order->notify()->customer("আপনার অর্ডারটির ডেলিভারি টি সম্পন্ন হয়েছে।");
        }

        if ($status == 'canceled') {
            $order->update([
                'is_cancelled' => true,
                'status' => OrderStatusEnum::CANCELED
            ]);
            $order->notify()->admin("অর্ডারটি বাতিল করা হয়েছে।");
            $order->notify()->allVendors("অর্ডারটি বাতিল করা হয়েছে।");
            $order->notify()->customer("আপনার অর্ডারটি বাতিল করা হয়েছে।");
        }

        // activity()
        // ->performedOn($order)
        // ->log('Order status has been edited. New status: '. $status);

        if (isset(request()->vendor)) {
            $orderVendor = $order->vendors()->where(['uuid' => request()->vendor])->first();
            if ($orderVendor) {
                $orderVendorData = [];
                $notifyMessage = "";
                if ($status == 'vendor_received') {
                    $orderVendorData['is_received'] = true;
                    $notifyMessage = "Vendor Approved";
                    $notifyMessage = $orderVendor->user->name . " অর্ডারটি গ্রহণ করেছে";
                } else if ($status == 'vendor_pack_complete') {
                    $orderVendorData['is_pack_complete'] = true;
                    $notifyMessage = $orderVendor->user->name . " এর প্রস্তুতি সম্পন্ন হয়েছে";
                }
                $orderVendor->update($orderVendorData);
                if ($notifyMessage != "") $order->notify()->Admin($notifyMessage);
            }
        }


        return response()->json([
            'message' => 'Successfully Change Status'
        ]);
    }

    public function showVendor($orderId)
    {
        $order = Order::findOrFail($orderId);
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $vendors = User::where(['role_name' => 'vendor'])->get()->pluck('name', 'id')->toArray();

        return view('order.show.vendor_add_form', [
            'order' => $order,
            'vendors' => $vendors
        ]);
    }

    public function printOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('order.show.print_order', ['order' => $order]);
    }

    public function assignProductVendorList($orderId)
    {
        $order = Order::findOrFail($orderId);
        $vendors = (new VendorService())->getList();
        return view('order.show.product_vendor_list', [
            'order' => $order,
            'vendors' => $vendors
        ]);
    }

    public function updateAssignProductVendorList(AssignProductVendorRequest $request, $orderId)
    {
        $productVendor = $request->product_vendor;
        $order = Order::findOrFail($orderId);

        if ($order->is_cancelled) {
            return response()->json([
                'message' => 'Order Already Cancelled'
            ], 400);
        }

        $orderItems = $order->items()->whereIn('uuid', array_keys($productVendor))->get();

        if (count($order->items) != count($orderItems)) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        foreach ($orderItems as $orderItem) {
            $orderItem->update([
                'vendor_id' => $productVendor[$orderItem->uuid] ?? null
            ]);
        }

        $order->update([
            'is_vendor_assign' => true,
            'status' => OrderStatusEnum::ASSIGN_STORE
        ]);

        $order->notify()->admin("অর্ডারটি বিক্রেতার কাছে পাঠানো হয়েছে।");
        $order->notify()->customer("আপনার অর্ডারটির প্রস্তুতি চলছে।");

        $order->updateVendor();


        return response()->json([
            'message' => 'Successfully Vendor Assign'
        ]);
    }

    public function updateVendor(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if (!$order->isEditable()) {
            return response()->json([
                'message' => 'Invalid Action'
            ], 401);
        }

        $vendor = User::where(['id' => $request->vendor_id])->first();
        $order->update([
            'vendor_id' => $vendor->id ?? null
        ]);

        return response()->json([
            'message' => 'Vendor Update Successfully'
        ]);
    }
}

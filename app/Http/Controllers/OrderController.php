<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Models\Order;
use Illuminate\Http\Request;

use Woo\Order\OrderSync;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('order.index');
    }

    public function getData(Request $request)
    {
        $orderQuery = Order::where([]);

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
                return $this->addPriceLabel($model->wholesale_total);
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
                $statusColor = $model->status == 'pending' ? 'danger' : 'warning';
                return "<span class = 'badge badge-{$statusColor}'>" . $model->status_bn_name . "</span>";
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
        //$test = 'ADMIN';
        // dd(OrderStatusEnum::PENDING);
        // dd(OrderStatusEnum::fromValue('pending')->bnName());
        $order = Order::findOrFail($id);
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
        return view('order.show.update_customer', ['order' => $order]);
    }

    public function showUpdateCustomerDetails($id, Request $request)
    {
        $order = Order::findOrFail($id);
        return view('order.show.update_customer', ['order' => $order]);
    }

    public function changeOrderStatus($orderId, $orderStatusId)
    {
        $order = Order::where(['id' => $orderId])->firstOrFail();
        $orderStatus = $order->statusList()->where(['uuid' => $orderStatusId])->firstOrFail();

        if ($orderStatus->status != "pending") {
            return response()->json([
                'message' => 'You already change this status'
            ], 400);
        }

        if (isset(request()->cancelled) && request()->cancelled == 'true') {
            $orderStatus->update([
                'status' => 'cancelled'
            ]);
            $order->is_cancelled = true;
            $order->status = OrderStatusEnum::CANCELED;
            $order->save();

        } else {
            $orderStatus->update([
                'status' => 'approved'
            ]);

            if ($orderStatus->name == OrderStatusEnum::APPROVED) {
                $order->is_approved = true;
            }

            if ($orderStatus->name == OrderStatusEnum::DELIVERY_COMPLETED) {
                $order->is_delivery_complete = true;
            }

            if ($orderStatus->name == OrderStatusEnum::VENDOR_PAYMENT_RECEIVED) {
                $order->is_vendor_payment_complete = true;
            }

            $order->status = $orderStatus->name;
            $order->save();
        }
    }
}

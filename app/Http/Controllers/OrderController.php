<?php

namespace App\Http\Controllers;

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
        return view('store.order.index');
    }

    public function getData(Request $request)
    {
        $orderQuery = Order::where([]);

        if (!request()->get('order')) {
            $orderQuery = $orderQuery->orderBy('id', 'asc');
        }

        return Datatables::of($orderQuery)
            ->filter(function ($query) use ($request) {
            })

            ->editColumn('updated_at', function ($model) {
                return $model->updated_at->diffForHumans();
            })
            ->editColumn('order_status', function ($model) {
                $statusColor = $model->order_status == 'private' ? 'danger' : 'success';
                return "<span class = 'badge badge-{$statusColor}'>" . $model->order_status . " hello</span>";
            })

            ->addColumn('action', function ($model) {

                $content = "<a href='" . route('orders.show', ['order' => $model->id]) . "' class='btn btn-success btn-action btn-sm mr-1' ><i class='fa fa-edit'></i></a>";

                return $content;
            })
            ->make(true);
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
}

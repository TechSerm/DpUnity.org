<?php

namespace App\Http\Controllers;

use App\Facades\Order\OrderFacade;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Http\Requests\OrderProfitDipositeRequest;
use App\Models\Order;
use App\Models\OrderProfitDiposite;
use App\Services\Account\DipositeService;
use App\Services\Account\WithdrawService;
use App\Services\VendorPayment\VendorPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderProfitDipositeController extends Controller
{
    private $vendorPaymentService;
    private $dipositeService;
    private $withdrawService;

    public function __construct(VendorPaymentService $vendorPaymentService, DipositeService $dipositeService, WithdrawService $withdrawService)
    {
        $this->vendorPaymentService = $vendorPaymentService;
        $this->dipositeService = $dipositeService;
        $this->withdrawService = $withdrawService;
    }

    public function index()
    {
        $this->authorize('order_profit_diposites.index');
        $orderQuery = Order::whereNull('order_profit_diposite_id')->where(['is_delivery_complete' => true]);

        $totalDipositeableProfit = $orderQuery->sum('total_profit');
        $countDipositeableProfit = $orderQuery->count();
        $totalDeliveryManHas = $this->vendorPaymentService->notPaidVendorAmount();
        $totalDeliveryManHas += $totalDipositeableProfit;

        $diposites = OrderProfitDiposite::with('user')->orderBy('id', 'desc')->paginate(20);

        return view('order_profit_diposite.index', [
            'totalDipositeableProfit' => $totalDipositeableProfit,
            'countDipositeableProfit' => $countDipositeableProfit,
            'totalDeliveryManHas' => $totalDeliveryManHas,
            'diposites' => $diposites
        ]);
    }

    public function create()
    {
        $this->authorize('order_profit_diposites.index');
        $orders = Order::whereNull('order_profit_diposite_id')->where(['is_delivery_complete' => true])->get();

        return view('order_profit_diposite.create', [
            'orders' => collect($orders)
        ]);
    }

    public function store(OrderProfitDipositeRequest $request)
    {
        $this->authorize('order_profit_diposites.index');
        $orders = Order::whereIn('uuid', array_keys($request->OrderProfitPaymentCheckbox))->where(['order_profit_diposite_id' => null])->get();
        if (empty($orders)) {
            return response()->json([
                'Please Select Order'
            ], 401);
        }

        $productProfit = $orders->sum('products_profit');
        $deliveryFee = $orders->sum('delivery_fee');
        $totalProfit = $orders->sum('total_profit');

        $orderProfitDiposite = OrderProfitDiposite::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'product_profit' => $productProfit,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalProfit,
            'total_orders' => count($orders),
            'note' => $request->notes
        ]);

        foreach ($orders as $order) {
            $order->update([
                'order_profit_diposite_id' => $orderProfitDiposite->id,
            ]);
        }

        $tokens = OrderFacade::getManagerDeviceToken();
        if (!empty($tokens)) {
            PushNotificationFacade::sendNotification($tokens, [
                'title' => "লাভ যুক্ত করা হয়েছে",
                'body' => $this->getOrderProfitNotificationBody($orderProfitDiposite),
                "url" => route('order_profit_diposites.index'),
            ]);
        }
    }

    public function show($dipositeId)
    {
        $orderProfitDiposite = OrderProfitDiposite::where(['uuid' => $dipositeId])->firstOrFail();

        return view('order_profit_diposite.show', [
            'diposite' => $orderProfitDiposite
        ]);
    }


    public function confirm($dipositeId)
    {
        $orderProfitDiposite = OrderProfitDiposite::where(['uuid' => $dipositeId])->firstOrFail();

        if ($orderProfitDiposite->total_amount >= 0) {
            $transaction = $this->dipositeService->create("order_profit", $orderProfitDiposite->total_amount, '', $orderProfitDiposite->user_id);
        } else {
            $transaction = $this->withdrawService->create("order_loss", $orderProfitDiposite->total_amount * (-1), '', $orderProfitDiposite->user_id);
        }

        if (empty($transaction)) {
            return response()->json([
                'Invalid Transaction'
            ], 419);
        }

        $orderProfitDiposite->update([
            'is_approved' => true,
            'account_transaction_id' => $transaction->id
        ]);

        return view('order_profit_diposite.show', [
            'diposite' => $orderProfitDiposite
        ]);
    }

    public function destroy($dipositeId)
    {
        $orderProfitDiposite = OrderProfitDiposite::where(['uuid' => $dipositeId])->firstOrFail();
        if ($orderProfitDiposite->is_approved) {
            return response()->json([
                'message' => 'Status already Changed'
            ], 419);
        }

        $orders = $orderProfitDiposite->orders;
        foreach ($orders as $order) {
            $order->update([
                'order_profit_diposite_id' => null
            ]);
        }

        $orderProfitDiposite->delete();

        return response()->json([
            'Payment Successfully Deleted'
        ]);
    }

    private function getOrderProfitNotificationBody($orderProfitDiposite)
    {
        $body = "🔖 আইডি : " . bnConvert()->number($orderProfitDiposite->id);
        $body .= "\n🛒 সর্বমোট অর্ডার: " . bnConvert()->number($orderProfitDiposite->total_orders);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($orderProfitDiposite->total_amount);
        $body .= "\n⏰ সময় : " . bnConvert()->date($orderProfitDiposite->created_at->format('d M Y, h:i a'));
        return $body;
    }
}

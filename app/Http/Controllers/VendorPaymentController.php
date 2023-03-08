<?php

namespace App\Http\Controllers;

use App\Facades\Order\OrderFacade;
use App\Facades\PushNotification\PushNotificationFacade;
use App\Facades\Vendor\Vendor;
use App\Http\Requests\VendorPaymentRequest;
use App\Models\Order;
use App\Models\OrderVendor;
use App\Models\VendorPayment;
use App\Services\VendorPayment\VendorPaymentService;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    private $vendorPaymentService;
    public function __construct(VendorPaymentService $vendorPaymentService)
    {
        $this->vendorPaymentService = $vendorPaymentService;
    }

    public function index()
    {
        $vendorPayments = VendorPayment::where(function($query){
            if(auth()->user()->isVendor()){
                $query->where(['vendor_id' => auth()->user()->id]);
            }
        })->orderBy('id', 'desc')->paginate(10);
        
        $vendors = $this->vendorPaymentService->getAllVendorData();
        if (auth()->user()->isVendor()) {
            $vendors = $vendors->filter(function ($item) {
                return $item['vendor_id'] == auth()->user()->id;
            });
        }

        return view('vendor_payment.index', [
            'vendors' => $vendors,
            'vendorPayments' => $vendorPayments
        ]);
    }

    public function sendPayment($vendorId)
    {
        $vendor = $this->vendorPaymentService->getAllVendorData()->filter(function ($item) use ($vendorId) {
            return $item['vendor_id'] == $vendorId;
        })->first();
        return view('vendor_payment.send_payment', [
            'vendor' => $vendor
        ]);
    }

    public function sendPendingPayment($vendorId)
    {
        $vendor = $this->vendorPaymentService->getAllVendorData()->filter(function ($item) use ($vendorId) {
            return $item['vendor_id'] == $vendorId;
        })->first();
        return view('vendor_payment.pending_payment', [
            'vendor' => $vendor
        ]);
    }

    public function store(VendorPaymentRequest $request)
    {
        $orderVendors = OrderVendor::whereIn('uuid', array_keys($request->vandorPaymentCheckbox))->where(['vendor_payment_id' => null])->get();
        if (empty($orderVendors)) {
            return response()->json([
                'Please Select Order'
            ], 401);
        }
        $total = $orderVendors->sum('wholesale_total');

        $vendorPayment = VendorPayment::create([
            'vendor_id' => $request->vendor_id,
            'user_id' => auth()->user()->id,
            'total_orders' => count($orderVendors),
            'total' => $total,
            'notes' => $request->notes
        ]);

        foreach ($orderVendors as $orderVendor) {
            $orderVendor->update([
                'vendor_payment_id' => $vendorPayment->id,
                'is_vendor_payment_send' => true
            ]);
        }

        $tokens = OrderFacade::getVendorDeviceToken([$request->vendor_id]);
        
        
        $body = $this->getPaymentNotificationBody($vendorPayment);

        if(!empty($tokens)){
            PushNotificationFacade::sendNotification($tokens, [
                'title' => "আপনাকে পেমেন্ট পাঠানো হয়েছে",
                'body' => $body."\n📌 পেমেন্ট টি গ্রহণ করুন",
                "url" => route('vendor_payments.index'),
            ]);
        }

        $tokens = OrderFacade::getManagerDeviceToken();
        if(!empty($tokens)){
            PushNotificationFacade::sendNotification($tokens, [
                'title' => "পেমেন্ট পাঠানো হয়েছে",
                'body' => $body,
                "url" => route('vendor_payments.index'),
            ]);
        }
        
    }

    public function show($vendorPaymentId)
    {
        $vendorPayment = VendorPayment::where(['uuid' => $vendorPaymentId])->firstOrFail();

        return view('vendor_payment.show', [
            'vendorPayment' => $vendorPayment
        ]);
    }

    public function paymentConfirm($vendorPaymentId)
    {
        $vendorPayment = VendorPayment::where(['uuid' => $vendorPaymentId])->firstOrFail();

        if ($vendorPayment->is_vendor_received) {
            return response()->json([
                'message' => 'Status already Changed'
            ], 419);
        }

        $orderVendors = $vendorPayment->orders;
        foreach ($orderVendors as $orderVendor) {
            $orderVendor->update([
                'is_vendor_payment_complete' => true
            ]);
            $this->updateOrderPaymentStatus($orderVendor->order);
        }

        $vendorPayment->update([
            'is_vendor_received' => true
        ]);

        $body = $this->getPaymentNotificationBody($vendorPayment);
        
        $tokens = OrderFacade::getManagerDeviceToken();
        if(!empty($tokens)){
            PushNotificationFacade::sendNotification($tokens, [
                'title' => "পেমেন্ট গ্রহণ করা হয়েছে",
                'body' => $body."\n👦 ".auth()->user()->name,
                "url" => route('vendor_payments.index'),
            ]);
        }

        return response()->json([
            'Payment Successfully Confirmed'
        ]);
    }

    public function destroy($vendorPaymentId)
    {
        $vendorPayment = VendorPayment::where(['uuid' => $vendorPaymentId])->firstOrFail();
        if ($vendorPayment->is_vendor_received) {
            return response()->json([
                'message' => 'Status already Changed'
            ], 419);
        }

        $orderVendors = $vendorPayment->orders;
        foreach ($orderVendors as $orderVendor) {
            $orderVendor->update([
                'is_vendor_payment_send' => false,
                'is_vendor_payment_complete' => false,
                'vendor_payment_id' => null
            ]);
            $this->updateOrderPaymentStatus($orderVendor->order);
        }

        $vendorPayment->delete();

        $body = $this->getPaymentNotificationBody($vendorPayment);
        $tokens = OrderFacade::getManagerDeviceToken();

        if(!empty($tokens)){
            PushNotificationFacade::sendNotification($tokens, [
                'title' => "পেমেন্ট বাতিল করা হয়েছে",
                'body' => $body."\n👦 ".auth()->user()->name,
                "url" => route('vendor_payments.index'),
            ]);
        }

        return response()->json([
            'Payment Successfully Deleted'
        ]);
    }

    private function updateOrderPaymentStatus(Order $order)
    {
        if (!$order->vendors()->where(['is_vendor_payment_complete' => false])->exists()) {
            $order->update([
                'is_vendor_payment_complete' => true
            ]);
        }
    }

    private function getPaymentNotificationBody($vendorPayment){
        $body = "🔖 পেমেন্ট আইডি : " . bnConvert()->number($vendorPayment->id);
        $body .= "\n🏬 দোকান : " . $vendorPayment->vendor->name;
        $body .= "\n🛒 সর্বমোট অর্ডার: " . bnConvert()->number($vendorPayment->total_orders);
        $body .= "\n💵 সর্বমোট: ৳ " . bnConvert()->number($vendorPayment->total);
        $body .= "\n⏰ সময় : " . bnConvert()->date($vendorPayment->created_at->format('d M Y, h:i a'));
        return $body;
    }
}

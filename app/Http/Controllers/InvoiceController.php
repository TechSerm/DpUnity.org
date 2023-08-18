<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Invoice\InvoiceService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoice.index');
    }

    public function print(Order $order, InvoiceService $invoiceService)
    {
        if (!$invoiceService->isPrintable($order)) abort(404);

        $qrCode = QrCode::size(80)->generate(route('store.order.show', ['uuid' => $order->uuid]));

        return view('invoice.print', compact('order', 'qrCode'));
    }
}

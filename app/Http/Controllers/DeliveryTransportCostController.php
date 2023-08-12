<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryTransportCostRequest;
use App\Models\DeliveryTransportCost;
use App\Services\Account\WithdrawService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class DeliveryTransportCostController extends Controller
{

    private $withdrawService;
    public function __construct(WithdrawService $withdrawService)
    {
        $this->withdrawService = $withdrawService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('delivery_transport_costs.index');
        $costs = DeliveryTransportCost::orderBy('id', 'desc')->paginate(20);
        return view('delivery_transport_cost.index', [
            'costs' => $costs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('delivery_transport_costs.index');
        return view('delivery_transport_cost.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryTransportCostRequest $request)
    {
        $this->authorize('delivery_transport_costs.index');

        $transaction = $this->withdrawService->withdraw("delivery_fee", $request->amount, $request->note);

        if (empty($transaction)) {
            return response()->json([
                'message' => 'একাউন্টে পর্যাপ্ত পরিমান টাকা নেই'
            ], 419);
        }

        DeliveryTransportCost::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note
        ]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

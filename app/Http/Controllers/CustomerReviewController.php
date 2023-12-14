<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\AddCustomerRequest;
use App\Http\Requests\CustomerReview\EnterMobileRequest;
use App\Models\Customer;
use App\Models\CustomerReview;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = CustomerReview::with('customer', 'assigned', 'order')->orderBy('id', 'desc')->get();
        return view('customer_review.index', [
            'reviews' => $reviews
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer_review.enter_mobile');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::where(['uuid' => $request->customer_id])->firstOrFail();
        $order = $request->order_id ? Order::find($request->order_id) : [];
        $assignedBy = User::find($request->assigned_by); 
        CustomerReview::create([
            'uuid' => Str::uuid(),
            'customer_id' => $customer->id,
            'schedule_time' => $request->schedule_time,
            'schedule_note' => $request->schedule_note,
            'order_id' => $order ? $order->id : null,
            'assigned_by' => $assignedBy ? $assignedBy->id : null
        ]);

        return response()->json([
            'message' => 'Successfully created new review schedule'
        ]);
    }

    public function enterMobile(EnterMobileRequest $request)
    {
        $customer = Customer::where(['mobile' => request()->mobile])->first();
        if (!$customer) {
            return view('customer_review.add_customer', [
                'mobile' => request()->mobile
            ]);
        }

        return view('customer_review.create', [
            'customer' => $customer,
            'users' => User::where('role_name', '!=', 'vendor')->pluck('name', 'id')->toArray()
        ]);
    }

    public function addCustomer(AddCustomerRequest $request)
    {
        $customer = Customer::where(['mobile' => request()->customer_mobile])->first();
        if (!$customer) {
            $customer = Customer::create([
                'uuid' => Str::uuid(),
                'mobile' => $request->customer_mobile,
                'name' => $request->customer_name,
                'address' => $request->customer_address,
            ]);
        }

        return view('customer_review.create', [
            'customer' => $customer,
            'users' => User::where('role_name', '!=', 'vendor')->pluck('name', 'id')->toArray()
        ]);
    }

    public function addReview($review) {
        $review = CustomerReview::where(['uuid' => $review])->firstOrFail();
        return view('customer_review.add_review', [
            'review' => $review
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

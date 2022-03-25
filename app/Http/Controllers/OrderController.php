<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->authorize('create', Order::class);

        if($request->package_name_slug) {
            $package = Package::where('name_slug', $request->package_name_slug)->first();
           // $package = Package::findOrFail($request->packageId);

            $settings = Setting::where('key','GST')->first();

            $gstPercentage = $settings->value;
            $totalPriceInclusiveOfTax = $package->selling_price;

            $priceExclusiveOfTax = ceil( ( ( $totalPriceInclusiveOfTax * 100 ) / ( 100 + $gstPercentage ) ));

            $gstAmount =  (( $totalPriceInclusiveOfTax * $gstPercentage ) / 100 );

           // $gstAmount =  ceil( ( ( $priceExclusiveOfTax * $gstPercentage ) / 100));

//            $totalPrice = $package->selling_price;

//            $priceExclusiveOfTax =  $totalPrice - $gstAmount;
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->package_id = $package->id;
            $order->price = $package->selling_price;
            $order->gst_percentage = $gstPercentage;
            $order->gst_amount = $gstAmount;
            $order->net_total = $totalPriceInclusiveOfTax;
            $order->status = Order::STATUS_PENDING;
            $order->save();

            $amount_to_pay = $order->net_total * 100;

            $api_key = config('services.razorpay.api_key');
            $api_secret = config('services.razorpay.api_secret');
            $api = new Api($api_key, $api_secret);
            $razorPayOrder  = $api->order->create(array('receipt' => $order->id, 'amount' => $amount_to_pay, 'currency' => 'INR'));

            return response()->json([ 'razorpayOrderId' => $razorPayOrder['id'], 'amount' => $order->net_total, 'order_id' => $order->id]);

        }

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

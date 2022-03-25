<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class TransactionController extends Controller
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
        $success = false;

        $orderId = $request->orderId;
        $razorPayOrderId = $request->razorPayOrderId;

        $order = Order::findOrFail($orderId);
        $order->razorpay_payment_id = $request->razorpay_payment_id;
        $order->razorpay_order_id = $request->razorpay_order_id;
        $order->razorpay_signature = $request->razorpay_signature;
        $order->save();

        $api_key = config('services.razorpay.api_key');
        $api_secret = config('services.razorpay.api_secret');
        $api = new Api($api_key, $api_secret);

        try
        {
            $attributes  = array(
                'razorpay_signature'  => $order->razorpay_signature,
                'razorpay_payment_id'  => $order->razorpay_payment_id ,
                'razorpay_order_id' => $razorPayOrderId
            );

            $api->utility->verifyPaymentSignature($attributes);
            $success = true;

        }
        catch(SignatureVerificationError $e)
        {
            $success = false;
            $error = 'Razorpay Error : ' . $e->getMessage();
        }

        if ($success == true){

            if($orderId){

                DB::beginTransaction();

                $order = Order::findOrFail($orderId);
                $order->status = Order::STATUS_SUCCESS;
                $order->update();

                $package = Package::findOrFail($order->package_id);
                $expire_duration = $package->expire_on;
                $packageExpiryDate = Carbon::today()->addDays($expire_duration)->format('Y-m-d');

               // $packageExpiryDate = $packageExpiringDate > $package->visible_to_date ? $package->visible_to_date : $packageExpiringDate;

                $alreadyPurchasedTransactions = Transaction::where('user_id', Auth::user()->id)
                    ->where('package_id', $order->package_id)
                    ->pluck('id');

                Transaction::whereIn('id', $alreadyPurchasedTransactions)->delete();

                $transaction = new Transaction();
                $transaction->user_id = $order->user_id;
                $transaction->package_id = $order->package_id;
                $transaction->course_id = $package->course_id;
                $transaction->order_id = $orderId;
                $transaction->price = $order->price;
                $transaction->package_expiry_date = $packageExpiryDate;
                $transaction->gst_percentage = $order->gst_percentage;
                $transaction->gst_amount = $order->gst_amount;
                $transaction->net_total = $order->net_total;
                $transaction->save();

                DB::commit();
            }
            return response()->json(true);
        }
        else{
            return response()->json(false);
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

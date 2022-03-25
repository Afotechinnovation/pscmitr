@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

    <div class="cart-wrapper pt-lg--7 pb-lg--7 pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4 class="mont-font fw-600 font-md mb-5">Order Details</h4>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                   <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1 mb-5">
                      <div class="row">
                            <div class="col-sm-12">
                                <div class="card-image float-left w-100 mb-0">
                                    <a href="{{ url('packages/'. $package->id)  }}" class=" @if( $package->package_videos->count() >= 1 ) video-bttn @endif position-relative d-block">
                                        <img src="{{ $package->cover_pic }}" alt="image" class="w-100">
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card-body w-100 float-left p-3 ">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-warning d-inline-block text-warning mr-1"> {{ $package->course->name }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="font-xss fw-700 float-right pl-3 pr-3 ls-2 lh-32 d-inline-block text-success ">
                                                <span class="font-xss"> ₹ </span>
                                                {{ number_format( $package->selling_price, 2) }}
                                            </span>
                                        </div>
                                    </div>

                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{ url('packages/'. $package->id) }}" class="text-dark text-grey-900">{{ $package->display_name }}</a></h4>
                                    <div class="row ">
                                        <div class="col-6">
                                            <h6 class="font-xssss text-grey-600 fw-600 ml-0 mt-2">
                                                {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Lessons @else Lesson @endif
                                            </h6>
                                        </div>
                                        <div class="col-6">
                                            <div class="star d-inline float-right">
                                                @for( $i=1; $i<=$package->average_package_rating; $i++ )
                                                    <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10">
                                                @endfor
                                                @for( $j=1; $j<=(5-$package->average_package_rating); $j++ )
                                                    <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10">
                                                @endfor
                                            </div>
                                        </div>
{{--                                        <div class="col-4">--}}
{{--                                            <h6 class="font-xssss text-grey-600 fw-600 ml-3 pt-1 float-left">--}}
{{--                                                <i class="ti-time mr-2"></i>--}}
{{--                                                {{ $package->total_video_duration }}--}}
{{--                                            </h6>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="row">
                                        <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 p-3 pr-1">
                                            {{ \Illuminate\Support\Str::limit($package->description, 100, $end='...') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                      </div>
                   </div>
                </div>

                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="order-details">
                        <div class="table-content table-responsive mb-1 card border-0 bg-greyblue p-5">
                            <table class="table order-table order-table-2 mb-0">
                                <thead>
                                <tr>
                                    <th class="border-0">Package</th>
                                    <th class="text-right border-0">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th class="text-grey-700 fw-500 font-xsss">
                                        {{ $package->display_name }}
                                    </th>
                                    <td class="text-right text-grey-700 fw-500 font-xsss">
                                        ₹{{ number_format( $package->selling_price, 2) }}
                                    </td>
                                </tr>

                                </tbody>
                                <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td class="text-right text-grey-900 font-xss fw-600">
                                        ₹{{ number_format( $package->selling_price, 2) }}
                                    </td>
                                </tr>

                                <tr class="order-total">
                                    <th>Net Total</th>
                                    <td class="text-right text-grey-900 font-xss fw-600">
                                        <span class="order-total-ammount"> ₹{{ number_format( $package->selling_price, 2) }}</span>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="clearfix"></div>

                        @if(\Illuminate\Support\Facades\Auth::user())
                            @if ((!in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages)) || (!$package->is_active) )
                                <div class="card shadow-none border-0">
                                    <button  value="1" class="place-order-button w-100 p-3 mt-3 font-xsss text-center border-0
                                        text-white bg-current rounded-lg text-uppercase fw-600 ls-3">Place Order
                                    </button>
                                </div>
                            @endif
                        @else
                            <div class="card shadow-none border-0">
                                <button  class="place-order-button w-100 p-3 mt-3 font-xsss text-center border-0
                                text-white bg-current rounded-lg text-uppercase fw-600 ls-3">Place Order</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="payment-option pt-0 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-3 text-left">
                    <i class="ti-shopping-cart text-grey-900 display1-size float-left mr-3"></i>
                    <h4 class="mt-1 fw-600 text-grey-900 font-xss mb-0">100% Secure Payments</h4>
                    <p class="font-xssss fw-500 text-grey-500 lh-26 mt-0 mb-0">100% Payment Protection.</p>
                </div>

                <div class="col-lg-3 col-md-6 mb-3 text-left">
                    <i class="ti-headphone-alt text-grey-900 display1-size float-left mr-3"></i>
                    <h4 class="mt-1 fw-600 text-grey-900 font-xss mb-0">Support</h4>
                    <p class="font-xssss fw-500 text-grey-500 lh-26 mt-0 mb-0">Always online feedback 24/7</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 text-left">
                    <i class="ti-lock text-grey-900 display1-size float-left mr-3"></i>
                    <h4 class="mt-1 fw-600 text-grey-900 font-xss mb-0">Trust pay</h4>
                    <p class="font-xssss fw-500 text-grey-500 lh-26 mt-0 mb-0">Easy Return Policy.</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-3 text-left">
                    <i class="ti-reload text-grey-900 display1-size float-left mr-3"></i>
                    <h4 class="mt-1 fw-600 text-grey-900 font-xss mb-0">Return and Refund</h4>
                    <p class="font-xssss fw-500 text-grey-500 lh-26 mt-0 mb-0">100% money back guarantee</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(function() {
            'use strict';

            $(".place-order-button").click(function (e){

                var isLoggedInUser = $(this).val();

                if(!isLoggedInUser){
                    $('#Modallogin').modal('toggle');
                }
                else{
                    var user_package = '{{ $package->name_slug }}';

                    var course_name = '{{ $package->course->name }}';

                    var package_name = '{{ $package->name }}';

                    var image_url = '{{ $package->image }}';

                    @if(\Illuminate\Support\Facades\Auth::user()) {

                        var is_profile_completed  = '{{ $isProfileComplete }}';

                    }
                    @endif

                    if(is_profile_completed == 1)
                    {
                        var success_url  = '{{url('/user/packages')}}' +'/' + user_package;

                    }else {

                        var success_url = '{{url('/user/profile')}}' + '?packageId=' + user_package;
                    }

                    let url = '{{ route('orders.store')}}'
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            package_name_slug: user_package,
                        }
                    }).done(function (response) {
                        console.log(response);
                        if (response) {
                            var orderId = response.order_id;
                            var razorPayOrderId = response.razorpayOrderId;
                            var options = {
                                "key": '{{config('services.razorpay.api_key')}}', // Enter the Key ID generated from the Dashboard
                                "amount": response.amount , // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                "currency": "INR",
                                "name": course_name,
                                "description": package_name,
                                "image": "http://pscmitr.test/web/images/favicon.png",
                                "order_id": razorPayOrderId, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                "handler": function (response){
                                    $.ajax({
                                        url: '{{route('transactions.store')}}',
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            orderId: orderId,
                                            razorPayOrderId: razorPayOrderId,
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_order_id: response.razorpay_order_id,
                                            razorpay_signature: response.razorpay_signature,
                                        }
                                    }).done(function (response) {
                                       if(response){
                                           toastr.success('Payment successful');
                                           window.location.href = success_url;
                                       }
                                       else{
                                           toastr.error('Oops! Payment failed');
                                       }
                                    });
                                },
                                "theme": {
                                    "color": "#305cd7"
                                }
                            };

                            var rzp1 = new Razorpay(options);

                            rzp1.on('payment.failed', function (response){
                                alert(response.error.code);
                                alert(response.error.description);
                                alert(response.error.source);
                                alert(response.error.step);
                                alert(response.error.reason);
                                alert(response.error.metadata.order_id);
                                alert(response.error.metadata.payment_id);
                            });
                            rzp1.open();
                            e.preventDefault();
                        } else {

                        }
                    });
                }

            });

        });
    </script>
@endpush

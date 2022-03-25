@extends('layouts.app')

@section('title', 'History')

@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden p-4">
                        <div class="card-body mb-3 pb-0"><h2 class="fw-400 font-lg d-block">My  <b>Purchase History</b></h2></div>
                        <div class="card-body pb-0">
                            <div class="table-responsive ">
                                <table id="history-table" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Package</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Price</th>
                                        <th>GST Amount</th>
                                        <th>Total Exclusive of GST</th>
                                        <th>Valid Upto</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($histories->count())
                                        @foreach( $histories as $history)
                                            <tr class="text-grey-600">
                                                <td>{{$history->package['display_name']}} </td>
                                                <td>{{ Carbon\Carbon::parse($history->created_at)->format('d M Y')}} </td>
                                                <td>{{ Carbon\Carbon::parse($history->created_at)->format('H:i:s')}} </td>
                                                <td>{{$history->package->selling_price}} </td>
                                                <td>{{$history->gst_amount}} </td>
                                                <td>{{$history->price - $history->gst_amount}} </td>
                                                <td>{{$history->package_expiry_date}}</td>
                                            <tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No data available in table</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            {{ $histories->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

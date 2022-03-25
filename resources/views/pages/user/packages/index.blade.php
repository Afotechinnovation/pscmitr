@extends('layouts.app')
@section('title', 'Packages')
@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden ">
                        <div class="card-body mb-3 pb-0">
                            <h2 class="fw-400 font-lg d-block">My  <b>Courses</b></h2>
                        </div>
                        <div class="row card-scroll">
                             @if($packages->count() > 0)
                                @foreach( $packages as $package)
                                    <div class="col-sm-6 col-xs-6 col-xl-4 mb-4">
                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                            <div class="card-image w-100 mb-3">
                                                <a href="{{ url('user/packages/'.$package->name_slug) }}" class="@if( $package->package_videos->count() >= 1 )video-bttn @endif position-relative d-block"><img src="{{ $package->image_url }}" alt="image" class="w-100"></a>
                                            </div>
                                            <div class="card-body pt-0">
                                                <h4 class="fw-700 font-xss mt-3 lh-28 mt-0 package-name-row"><a href="{{ url('user/packages/'.$package->name_slug )}}" class="text-dark text-grey-900 package-name-row">{{\Illuminate\Support\Str::limit( $package->display_name , 28, $end='..') }}</a></h4>
                                                <div class="row p-1">
                                                    <div class="col-12" style="min-height: 40px;">
                                                        <h6 class="font-xssss text-balck-100 fw-600 ml-0 mt-2">
                                                            @if($package->is_active)   Expires In  :  @if($package->expiry_date == -1) Today @else  {{ $package->expiry_date }} @if($package->expiry_date == 1) Day @else Days @endif @endif @else Package Expired @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="row p-1">
                                                    <div class="col-md-6 col-xs-12 col-sm-12 p-0 pl-md-3" >
                                                        <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2">
                                                            {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Videos @else Video @endif
                                                            +  {{ $package->package_tests->count() }}  @if( $package->package_tests->count() > 1 ) Tests @else Test @endif
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                                        <span class="font-xssss float-md-right text-center text-grey-500 fw-600 pt-2">
                                                        <i class="ti-book mr-2">   {{ \Illuminate\Support\Str::limit( $package->course->name, 14, $end='...') }} </i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-12 col-xs-12 mobile-text-center ">
                                                        <div class="star float-left text-left mb-0">
                                                            @for( $i=1; $i<=$package->average_package_rating; $i++ )
                                                                <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-2 float-left">
                                                            @endfor
                                                            @for( $j=1; $j<=(5-$package->average_package_rating); $j++ )
                                                                <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 d-contents ">
                                                        <div class=" review-link mt-md-0 mt-2 font-xssss float-md-right text-sm-center mb-2 fw-500 text-grey-500 lh-3">
                                                            {{ $package->package_ratings->count() }} customer @if( $package->package_ratings->count() > 1 )reviews @else review @endif
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                <div class="star float-left text-left mb-0">--}}
{{--                                                    @for( $i=1; $i<=$package->average_package_rating; $i++ )--}}
{{--                                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-2 float-left">--}}
{{--                                                    @endfor--}}
{{--                                                    @for( $j=1; $j<=(5-$package->average_package_rating); $j++ )--}}
{{--                                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">--}}
{{--                                                    @endfor--}}
{{--                                                </div>--}}
{{--                                                <p class="review-link mt-0 font-xssss float-right mb-2 mt-md-0 mt-2 fw-500 text-grey-500 lh-3">--}}
{{--                                                    {{ $package->package_ratings->count() }} customer @if( $package->package_ratings->count() > 1 )reviews @else review @endif--}}
{{--                                                </p>--}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

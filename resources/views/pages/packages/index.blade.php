@extends('layouts.app')

@section('title', 'Packages')

@section('content')

    @include('pages.includes.quiz')

    @if($courses->count() > 0)
        <div class="how-to-work pt-7 pb-lg-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                        <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Popular Classes</h2>
                        <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                            @foreach($courses as $key => $course)
                                <li class="list-inline-item @if( $key == 0 ) active @endif">
                                    <a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3 @if( $key == 0 ) active @endif" href="#navtabs{{ $course->id }}" data-toggle="tab">{{ $course->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    @foreach( $courses as $key => $course )
                        <div class="tab-pane  @if( $key == 0 ) show active @else fade @endif" id="navtabs{{ $course->id }}">
                            <div class="row card-scroll">
                                @foreach( $course['packages'] as $package )
                                    <div class="col-sm-6 col-xs-6 col-xl-4 mb-4 ">
                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg  mr-1">
                                            <div class="card-image w-100 mb-3">
                                                <a href="{{ url('packages/'.$package->name_slug) }}" class="@if( $package->package_videos->count() >= 1 )video-bttn @endif position-relative d-block"><img src="{{ $package->image_url }}" alt="image" class="w-100"></a>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row p-1">
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2">
                                                            {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Videos @else Video @endif
                                                            +  {{ $package->package_tests->count() }}  @if( $package->package_tests->count() > 1 ) Tests @else Test @endif
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12 d-contents">
{{--                                                        <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">{{ $package->subject ? $package->subject->name : '' }}</span>--}}
                                                        @if( $package->offer_price )
                                                            <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->offer_price }}</span>
                                                            <span class="font-xsssss fw-700 pl-3 pr-0 ls-2 lh-32 d-inline-block text-grey-600 float-right"><strike><span class="font-xsss">₹</span> {{ $package->price }}</span></strike>
                                                        @else
                                                            <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->price }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <h4 class="fw-700 font-xss mt-3 lh-28 mt-0 description-row"><a href="{{ url('packages/'.$package->name_slug )}}" class="text-dark text-grey-900 ">{{\Illuminate\Support\Str::limit( $package->display_name , 20, $end=' ...') }} </a></h4>
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
                                                    <div class="col-md-6 col-sm-12 col-xs-12 d-contents">
                                                        <div class="pl-3 review-link mt-md-0 mt-2 font-xssss float-md-right text-sm-center mb-2 fw-500 text-grey-500 lh-3 pr-2">
                                                            {{ $package->package_ratings->count() }} customer @if( $package->package_ratings->count() > 1 )reviews @else review @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

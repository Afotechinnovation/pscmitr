@extends('layouts.app')

@section('title', 'Courses')

@section('content')

 @include('pages.includes.quiz')
 <style>
     li {
         list-style: none;
     }
 </style>

    <div class="blog-page pt-lg--5 pb-lg--7 pt-5 pb-5" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card rounded-xxl p-0 border-0 bg-no-repeat" style=" background-color: #e4f7fe; ">
                        <div class="card-body w-100 p-4">
                            <div class="side-wrap rounded-lg">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-group" name="filter-package-form" id="filter-package-form" action="{{ url('courses') }}" method="GET">
                                            <div class="col-md-12">
                                                <div class="form-group icon-input mb-3">
                                                    <input type="text" name="search" value="{{ request()->input('search') ? request()->input('search') : '' }}" class="form-control style1-input pl-5 border-size-md border-light font-xsss" placeholder="To search type and hit enter">
                                                    <i class="ti-search text-grey-500 font-xs"></i>
                                                </div>
                                                <ul class="nav nav-pills pills-dark mb-3" id="pills-tab" role="tablist" >
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $tab == 'courses' ? 'active' : '' }}   rounded-xl" id="pills-course-tab"
                                                            href="{{ route('courses.index',  array_merge(request()->all(), ['tab' => 'courses','page' => 1])) }}"
                                                            role="tab" aria-controls="pills-course" aria-selected="true">Course
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $tab == 'package-type' ? 'active' : '' }}   rounded-xl"  id="pills-type-tab"
                                                           href="{{ route('courses.index',  array_merge(request()->all(), ['tab' => 'package-type','page' => 1])) }}"
                                                           role="tab" aria-controls="pills-type" aria-selected="false">Type</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link {{ $tab == 'ratings' ? 'active' : '' }}   rounded-xl"  id="pills-rating-tab"
                                                           href="{{ route('courses.index',  array_merge(request()->all(), ['tab' => 'ratings','page' => 1])) }}"
                                                           role="tab" aria-controls="pills-rating" aria-selected="false">Rating</a>
                                                    </li>
                                                </ul>
                                                <input type="hidden" name="tab" value="{{ $tab }}">
                                                <div class="tab-content pl-3 form-group" id="pills-tabContent">
                                                    <div class="tab-pane show {{ $tab == 'courses' ? 'active' : 'fade' }}" id="pills-course" role="tabpanel" aria-labelledby="pills-course-tab">
                                                        <ul class="list-group list-group-horizontal-lg border-bottom-0 mt-2">
                                                            @foreach($courses as $course)
                                                                <li>
                                                                    <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                        <input type="checkbox" class="m-2" name="courses[]" value="{{ $course->name }}"
                                                                            {{ request()->input('courses') ? in_array($course->name, request()->input('courses'))?'checked':'': '' }} >
                                                                        {{ $course->name }}
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane {{ $tab == 'package-type' ? 'active' : 'fade' }}" id="pills-type" role="tabpanel" aria-labelledby="pills-type-tab">
                                                        <ul class="list-group list-group-horizontal-lg border-bottom-0 mt-2">
                                                            @foreach($package_types as $package_type)
                                                            <li>
                                                                <label  class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input class="m-2" type="checkbox" name="package_types[]" value="{{ $package_type->id }}"
                                                                        {{ request()->input('package_types') ? in_array($package_type->id, request()->input('package_types'))?'checked':'': '' }}
                                                                        {{ request()->input('package_type') ? request()->input('package_type') ==  $package_type->id ? 'checked' : '' : ''}}>
                                                                    {{ $package_type->title }}
                                                                </label>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="tab-pane {{ $tab == 'ratings' ? 'active' : 'fade' }}" id="pills-rating" role="tabpanel" aria-labelledby="pills-rating-tab">
                                                        <ul class="list-group list-group-horizontal-lg border-bottom-0 mt-2">
                                                            @for( $i=1; $i<=5; $i++)
                                                            <li>
                                                                <label  class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input class="m-2" type="checkbox" name="ratings[]" value="{{$i}}"
                                                                        {{ request()->input('ratings') ? in_array($i, request()->input('ratings'))?'checked':'': '' }}>
                                                                    {{$i}} Star
                                                                </label>
                                                            </li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12 col-lg-4 col-sm-4 ">
                                                <button type="submit" data-question="question2" class="p-2 mt-3 border-0 d-inline-block
                                                    text-white fw-700 lh-30 rounded-lg ml-3 w100 font-xsssss ls-3 bg-info">FILTER</button>
                                                <a href="{{ url('courses') }}">
                                                    <button type="button" data-question="question2" class="p-2 mt-3 border-0 d-inline-block
                                                        fw-700 lh-30 rounded-lg ml-3 w100 font-xsssss ls-3 bg-grey-800">CLEAR</button>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @if($packages->count() > 0 )
            <div class="row card-scroll">
               @foreach( $packages as $package)
                <div class="col-xl-6 col-lg-12 col-xs-12 col-sm-12 mb-4">
                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                        <div class="row">
                            <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden">
                                <div class="row">
                                    <div class="col-6 col-xs-12">
                                        <a href="{{ url('packages/'. $package->name_slug) }}" class="@if( $package->package_videos->count() >= 1 ) video-bttn @endif position-relative d-block">
                                            <img src="{{ $package->image_url }}" alt="image" class="w-100">
                                        </a>
                                    </div>
                                    <div class="col-6 col-xs-12 pl-md--0">
                                        <div class="post-content p-4">
{{--                                            <h6 class="font-xssss text-grey-500 fw-600 float-left"><i class="ti-time mr-2"></i> {{ $package->total_video_duration }}</h6>--}}
                                            <h6 class="font-xssss text-grey-500 fw-600 float-right"><i class="ti-book mr-2"></i>
                                                {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Lessons @else Lesson @endif
                                                +  {{ $package->package_tests->count() }}  @if( $package->package_tests->count() > 1 ) Tests @else Test @endif
                                            </h6>

                                            <div class="clearfix"></div>
                                            <h2 class="post-title mt-2 mb-2 pr-3">
                                                <a href="{{ url('packages/'. $package->name_slug) }}" class="lh-30 font-xss mont-font text-grey-800 fw-700">
                                                    {{ \Illuminate\Support\Str::limit( $package->display_name, 16, $end=' ...') }}
                                                </a>
                                            </h2>
                                            <div class="row">
                                                <div class="col-6">
                                                    @for( $i=1; $i<=$package->average_package_rating; $i++ )
                                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                                    @endfor
                                                    @for( $j=1; $j<=(5-$package->average_package_rating); $j++ )
                                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                                    @endfor
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="font-xssss text-success mr-2 fw-600 text-right"> {{ \Illuminate\Support\Str::limit( $package->course->name, 12, $end='...') }}</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <span class="font-xsss fw-700  pt-4 ls-2 lh-32 d-inline-block text-success float-left">
                                                        ₹ {{ $package->offer_price }} <strike class="font-xsssss text-grey-600">₹ {{ $package->price }}</strike>
                                                    </span>
                                                    <span class="font-xsssss fw-700 pl-3 pr-0 ls-2 lh-32 d-inline-block text-grey-600 float-right"></span>
                                                </div>
                                                <div class="col-6">
                                                    @if(\Illuminate\Support\Facades\Auth::user())
                                                        @if ( in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) && $package->is_active )
                                                            <a href="{{ url('user/packages/'.$package->name_slug) }}" class="rounded-xl float-right text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Watch Now</a>
                                                        @else
                                                            <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class="rounded-xl float-right text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Buy Now</a>
                                                        @endif
                                                    @else
                                                        <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class="rounded-xl float-right text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Buy Now</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <div class="row">
                    <div class="col-xl-12 col-lg-12 mb-4">
                        <center> No Data Available on this Search </center>
                    </div>
                </div>
            @endif

            {{ $packages->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection


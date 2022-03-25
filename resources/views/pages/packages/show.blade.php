@extends('layouts.app')

@section('title', 'Courses')

@section('meta')
    <meta property="og:title" content="{{ $package->display_name }}" />
    <meta property="og:type" content="text" />
    <meta property="og:url" content="">
    <meta property="og:description" content="{{ $package->description }}">
    <meta property="og:image" content="{{ $package->cover_pic }}" />
@endsection

@section('content')

    @include('pages.includes.quiz')
    <style>
        li{
            list-style: none;
        }
    </style>

    <div class="course-details pt-lg--7 pb-lg--7 pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-xxl-9 col-lg-8">
                    <div class="card border-0 mb-0 rounded-lg overflow-hidden">
                        @if(\Illuminate\Support\Facades\Auth::user())
                            @if( (in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages)) && (!$package->is_active))
                            <div class="alert alert-danger" role="alert">
                                <p>Oops! Your package has expired. Please purchase again to continue.</p>
                            </div>
                            @endif
                        @endif
                        <img src="{{ $package->cover_pic }}" alt="image" class="w-100">
                    </div>
                    <div class="card d-block border-0 rounded-lg dark-bg-transparent bg-transparent mt-4 pb-3">
                        <div class="row">
                            <div class="col-9">
                                <h4 class="fw-700 font-md d-block lh-4 mb-2 mobile-h2-font">{{ $package->display_name }}</h4>
                            </div>
                            <div class="col-1 pr-1 d-none d-md-block">
                                <a href="#" class="btn-round-md ml-0 d-inline-block rounded-lg float-right bg-greylight" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather-share-2 font-sm text-grey-700"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 border-0 shadow-xss"  aria-labelledby="dropdownMenu2">
                                    <ul class="d-flex align-items-center mt-0 float-left">
                                        <li class="mr-2"><h4 class="fw-600 font-xss text-grey-900  mt-2 mr-3">Share: </h4></li>
                                        <li class="mr-2">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('user/packages/'.$package->name_slug )}}" target="_blank" class="btn-round-md bg-facebook">
                                                <i class="font-xs ti-facebook text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="https://twitter.com/intent/tweet?text={{ url('user/packages/'.$package->name_slug) }}" target="_blank"  class="btn-round-md bg-twiiter">
                                                <i class="font-xs ti-twitter-alt text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url('user/packages/'.$package->name_slug) }}&summary={{ $package->description }}&source={{ (env('APP_DOMAIN')) }}" target="_blank"  class="btn-round-md bg-linkedin">
                                                <i class="font-xs ti-linkedin text-white"></i>
                                            </a>
                                        </li>
                                        {{--                                        <li class="mr-2"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></li>--}}
                                        <li class="mr-2">
                                            <a href="http://pinterest.com/pin/create/button/?url={{ url('user/packages/'.$package->name_slug) }}&description={{ $package->description }}" target="_blank" class="btn-round-md bg-pinterest">
                                                <i class="font-xs ti-pinterest text-white"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-2 pr-0 pr-lg-3 pr-md-3 ">
                                @if(\Illuminate\Support\Facades\Auth::user())
                                    @if ( in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) )
                                        @if($package->is_active)
                                            <a href="{{ url( '/user/packages/'. $package->name_slug ) }}" class=" text-white bg-current rounded-lg float-right p-2 w125 lh-32 font-xsss watch-button text-center fw-500 d-inline-block mb-0">Watch Now</a>
                                        @else
                                            <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class=" text-white bg-current rounded-lg buy-button float-right  p-2  w125 lh-32 font-xsss text-center fw-500 d-inline-block mb-0">Buy Now</a>
                                        @endif
                                    @else
                                        <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class=" text-white bg-current rounded-lg float-right buy-button  p-2 w100 lh-32 font-xsss text-center fw-500 d-inline-block mb-0">Buy Now</a>
                                    @endif
                                @else
                                    <a href="#" data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug  }}" class="login-section text-white bg-current rounded-lg float-right p-2 w100 lh-32 buy-button font-xsss text-center fw-500 d-inline-block mb-0">Buy Now</a>
                                @endif
                            </div>
                        </div>
                        <div class="row justify-content-center 	d-block d-sm-none">
                            <div class="col-12 text-center">
                                <a href="#" class="btn-round-md ml-0 d-inline-block rounded-lg text-center bg-greylight" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather-share-2 font-sm text-grey-700"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 border-0 shadow-xss"  aria-labelledby="dropdownMenu2">
                                    <ul class="d-flex align-items-center mt-0 float-left">
                                        <li class="mr-2"><h4 class="fw-600 font-xss text-grey-900  mt-2 mr-3">Share: </h4></li>
                                        <li class="mr-2">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('user/packages/'.$package->name_slug )}}" target="_blank" class="btn-round-md bg-facebook">
                                                <i class="font-xs ti-facebook text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="https://twitter.com/intent/tweet?text={{ url('user/packages/'.$package->name_slug) }}" target="_blank"  class="btn-round-md bg-twiiter">
                                                <i class="font-xs ti-twitter-alt text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url('user/packages/'.$package->name_slug) }}&summary={{ $package->description }}&source={{ (env('APP_DOMAIN')) }}" target="_blank"  class="btn-round-md bg-linkedin">
                                                <i class="font-xs ti-linkedin text-white"></i>
                                            </a>
                                        </li>
                                        {{--                                        <li class="mr-2"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></li>--}}
                                        <li class="mr-2">
                                            <a href="http://pinterest.com/pin/create/button/?url={{ url('user/packages/'.$package->name_slug) }}&description={{ $package->description }}" target="_blank" class="btn-round-md bg-pinterest">
                                                <i class="font-xs ti-pinterest text-white"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <span class="font-xssss fw-700 text-primary d-inline-block ml-0 ">{{ $package->title }}</span>
{{--                        <span class="font-xssss fw-700 text-black d-inline-block ml-0 ">Validity : {{ \Carbon\Carbon::parse($package->expiry_date->package_expiry_date)->format('d M Y') }}</span>--}}
                    </div>

                    <div class="how-to-work pt-lg--2 pb-lg-2">
                        <div class="container pl-0 pr-0">
                            <div class="row justify-content-center">
                                <div class="page-title style1 col-xl-12 col-lg-12 col-md-12 mt-1 text-center mb-3">
                                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                                        @if( $package->package_videos->count() > 0 )
                                            <li class="active list-inline-item text-center">
                                                <a class="fw-700 ls-3 font-xss text-grey-600 text-uppercase ml-3 active" href="#playlists" data-toggle="tab">
                                                    PLAYLISTS
                                                </a>
                                            </li>
                                        @endif
                                        <li class="list-inline-item @if( !$package->package_videos->count() ) active @endif text-center">
                                            <a class="fw-700 ls-3 font-xss  @if( !$package->package_videos->count() ) active @endif text-grey-600 text-uppercase ml-3 " href="#details" data-toggle="tab">
                                                DETAILS
                                            </a>
                                        </li>
                                        @if( $test_categories->count() > 0)
                                        <li class="list-inline-item text-center">
                                            <a class="fw-700 ls-3 font-xss text-grey-600 text-uppercase ml-3 " href="#test" data-toggle="tab">
                                                TESTS
                                            </a>
                                        </li>
                                        @endif
                                        @if($package->package_study_materials->count() > 0)
                                            <li class="list-inline-item text-center">
                                                <a class="fw-700 ls-3 font-xss text-grey-600 text-uppercase ml-3 " href="#study_materials" data-toggle="tab">
                                                    STUDY MATERIALS
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade   @if($package->package_videos->count() > 0) show active @endif" id="playlists">
                                    <div class="container pl-0 pr-0">
                                        @foreach( $package->package_categories as $package_category )
                                            @if($package_category['package_videos']->count() > 0)
                                                <div class="category mb-3">
                                                    <h6 class="fw-700  lh-32 text-uppercase rounded-lg ls-2 d-inline-block text-black mb-3">
                                                        {{ $package_category->name }}
                                                    </h6>
                                                    <div class="row card-scroll">
                                                        @foreach( $package_category['package_videos'] as $package_video )
                                                            <div class="col-xs-6 col-sm-6 col-md-3 mb-3">
                                                                <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                                                    <div class="card-image w-100 ">
                                                                        @if( !$package_video->is_demo )
                                                                            @if(\Illuminate\Support\Facades\Auth::user())
                                                                                @if (in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) )
                                                                                    <a href="{{ url('/user/packages/'.$package->name_slug. '?watch='. $package_video->video->id )}}" class="video-bttn position-relative d-block">
                                                                                        <img src="{{ $package_video->thumbnail }}" alt="image" class="w-100">
                                                                                    </a>
                                                                                @else
                                                                                    <a href="#" data-package-video-id="{{ $package_video->video->id }}" class="purchase-alert watch-package-videos video-bttn position-relative d-block">
                                                                                        <img src="{{ $package_video->thumbnail }}" alt="image" class="w-100">
                                                                                    </a>
                                                                                @endif
                                                                            @else
                                                                                <a data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug  }}"  class="login-section video-bttn position-relative d-block">
                                                                                    <img src="{{ $package_video->thumbnail }}" alt="image" class="w-100">
                                                                                </a>
                                                                            @endif
                                                                        @else
                                                                            <a  data-video-src="{{ $package_video->video_src }}"  class="view-demo-video video-bttn position-relative d-block">
                                                                                <img src="{{ $package_video->thumbnail }}" alt="image" class="w-100">
                                                                            </a>
                                                                        @endif

                                                                    </div>
                                                                    <div class="card-body p-2">
                                                                        <div class="row p-2">
                                                                                <div class="col-md-7 col-xs-12 col-sm-12">
                                                                                    <span class="font-xssss text-grey-500 fw-600"><i class="ti-time mr-2"></i>{{ $package_video->video_duration }}</span>
                                                                                </div>
                                                                            @if( $package_video->is_demo)
                                                                                <div class="col-md-5 col-xs-12 col-sm-12 pt-lg-1">
                                                                                    <a data-video-src="{{ $package_video->video_src }}"  class="view-demo-video"  >
                                                                                        <span class="font-xsssss fw-700  pl-2 pr-2 lh-25 text-uppercase rounded-lg ls-2 float-md-right text-center alert-success d-inline-block text-success ">
                                                                                            Demo
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                                @endif
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <h6 class="author-name font-xssss fw-600 mb-0 text-grey-800">
                                                                               @if(! $package_video->is_demo)
                                                                                    @if ( \Illuminate\Support\Facades\Auth::user() && in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) )
                                                                                        <a href="{{ url('/user/packages/'.$package->name_slug. '?watch='. $package_video->video->id )}}" class="text-dark text-grey-900">
                                                                                            {{ $package_video->video->title }}
                                                                                        </a>
                                                                                    @else
                                                                                        <a href="#" class="text-dark text-grey-900">
                                                                                            {{ $package_video->video->title }}
                                                                                        </a>
                                                                                    @endif
                                                                                @else
                                                                                    <a  class="text-dark text-grey-900">
                                                                                        {{ $package_video->video->title }}
                                                                                    </a>
                                                                                @endif
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                             @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-pane fade @if(!$package->package_videos->count()) show active @endif" id="details">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0">
                                                {{$package->description}}
                                            </p>
                                       </div>
                                    </div>

                                    <div class="card d-block border-0 rounded-lg overflow-hidden p-4 shadow-xss mt-4 alert-success">
                                        <h2 class="fw-700 font-sm mb-3 mt-1 pl-1 text-success mb-4">What you'll learn from this lesson</h2>
                                        <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0 pl-2" id="package-content"></p>
                                    </div>

                                    <div class="card d-block border-0 rounded-lg overflow-hidden p-4 shadow-xss mt-4 mb-5">
                                        <h2 class="fw-700 font-sm mb-3 mt-1 pl-1 mb-3">Requirements</h2>
                                        <p class="font-xssss fw-500 lh-28 text-grey-600 mb-0 pl-2" id="requirements"></p>
                                    </div>
                                </div>

                                <div class="tab-pane fade "  id="test">
                                    <div class="container pl-0 pr-0">
                                        @foreach( $test_categories as $test_category )
                                            @if( $test_category['tests']->count() > 0)
                                                <div class="col-12">
                                                    <h6 class="fw-700  lh-32 text-uppercase rounded-lg ls-2 d-inline-block text-black mb-3">
                                                        {{ $test_category->name }}
                                                    </h6>
                                                </div>
                                                <div class="row card-scroll">
                                                    @foreach( $test_category['tests'] as $package_test )
                                                        <div class="col-xs-6 col-sm-6 col-md-4 mb-3">
                                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                                            <div class="card-image w-100 ">
                                                                @if( $user )
                                                                    @if (in_array( $package_test->package_id, $user->purchased_packages ) )
                                                                        <a href="#"   data-test-id ="{{ $package_test['test']['id'] }}"
                                                                           class="@if(!$package->is_active)  re-purchase-alert @else test-detail-modal @endif position-relative d-block">
                                                                            <img src="{{ $package_test['test']['image'] }}" alt="image" class="w-100">
                                                                        </a>
                                                                    @else

                                                                        <a href="#" data-package-test-id="{{  $package_test['test']['id'] }}" class="purchase-alert position-relative d-block">
                                                                            <img src="{{ $package_test['test']['image'] }}" alt="image" class="w-100">
                                                                        </a>
                                                                    @endif
                                                                @else
                                                                    <a data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug }}"  class="login-section position-relative d-block">
                                                                        <img src="{{ $package_test['test']['image'] }}" alt="image" class="w-100">
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <div class="row p-2">
                                                                    <div class="col-md-6 col-sm-6 ">
                                                                        <span class="font-xssss text-grey-500 fw-600"><i class="ti-time mr-2"></i>{{ $package_test['test']['total_time'] }} </span>
                                                                    </div>
                                                                </div>
                                                                <div class="p-2 test-fixed-height" >
                                                                    <h6 class="author-name font-xssss fw-600 mb-0 text-grey-800">
                                                                        <span>{{ \Illuminate\Support\Str::limit( $package_test['test']['display_name'], 20, $end=' ...') }}</span>
                                                                    </h6>
                                                                </div>

                                                                <div class="row pl-2">
                                                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                                                         <span class="font-xssss text-grey-700 float-left fw-600 d-inline-block ">
                                                                           {{ $package_test->test->test_questions->count() }}  Questions
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                                                         <span class="font-xssss float-md-right text-center fw-600 d-inline-block ">
                                                                           {{ $package_test['test']['total_marks'] }}  Marks
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <div class="p-2 text-center">
                                                                    @if( $user )
                                                                        @if (in_array( $package_test->package_id, $user->purchased_packages ) )
                                                                            <a href="#" data-test-id ="{{ $package_test['test']['id'] }}"
                                                                                class="@if(!$package->is_active)  re-purchase-alert @else test-detail-modal @endif position-relative d-block">
                                                                                <button class=" border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">START
                                                                                </button>
                                                                            </a>
                                                                        @else
                                                                            <button data-package-test-id="{{  $package_test['test']['id'] }}" class="purchase-alert border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">
                                                                                START
                                                                            </button>
                                                                        @endif
                                                                    @else
                                                                        <button  data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow"data-package-name ="{{ $package->name_slug  }}"
                                                                                 class="start-quiz-button login-section border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">START
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="study_materials">
                                    <div class="container pl-0 pr-0">
                                        @foreach( $package->package_categories as $package_category )
                                            @if($package_category['package_study_materials']->count() > 0)
                                                <div class="category mb-2 ">
                                                    <h6 class="fw-700  lh-32 text-uppercase rounded-lg ls-2 d-inline-block text-black mb-1">
                                                         {{ $package_category->name }}</a>
                                                    </h6>
                                                    <div class="row card-scroll m-2 ">
                                                        @foreach( $package_category['package_study_materials'] as $package_study_material )
                                                            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                                                                <div class="card mt-3 w-100 p-0 shadow-md border-0 rounded-lg  overflow-hidden mr-1">
                                                                    <div class="card-body p-2">
                                                                        <div class="card-body p-2">
                                                                            <h6 class="author-name font-xssss fw-600 mb-2 text-grey-800"><a href="#" class="text-dark text-grey-900">
                                                                                    {{ $package_study_material->title }}</a>
                                                                            </h6>
                                                                            <p class="font-xssss fw-500 my-1 lh-28 text-grey-600 mb-0">
                                                                                {{$package_study_material->body}}
                                                                            </p>
                                                                            <div class="row p-2">
                                                                                <div class="col-12 col-md-4 text-center pl-2">
                                                                                    @if(\Illuminate\Support\Facades\Auth::user())
                                                                                        @if ( \Illuminate\Support\Facades\Auth::user() && in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) && $package->is_active)
                                                                                            <a download href="{{$package_study_material->document->name }}" class="border-0 p-2 d-inline-block  text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">Download
                                                                                            </a>
                                                                                        @else
                                                                                            <button  class="purchase-alert border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">Download
                                                                                            </button>
                                                                                        @endif
                                                                                    @else
                                                                                        <button data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug }}"  class="login-section border-0 p-2 d-inline-block  text-white fw-700 lh-27  rounded-lg w125 font-xsssss ls-3 bg-current">Download
                                                                                        </button>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-xxl-3 col-lg-4">
                    <div class="card p-4 mb-4 bg-primary border-0 shadow-xss rounded-lg">
                        <div class="card-body">
                            <!--<h2 class="text-white font-xsssss fw-700 text-uppercase ls-3 ">Starter</h2>-->
                            @if( $package->package_offer_percentage )
                                <h1 class="display2-size text-white fw-700">₹ {{ number_format( $package->offer_price ) }}
                                   <br> <span class="font-xss"><strike> ₹ {{ number_format( $package->price ) }}</strike> </span>
                                </h1>
                                <h4 class="text-white fw-500 mb-4 lh-24 font-xssss">
                                    {{ $package->package_offer_percentage }}% OFF. Best time to buy this course
                                </h4>
                            @else
                                <h1 class="display2-size text-white fw-700">₹ {{ number_format( $package->price ) }}</h1>
                            @endif
                            <h4 class="text-white font-xssss mb-2"><i class="ti-check mr-2 text-white"></i> Valid upto
                                {{$package->expire_on }} Days</h4>
                            <h4 class="text-white font-xssss mb-2"><i class="ti-check mr-2 text-white"></i> Unlimited views</h4>
                            <h4 class="text-white font-xssss mb-2"><i class="ti-check mr-2 text-white"></i> Everything in Free</h4>
                            @if(\Illuminate\Support\Facades\Auth::user())
                               @if ( in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) )
                                    @if($package->is_active)
                                        <a href="{{ url( '/user/packages/'. $package->name_slug ) }}" class="btn btn-block border-0 w-100 bg-white p-3 mt-2 text-primary fw-600 rounded-lg d-inline-block font-xssss btn-light">Watch Now</a>
                                    @else
                                        <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class="btn btn-block border-0 w-100 bg-white p-3 mt-2 text-primary fw-600 rounded-lg d-inline-block font-xssss btn-light">Buy Now</a>
                                    @endif
                                 @else
                                    <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class="btn btn-block border-0 w-100 bg-white p-3 mt-2 text-primary fw-600 rounded-lg d-inline-block font-xssss btn-light">Buy Now</a>
                               @endif
                            @else
                                <a href="#"  data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug  }}"  class="login-section btn btn-block border-0 w-100 bg-white p-3 mt-2 text-primary fw-600 rounded-lg d-inline-block font-xssss btn-light">Buy Now</a>
                            @endif
                        </div>
                    </div>
                    <div class="card w-100 border-0 mt-0 mb-4 p-4 shadow-xss position-relative rounded-lg bg-white">
                        <div class="row">
                            <div class="col-5 pr-0">
                                <h2 class="display3-size lh-1 m-0 text-grey-900 fw-700">{{ number_format($package->average_package_rating,1) }}</h2>
                            </div>
                            <div class="col-7 pl-0 text-right">
                                <div class="star d-block w-100 text-right">
                                    @for( $i=1; $i<=$package->average_package_rating; $i++ )
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10">
                                    @endfor
                                    @for( $j=1; $j<=(5-$package->average_package_rating); $j++ )
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10">
                                    @endfor
                                </div>
                                <h4 class="font-xsssss text-grey-600 fw-600 mt-1">Based on {{ $package->package_ratings->count() }}
                                    @if( $package->package_ratings->count() >1 ) ratings @else rating @endif</h4>
                            </div>
                        </div>
                        <div class="bg-greylight theme-dark-bg rounded-sm p-2 mt-3 mb-4">
                            @for( $i=5; $i>=1; $i-- )
                            <div class="row mt-1">
                                <div class="col-3 pr-1 mt-0"><img src="/images/star.png" alt="star" class="w10 float-left"><h4 class="font-xsss fw-600 text-grey-600 ml-1 float-left d-inline">{{ $i }}</h4></div>
                                <div class="col-6 pl-0 mr-0">
                                    <div id="bar_1" data-value="45" class="bar-container">
                                        <div class="bar-percentage" style="width:{{$package->rating_percentage[$i]}}%;"></div>
                                    </div>
                                </div>
                                <div class="col-3 pl-0"><h4 class="font-xssss fw-600 text-grey-800">{{ $package->rating_percentage[$i] }}%</h4></div>
                            </div>
                            @endfor
                        </div>

                        @foreach( $package->package_ratings as $package_rating )
                        <div class="row">
                            <div class="col-2 text-left">
                                <figure class="avatar float-left mb-0"><img src=" @if($package_rating->student->image) {{$package_rating->student->image }} @else {{ url('/web/images/student_avatar.jpg') }}  @endif" alt="image" class="float-right shadow-none w40 mr-2"></figure>
                            </div>
                            <div class="col-10 pl-4">
                                <div class="content">
                                    <h6 class="author-name font-xssss fw-600 mb-0 text-grey-800">{{ $package_rating->user_name }}</h6>
                                    <h6 class="d-block font-xsssss fw-500 text-grey-500 mt-2 mb-0">{{ $package_rating->created_at }}</h6>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="star d-block w-100 text-left">
                                                @for( $i=1; $i<=$package_rating->rating; $i++ )
                                                    <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10">
                                                @endfor
                                                @for( $j=1; $j<=(5-$package_rating->rating); $j++ )
                                                    <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10">
                                                @endfor
                                            </div>
                                        </div>
{{--                                        <div class="col-4">--}}
{{--                                            <img src="{{ asset('web/images/trash.png') }}" alt="star" class="w10 float-right pt-2">--}}
{{--                                        </div>--}}
                                    </div>
                                    <p class="comment-text lh-24 fw-500 font-xssss text-grey-500 mt-2">{{ $package_rating->comment }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="row">
                            @if(\Illuminate\Support\Facades\Auth::user() )
                                @if(in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) && $package->is_active)
                                    @if(!$rating_count)
                                        <a href="#" id="addReviewBtn" data-package-id="{{ $package->id }}"  data-toggle="modal" data-target="#packageReviewModal" class="d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                                    @else
                                        <a href="#"  class="review-alert d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                                    @endif
                                @else
                                    <a href="#"  class="purchase-alert d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                                @endif
                            @else
                                <a href="#" data-toggle="modal" data-target="#Modallogin" data-redirect-page="packageShow" data-package-name ="{{ $package->name_slug  }}"  class="login-section d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script>

    $(".start-quiz-button").click(function (e) {

        var isLoggedInUser = $(this).val();

        if (!isLoggedInUser) {
            $('#Modallogin').modal('toggle');
        } else {
            var testId = $(this).data('test-id');

            var url = '{{ url('/user/tests') }}' + '/'+testId+'?question=1';

            window.location.href =  url;
        }

    });
    $('.test-detail-modal').click(function (e) {
        e.preventDefault();
        let testId = $(this).data('test-id');
        let packageId = '{{ $package->id }}';

        $(" #user-testId").val( testId );
        $(" #user-packageId").val( packageId );

        let url = '{{ url ('user/test/details/') }}' + '/' +testId;
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                "_token": "{{ csrf_token() }}",
                'testId': testId
            },
            success: function(response){

                $("#test-name").text(response.name);
                $("#test-display-name").text(response.display_name);
                $("#test-total-questions").text(response.total_questions + ' Questions');
                $("#test-total-time").text(response.total_time);
                $("#test-correct-answer-mark").text( 'Correct Answer Mark : ' + response.correct_answer_marks);
                $("#test-negative-mark").text('Negative Mark : ' +  response.negative_marks);
                $("#test-cut-off-mark").text('Cutt Off Mark : ' + response.cut_off_marks );
                $("#test-total-mark").text( 'Marks : ' + response.total_marks);
                $("#test-description").text(response.description);
                $('#testModal').modal('toggle');
            }
        });

    });

    $(".re-purchase-alert").click(function (e) {
        e.preventDefault();
        swal("Your subscription has ended. Re-purchase to continue.")
            .then ( function() {
                var url = '{{ url('checkout?package='.$package->name_slug) }}';
                window.location = url;
            });
    });

    $(".purchase-alert").click(function (e) {
        e.preventDefault();
        swal("Click here to purchase package.")
            .then ( function() {
                var url = '{{ url('checkout?package='.$package->name_slug) }}';
                window.location = url;
            });
    });


    $(".review-alert").click(function (e) {
        e.preventDefault();
        swal("You have already added your Review!")
    });


    $(".view-demo-video").click(function (e) {
        $('#demoVideoModal').modal('toggle');

        var video_src = $(this).data('video-src');

        $("#demo-video-player").attr("src", video_src);
    });

    @if (session('error'))
        toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };
    toastr.error(session('error'));
    @endif


    //what you'll learn section html parsed and appended to <p>
    let package_contents = @json( $package->package_content );
    let package_content_data = JSON.parse( package_contents );

    const edjsParser = edjsHTML();
    const  parsed_package_contents = edjsParser.parse( package_content_data );

    $(parsed_package_contents).each(function( index, parsed_package_content ) {
        $("#package-content").append(parsed_package_content);
    });

    $(document).on("click", "#addReviewBtn", function () {
        var package_id = {{ $package->id }};
        $("#packageReviewModal .modal-body #package-id").val( package_id );
    });

    //requirements section html parsed and appended to <p>
    let requirements = @json( $package->requirements );
    let requirements_data = JSON.parse( requirements );

    const  parsed_requirements = edjsParser.parse( requirements_data );

    $(parsed_requirements).each(function( index, parsed_requirement ) {
        $("#requirements").append(parsed_requirement);
    });

    $(".login-section").click(function (e) {
        e.preventDefault();

        let redirect = $(this).data('redirect-page');
        let packageName = $(this).data('package-name');
        $(".modal-body #redirect").val( redirect );
        $(".modal-body #packageName").val( packageName );

    });

    </script>
@endpush

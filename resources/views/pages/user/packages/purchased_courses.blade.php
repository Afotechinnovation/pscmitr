@extends('layouts.app')

@section('title', 'Courses')

@section('meta')
    <meta property="og:title" content="{{ $package->display_name }}" />
    <meta property="og:type" content="text" />
    <meta property="og:url" content="">
    <meta property="og:description" content="{{ $package->description }}">
    <meta property="og:image" content="{{ $package->cover_pic }}" />
    <style>
        /*.vid{*/
        /*    transform: scale(1.5);*/
        /*}*/
        /*.container{ width: 100%; height: 500px; overflow: hidden; }*/
    </style>
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
                    @if($package->is_active)
                        <div class="card border-0 mb-0 rounded-lg overflow-hidden">
                            @if($packageVideoCount > 0)
                                @if( $purchasedPackageVideo )
                                    <iframe class="vid" src="{{ $purchasedPackageVideo->video_src }}"  allow="autoplay; fullscreen; picture-in-picture"
                                        width="100%" height="500px" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                        allowfullscreen>
                                    </iframe>
                                @else
                                <div class="player shadow-none">
                                    <video id='video' src='https://via.placeholder.com/1200x600.png' playsinline></video>
                                    <div class='play-btn-big'></div>
                                    <div class='controls'>
                                        <div class="time"><span class="time-current"></span><span class="time-total"></span></div>
                                        <div class='progress'>
                                            <div class='progress-filled'></div>
                                        </div>
                                        <div class='controls-main'>
                                            <div class='controls-left'>
                                                <div class='volume'>
                                                    <div class='volume-btn loud mt-1'>
                                                        <i class="feather-volume-1 font-xl text-white"></i>
                                                    </div>
                                                    <div class='volume-slider'>
                                                        <div class='volume-filled'></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='play-btn paused'></div>
                                            <div class="controls-right">
                                                <div class='speed'>
                                                    <ul class='speed-list'>
                                                        <li class='speed-item' data-speed='0.5'>0.5x</li>
                                                        <li class='speed-item' data-speed='0.75'>0.75x</li>
                                                        <li class='speed-item active' data-speed='1'>1x</li>
                                                        <li class='speed-item' data-speed='1.5'>1.5x</li>
                                                        <li class='speed-item' data-speed='2'>2x</li>
                                                    </ul>
                                                </div>
                                                <div class='fullscreen'>
                                                    <svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0V-1.5H-1.5V0H0ZM0 18H-1.5V19.5H0V18ZM26 18V19.5H27.5V18H26ZM26 0H27.5V-1.5H26V0ZM1.5 6.54545V0H-1.5V6.54545H1.5ZM0 1.5H10.1111V-1.5H0V1.5ZM-1.5 11.4545V18H1.5V11.4545H-1.5ZM0 19.5H10.1111V16.5H0V19.5ZM24.5 11.4545V18H27.5V11.4545H24.5ZM26 16.5H15.8889V19.5H26V16.5ZM27.5 6.54545V0H24.5V6.54545H27.5ZM26 -1.5H15.8889V1.5H26V-1.5Z" transform="translate(2 2)" fill="white"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @else
                                <img src="{{ $package->cover_pic }}" alt="image" class="w-100">
                            @endif
                        </div>
                    @else
                        <div class="card border-0 mb-0 rounded-lg overflow-hidden">
                            <div class="alert alert-danger" role="alert">
                               <p>Oops! Your package has expired. @if(in_array($package->id, $deletedPackages))  This package is not available now @else  Please purchase again to continue.   @endif</p>
                            </div>
                            <img src="{{ $package->cover_pic }}" alt="image" class="w-100">
                        </div>
                    @endif

                        <div class="card d-block border-0 rounded-lg dark-bg-transparent bg-transparent mt-4 pb-3">
                        <div class="row">
                            <div class=" @if ( in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages)  && $package->is_active ) col-md-10 col-sm-12   @else  col-9  @endif "><h4 class="fw-700 font-md d-block lh-4 mb-2 pr-0 ">{{ $package->display_name }}</h4></div>
                            <div class="@if(!$package->is_active)  col-1  @else col-2 @endif  d-none d-md-block">
                                <a href="#" class="btn-round-md ml-0 d-inline-block rounded-lg bg-greylight float-right"
                                   id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather-share-2 font-sm text-grey-700 "></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right p-3 border-0 shadow-xss"  aria-labelledby="dropdownMenu2">
                                    <ul class="d-flex align-items-center mt-0 float-left">
                                        <li class="mr-2"><h4 class="fw-600 font-xss text-grey-900  mt-2 mr-3">Share: </h4></li>
                                        <li class="mr-2">
                                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('packages/'.$package->id )}}" target="_blank" class="btn-round-md bg-facebook">
                                                <i class="font-xs ti-facebook text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="https://twitter.com/intent/tweet?text={{ url('packages/'.$package->id) }}" target="_blank"  class="btn-round-md bg-twiiter">
                                                <i class="font-xs ti-twitter-alt text-white"></i>
                                            </a>
                                        </li>
                                        <li class="mr-2">
                                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url('packages/'.$package->id) }}&summary={{ $package->description }}&source={{ (env('APP_DOMAIN')) }}" target="_blank"  class="btn-round-md bg-linkedin">
                                                <i class="font-xs ti-linkedin text-white"></i>
                                            </a>
                                        </li>
                                        {{--                                        <li class="mr-2"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></li>--}}
                                        <li class="mr-2">
                                            <a href="http://pinterest.com/pin/create/button/?url={{ url('packages/'.$package->id) }}&description={{ $package->description }}" target="_blank" class="btn-round-md bg-pinterest">
                                                <i class="font-xs ti-pinterest text-white"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="@if(!$package->is_active) col-2 pl-0 @else col-0 @endif ">
                                @if(!$package->is_active )
                                    @if((in_array($package->id, $deletedPackages)))
                                        <a href="#" class=" text-white bg-danger available-button
                                        rounded-lg  p-2 w125 font-xsss text-center fw-500 d-inline-block mb-0">Not Available
                                        </a>
                                    @else
                                       <a href="{{ url( 'checkout?package='. $package->name_slug ) }}" class=" text-white bg-current buy-button
                                            rounded-lg  p-2 w125 lh-32 font-xsss text-center fw-500 d-inline-block mb-0">Buy Now
                                       </a>
                                    @endif
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
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ url('user/packages/'.$package->id )}}" target="_blank" class="btn-round-md bg-facebook">
                                                    <i class="font-xs ti-facebook text-white"></i>
                                                </a>
                                            </li>
                                            <li class="mr-2">
                                                <a href="https://twitter.com/intent/tweet?text={{ url('user/packages/'.$package->id) }}" target="_blank"  class="btn-round-md bg-twiiter">
                                                    <i class="font-xs ti-twitter-alt text-white"></i>
                                                </a>
                                            </li>
                                            <li class="mr-2">
                                                <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ url('user/packages/'.$package->id) }}&summary={{ $package->description }}&source={{ (env('APP_DOMAIN')) }}" target="_blank"  class="btn-round-md bg-linkedin">
                                                    <i class="font-xs ti-linkedin text-white"></i>
                                                </a>
                                            </li>
                                            {{--                                        <li class="mr-2"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></li>--}}
                                            <li class="mr-2">
                                                <a href="http://pinterest.com/pin/create/button/?url={{ url('user/packages/'.$package->id) }}&description={{ $package->description }}" target="_blank" class="btn-round-md bg-pinterest">
                                                    <i class="font-xs ti-pinterest text-white"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <span class="font-xssss fw-700 text-primary d-inline-block ml-0 ">{{$package->title}}</span>
                        <span class="font-xssss fw-700 text-black d-inline-block ml-0 ">@if($package->is_active)   Expires In  :  @if($package->expiry_date == -1) Today @else  {{ $package->expiry_date }} @if($package->expiry_date == 1) Day @else Days @endif @endif @else Package Expired @endif </span>

                    </div>
                    @if($totalPackageTestCount  == $UserCompletedTestCount)
                        <div class="row">
                                <div class="col">
                                    <h2>Congratulations!. You have completed the course. <a href="{{route('user.package.certificate_download')}}" class="certificate">Download Your Certificate</a></h2>
                                </div>
                        </div>
                    @endif
                    <div class="how-to-work pt-lg--2 pb-lg-2">
                        <div class="container pl-0 pr-0">
                            <div class="row justify-content-center">
                                <div class="page-title style1 col-xl-12 col-lg-12 col-md-12 text-center mt-1 mb-3">
                                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                                        @if($package->package_videos->count() >= 1)
                                            <li class="active list-inline-item text-center">
                                                <a class="fw-700 ls-3 font-xss text-grey-600 text-uppercase ml-3 active" href="#playlists" data-toggle="tab">
                                                    PLAYLISTS
                                                </a>
                                            </li>
                                        @endif
                                        <li class="list-inline-item @if(!$package->package_videos->count()) active @endif text-center">
                                            <a class="fw-700 ls-3 font-xss  @if(!$package->package_videos->count()) active @endif text-grey-600 text-uppercase ml-3 " href="#details" data-toggle="tab">
                                                DETAILS
                                            </a>
                                        </li>
                                        @if($package->package_tests->count() >= 1)
                                        <li class="list-inline-item text-center">
                                            <a class="fw-700 ls-3 font-xss text-grey-600 text-uppercase ml-3 " href="#test" data-toggle="tab">
                                                TESTS
                                            </a>
                                        </li>
                                        @endif
                                        @if($package->package_study_materials->count() >= 1)
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
                                        @foreach($package->package_categories as $package_category)
                                            @if($package_category['package_videos']->count() > 0)
                                                <div class="category mb-3">
                                                <h6 class="fw-700  lh-32 text-uppercase rounded-lg ls-2 d-inline-block text-black mb-3">
                                                    {{$package_category->name}}
                                                </h6>
                                                <div class="row card-scroll">
                                                    @foreach($package_category['package_videos'] as $package_video)
                                                        <div class="col-xs-6 col-sm-6 col-md-3 mb-3">
                                                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                                                <div class="card-image w-100 ">
                                                                    @if( !$package_video->is_demo )
                                                                        @if ( \Illuminate\Support\Facades\Auth::user() && in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) && $package->is_active )
                                                                            <a href="{{ url('/user/packages/'.$package->name_slug. '?watch='. $package_video->video_id )}}" class="video-bttn position-relative d-block">
                                                                                <img src="{{ $package_video->thumbnail }}" alt="image" class="w-100">
                                                                            </a>
                                                                        @else
                                                                            <a href="#" class="video-bttn position-relative d-block">
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
                                                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                                                            <span class="font-xssss text-grey-500 fw-600"><i class="ti-time mr-2"></i>{{ $package_video->video_duration }}</span>
                                                                        </div>
                                                                        @if( $package_video->is_demo)
                                                                            <div class="col-md-5 col-sm-12 col-xs-12 pt-lg-1">
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
                                                                                    <a href="{{ url('/user/packages/'.$package->name_slug. '?watch='. $package_video->video_id )}}" class="text-dark text-grey-900">
                                                                                        {{ $package_video->title }}
                                                                                    </a>
                                                                                @else
                                                                                    <a href="#" class="text-dark text-grey-900">
                                                                                        {{ $package_video->title }}
                                                                                    </a>
                                                                                @endif
                                                                            @else
                                                                                <a  class="text-dark text-grey-900">
                                                                                    {{ $package_video->title }}
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
                                                    @foreach( $test_category['tests'] as $package_test)
                                                    <div class="col-xs-6 col-sm-6 col-md-4 mb-3">
                                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                                            <div class="card-image w-100 ">
                                                                <a href="#" data-test-id ="{{ $package_test['id'] }}" data-package-id ="{{ $package->id }}"
                                                                   class="@if(!$package->is_active)  @if((in_array($package->id, $deletedPackages))) package-not-available @else  purchase-alert  @endif @else test-detail-modal @endif test position-relative d-block">
                                                                    <img src="{{ $package_test['image'] }}" alt="image" class="w-100">
                                                                </a>
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <div class="row p-2">
                                                                    <div class="col-md-6 col-sm-6 ">
                                                                        <span class="font-xssss text-grey-500 fw-600"><i class="ti-time mr-2"></i>{{ $package_test['total_time'] }} </span>
                                                                    </div>
                                                                </div>
                                                                <div class="p-2  test-fixed-height">
                                                                    <h6 class="author-name font-xssss fw-600 mb-0 text-grey-800 title-fixed-height">
                                                                        <span>{{ \Illuminate\Support\Str::limit( $package_test['display_name'], 20, $end=' ...') }} </span>
                                                                    </h6>
                                                                </div>
                                                                <div class="row pl-2">
                                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                                         <span class="font-xssss text-grey-700 float-md-left text-center fw-600 d-inline-block ">
                                                                          {{ $package_test->test_questions->count() }}  Questions
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-12 col-xs-12 ">
                                                                         <span class="font-xssss float-md-right  fw-600 d-inline-block text-center">
                                                                           {{ $package_test['total_marks'] }}  Marks
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                 <div class="p-2 text-center">
                                                                    <a href="#" data-test-id ="{{ $package_test['id'] }}" data-package-id ="{{ $package->id }}"
                                                                        class="@if(!$package->is_active)  @if((in_array($package->id, $deletedPackages))) package-not-available @else  purchase-alert  @endif @else test-detail-modal @endif position-relative d-block">
                                                                        <button class=" border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">START
                                                                        </button>
                                                                    </a>
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
                                                <div class="category mb-2">
                                                    <h6 class="fw-700  lh-32 text-uppercase rounded-lg ls-2 d-inline-block text-black mb-1">
                                                        {{ $package_category->name }}</a>
                                                    </h6>
                                                </div>
                                                <div class="row m-2 card-scroll">
                                                    @foreach( $package_category['package_study_materials'] as $package_study_material )
                                                        <div class="col-xs-12 col-sm-12 col-md-12 mb-3 ">
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
                                                                        <div class="col-12 col-md-4 text-left pl-2">
                                                                            @if($package->is_active)
                                                                                @if ( \Illuminate\Support\Facades\Auth::user() && in_array( $package->id, \Illuminate\Support\Facades\Auth::user()->purchased_packages) )
                                                                                    <a download href="{{$package_study_material->document->name }}"
                                                                                       class="border-0 p-2 d-inline-block  text-center text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">Download
                                                                                    </a>
                                                                                @else
                                                                                    <button class="border-0 p-2 d-inline-block text-center  text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">Download
                                                                                    </button>
                                                                                @endif
                                                                            @else
                                                                                <button class="@if(in_array($package->id, $deletedPackages)) package-not-available @else  purchase-alert @endif  border-0 p-2 d-inline-block text-center  text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">Download
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
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-xxl-3 col-lg-4">
                    <div id="accordion" class="accordion mb-0">
                        @foreach( $package->package_categories as $key => $package_category )
                            @if($package_category['package_videos']->count() > 0)
                                <div class="card shadow-xss mb-0">
                                <div class="card-header bg-greylight theme-dark-bg" id="headingOne">
                                    <h5 class="mb-0"><button class="btn font-xsss fw-600 btn-link" data-toggle="collapse" data-target="#collapseOneOne"
                                        aria-expanded="true" aria-controls="collapseOneOne">{{ $package_category->name }}</button>
                                    </h5>
                                </div>
                                <div id="collapseOneOne" class="p-3 collapse @if( $key == 0 ) show @endif " aria-labelledby="headingOne" data-parent="#accordion" style="">
                                    @foreach( $package_category['package_videos'] as $video_key => $package_video)
{{--                                        <p>{{ $package_video }}</p>--}}
                                        <div class="card-body d-flex p-2">
                                            <a href="{{ url('/user/packages/'.$package->name_slug.'?watch='.$package_video->video->id) }}">
                                                <span class="bg-current btn-round-xs rounded-lg font-xssss text-white fw-600"> {{ $video_key + 1 }} </span>
                                                <span class="font-xssss fw-500 text-grey-500 ml-2">{{ $package_video->video ? $package_video->video->title : '' }}</span>
                                                <span class="ml-auto font-xssss fw-500 text-grey-500">{{ $package_video->video_duration }}</span>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
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
                            <div class="row" id="package-rating-id">
                                <div class="col-2 text-left">
                                    <figure class="avatar float-left mb-0"><img src="@if($package_rating->student->image) {{$package_rating->student->image }} @else {{ url('/web/images/student_avatar.jpg') }}  @endif" alt="image" class="float-right shadow-none w40 mr-2"></figure>
                                </div>
                                <div class="col-10 pl-4">
                                    <div class="content">
                                        <h6 class="author-name font-xssss fw-600 mb-0 text-grey-800">{{ $package_rating->user_name }}</h6>
                                        <h6 class="d-block font-xsssss fw-500 text-grey-500 mt-2 mb-0">{{ $package_rating->created_at }}</h6>
                                        <div class="row" >
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

                                            @if(\Illuminate\Support\Facades\Auth::user()->id == $package_rating->user_id)
                                                <div class="col-4 ">
                                                    <a href="#" data-package-rating-id="{{$package_rating->id}}"
                                                       class="rating-button-delete btn btn-sm btn-icon btn-pure btn-default ladda-button " data-toggle="tooltip"
                                                       data-original-title="Delete"  data-style="zoom-in" id="rating-button-delete">
                                                        <span class="ladda-label"><img src="{{ asset('web/images/trash.png') }}" alt="star" class=" w10 float-right pt-2"></span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="comment-text lh-24 fw-500 font-xssss text-grey-500 mt-2">{{ $package_rating->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            @if($package->is_active)
                                @if(\Illuminate\Support\Facades\Auth::user() && $package_ratings->count() == 0)
                                    <a href="#" id="addReviewBtn" data-package-id="{{ $package->id }}"  data-toggle="modal" data-target="#packageReviewModal" class="d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                                @else
                                    <a href="#"  class="review-alert d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
                                @endif
                            @else
                                <a href="#"  class="@if(in_array($package->id, $deletedPackages)) package-not-available @else  purchase-alert @endif d-block p-2 lh-32 w-100 text-center ml-3 mr-3 bg-greylight fw-600 font-xssss text-grey-900">Add a Review</a>
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

        $(".view-demo-video").click(function (e) {
            $('#demoVideoModal').modal('toggle');

            var video_src = $(this).data('video-src');

            $("#demo-video-player").attr("src", video_src);
        });

        $(".review-alert").click(function (e) {
            e.preventDefault();
            swal("You have already added your Review!")

        });

        $(".package-not-available").click(function (e) {
            e.preventDefault();
            swal("This package is not available now!")

        });
        $(".purchase-alert").click(function (e) {
            e.preventDefault();

            swal("Your subscription has ended. Re-purchase to continue.")
                .then ( function() {
                    var url = '{{ url('checkout?package='.$package->name_slug) }}';
                    window.location = url;
                });
        });

        $('.test-detail-modal').click(function (e) {
            e.preventDefault();
            let testId = $(this).data('test-id');
            let packageId = $(this).data('package-id');

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

        $('.rating-button-delete').click(function(e){
            e.preventDefault();
            let packageId = $(this).data('package-rating-id');

            let url = '{{ route('user.packages.ratings.destroy') }}'

            let confirmation = confirm("Delete this item?");

            if(confirmation){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id" : packageId
                    }
                }).done(function (data, textStatus, jqXHR) {
                    $("#package-rating-id").load(" #package-rating-id");
                    toastr.success('Review deleted.');
                    location.reload(true);
                });
            }
        });

        $('.certificate').click(function (e) {
            e.preventDefault();
            let packageId = '{{ $package->id }}';

            let url =  '{{ url('user/package/course/completion') }}'  +'?package=' + packageId;

            window.location.href = url;

        });

        $('#btn-clear').click(function (e) {
            e.preventDefault();
            search: $('#search').val('');
            date: $('#date').val('');

            $table.DataTable().draw();
        });

    </script>
@endpush

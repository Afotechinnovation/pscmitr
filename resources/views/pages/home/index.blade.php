@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div style="@if(!$banner) background:url('/web/images/pscmitr-signup.jpg'); @else background:url({{ $banner->image }}); @endif background-size: cover; background-position: center;" class=" banner-wrapper bg-after-fluid">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 order-lg-1 pt-lg--10 pb-lg--10 xl-p-5 text-center pl-3 pr-3">
                    <h2 class="display3-size display2-md-size fw-700 aos-init" data-aos="fade-up" data-aos-delay="100"
                        data-aos-duration="500">Learn with us<br>
                        to live <span class="text-current">your dreams</span>
                    </h2>
                    <div class="form-group mt-lg-5 border-info border bg-white  aos-init"
                         data-aos="fade-up" data-aos-delay="300" data-aos-duration="500">
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group icon-input mb-0">
                                    <i class="ti-search font-xs text-grey-400"></i>
                                    <input type="text" id="search-courses" class="style1-input bg-transparent border-0 col-12 pl-5 font-xs mb-0
                                    text-grey-500 fw-500" placeholder="Search exam">
                                </div>
                            </div>
                            <div class="col-4">
                                <a href="#"  id="search-course-btn" class="w-50 rounded-0 float-right  d-block btn bg-current text-white font-xssss fw-600 ls-3
                                style1-input p-0 border-0 text-uppercase"><i class="ti-search font-xs text-grey-400"></i></a>
                            </div>
                        </div>
                    </div>
                    @if($popular_searches->count())
                    <h4 class="text-grey-500 font-xss fw-500 ml-1 lh-24">
                        <b class="text-grey-800">Popular Search :</b>
                        @foreach($popular_searches as $key => $popular_search)
                          <a href="{{url('courses?search='.$popular_search->name)}}">
                              <span class="badge badge-pill badge-primary">{{$popular_search->name}}</span>
                          </a>
                        @endforeach
                    </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
{{--    @if (  \Illuminate\Support\Facades\Auth::user())--}}
{{--        @if (in_array(  \Illuminate\Support\Facades\Auth::user()->id , \Illuminate\Support\Facades\Auth::user()->purchased_users) )--}}
{{--            fvgd--}}
{{--        @endif--}}
{{--    @endif--}}


        <div class="container mt-3">
        <div class="col-12">
            <div class="row">
                <div class="drop-buttons col-lg-4 col-md-12  p-3 text-center m-border-radius mb-2" style="border-bottom-left-radius: 10px; border-top-left-radius: 10px">
                    <a class="text-white" href="#" data-toggle="modal" data-target="#testWinnerModal" >
                        <h2 class="fw-700">Test Winners</h2>
                    </a>
                </div>
                <div class="drop-buttons  col-lg-4 col-md-12   p-3 text-center m-border-radius mb-2">
                    <a class="text-white" href="{{ route('today_test') }}"  >
                        <h2 class="fw-700">Today Test</h2>
                    </a>
                </div>
                <div class="drop-buttons  col-lg-4 col-md-12   p-3 rounded-end text-center m-border-radius mb-2" style="border-bottom-right-radius: 10px; border-top-right-radius: 10px">
                    <a class="text-white" href="{{ route('live-test') }}">
                        <h2 class="fw-700">Live Test</h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

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
                                <div class="card w-100 p-0 shadow-xss border-0 rounded-lg  mr-1" >
                                    <div class="card-image w-100 mb-3">
                                        <a href="{{ url('packages/'.$package->name_slug) }}" class="@if( $package->package_videos->count() >= 1 )video-bttn @endif position-relative d-block"><img src="{{ $package->image_url }}" alt="image" class="w-100"></a>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row p-1">
                                            <div class="col-md-6 col-sm-12 col-xs-12 mobile-text-center pl-md-3 p-0">
                                                <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2">
                                                    {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Videos @else Video @endif
                                                    +  {{ $package->package_tests->count() }}  @if( $package->package_tests->count() > 1 ) Tests @else Test @endif
                                                </h6>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12 d-contents">
                                                {{--                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">{{ $package->subject ? $package->subject->name : '' }}</span>--}}
                                                @if( $package->offer_price )
                                                    <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->offer_price }}</span>
                                                    <span class="font-xsssss fw-700 pl-3 pr-0 ls-2 lh-32 d-inline-block text-grey-600 float-right"><strike><span class="font-xsss">₹</span> {{ $package->price }}</span></strike>
                                                @else
                                                    <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <h4 class="fw-700 font-xss mt-3 lh-28 mt-0 description-row"><a href="{{ url('packages/'.$package->name_slug )}}" class="text-dark text-grey-900">{{\Illuminate\Support\Str::limit( $package->display_name , 15, $end=' ...') }} </a></h4>
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
                                                <div class="pl-3 review-link mt-md-0 mt-2 font-xssss float-md-right text-sm-center mb-2 fw-500 text-grey-500 lh-3">
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
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <a href="{{route('packages.index')}}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">View More</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($test_only_courses->count() > 0)
        <div class="how-to-work pt-lg--7 pb-lg--4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                        <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Test Only Packages</h2>
                        <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                            @foreach($test_only_courses as $key => $test_only_course)
                                <li class="list-inline-item @if( $key == 0 ) active @endif">
                                    <a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3 @if( $key == 0 ) active @endif" href="#navtabstest{{ $test_only_course->id }}" data-toggle="tab">{{ $test_only_course->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    @foreach( $test_only_courses as $key => $course )
                        <div class="tab-pane  @if( $key == 0 ) show active @else fade @endif" id="navtabstest{{ $course->id }}">
                            <div class="row card-scroll">
                                @foreach( $course['packages'] as $package )
                                    @if($package['package_tests']->count() && $package['package_videos']->count() == 0 )
                                    <div class="col-xl-4 col-sm-6 col-xs-6 d-inline-block mb-4">
                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1" >
                                            <div class="card-image w-100 mb-3">
                                                <a href="{{ url('packages/'.$package->name_slug) }}" class="@if( $package->package_videos->count() >= 1 ) video-bttn @endif position-relative d-block"><img src="{{ $package->image_url }}" alt="image" class="w-100"></a>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row p-1">
                                                    <div class="col-md-5 col-sm-12 col-xs-12 mobile-text-center pl-md-3 p-0">
                                                        <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2 ">
                                                            {{ $package->package_videos->count() }}  @if( $package->package_videos->count() > 1 ) Videos @else Video @endif
                                                            +  {{ $package->package_tests->count() }}  @if( $package->package_tests->count() > 1 ) Tests @else Test @endif
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-7 col-sm-12 col-xs-12 d-contents">
{{--                                                        <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">{{ $package->subject ? $package->subject->name : '' }}</span>--}}
                                                        @if( $package->offer_price )
                                                            <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->offer_price }}</span>
                                                            <span class="font-xsssss fw-700 pl-3 pr-0 ls-2 lh-32 d-inline-block text-grey-600 float-right"><strike><span class="font-xsss">₹</span> {{ $package->price }}</span></strike>
                                                        @else
                                                            <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsss">₹</span> {{ $package->price }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <h4 class="fw-700 font-xss mt-3 lh-28 mt-0 description-row"><a href="{{ url('packages/'.$package->name_slug )}}" class="text-dark text-grey-900">{{\Illuminate\Support\Str::limit( $package->display_name , 15, $end=' ...') }} </a></h4>
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
                                                        <div class="pl-3 review-link mt-md-0 mt-2 font-xssss float-md-right text-sm-center mb-2 fw-500 text-grey-500 lh-3">
                                                            {{ $package->total_package_reviews }} customer @if( $package->total_package_reviews > 1 )reviews @else review @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="feature-wrapper layer-after pt-lg--7 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title mx-5 style1 col-xl-12 col-lg-8 col-md-10 text-center mb-5">
                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Why to take test & Learn with <span class="text-current">PscMitr</span></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="500">
                        <i class="feather-book-open text-danger font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Focused Test Series</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Subjectwise & Final Exam oriented mock tests.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="500">
                        <i class="feather-bar-chart text-info font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">360° Data Driven Analysis</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Identify your strength & weakness based on exams taken.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="500">
                        <i class="feather-help-circle text-warning font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Quick Support</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">We are happy to solve your queries at the earliest.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="feature-card card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="500">
                        <i class="feather-users text-secondary font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Best Faculties</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">We bring the subject matter experts to teach you.</p>
                    </div>
                </div>

{{--                <div class="col-lg-4 col-md-6">--}}
{{--                    <div class="feature-card card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="500">--}}
{{--                        <i class="feather-globe text-success font-xl position-absolute left-15 ml-2"></i>--}}
{{--                        <h2 class="fw-700 font-xss text-grey-900 mt-1">10000+ happy Students</h2>--}}
{{--                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    @if( $exam_notification_categories->count() > 0 )
    <div class="how-to-work pt-lg--7 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Notifications & Applications</h2>
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        @foreach( $exam_notification_categories as $key => $exam_notification_category )
                            <li class="list-inline-item @if( $key == 0 ) active @endif">
                                <a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3 @if( $key == 0 ) active @endif" href="#notificationNavtabs{{ $exam_notification_category->id }}" data-toggle="tab">{{$exam_notification_category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @foreach( $exam_notification_categories as  $key => $exam_notification_category )
                <div class="tab-pane fade @if( $key == 0 ) show active @endif"  id="notificationNavtabs{{ $exam_notification_category->id }}">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row card-scroll">
                                @foreach( $exam_notification_category['exam_notifications'] as $exam_notification )
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                            <div class="card-body ">
                                                <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: {{ $exam_notification->exam_number }}</span>
                                                <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{route('exam-notifications.show', $exam_notification->name_slug)}}"   target="_blank" class="text-dark text-grey-900">
                                                        {{ $exam_notification->title }}</a></h4>
                                                <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2">

                                                    <a href="{{route('exam-notifications.show', $exam_notification->name_slug)}}"> Last Date of Apply : {{ $exam_notification->last_date }}</a>
                                                    <a class="d-inline-block pl-3" target="_blank"  href="{{ $exam_notification->file }}" download ><small><i class="ti-import pr-1"></i></small></a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pt-0 pl-4 mb-4">
                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <label class="fw-700 text-current mb-3">Download Applications</label>
                                        @foreach( $exam_notification_category['exam_applications'] as $exam_application )
                                        <div class="col-8 pl-1 mb-2">
                                            <a href="{{ $exam_application->url }}" target="_blank">
                                                <h6 class="font-xssss text-grey-500 fw-600 mt-0">Last Date: {{ $exam_application->last_date }}</h6>
                                                <h2 class="fw-600 text-grey-800 font-xsss lh-3">{{ $exam_application->title }}</h2>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 ">
                    <a href="{{url('exam-notifications')}}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">View More</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($blog_categories->count() > 0)
         <div class="blog-page pt-lg--5 pt-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-8 col-md-10 col-sm-12 text-center mb-5">
                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-xl ls-2 alert-warning d-inline-block text-warning mr-1">Blog</span>
                    <h2 class="text-grey-900 fw-700 font-xxl pb-3 mb-0 mt-3 d-block lh-3">Don't Miss Out Our Story</h2>
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        @foreach($blog_categories as $key=> $blog_category)
                            <li class="list-inline-item  @if($key == 0) active @endif">
                                <a class="fw-700 ls-3 font-xss text-black text-uppercase  @if($key == 0) active @endif ml-3" href="#blogNavTab{{ $blog_category['id'] }}" data-toggle="tab">
                                    {{ $blog_category['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @foreach($blog_categories as $key=> $blog_category)
                    <div class="tab-pane @if($key == 0) show active @else fade @endif" id="blogNavTab{{ $blog_category['id'] }}">
                        <div class="row card-scroll">
                            @foreach($blog_category['blogs'] as $blog)
                                <div class="col-xl-4 col-sm-6 col-xs-6  col-md-12  mb-4">
                                    <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden">
                                        <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank"><img src="{{ $blog->image }}" alt="blog-image" class="w-100"></a>
                                        <div class="post-content p-3">
                                            <h6 class="font-xssss text-grey-500 fw-600 float-left "><i class="ti-calendar mr-2"></i>
                                                {{Carbon\Carbon::parse($blog->created_at)->format('d M Y') }} </h6>
                                                @if($blog->blog_type == \App\Models\Blog::BLOG_TYPE_ARTICLE )
                                                    <span class="font-xsssss fw-700  pl-2 pr-2 lh-25 text-uppercase rounded-lg ls-2 float-md-right text-sm-center alert-success d-inline-block text-success ">
                                                       Article
                                                     </span>
                                                @else
                                                    <span class="font-xsssss fw-700  pl-2 pr-2 lh-25 text-uppercase rounded-lg ls-2 float-md-right text-sm-center alert-success d-inline-block text-success ">
                                                       Video
                                                     </span>
                                                @endif
                                            <div class="clearfix"></div>
{{--                                            <div  style="min-height: 70px !important;">--}}
                                                <h2 class="post-title mt-2 mb-2 pr-3 description-row">
                                                    <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank" class="lh-30 font-sm mont-font text-grey-800 fw-700">
                                                        {{ \Illuminate\Support\Str::limit( $blog->title, 20, $end=' ...') }}
                                                    </a>
                                                </h2>
                                                <h6 class="font-xssss text-grey-500 fw-600"><i class="ti-user mr-2"></i> {{ $blog->author }}</h6>
{{--                                            </div>--}}
                                            <div class="description-row">
                                            <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3">  {!! $blog->parsed_description !!}</p>
                                            </div>
                                            <div class="row justify-content-center">
                                                <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank" class="rounded-xl text-white bg-current w125 p-2  lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>
                                            </div>

                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4 ">
                    <a href="{{url('blogs')}}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">Explore More</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="feedback-wrapper pt-lg--7 pb-lg--7 pb-5 pt-5">
        <div class="container">
            @if($testimonials->count() > 0)
                <div class="row">
                <div class="col-lg-6 text-left mb-5 pb-0">
                    <h2 class="text-grey-800 fw-700 font-xl lh-2">Customer love what we do</h2>
                </div>

                <div class="col-lg-12">
                    <div class="feedback-slider2 owl-carousel owl-theme overflow-visible dot-none right-nav pb-4 nav-xs-none">
                        @foreach( $testimonials as $testimonial )
                        <div class="owl-items bg-transparent">
                            <div class="card w-100 p-0 bg-transparent text-left border-0">
                                <div class="card-body  testimonial-cards p-5 bg-white shadow-xss rounded-lg triangle-after">
                                    <p class="font-xsss fw-500 text-grey-700 lh-30 mt-0 mb-0 ">
                                        {{ $testimonial->body }}
                                    </p>
                                    <div class="star d-block w-100 text-right mt-4 mb-0">
                                        @for( $i=1; $i<= $testimonial->rating; $i++ )
                                            <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        @endfor
                                        @for( $j=1; $j<= (5-$testimonial->rating); $j++ )
                                            <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                        @endfor
                                    </div>
                                </div>

                                <div class="card-body p-0 mt-5 bg-transparent">
                                    <img src="{{ $testimonial->image }}" alt="user" class="w45 float-left mr-3">
                                    <h4 class="text-grey-900 fw-700 font-xsss mt-0 pt-1">{{ $testimonial->name }}</h4>
                                    <h5 class="font-xssss fw-500 mb-1 text-grey-500">{{ $testimonial->designation }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>


@endsection

@push('js')
    <script type="text/javascript">

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


            $(".purchase-alert").click(function (e) {
                e.preventDefault();
                let packageId =  $(this).data('package-id');
                swal("Click here to purchase package.")
                    .then ( function() {
                        var url = '{{ url('checkout?package=') }}' +packageId;
                        window.location = url;
                    });
            });

        $(".re-purchase-alert").click(function (e) {
            e.preventDefault();
            let packageId =  $(this).data('package-id');
            swal("Your subscription has ended. Re-purchase to continue.")
                .then ( function() {
                    var url = '{{ url('checkout?package=') }}' +  packageId;
                    window.location = url;
                });
        });




        $('#search-courses').keypress(function (e) {
            var key = e.which;
            if(key == 13)  // the enter key code
            {
                var search = $("#search-courses").val();
                var url = '{{url('courses')}}' + '?search=' + search;

                window.location.href = url;
            }
        });

        $(function() {
            $("#search-course-btn").click(function(){
                var search = $("#search-courses").val();
                if(search != '') {
                    var url = '{{url('courses')}}' + '?search=' + search;

                    window.location.href = url;
                }

            });

        });

        $(".start-user-test").click(function (e) {
            e.preventDefault();
            let testId = $(this).data('test-id');
           // console.log(testId);
            var storeTestUrl = '{{ url('/user/tests') }}' + '/'+testId+'/result';
            let packageId =  $(this).data('package-id');
            let startTestUrl = '{{url('/user/tests')}}' + '/'+testId+'?package='+packageId+'&question=1';

            $.ajax({
                type: 'POST',
                url: storeTestUrl,
                data: {
                    "_token": "{{ csrf_token() }}",
                    'testId': testId,
                    'packageId' : packageId
                },
                success: function(response){
                    window.location.href =  startTestUrl;
                }
            });
        });
    </script>
@endpush

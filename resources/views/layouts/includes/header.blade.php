
<div class="header-wrapper pt-3 pb-3 shadow-none ">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-12 d-flex">
                <a href="{{url('/')}}">
                    <img src="{{ url('/web/images/pscmitr-logo.png') }}" class="w150 m-w-100">
                </a>
                <div class="d-sm-block d-lg-none text-center pl-3">
                    @if(!\Illuminate\Support\Facades\Auth::user())
                        <a href="#" class="nav-btn bg-dark fw-500 text-white font-xsss p-1 lh-32 w75 text-center d-inline-block rounded-xl mr-1" data-toggle="modal" data-target="#Modallogin">Login</a>
                        <a href="{{ route('sign-up.index') }}" class="nav-btn bg-dark fw-500 text-white font-xsss p-1 lh-32 w75 text-center d-inline-block rounded-xl">SignUp</a>
                    @else
                        <a href="#" data-toggle="modal" data-target="#ModalSideMenu" class="float-center text-center mt-1 text-grey-800 position-relative">
                            <img src="@if($student['image']) {{$student['image']}} @elseif($student['gender'] == 0) {{ url('/web/images/female-avatar.jpeg') }} @else  {{ url('/web/images/avatar.jpg') }}  @endif" alt="image" class=" ml-5 p-1 bg-white rounded-circle  w-25 min-w-10" >
                        </a>
                    @endif
                </div>
                <div class="d-flex ml-auto">
                    <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon" ></span>
                    </button>
                </div>
            </div>

            <div class="col-lg-7 order-1">
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav nav-menu float-none text-center">
                        @if($nav_bar_courses)
                            @foreach( $nav_bar_courses as $nav_bar_course)
                                <li class="nav-item dropdown">
                                    <a class="nav-link  dropdown-toggle" data-toggle="dropdown" href="{{url('courses/' .$nav_bar_course->id )}}">
                                        {{ \Illuminate\Support\Str::limit( $nav_bar_course->name, 7, $end='...') }}  <i class="ti-angle-down"></i>
                                    </a>
                                    <div class="dropdown-menu" >
                                        @foreach( $package_highlights as $package_type)
                                        <a class="dropdown-item" href="{{ url('courses?search='.$nav_bar_course->name. '&tab=package-type&package_type='. $package_type->id) }}">
                                             {{ $package_type->title }}
                                         </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{url('courses')}}">All Courses</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('blogs')}}">Blogs</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('contact')}}">Contact</a></li>
                        @if(\Illuminate\Support\Facades\Auth::user())
                            @if( in_array( \Illuminate\Support\Facades\Auth::user()->id, $subscribers) )
                                <li class="nav-item"><a class="nav-link" href="{{route('user.questions.index')}}">Question Search</a></li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-md-3 order-2 d-none-990">
               <div class="d-flex justify-content-end p-2">
                   @if(!\Illuminate\Support\Facades\Auth::user())
                       <a href="#" class="header-btn bg-dark fw-500 text-white font-xsss p-2 lh-32 w100 text-center d-inline-block rounded-xl mr-1" data-toggle="modal" data-target="#Modallogin">Login</a>
                       <a href="{{ route('sign-up.index') }}" class="header-btn bg-dark fw-500 text-white font-xsss p-2 lh-32 w100 text-center d-inline-block rounded-xl">SignUp</a>
                   @else
                       <a href="#" data-toggle="modal" data-target="#ModalSideMenu" class="header-btn float-right text-center mt-1 ml-4 text-grey-800 position-relative">
                           <img src="@if($student['image']) {{$student['image']}} @elseif($student['gender'] == 0) {{ url('/web/images/female-avatar.jpeg') }} @else  {{ url('/web/images/avatar.jpg') }}  @endif" alt="image" class="float-right p-1 bg-white rounded-circle  w-25">
                       </a>
                   @endif
               </div>
            </div>
        </div>
    </div>
</div>

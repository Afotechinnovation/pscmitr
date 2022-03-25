@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main role="main">
        <div style="background:url('/web/images/pscmitr-signup.jpg'); min-height: 491px;   background-size: cover" class="banner-wrapper bg-after-fluid">
        <section class="bg-brand-gradient py-4" >
            <div class="container">
                <ul class="nav nav-tabs nav-tabs-line d-none" role="tablist">
                    <li class="nav-item text-white" role="presentation"><a class="nav-link font-size-16 active" data-toggle="tab" href="#phone-num" aria-controls="phone-num" role="tab" aria-selected="true" id="mobile-navbar">Mobile</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#otp" aria-controls="otp" role="tab" aria-selected="false" id="otp-navbar">Otp</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#pin" aria-controls="pin" role="tab" aria-selected="false" id="pin-navbar">Pin</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#name_and_email" aria-controls="name_and_email" role="tab" aria-selected="false" id="name-and-email-navbar">Name</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#interest" aria-controls="interest" role="tab" aria-selected="false" id="interest-navbar">Interests</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#dob" aria-controls="dob" role="tab" aria-selected="false" id="dob-navbar">Dob</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#location" aria-controls="location" role="tab" aria-selected="false" id="location-navbar">Location</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link font-size-16" data-toggle="tab" href="#occupation" aria-controls="occupation" role="tab" aria-selected="false" id="occupation-navbar">Occupation</a></li>
                </ul>
                <div class="nav-tabs-horizontal" data-plugin="tabs">
                    <form id="form-sign-up" method="POST" action="">
                        @csrf
                        <div class="tab-content">
                            <div class="tab-pane active" id="phone-num" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-5">
                                        <h2 class="text-center">Enter your mobile</h2>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-4 col-sm-12">
                                        <div class="form-group icon-input mb-4">
                                            <i class="ti-mobile font-xs text-grey-400"></i>
                                            <input type="tel" name="mobile_number" value="" id="mobile_number" maxlength="10" class="form-control @error('mobile_number') is-invalid @enderror  pl-5  w-200 font-xsss mb-0 text-grey-500 fw-500" placeholder="Mobile Number">
                                            @error('mobile_number')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                            <input type="hidden" id="signup_page" name="signup_page" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary" id="btn-next-mobile" type="button">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="otp" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-5">
                                        <h2 class="text-center">Verify your otp</h2>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6 pt-4 col-sm-12" >
                                        <div class="form-group icon-input mb-4" >
                                            <i class="ti-lock font-xs text-grey-400"></i>
                                            <input hidden name="otp_token" id="otp-token">
                                            <input type="password" name="otp_number" id="otp_number" maxlength="6" class="form-control  @error('otp_number') is-invalid @enderror style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="OTP">
                                            @error('otp_number')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary" id="btn-prev-otp" type="button">Previous</button>
                                    <button class="btn btn-primary ml-2" id="btn-next-otp" type="button">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="pin" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-5">
                                        <h2 class="text-center">Set your pin</h2>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-6 col-sm-12 col-md-6">
                                        <div class="form-group icon-input mb-3">
                                            <input type="text" name="sign_up_pin_number" required id="sign_up_pin_number"  minlength="4" class="pl-3 form-control  @error('sign_up_pin_number') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Enter pin number">
                                            @error('sign_up_pin_number')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group icon-input mb-3">
                                            <input type="text" id="sign_up_confirm_pin" required name="sign_up_confirm_pin" minlength="4" class="pl-3 form-control  @error('sign_up_confirm_pin') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Confirm pin number">
                                            @error('sign_up_confirm_pin')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary" id="btn-prev-pin" type="button">Previous</button>
                                    <button class="btn btn-primary ml-2" id="btn-next-pin" type="button">Next</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="name_and_email" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-5">
                                        <h2 class="text-center">Contact Details</h2>
                                    </div>
                                </div>
                                <div class="row justify-content-center mt-4">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group icon-input mb-3">
                                            <input type="text" name="name" id="name" required class="pl-3 form-control @error('name') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="mt-2 mb-2 pl-0 col-lg-6 col-md-6 col-sm-12" >
                                        <div class="form-check icon-input text-left mb-1">
                                            <div class="form-check form-check-inline" >
                                                <input class="form-check-input " type="radio"  id="inlineRadio1" checked  name="gender" value="1">
                                                <label class="form-check-label font-xsss mb-0  fw-500" for="inlineRadio1">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"  name="gender" id="inlineRadio2" value="0">
                                                <label class="form-check-label font-xsss mb-0 fw-500" for="inlineRadio2">Female</label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <span class="pl-3" id="student-gender"></span>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group icon-input mb-3">
                                            <input type="email" id="email" name="email" required class="pl-3 form-control  @error('email') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 justify-content-center">
                                    <button class="btn btn-primary" id="btn-prev-name-and-email" type="button">Previous</button>
                                    <button class="btn btn-primary ml-2" id="btn-next-name-and-email" type="button">Finish</button>
                                </div>
{{--                                <div class="row justify-content-center">--}}
{{--                                    <button class="btn btn-primary" id="btn-prev-name-and-email" type="button">Previous</button>--}}
{{--                                    <button class="btn btn-primary ml-2" id="btn-next-name-and-email" type="button">Next</button>--}}
{{--                                </div>--}}
                            </div>
{{--                            <div class="tab-pane" id="interest" role="tabpanel">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 pt-5">--}}
{{--                                        <h2 class="text-center">Choose your interests</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center mt-4">--}}
{{--                                    <div class="courses" >--}}
{{--                                        @foreach($courses as $key => $course)--}}
{{--                                              <span class="courses" >--}}
{{--                                                <input type="checkbox" class="btn-check d-none course-checkbox" id="course-check-{{$key}}" autocomplete="off">--}}
{{--                                                <input type="hidden" class="course_id" name="course_id" value="{{ $course->id }}">--}}
{{--                                                <label class="btn btn-light course-label " for="course-check-{{$key}}">{{ $course->name }}</label>--}}
{{--                                            </span>--}}

{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-5 justify-content-center">--}}
{{--                                    <button class="btn btn-primary" id="btn-prev-interest" type="button">Previous</button>--}}
{{--                                    <button class="btn btn-primary ml-2" id="btn-next-interest" type="button">Next</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane" id="dob" role="tabpanel">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 pt-5 ">--}}
{{--                                        <h2 class="text-center">Personal details</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center mt-4">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <input type="text" id="date_of_birth" name="date_of_birth"   class="user_date_of_birth style2-input pl-3 form-control  @error('date_of_birth') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Date Of Birth">--}}
{{--                                            @error('date_of_birth')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class=" mt-2 mb-2 pl-0 col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <div class="form-check icon-input text-left mb-1">--}}
{{--                                            <div class="form-check form-check-inline" >--}}
{{--                                                <input class="form-check-input " type="radio"  id="inlineRadio1" checked  name="gender" value="1">--}}
{{--                                                <label class="form-check-label font-xsss mb-0  fw-500" for="inlineRadio1">Male</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check form-check-inline">--}}
{{--                                                <input class="form-check-input" type="radio"  name="gender" id="inlineRadio2" value="0">--}}
{{--                                                <label class="form-check-label font-xsss mb-0 fw-500" for="inlineRadio2">Female</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        @error('gender')--}}
{{--                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                        <span class="pl-3" id="student-gender"></span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <button class="btn btn-primary" id="btn-prev-dob" type="button">Previous</button>--}}
{{--                                    <button class="btn btn-primary ml-2" id="btn-next-dob" type="button">Next</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane" id="location" role="tabpanel">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 pt-5">--}}
{{--                                        <h2 class="text-center">Location details</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center mt-4">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <x-inputs.countries id="country_id"  class="{{ $errors->has('country_id') ? ' is-invalid' : '' }}  ">--}}
{{--                                                @if(!empty(old('country_id', $defaultCountry->id)))--}}
{{--                                                    <option value="{{ old('country_id', $defaultCountry->id) }}" selected>{{ old('country_id_text', $defaultCountry->name) }}</option>--}}
{{--                                                @endif--}}
{{--                                            </x-inputs.countries>--}}
{{--                                            @error('country_id')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                            <span id="country"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <div class="form-group icon-input mb-1">--}}
{{--                                            <x-inputs.states id="state_id" related="#country_id" class="text-grey-900 font-xsss fw-600 {{ $errors->has('state_id') ? ' is-invalid' : '' }} ">--}}
{{--                                                @if(!empty(old('state_id', $defaultState->id)))--}}
{{--                                                    <option value="{{ old('state_id', $defaultState->id) }}" selected>{{ old('state_id_text', $defaultState->name) }}</option>--}}
{{--                                                @endif--}}
{{--                                            </x-inputs.states>--}}
{{--                                            @error('state_id')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                            <span  id="state"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 col-md-6 col-sm-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <input type="text" id="place" name="place" class="pl-3 form-control  @error('place') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Enter your place name">--}}
{{--                                            @error('place')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <button class="btn btn-primary" id="btn-prev-state" type="button">Previous</button>--}}
{{--                                    <button class="btn btn-primary ml-2" id="btn-next-state" type="button">Next</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="tab-pane" id="occupation" role="tabpanel">--}}
{{--                                <div class="row justify-content-center">--}}
{{--                                    <div class="col-lg-6 pt-5">--}}
{{--                                        <h2 class="text-center">Choose your occupations</h2>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row justify-content-center mt-4">--}}
{{--                                    <div class="courses pl-4">--}}
{{--                                        @foreach($occupations as $key => $occupation)--}}
{{--                                            <span class="occupations">--}}
{{--                                                <input type="checkbox" class="btn-check d-none occupation-checkbox" id="occupation-check-{{$key}}" autocomplete="off">--}}
{{--                                                <input type="hidden" class="occupation_id" name="occupation_id" value="{{ $occupation->id }}">--}}
{{--                                                <label class="btn btn-light occupation-label" for="occupation-check-{{$key}}">{{ $occupation->name }}</label>--}}
{{--                                            </span>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mt-5 justify-content-center">--}}
{{--                                    <button class="btn btn-primary" id="btn-prev-occupation" type="button">Previous</button>--}}
{{--                                    <button class="btn btn-primary ml-2" id="btn-next-occupation" type="button">Finish</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </form>
                </div>
            </div>
        </section>
        </div>
        <input type="hidden" name="redirect" id="redirect">
    </main>

@endsection

@push('js')
    <script>
        $(function () {

            $(".user_date_of_birth").mask("99/99/9999");

            new_user_mobile =  "{{ request()->mobile  }}";
            redirect_value =    "{{ request()->redirect }}";
            test  =   "{{ request()->test }}";
            packageId =  "{{ request()->package }}";

           if(new_user_mobile) {
               $('#mobile_number').val(new_user_mobile);
           }

           if(redirect_value) {
               $('#redirect').val(redirect_value);

           }

            var mobile;
            var otp_token;
            var otp_number;

            var userCourses = [];
            var userOccupations = [];

            $("#course-check-0").attr('checked', true);
            var courseVal = $("#course-check-0").closest('.courses').find('.course_id').val();
            $("#course-check-0").closest('.courses').find('.course-label').addClass('bg-primary');
            userCourses.push(courseVal);

            $("#occupation-check-0").attr('checked', true);
            var occupationVal = $("#occupation-check-0").closest('.occupations').find('.occupation_id').val();
            $("#occupation-check-0").closest('.occupations').find('.occupation-label').addClass('bg-primary');

            userOccupations.push(courseVal);

            $("#btn-next-mobile").click(function (e){
                e.preventDefault;
                $('#form-sign-up').validate({
                    rules: {
                        mobile_number: {
                            required: true,
                            maxlength: 10,
                            minlength: 10,
                            number: true
                        },
                    },
                });
                if ($('#form-sign-up').valid()) {
                    mobile = $('#mobile_number').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('otp.send') }}',
                        data: {
                            'mobile': mobile,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            otp_token = response['data'];
                            $("#otp").addClass('active');
                            $("#phone-num").removeClass('active');
                            $("#mobile-navbar").removeClass('active');
                            $("#otp-navbar").addClass('active');

                        }, error: function (response) {
                            swal("Phone number already exist");
                        }
                    });
                }
            });

            $("#btn-next-otp").click(function (e){
                e.preventDefault();
                $('#form-sign-up').validate({
                    rules: {
                        otp_number: {
                            required: true,
                        },
                    },
                });

                if ($('#form-sign-up').valid()) {
                    otp_number = $("#otp_number").val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ url('otp/verify') }}',
                        data: {
                            'mobile' : mobile,
                            'otp' : otp_number,
                            'otp_token' : otp_token,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response){
                            if(response.message){
                                $("#otp").removeClass('active');
                                $("#otp-navbar").removeClass('active');
                                $("#pin").addClass('active');
                                $("#pin-navbar").addClass('active');
                            }
                        },
                        error: function (response) {
                            swal("Please enter valid OTP.");
                        }
                    });
                }
            });

            $("#btn-next-pin").click(function (e){
                e.preventDefault();
                $('#form-sign-up').validate({
                    rules: {
                        sign_up_pin_number: {
                            required: true,
                            maxlength: 6,
                            minlength: 4,
                            number: true

                        },
                        sign_up_confirm_pin: {
                            required: true,
                            maxlength: 6,
                            minlength: 4,
                            number: true,
                            equalTo : "#sign_up_pin_number"

                        },
                    },
                    messages:{
                        sign_up_confirm_pin:{
                            equalTo : "Pin Number and Confirm Pin Number must be same and should be a number"
                        }
                    }
                });
                if ($('#form-sign-up').valid()) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('pin-number/store') }}',
                        data: {
                            'mobile': mobile,
                            'pin': $("#sign_up_pin_number").val(),
                            'confirm_pin': $("#sign_up_confirm_pin").val(),
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            $("#pin").removeClass('active');
                            $("#pin-navbar").removeClass('active');
                            $("#name_and_email").addClass('active');
                            $("#name-and-email-navbar").addClass('active');
                        },error: function (response) {
                            swal("Pin Number and Confirm Pin Number must be same.");
                        }
                    });
                }
            })

            $("#btn-next-name-and-email").click(function (e){
                packageId =  "{{ request()->package }}";
                alert(packageId);

                e.preventDefault();
                $('#form-sign-up').validate({
                    rules : {
                        name : {
                            required: true,
                            minlength : 3
                        },
                        email : {
                            required: true,
                            email : true,
                        }
                    }
                });
                if ($('#form-sign-up').valid()) {

                    $.ajax({
                        type: 'POST',
                        url: '{{ url('name-and-email/update') }}',
                        data: {
                            'mobile' : mobile,
                            'name' : $("#name").val(),
                            'email' : $("#email").val(),
                            'gender': $("input[name='gender']:checked").val(),
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response){
                            if(response.message){
                                $("#name_and_email").removeClass('active');
                                $("#name-and-email-navbar").removeClass('active');
                                // $("#interest").addClass('active');
                                // $("#interest-navbar").addClass('active');

                                if(redirect_value == "quickTest") {

                                    window.location.href = '{{ url('test/quick-test') }}' + '?test=' + test;
                                }
                                else if(redirect_value == "todayTest") {
                                    window.location.href =  '{{ url('test/today-tests')}}';
                                }
                                else if(redirect_value == "liveTest") {
                                    window.location.href =  '{{ url('test/live-tests')}}';
                                }
                                else if(redirect_value == "packageShow") {
                                    window.location.href =  '{{ url('packages/')}}' +'/' + packageId;
                                }
                                else{
                                    window.location.href = '{{ route('home.index') }}';
                                }
                            }
                        },
                        error: function (response) {
                            swal("Email already exist.");
                        }
                    });
                }
            });

            $("#btn-next-interest").click(function (e){
                e.preventDefault();
                if(userCourses.length <=0){
                    swal("Choose any course");
                }
                else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('user-interests/update') }}',
                        data: {
                            'mobile' : mobile,
                            'interests': userCourses,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response){
                            if(response.message){
                                $("#interest").removeClass('active');
                                $("#interest-navbar").removeClass('active');
                                $("#dob").addClass('active');
                                $("#dob-navbar").addClass('active');
                            }
                        },
                        error: function (response) {

                        }
                    });
                }
            });

            $("#btn-next-dob").click(function (e){
                e.preventDefault();
                $('#form-sign-up').validate({
                    rules: {
                        date_of_birth: {
                            required: true,
                        },
                    },
                });
                if ($('#form-sign-up').valid()) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('dob-and-gender/update') }}',
                        data: {
                            'mobile': mobile,
                            'dob': $("#date_of_birth").val(),
                            'gender': $("input[name='gender']:checked").val(),
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            $("#dob").removeClass('active');
                            $("#dob-navbar").removeClass('active');
                            $("#location").addClass('active');
                            $("#location-navbar").addClass('active');
                        },
                        error: function (response) {

                        }
                    });
                }
            });

            $("#btn-next-state").click(function (e){
                e.preventDefault();
                $('#form-sign-up').validate({
                    rules : {
                        place : {
                            required: true,
                        },
                    }
                });
                if ($('#form-sign-up').valid()) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('state-and-country/update') }}',
                        data: {
                            'mobile': mobile,
                            'state': $("#state_id").val(),
                            'country': $("#country_id").val(),
                            'place': $("#place").val(),
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            $("#location").removeClass('active');
                            $("#location-navbar").removeClass('active');
                            $("#occupation").addClass('active');
                            $("#occupation-navbar").addClass('active');
                        },
                        error: function (response) {

                        }
                    });
                }
            });

            {{--$("#btn-next-occupation").click(function (e){--}}
            {{--    e.preventDefault();--}}

            {{--    $.ajax({--}}
            {{--        type: 'POST',--}}
            {{--        url: '{{ url('occupations/update') }}',--}}
            {{--        data: {--}}
            {{--            'mobile' : mobile,--}}
            {{--            'occupations': userOccupations,--}}
            {{--            "_token": "{{ csrf_token() }}",--}}
            {{--        },--}}
            {{--        success: function(response){--}}
            {{--            if(redirect_value == "quickTest") {--}}

            {{--                window.location.href = '{{ url('test/quick-test') }}' + '?test=' + test;--}}
            {{--            }--}}
            {{--            else if(redirect_value == "todayTest") {--}}
            {{--                window.location.href =  '{{ url('test/today-tests')}}';--}}
            {{--            }--}}
            {{--            else if(redirect_value == "liveTest") {--}}
            {{--                window.location.href =  '{{ url('test/live-tests')}}';--}}
            {{--            }--}}
            {{--            else if(redirect_value == "packageShow") {--}}
            {{--                window.location.href =  '{{ url('packages/')}}' +'/' + packageId;--}}
            {{--            }--}}
            {{--            else{--}}
            {{--                window.location.href = '{{ route('home.index') }}';--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function (response) {--}}

            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            $("#btn-prev-otp").click(function (e){
                $("#otp").removeClass('active');
                $("#otp-navbar").removeClass('active');
                $("#phone-num").addClass('active');
                $("#mobile-navbar").addClass('active');
            });

            $("#btn-prev-pin").click(function (e){
                $("#otp").addClass('active');
                $("#otp-navbar").addClass('active');
                $("#pin").removeClass('active');
                $("#pin-navbar").removeClass('active');
            });

            $("#btn-prev-name-and-email").click(function (e){
                $("#pin").addClass('active');
                $("#pin-navbar").addClass('active');
                $("#name_and_email").removeClass('active');
                $("#name-and-email-navbar").removeClass('active');
            });

            $("#btn-prev-interest").click(function (e){
                $("#name-and-email-navbar").addClass('active');
                $("#name_and_email").addClass('active');
                $("#interest").removeClass('active');
                $("#interest-navbar").removeClass('active');
            });

            $("#btn-prev-dob").click(function (e){
                $("#interest").addClass('active');
                $("#interest-navbar").addClass('active');
                $("#dob").removeClass('active');
                $("#dob-navbar").removeClass('active');
            });

            $("#btn-prev-state").click(function (e){
                $("#dob").addClass('active');
                $("#dob-navbar").addClass('active');
                $("#location-navbar").removeClass('active');
                $("#location").removeClass('active');
            });

            $("#btn-prev-occupation").click(function (e){
                $("#location-navbar").addClass('active');
                $("#location").addClass('active');
                $("#occupation").removeClass('active');
                $("#occupation-navbar").removeClass('active');
            });

            $(".course-checkbox").change(function() {
                if($(this).prop('checked')) {
                   var val = $(this).closest('.courses').find('.course_id').val();
                    $(this).closest('.courses').find('.course-label').removeClass('bg-light');
                    $(this).closest('.courses').find('.course-label').addClass('bg-primary');
                    if(jQuery.inArray(val, userCourses) !== -1){

                    }
                    else {
                        userCourses.push(val);
                    }
                } else {
                    var removeVal = $(this).closest('.courses').find('.course_id').val();
                    $(this).closest('.courses').find('.course-label').addClass('bg-light');
                    $(this).closest('.courses').find('.course-label').removeClass('bg-primary');
                    userCourses.splice($.inArray(removeVal, userCourses), 1);
                }
            });

            $(".occupation-checkbox").change(function() {
                if($(this).prop('checked')) {
                    var val = $(this).closest('.occupations').find('.occupation_id').val();
                    $(this).closest('.occupations').find('.occupation-label').removeClass('bg-light');
                    $(this).closest('.occupations').find('.occupation-label').addClass('bg-primary');
                    if(jQuery.inArray(val, userOccupations) !== -1){

                    }
                    else {
                        userOccupations.push(val);
                        console.log(userOccupations);
                    }
                } else {
                    var removeVal = $(this).closest('.occupations').find('.occupation_id').val();
                    $(this).closest('.occupations').find('.occupation-label').addClass('bg-light');
                    $(this).closest('.occupations').find('.occupation-label').removeClass('bg-primary');
                    userOccupations.splice($.inArray(removeVal, userOccupations), 1);
                    console.log(userOccupations);
                }
            });
        });
    </script>
@endpush

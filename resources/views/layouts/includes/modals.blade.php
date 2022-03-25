<link rel="stylesheet" href="{{ asset('/web/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.css') }}">
<style>
    .txt-center {
        text-align: center;
    }
    .hide {
        display: none;
    }

    .clear {
        float: none;
        clear: both;
    }

    .rating {
        unicode-bidi: bidi-override;
        direction: rtl;
        text-align: center;
        position: relative;
    }

    .rating > label {
        float: right;
        display: inline;
        padding: 0;
        margin: 0;
        position: relative;
        width: 1.1em;
        cursor: pointer;
        color: #000;
    }

    .rating > label:hover,
    .rating > label:hover ~ label,
    .rating > input.radio-btn:checked ~ label {
        color: transparent;
    }

    .rating > label:hover:before,
    .rating > label:hover ~ label:before,
    .rating > input.radio-btn:checked ~ label:before,
    .rating > input.radio-btn:checked ~ label:before {
        content: "\2605";
        position: absolute;
        left: 0;
        color: #FFD700;
    }


</style>
    <!-- Modal Login -->
<div class="modal bottom fade" id="Modallogin" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close text-grey-500"></i></button>
            <div class="modal-body p-3 d-flex align-items-center bg-none">
                <div class="card shadow-none rounded-0 w-100 p-2 pt-3 border-0">
                    <div class="card-body rounded-0 text-left p-3">
                        <form id="login-form" class="form-group" action="{{ url('register') }}"  method="POST">
                            @csrf
                            <input type="hidden" value="" id="redirect" name="redirect">
                            <input type="hidden" value="" id="testId" name="testId">
                            <input type="hidden" value="" id="packageName" name="packageName">
                            <div class="row" id="enter-mobile-no-section" >
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Login into <br>your account</h2>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group icon-input mb-4">
                                        <i class="ti-mobile font-xs text-grey-400"></i>
                                        <input type="tel" name="mobile" id="mobile" maxlength="10" required class="form-control @error('mobile') is-invalid @enderror  pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Mobile Number">
                                        <p id="number-not-exist" class="d-none text-danger">Number not exist</p>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 p-0 text-left">
                                    <div class="form-group mb-1"><a href="#"  class="form-control text-center send-otp-button
                                    style2-input text-white fw-600 bg-dark border-0 p-0" >Submit</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row"  id="login-with-pin-section" style="display: none;">
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Login with PIN</h2>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group icon-input mb-4" >
                                        <i class="ti-lock font-xs text-grey-400"></i>
                                        <input type="password" required name="login-pin" id="login-pin"  class="form-control @error('login-pin') is-invalid @enderror style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="PIN Number">
                                        @error('login-pin')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 p-0 text-left">
                                    <button type="button" class="form-control text-center login-with-pin-button
                                    style2-input text-white fw-600 bg-dark border-0 p-0">
                                        Login
                                    </button>
                                    <a href="#" class="fw-600 font-xsss text-grey-600 mt-1 float-right forgot-pin-number" data-toggle="modal" data-target="#Modalforgetpin"  data-dismiss="modal" >Forgot your Pin?</a>
                                </div>
                            </div>
                            <div class="row"  id="enter-otp-section" style="display: none;">
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Verify OTP</h2>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group icon-input mb-4" >
                                        <i class="ti-lock font-xs text-grey-400"></i>
                                        <input hidden name="otp_token" id="otp-token">
                                        <input type="password" required name="otp" id="otp" maxlength="6" class="form-control style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="OTP">
                                        @error('otp')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 p-0 text-left">
                                    <button type="button" class="form-control text-center verify-otp-button
                                    style2-input text-white fw-600 bg-dark border-0 p-0">
                                        VERIFY
                                    </button>

                                </div>
                            </div>
{{--                            <div class="col-12"  id="sign-up-section" style="display: none">--}}
{{--                                <h2 class="fw-700 display1-size display2-md-size mb-4">Signup</h2>--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <input type="text" name="name"   class="pl-3 form-control  @error('name') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Name">--}}
{{--                                            @error('name')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <input type="email" id="email" name="email"   class="pl-3 form-control  @error('email') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Email">--}}
{{--                                            @error('email')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <x-inputs.countries id="country_id"  class="pl-5 {{ $errors->has('country_id') ? ' is-invalid' : '' }}  ">--}}
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

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-1">--}}
{{--                                            <x-inputs.states id="state_id" related="#country_id"   class="text-grey-900 font-xsss fw-600 {{ $errors->has('state_id') ? ' is-invalid' : '' }} ">--}}
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

{{--                                    <div class="col-12 mt-2 mb-2 pl-0 ">--}}
{{--                                        <div class="form-check icon-input text-left mb-1">--}}
{{--                                            <div class="form-check form-check-inline" >--}}
{{--                                                <input class="form-check-input " type="radio"  id="inlineRadio1"  name="gender" value="1">--}}
{{--                                                <label class="form-check-label font-xsss mb-0 text-grey-500 fw-500" for="inlineRadio1">Male</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check form-check-inline">--}}
{{--                                                <input class="form-check-input" type="radio"  name="gender" id="inlineRadio2" value="0">--}}
{{--                                                <label class="form-check-label font-xsss mb-0 text-grey-500 fw-500" for="inlineRadio2">Female</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        @error('gender')--}}
{{--                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                        <span class="pl-3" id="student-gender"></span>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <input type="text" id="date_of_birth" name="date_of_birth"   class="style2-input pl-3 form-control  @error('date_of_birth') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Date Of Birth">--}}
{{--                                            @error('date_of_birth')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <i class="font-sm ti-lock text-grey-500 pr-0"></i>--}}
{{--                                            <input type="password" id="pin_number" name="pin_number"  minlength="4"   class="style2-input pl-5 form-control  @error('pin_number') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Your PinNumber">--}}
{{--                                            @error('pin_number')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-group icon-input mb-3">--}}
{{--                                            <i class="font-sm ti-lock text-grey-500 pr-0"></i>--}}
{{--                                            <input type="password" id="confirm_pin_number"  name="confirm_pin_number"  minlength="4"   class="style2-input pl-5 form-control  @error('confirm_pin_number') is-invalid @enderror text-grey-900 font-xsss fw-600" placeholder="Confirm Pin Number">--}}
{{--                                            @error('confirm_pin_number')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="col-12">--}}
{{--                                        <div class="form-check text-left mb-3">--}}
{{--                                            <input type="checkbox" name="checkbox" class="form-check-input mt-2  @error('checkbox') is-invalid @enderror " id="checkbox">--}}
{{--                                            <label class="form-check-label font-xsss text-grey-500" for="exampleCheck3">Accept Term and Conditions</label>--}}
{{--                                            <!-- <a href="#" class="fw-600 font-xsss text-grey-700 mt-1 float-right">Forgot your Password?</a> -->--}}
{{--                                            @error('checkbox')--}}
{{--                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>--}}
{{--                                            @enderror--}}
{{--                                            <span id="terms-policy"></span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                                <div class="col-sm-12 p-0 text-left">--}}
{{--                                    <div class="form-group mb-1">--}}
{{--                                        <button type="submit" class="form-control text-center style2-input text-white fw-600 bg-dark border-0 p-0">Register</button>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </form>
                        <div class="col-sm-12 p-0 text-center mt-3 ">
                            <h6 class="mb-0 d-inline-block bg-white fw-600 font-xsss text-grey-500 mb-4">Sign in with your social account </h6>
                            <div class="form-group mb-1"><a href="{{ url('auth/google') }}" class="form-control text-left style2-input text-white fw-600 bg-facebook border-0 p-0 mb-2"><img src="https://via.placeholder.com/50x50.png" alt="icon" class="ml-2 w40 mb-1 mr-5"> Sign in with Google</a></div>
                            <div class="form-group mb-1"><a href="{{ url('login/facebook') }}" class="form-control text-left style2-input text-white fw-600 bg-twiiter border-0 p-0 "><img src="https://via.placeholder.com/50x50.png" alt="icon" class="ml-2 w40 mb-1 mr-5"> Sign in with Facebook</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{--    Modal forget pin--}}

<div class="modal bottom fade" id="Modalforgetpin" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close text-grey-500"></i></button>
            <div class="modal-body p-3 d-flex align-items-center bg-none">
                <div class="card shadow-none rounded-0 w-100 p-2 pt-3 border-0">
                    <div class="card-body rounded-0 text-left p-3">
                        <form id="forgot-pin-form" class="form-group" action="{{ route('login.forgot_pin') }}"  method="POST">
                            @csrf
                            <div class="row" id="forgot-pin-enter-mobile-section" >
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Login into <br>your account</h2>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group icon-input mb-4">
                                        <i class="ti-mobile font-xs text-grey-400"></i>
                                        <input type="tel" name="mobile_number" id="mobile_number" maxlength="10" required class="form-control @error('mobile_number') is-invalid @enderror  pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Mobile Number">
                                        @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 p-0 text-left">
                                    <div class="form-group mb-1"><a href="#"  class="form-control text-center send-otp-button-forgot-pin
                                    style2-input text-white fw-600 bg-dark border-0 p-0" >Submit</a></div>
                                </div>
                            </div>
                            <div class="row"  id="enter-forgot-pin-otp-section" style="display: none;">
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Verify OTP</h2>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group icon-input mb-4" >
                                        <i class="ti-lock font-xs text-grey-400"></i>
                                        <input hidden name="forget-pin-otp-token" id="forget-pin-otp-token">
                                        <input type="password" required name="forget_pin_otp" id="forget_pin_otp" maxlength="4" class="form-control style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="OTP">
                                        @error('forget_pin_otp')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 p-0 text-left">
                                    <button type="button" class="form-control text-center verify-forget-pin-otp-button
                                    style2-input text-white fw-600 bg-dark border-0 p-0">
                                        VERIFY
                                    </button>

                                </div>
                            </div>
                            <div class="row"  id="forgot-pin-section" style="display: none;">
                                <div class="col-12">
                                    <h2 class="fw-700 display1-size display2-md-size mb-4">Reset Pin</h2>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group icon-input mb-4" >
                                        <i class="ti-lock font-xs text-grey-400"></i>
                                        <input type="password" required name="new_pin_number" id="new_pin_number"  class="form-control style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="New Pin Number">
                                        @error('new_pin_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12" >
                                    <div class="form-group icon-input mb-4" >
                                        <i class="ti-lock font-xs text-grey-400"></i>
                                        <input hidden name="otp_token" id="otp-token">
                                        <input type="password" required name="confirm_new_pin_number" id="confirm_new_pin_number" class="form-control style2-input pl-5  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Confirm Pin Number">
                                        @error('confirm_new_pin_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 p-0 text-left">
                                    <button type="submit" class="form-control text-center
                                    style2-input text-white fw-600 bg-dark border-0 p-0">
                                        UPDATE
                                    </button>
                                </div>
                            </div>

                        </form>
                        <div class="col-sm-12 p-0 text-center mt-3 ">
                            <h6 class="mb-0 d-inline-block bg-white fw-600 font-xsss text-grey-500 mb-4">Sign in with your social account </h6>
                            <div class="form-group mb-1"><a href="{{ url('/login/google') }}" class="form-control text-left style2-input text-white fw-600 bg-facebook border-0 p-0 mb-2"><img src="https://via.placeholder.com/50x50.png" alt="icon" class="ml-2 w40 mb-1 mr-5"> Sign in with Google</a></div>
                            <div class="form-group mb-1"><a href="{{ url('/login/facebook') }}" class="form-control text-left style2-input text-white fw-600 bg-twiiter border-0 p-0 "><img src="https://via.placeholder.com/50x50.png" alt="icon" class="ml-2 w40 mb-1 mr-5"> Sign in with Facebook</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal bottom fade" id="packageReviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close text-grey-500"></i></button>
            <div class="modal-body p-3 d-flex align-items-center bg-none">
                <div class="card shadow-none rounded-0 w-100 p-2 pt-3 border-0">
                    <div class="card-body rounded-0 text-left p-3">
                        <h2 class="fw-700 display1-size display2-sm-size mb-4">Rate this package</h2>
                        <form id="package-rating-from" class="form-group" action="{{route('packages.ratings')}}"  method="POST">
                            @csrf
                            <input type="text" hidden name="package_id" id="package-id" value=""/>
                            <div class="form-group">
                                <div class="rating float-left mb-3" >

                                    <input id="star5" name="rating" type="radio" value="5" class="radio-btn hide @error('rating') is-invalid @enderror" />
                                    <label for="star5" class="font-lg" >☆</label>
                                    <input id="star4" name="rating" type="radio" value="4" class="radio-btn hide @error('rating') is-invalid @enderror" />
                                    <label for="star4" class="font-lg">☆</label>
                                    <input id="star3" name="rating" type="radio" value="3" class="radio-btn hide @error('rating') is-invalid @enderror" />
                                    <label for="star3" class="font-lg">☆</label>
                                    <input id="star2" name="rating" type="radio" value="2" class="radio-btn hide @error('rating') is-invalid @enderror" />
                                    <label for="star2" class="font-lg">☆</label>
                                    <input id="star1" name="rating" type="radio" value="1" class="radio-btn hide @error('rating') is-invalid @enderror" />
                                    <label for="star1" class="font-lg">☆</label>
                                    <div class="clear"></div>
                                </div>

                                @error('rating')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                                <span id="package-rating" class="text-danger d-none"> The feild is required</span>

                            </div>
                            <div class="form-group">
                                <textarea class="form-control @error('comments') is-invalid @enderror"  name="comments" placeholder="Please add your comments" id="message-text"></textarea>
                                @error('comments')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-12 p-0 mt-3 ">
                                <button type="submit"  class="p-2 mt-3 border-0 d-inline-block text-white fw-700 lh-30 rounded-lg  w200 font-xsss ls-3 bg-info">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal dashboard menu-->
<div class="modal p-0 right side fade" id="ModalSideMenu" tabindex="-1" role="dialog">
    <div class="modal-dialog ml-auto mr-0 mt-0" role="document">
        <div class="modal-content border-0 rounded-0 p-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="ti-close text-grey-500"></i></button>
            <div class="modal-body pt-2 pl-4 pb-4 pr-4 vh-100 d-flex align-items-start flex-column">
                @if(!\Illuminate\Support\Facades\Auth::user())
                    <h6 class="fw-900 display1-size mb-2">Login </h6>
                @else

                <h6 class="fw-900 font-xs mb-2">Hi  @if($student['name']) {{$student['name']}} @else {{$student['mobile']}}  @endif </h6>
                @endif
                <div class="card w-100 border-0 mt-4">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.tests.index')}}" class="text-grey-800 fw-500 font-xss lh-26">Dashboard</a></h2>
                        </div>
                    </div>
                </div>

                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left  w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.packages.index')}}" class="text-grey-800 fw-500 font-xss lh-26">My Packages</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.tests.index')}}" class="text-grey-800 fw-500 font-xss lh-26">My Tests</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.profile.index')}}" class="text-grey-800 fw-500 font-xss lh-26">My Profile</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.purchase-history.index')}}" class="text-grey-800 fw-500 font-xss lh-26">My Purchase History</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.user-favourite-questions.index')}}" class="text-grey-800 fw-500 font-xss lh-26">My Favourite Questions</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{route('user.doubts.index')}}" class="text-grey-800 fw-500 font-xss lh-26">Doubts Asked</a></h2>
                        </div>
                    </div>
                </div>
                <div class="card w-100 border-0 mt-2">
                    <div class="row m-0">
                        <div class="float-left w-75 pt-2 pb-0">
                            <h2><a href="{{url('logout')}}" class="text-grey-800 fw-500 font-xss lh-26">Logout</a></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--student image upload--}}
<div class="modal fade" id="imageUploadModal" tabindex="-1" role="dialog" aria-labelledby="imageUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="profile-update"  class="p-5" method="POST" action="{{ route('user.profile.image.upload') }}" enctype="multipart/form-data">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageUploadModalLabel">Edit Profile Image</h5>
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10 mt-3">
                                    <input type="hidden" name="packageId" id="packageId" value="">
                                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                     {{ $errors->first('image') }}
                                      </span>
                                    @enderror
                                    <span class="text-info" role="alert"  style="display: inline;">
                                     <small> Recommended size for Image Max - 300 x 300</small>
                                    </span>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal" id="demoVideoModal"  role="dialog" aria-labelledby="demoVideoModalLabel"  >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="demoVideoModalLabel">Demo Video</h3>
                <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div id="demo-video-player-div">
                            <iframe class="video" id="demo-video-player"  allow="autoplay; fullscreen; picture-in-picture"
                                    width="100%" height="300px" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="answerModal"  role="dialog" aria-labelledby="answerModalLabel" style=" overflow-y: scroll;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="answerModalLabel">Answer</h2>
                <button type="button"  id="modal-doubt-asked" class="close mr-1" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 500px" >
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="col-12">
                            <div id="doubt-question-div" class="text-grey-700 font-sm fw-600"></div>
                        </div>
                       <div class="col-12">
                           <div id="doubt-answer-div" class="text-grey-700 font-xss fw-400"></div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--test winner --}}
<div class="modal fade" id="testWinnerModal" tabindex="-1" role="dialog" aria-labelledby="testWinnerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testWinnerModalLabel">Test Winners</h5>
                <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($test_winner)
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image text-center  w-100 mb-3 p-2">
                                    <img src="{{url('storage/test_winner/'. $test_winner->image)}}"   alt="image"  style="height: 200px; width: 200px"  >
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <span class="font-xss fw-700 pl-2 pr-0 ls-2 lh-32 d-inline-block ">Oops...No winners Yet. </span>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-700 text-uppercase" id="test-display-name"></h5>
                <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden"  id="user-testId"  value="" >
                <input type="hidden" id="user-packageId" value="">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4 d-block w-100  p-md-2  border-0 text-center">
                                <div class="col-md-12">
                                    <h2 class="fw-600  mt-4" id="test-name"> </h2>
                                </div>
                                <p class="fw-500 font-xsss text-grey-500 text-justify mt-3" id="test-description">

                                <div class="clearfix"></div>
                                <span class="font-xsss fw-700 pl-3 mb-2 pr-3 lh-32 rounded-lg ls-2 alert-danger
                                d-inline-block text-danger mr-1" id="test-correct-answer-mark">

                                </span>
                                <span class="font-xsss fw-700 pl-3 mb-2 pr-3 lh-32 rounded-lg ls-2 alert-danger
                                d-inline-block text-danger mr-1" id="test-negative-mark">
                                </span>

                                <span class="font-xsss fw-700 pl-3 mb-2 pr-3 lh-32 rounded-lg ls-2 alert-success
                                d-inline-block text-success mr-1" id="test-cut-off-mark">
                                </span>
                                <span class="font-xsss fw-700 pl-3 mb-2 pr-3 lh-32 rounded-lg ls-2 alert-success
                                d-inline-block text-success mr-1" id="test-total-mark">

                                </span>

                                <span class="font-xsss fw-700 pl-3 mb-2 pr-3 lh-32  rounded-lg ls-2 alert-primary
                                 d-inline-block text-primary mr-1" id="test-total-questions">

                                 </span>
                                <span class="fw-700 mb-2 pl-2 pr-2 lh-32 rounded-lg ls-2 alert-info d-inline-block text-info">
                                   <span><i class="fa fa-clock-o pr-1" > </i> <span class="font-xsss" id="test-total-time"> </span></span>
                                </span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary start-user-test">Start Test</button>
            </div>
        </div>
    </div>
</div>


@push('js')

<script>
    test = "{{ request()->test }}";

     $('#demoVideoModal').on('hidden.bs.modal', function () {
         var $this = $(this);
             //get iframe on click
         var vidsrc_frame = $this.find("iframe");
         var vidsrc_src = vidsrc_frame.attr('src');
         vidsrc_frame.attr('src', '');
         vidsrc_frame.attr('src', vidsrc_src);
     });

    $(".start-user-test").click(function (e) {
        e.preventDefault();
        var testId =  $('#user-testId').val();
        var packageId =  $('#user-packageId').val();

        var storeTestUrl = '{{ url('/user/tests') }}' + '/'+testId+'/result';

        let startTestUrl = '{{url('/user/tests')}}' + '/'+testId+'?package='+packageId+'&question=1';
        $.ajax({
            type: 'POST',
            url: storeTestUrl,
            data: {
                "_token": "{{ csrf_token() }}",
                'packageId': packageId
            },
            success: function(response){
                window.location.href =  startTestUrl;
            }
        });
    });

    $('#modal-doubt-asked').on('click',function() {
        $('#answerModal').modal('toggle');
    });

    var loadFile = function(event) {
        var image = document.getElementById('cropped-profile-photo');
        var image_src = event.target.files[0];
        if(image_src){
            image.src = URL.createObjectURL(image_src);
        }
    }

    $('#date_of_birth').datepicker({ });

    //Send OTP -> initial registration
    $('.send-otp-button').on('click', function(e) {
        e.preventDefault();


        $('#login-form').validate({
            errorPlacement: function(error, element) {
                if (element.attr("name") == "checkbox") {
                    error.insertAfter($("#terms-policy"));
                } else if(element.attr("name") == "gender") {
                    error.insertAfter($("#student-gender"));
                }
                else if(element.attr("name") == "country_id") {
                    error.insertAfter($("#country"));
                }
                else if(element.attr("name") == "state_id") {
                    error.insertAfter($("#state"));
                }
                else {
                    error.insertAfter(element);
                }
            },
            rules: {
                mobile: {
                    required: true,
                    maxlength: 10,
                    minlength:10,
                    number:true
                },
                name: {
                    required: true,
                },
                gender: {
                    required:true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '/register/check_email_unique',
                        type: 'post',
                        data: {
                            email: function () {
                                return $('#email').val();
                            },
                            '_token': "{{ csrf_token() }}",
                        }
                    }
                },

                country_id: {
                    required: true,
                },
                state_id: {
                    required: true,
                },
                date_of_birth: {
                    required: true,
                },
                pin_number: {
                    required: true,
                    minlength: 4,
                    number: true

                },
                confirm_pin_number: {
                    required: true,

                    minlength: 4,
                    equalTo : "#pin_number"

                },

                checkbox: {
                    required: true,

                },
            },
            messages:{
                confirm_pin_number:{
                    equalTo : "Pin Number and Confirm Pin Number must be same"
                },
                email: {
                    remote: "Email has been already taken"
                }
            }


        });

        if ($('#login-form').valid()) {
            var mobile = $('#mobile').val();
            var test =   "{{ request()->test }}";
            var redirect = $('#redirect').val();
            var packageName = $('#packageName').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('otp-number.send') }}',
                data: {
                    'mobile': mobile,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response['data']) {

                        swal({
                            title: "It Seems you are here for first time!",
                            text: "Please complete quick signup to explore our test & video lessons!",
                            type: "success"
                        }).then((newUser) => {
                                if (newUser) {

                                    if(redirect == "quickTest") {

                                        window.location = '{{ url('sign-up')}}' + '?mobile=' + mobile + '&redirect=' + redirect + '&test=' + test;
                                    }else if(redirect == "todayTest") {

                                        window.location = '{{ url('sign-up')}}' + '?mobile=' + mobile + '&redirect=' + redirect;
                                    }
                                    else if(redirect == "liveTest") {
                                        window.location = '{{ url('sign-up')}}' + '?mobile=' + mobile + '&redirect=' + redirect ;
                                    }
                                    else if(redirect == "packageShow") {
                                        window.location = '{{ url('sign-up')}}' + '?mobile=' + mobile + '&redirect=' + redirect + '&package=' + packageName ;
                                    }
                                    else{
                                        window.location = '{{ url('sign-up')}}' + '?mobile=' + mobile;
                                    }

                                } else {
                                    window.location = '{{ url('/')}}';
                                }
                            });

                    }
                    else {

                        $("#enter-mobile-no-section").toggle();
                        $("#login-with-pin-section").toggle();
                    }
                }
            });
        }

    });

    //Login with PIN
    $('.login-with-pin-button').on('click', function(e) {
        e.preventDefault();

        let mobile = $('#mobile').val();
        let pin = $('#login-pin').val();
        let redirect = $('#redirect').val();
        let testId = $('#testId').val();

        let packageName = $('#packageName').val();

        $.ajax({
            type: 'POST',
            url: '{{ url('login/pin') }}',
            data: {
                'mobile' : mobile,
                'pin' : pin,
                "_token": "{{ csrf_token() }}",
            },
            success: function(response){
                if(response.data){

                    swal("You have successfully logged in!").then ( function() {
                        if(redirect == "quickTest") {
                            window.location.href =  '{{ url('test/quick-test')}}' + '?test=' + test;

                        }else if(redirect == "packageShow") {
                            window.location.href =  '{{ url('packages/')}}' +'/' + packageName;
                        }
                        else if(redirect == "todayTest") {
                            window.location.href =  '{{ url('test/today-tests')}}';
                        }
                        else if(redirect == "liveTest") {
                            window.location.href =  '{{ url('test/live-tests')}}';
                        }
                        else{

                            window.location.href = '{{route('home.index')}}';

                        }

                    });
                }
                else{
                    swal("Oops! These credentials do not match our records!") .then ( function() {
                        location.reload();
                    });
                }
            }
        });

    });

        //Send OTP -> Forgot PIN
    $('.send-otp-button-forgot-pin').on('click', function(e) {
        e.preventDefault();

       $('#forgot-pin-form').validate({
           rules: {
               mobile: {
                   required: true,
                   maxlength: 10,
                   minlength: 10,
                   number: true
               },
               new_pin_number: {
                   required: true,
                   minlength: 4,
                   number: true

               },
               confirm_new_pin_number: {
                   required: true,
                   // maxlength: 6,
                   minlength: 4,
                   equalTo : "#new_pin_number"

               },
           },
           messages:{
               confirm_new_pin_number:{
                   equalTo : "Pin Number and Confirm Pin Number must be same"
               }
           }


       });
        if ($('#forgot-pin-form').valid()) {
            var mobile = $('#mobile_number').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('otp.forgot_pin_otp_send') }}',
                data: {
                    'mobile': mobile,
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                     console.log(response);
                    if (response['data']) {

                        $("#forgot-pin-enter-mobile-section").toggle();
                        $("#enter-forgot-pin-otp-section").toggle();
                        $("#forget-pin-otp-token").val(response['data']);
                    }
                    else {
                        //console.log("fail");
                        $("#forgot-pin-enter-mobile-section").toggle();
                    }

                }
            });
        }

    });

    //Verify OTP -> Forgot PIN
    $('.verify-forget-pin-otp-button').on('click', function(e) {
        e.preventDefault();

        $('#forgot-pin-form').validate({
            rules: {
                forget_pin_otp: {
                    required: true,
                    maxlength: 4
                },
            }
        });

        if ($('#forgot-pin-form').valid()) {
            let mobile = $('#mobile_number').val();
            let otp = $('#forget_pin_otp').val();
            let otp_token = $('#forget-pin-otp-token').val();

          //  console.log(forget-pin-otp-token);

            $.ajax({
                type: 'POST',
                url: '{{ url('forget_pin/otp/verify') }}',
                data: {
                    'mobile' : mobile,
                    'otp' : otp,
                    'otp_token' : otp_token,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response){
                    if(response.message){
                        $("#enter-forgot-pin-otp-section").toggle();
                        $("#forgot-pin-section").toggle();
                    }
                }
            });
        }

    });





    @if (session('error'))
    toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };
    toastr.error(session('error'));
    @endif

    @if (session('success'))
        toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };
    toastr.success(session('success'));
    @endif

    @if (session('is_registered'))
        swal("Welcome!", "You have successfully registered.", "success");
    @endif

    @if (session('is_pin_updated'))
    swal("You have successfully updated your Pin!.");
    @endif

    $(function() {

        var errors = '{{ $errors->first('image') }}';

      //  var Otperrors = '{{$errors->first('otp')}}';

        if (errors) {
            $('#imageUploadModal').modal('show');
        }


    });
</script>
@endpush

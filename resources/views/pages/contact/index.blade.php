@extends('layouts.app')

@section('title', 'Contact')

@section('content')

    <div class="page-nav bg-lightblue pt-lg--7 pb-4 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 text-center">
                    <h1 class="text-grey-800 fw-700 display3-size mb-3 display4-md-size">Get in touch with us <span class="font-xsss text-grey-500 fw-600 d-block mt-3 pl-lg-5 pr-lg-5 lh-28">Ask us a question by email and we will respond within a few days. </span></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-wrapp pb-lg--10 pb-5 bg-lightblue pt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 md-mb-2">
                    <div class="card shadow-xss border-0 p-5 rounded-lg">
                        <span class="btn-round-xxxl alert-success"><i class="feather-mail text-success font-xl"></i></span>
                        <h2 class="fw-700 font-sm mt-4 mb-3 text-grey-900">Email us</h2>
                        <a href="mailto:support@gmail.com" class="fw-700 font-xsss text-primary">admin@pscmitr.com</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 md-mb-2">
                    <div class="card shadow-xss border-0 p-5 rounded-lg">
                        <span class="btn-round-xxxl alert-primary"><i class="feather-map-pin text-primary font-xl"></i></span>
                        <h2 class="fw-700 font-sm mt-4 mb-3 text-grey-900">Contact us</h2>

                        <a href="" class="fw-700 font-xsss text-primary">Afotech Innovation Private Limited, Aster,
                            Arayakandipara, Azhikode, Kannur,
                            Kerala, 670009, India</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 md-mb-2">
                    <div class="card shadow-xss border-0 p-5 rounded-lg">
                        <span class="btn-round-xxxl alert-danger"><i class="feather-phone text-danger font-xl"></i></span>
                        <h2 class="fw-700 font-sm mt-4 mb-3 text-grey-900">Call us</h2>
                        <a href="tel:893432323" class="fw-700 font-xsss text-primary">953 906 9777</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-wrapper pt-lg--10 pt-5 pb-lg--10 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="contact-wrap bg-white shadow-lg rounded-lg position-relative top-0">
                        <h1 class="text-grey-900 fw-700 display3-size mb-5 lh-1">Contact us</h1>
                        <form action="{{ url('contact') }}" method="POST" id="contact-create">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="text" name="name" value="{{old('name')}}"  required class="form-control style2-input bg-color-none text-grey-700 @error('name') is-invalid @enderror"
                                               id="name" placeholder="Name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" value="{{old('email')}}"  class=" @error('email') is-invalid @enderror form-control style2-input bg-color-none text-grey-700"
                                               id="email" placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3 md-mb25">
                                        <textarea name="message" required placeholder="Message" class="form-control @error('message') is-invalid @enderror"
                                                  rows="4"  id="message">{{ old('message') }}</textarea>

                                        @error('message')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                        <span id="contact-message" class="text-danger d-none"> The message may not be greater than 500 characters.</span>

                                    </div>
                                    <div class="form-check text-left mt-3 float-left md-mb25">
                                        <input type="checkbox" name="checkbox"  required class="form-check-input mt-2" id="checkbox" >

                                        <label class="form-check-label font-xsss text-grey-500 fw-500" for="exampleCheck1">
                                            I agree to the term of this <a href="#" class="text-grey-600 fw-600">Privacy Policy</a></label>
                                       <br>
                                    </div>
                                    <div class="col-12">
                                        @error('checkbox')
                                        <small><span class="invalid-feedback" role="alert">{{ $message }}</span></small>
                                        @enderror
                                    </div>
                                    <div class="form-group"><button type="submit" class="rounded-lg style1-input float-right bg-current text-white text-center font-xss fw-500 border-2 border-0 p-0 w175">Submit</button></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

<script>
    $('#message').bind('keyup', function(e){

        let message =  $('#message').val().length;
       // console.log(message);
        if(message > 500) {
            $("#contact-message").removeClass('d-none')
        }else {
            $("#contact-message").addClass('d-none')
        }
    });
</script>

@endpush

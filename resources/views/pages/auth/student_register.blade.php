@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="banner-wrapper bg-after-fluid " >
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 align-items-center d-flex pb-md-5 pt-5 aos-init aos-animate" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="500">
                    <div class="card w-100 border-0 shadow-lg bg-white p-4 p-md--5">
                        <h2 class="fw-700 text-grey-900 display2-size display2-md-size lh-1 mb-3 mt-0">Details </h2>
                        <div class="form-group mt-0 pt-2 mb-0 bg-white rounded-lg">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mb-4">
                                        <input type="text" name="name" class="form-control pl-3 w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <input type="email" name="email"  class="form-control  pl-3  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <input type="text" name="dob" class="form-control pl-3 dob w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Date Of Birth">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group  mb-4 ml-1">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender" checked> Male
                                        </label>
                                        <label class="radio-inline pl-3">
                                            <input type="radio"  name="gender"> Female
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <input type="text" name="place" class="form-control pl-3  w-100 font-xsss mb-0 text-grey-500 fw-500" placeholder="Place">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <select name="state"  class="form-control pl-3 w-100 font-xsss mb-0  fw-500"  id="state">
                                            <option>Select State</option>
                                            <option value="1">Kerala</option>
                                            <option value="2">Tamil Nadu</option>
                                            <option value="3">Mumbai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <select name="occupation" class="form-control pl-3 w-100 font-xsss mb-0  fw-500"  id="occupation">
                                            <option>Select Occupation</option>
                                            <option value="1">Salaried</option>
                                            <option value="2">Student</option>
                                            <option value="3">Homemaker</option>
                                            <option value="4">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group  mb-4">
                                        <h6 class="author-name ml-2 font-xsss fw-600 mb-0 text-grey-800">Interests</h6>
                                        <ul class="list-group list-group-horizontal border-bottom-0 mt-2">
                                            <li> <label  class="fw-500 lh-24 font-xssss text-grey-500 ">
                                                    <input class="m-2 border-grey" type="checkbox">PSC
                                                </label>
                                            </li>
                                            <li>
                                                <label  class="fw-500 lh-24 font-xssss text-grey-500 ">
                                                    <input class="m-2" type="checkbox">UPSC
                                                </label>
                                            </li>
                                            <li>
                                                <label  class="fw-500 lh-24 font-xssss text-grey-500 ">
                                                    <input class="m-2"  type="checkbox">GATE
                                                </label>
                                            </li>
                                            <li><label  class="fw-500 lh-24 font-xssss text-grey-500 ">
                                                    <input class="m-2"  type="checkbox">IFS
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <a href="#" class="w-100 d-block btn bg-current text-white font-xssss fw-600 ls-3 style1-input p-0 border-0 text-uppercase ">Go to Dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 offset-xl-2 col-lg-6 vh-lg--100 align-items-center d-flex pt-5 pb-5">
                    <div class="card d-block bg-transparent border-0">
                        <h2 class="fw-700 text-white display4-size display4-lg-size display4-md-size lh-2 mb-4 mt-4 aos-init aos-animate" data-aos="fade-up" data-aos-once="true" data-aos-delay="900" data-aos-duration="500">Buy Elomoas and get access to amazing feature</h2>
                        <p class="fw-300 font-xsss lh-28 text-white aos-init aos-animate" data-aos="fade-up" data-aos-once="true" data-aos-delay="1000" data-aos-duration="500">orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dol ad minim veniam, quis nostrud exercitation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="how-to-work pt-lg--7 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Popular Classes</h2>
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        <li class="active list-inline-item"><a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3 active" href="#navtabs1" data-toggle="tab">PSC</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3" href="#navtabs2" data-toggle="tab">UPSE</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3" href="#navtabs2" data-toggle="tab">GATE</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3" href="#navtabs1" data-toggle="tab">IFS</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xss text-black text-uppercase ml-3" href="#navtabs2" data-toggle="tab">Other</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navtabs1">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-4.jpeg') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Reasoning</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 370</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">The Data Science Course Complete Data Science </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 23 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-2.png') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Mathamatics</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 450</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 24 Lesson </h6>

                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-3.png') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-warning d-inline-block text-warning mr-1">GK</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 670</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Fundamentals for Scrum Master and Agile Projects </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 32 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-1.png') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-warning d-inline-block text-warning mr-1">Physics</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 240</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 32 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href={{url('courses/1')}}#" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-3.png') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Social Science</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 40</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 24 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="{{ asset('web/images/v-2.png') }}" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">GK</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 60</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Java Programming Masterclass for Developers</a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 14 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="navtabs2">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-warning d-inline-block text-warning mr-1">Python</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 240</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 32 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Desinger</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 40</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 24 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">Bootstrap</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 60</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Java Programming Masterclass for Developers</a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 14 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Develop</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 370</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">The Data Science Course Complete Data Science </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 23 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-danger d-inline-block text-danger mr-1">Desinger</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 450</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Complete Python Bootcamp From Zero to Hero in Python </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 24 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                            <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                <div class="card-image w-100 mb-3">
                                    <a href="{{url('courses/1')}}" class="video-bttn position-relative d-block"><img src="https://via.placeholder.com/400x300.png" alt="image" class="w-100"></a>
                                </div>
                                <div class="card-body pt-0">
                                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-warning d-inline-block text-warning mr-1">Python</span>
                                    <span class="font-xss fw-700 pl-3 pr-3 ls-2 lh-32 d-inline-block text-success float-right"><span class="font-xsssss">$</span> 670</span>
                                    <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{url('courses/1')}}" class="text-dark text-grey-900">Fundamentals for Scrum Master and Agile Projects </a></h4>
                                    <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> 32 Lesson </h6>
                                    <div class="star float-left text-left mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">
                                    </div>
                                    <p class="review-link mt-0 font-xssss float-right mb-2 fw-500 text-grey-500 lh-3"> Designed By Pixbit Solutions Pvt Ltd</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="feature-wrapper layer-after pt-lg--7 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title mx-5 style1 col-xl-12 col-lg-8 col-md-10 text-center mb-5">
                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Why to take test & Learn with <span class="text-current">Master Class</span></h2>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="100" data-aos-duration="500">
                        <i class="feather-award text-danger font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Unlimited tests</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="500">
                        <i class="feather-cpu text-info font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Quick QA sessions</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="500">
                        <i class="feather-hard-drive text-warning font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">Live Classes</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="400" data-aos-duration="500">
                        <i class="feather-lock text-secondary font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">24x7 Support</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 w-100 border-0 pt-4 pb-4 pr-4 pl-7 shadow-xss rounded-lg aos-init" data-aos="zoom-in" data-aos-delay="500" data-aos-duration="500">
                        <i class="feather-globe text-success font-xl position-absolute left-15 ml-2"></i>
                        <h2 class="fw-700 font-xss text-grey-900 mt-1">10000+ happy Students</h2>
                        <p class="fw-500 font-xssss lh-24 text-grey-500 mb-0">Praesent porttitor nunc vitae lacus vehicula, nec mollis eros congue.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="how-to-work pt-lg--7 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Notifications & Applications</h2>
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        <li class="active list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3 active" href="#navtabs11" data-toggle="tab">New</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3" href="#navtabs22" data-toggle="tab">Bank PO</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3" href="#navtabs11" data-toggle="tab">Railway</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3" href="#navtabs22" data-toggle="tab">Bank Clerk</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3" href="#navtabs11" data-toggle="tab">IFS</a></li>
                        <li class="list-inline-item"><a class="fw-700 ls-3 font-xssss text-black text-uppercase ml-3" href="#navtabs22" data-toggle="tab">Other</a></li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navtabs11">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pt-0 pl-4 mb-4">
                                <div class="form-group mb-3">
                                    <label class="fw-700 text-current pl-0">Download Applications</label>
                                </div>
                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0">Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">RRB Exam Application form</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Indian Navy Special recrutment drive</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Fireforce recrutment 2021</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Ways your mother lied to you about food stuffs</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade" id="navtabs22">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: 123-Abc</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="#" class="text-dark text-grey-900">Probationary Officer Grade II</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply: 12 Apr 2021 </h6>
                                            <a href="#"><small><i class="ti-import pr-1"></i></small></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pt-0 pl-4 mb-4">
                                <div class="form-group mb-3">
                                    <label class="fw-700 text-current pl-0">Download Applications</label>
                                </div>
                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0">Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">RRB Exam Application form</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Indian Navy Special recrutment drive</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Fireforce recrutment 2021</h2></div>
                                    </div>
                                </div>

                                <div class="card w-100 shadow-none bg-transparent border-0 mb-3">
                                    <div class="row">
                                        <div class="col-8 pl-1"><h6 class="font-xssss text-grey-500 fw-600 mt-0"> Last Date: 24 May 2020</h6><h2 class="fw-600 text-grey-800 font-xsss lh-3">Ways your mother lied to you about food stuffs</h2></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 offset-4">
                    <a href="#" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">View More</a>
                </div>
            </div>
        </div>
    </div>

    <div class="blog-page pt-lg--5 pt-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-8 col-md-10 text-center mb-5">
                    <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-xl ls-2 alert-warning d-inline-block text-warning mr-1">Blog</span>
                    <h2 class="text-grey-900 fw-700 font-xxl pb-3 mb-0 mt-3 d-block lh-3">Dont Miss Out Our Story</h2>
                    <p class="fw-300 font-xsss lh-28 text-grey-500">orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dol ad minim veniam, quis nostrud exercitation</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden aos-init" data-aos="fade-up" data-aos-delay="300" data-aos-duration="500">
                        <a href="{{url('blogs/1')}}"><img src="{{ asset('web/images/blog-1.jpeg') }}" alt="blog-image" class="w-100"></a>
                        <div class="post-content p-4">
                            <h6 class="font-xsss text-success fw-600 float-left">Travel</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-time mr-2"></i> 24 May 2020</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-user mr-2"></i> Jack Robin</h6>
                            <div class="clearfix"></div>
                            <h2 class="post-title mt-2 mb-2 pr-3"><a href="#" class="lh-30 font-sm mont-font text-grey-800 fw-700">Never the power of a sketch in accomplishing</a></h2>
                            <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3">Human coronaviruses are common and are typically associated with mild illnesses, similar to the common cold. We are digital agency.</p>
                            <a href="#" class="rounded-xl text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden aos-init" data-aos="fade-up" data-aos-delay="400" data-aos-duration="500">
                        <a href="{{url('blogs/1')}}"><img src="{{ asset('web/images/blog-2.jpeg') }}" alt="blog-image" class="w-100"></a>
                        <div class="post-content p-4">
                            <h6 class="font-xsss text-success fw-600 float-left">Design</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-time mr-2"></i> 24 May 2020</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-user mr-2"></i> Jack Robin</h6>
                            <div class="clearfix"></div>
                            <h2 class="post-title mt-2 mb-2 pr-3"><a href="#" class="lh-30 font-sm mont-font text-grey-800 fw-700">You work your way to ever creative thinking</a></h2>
                            <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3">Human coronaviruses are common and are typically associated with mild illnesses, similar to the common cold. We are digital agency.</p>
                            <a href="#" class="rounded-xl text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 mb-4">
                    <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden aos-init" data-aos="fade-up" data-aos-delay="500" data-aos-duration="500">
                        <a href="{{url('blogs/1')}}"><img src="{{ asset('web/images/blog-3.jpeg') }}" alt="blog-image" class="w-100"></a>
                        <div class="post-content p-4">
                            <h6 class="font-xsss text-success fw-600 float-left">Lifestyle</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-time mr-2"></i> 24 May 2020</h6>
                            <h6 class="font-xssss text-grey-500 fw-600 ml-3 float-left"><i class="ti-user mr-2"></i> Jack Robin</h6>
                            <div class="clearfix"></div>
                            <h2 class="post-title mt-2 mb-2 pr-3"><a href="#" class="lh-30 font-sm mont-font text-grey-800 fw-700">Being creative within the constraints of client briefs</a></h2>
                            <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3">Human coronaviruses are common and are typically associated with mild illnesses, similar to the common cold. We are digital agency.</p>
                            <a href="#" class="rounded-xl text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>
                        </div>
                    </article>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 offset-4">
                    <a href="#" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">Explore More</a>
                </div>
            </div>
        </div>
    </div>

    <div class="feedback-wrapper pt-lg--7 pb-lg--7 pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 text-left mb-5 pb-0">

                    <h2 class="text-grey-800 fw-700 font-xl lh-2">Customer love  what we do</h2>
                </div>

                <div class="col-lg-12">
                    <div class="feedback-slider2 owl-carousel owl-theme overflow-visible dot-none right-nav pb-4 nav-xs-none">
                        <div class="owl-items bg-transparent">
                            <div class="card w-100 p-0 bg-transparent text-left border-0">
                                <div class="card-body p-5 bg-white shadow-xss rounded-lg triangle-after">
                                    <p class="font-xsss fw-500 text-grey-700 lh-30 mt-0 mb-0 ">Quite simply the best theme we’ve ever purchased. The customisation and flexibility are superb. Speed is awesome. Not a criticism we can make. Fun to use the theme, easy installation, super easy to use. Excellent work.”</p>
                                    <div class="star d-block w-100 text-right mt-4 mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                    </div>
                                </div>

                                <div class="card-body p-0 mt-5 bg-transparent">
                                    <img src="{{ asset('web/images/user-7.png') }}" alt="user" class="w45 float-left mr-3">
                                    <h4 class="text-grey-900 fw-700 font-xsss mt-0 pt-1">Goria Coast</h4>
                                    <h5 class="font-xssss fw-500 mb-1 text-grey-500">Digital Marketing Executive</h5>
                                </div>
                            </div>
                        </div>

                        <div class="owl-items bg-transparent">
                            <div class="card w-100 p-0 bg-transparent text-left border-0 ">
                                <div class="card-body p-5 bg-white shadow-xss rounded-lg triangle-after">
                                    <p class="font-xsss fw-500 text-grey-700 lh-30 mt-0 mb-0 ">Quite simply the best theme we’ve ever purchased. The customisation and flexibility are superb. Speed is awesome. Not a criticism we can make. Fun to use the theme, easy installation, super easy to use. Excellent work.”</p>
                                    <div class="star d-block w-100 text-right mt-4 mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w15 float-left mr-2">
                                    </div>
                                </div>

                                <div class="card-body p-0 mt-5 bg-transparent">
                                    <img src="{{ asset('web/images/user-8.png') }}" alt="user" class="w45 float-left mr-3">
                                    <h4 class="text-grey-900 fw-700 font-xsss mt-0 pt-1">Goria Coast</h4>
                                    <h5 class="font-xssss fw-500 mb-1 text-grey-500">Digital Marketing Executive</h5>
                                </div>
                            </div>
                        </div>

                        <div class="owl-items bg-transparent">
                            <div class="card w-100 p-0 bg-transparent text-left border-0">
                                <div class="card-body p-5 bg-white shadow-xss rounded-lg triangle-after">
                                    <p class="font-xsss fw-500 text-grey-700 lh-30 mt-0 mb-0 ">Quite simply the best theme we’ve ever purchased. The customisation and flexibility are superb. Speed is awesome. Not a criticism we can make. Fun to use the theme, easy installation, super easy to use. Excellent work.”</p>
                                    <div class="star d-block w-100 text-right mt-4 mb-0">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                        <img src="{{ asset('web/images/star.png') }}" alt="star" class="w15 float-left mr-2">
                                    </div>
                                </div>

                                <div class="card-body p-0 mt-5 bg-transparent">
                                    <img src="{{ asset('web/images/user-6.png') }}" alt="user" class="w45 float-left mr-3">
                                    <h4 class="text-grey-900 fw-700 font-xsss mt-0 pt-1">Goria Coast</h4>
                                    <h5 class="font-xssss fw-500 mb-1 text-grey-500">Digital Marketing Executive</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('.dob').datepicker({});
    </script>
@endpush



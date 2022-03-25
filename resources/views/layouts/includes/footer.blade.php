<div class="footer-wrapper layer-after bg-dark mt-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-left mobile-text-center ">
                <h4 class="mb-4 text-grey-300 fw-300 font-xl open-font lh-3 d-inline-block">Get personal learning recommendations. Subscribe Us for new courses, application notifications, downloads etc</h4>
            </div>
            <div class="col-sm-12 text-left m-d-flex mobile-content-center">
                <div class="d-flex align-items-center mt-2 float-left xs-mb-2">
                    <div class="mr-2"><a href="#" class="btn-round-md bg-facebook"><i class="font-xs ti-facebook text-white"></i></a></div>
                    <div class="mr-2"><a href="#" class="btn-round-md bg-twiiter"><i class="font-xs ti-twitter-alt text-white"></i></a></div>
                    <div class="mr-2"><a href="#" class="btn-round-md bg-linkedin"><i class="font-xs ti-linkedin text-white"></i></a></div>
                    <div class="mr-2"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="middle-footer">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-6 sm-mb-4">
                            <h5>Trending Courses</h5>
                            <div>
                                @foreach($footer_courses as $key => $footer_course)
                                <div><a class="footer-text-color" style="color: #aaa" href="{{url('courses?search='.$footer_course->name)}}">{{$footer_course->name}}</a></div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-6 sm-mb-4">
                            <h5>Quick Links</h5>
                                <div><a class="footer-text-color" href="{{ route('courses.index') }}">All Courses</a></div>
                                <div><a class="footer-text-color"  href="{{ url('blogs') }}">Blogs</a></div>
                                <div><a class="footer-text-color"  href="{{ route('contact.index') }}">Contact</a></div>
                        </div>

                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-6">
                            <h5>About</h5>
                                <div><a class="footer-text-color" href="{{ route('faq') }}">FAQ</a></div>
                                <div><a class="footer-text-color" href="{{route('terms-of-use')}}">Term of use</a></div>
                                <div><a class="footer-text-color" href="{{route('privacy-policy')}}">Privacy Policy</a></div>
                                <div><a class="footer-text-color" href="{{ route('contact.index') }}">Feedback</a></div>
{{--                                <li><a href="#">Careers</a></li>--}}
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6 col-xs-6">
                            <h5 class="mb-3">Office</h5>
                            <p style="width: 100%;">Afotech Innovation Private Limited, Aster,
                                Arayakandipara, Azhikode, Kannur,
                                Kerala, 670009, India <br>admin@pscmitr.com</p>
{{--                            <p style="width: 100%;">41 madison ave, floor 24 new work, NY 10010 <br>1-877-932-7111</p>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 lower-footer"></div>
            <div class="col-sm-6">
                <p class="copyright-text">© 2021 copyright. All rights reserved.</p>
            </div>
            <div class="col-sm-6 text-right">
                <p class="float-right copyright-text">Designed By <a href="#">Pixbit Solutions Pvt Ltd</a></p>
            </div>
        </div>
    </div>
</div>

@extends('layouts.app')

@section('title', 'Quiz')

@section('content')
<div class="container pt-lg--7 pb-lg--7 pt-5 pb-5">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left">

            <div class="row">

                <div class="col-xxl-4 col-xl-4 col-md-12">
                    <div class="card mb-4 d-block w-100 shadow-xss rounded-lg p-md-5 p-4 border-0 text-center">

                        <div class="col-md-12">
                            <h2 class="fw-700  mt-4"> {{ $test->display_name }} </h2>
                        </div>
                        <div class=" d-none d-sm-block">
                            <p class="fw-500 font-xssss text-grey-500 text-justify mt-3">
                                {{ $test->description }}
                            </p>

                            <div class="clearfix"></div>

                            <span class="font-xssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1 ">
                            {{ $test->total_questions }} Questions
                        </span>

                            <span class="font-xssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">
                            {{ $test->total_marks }} Marks
                        </span>

                            <span class="font-xssss fw-700 mb-2 pl-2 pr-2 lh-32 text-uppercase rounded-lg ls-2 bg-lightblue d-inline-block text-grey-800 mr-1">
                            Objective-type (MCQs)
                        </span>

                            <span class="font-xssss fw-700 mb-2 pl-2 pr-2 lh-32 text-uppercase rounded-lg ls-2 alert-info d-inline-block text-info">
                           <span><i class="fa fa-clock-o pr-1"></i></span>{{ $test->total_time }}
                        </span>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-8 col-xl-8 col-md-12 col-sm-12">
                    <div class="mb-4 d-block w-100 pt-0  rounded-lg px-5 py-3 border-0 text-left question-div m-p-0 mobile-text-center">
{{--                        <div class="col-12">--}}
                            <form name="testRatingForm" id="test-rating-form">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="font-xs text-grey-800 fw-700">Hi Student, how do you feel about the exam?</p><br>
                                    </div>

                                    <div class="col-lg-2 col-md-6 p-3 m-d-none">
                                        <img  src="{{ asset('images/icons/point.png') }}" alt="point"  class="w35 ml-0 mr-2">
                                    </div>
                                    <div class="col-lg-2 col-md-6 p-3">
                                        <img data-value="5" src="{{ asset('images/icons/happier.png') }}" alt="very happy" class="test-rating w35  ml-2 mr-1">
                                    </div>
                                    <div class="col-lg-2 col-md-6 p-3">
                                        <img data-value="4" src="{{ asset('images/icons/smile.png') }}" alt="happy" class="test-rating w35 ml-2 mr-1">
                                    </div>
                                    <div class="col-lg-2 col-md-6 p-3">
                                        <img data-value="3" src="{{ asset('images/icons/neutral.png') }}" alt="neutral" class="test-rating w35 ml-2 mr-1">
                                    </div>
                                    <div class="col-lg-2 col-md-6 p-3">
                                        <img data-value="2" src="{{ asset('images/icons/sad.png') }}" alt="sad" class="test-rating w35 ml-2 mr-1">
                                    </div>
                                    <div class="col-lg-2 col-md-6 p-3">
                                        <img data-value="1" src="{{ asset('images/icons/dissapointment.png') }}" alt="disappointed" class="test-rating w35 ml-2 mr-1">
                                    </div>
                                </div>
                            </form>
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(function () {
        let testId = '{{ $test->id }}';
        let testResultId = '{{ $testresultId }}';

        $('.test-rating').on('click', function(e) {
            let rating = $(this).data('value');
            e.preventDefault();
            $.ajax({
            type: 'POST',
            url:  '{{ url('user/tests') }}' + '/'+ testId +'/rating',
            data: {
                "_token": "{{ csrf_token() }}",
                'testResultId': testResultId,
                'rating': rating
            },
            success: function(response){
                if(response){
                    swal("Thank you! Your rating have been submitted.")
                        .then ( function() {
                            window.location.href =   '{{ url('user/tests') }}' + '/'+ testId +'/test_result/'+ testResultId +'/result';
                        });

                    }
                }
            });
        });
    });
</script>
@endpush

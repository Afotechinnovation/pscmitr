@extends('layouts.app')

@section('title', 'Quiz')

@section('content')
    <style>
        @media screen and (max-width: 768px) {
            .header-wrapper {
                display: none;
            }
        }

    </style>
    <div class="container pt-3" >
        <div class="middle-sidebar-bottom" id="test-div">
            <div class="middle-sidebar-left" id="test-question-div">
                <div class="row" >
                    <div class="col-xxl-12 col-xl-12 col-md-12">
                        <div class="row pb-2">
                            <div class="col-md-11">
                                <h1 class="fw-600 mb-0 text-center "> {{ $test->display_name }} </h1>
                            </div>

                        </div>
                    </div>

                    <div class="col-xxl-8 col-xl-8 col-md-12 pb-5 question-div-row">
                        <div class="card border-0  bg-white shadow-xss shadow-xss rounded-lg" id="sections">
                            @if(!$confirmation)
                                <form  name="filter-section-form" id="filter-section-form" action="{{ route('user.tests.show', $test->id)  }}" method="GET">
                                    <ul class="nav nav-pills pills-dark pt-1 pl-4 " id="pills-tab" role="tablist">
                                        @foreach ($test_sections as $test_section)
                                        <li class="nav-item p-2">
                                            <a class="nav-link {{ $tab == $test_section->name_slug ? 'active' : '' }}  rounded-xl" id="pills-section-tab"
                                               href="{{ url('user/tests/'.$test->id.'?package='.$packageId.'&question=1&tab='.$test_section->name_slug.'&page=1') }}"
                                               role="tab" aria-controls="pills-sections" aria-selected="true" > {{$test_section->name}}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="tab" value="{{ $tab }}" id="section-tab">
                                </form>
                            @endif

                            <div class=" d-block w-100 pt-0 px-5 py-3 text-left question-div ">
                                <form id="quiz-form" class="quiz-form" method="POST" action="{{ route('user.tests.answers.store') }}"  >
                                    @csrf
                                    @if(!$confirmation && request()->question <= $totalQuestionsCount)
                                    <div class="card-body p-0 ">
                                        <div class="row">
                                            <div class="col-9 pl-0 ">
                                                <h4 class="font-xsss text-uppercase  text-current fw-700 ls-3 ">
                                                    Question {{ request()->input('question') }}
                                                </h4>
                                            </div>
                                            <div class="col-3">
                                                @if(!$userFavouriteQuestion)
                                                    <img src="{{ asset('web/images/star-disable.png') }}" alt="star" data-question-id="{{ $question->id }}"  class="add-user-favourite-questions w20 float-right " data-toggle="tooltip" title="Question has been added to Favourites!">
                                                @else
                                                    <img src="{{ asset('web/images/star.png') }}" alt="star" data-favourite-question-id="{{ $userFavouriteQuestion->id }}" class="delete-user-favourite-questions w20 float-right " data-toggle="tooltip" title="Question has been removed from Favourites">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 pl-0">
                                                <h1  class="font-sm text-grey-800 fw-700 d-inline-block lh-32 " >
                                                       {!! $question->question !!}
                                                </h1>
                                            </div>
                                        </div>
                                        @if($question->image)
                                            <div class="row mobile-text-center">
                                                <div class="imgContainer">
                                                    <div class="row mt-3">
                                                        <div class="col px-2">
                                                            <img src="{{ url('storage/questions/image/'.$question->image) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if( $question->type == \App\Models\Question::QUESTION_TYPE_OBJECTIVE )
                                            <div class="col-12 col-md-12  pr-0">
                                                <div class="row">
                                                    @foreach( $question->options as $key => $option)
                                                        <div class="col-12 option-container rounded-lg ">
                                                            <input id="option{{ $key }}" @if( $studentTestAnswer )
                                                            @if( $studentTestAnswer->option_id == $option->id ) checked @endif @endif class="form-group quiz-radio-btn "
                                                            type="radio" name="option_radio" value="{{ $option->id }}">

                                                            <label for="option{{ $key }}" class="clickable theme-dark-bg">
                                                                <div class="option font-xss fw-600 lh-30 mb-0 ">
                                                                   {!! $option->option  !!}
                                                                </div>
                                                            </label>
                                                        </div>
                                                        @if($option->image)
                                                            <div class="option-images mobile-text-center">
                                                                <div class="imgContainer">
                                                                    <div class="row mt-3">
                                                                        <div class="col px-2 ml-2">
                                                                            <img src="{{ $option->image }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @elseif( $question->type == \App\Models\Question::QUESTION_TYPE_TRUE_OR_FALSE  )
                                            <div class="col-12 pl-0 pr-0" >
                                                <div class="row">
                                                    <div class="col-6 col-md-6">
                                                        <div class="option-container-true-or-false rounded-lg ">
                                                            <input id="true" class="form-group quiz-radio-btn"
                                                                 @if($studentTestAnswer)  {{ $studentTestAnswer->is_true ? 'checked' : '' }} @endif
                                                                type="radio"  name="option_radio" value="true">
                                                            <label for="true" class="clickable theme-dark-bg">
                                                                <p class="option pt-2 pl-4 font-xss fw-600 lh-30 ">
                                                                    True
                                                                </p>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6 ">
                                                        <div class="option-container-true-or-false rounded-lg ">
                                                            <input id="false" class="form-group quiz-radio-btn "
                                                                   @if($studentTestAnswer)  {{ !$studentTestAnswer->is_true ? 'checked' : '' }} @endif
                                                                   type="radio"  name="option_radio" value="false">
                                                            <label for="false" class="clickable theme-dark-bg">
                                                                <p class="option  pt-2 pl-4 font-xss fw-600 lh-30 ">
                                                                    False
                                                                </p>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12 pl-0 pr-0" id="description">
                                                <textarea class="form-control mt-3"  name="test_description" id="test_description"
                                                   rows="5"> @if($studentTestAnswer) {{ old('test_description', $studentTestAnswer->descriptive_answer )}}
                                                    @else  {{ old('test_description') }}  @endif
                                                </textarea>
                                            </div>
                                        @endif
                                            <div class="row justify-content-center">
                                                <div  class="col-sm-12  col-md-4 col-lg-4 mobile-text-center" >
                                                    <button type="submit"  class=" next border-yellow  p-2 mt-3 d-inline-block  fw-700 lh-30 rounded-lg  w200 font-xsss ls-3 button-test " >
                                                        SAVE & NEXT
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row ">
                                                <div class="col-4 @if( request()->input('question') == 1 ) col-6 @endif p-1" >
                                                    <button type="button" data-question-id="{{ $question->id }}"  class="button-test  @if( request()->input('question') == 1 ) float-right-md  @endif lh-34 p-1 p-md-2 clear-response-btn border-back mt-3 d-inline-block fw-700
                                                     rounded-lg  w-100 font-xsss ls-3" >
                                                        CLEAR RESPONSE
                                                    </button>
                                                </div>
                                                @if( request()->input('question') != 1 )
                                                    <div class=" col-4  text-left p-1">
                                                        <a href="{{ url('user/tests/'. $test->id .'?package=' .$packageId. '&question='. (request()->input('question')-1)).'&tab='.$tab }}">
                                                            <button type="button"  class="next  mt-3 d-inline-block w-100 fw-700 rounded-lg font-xsss p-2 border-blue button-test lh-34">
                                                                PREVIOUS
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class=" col-4 @if( request()->input('question') == 1 ) col-6  @endif p-1">
                                                    <button type="button" data-question-id="{{ $question->id }}" class=" button-test mark-for-review p-1 p-md-2 mt-3 d-inline-block fw-700 lh-34
                                                    rounded-lg w-100 font-xsss ls-3 border-purple ">
                                                        MARK FOR REVIEW
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="hidden-inputs-container">
                                             <input type="hidden" name="test_id" value="{{ $test->id }}">
                                             <input type="hidden" name="question_id" value="{{ $question->id }}">
                                             <input type="hidden" name="package_id" value="{{ request()->package }}">
                                             <input type="hidden" name="question" value="{{ request()->question }}">
                                             <input type="hidden" name="tab" value="{{ request()->tab }}">
                                             <input type="hidden" id="isMarkedForReview" name="is_marked_for_review" value="false">
                                         </div>
                                    @endif
                                    <div class="card-body p-0"  id="confirmation" @if(!$confirmation) hidden @endif >
                                       <form id="submitTestForm" name="submitTestForm">
                                           @csrf

                                            <h2 class=" text-grey-800 fw-700 lh-32 mt-4 mb-0 custom-question-li">
                                                Hi Student, You still have {{ floor($testResult->test_end_time / 60) }} minutes remaining!
                                            </h2>

                                           <h3 class="font-xss text-dark-blue fw-700 lh-32 mt-4 mt-2 custom-question-answered">
                                               <img  src="{{ asset('images/icons/point.png') }}" alt="point"  class="w50 ml-0 mr-2">
                                               You have attempted {{ $totalQuestionsAttended }} / {{ $totalQuestionsCount }} @if($totalQuestionsNotAttended < 2) question @else questions @endif!
                                           </h3>

                                            <h3 class="font-xss text-dark-blue fw-700 lh-32 mt-4 mt-2 custom-question-answered">
                                                <img  src="{{ asset('images/icons/point.png') }}" alt="point"  class="w50 ml-0 mr-2">
                                                You have not answered {{ $totalQuestionsNotAttended }} @if($totalQuestionsNotAttended < 2) question @else questions @endif!
                                            </h3>
                                            <h3 class="font-xss text-dark-blue fw-700 lh-32 mt-4 mt-2 custom-question-answered">
                                                <img  src="{{ asset('images/icons/point.png') }}" alt="point"  class="w50 ml-0 mr-2">
                                                You have marked {{ $totalQuestionsMarkedForReview }}
                                                @if($totalQuestionsMarkedForReview < 1) question @else questions @endif for review !
                                            </h3>

                                            <div class="row">
                                                <div class="col-md-6 d-flex justify-content-center">
                                                     <button type="button" id="formSubmitBtn" class="next p-2 mt-3 d-inline-block border-green
                                                     fw-700 lh-30 rounded-lg float-left w200 font-xsss ls-3  custom-question-answered">SUBMIT</button>
                                                </div>
                                                <div class="col-md-6 d-flex justify-content-center">
                                                    <a href="{{ url('user/tests/'.$test->id.'?test_result='.$testResult->id.'&question=1') }}">
                                                        <button type="button"  class="next p-2 mt-3  d-inline-block border-yellow
                                                        fw-700 lh-30 rounded-lg float-left w200 font-xsss ls-3  custom-question-answered">CANCEL</button>
                                                    </a>
                                                </div>
                                             </div>
                                       </form>
                                   </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-md-12 col-sm-12 col-xs-12 timer-div">
                        <div class="col-12">
                            <div class="row ">
                                <div class="card border-0 mb-4 bg-white shadow-xss rounded-lg" style="width: 100%; min-height: 123px;">
                                    <div class="card-body bg-white d-flex justify-content-between align-items-end p-2">
                                        <div class="col-12 m-d-flex mobile-content-center">
                                            <div class="timer mt-4 mb-2" id="count-down-timer"></div>
                                            <input id="timer" value="60" hidden>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mb-4 d-sm-none d-md-block ">
                                <button class="border-primary bg-primary navbar-toggler " type="button" data-toggle="collapse" data-target="#testAnswerPalatteCollapse" aria-expanded="false" aria-controls="testAnswerPalatteCollapse" aria-label="Toggle navigation">
                                    <span class="text-white">Answer Palette </span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse" id="testAnswerPalatteCollapse">
                                <div class="navbar-nav nav-menu float-none ">
                                    <div class=" row answer-palatte-div " >
                                        <div class="card border-0 mb-4 bg-white shadow-xss rounded-lg">
                                            <div class="card-body p-5">
                                                <div class="row">
                                                    <h2 class="font-xss text-uppercase text-current fw-700 ls-3 custom-question-li">Answer Palette</h2>
                                                    <div class="col-12 pt-2 pl-0 pb-4 pr-2 float-none">
                                                        <div class="card w-100 border-0 mt-1">
                                                            @if(\Illuminate\Support\Facades\Auth::user())
                                                                @if( $totalTestQuestions )
                                                                    @if($test_sections->count() == 0 )
                                                                        <div class="row m-0">
                                                                            @foreach( $totalTestQuestions as $key => $testQuestion )
                                                                                <a href="{{ url('user/tests/'. $test->id .'?test_result=' .$testResult->id. '&question='.($key +1)) }}">
                                                                                    @if( in_array( $testQuestion->question_id, $studentAttemptsArray ))
                                                                                        <span class="circle mb-2  text-white bg-primary " > {{ $key +1 }} </span>
                                                                                    @elseif( in_array( $testQuestion->question_id, $markedForReviewArray ))
                                                                                        <span class="circle mb-2 bg-purple text-white "> {{ $key +1 }} </span>
                                                                                    @elseif(in_array( $testQuestion->question_id, $reviewQuestionWithOptionArray) )
                                                                                        <span class="circle mb-2 bg-warning text-white"> {{ $key +1 }} </span>
                                                                                    @else
                                                                                        <span class="circle mb-2 "> {{ $key + 1 }} </span>
                                                                                    @endif
                                                                                </a>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        @foreach($test_sections as $sectionKey => $section)
                                                                            <div class="row ml-2">
                                                                                <span class="text-current pr-2" > <small>{{ ucfirst($section->name) }} :  </small> </span>
                                                                                @foreach($section->test_questions as $key => $test_question)
                                                                                    <a href="{{ url('user/tests/'. $test->id .'?test_result=' .$testResult->id. '&question='.($key +1).'&tab='.$section->name_slug) }}">
                                                                                        @if( in_array( $test_question->question_id, $studentAttemptsArray ))
                                                                                            <span class="circle mb-2  text-white bg-primary " > {{ $key +1 }} </span>
                                                                                        @elseif( in_array( $test_question->question_id, $markedForReviewArray ))
                                                                                            <span class="circle mb-2 bg-purple text-white"> {{ $key +1 }} </span>
                                                                                        @elseif(in_array( $test_question->question_id, $reviewQuestionWithOptionArray) )
                                                                                            <span class="circle mb-2 bg-warning text-white"> {{ $key +1 }} </span>
                                                                                        @else
                                                                                            <span class="circle mb-2"> {{ $key + 1 }} </span>
                                                                                        @endif
                                                                                    </a>
                                                                                @endforeach
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-12 pl-0">
                                                        <div class="border-0" >
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <span class="dot d-inline-block bg-primary custom-question-answered " ></span>
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Attempted</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <span class="dot d-inline-block custom-question-answered" ></span>
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Unattempted</span>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-2 ">
                                                                    <span class="dot d-inline-block bg-purple custom-question-answered" ></span>
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Mark for Review </span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-2">
                                                                    <span class="dot d-inline-block bg-warning custom-question-answered" ></span>
                                                                </div>
                                                                <div class="col-10">
                                                                    <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Mark for Review + Attempted</span>
                                                                </div>
                                                            </div>

                                                            @if(!request()->confirmation == true)
                                                                <div class="row ">
                                                                    <div class="col-6 pr-3 ">
                                                                        <button type="submit"  class="p-2 mt-3 d-inline-block fw-700 lh-30 w125 rounded-lg
                                                                        font-xssss ls-3 border-green custom-question-answered" id="answer-palatte-submit-test" >
                                                                            SUBMIT
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-6 justify-content-center">
                                                                        <button type="button"  class="p-2  mt-3 border-red  d-inline-block  fw-700 lh-30 rounded-lg w125
                                                                        font-xssss ls-3 custom-question-answered" id="pause-exit-button">
                                                                            EXIT
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        $(function () {

            $("#test-div").on("contextmenu",function(e){
                return false;
            });

            $('#test-div').bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            let isTimeOut = false;
            function CountDown(duration, countDownTimer) {
                if (!isNaN(duration)) {
                    var timer, hours, minutes, seconds, warning, ok;
                    timer = duration;
                    warning = 60;
                    ok = false;

                    var interVal=  setInterval(function () {
                        hours = Math.floor((timer % (60 * 60 * 24)) / (3600));
                        minutes = Math.floor((timer % (60 * 60)) / 60);
                        seconds =  Math.floor(timer % 60, 10);

                        hours   = hours < 10 ? "0" + hours : hours;
                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;

                        $(countDownTimer).html(''
                            + '<div class="time-count"><span class="text-time">'+hours+'</span> <span class="text-day">Hours</span> </div> '
                            + '<div class="time-count"><span class="text-time">'+minutes+'</span> <span class="text-day">Min</span> </div> '
                            + '<div class="time-count"><span class="text-time">'+seconds+'</span> <span class="text-day">Sec</span> </div> ');

                        if( timer == warning && !ok ){
                            swal('Time is running out! You have less than 1 minute to go!');
                            ok=true;
                        }

                        if (--timer <= 0) {
                            timer = duration;
                            isTimeOut =  true;

                            $( "#formSubmitBtn" ).trigger("click");

                            if( !isNaN( interVal ) )clearInterval( interVal );
                            $('#count-down-timer').empty();
                            clearInterval(interVal)
                        }

                    },1000);
                }
            }

            var time_in_sec = '{{ $testResult->test_end_time }}';

            CountDown(time_in_sec,$('#count-down-timer'));

            let testId = '{{ $test->id }}';
            let packageId = '{{ $packageId }}';
            let test_result_id = '{{$testResult->id}}';
            let question = '{{ request()->question }}';
            let tab = '{{ $tab }}';
            question = {{ request()->question + 1 }};

            $('#answer-palatte-submit-test').on('click', function(e) {
                var url = '{{ url('user/tests') }}' + '/'+ testId +  '?test_result/'+test_result_id + '&confirmation=true';
                window.location.href =  url;

            });

            $('#pause-exit-button').on('click', function(e) {

                swal({
                    title: "Are you sure?",
                    text: "Do you want to exit!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((exit) => {
                        if (exit) {
                            var url = '{{ url('user/tests') }}';
                            window.location = url;
                        } else {
                            swal("Go back to test!");
                        }
                    });

            });

            $('#formSubmitBtn').on('click', function(e) {

                let totalQuestionsAttempted = '{{ $totalQuestionsAttended }}';
                let totalQuestions = '{{ $totalQuestionsCount }}';
                let message = 'You have successfully attempted '+ totalQuestionsAttempted +' /'+ totalQuestions + ' questions';
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.tests.submit') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': '{{ $test->id }}',
                        'testResultId': test_result_id,
                    },
                    success: function(response){
                        if(response){

                            if(isTimeOut){
                                swal("Oops! The time is up!", message, "warning")
                                    .then ( function() {
                                     window.location.href =   '{{ url('user/tests') }}' + '/'+ testId + '/test_result/'+ test_result_id +'/rating';
                                    });
                            }
                            else{
                                window.location.href =   '{{ url('user/tests') }}' + '/'+ testId + '/test_result/'+ test_result_id +'/rating';
                            }
                        }
                    }
                });
            });

            $(".mark-for-review").on('click', function(){

                let questionId =  $(this).data('question-id');
                let test_result_id = '{{$testResult->id}}';
                let option = $(".quiz-radio-btn:checked").val();
                let tab = $('#section-tab').val();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('user.tests.question.mark-for-review') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'test_id': testId,
                            'question_id': questionId,
                            'test_result_id' : test_result_id,
                            'option_radio': option,
                            'tab' : tab
                        },
                        success: function(response){
                            swal("Successfully Added To Marked for Review!")
                                .then ( function() {
                                    location.reload(true);
                                });
                        }
                    });
            });

            $(".clear-response-btn").click(function(e) {
                e.preventDefault();
                let questionId =  $(this).data('question-id');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.tests.question.clear-response') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId,
                        'testResultId': test_result_id,
                        'questionId': questionId,
                    },
                    success: function(response){
                        swal("Response cleared!")
                            .then ( function() {
                                location.reload(true);
                            });
                    }
                });
            });

            $(".add-user-favourite-questions").click(function(e) {
                e.preventDefault();
                let questionId =  $(this).data('question-id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.user-favourite-questions.store') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId,
                        'testResultId': test_result_id,
                        'questionId': questionId,
                    },
                    success: function(response){
                        swal("Question Successfully added to favourite list!")
                            .then ( function() {
                                location.reload(true);
                            });
                        }
                });
            });

            $(".delete-user-favourite-questions").click(function(e) {
                e.preventDefault();

                let favouriteQuestionId  =  $(this).data('favourite-question-id');
                $.ajax({
                    type: 'POST',
                    url: '{{url('/user/user-favourite-questions/destroy')}}' +'/' +favouriteQuestionId,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'favouriteQuestionId': favouriteQuestionId,
                    },
                    success: function(response){
                        swal("Successfully removed from favourite list!")
                            .then ( function() {
                                location.reload(true);
                            });
                    }
                });
            });

            $(".add-user-favourite-tests").click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.user-favourite-tests.store') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId,
                        'testResultId': test_result_id,
                    },
                    success: function(response){
                        location.reload(true);
                        swal('Test Successfully added to favourite list!',30);

                    }
                });
            });

            $(".delete-user-favourite-tests").click(function(e) {
               let favouriteTestId = $(this).data('favourite-test-id');
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.favourite-tests.destroy') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'favouriteTestId': favouriteTestId,
                    },
                    success: function(response){
                        location.reload(true);
                        toastr.success('Test Successfully removed from favourite list!');

                    }
                });
            });

        });
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Test')

@section('content')

    <div class="container pb-5">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">
                <div class="row">
                    <input type="hidden" name="question" value="{{ request()->question }}">
                    <div class="col-xxl-8 col-xl-8 col-md-12 col-sm-12">
                        <div class="card-body text-center p-3 bg-no-repeat bg-image-topcenter" id="solution">
                            <form  name="filter-test-form" id="filter-test-form" action="{{  route('user.test-solution',['id'=>$test->id,'testresultId'=>$testresultId])  }}" method="GET">
                                <ul class="nav nav-pills pills-dark mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link  {{ $tab == 'all-questions' ? 'active' : '' }}    rounded-xl" id="pills-all_question-tab"
                                           href="{{ url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab=all-questions&question=1' }}"
                                           role="tab" aria-controls="pills-all_question" aria-selected="true" >All Questions
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'correct' ? 'active' : '' }}  rounded-xl"  id="pills-correct-tab"
                                           href="{{  url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab=correct&question=1' }}"
                                           role="tab" aria-controls="pills-correct" aria-selected="false">Correct</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'wrong' ? 'active' : '' }} rounded-xl"  id="pills-wrong-tab"
                                           href="{{  url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab=wrong&question=1' }}"
                                           role="tab" aria-controls="pills-rating" aria-selected="false">Wrong</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'unattempted' ? 'active' : '' }}  rounded-xl"  id="pills-unattempted-tab"
                                           href="{{ url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab=unattempted&question=1' }}"
                                           role="tab" aria-controls="pills-unattempted" aria-selected="false">UnAttempted</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  {{ $tab == 'favourite' ? 'active' : '' }}  rounded-xl" id="pills-favourite-tab"
                                           href="{{ url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab=favourite&question=1' }}"
                                           role="tab" aria-controls="pills-favourite" aria-selected="false">Favourite</a>
                                    </li>
                                </ul>
                                <input type="hidden" name="tab" value="{{ $tab }}">

                            </form>
                            <div class="row">
                                <div class="col-10" >
                                    <h4 class="font-xssss text-uppercase text-current fw-700 ls-3">{{ $test->display_name }}</h4>
                                </div>
                                @if($studentQuestion)
                                    <div class="col-2">
{{--                                        @if(!$userFavouriteQuestion)--}}
{{--                                            <img src="{{ asset('web/images/star-disable.png') }}" alt="star" data-question-id="{{ $question->id }}"  class="add-user-favourite-questions w20 float-right " data-toggle="tooltip" title="Question has been added to Favourites!">--}}
{{--                                        @else--}}
{{--                                            <img src="{{ asset('web/images/star.png') }}" alt="star" data-favourite-question-id="{{ $userFavouriteQuestion->id }}" class="delete-user-favourite-questions w20 float-right " data-toggle="tooltip" title="Question has been removed from Favourites">--}}
{{--                                        @endif--}}
                                        @if ( in_array( $studentQuestion->question->id, $favouriteQuestions) )
                                            <img src="{{ asset('web/images/star.png') }}" alt="star" data-favourite-question-id="{{ $userFavouriteQuestion->id }}" class="w15 d-inline-block pt-3 delete-user-favourite-questions" data-toggle="tooltip" title="Question has been removed from Favourites">
                                        @else
                                            <img src="{{ asset('web/images/star-disable.png') }}" alt="star" data-question-id="{{ $studentQuestion->question->id }}" class="add-user-favourite-questions  w15 d-inline-block pt-3" data-toggle="tooltip" title="Question has been added to Favourites!">
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($studentQuestion)
                                <div class="row">
                                    @if($studentQuestion->test_section)
                                        <div class="col-6 text-left">
                                            <h2  class="font-xs text-grey-800 fw-700 d-inline-block mt-4 mb-4">
                                                {{ ucfirst($studentQuestion->test_section->name )}}
                                            </h2>
                                        </div>
                                    @endif
                                </div>
                                 <div class="row">
                                     <h3 class="font-xss text-grey-800 fw-700 d-inline-block lh-32 mt-2 mb-2"> {{ request()->input('question') }}.  &nbsp  </h3>
                                     <div class="col-10 text-left p-0">
                                        <h3  class="font-xss text-grey-800 fw-700 d-inline-block lh-32 mt-2 mb-2 " >
                                            {!! $question->question !!}
                                        </h3>
                                    </div>
                                </div>
                                @if($studentQuestion->question->image)
                                    <div class="row mobile-text-center">
                                        <div class="imgContainer">
                                            <div class="row mt-2 mt-3">
                                                <div class="col px-2">
                                                    <img src="{{  url('storage/questions/image/'.$studentQuestion->question->image)  }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if( $studentQuestion->question->type == \App\Models\Question::QUESTION_TYPE_OBJECTIVE )
                                    {{--Your Answer--}}
                                    @if($studentQuestion->studentAnswer)
                                        @if($studentQuestion->studentAnswer->option)
                                            <div class="col-12">
                                                <div class="row pt-2">
                                                    <div class="col-4 text-left">
                                                        <span class="badge badge-primary">Your Answer : </span>
                                                    </div>
                                                    <div class="col-8 text-left pl-5">
                                                        <span class="font-xss pt-1 text-grey-800">{!! $studentQuestion->studentAnswer->option->option!!}
                                                            @if($studentQuestion->studentAnswer->is_correct)
                                                                <span><i class="fa fa-check text-success"></i></span>
                                                            @else
                                                                <span><i class="fa fa-times text-danger"></i></span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($studentQuestion->studentAnswer->option->image)
                                                <div class="option-images mobile-text-center">
                                                    <div class="imgContainer">
                                                        <div class="row mt-3">
                                                            <div class="col px-2">
                                                                <img src="{{ $studentQuestion->studentAnswer->option->image }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    {{-- Correct Answer--}}
                                    @foreach( $studentQuestion->question->options as $option )
                                        @if( $option->is_correct )
                                            <div class="col-12">
                                                <div class="row pt-2 pb-0">
                                                    <div class="col-4  text-left">
                                                        <span class="badge badge-success">Correct Answer : </span>
                                                    </div>
                                                    <div class="col-8  text-left pl-5">
                                                        <span class="font-xss pt-1 text-grey-800">{!! $option->option !!} </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($option->image)
                                                <div class="option-images mobile-text-center">
                                                    <div class="imgContainer">
                                                        <div class="row mt-3">
                                                            <div class="col px-2">
                                                                 <img src="{{ $option->image }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach

                                @elseif( $studentQuestion->question->type == \App\Models\Question::QUESTION_TYPE_TRUE_OR_FALSE )
                                    @if($studentQuestion->studentAnswer)
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4  text-left">
                                                    <span class="badge badge-primary">Your Answer : </span>
                                                </div>
                                                <div class="col-8  text-left pl-5">
                                                    <p class="font-xss pt-1 text-grey-800">{{ $studentQuestion->studentAnswer->is_true ? 'TRUE' : 'FALSE' }}
                                                        @if($studentQuestion->studentAnswer->is_correct)
                                                            <span><i class="fa fa-check text-success"></i></span>
                                                        @else
                                                            <span><i class="fa fa-times text-danger"></i></span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @foreach( $studentQuestion->question->options as $option )

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4 text-left">
                                                    <span class="badge badge-success ">Correct Answer : </span>
                                                </div>
                                                <div class="col-8 text-left pl-5">
                                                    @if( $option->is_correct )
                                                        <p class="font-xss pt-1 text-grey-800">TRUE</p>
                                                    @else
                                                        <p class="font-xss pt-1 text-grey-800">FALSE</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @if($option->image)
                                            <div class="option-images mobile-text-center">
                                                <div class="imgContainer">
                                                    <div class="row mt-3">
                                                        <div class="col px-2">
                                                            <img src="{{ $option->image }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        @if($studentQuestion && $question->explanation)
                             <div class="col-3 text-left pt-0">
                                <span class="badge badge-primary ml-3 ">Explanation : </span>
                            </div>
                            <div class=" row pt-0 pl-3">
                                <div class="col-9 imgContainer pl-5">
                                    {!! $question->explanation !!}
                                </div>
                            </div>
                        @endif
                        @if($questionID)
                            <div class="row">
                                <div class="col-11  mr-0">
                                    <input type="text" name="doubt" required  id="doubt" placeholder="Type your doubts here" class="form-control" style="border-radius: 0px; border: 0px; border-bottom: 1px #eee solid" >
                                </div>
                                <div class="col-1 mt-4">
                                    <img src="{{ asset('images/icons/send.png') }}" id="submit-doubt" alt="total marks" class="w20"
                                         style="margin-left: -44px;">
                                </div>
                            </div>


                            <div class="row justify-content-center">
                                @if( request()->input('question') != 1 )
                                    <div class=" col-xs-12 col-sm-12 col-md-4 col-lg-4  text-center">
                                        <a href="{{ url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution').'?tab='.$tab.'&question='. (request()->input('question')-1) }}">
                                            <button type="button"  class="btn p-1 mt-3 btn-outline-secondary text-secondary fw-700
                                            lh-30 rounded-lg w200 font-xssss ls-3 bg-white">
                                                PREVIOUS
                                            </button>
                                        </a>
                                    </div>
                                @endif
                                <div  class="col-sm-12  col-md-4 col-lg-4 text-center" >
                                    <button type="submit" id="save-next" class="btn p-1 mt-3 btn-outline-warning text-warning fw-700
                                            lh-30 rounded-lg w200 font-xssss ls-3 bg-white" >
                                         NEXT
                                    </button>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-4 col-sm-6 text-center">
                                    <a href="{{ url('user/tests') }}">
                                        <button type="button"  class="btn p-1 mt-3 btn-outline-success text-success fw-700
                                            lh-30 rounded-lg w200 font-xssss ls-3 bg-white">
                                            GO TO DASHBOARD
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-4 col-sm-6 text-center" >
                                    <a href="{{ url('user/tests/'.$test->id.'/test_result/'. $testresultId.'/result') }}">
                                        <button type="button"  class="btn p-1 mt-3 btn-outline-info text-info fw-700
                                            lh-30 rounded-lg  w200 font-xssss ls-3 bg-white">
                                            GO TO RESULT
                                        </button>
                                    </a>
                                </div>
                            </div>
                        @else
                          <div class="text-center">  No data available </div>
                        @endif
                    </div>
                    @if($questionID)
                        <div class="col-xxl-4 col-xl-4 col-md-12">
                        <div class="d-none d-sm-block">
                            <div class="card mb-4 d-block w-100 shadow-xss rounded-lg p-md-5 p-4 border-0 text-center ">
                                <div class="col-md-12">
                                    <h4 class="fw-700 font-xs mt-4"> {{ $test->display_name }} </h4>
                                </div>

                                <p class="fw-500 font-xssss text-grey-500 mt-3">
                                    {{ $test->description }}
                                </p>
                                <div class="clearfix"></div>
                                <span class="font-xssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">
                                {{ $test->test_questions->count() }} Questions
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

                        <div class="row justify-content-center mb-4 d-sm-none d-md-block pt-3">
                            <button class="border-primary bg-primary navbar-toggler" type="button" data-toggle="collapse" data-target="#solutionAnswerpalatte" aria-expanded="false" aria-controls="solutionAnswerpalatte" aria-label="Toggle navigation">
                                <span class="text-white">Answer Palette </span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="solutionAnswerpalatte">
                            <div class="navbar-nav nav-menu float-none ">
                                <div class="card border-0 mb-4 bg-white shadow-xss rounded-lg">
                                    <div class="card-body p-5">
                                        <div class="row">
                                            <h2 class="font-xss text-uppercase text-current fw-700 ls-3 custom-question-li">Answer Palette</h2>
                                            <div class="col-12 pt-2 pl-0 pb-4 pr-2">
                                                <div class="card w-100 border-0 mt-1">
                                                    <div class="row m-0">
                                                        @foreach( $totalTestQuestions as $key => $testQuestion )
                                                            <a href="{{ url('user/tests/'. $test->id .'/test_result/' .$testresultId.'/solution?tab=all-questions'. '&question='.($key +1)) }}">
                                                                @if( in_array( $testQuestion->question_id, $studentCorrectAnswers ))
                                                                    <span class="circle mb-2  text-white bg-primary " > {{ $key +1 }} </span>
                                                                @elseif( in_array( $testQuestion->question_id, $studentWrongAnswers ))
                                                                    <span class="circle mb-2 bg-purple text-white "> {{ $key +1 }} </span>
                                                                @else
                                                                    <span class="circle mb-2 "> {{ $key + 1 }} </span>
                                                                @endif
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                    <div class="row m-0">
                                                        @foreach( $favouriteQuestions as $key => $favouriteQuestion )
                                                            <a href="{{ url('user/tests/'. $test->id .'/test_result/' .$testresultId.'/solution?tab=all-questions'. '&question='.($key +1)) }}">
                                                                <span class="circle mb-2  text-white bg-warning " > {{ $key +1 }} </span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 pl-0">
                                                <div class="border-0" >
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <span class="dot d-inline-block bg-primary  custom-question-answered" ></span>
                                                        </div>
                                                        <div class="col-10">
                                                            <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Correct</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <span class="dot bg-purple d-inline-block custom-question-answered" ></span>
                                                        </div>
                                                        <div class="col-10">
                                                            <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Wrong</span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-2">
                                                            <span class="dot d-inline-block  custom-question-answered" ></span>
                                                        </div>
                                                        <div class="col-10">
                                                            <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Unattempted </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <span class="dot d-inline-block bg-warning custom-question-answered" ></span>
                                                        </div>
                                                        <div class="col-10">
                                                            <span class="d-inline-block font-xsss fw-600 text-grey-500 custom-question-answered">Favourite</span>
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
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {

            $("#solution").on("contextmenu",function(e){

                return false;
            });

            $('#solution').bind('cut copy paste', function (e) {
                e.preventDefault();
            });

            $("#submit-doubt").click(function (e) {
                e.preventDefault();

                let doubt = $('#doubt').val();
                if(!doubt){
                    swal("Please type your question!");
                }
              let doubtlength =  $('#doubt').val().length;
                if(doubtlength >= 1000) {
                    swal("Please type your doubt in 1000 charecters!");
                }

                let confirmation = confirm('Are you sure to submit?')
                if(confirmation && doubtlength <= 1000){
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('user.doubts.store') }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'testId': '{{ $test->id }}',
                            'questionId': '{{ $questionID }}',
                            'doubt': doubt
                        },
                        success: function(response){
                            if(response){
                                $('#doubt').val('');
                                swal("Success!","Our team will get back to you soon!", "success");
                            }
                        }
                    });
                }

            });

            $("#save-next").click(function (e) {
                e.preventDefault();

                let testId =  '{{ $test->id }}';
                let testResultId = '{{ $testresultId }}';

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.tests.save-next') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId,
                        'testResultId': testResultId,
                        'questionNumber' : '{{ request()->input('question') }}',
                        'tab' : '{{ $tab }}'
                    },
                    success: function(response){
                        if(response){
                            window.location.href =  response;
                        }
                    }
                });

            });

            $(".add-user-favourite-questions").click(function(e) {
                e.preventDefault();
                let questionId =  $(this).data('question-id');
                let testResultId = '{{ $testresultId }}';
                let testId =  '{{ $test->id }}';

                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.user-favourite-questions.store') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId,
                        'testResultId': testResultId,
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

            });
    </script>
@endpush



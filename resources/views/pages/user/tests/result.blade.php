@extends('layouts.app')

@section('title', 'Quiz')


@section('content')

    <div class="container pt-5 m-pt-0 pb-5">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-md-12">
                        <div class="card mb-4 d-block w-100 shadow-xss rounded-lg p-md-5 p-4 border-0 text-center">
                            <div class="col-md-12">
                                <h4 class="fw-700 font-xs mt-4">{{ $test->display_name }} </h4>
                            </div>
                            <div class=" d-none d-sm-block">
                                <p class="fw-500 font-xssss text-grey-500 mt-3">
                                    {{ $test->description }}
                                </p>
                                <div class="clearfix"></div>

                                <span class="font-xsssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">
                                {{ $test->test_questions->count()  }} Questions
                            </span>

                                <span class="font-xsssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">
                                {{ $test->total_marks }} Marks
                            </span>

                                <span class="font-xsssss fw-700 mb-2 pl-2 pr-2 lh-32 text-uppercase rounded-lg ls-2 bg-lightblue d-inline-block text-grey-800 mr-1">
                                Objective-type (MCQs)
                            </span>

                                <span class="font-xsssss fw-700 mb-2 pl-2 pr-2 lh-32 text-uppercase rounded-lg ls-2 alert-info d-inline-block text-info">
                                <span><i class="fa fa-clock-o pr-1"></i></span>{{ $test->total_time }}
                            </span>

                                <div class="clearfix"></div>

                            </div>

                        </div>
                    </div>
{{--                    fsgd--}}
                    <div class="col-xxl-8 col-xl-8 col-md-12 col-sm-12">
                        <div class="card-body text-center p-3 bg-no-repeat bg-image-topcenter" id="result" >
                            <div class="row mt-2">
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-dark-blue fw-700 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/target.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-1 mt-1"> Total Marks
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3 ">
                                        {{ $completedTestResult->total_marks }} / {{ $test->total_marks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-dark-blue fw-700 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/cutoff.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-1 mt-1"> Cut-off Marks
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $test->cut_off_marks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left">
                                    <h3 class="font-xss text-dark-blue fw-700 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/trophy.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-1 mt-1">
                                        Your Rank
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $userRank }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-dark-blue fw-700 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/percentage.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">
                                        Percentile
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $percentageMarks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h4 class="font-xss text-light-blue fw-600 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/question.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">
                                       Q. Attempted
                                    </h4>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $totalQuestionsAttempted}} / {{ $test->test_questions->count() }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-light-blue fw-600 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/correct_answer.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">
                                      Mark Per Q.
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3"> {{ $test->correct_answer_marks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-light-blue fw-600 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/correct_answer.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">
                                    Negative Mark Per Q.
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $test->negative_marks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-light-blue fw-600 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/wrong.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">
                                     Total Negative Mark
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
                                        {{ $totalNegativeMarks }}
                                    </h3>
                                </div>
                                <div class="col-8 text-left ">
                                    <h3 class="font-xss text-light-blue fw-600 mb-3 d-flex">
                                        <img src="{{ asset('images/icons/timer.png') }}" height="15px" alt="total marks" class="w15 ml-2 mr-2 mt-1">Time Taken
                                    </h3>
                                </div>
                                <div class="col-4 text-left">
                                    <h3 class="font-xss text-grey-800 fw-700 mb-3">
{{--                                        @if(round($completedTestResult->total_duration) >= $test->total_time)--}}
{{--                                            {{ $completedTestResult->total_duration }} Minutes--}}
{{--                                        @else--}}
                                            {{ $completedTestResult->total_duration }} Minutes
{{--                                        @endif--}}
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 offset-1 text-center">
                                    <div class="card border-0 mb-0  rounded-lg ">
                                        <div class="alert-sm " role="alert">
                                            @if($completedTestResult->total_marks < $test->cut_off_marks )
                                                <p  class="font-xss text-danger fw-700 mb-3">
                                                    Better Luck Next Time! You need to work harder for the next exams.
                                                </p>
                                            @else
                                                <p  class="font-xss text-success fw-700 mb-3">
                                                    Well Done! Keep it up.
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row " style="margin-bottom: 25px">
                    <div class="col-md-6 col-sm-12 mobile-text-center pb-5">
                        @if($completedTestResult->total_marks < $test->cut_off_marks )
                            <img width="40%" src="{{ asset('images/icons/dissatisfied.png') }}" alt="icon" class="d-inline-block ">
                        @else
                            <img width="40%" src="{{ asset('web/images/Congratulations.png') }}" alt="icon" class="d-inline-block">
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <canvas id="resultPieChart" ></canvas>
                    </div>
                </div>
                <div class="row">
                    @if(!$sections->count() <= 0)
                        <div style="width: 100%; overflow-x: scroll">
                            <h2 class="m-5 fw-600" >Section wise Analysis</h2>
                            <div style="width: 1024px" class="m-w-512 p-3" >
                                <canvas id="testSectionBarChart" ></canvas>
                            </div>
                        </div>
                    @endif
                </div>
                @if(!$test->is_live_now)
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ url('user/tests/'.$test->id.'/test_result/'. $testresultId.'/solution'.'?question=1')   }}">
                                <button type="button"  class="p-1 mt-3 d-inline-block  fw-700 lh-30 rounded-lg w200 font-xsss ls-3 border-purple">
                                   SOLUTION
                                </button>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="row">
                    @if($completedTestResult->package_id)
                        @if ( in_array( $completedTestResult->package_id, $activePackages) )
                        <div class="col-md-4 col-sm-12 text-center">
                            <a href="#" data-test-id="{{  $test->id }}" data-package-id="{{ $completedTestResult->package_id }}" class="test-detail-modal">
                                <button type="button"  class=" p-1 mt-3  fw-700 lh-30 rounded-lg border-green text-center w200 font-xssss ls-3 ">
                                    RE-TAKE TEST
                                </button>
                            </a>
                        </div>
                        @endif
                    @else
                        @if($completedTestResult->test->is_today_now)
                        <div class="col-md-4 col-sm-12 text-center">
                            <a href="#" data-test-id="{{ $test->id }}" data-package-id="{{ $completedTestResult->package_id }}" class="test-detail-modal">
                                <button type="button"  class=" p-1 mt-3 fw-700 lh-30 rounded-lg border-green text-center w200 font-xssss ls-3">
                                    RE-TAKE TEST
                                </button>
                            </a>
                        </div>
                        @endif
                    @endif

                    <div class=" @if(!$completedTestResult->test->is_today_now && in_array(! $completedTestResult->package_id, $activePackages))
                                    col-md-6 col-sm-12 text-center button-align-right @else col-md-4 col-sm-12 text-center @endif">
                        <a href="{{ url('user/tests') }}">
                            <button type="button"  class=" p-1 mt-3 fw-700 border-yellow lh-30 rounded-lg w200 font-xssss ls-3 text-center">
                                GO TO DASHBOARD
                            </button>
                        </a>
                    </div>
                    <div class="@if(!$completedTestResult->test->is_today_now && in_array(! $completedTestResult->package_id, $activePackages))
                                    col-md-6 col-sm-12 text-center button-align-left @else col-md-4 col-sm-12 text-center @endif">
                        <a href="{{ url('user/tests/'.$test->id.'/test_result/'. $testresultId.'/attempts'.'?package='. $completedTestResult->package_id) }}">
                            <button type="button"  class=" p-1 mt-3  fw-700 border-blue lh-30 rounded-lg w200 font-xssss text-center ls-3">
                                GO TO ATTEMPTS
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    <script>
        $(function () {

            $('.test-detail-modal').click(function (e) {
                e.preventDefault();
                let testId = $(this).data('test-id');
                let packageId = $(this).data('package-id');

                $(" #user-testId").val( testId );
                $(" #user-packageId").val( packageId );

                let url = '{{ url ('user/test/details/') }}' + '/' +testId;
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'testId': testId
                    },
                    success: function(response){

                        $("#test-name").text(response.name);
                        $("#test-display-name").text(response.display_name);
                        $("#test-total-questions").text(response.total_questions + ' Questions');
                        $("#test-total-time").text(response.total_time);
                        $("#test-correct-answer-mark").text( 'Correct Answer Mark : ' + response.correct_answer_marks);
                        $("#test-negative-mark").text('Negative Mark : ' +  response.negative_marks);
                        $("#test-cut-off-mark").text('Cutt Off Mark : ' + response.cut_off_marks );
                        $("#test-total-mark").text( 'Marks : ' + response.total_marks);
                        $("#test-description").text(response.description);
                        $('#testModal').modal('toggle');
                    }
                });

            });
            $( document ).ready(function() {
                var ctx = document.getElementById('resultPieChart').getContext('2d');

                let correct = '{{ $totalCorrectAnswers }}';
                let wrong = '{{ $totalWrongAnswers }}';
                let unattempted = '{{ $totalUnattempted }}';

                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'pie',

                    // The data for our dataset
                    data: {
                        labels: ['Correct','Wrong','Unattempted'],
                        datasets: [{
                            label: 'Result data set',
                            backgroundColor: ['rgb(187,208,155)','rgb(252,134,91)','rgb(210,206,206)'],
                            borderColor:  ['rgb(189,211,154)','rgb(250,129,85)','rgb(210,206,206)'],
                            data: [correct, wrong, unattempted]
                        }]
                    },

                    // Configuration options go here
                    options: {

                        legend: {
                            position: "right",
                            align: "middle"
                        },
                        labels: {
                            padding: 20,
                            render: 'percentage',
                            precision: 2
                        }
                    }
                });

            });

            @if(!$sections->count() <= 0)

            let sections = @json($sections);
            let section_wise_correct_answers = @json($section_wise_correct_answers);
            let section_wise_wrong_answers = @json($section_wise_wrong_answers);
            let section_wise_unattempted_questions = @json($section_wise_unattempted_questions);
            let maxMark = '{{ $maxMark }}';


            var graphicalsectionResult = document.getElementById("testSectionBarChart").getContext('2d');
            var chart = new Chart(graphicalsectionResult, {
                type: 'bar',
                data: {
                    labels: sections,
                    datasets: [
                        {
                            label: 'Correct',
                            data: section_wise_correct_answers,
                            backgroundColor: '#bfd59c'
                        },
                        {
                            label: 'Wrong',
                            data: section_wise_wrong_answers,
                            backgroundColor: '#ee6f43'
                        },
                        {
                            label: 'Unattempted',
                            data: section_wise_unattempted_questions,
                            backgroundColor: '#d3d0d0'
                        },
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'right' // place legend on the right side of chart
                    },
                    scales: {
                        xAxes: [{
                            stacked: true,
                            barPercentage: 0.4,
                            ticks: {
                                callback: function(labels) {
                                    if (/\s/.test(labels)) {
                                        return labels.split(" ");
                                    }else{
                                        return labels;
                                    }
                                }
                            }
                        }],
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                suggestedMin : 0,
                                stepSize : 5,
                                suggestedMax : maxMark,
                            },
                            datalabels: {
                                display: false
                            }
                            // this also..
                        }]
                    }
                }
            });

            @endif

        });
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Result Graph')

@section('content')
    <div class="container pb-5">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">
                <div class="row">
                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Test wise Analysis</h2>
                        <div class="row m-5">
                            <form class="form-inline mb-0" id="form-filter" action="{{ route('user.test.graphical_analysis') }}" method="GET">
                                <div class="form-group mr-2">
                                    <input type="text" id="created_at" value="{{old('created_at', request()->input('created_at'))}}" name="created_at" class="created_at form-control"
                                           autocomplete="off">
{{--                                    <input id="date-range" name="date_range" type="date" value="{{old('date_range', request()->input('date_range'))}}"  class="form-control @error('date_range') is-invalid @enderror"--}}
{{--                                           value="{{ old('date_range') }}" autocomplete="off">--}}
                                </div>

                                <div class="form-group mr-2 ">
                                    <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                                </div>
                                <div class="form-group">
                                    <a href="{{ url('user/tests/graphical/result_analysis') }}">
                                        <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Cancel</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div style="width: 1000px">
                            <canvas id="testResultBarChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12">
                        <h2 class="m-5 fw-600 mobile-h3-font" >All Test Answers Analysis</h2>
                        <div class="row ml-5">
                            <h5 class="float-right"> Total Questions : {{$testQuestionCount}}</h5>
                        </div>
                        <div class="row ml-5">
                            <h5 class="float-right"> Total Test : {{$completedTestResults->count()}}</h5>
                        </div>
                {{--sdaedew--}}
                        <div class="row text-center ">
                            <canvas id="allTestResultPieChart"></canvas>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-md-6 col-sm-12">
                        <h2 class="m-5 fw-600 mobile-h3-font" >All Test Percentage Analysis</h2>
                        <div class="row ml-5">
                            <h5 class="float-right"> Total Questions : {{$testQuestionCount}}</h5>
                        </div>
                        <div class="row ml-5">
                            <h5 class="float-right"> Total Test : {{$completedTestResults->count()}}</h5>
                        </div>

                        <div class="row text-center ">
                            <canvas id="allTestResultPercentagePieChart"></canvas>
                        </div>
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

            $('input[name="created_at"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
            });

            let testPackages = @json($testPackages);
            let correct_answers = @json($correct_answers);
            let wrong_answers = @json($wrong_answers);
            let unattempted_questions = @json($unattempted_questions);
            let maxMark = @json($maxMark);

            var graphicalResult = document.getElementById("testResultBarChart").getContext('2d');
            var chart = new Chart(graphicalResult, {
                type: 'bar',
                data: {
                    labels: testPackages,

                    datasets: [
                        {
                            label: 'Correct',
                            data: correct_answers,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: wrong_answers,
                            backgroundColor: '#ee6f43'
                        },
                        {
                            label: 'Unattempted',
                            data:unattempted_questions,
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
                        }]
                    }
                }
            });



            $( document ).ready(function() {
                var ctx = document.getElementById('allTestResultPieChart').getContext('2d');

                let correct = '{{ $totalCorrectAnswers }}';
                let wrong = '{{ $totalWrongAnswers }}';
                let unattempted = '{{ $totalUnattemptedQuestions }}';

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

            $( document ).ready(function() {
                var ctx = document.getElementById('allTestResultPercentagePieChart').getContext('2d');

                let correctAnswersPercentage = '{{ $totalCorrectAnswersPercentage }}';
                let wrongAnswersPercentage = '{{ $totalWrongAnswersPercentage }}';
                let unattemptedQuestionsPercentage  = '{{ $totalUnattemptedQuestionsPercentage}}';

                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'pie',

                    // The data for our dataset
                    data: {
                        labels: ['Correct %','Wrong %','Unattempted %'],
                        datasets: [{
                            label: 'Result data set',
                            backgroundColor: ['rgb(187,208,155)','rgb(252,134,91)','rgb(210,206,206)'],
                            borderColor:  ['rgb(189,211,154)','rgb(250,129,85)','rgb(210,206,206)'],
                            data: [correctAnswersPercentage, wrongAnswersPercentage, unattemptedQuestionsPercentage]
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

            });
    </script>
@endpush

@extends('layouts.app')

@section('title', 'Quiz')

@section('content')
    <style>
        div.chartWrapper {
            position: relative;
            overflow: auto;
            width: 100%;
        }

        div.chartContainer {
            position: relative;
            height: 300px;
        }
    </style>
    <div class="container pt-lg--7 pb-lg--7 pt-5 m-pt-0 pb-5">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">

                <div class="row">
{{--                    <div class="col-xxl-12 col-xl-12 col-md-12">--}}
{{--                        <h2 class="m-5 fw-600" >Test wise Analysis</h2>--}}
{{--                        <div class="col-12 text-center">--}}
{{--                            <canvas id="testBarChart"></canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    @if(!$sections->count() <= 0)
                        <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Section wise Analysis</h2>
                            <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSectionBarChart"></canvas>
                        </div>
                    </div>
                        <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Section wise Analysis</h2>
                        <h3 class="float-right"> Total Mark Scored : {{$testResult->total_marks}}</h3>
                            <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSectionMarkBarChart"></canvas>
                        </div>
                    </div>

                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Section wise Analysis</h2>
                        <h3 class="float-right"> Total Percentage Scored : {{ round($testResult->mark_percentage)}}</h3>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSectionMarkPercentageBarChart"></canvas>
                        </div>
                    </div>
                    @endif

                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Subject wise Analysis</h2>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSubjectBarChart" ></canvas>
                        </div>
                    </div>

                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Subject wise Analysis</h2>
                        <h3 class="float-right"> Total Mark Scored : {{$testResult->total_marks}}</h3>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSubjectMarkBarChart"></canvas>
                        </div>
                    </div>
                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Subject wise Analysis</h2>
                        <h3 class="float-right"> Total Percentage Scored : {{ round($testResult->mark_percentage)}}</h3>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testSubjectPercentageBarChart"></canvas>
                        </div>
                    </div>
                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Chapter wise Analysis</h2>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testChapterBarChart"></canvas>
                        </div>
                    </div>
                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Chapter wise Analysis</h2>
                        <h3 class="float-right"> Total Mark Scored : {{$testResult->total_marks}}</h3>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testChapterMarkBarChart"></canvas>
                        </div>
                    </div>
                    <div style="width:100%; overflow-x: scroll;">
                        <h2 class="m-5 fw-600" >Chapter wise Analysis</h2>
                        <h3 class="float-right"> Total Percentage Scored : {{ round($testResult->mark_percentage)}}</h3>
                        <div style="width: 1000px" class="m-w-512">
                            <canvas id="testChapterPercentageBarChart"></canvas>
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

            @if(!$sections->count() <= 0)

            let sections = @json($sections);
            let section_wise_correct_answers = @json($section_wise_correct_answers);
            let section_wise_wrong_answers = @json($section_wise_wrong_answers);
            let section_wise_unattempted_questions = @json($section_wise_unattempted_questions);


            var graphicalsectionResult = document.getElementById("testSectionBarChart").getContext('2d');
            var chart = new Chart(graphicalsectionResult, {
                type: 'bar',
                data: {
                    labels: sections,
                    datasets: [
                        {
                            label: 'Correct',
                            data: section_wise_correct_answers,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: section_wise_wrong_answers,
                            backgroundColor: '#f1794f'
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
                                stepSize : 5

                            },// this also..
                        }]
                    }
                }
            });



            let section_wise_positive_marks = @json($section_wise_positive_marks);
            let section_wise_negative_marks = @json($section_wise_negative_marks);
            let section_wise_total_marks = @json($section_wise_total_marks);

            var graphicalsectionMarkResult = document.getElementById("testSectionMarkBarChart").getContext('2d');
            var chart = new Chart(graphicalsectionMarkResult, {
                type: 'bar',
                data: {
                    labels: sections,
                    datasets: [
                        {
                            label: 'Positive Mark',
                            data: section_wise_positive_marks,
                            backgroundColor: '#a8c084'

                        },
                        {
                            label: 'Negative Mark',
                            data: section_wise_negative_marks,
                            backgroundColor: '#f1794f'

                        },
                        {
                            label: 'Total Mark',
                            data: section_wise_total_marks,
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
                                stepSize : 5
                            },// this also..
                        }]
                    }
                }
            });

            let section_wise_correct_answer_percentages = @json($section_wise_correct_answer_percentages);
            let section_wise_wrong_answer_percentages = @json($section_wise_wrong_answer_percentages);
            let section_wise_unattempted_question_percentages = @json($section_wise_unattempted_question_percentages);

            var graphicalsectionMarkPercentage = document.getElementById("testSectionMarkPercentageBarChart").getContext('2d');
            var chart = new Chart(graphicalsectionMarkPercentage, {
                type: 'bar',
                data: {
                    labels: sections,
                    datasets: [
                        {
                            label: 'Correct',
                            data: section_wise_correct_answer_percentages,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: section_wise_wrong_answer_percentages,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Unattempted',
                            data: section_wise_unattempted_question_percentages,
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
                                stepSize : 10,
                                suggestedMax : 101,
                            },// this also..
                        }]
                    }
                }
            });

            @endif

            let subjects = @json($subjects);
            let subject_wise_correct_answers = @json($subject_wise_correct_answers);
            let subject_wise_wrong_answers = @json($subject_wise_wrong_answers);
            let subject_wise_unattempted_questions = @json($subject_wise_unattempted_questions);


            var graphicalSubjectResult = document.getElementById("testSubjectBarChart").getContext('2d');
            var chart = new Chart(graphicalSubjectResult, {
                type: 'bar',
                data: {
                    labels: subjects,
                    datasets: [
                        {
                            label: 'Correct',
                            data: subject_wise_correct_answers,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: subject_wise_wrong_answers,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Unattempted',
                            data: subject_wise_unattempted_questions,
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
                                stepSize : 5
                            },// this also..
                        }]
                    }
                }
            });


            let subject_wise_positive_marks = @json($subject_wise_positive_marks);
            let subject_wise_negative_marks = @json($subject_wise_negative_marks);
            let subject_wise_total_marks = @json($subject_wise_total_marks);

            var graphicalSubjectMarkResult = document.getElementById("testSubjectMarkBarChart").getContext('2d');
            var chart = new Chart(graphicalSubjectMarkResult, {
                type: 'bar',
                data: {
                    labels: subjects,
                    datasets: [
                        {
                            label: 'Positive Mark',
                            data: subject_wise_positive_marks,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Negative Mark',
                            data: subject_wise_negative_marks,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Total Mark',
                            data: subject_wise_total_marks,
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
                                stepSize : 5
                            },// this also..
                        }]
                    }
                }
            });

            let subject_wise_correct_answer_percentages = @json($subject_wise_correct_answer_percentages);
            let subject_wise_wrong_answer_percentages = @json($subject_wise_wrong_answer_percentages);
            let subject_wise_unattempted_question_percentages = @json($subject_wise_unattempted_question_percentages);

            var graphicalSubjectPercentageResult = document.getElementById("testSubjectPercentageBarChart").getContext('2d');
            var chart = new Chart(graphicalSubjectPercentageResult, {
                type: 'bar',
                data: {
                    labels: subjects,
                    datasets: [
                        {
                            label: 'Correct',
                            data: subject_wise_correct_answer_percentages,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: subject_wise_wrong_answer_percentages,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Unattempted',
                            data: subject_wise_unattempted_question_percentages,
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
                                stepSize : 10,
                                suggestedMax : 101,
                            },// this also..
                        }]
                    }
                }
            });

            let chapters = @json($chapters);
            let chapter_wise_correct_answers = @json($chapter_wise_correct_answers);
            let chapter_wise_wrong_answers = @json($chapter_wise_wrong_answers);
            let chapter_wise_unattempted_questions = @json($chapter_wise_unattempted_questions);

            var graphicalchapterResult = document.getElementById("testChapterBarChart").getContext('2d');
            var chart = new Chart(graphicalchapterResult, {
                type: 'bar',
                data: {
                    labels: chapters,
                    datasets: [
                        {
                            label: 'Correct',
                            data: chapter_wise_correct_answers,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: chapter_wise_wrong_answers,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Unattempted',
                            data: chapter_wise_unattempted_questions,
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
                                stepSize : 5
                            },
                            // this also..
                        }]
                    }
                }
            });

            let chapter_wise_positive_marks = @json($chapter_wise_positive_marks);
            let chapter_wise_negative_marks = @json($chapter_wise_negative_marks);
            let chapter_wise_total_marks = @json($chapter_wise_total_marks);

            var graphicalChapterMarkResult = document.getElementById("testChapterMarkBarChart").getContext('2d');
            var chart = new Chart(graphicalChapterMarkResult, {
                type: 'bar',
                data: {
                    labels: chapters,
                    datasets: [
                        {
                            label: 'Positive Mark',
                            data: chapter_wise_positive_marks,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Negative Mark',
                            data: chapter_wise_negative_marks,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Total Mark',
                            data: chapter_wise_total_marks,
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
                                suggestedMin : 0
                            },
                            // this also..
                        }]
                    }
                }
            });

            let chapter_wise_correct_answer_percentages = @json($chapter_wise_correct_answer_percentages);
            let chapter_wise_wrong_answer_percentages = @json($chapter_wise_wrong_answer_percentages);
            let chapter_wise_unattempted_question_percentages = @json($chapter_wise_unattempted_question_percentages);

            var graphicalChapterPercentageResult = document.getElementById("testChapterPercentageBarChart").getContext('2d');
            var chart = new Chart(graphicalChapterPercentageResult, {
                type: 'bar',
                data: {
                    labels: chapters,
                    datasets: [
                        {
                            label: 'Correct',
                            data: chapter_wise_correct_answer_percentages,
                            backgroundColor: '#a8c084'
                        },
                        {
                            label: 'Wrong',
                            data: chapter_wise_wrong_answer_percentages,
                            backgroundColor: '#f1794f'
                        },
                        {
                            label: 'Unattempted',
                            data: chapter_wise_unattempted_question_percentages,
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
                            // this should be set to make the bars stacked
                        }],
                        yAxes: [{
                            stacked: true,
                            ticks: {
                                suggestedMin : 0,
                                stepSize : 10,
                                suggestedMax : 101,
                            },// this also..
                        }]
                    }
                }
            });

        });
    </script>
@endpush

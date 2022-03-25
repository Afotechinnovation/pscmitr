@extends('admin::layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h1 class="page-title">Dashboard</h1>

@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row m-3">
                <h3 class="text-black text-center">Analytics</h3>
            </div>
            <div class="row m-3">
                <h4 class="text-black text-center">User wise</h4>
            </div>
                <div class="row m-3">
                    <form class="form-inline mb-0" id="form-filter" action="{{ route('admin.dashboard.graphical_view') }}" method="GET">
                        <div class="form-group ">
                            <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                <input type="checkbox" class="m-2 checkbox" name="courses" value="course" id="checkbox_course">
                                Course
                            </label>
                            <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                <input type="checkbox" class="m-2 checkbox" name="test" value="test" id="checkbox_test">
                                Test
                            </label>
                        </div>

                       <div class="form-group">
                             <input id="date-range" name="date_range" type="text" value="{{old('date_range', request()->input('date_range'))}}"  class="form-control @error('date_range') is-invalid @enderror"
                                    value="{{ old('date_range') }}" autocomplete="off">
                             @error('date_range')
                             <span class="invalid-feedback" role="alert" style="display: inline;">
                                 {{ $errors->first('date_range') }}
                             </span>
                             @enderror
                         </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('admin.dashboard.graphical_view') }}">
                                <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Cancel</button>
                            </a>
                        </div>
                    </form>
                </div>
            <div id="user-bar-chart">
                <div class="row m-3">
                    <h4 class="text-black text-center">Course</h4>
                </div>
                <div class="row m-2" >
                    <div class="col-xl-10 col-md-10 info-panel p-2">
                        <canvas id="UserBarChart"></canvas>
                    </div>
                </div>
            </div>
            <div id="test-bar-chart">
                <div class="row m-3">
                    <h4 class="text-black text-center">Test</h4>
                </div>
                <div class="row m-3" >
                    <div class="col-xl-10 col-md-10 info-panel p-2">
                        <canvas id="TestBarChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <h3 class="text-black text-center">Doubts Cleared</h3>
            </div>
            <div class="row m-3">
                <div class="form-group ">
                    <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                        <input type="checkbox" class="m-2 checkbox" name="subject_doubts" value="course" id="checkbox_subject_doubts">
                        Subject
                    </label>
                    <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                        <input type="checkbox" class="m-2 checkbox" name="course_doubts" value="test" id="checkbox_course_doubts">
                        Course
                    </label>
                </div>
            </div>
            <div id="doubt-cleared-bar-chart">
                <div class="row m-3">
                    <h4 class="text-black text-center">Subjects</h4>
                </div>
                <div class="row m-2" >
                    <div class="col-xl-6 col-md-6 info-panel p-2">
                        <canvas id="DoubtSubjectChart"></canvas>
                    </div>
                </div>
            </div>
            <div id="doubt-cleared-course-bar-chart">
                <div class="row m-3">
                    <h4 class="text-black text-center">Courses</h4>
                </div>
                <div class="row m-2" >
                    <div class="col-xl-6 col-md-6 info-panel p-2">
                        <canvas id="DoubtCourseChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script src="/web/js/countdown.js"></script>
    <script src="/web/js/jquery-validation/jquery.validate.min.js"></script>
    <script src="/web/js/jquery-validation/additional-methods.min.js"></script>

    <script>

        $('.checkbox').click(function(){
            $('.checkbox').each(function(){
                $(this).prop('checked', false);
            });
            $(this).prop('checked', true);
        })

        $( document ).ready(function() {

            $('#date-range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $("#test").select2({
                placeholder: 'Choose Test'
            });

            $("#checkbox_course").click(function(){
                if($(this).is(":checked")){
                    $("#user-bar-chart").show();
                    $("#test-bar-chart").hide();
                }else if($(this).is(":not(:checked)")){
                    $("#user-bar-chart").show();
                    $("#test-bar-chart").show();
                }
            });
            $("#checkbox_test").click(function(){
                if($(this).is(":checked")){
                    $("#user-bar-chart").hide();
                    $("#test-bar-chart").show();
                }else if($(this).is(":not(:checked)")){
                    $("#user-bar-chart").show();
                    $("#test-bar-chart").show();
                }
            });
            $("#checkbox_subject_doubts").click(function(){
                if($(this).is(":checked")){
                    $("#doubt-cleared-bar-chart").show();
                    $("#doubt-cleared-course-bar-chart").hide();
                }else if($(this).is(":not(:checked)")){
                    $("#doubt-cleared-course-bar-chart").show();
                    $("#doubt-cleared-bar-chart").show();
                }
            });
            $("#checkbox_course_doubts").click(function(){
                if($(this).is(":checked")){
                    $("#doubt-cleared-bar-chart").hide();
                    $("#doubt-cleared-course-bar-chart").show();
                }else if($(this).is(":not(:checked)")){
                    $("#doubt-cleared-course-bar-chart").show();
                    $("#doubt-cleared-bar-chart").show();
                }
            });

            let courses = @json($courses);
            let users = @json($usersCount);
            let userCount = @json($max_userCount);

            var userChart = document.getElementById('UserBarChart').getContext('2d');
            var userBarChart = new Chart(userChart, {

                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: courses,
                    datasets: [
                        {
                            label: 'Users',
                            backgroundColor: '#0074d9',
                            borderColor: '#0074d9',
                            width:10,
                            data: users,
                        },

                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.2
                        }],
                        yAxes: [
                            {
                                display: true,
                                position: 'left',
                                ticks: {
                                    suggestedMin : 0,
                                    stepSize : 5,
                                    suggestedMax : userCount,
                                }
                            },
                        ]
                    },
                    legend: {
                        position: 'bottom',
                        display: true
                    },
                }
            });

            let tests = @json($tests);
            let testUserCount = @json($testUserCount);
            let max_testCount = @json($max_testCount);


            var testChart = document.getElementById('TestBarChart').getContext('2d');
            var testBarChart = new Chart(testChart, {

                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: tests,
                    datasets: [
                        {
                            label: 'Users',
                            backgroundColor: '#0074d9',
                            borderColor: '#0074d9',
                            width:10,
                            data: testUserCount,
                        },

                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.2
                        }],
                        yAxes: [
                            {
                                display: true,
                                position: 'left',
                                ticks: {
                                    suggestedMin : 0,
                                    stepSize : 5,
                                    suggestedMax : max_testCount,
                                }
                            },

                        ]
                    },
                    legend: {
                        position: 'bottom',
                        display: true
                    },
                }
            });


            let subjects = @json($subjects );
            let userSubjectDoubtCount = @json($userSubjectDoubtCount);
            let maxSubjectDountCount = @json($maxSubjectDoubtCount);

           var ctx = document.getElementById('DoubtSubjectChart').getContext('2d');
            var UserDoubtChart = new Chart(ctx, {

                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: subjects,
                    datasets: [
                        {
                            label: 'Doubts Cleared',
                            backgroundColor: '#0074d9',
                            borderColor: '#0074d9',
                            width:10,
                            data: userSubjectDoubtCount,
                        },

                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.2
                        }],
                        yAxes: [
                            {
                                display: true,
                                position: 'left',
                                ticks: {
                                    suggestedMin : 0,
                                    stepSize : 5,
                                    suggestedMax : maxSubjectDountCount,
                                }
                            },
                        ]
                    },
                    legend: {
                        position: 'bottom',
                        display: true
                    },
                }
            });

            let doubtCourses = @json($user_courses);
            let usercourseDoubts = @json($userCourseDoubtCount);
            let max_doubtCourseCount = @json($maxCourseDoubtCount);

            var DoubtCourseChart = document.getElementById('DoubtCourseChart').getContext('2d');
            var UserDoubtChart = new Chart(DoubtCourseChart, {

                // The type of chart we want to create
                type: 'bar',
                // The data for our dataset
                data: {
                    labels: doubtCourses,
                    datasets: [
                        {
                            label: 'Doubts Cleared',
                            backgroundColor: '#0074d9',
                            borderColor: '#0074d9',
                            width:10,
                            data: usercourseDoubts,
                        },

                    ]
                },

                // Configuration options go here
                options: {
                    scales: {
                        xAxes: [{
                            barPercentage: 0.2
                        }],
                        yAxes: [
                            {
                                display: true,
                                position: 'left',
                                ticks: {
                                    suggestedMin : 0,
                                    stepSize : 5,
                                    suggestedMax : max_doubtCourseCount,
                                }
                            },
                        ]
                    },
                    legend: {
                        position: 'bottom',
                        display: true
                    },
                }
            });

        });
    </script>
@endpush



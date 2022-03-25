@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden p-4">
                        <div class="card-body mb-3 pb-0">
                            <h2 class="fw-400 font-lg d-block mb-5"> <b>Dashboard</b></h2>

                            <div class="row">
                                <div class="col-xl-3 col-lg-3 mt-3">
                                    <div class="card w-100 bg-current p-0 shadow-sm border-0 rounded-lg overflow-hidden mr-1 p-3">
                                        <div class="card-body pt-0  text-center">
                                            <h5 class="fw-700  lh-32 text-uppercase  text-white  rounded-lg ls-2">
                                                {{$purchasedPackgeCourses->count()}}
                                            </h5>
                                            <h5 class="fw-700  text-uppercase  text-white rounded-lg ls-2">
                                                Courses
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 mt-3">
                                    <div class="card w-100 bg-current p-0 shadow-sm border-0 rounded-lg overflow-hidden mr-1 p-3">
                                        <div class="card-body pt-0  text-center">
                                            <h5 class="fw-700  lh-32 text-uppercase  text-white  rounded-lg ls-2">
                                                {{$completedTestResults->count()}}
                                            </h5>
                                            <h5 class="fw-700  text-uppercase  text-white rounded-lg ls-2">
                                                Tests
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 mt-3">
                                    <div class="card w-100 bg-current p-0 shadow-sm border-0 rounded-lg overflow-hidden mr-1 p-3">
                                        <div class="card-body pt-0  text-center">
                                            <h5 class="fw-700  lh-32 text-uppercase  text-white  rounded-lg ls-2">
                                                {{ $testQuestionCount }}
                                            </h5>
                                            <h5 class="fw-700  text-uppercase  text-white rounded-lg ls-2">
                                                Questions
                                            </h5>
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


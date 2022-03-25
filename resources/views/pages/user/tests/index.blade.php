@extends('layouts.app')

@section('title', 'Tests')

@section('content')
<style>
    li {
        list-style: none;
    }
</style>
<div class="course-details pb-lg--7 pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card-body pb-0">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg bg-no-repeat">
                        <div class="card-body mb-3 pb-0">
                            <h1 class="fw-400 font-lg d-block">My  <b>Tests</b></h1>
                        </div>
                        @if($testResultExist->count() > 0)
                            <div class="card-body w-100 p-4">
                                <div class="side-wrap rounded-lg">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form  name="filter-test-courses-form" id="filter-test-courses-form" action="{{route('user.tests.index') }}" method="GET">
                                                <div class="form-group icon-input mb-3">
                                                    <input type="text" name="search" value="{{ request()->input('search') ? request()->input('search') : '' }}" class="form-control style1-input pl-5 border-size-md border-light font-xsss" placeholder="To search type and hit enter">
                                                    <i class="ti-search text-grey-500 font-xs"></i>
                                                </div>
                                                <ul class="nav nav-pills pills-dark" id="pills-tab" role="tablist">
                                                    @foreach ($courses as $course)
                                                        <li class="nav-item p-2">
                                                            <a class="nav-link  {{ $tab == $course->name ? 'active' : '' }}  rounded-xl" id="pills-courses-tab"
                                                               href="{{ url('user/tests'.'?tab='.$course->name.'&page=1') }}"
                                                               role="tab" aria-controls="pills-test-courses" aria-selected="true" >{{$course->name}}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <input type="hidden" name="tab" value="{{ $tab }}">
                                                <div class="tab-content ml-3 mb-0 form-group" id="pills-tabContent">
                                                    <div class="tab-pane show active " id="pills-types" role="tabpanel" aria-labelledby="pills-types-tab">
                                                        <ul class="list-group active list-group-horizontal-lg border-bottom-0 mt-2">
                                                            <li>
                                                                <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input type="checkbox" class="m-2 checkbox" name="type" value="all" {{ request()->input('type') == 'all' ?'checked':'' }}>All
                                                                </label>
                                                                <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input type="checkbox" class="m-2 checkbox" name="type" value="ongoing" {{ request()->input('type') == 'ongoing' ?'checked':'' }}>Ongoing
                                                                </label>
                                                                <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input type="checkbox" class="m-2 checkbox" name="type" value="completed" {{ request()->input('type') == 'completed' ?'checked':'' }}>Completed
                                                                </label>
                                                                <label class="fw-500 lh-24 font-xsss text-grey-500 ">
                                                                    <input type="checkbox" class="m-2 checkbox" name="type" value="favourite" {{ request()->input('type') == 'favourite' ?'checked':'' }}>Favorites
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit"  class="p-2 mt-3 border-0 d-inline-block text-white fw-700 lh-30  rounded-lg w90 font-xsssss ls-3 bg-info">SEARCH</button>
                                                    <a href="{{ route('user.tests.index') }}" > <button type="button"  class="p-2 mt-3 border-0 d-inline-block
                                                        fw-700 lh-30 rounded-lg ml-3 w90 font-xsssss ls-3 bg-grey-800">CLEAR</button></a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if($completedTestResultCount >=1 )
                                <div class="col-12">
                                    <div class="form-group icon-input mt-3">
                                        <a href="{{ url('user/tests/graphical/result_analysis') }}">
                                            <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Graphical Analysis</button>
                                        </a>
                                    </div>
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered ">
                                        <thead>
                                            <tr>
                                                <th scope="col" >S.No</th>
                                                <th scope="col">Package</th>
                                                <th scope="col">Exam Title</th>
                                                <th scope="col">Marks</th>
                                                <th scope="col">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($testResults as $testResult)
                                                <tr>
                                                    <th scope="row">{{$loop->iteration }}</th>
                                                    <th scope="row" > {{ $testResult->package == '' ? 'Live Test' : \Illuminate\Support\Str::limit( $testResult->package->name, 19, $end=' ..') }} </th>
                                                    <td>{{\Illuminate\Support\Str::limit( $testResult->test->display_name, 20, $end=' ..') }}</td>
                                                    <td>{{ !$testResult->total_marks ? 0 : $testResult->total_marks }}</td>
                                                    <td>
                                                        <a href="{{ url('user/tests/'.$testResult->test_id.'/test_result/'. $testResult->id.'/result') }}">
                                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg
                                                             ls-2 alert-primary d-inline-block text-primary mr-1 mt-2"> Result</span>
                                                        </a>
                                                        <a href="{{ url('user/tests/'.$testResult->test_id.'/test_result/'. $testResult->id.'/attempts'.'?package='. $testResult->package_id) }}">
                                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg
                                                             ls-2 alert-success d-inline-block text-success mr-1 mt-2"> Attempts</span>
                                                        </a>
                                                        @if(!$testResult->test->is_live_now)
                                                            <a href="{{ url('user/tests/'.$testResult->test_id.'/test_result/'. $testResult->id.'/solution?question=1') }}">
                                                                <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg
                                                                 ls-2 alert-danger d-inline-block text-danger mr-1 mt-2"> Solution</span>
                                                            </a>
                                                        @endif

                                                        <a href="{{ url('user/tests/'.$testResult->test_id.'/test_result/'.$testResult->id.'/test-result-graphs') }}">
                                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg
                                                             ls-2 alert-warning d-inline-block text-warning mr-1 mt-2"> Graph</span>
                                                        </a>
                                                        @if($testResult->package_id)
                                                            @if ( in_array( $testResult->package_id, $activePackages) )
                                                                <a href="#" data-test-id="{{ $testResult->test_id }}" data-package-id="{{ $testResult->package_id }}"
                                                                   class="test-detail-modal">
                                                                 <span class="font-xsssss fw-700 pl-3 pr-3 p-2 text-uppercase  text-center rounded-lg w-20
                                                                 ls-2 alert-danger d-inline-block text-danger mr-1 mt-2">Re-Take Test</span>
                                                                </a>
                                                            @endif
                                                        @else
                                                            @if( $testResult->test->is_today_now)
                                                                <a href="#" data-test-id="{{ $testResult->test_id }}" data-package-id="{{ $testResult->package_id }}"
                                                                   class="test-detail-modal">
                                                                 <span class="font-xsssss fw-700 pl-3 pr-3 p-2 text-uppercase rounded-lg text-center w-20
                                                                 ls-2 alert-danger d-inline-block text-danger mr-1 mt-2">Re-Take Test</span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                           <div class="text-center pb-3"> No data Available.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script src="{{ asset('/vendor/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">

        $(function() {
            $("#test-type").select2({
                placeholder: 'Choose Type'
            });

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

            $('.checkbox').click(function(){
                $('.checkbox').each(function(){
                    $(this).prop('checked', false);
                });
                $(this).prop('checked', true);
            })
        });
    </script>
@endpush

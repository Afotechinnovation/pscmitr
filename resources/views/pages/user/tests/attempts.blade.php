@extends('layouts.app')

@section('title', 'Test')

@section('content')
    <div class="container pt-lg--7 pb-lg--7 pt-2 pb-5">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-md-12">
                        <div class="card mb-4 d-block w-100 shadow-xss rounded-lg p-md-5 p-4 border-0 text-center">
                            <div class="col-md-12">
                                <h4 class="fw-700 font-xs mt-4">{{ $test->name }} </h4>
                            </div>
                            <div class="d-none d-sm-block">
                                <p class="fw-500 font-xssss text-grey-500 mt-3 text-justify">{{ $test->description }}  </p>
                                <div class="clearfix"></div>
                                <span class="font-xsssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1"> {{ $test->test_questions->count() }} Questions</span>
                                <span class="font-xsssss fw-700 pl-3 mb-2 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-success d-inline-block text-success mr-1">{{ $test->total_marks }} Marks</span>
                                <span class="font-xsssss fw-700 mb-2 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-lightblue d-inline-block text-grey-800 mr-1">Objective-type (MCQs)</span>
                                <span class="font-xsssss fw-700 mb-2 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 alert-info d-inline-block text-info">{{ $test->total_time }} </span>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8 col-xl-8 col-md-12">
                        <div class="card-body text-center p-3 bg-no-repeat bg-image-topcenter" id="solution"  >
                            <h3 class="font-xss text-uppercase text-current fw-700 mb-3 ls-3">{{ $test->name }}</h3>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="fw-700 font-xsss text-dark-blue text-left">Total Questions : {{ $test->test_questions->count() }} </h4>
                                </div>
                                <div class="col-12">
                                    <h4 class="fw-700 font-xsss text-dark-blue text-left">Total Marks : {{ $test->total_marks }} </h4>
                                </div>
                                <div class="col-12">
                                    <h4 class="fw-700 font-xsss text-dark-blue text-left">Total Attempts : {{ $attepmts->count() }}</h4>
                                </div>

                                <div class="col-12 mt-5 table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Attempt</th>
                                            <th scope="col"> Date</th>
                                            <th scope="col">Marks Scored</th>
                                            <th scope="col">Your Rank</th>
                                            <th scope="col">Percentile</th>
                                            <th scope="col">Progress</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($attepmts as $attepmt)
                                            <tr>
                                                <td>{{$attepmt->attempts}}</a></td>
                                                <td>{{ \Carbon\Carbon::parse($attepmt->created_at)->toDateString()}}</a></td>
                                                <td>{{ $attepmt->total_mark }}</td>
                                                <td>{{ $attepmt->rank }}</td>
                                                <td>{{ round($attepmt->percentile, 2)  }} %</td>
                                                <td>
                                                    @if($attepmt->attempts == 1)
                                                        Nill
                                                    @else
                                                        <span class="text-success"> {{ round($attepmt->progress, 2) }} %</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            @if($attepmt->package_id)
                                @if ( in_array( $attepmt->package_id, $activePackages) )
                                <div class="col-md-4 col-sm-12 text-center @if($test->is_live_now) col-md-6 @endif">
                                    <a href="#" data-test-id="{{  $attepmt->test_id }}" data-package-id="{{ $attepmt->package_id  }}" class="test-detail-modal">
                                        <button type="button"  class=" p-1 mt-3  fw-700 lh-30 rounded-lg border-green text-center w200 font-xsssss ls-3 ">
                                            RE-TAKE TEST
                                        </button>
                                    </a>
                                </div>
                                @endif
                            @else
                                @if($attepmt->test->is_today_now )
                                <div class="col-md-4 col-sm-12 text-center @if($test->is_live_now) col-md-6 @endif">
                                    <a href="#" data-test-id="{{  $attepmt->test_id }}" data-package-id="{{ $attepmt->package_id  }}" class="test-detail-modal">
                                        <button type="button"  class=" p-1 mt-3  fw-700 lh-30 rounded-lg border-green text-center w200 font-xsssss ls-3 ">
                                            RE-TAKE TEST
                                        </button>
                                    </a>
                                </div>
                                @endif
                            @endif

                            <div class=" @if(! $test->is_today_now && in_array(! $attepmt->package_id, $activePackages ) && $test->is_live_now) col-md-12 text-center
                                    @elseif(! $test->is_today_now && in_array(! $attepmt->package_id, $activePackages )) col-md-6 col-sm-12 text-center button-align-right
                                    @else col-md-4 col-sm-12 text-center @endif" >
                                <a href="{{ url('user/tests') }}">
                                    <button type="button"  class=" p-1 mt-3  fw-700 border-yellow
                                        lh-30 rounded-lg  w200 font-xsssss ls-3 ">
                                        GO TO DASHBOARD
                                    </button>
                                </a>
                            </div>
                            @if(!$test->is_live_now)
                                <div class="col-md-4 col-sm-12 text-center ">
                                    <a href="{{ url('user/tests/'.$test->id.'/test_result/'.$testresultId.'/solution?question=1') }}">
                                        <button type="button"  class=" p-1 mt-3 border-blue fw-700
                                        lh-30 rounded-lg  w200 font-xsssss ls-3">
                                            SOLUTION
                                        </button>
                                    </a>
                                </div>
                            @endif
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
        });
    </script>
@endpush

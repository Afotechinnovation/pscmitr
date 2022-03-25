@extends('layouts.app')
@section('title', 'Today tests')
@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden p-4">
                        @if($todayTests->count() > 0)
                            <div class="row justify-content-center">
                                <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                                    <h2 class="text-grey-900 fw-700 display1-size display2-md-size pb-3 mb-0 d-block">Today's Test</h2>
                                </div>
                            </div>
                            <div class="row card-scroll">
                                @foreach( $todayTests as $todayTest )
                                    <div class="col-xs-12 col-sm-12 col-md-4  mb-3">
                                        <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                            <div class="card-image w-100 ">
                                                @if(\Illuminate\Support\Facades\Auth::user())
                                                     <a href="#"   data-test-id ="{{ $todayTest->id  }}"  data-package-id ="{{ $todayTest->package_id }}"
                                                       class="test-detail-modal position-relative d-block">
                                                        <img src="{{  $todayTest->image }}" alt="image" class="w-100">
                                                    </a>

                                                @else
                                                    <a data-toggle="modal" data-target="#Modallogin" class=" position-relative d-block">
                                                        <img src="{{  $todayTest->image }}" alt="image" class="w-100">
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="card-body p-2">
                                                <div class="row p-2">
                                                    <div class="col-md-6 col-sm-6 ">
                                                        <span class="font-xssss text-grey-500 fw-600"><i class="ti-time mr-2"></i>{{ $todayTest->total_time }} </span>
                                                    </div>

                                                </div>
                                                <div class="p-2 test-fixed-height" >
                                                    <h6 class="author-name font-xsss fw-600 mb-0 text-grey-800">
                                                        <span>{{ \Illuminate\Support\Str::limit( $todayTest->display_name, 20, $end=' ...') }}</span>
{{--                                                        <span class="float-right font-xssss text-black-50">{{ \Illuminate\Support\Str::limit( $liveTest->package->name, 20, $end=' ...') }}</span>--}}
                                                    </h6>
                                                </div>
                                                <div class="row pl-2">
                                                    <div class="col-6">
                                                 <span class="font-xssss text-grey-700 float-left fw-600 d-inline-block ">
                                                   {{ $todayTest->total_questions }}  Questions
                                                </span>
                                                    </div>
                                                    <div class="col-6">
                                                     <span class="font-xssss float-right  fw-600 d-inline-block ">
                                                       {{ $todayTest->total_marks }}  Marks
                                                    </span>
                                                    </div>
                                                </div>

                                                <div class="p-2 text-center">
                                                    @if( \Illuminate\Support\Facades\Auth::user() )
                                                        <a href="#" data-test-id ="{{ $todayTest->id  }}"  data-package-id ="{{ $todayTest->package_id }}"
                                                           class="test-detail-modal position-relative d-block">
                                                            <button class=" border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">START
                                                            </button>
                                                        </a>
                                                    @else
                                                        <button  data-toggle="modal" data-target="#Modallogin" data-redirect-page="todayTest"
                                                                 class=" start-quiz-button border-0 p-2 d-inline-block text-white fw-700 lh-27 rounded-lg w125 font-xsssss ls-3 bg-current">START
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <center> Today No Tests available</center>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">

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


        $(".start-quiz-button").click(function (e) {
            e.preventDefault();
            let redirect = $(this).data('redirect-page');
            $(".modal-body #redirect").val( redirect );

        });


    </script>
@endpush

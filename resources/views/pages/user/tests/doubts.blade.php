@extends('layouts.app')

@section('title', 'Doubts')

@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden p-4">
                                    <div class="card-body mb-3 pb-0">
                                        <h2 class="fw-400 font-lg d-block">Doubts Asked</h2>
                                    </div>
                                    <div class="card-body pb-0 table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Test</th>
                                                <th scope="col">Question</th>
                                                <th scope="col">Doubt</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Answer</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($studentDoubts->count() > 0)
                                                @foreach($studentDoubts as $key =>  $studentDoubt)
                                                    <tr>
                                                        <th scope="row"> {{ $key +1 }} </th>
                                                        <td>{{ $studentDoubt->test->name }}</td>
                                                        <td>{!! $studentDoubt->question->question !!} </td>
                                                        <td>{{ $studentDoubt->doubt }}</td>
                                                        <td>{{ $studentDoubt->status }}</td>
                                                        <td>
                                                        @if($studentDoubt->answer)
                                                             <a  data-toggle="modal"  data-target="#answerModal"> <i data-answer="{{ $studentDoubt->answer }}"  data-question="{{ $studentDoubt->question->question }}"
                                                                   class="fa fa-eye show-answer-modal"></i> </a>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="justify-content-center">
                                                    <td colspan="6" class="text-center">No data available </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    {{ $studentDoubts->links('vendor.pagination.custom') }}
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
        $(".show-answer-modal").click(function (e) {
            let question = $(this).data('question');
            let answer = $(this).data('answer');
            if(answer){
                $('#answerModal').modal('toggle');
                $("#doubt-question-div").empty().append(question);
                $("#doubt-answer-div").empty().append(answer);
            }
        });

    </script>
@endpush

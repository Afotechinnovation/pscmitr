@extends('admin::layouts.app')

@section('title', 'Package Test')

@section('header')
    <h1 class="page-title">Package Test</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.packages.show', $package_test->id)}}">Package Tests</a></li>
        </ol>
    </nav>
@endsection

@section('content')

<div class="card">
    <div class="card-body p-0">
        <div class="card-header bg-white border-bottom p-20">
            <h4 class="card-title m-0">Test Information</h4>
        </div>
        <dl class="">
            <div class="row no-gutters align-items-center p-15">
                <dd class="col-md-3 mb-sm-0">Total no. of Questions</dd>
                <dt class="col-md-9">{{ $package_test->total_questions }}</dt>
            </div>
            <div class="row no-gutters align-items-center bg-light p-15">
                <dd class="col-md-3 mb-sm-0">Total Marks</dd>
                <dt class="col-md-9">{{ $package_test->total_marks }}</dt>
            </div>
            <div class="row no-gutters align-items-center p-15">
                <dd class="col-md-3 mb-sm-0">Total Time</dd>
                <dt class="col-md-9">{{ $package_test->total_time }}</dt>
            </div>
            <div class="row no-gutters align-items-center bg-light p-15">
                <dd class="col-md-3 mb-sm-0">Correct Answer Marks</dd>
                <dt class="col-md-9">{{ $package_test->correct_answer_marks }}</dt>
            </div>
            <div class="row no-gutters align-items-center p-15">
                <dd class="col-md-3 mb-sm-0">Negative Marks</dd>
                <dt class="col-md-9">{{ $package_test->negative_marks }}</dt>
            </div>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-body bg-light p-0">

        <div class="card-header bg-white border-bottom p-20">
            <h4 class="card-title m-0">Questions</h4>
        </div>

        <div class="accordion" id="accordionExample">
            @foreach( $test_questions as $index => $test_question)
                <div class="card">
                    <div class="card-header bg-white" id="headingOne">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne"
                                aria-expanded="true" aria-controls="collapseOne">
                           {{ $index+1 }} . {{ $test_question->question->question }}
                        </button>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body bg-light">
                            <div class="row">
                                <div class="col-md-12">
{{--                                    @if( $test_question->question->type == 1 )--}}
{{--                                        <h4>Objective</h4>--}}
{{--                                        @foreach( $test_questions->question->options as $key => $option )--}}
{{--                                            <p> {{ $key+1 }} . {{ $option->option }}</p>--}}
{{--                                        @endforeach--}}
{{--                                    @elseif( $test_question->question->type == 2 )--}}
{{--                                        <h4>True or False</h4>--}}
{{--                                        @foreach( $test_question->question->options as $trueOrFalse )--}}
{{--                                            @if($trueOrFalse->is_correct)--}}
{{--                                               <p><span class="badge badge-success">True</span></p>--}}
{{--                                            @else--}}
{{--                                               <p><span class="badge badge-failure">False</span></p>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    @else--}}
{{--                                        <h4>Descriptive</h4>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

@push('scripts')

@endpush

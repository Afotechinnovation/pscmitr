@extends('admin::layouts.app')

@section('title', 'Package Test')

@section('header')
    <h1 class="page-title">Package Test</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.packages.show', $package_test->id)}}">Package Tests</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST" action="{{ route('admin.packages.tests.update', ['package' => $package_test->package_id,'test' => $package_test->id]) }}"
        enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Question<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="total_questions" name="total_questions" type="text"
                                       class="form-control @error('total_questions') is-invalid @enderror"
                                       placeholder="Total Question" value="{{ old('total_questions',$package_test->total_questions) }}"
                                       autocomplete="off">

                                @error('total_questions')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Marks<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="total_marks" name="total_marks" type="text"
                                       class="form-control @error('total_marks') is-invalid @enderror"
                                       placeholder="Total Marks" value="{{ old('total_marks',$package_test->total_marks) }}"
                                       autocomplete="off">

                                @error('total_questions')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Time<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="total_time" name="total_time" type="text"
                                       class="form-control @error('total_time') is-invalid @enderror"
                                       placeholder="Total Time" value="{{ old('total_time',$package_test->total_time) }}"
                                       autocomplete="off">

                                @error('total_time')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Correct Answer Mark<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="correct_answer_marks" name="correct_answer_marks" type="text"
                                       class="form-control @error('correct_answer_marks') is-invalid @enderror"
                                       placeholder="Correct Answer Marks" value="{{ old('correct_answer_marks',$package_test->correct_answer_marks) }}"
                                       autocomplete="off">

                                @error('correct_answer_marks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Negative Marks<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="negative_marks" name="negative_marks" type="text"
                                       class="form-control @error('negative_marks') is-invalid @enderror"
                                       placeholder="Negative Marks" value="{{ old('negative_marks',$package_test->negative_marks) }}"
                                       autocomplete="off">

                                @error('negative_marks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Questions<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <select name="questions[]" id="questions" multiple class="form-control
                                @error('questions') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach($quizzes as $quiz)
                                        <option
                                            @foreach($package_test->test_questions as $test_question)
                                            @if($test_question->pivot->question_id == $quiz->id)
                                            selected
                                            @endif
                                            @endforeach
                                            value="{{$quiz->id}}">{{ $quiz->question }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                   @can('update', $package_test)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                        </div>
                   @endcan
            </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
   <script>

       $("#questions").select2({
           placeholder: ' Select Questions'
       });

        $(function() {
            $('#form-update').validate({
                rules: {
                    total_questions: {
                        required: true,
                        number: true,
                    },
                    total_marks: {
                        required: true,
                        number: true
                    },
                    total_time: {
                        required: true,
                        number: true
                    },
                    negative_marks: {
                        required: true,
                        number: true
                    },
                    correct_answer_marks: {
                        required: true,
                        number: true
                    },
                }
            })
        });
    </script>
@endpush

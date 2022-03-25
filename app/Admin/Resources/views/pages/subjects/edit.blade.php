@extends('admin::layouts.app')

@section('title', 'Courses')

@section('header')
    <h1 class="page-title">Subject</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.subjects.index')}}">Subject</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST" action="{{ route('admin.subjects.update', $subject->id) }}">
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Course<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <x-inputs.courses id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('course_id', $subject->course_id)))
                                        <option value="{{ old('course_id', $subject->course_id) }}" selected>
                                            {{ old('course_id_text', empty($subject->course) ? '' : $subject->course->name) }}</option>
                                    @endif
                                </x-inputs.courses>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Name<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Subject Name" value="{{ old('name',$subject->name) }}"
                                       autocomplete="off">

                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $subject)
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
        $(function() {
            $('#form-update').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    course_id: {
                        required: true,
                    }
                }
            })
        });
    </script>
@endpush

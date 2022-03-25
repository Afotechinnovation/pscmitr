@extends('admin::layouts.app')

@section('title', 'Exam Notification')

@section('header')
    <h1 class="page-title">Exam Notification</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.exam-notifications.index')}}">Exam Notification</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form role="form" id="form-create" method="POST" action="{{ route('admin.exam-notifications.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Title<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="title" name="title" type="text" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Exam Notification Title" value="{{ old('title') }}" autocomplete="off">
                                @error('title')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Exam Category<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <x-inputs.exam_categories id="exam_category_id" class="{{ $errors->has('exam_category_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('exam_category_id')))
                                        <option value="{{ old('exam_category_id') }}" selected>{{ old('exam_category_id_text') }}</option>
                                    @endif
                                </x-inputs.exam_categories>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Related Notifications</label>
                            <div class="col-md-9">
                                <select name="related_exam_notifications[]" id="related_exam_notifications" multiple class="form-control
                                    @error('related_exam_notifications') is-invalid @enderror" style="width: 100%;" >
                                    <option></option>
                                    @foreach($related_exam_notifications as $related_exam_notification)
                                        <option @if (old("related_blogs"))
                                                {{ (in_array($related_exam_notification->id, old("related_exam_notifications")) ? "selected":"") }}
                                                @endif
                                                value="{{ $related_exam_notification->id }}">{{ $related_exam_notification->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Exam Number<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="exam_number" name="exam_number" type="text" class="form-control @error('exam_number') is-invalid @enderror"
                                       placeholder="Exam Number" value="{{ old('exam_number') }}" autocomplete="off">
                                @error('exam_number')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Last Date<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="last_date" name="last_date" type="date" class="form-control @error('last_date') is-invalid @enderror"
                                       placeholder="Last Date" value="{{ old('last_date') }}" autocomplete="off">
                                @error('last_date')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Url <span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="url" name="url" type="url" class="form-control @error('url') is-invalid @enderror"
                                       placeholder="https://www.exmaple" value="{{ old('url') }}" autocomplete="off">
                                @error('url')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Choose File<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input id="file" name="file" type="file" class="form-control @error('file') is-invalid @enderror"
                                       placeholder="Upload File" value="{{ old('file') }}" autocomplete="off" >

                                @error('file')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Body<span class="required">*</span> </label>
                            <div class="col-md-9" >
                                <div class="border" id="editorjs"></div>
                                <input id="body" name="body" type="hidden">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('create', \App\Models\ExamNotification::class)
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" type="submit">CREATE</button>
                    </div>
                    @endcan
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const editor = new EditorJS({
                placeholder: 'Body'
            });

            $("#related_exam_notifications").select2({
                placeholder: 'Select Related Exam Notification'
            });

            $('#form-create').validate({
                ignore: '#editorjs *',
                rules: {
                    title: {
                        required: true,
                        maxlength: 50,
                    },
                    exam_category_id: {
                        required: true,
                    },
                    exam_number: {
                        required: true,
                    },
                    last_date: {
                        required: true,
                    },
                    file: {
                        required: true,
                        extension: "pdf|doc|xls|docx|xlsx",

                    },
                    url: {
                        required: false,
                        url: true
                    },
                },
                messages :{
                    file: {
                        extension: "Please upload file type with pdf,doc,xls,docx",
                    }
                }

            });

            $('#form-create').on('submit', function (e) {
                e.preventDefault();

                if ($('#form-create').valid()) {
                    editor.save().then((data) => {
                        $('#body').val(JSON.stringify(data));
                        $('#form-create')[0].submit();
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            });
        });
    </script>
@endpush

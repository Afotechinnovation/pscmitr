@extends('admin::layouts.app')

@section('title', 'Questions')

@section('header')
    <h1 class="page-title">Questions</h1>
    <div class="page-header-actions">
        <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.questions.create') }}">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Create</span>
        </a>
    </div>

@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form id="form-filter-questions" class="form-inline mb-0 form-filter">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="sr-only" for="inputUnlabelUsername">Search</label>
                        <input id="search" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <select id="type" style="width: 100%" name="type" class="form-control">
                            <option></option>
                            <option value="all">All</option>
                            <option value="1">Objective</option>
                            <option value="2">True or False</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <x-inputs.courses style="width: 100%" id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                            @if(!empty(old('course_id')))
                                <option value="{{ old('course_id') }}" selected>{{ old('course_id_text') }}</option>
                            @endif
                        </x-inputs.courses>
                    </div>
                </div>
                <div class="col-md-2">
                    <x-inputs.subjects style="width: 100%" id="subject_id" related="#course_id" class="{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
                        @if(!empty(old('subject_id')))
                            <option value="{{ old('subject_id') }}" selected>{{ old('subject_id_text') }}</option>
                        @endif
                    </x-inputs.subjects>
                </div>
                <div class="col-md-2">
                    <x-inputs.chapters  style="width: 100%" id="chapter_id" related="#subject_id" class="{{ $errors->has('chapter_id') ? ' is-invalid' : '' }}">
                        @if(!empty(old('chapter_id')))
                            <option value="{{ old('chapter_id') }}" selected>{{ old('chapter_id_text') }}</option>
                        @endif
                    </x-inputs.chapters>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <select id="created_by" style="width: 100%" name="created_by" class="form-control">
                            <option></option>
                            @foreach($questionCreaters as $questionCreater)
                                <option value="{{ $questionCreater->id }}"  >{{ $questionCreater->name }} </option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-md-2 pt-4">
                    <div class="form-group">
                        <input class="form-control w-full" id="created_at" type="date" name="created_at" placeholder="Date" autocomplete="off">

                    </div>
                </div>
                <div class="col-md-3 pt-4">
                    <div class="form-group">
                        <button id="btn-filter" type="submit" class="btn btn-primary btn-outline">Search</button>
                        <button id="btn-clear" class="btn btn-primary ml-2">Clear</button>
                        @can('create', \App\Models\Admin::class)
                        <a  class="btn btn-primary export ml-2" href="#">
                            Download
                        </a>
                        @endcan
{{--                        <a href="#" class="btn btn-primary btn-outline ml-1 export">Export </a>--}}
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $tableQuestions->table(['id' => 'table-questions'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')

    {!! $tableQuestions->scripts() !!}

@endpush
@push('scripts')

    <script>
        $(function() {

            $("#type").select2({
                placeholder: 'Type'
            });
            $("#created_by").select2({
                placeholder: 'Created By'
            });

            let $tableQuestions = $('#table-questions');

            $tableQuestions.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    course: $('#course_id').val(),
                    subject: $('#subject_id').val(),
                    chapter: $('#chapter_id').val(),
                    type: $('#type').val(),
                    created_by: $('#created_by').val(),
                    date: $('#created_at').val(),

                };
            });

            $('#form-filter-questions').submit(function (e) {
                e.preventDefault();
                $tableQuestions.DataTable().draw();
            });

            $('.export').click(function (e) {
                e.preventDefault();

               let  type = $('#type').val();
               let  search = $('#search').val();
               let  course = $('#course_id').val();
               let  subject = $('#subject_id').val();
               let  chapter = $('#chapter_id').val();
               let  created_by = $('#created_by').val();
               let  date = $('#created_at').val();

                if(!type){
                    type =  null;
                }
                if(!search){
                    search =  null;
                }
                if(!created_by){
                    created_by =  null;
                }
                if(!date){
                    date =  null;
                }

                let url =  '{{ url('admin/question') }}' +'/download?' + 'type=' + type + '&search=' + search + '&course=' + course
                    + '&subject=' + subject + '&chapter=' + chapter + '&created_by=' + created_by + '&date=' + date;

                window.location.href = url;
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                type: $('#type').empty();
                course: $('#course_id').empty();
                subject: $('#subject_id').empty();
                chapter: $('#chapter_id').empty();
                created_by: $('#created_by').empty();
                date : $('#created_at').val( );

                $tableQuestions.DataTable().draw();
            });


            $tableQuestions.on('click', '.button-delete', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let ladda = Ladda.create(this);
                ladda.start();

                alertify.okBtn("Delete")
                alertify.confirm("Are you sure?", function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        toastr.success('Question successfully deleted');
                        $tableQuestions.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });
        })
    </script>
@endpush

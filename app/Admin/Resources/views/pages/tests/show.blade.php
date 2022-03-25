@extends('admin::layouts.app')

@section('title', 'Test Questions')

@section('header')
    <h1 class="page-title">{{ $test->name }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route( 'admin.tests.index', $test->id )}}">Tests</a></li>
        </ol>
    </nav>
    @if(!in_array($test->id, $isUserAttemptedTest))
    <div class="page-header-actions">
        <a class="btn btn-md btn-primary  btn-round" href="{{ route('admin.tests.edit', $test->id) }}">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <span class="text hidden-sm-down"><i class="icon wb-edit" aria-hidden="true"></i>Edit Test</span>
        </a>
    </div>
    @endif
    <style>
        .modal-open .select2-container{
            z-index: 0 !important;
        }
    </style>
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
                    <dt class="col-md-9">{{ $test->total_questions_added }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Total Marks</dd>
                    <dt class="col-md-9">{{ $test->total_marks }}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Total Time</dd>
                    <dt class="col-md-9">{{ $test->total_time }}</dt>
                </div>

                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Correct Answer Marks</dd>
                    <dt class="col-md-9">{{ $test->correct_answer_marks }}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Negative Marks</dd>
                    <dt class="col-md-9">{{ $test->negative_marks }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Cut Off Marks</dd>
                    <dt class="col-md-9">{{ $test->cut_off_marks }}</dt>
                </div>
                <div class="row no-gutters align-items-center  p-15">
                    <dd class="col-md-3 mb-sm-0">Description</dd>
                    <dt class="col-md-9">{{ $test->description }}</dt>
                </div>
                <div class="row no-gutters align-items-center  p-15">
                    <dd class="col-md-3 mb-sm-0">Sections</dd>
                    <dt class="col-md-9">{{ $newSection }}</dt>
                </div>

            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 active" data-toggle="tab" href="#test-questions" aria-controls="test-questions" role="tab" aria-selected="false">Test Questions</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 " data-toggle="tab" href="#test-sections" aria-controls="test-sections" role="tab" aria-selected="true">Sections</a></li>

            </ul>
        </div>
        @if(!in_array($test->id, $isUserAttemptedTest))
            <div class="col-md-2">
                <span class="float-right">
                     <a class="btn btn-md btn-primary" href="#" data-toggle="modal" data-target="#modal-create-test-sections">
                        <i class="wb-plus" aria-hidden="true"></i>
                        <span class="text hidden-sm-down">Create Sections </span>
                    </a>
                </span>
            </div>
        @endif
    </div>

    <div class="nav-tabs-horizontal" data-plugin="tabs">
        <div class="tab-content">
            <div class="tab-pane active" id="test-questions" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Test Questions</h4>
                        @if(!in_array($test->id, $isUserAttemptedTest))
                            <div class="">
                                <a class="btn btn-md btn-primary"  href="{{ route('admin.tests.questions.create', $test->id) }}">
                                    <span class="text hidden-sm-down" ><i class="wb-plus" aria-hidden="true"></i>Add Questions</span>
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card">
                     <div class="card-body">
                                {!! $tableQuestions->table(['id' => 'table-test-questions'], true) !!}
                     </div>

                        <div class="modal fade " id="modal-show-options" tabindex="-1" role="dialog" aria-labelledby="videoCategoryFolderLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="ShowQuestionOption">Options</h3> </hr>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="question-options">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="test-sections" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Sections</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $tableTestSections->table(['id' => 'table-test-sections'], true) !!}
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


    {{--Show Option modal--}}
    <div class="modal fade" id="modal-create-test-sections" tabindex="-1" role="dialog" aria-labelledby="testSectionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="test-section-form" action="{{route('admin.tests.sections.store', $test->id)}}">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="testSectionLabel">Test Section </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row mt-2">
                            <label for="name" class="col-sm-2 col-form-label">Name*</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" required class="form-control @error('name')
                                    is-invalid @enderror" id="name" placeholder="Section Name">
                                @error('name')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('name') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    {!! $tableQuestions->scripts() !!}
    {!! $tableTestSections->scripts() !!}
@endpush

@push('scripts')

    <script>

        $(function() {

            // section validation
            var errors = '{{ $errors->first('name') }}';

            if(errors){
                $('#modal-create-test-sections').modal('show');
            }

            //Sort Package Test Order
            $('#table-test-questions tbody').sortable({
                update: function() {
                    let test_question;
                    let test_questions = [];

                    $(this).find('tr').each(function() {
                        test_question = $(this).find('.test-question-id').val();
                        test_questions.push(test_question);
                    });

                    $.ajax({
                        url: '{{ route('admin.tests.questions.change-order') }}',
                        data: {
                            test_questions: test_questions
                        }
                    }).done(function() {
                        $('#table-test-questions').DataTable().draw();
                    });
                }
            });

            //Filter Questions Table
            let $questionsTable = $('#table-test-questions');

            $questionsTable.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    course: $('#course_id').val(),
                    subject: $('#subject_id').val(),
                    chapter: $('#chapter_id').val(),
                    type: $('#type').val(),

                };
            });

            $('#btn-filter').click(function (e) {
                e.preventDefault();
                $questionsTable.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                type: $('#type').val('all');
                course: $('#course_id').empty();
                subject: $('#subject_id').empty();
                chapter: $('#chapter_id').empty();
                $questionsTable.DataTable().draw();
            });



            $questionsTable.on('click', '.show-options', function (e) {
                e.preventDefault();
                let id = $(this).attr('data-question-id');

                url = '{{ url('admin/tests/show/options') }}';
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        'id' : id ,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response)
                    {
                        $("#question-options").empty();
                       if(response) {
                           var question_options = $("#question-options");
                               if(response.type==1) {
                                   var type = 'Objective';
                                   question_options.append("<div class='row>' <div> Type : " + type + " </div>");

                                   var options = response.options;
                                   $.each(options, function (i) {
                                       if (response.type == 1) {
                                           var count = i+1;
                                           if (options[i].is_correct == 1) {

                                               question_options.append("<div class='row>' <div> Option :" + count + ":" + options[i].option + "&nbsp &nbsp <i class='icon wb-check  btn-success'> </i></div>");

                                           } else {
                                               question_options.append("<div class='row>' <div> Option :" + count + ":" + options[i].option + " </div>");
                                           }


                                       }
                                   });
                               }
                               else if(response.type==2) {

                                var type = 'True Or False';

                               var option = response.options[0];

                               question_options.append("<div class='row>' <div> Type : " + type + " </div>");

                                if(option.is_correct) {
                                    question_options.append("<span class='badge badge-success'> " + "True"  + " </span>");
                                }else {
                                    question_options.append("<span class='badge badge-danger'> " + "False"  + " </span>");
                                }

                           }

                       }

                    }
                });
            });
            $questionsTable.on('click', '.button-delete', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let ladda = Ladda.create(this);
                ladda.start();

                alertify.okBtn("Delete")
                alertify.confirm("Are you sure?", function () {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        toastr.success('Test Question Successfully deleted');
                        $questionsTable.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            let $tableTestSections = $('#table-test-sections');
            $tableTestSections.on('click', '.button-delete', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let ladda = Ladda.create(this);
                ladda.start();

                alertify.okBtn("Delete")
                alertify.confirm("Are you sure? Section and Test Question under this section also will be Deleted?", function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        toastr.success('Section successfully deleted');
                        $tableTestSections.DataTable().draw();
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

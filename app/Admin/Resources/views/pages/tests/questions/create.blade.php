@extends('admin::layouts.app')

@section('title', 'Test Questions')

@section('header')
    <h1 class="page-title">{{ $test->name }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route( 'admin.tests.index', $test->id )}}">Tests</a></li>
            <li class="breadcrumb-item"><a href="{{route( 'admin.tests.show', $test->id )}}">{{ $test->name }}</a></li>
            <li class="breadcrumb-item">Questions</li>
        </ol>
    </nav>
    <style>
        .modal-open .select2-container{
            z-index: 0 !important;
        }
        .ColorChange {
            background-color: #b5bd68;
        }
    </style>
@endsection

@section('content')
<div class="card">
    <form id="form-test-questions"  name="form-test-questions" method="POST"  action="{{ route('admin.test-questions.update', $test->id)}}">
        @csrf

        <div class="card-body bg-grey-100">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="sr-only" for="inputUnlabelUsername">Search</label>
                        <input id="search" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
                    </div>
                </div>

{{--                <div class="col-md-2">--}}
{{--                    <div class="form-group">--}}
{{--                        <select id="type" name="status" class="form-control">--}}
{{--                            <option>Select Type</option>--}}
{{--                            <option value="all">All</option>--}}
{{--                            <option value="1">Objective</option>--}}
{{--                            <option value="2">True or False</option>--}}
{{--                            <option value="3">Descriptive</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-md-2">
                    <div class="form-group row">
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
                        <button id="btn-filter" type="button" class="btn btn-primary btn-outline">Search</button>
                        <button id="btn-clear" class="btn btn-primary ml-2">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row float-right" >
                <div class="col-md-3">
                    <label class="fw-700 text-black"> Questions Added</label>
                       <input type="text" readonly  class="form-control" value="{{$testQuestions->count()}}" >
                </div>
                <div class="col-md-3">
                    <label class="fw-700 text-black">Selected Questions</label>
                    <input type="text"  readonly class="form-control" id="selected-questions-row" value="">
                </div>
            </div>

            {!! $tableQuestions->table(['id' => 'table-questions'], true) !!}
        </div>
        <input type="hidden"  id="test_section_id" name="test_section_id" value="" >
        <div class="card-footer bg-grey-100">
            <div class="row">
                {{--                    @can('create', \App\Models\Course::class)--}}
                <div class="col-md-12">
                    <button class="btn btn-primary float-right" name="add_section" value="add_questions"  id="add-test-questions" type="button">SUBMIT</button>
                </div>
                {{--                    @endcan--}}
            </div>
        </div>
    </form>
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

<div class="modal fade" id="modal-add-test-sections"  role="dialog" aria-labelledby="addtestSectionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form  id="test-section-form">
                <div class="modal-header">
                    <h3 class="modal-title" id="addtestSectionLabel">Add Test Section </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row mt-2">

                            @if(!$testSections->count() )

                                <h4  class="font-xss text-grey-800 fw-700 d-inline-block mt-16 mb-4 pl-30">
                                    Would you like to Add Questions Without Sections?
                                </h4>

                            @else
                                @if(!$testQuestionSections->count() && $testQuestions->count())
                                        <h4  class="font-xss text-grey-800 fw-700 d-inline-block mt-16 mb-4 pl-30 lh-5">
                                     Remove Already added questions to add these question into new section or Countinue by adding questions without sections?
                                </h4>
                                @else
                                    <label for="test_section" class="col-sm-2 col-form-label">Section</label>
                                    <div class="col-sm-10">
                                        <select name="test_section" id="test_section"  class="form-control
                                            @error('test_section') is-invalid @enderror" required style="width: 100%;" >
                                            <option></option>
                                            @foreach( $testSections as $testSection )
                                                <option @if ( (old('test_section') == $testSection->id) ) selected @endif
                                                value="{{ $testSection->id }}" {{ $loop->first ? 'selected="selected"' : '' }}>{{ $testSection->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                            @endif

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="test-section-button" >Ok</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@push('scripts')
    {!! $tableQuestions->scripts() !!}
@endpush

@push('scripts')
    <script>

        //Select and add questions to test
        //Two arrays with one containing selected questions id and another one for unchecked questions
        let rows_selected = JSON.parse( '{!! json_encode( $selectedQuestionIDs ) !!}' );

        let rows_unchecked = [];
        let checked_rows = [];

        //Function which returns the id of the questions from controller and checks if it is present in the row_selected array
        function renderCheckbox( questionId ){
            if( rows_selected.includes( questionId ) ){
                return '<input id="'+ questionId +'"  value="'+ questionId +'"  class="check-row " disabled name="questions[]" type="checkbox" >';
            }
            else{
                return '<input id="'+ questionId +'"  value="'+ questionId +'"   class="check-row" name="questions[]" type="checkbox" >';
            }

        }

        //Function to add or remove 'selected class from checkbox based on the selection
        function callback(row, data, dataIndex){
            var rowId = data[0];

            // If row ID is in the list of selected row IDs
            if($.inArray( rowId, rows_selected ) !== -1){
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');
            }

            // If row ID is in the list of removed row IDs
            if( $.inArray(rowId, rows_unchecked) !== -1 ){
                $(row).find('input[type="checkbox"]').prop('checked', false);

                $(row).removeClass('selected');
            }
        }


        $(function() {

            $("#test_section").select2({
                dropdownParent: $('#modal-add-test-sections'),
                placeholder: 'Select Section'
            });


            var table = $('#table-questions').DataTable();

            // Handle click on checkbox
            $('#table-questions tbody').on('click', 'input[type="checkbox"]', function(e){

                // show count of selected questions

                var selectedQuestions = $('input[type="checkbox"]:checked').map(function() {
                    return this.id;
                })
                 .get();
                $('#selected-questions-row').val( selectedQuestions.length );

                var $row = $(this).closest('tr');

                // Get row data
                var data = table.row($row).data();

                // Get row ID
                var rowId = data.id;
                // checked_rows.push(rowId);


                // Determine whether row ID is in the list of selected row IDs
                var index = $.inArray(rowId, rows_selected);
                var index_removed = $.inArray(rowId, rows_unchecked);

                // If checkbox is checked and row ID is not in list of selected row IDs
                if(this.checked && index === -1){
                    checked_rows.push(rowId);

                    // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                } else if (!this.checked && index !== -1){
                    checked_rows.splice(index, 1);

                }

                if(!this.checked && index_removed === -1){
                    rows_unchecked.push(rowId);
                }else{
                    rows_unchecked.splice(index_removed, 1);
                }

                if(this.checked){
                    $row.addClass('selected');

                } else {
                    $row.removeClass('selected');
                }

                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle click on table cells with checkboxes , thead th:first-child
            $('#table-questions').on('click', 'tbody td', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            // Handle click on "Select all" control
            $('#table-questions').on('click', 'thead input[name="select_all"]',function(e){
                if(this.checked){
                    $('#table-questions tbody input[type="checkbox"]:not(:checked)').trigger('click');

                } else {
                    $('#table-questions tbody input[type="checkbox"]:checked').trigger('click');
                }

                // Prevent click event from propagating to parent
                e.stopPropagation();
            });

            // Handle table draw event
            table.on('draw', function(){
                // Update state of "Select all" control
                updateDataTableSelectAllCtrl(table);
            });

            // Handle form submission event
            $('#add-test-questions').on('click', function(e){
                e.preventDefault();
                var form = this;
                console.log(checked_rows.length);
                // Iterate over all selected checkboxes
                $.each(checked_rows, function(index, rowId){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('id','selected_questions')
                            .attr('name', 'selected_questions[]')
                            .val(rowId),
                    );
                    var selected_row = $('#selected_questions').val();
                   console.log(selected_row);
                   if(selected_row) {
                       $("#modal-add-test-sections").modal('show');
                   }
                });
                $.each(rows_unchecked, function(index, rowId){
                    // Create a hidden element

                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('id','removed_questions')
                            .attr('name', 'removed_questions[]')
                            .val(rowId),
                    );

                });

                $('#test-section-button').on('click', function(){

                    var test_section = $('#test_section').val();

                    $('#test_section_id').val(test_section);
                    $('#form-test-questions').submit();

                });
            });

            // Updates "Select all" control in a data table
            function updateDataTableSelectAllCtrl(table){
                var $table             = table.table().node();
                var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
                var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
                var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

                // If none of the checkboxes are checked
                if($chkbox_checked.length === 0){
                    chkbox_select_all.checked = false;
                    if('indeterminate' in chkbox_select_all){
                        chkbox_select_all.indeterminate = false;
                    }

                    // If all of the checkboxes are checked
                } else if ($chkbox_checked.length === $chkbox_all.length){
                    chkbox_select_all.checked = true;
                    if('indeterminate' in chkbox_select_all){
                        chkbox_select_all.indeterminate = false;
                    }

                    // If some of the checkboxes are checked
                } else {
                    chkbox_select_all.checked = true;
                    if('indeterminate' in chkbox_select_all){
                        chkbox_select_all.indeterminate = true;
                    }
                }
            }

            //Filter Questions Table
            let $tableQuestions = $('#table-questions');

            $tableQuestions.on('preXhr.dt', function (e, settings, data) {
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
                $tableQuestions.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                type: $('#type').val('all');
                course: $('#course_id').empty();
                subject: $('#subject_id').empty();
                chapter: $('#chapter_id').empty();
                $tableQuestions.DataTable().draw();
            });

            let $questionsTable = $('#table-questions');

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


        })

    </script>
@endpush

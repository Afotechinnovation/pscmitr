@extends('admin::layouts.app')

@section('title', 'Package Tests')

@section('header')
    <h1 class="page-title">Package Tests</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route( 'admin.packages.index')}}">Packages</a></li>
            <li class="breadcrumb-item"><a href="{{route( 'admin.packages.show', $package->id )}}">{{ $package->name }}</a></li>
            <li class="breadcrumb-item">Tests</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <form id="form-package-test"  name="form-package-test" method="POST"  action="{{ route('admin.package-tests.update', $package->id)}}">
            @csrf
            <div class="card-body bg-grey-100">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="sr-only" for="inputUnlabelUsername">Search</label>
                            <input id="search" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
                        </div>
                    </div>
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
                        <div class="form-group">
                            <button id="btn-filter" type="button" class="btn btn-primary btn-outline">Search</button>
                            <button id="btn-clear" class="btn btn-primary ml-2">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $tableTests->table(['id' => 'table-package-tests'], true) !!}
            </div>
            <div class="card-footer bg-grey-100">
                <div class="row">
                    {{--                    @can('create', \App\Models\Course::class)--}}
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" name="submit" value="add_tests"  type="submit">SUBMIT</button>
                    </div>
                    {{--                    @endcan--}}
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    {!! $tableTests->scripts() !!}
@endpush

@push('scripts')
    <script>

        //Select and add questions to test
        //Two arrays with one containing selected questions id and another one for unchecked questions
        let rows_selected = JSON.parse( '{!! json_encode( $selectedTestIDs ) !!}' );
        let rows_unchecked = [];

        //Function which returns the id of the questions from controller and checks if it is present in the row_selected array
        function renderCheckbox( testId ){
            if( rows_selected.includes( testId ) ){
                return '<input id="'+ testId +'"  value="'+ testId +'"  checked  class="check-row" name="tests[]" type="checkbox" >';
            }
            else{
                return '<input id="'+ testId +'"  value="'+ testId +'"   class="check-row" name="tests[]" type="checkbox" >';
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

            var table = $('#table-package-tests').DataTable();

            // Handle click on checkbox
            $('#table-package-tests tbody').on('click', 'input[type="checkbox"]', function(e){
                var $row = $(this).closest('tr');

                // Get row data
                var data = table.row($row).data();

                // Get row ID
                var rowId = data.id;

                // Determine whether row ID is in the list of selected row IDs
                var index = $.inArray(rowId, rows_selected);
                var index_removed = $.inArray(rowId, rows_unchecked);


                // If checkbox is checked and row ID is not in list of selected row IDs
                if(this.checked && index === -1){
                    rows_selected.push(rowId);
                    // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                } else if (!this.checked && index !== -1){
                    rows_selected.splice(index, 1);
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
            $('#table-package-tests').on('click', 'tbody td', function(e){
                $(this).parent().find('input[type="checkbox"]').trigger('click');
            });

            // Handle click on "Select all" control
            $('#table-package-tests').on('click', 'thead input[name="select_all"]',function(e){
                if(this.checked){
                    $('#table-package-tests tbody input[type="checkbox"]:not(:checked)').trigger('click');
                } else {
                    $('#table-package-tests tbody input[type="checkbox"]:checked').trigger('click');
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
            $('#form-package-test').on('submit', function(e){
                var form = this;

                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'selected_tests[]')
                            .val(rowId),
                    );
                });
                $.each(rows_unchecked, function(index, rowId){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'removed_tests[]')
                            .val(rowId),
                    );
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
            let $tableTests = $('#table-package-tests');

            $tableTests.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    course: $('#course_id').val(),
                };
            });

            $('#btn-filter').click(function (e) {
                e.preventDefault();
                $tableTests.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                course: $('#course_id').empty();
                $tableTests.DataTable().draw();
            });

        })

    </script>
@endpush

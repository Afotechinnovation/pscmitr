@extends('admin::layouts.app')

@section('title', 'Tests')

@section('header')
    <h1 class="page-title">Tests</h1>
    <div class="page-header-actions">
        <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.tests.create') }}">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Create</span>
        </a>
        <a class="btn btn-sm btn-primary btn-round" href="#" data-target="#testWinnerImageModal" data-toggle="modal">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Test Winner</span>
        </a>
    </div>
    <style>
        .modal-open .select2-container{
            z-index: 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form id="form-filter-tests" class="form-inline mb-0 form-filter">
                <div class="form-group">
                    <label class="sr-only" for="inputUnlabelUsername">Search</label>
                    <input id="search" type="text" class="form-control w-200" placeholder="Search..." autocomplete="off">
                </div>
                <div class="form-group">
                    <x-inputs.courses id="course_id"  class="w-200">
                        @if (request()->filled('course_id') && request()->filled('course_id_text'))
                            <option value="{{ old('course_id', request()->input('course_id')) }}" selected>{{ old('course_id', request()->input('course_id_text')) }}</option>
                        @endif
                    </x-inputs.courses>
                </div>
                <div class="row  p-15">
                    <div class="form-group">
                        <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Clear</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $tableTests->table(['id' => 'table-tests'], true) !!}
        </div>
    </div>

    <div class="modal fade" id="testWinnerImageModal" tabindex="-1" role="dialog" aria-labelledby="testWinnerImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="testWinner-update"  class="p-5" method="POST" action="{{ route('admin.test_winners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testWinnerImageModalLabel">Test Winner</h5>
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 mt-3">
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                @error('image')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                     {{ $errors->first('image') }}
                                      </span>
                                @enderror
                                <span class="text-info" role="alert"  style="display: inline;">
                                     <small> Recommended size for Image Max - 300 x 300</small>
                                    </span>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Submit</button>
                </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="TodayTestModal" tabindex="-1" role="dialog" aria-labelledby="TodayTestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="today-test-update"  class="p-5" method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="TodayTestModalLabel">Today Test</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label for="total_questions" class="col-md-3 col-form-label">Date Time: </label>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="testId" value="" id="testId">
                                    <input type="date" name="today_test_date"  required class="form-control @error('today_test_date')
                                        is-invalid @enderror" id="today_test_date" placeholder="Date and Time" value="" >
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="today-test-date-btn" >
                                            Cancel
                                        </button>
                                    </div>
                                    @error('today_test_date')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('today_test_date') }}
                                </span><br>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Is Today Test: </label>
                            <div class="col-md-6" style="padding-top: 10px">
                                <input type="checkbox" name="is_today_test"  required id="is_today_test" class="form-check @error('is_today_test') is-invalid @enderror"
                                       autocomplete="off">
                                @error('is_today_test')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="LiveTestModal" tabindex="-1" role="dialog" aria-labelledby="LiveTestModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="live-test-update"  class="p-5" method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="LiveTestModalLabel">Live Test</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label for="live_test_date_time" class="col-md-3 col-form-label">Date Time: </label>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="testId" value="" id="testId">
                                    <input type="datetime-local" name="live_test_date_time"  required class="form-control @error('live_test_date_time')
                                        is-invalid @enderror" id="live_test_date_time" placeholder="Date and Time" value="" >
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="live-test-date-btn" >
                                            Cancel
                                        </button>
                                    </div>
                                    @error('live_test_date_time')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('live_test_date_time') }}
                                </span><br>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="live_test_duration" class="col-md-3 col-form-label">Live Test Duration: </label>
                            <div class="col-md-8">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="testId" value="" id="testId">
                                    <input type="time" name="live_test_duration"  required class="form-control @error('live_test_duration')
                                        is-invalid @enderror" id="live_test_duration" placeholder="Date and Time" value="" >
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="live-test-duration-btn" >
                                            Cancel
                                        </button>
                                    </div>
                                    @error('today_test_date')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('today_test_date') }}
                                </span><br>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Is Live Test: </label>
                            <div class="col-md-8" style="padding-top: 10px">
                                <input type="checkbox" name="is_live_test" id="is_live_test" class="form-check @error('is_live_test') is-invalid @enderror"
                                       autocomplete="off">
                                @error('is_live_test')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $tableTests->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {

            let $tableTests = $('#table-tests');

            $tableTests.on('click', '.button-publish', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let publish = $(this).data('publish');
                let ladda = Ladda.create(this);
                ladda.start();
                if(publish!='1') {
                    alertify.okBtn("UnPublish");
                }else {
                    alertify.okBtn("Publish");
                }

                alertify.confirm("Are you sure?", function () {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            publish: publish
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        if(data){
                            if(data.is_published == 1){
                                toastr.success('Test successfully Published');
                            }else {
                                toastr.success('Test successfully UnPublished');
                            }
                        }
                        $tableTests.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        toastr.warning('Add full test Questions to publish');
                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });


            $tableTests.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    course: $('#course_id').val(),

                };
            });

            $('#form-filter-tests').submit(function (e) {
                e.preventDefault();
                $tableTests.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
               e.preventDefault();
                 search: $('#search').val('');
                 course: $('#course_id').empty();
                 $tableTests.DataTable().draw();
             });


            $tableTests.on('click', '.button-delete', function (e) {
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
                        toastr.success('Test successfully deleted');
                        $tableTests.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            $tableTests.on('click', '.button-today-test', function (e) {
                e.preventDefault();
                let testId =  $(this).data('test-id');
                let testDate =  $(this).data('test-date');
                let isTodayTest =  $(this).data('today-test');

                if(isTodayTest == 1 ) {

                    $("#is_today_test").prop( "checked", true );
                }else {
                    $("#is_today_test").prop( "checked", false );
                }

                $('input[id=testId]').val(testId);
                $('input[id=today_test_date]').val(testDate);
                $('#TodayTestModal ').modal('show');

                let url = '{{ url('admin/tests/today-test') }}' + '/' + testId;

                $('#today-test-update').attr('action', url);
            });
            $('#today-test-date-btn').click(function (e) {
                e.preventDefault();
                $('#today_test_date').val('');

            });

            $tableTests.on('click', '.button-live-test', function (e) {
                e.preventDefault();

                let testId =  $(this).data('test-id');
                let livetestDuration =  $(this).data('live-test-duration');
                let livetestDateTime =  $(this).data('live-test-date-time');
                let isLiveTest =  $(this).data('is-live-test');

                if(isLiveTest == 1 ) {

                    $("#is_live_test").prop( "checked", true );
                }else {
                    $("#is_live_test").prop( "checked", false );
                }

                $('input[id=testId]').val(testId);
                $('input[id=live_test_duration]').val(livetestDuration);
                $('input[id=live_test_date_time]').val((livetestDateTime.toLocaleString("sv-SE") + '').replace(' ','T'));
                $('#LiveTestModal ').modal('show');

                let url = '{{ url('admin/tests/live-test') }}' + '/' + testId;

                $('#live-test-update').attr('action', url);
            });

            $tableTests.on('click', '.button-copy-test', function (e) {
                e.preventDefault();

                let testId = $(this).attr('data-test-id');
                let url =   '{{ url('test/quick-test')}}' + '?test=' + testId;

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();
                toastr.success('Test link Copied');
            });

            $('#live-test-date-btn').click(function (e) {
                e.preventDefault();
                $('#live_test_date_time').val('');

            });
            $('#live-test-duration-btn').click(function (e) {
                e.preventDefault();
                $('#live_test_duration').val('');

            });
        })
    </script>
@endpush

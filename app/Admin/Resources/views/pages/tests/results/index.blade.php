@extends('admin::layouts.app')

@section('title', 'Tests')

@section('header')
    <h1 class="page-title">Test Results</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form id="form-filter-tests" class="form-inline mb-0 form-filter">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="sr-only" for="inputUnlabelUsername">Search</label>
                        <input id="search" name="search" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input id="date" name="created_at" type="text" class="form-control @error('created_at') is-invalid @enderror"
                               placeholder="Date" value="{{ old('created_at') }}" autocomplete="off">
                        @error('created_at')
                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                    {{ $errors->first('created_at') }}
                                </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <button id="btn-filter" type="submit" class="btn btn-primary btn-outline">Search</button>
                        <button id="btn-clear" class="btn btn-primary ml-2">Clear</button>
                        <a  class="btn btn-primary download ml-2" href="#">
                            Download
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $table->table(['id' => 'tbl-test-result'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')

    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#tbl-test-result');

            $table.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    date:  $('#date').val(),
                };
            });

            $('#form-filter-tests').submit(function (e) {
                e.preventDefault();
                $table.DataTable().draw();
            });


            $('.download').click(function (e) {
                e.preventDefault();
                let date = $('#date').val();
                let search = $('#search').val();

                if(!date){
                    date =  null;
                }
                if(!search){
                    search =  null;
                }

               let url =  '{{ url('admin/test-results') }}' +'/download?' + 'date=' + date + '&search=' + search;
                window.location.href = url;
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                date: $('#date').val('');

                $table.DataTable().draw();
            });

            // $('#date').daterangepicker({
            //     locale: {
            //         format: 'YYYY-MM-DD',
            //         setDate : ''
            //     }
            // });

            $('#date').daterangepicker({autoUpdateInput: false}, (from_date, to_date) => {
                $('#date').val(from_date.format('YYYY-MM-DD') + ' - ' + to_date.format('YYYY-MM-DD'));
            });

            $table.on('click', '.button-delete', function (e) {
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
                        toastr.success('test result Successfully deleted');
                        $table.DataTable().draw();
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

@extends('admin::layouts.app')

@section('title', 'Popular Search')

@section('header')
    <h1 class="page-title">Popular Search</h1>
    @can('create', \App\Models\PopularSearch::class)
        <div class="page-header-actions">
            <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.popular-searches.create') }}">
                <i class="wb-plus" aria-hidden="true"></i>
                <span class="text hidden-sm-down">Create</span>
            </a>
        </div>
    @endcan
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form class="form-inline mb-0" id="form-filter">
                <div class="form-group">
                    <label class="sr-only" for="search">Search</label>
                    <input class="form-control w-full" id="search" type="text" placeholder="Search" autocomplete="off">
                </div>
                <div class="form-group">
                    <label class="sr-only1 mr-2" for="status">Status: </label>
                    <select id="status" name="status" class="form-control w-150">
                        <option></option>
                        <option value="all">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-outline" id="btn-clear" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $table->table(['id' => 'table-popular-search'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {

            $("#status").select2({
                placeholder: 'Select Status'
            });


            let $table = $('#table-popular-search');

            $table.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    status: $('#status').val(),
                };
            });

            $('#form-filter').submit(function (e) {
                e.preventDefault();
                $table.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                status: $('#status').val('all'),
                $table.DataTable().draw();
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
                        toastr.success('Search key Successfully deleted');
                        $table.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

        $table.on('click', '.button-status-change', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let ladda = Ladda.create(this);
            ladda.start();

            alertify.okBtn("Status Change")
            alertify.confirm("Are you sure?", function () {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    }
                }).done(function (data, textStatus, jqXHR) {
                    toastr.success('Status Successfully changed');
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

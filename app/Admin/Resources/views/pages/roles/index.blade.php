@extends('admin::layouts.app')
@section('title', 'Roles')


@section('header')
    <h1 class="page-title">Roles</h1>
    <div class="page-header-actions">
            <a class="btn btn-md btn-primary" href="{{ route('admin.roles.create') }}">
                <i class="wb-plus" aria-hidden="true"></i>
                <span class="text hidden-sm-down">Add Role</span>
            </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form class="form-inline mb-0 form-filter">
                <div class="form-group">
                    <label class="sr-only" for="inputUnlabelUsername">Search</label>
                    <input id="search-query" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
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
            {!! $html->table(['id' => 'tbl-roles'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $html->scripts() !!}

@endpush

@push('scripts')
    <script>
        $(function() {

            var $table = $('#tbl-roles');

            $table.on('preXhr.dt', function ( e, settings, data ) {
                data.filter = {
                    search: $('#search-query').val(),
                };
            });

            $('.form-filter').submit(function(e) {
                e.preventDefault();
                $table.DataTable().draw();
            });

            $('#btn-clear').click(function() {
                $('#search-query').val('');

                $table.DataTable().draw();
            });

            $('#tbl-roles').on('click', '.btn-delete', function (e) {
                e.preventDefault();
                let confirm = window.confirm('Delete Role?');
                let url = $(this).attr('href');
                if (confirm) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }
                    }).done(function (response) {
                        toastr.success('Successfully deleted');
                        $table.DataTable().draw();
                    });
                }
            });

        });
    </script>
@endpush

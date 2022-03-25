@extends('admin::layouts.app')

@section('title', 'Transactions')

@section('header')
    <h1 class="page-title">Transactions</h1>
    <div class="page-header-actions">
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form class="form-inline mb-0" id="form-filter-transactions">
                <div class="form-group">
                    <label class="sr-only" for="search">Search</label>
                    <input class="form-control w-full" id="search" type="text" placeholder="Search" autocomplete="off">
                </div>
                <div class="form-group">
                     <input class="form-control w-full" id="transaction-date" type="date" name="created_at" placeholder="Date" autocomplete="off">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                </div>
                <div class="form-group">
                    <button id="btn-clear" class="btn btn-primary btn-outline"  type="button">Clear</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $table->table(['id' => 'table-transactions'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#table-transactions');

            $('#table-transactions').on('preXhr.dt', function ( e, settings, data ) {
                data.filter = {
                    search: $('#search').val(),
                    date: $('#transaction-date').val(),
                };
            });

            $('#form-filter-transactions').submit(function(e) {
                e.preventDefault();
                $('#table-transactions').DataTable().draw();
            });

            $('#btn-clear').click(function(e) {
                $('#search').val('');
                $('#transaction-date').val('');
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
                        toastr.success('Transaction Successfully deleted');
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

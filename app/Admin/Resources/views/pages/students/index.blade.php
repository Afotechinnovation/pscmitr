@extends('admin::layouts.app')

@section('title', 'Students')

@section('header')
    <h1 class="page-title">Students</h1>

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
                    <input id="date" name="date_range" type="text" value="{{old('date_range', request()->input('date_range'))}}"  class="form-control @error('date_range') is-invalid @enderror"
                           autocomplete="off" placeholder="Select Date">

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
            {!! $table->table(['id' => 'table-students'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            $('#date').daterangepicker({
            });

            let $table = $('#table-students');

            $table.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    date: $('#date').val(),

                };
            });

            $('#form-filter').submit(function (e) {
                e.preventDefault();
                $table.DataTable().draw();
            });

            $('#btn-clear').click(function (e) {
                e.preventDefault();
                search: $('#search').val('');
                date: $('#date').val('');
                $table.DataTable().draw();
            });

        })
    </script>
@endpush

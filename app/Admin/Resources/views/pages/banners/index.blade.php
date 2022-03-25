@extends('admin::layouts.app')

@section('title', 'Banners')

@section('header')
    <h1 class="page-title">Banners</h1>
{{--    @can('create', \App\Models\Banners::class)--}}
        <div class="page-header-actions">
            <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.banners.create') }}">
                <i class="wb-plus" aria-hidden="true"></i>
                <span class="text hidden-sm-down">Create</span>
            </a>
        </div>
{{--    @endcan--}}
@endsection

@section('content')

<div class="card">
    <div class="card-body bg-grey-100">
        <form id="form-filter-banners" class="form-inline mb-0">
            <div class="form-group">
                <label class="sr-only" for="search">Search</label>
                <input class="form-control w-full" id="search" type="text" placeholder="Search" autocomplete="off">
            </div>
            <div class="form-group">
                <select id="status" name="status" class="form-control w-200" >
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
                <button id="btn-clear" class="btn btn-primary btn-outline"  type="button">Clear</button>
            </div>
        </form>
    </div>
    <div class="card-body">
        {!! $bannersTable->table(['id' => 'table-banners'], true) !!}
    </div>
</div>
@endsection

@push('js')
    {!! $bannersTable->scripts() !!}
@endpush

@push('js')
    <script type="text/javascript">

         $(function() {

             $("#status").select2({
                 placeholder: 'Select Status'
             });

             //Sort the banners datatable
            $('#table-banners tbody').sortable({
                update: function() {
                    let banner;
                    let banners = [];

                    $(this).find('tr').each(function() {
                        banner = $(this).find('.banner-id').val();
                        banners.push(banner);
                    });

                    $.ajax({
                        url: '{{ route('admin.banners.change-order') }}',
                        data: {
                            banners: banners
                        }
                    }).done(function() {
                        $('#table-banners').DataTable().draw();
                    });
                }
            });

             let $bannersTable = $('#table-banners');

             //Filter table
             $('#table-banners').on('preXhr.dt', function (e, settings, data) {
                 data.filter = {
                     search: $('#search').val(),
                     status: $('#status').val(),
                 };
             });

             $('#form-filter-banners').submit(function(e) {
                 e.preventDefault();
                 $bannersTable.DataTable().draw();
             });

             $('#btn-clear').click(function(e) {
                 $('#search').val('');
                 $('#status').val('all');
                 $bannersTable.DataTable().draw();
             });


             //Delete banner
             $bannersTable.on('click', '.button-delete', function (e) {
                 e.preventDefault();
                 let url = $(this).attr('href');
                 let ladda = Ladda.create(this);
                 ladda.start();

                 alertify.confirm("Are you sure?", function () {
                     $.ajax({
                         url: url,
                         type: 'DELETE',
                         dataType: 'json',
                         data: {
                             "_token": "{{ csrf_token() }}",
                         }
                     }).done(function (data, textStatus, jqXHR) {
                         toastr.success('Banner Successfully deleted');
                         $bannersTable.DataTable().draw();
                     }).fail(function(jqXHR, textStatus, errorThrown) {

                     }).always(function() {
                         ladda.stop();
                     });
                 }, function () {
                     ladda.stop();
                 });
             });
        });

    </script>
@endpush

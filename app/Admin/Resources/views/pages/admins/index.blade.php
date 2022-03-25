@extends('admin::layouts.app')
@section('title', 'Admins')

@section('header')
    <h1 class="page-title">Admins</h1>
    @can('create', \App\Models\Admin::class)
    <div class="page-header-actions">
        <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.admins.create') }}">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Create</span>
        </a>
    </div>
    @endcan
@endsection

@section('content')
    {{--<h2>Admins</h2>--}}
    <div class="card">
        <div class="card-body bg-grey-100">
            <form id="form-filter-admins" class="form-inline mb-0">
                <div class="form-group">
                    <label class="sr-only" for="inputUnlabelUsername">Search</label>
                    <input id="search" type="text" class="form-control w-full" placeholder="Search..." autocomplete="off">
                </div>

                <div class="form-group">
                    <label class="sr-only1 mr-2" for="status">Status:</label>
                    <select data-plugin="select2" placeholder="Select Status" id="status" name="status" class="w150 form-control">
                        <option value="all">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button id="btn-filter-admins" type="submit" class="btn btn-primary btn-outline">Search</button>
                </div>
                <div class="form-group">
                    <button id="btn-clear" class="btn btn-primary btn-outline"  type="button">Clear</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            {!! $html->table(['id' => 'tbl-admins'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
{!! $html->scripts() !!}
@endpush

@push('scripts')
<script>
    $(function() {
        var $table = $('#tbl-admins');

        $('#tbl-admins').on('preXhr.dt', function ( e, settings, data ) {
            data.filter = {
                search: $('#search').val(),
                status: $('#status').val(),
            };
        });

        $("#status").select2({
            width: 'resolve'
        });

        $('#form-filter-admins').submit(function(e) {
            e.preventDefault();
            $table.DataTable().draw();
        });

        $('#btn-clear').click(function(e) {
            $('#search').val('');
            $('#status').val('all');
            $table.DataTable().draw();
        });

    /*  $table.on('click', '.btn-delete', function(e) {
          e.preventDefault();

          var ladda = Ladda.create(this);
          ladda.start();

          alertify.okBtn("Delete")
          alertify.confirm("Are you sure?", function () {
              $.ajax({
                  url: this.href,
                  type: 'DELETE',
                  dataType: 'json' /!*,
                   global: false *!/ // set false to disable global event handler
              }).done(function(data, textStatus, jqXHR ) {
                  $table.DataTable().draw();
              }).fail(function(jqXHR, textStatus, errorThrown ) {

              }).always(function() {
                  ladda.stop();
              });
          }, function () {
              ladda.stop();
          });
      });*/
  })
</script>
@endpush

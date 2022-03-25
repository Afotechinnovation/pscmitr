@extends('admin::layouts.app')

@section('title', 'Packages')

@section('header')
    <h1 class="page-title">Packages</h1>
    <div class="page-header-actions">
        <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.packages.create') }}">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Create</span>
        </a>
    </div>
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
                        <select id="status" name="status" class="form-control w-200" >
                            <option></option>
                            <option value="1">Published</option>
                            <option value="0">Unpublished</option>
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
            {!! $tablePackages->table(['id' => 'table-packages'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $tablePackages->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {

            $("#status").select2({
                placeholder: 'Select Status'
            });

            let $tablePackage = $('#table-packages');

          $tablePackage.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    status: $('#status').val(),
                };
            });

            $('#form-filter').submit(function (e) {
                e.preventDefault();
                $tablePackage.DataTable().draw();
            });

            $('#btn-clear').click(function(e) {
                e.preventDefault();
               $('#search').val('');
               $('#status').prop('selectedIndex',-1).trigger( "change" );
                $tablePackage.DataTable().draw();
            });

            $tablePackage.on('click', '.button-publish', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let publish = $(this).data('publish');
                let videoCount = $(this).attr('data-video-count');
                let documentCount = $(this).attr('data-document-count');
                let testCount = $(this).attr('data-test-count');
                if(videoCount == 0 && documentCount == 0 && testCount == 0){
                    toastr.error('Package cannot publish without videos or study materials or tests');
                }
                else{
                    let ladda = Ladda.create(this);
                    ladda.start();
                    if(publish!='1'){
                        alertify.okBtn("Unpublish");
                    }
                    else{
                        alertify.okBtn("Publish")
                    }
                    alertify.confirm("Are you sure?", function () {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                publish : publish
                            }
                        }).done(function (data, textStatus, jqXHR) {
                            if(data){
                                if(data.is_published==1){
                                    toastr.success('Package published');
                                }
                                else{
                                    toastr.success('Package unpublished');
                                }

                                $('#table-packages').DataTable().draw();
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {

                        }).always(function() {
                            ladda.stop();
                        });
                    }, function () {
                        ladda.stop();
                    });
                }
            });

            $tablePackage.on('click', '.button-delete', function (e) {
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
                        if(data){
                            toastr.success('Package successfully deleted');
                            $('#table-packages').DataTable().draw();
                        }
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

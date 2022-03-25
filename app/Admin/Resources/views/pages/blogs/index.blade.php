@extends('admin::layouts.app')

@section('title', 'Blogs')

@section('header')
    <h1 class="page-title">Blogs</h1>
    <div class="page-header-actions">
        @can('create', \App\Models\Blog::class)
        <a class="btn btn-sm btn-primary btn-round" href="{{ route('admin.blogs.create') }}">
            <i class="wb-plus" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Create</span>
        </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <form id="form-filter-blogs" class="form-inline mb-0" id="form-filter">
                <div class="form-group">
                    <label class="sr-only" for="search">Search</label>
                    <input class="form-control w-full" id="search" type="text" placeholder="Search" autocomplete="off">
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
            {!! $table->table(['id' => 'table-blogs'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#table-blogs');

            $table.on('click', '.button-publish', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let publish = $(this).data('publish');
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
                                toastr.success('Blog published');
                            }
                            else{
                                toastr.success('Blog unpublished');
                            }

                            $table.DataTable().draw();
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            $table.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val()
                };
            });
            $('#form-filter-blogs').submit(function(e) {
                e.preventDefault();
                $table.DataTable().draw();
            });

            $('#btn-clear').click(function(e) {
                $('#search').val('');
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
                        toastr.success('Blog Successfully deleted');
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

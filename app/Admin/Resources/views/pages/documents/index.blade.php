@extends('admin::layouts.app')

@section('title', 'Documents')

@section('header')
    <h1 class="page-title">Documents</h1>
    <div class="page-header-actions">
        @can('create', \App\Models\Node::class)
        <button class="btn btn-sm btn-primary btn-round button-new-folder" data-toggle="modal"
                data-target="#modal-new-folder">+ Folder</button>
        @endcan
        @can('create', \App\Models\Document::class)
        <button class="btn btn-sm btn-primary btn-round" data-toggle="modal" data-target="#modal-new-file">+ File</button>
        @endcan
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
                    <button class="btn btn-primary btn-outline" id="button-filter" type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <span class="ml-2">
                        <i class="wb-arrow-left"></i>
                        <a class="previous" href="">Back</a>
                    </span>
                </div>
            </div>
            {!! $table->table(['id' => 'table-nodes'], true) !!}
        </div>
    </div>

    <div id="modal-new-folder" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm modal-center">
            <div class="modal-content">
                <form id="form-new-folder">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">NEW FOLDER</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" name="name" placeholder="Name"
                                           autocomplete="off">
                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-new-file" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md modal-center">
            <div class="modal-content">
                <form id="form-new-file" method="post" action="{{route('admin.documents.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">NEW FILE</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row mt-4">
                            <label for="folder_name" class="col-sm-2 col-form-label">File</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="parent_id" id="parent_id">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
{{--                                        <input type="file"  name="files[]" multiple class="custom-file-input @error('file') is-invalid @enderror" id="file">--}}
{{--                                        <label class="custom-file-label" for="file">Choose file</label>--}}
                                    <input id="file" name="files[]" multiple type="file" class="form-control @error('file') is-invalid @enderror"
                                           placeholder="Upload File" value="{{ old('file') }}" id="fie" autocomplete="off" >

                                    </div>
                                </div>
                                @error('files')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right">CREATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#table-nodes');

            let nodes = [];
            let nodeID = 0;
            let parentID = 0;
            let nodeType = null;

            $table.on('preXhr.dt', function (e, settings, data) {
                data.filter = {
                    search: $('#search').val(),
                    parent_id: nodeID
                };
            });

            $table.DataTable().draw();

            $table.on('click', '.node', function (e) {
                e.preventDefault();
                nodeID = $(this).data('id');
                $("#parent_id").val(nodeID);
                nodeType = parseInt($(this).data('node-type'));
                $("#parentId").val(nodeID);
                if (nodeType !== 1) {
                    return;
                }

                nodes.push({ parentID: parentID });
                $table.DataTable().draw();
            });

            $('.previous').click(function(e) {
                e.preventDefault();
                let nodeIndex = nodes.length - 1;

                if (nodeIndex >= 0) {
                    nodeID = nodes[nodeIndex].parentID;
                    nodes.splice(nodeIndex, 1);
                    $("#parent_id").val(nodeID);
                    $table.DataTable().draw();
                }
            });

            $('#form-filter').submit(function (e) {
                e.preventDefault();
                $table.DataTable().draw();
            });

            $table.on('click', '.button-delete', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let ladda = Ladda.create(this);
                ladda.start();
                alertify.okBtn('Delete');

                alertify.confirm('Are you sure?', function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': '{{ csrf_token() }}',
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        toastr.success('Node successfully deleted');
                        $table.DataTable().draw();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            let $formNewFolder = $('#form-new-folder');

            $formNewFolder.validate({
                rules: {
                    name: {
                        required: true
                    }
                }
            });

            $formNewFolder.submit(function (e) {
                if ($(this).valid()) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ route('admin.nodes.store') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            name: $('#name').val(),
                            type: 1,
                            parent_id: nodeID,
                            model: 2
                        }
                    }).done(function () {
                        $('#modal-new-folder').modal('toggle');
                        $('#name').val('');
                        toastr.success('Node successfully created');
                        $table.DataTable().draw();
                    });
                }
            });

            let $formNewFile = $('#form-new-file');

            $formNewFile.validate({
                rules: {
                    file: {
                        required: true
                    }
                }
            });


        })
    </script>
@endpush

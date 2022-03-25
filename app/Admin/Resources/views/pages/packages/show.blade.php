@extends('admin::layouts.app')

@section('title', 'Packages')

@section('header')
    <h1 class="page-title mb-2">Packages</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.packages.index')}}">Packages</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$package->name}}</li>
        </ol>
    </nav>
    <div class="page-header-actions">
        <a class="btn btn-md btn-primary  btn-round" href="{{ route('admin.packages.edit', $package->id) }}">
            <i class="icon wb-edit" aria-hidden="true"></i>
            <span class="text hidden-sm-down">Edit Package</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <div class="card-header bg-white border-bottom p-20">
                <h4 class="card-title m-0">Package Information</h4>
            </div>
            <dl class="">
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Name</dd>
                    <dt class="col-md-9">{{ $package->name }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Display Name</dd>
                    <dt class="col-md-9">{{ $package->display_name}}</dt>
                </div>

                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Course</dd>
                    <dt class="col-md-9">{{ $package->course->name }}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Subject</dd>
                    <dt class="col-md-9">{{$package->package_subjects_name}}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Chapter</dd>
                    <dt class="col-md-9">{{ $package->package_chapters_name}}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Price</dd>
                    <dt class="col-md-9">₹ {{ $package->price }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Offer Price</dd>
                    <dt class="col-md-9"> {{ $package->offer_price ? '₹ '.$package->offer_price : ''}}</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Visibility</dd>
                    <dt class="col-md-9"> {{ $package->package_visibility }}</dt>
                </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Availability</dd>
                    <dt class="col-md-9"> {{ $package->expire_on }} Days</dt>
                </div>
                <div class="row no-gutters align-items-center p-15">
                    <dd class="col-md-3 mb-sm-0">Status</dd>
                    <dt class="col-md-9">
                        @if($package->status=='enabled')
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </dt>
                </div>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 active" data-toggle="tab" href="#videos" aria-controls="videos" role="tab" aria-selected="false">Videos</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 " data-toggle="tab" href="#study-materials" aria-controls="study-materials" role="tab" aria-selected="true">Study Materials</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 " data-toggle="tab" href="#tests" aria-controls="videos" role="tab" aria-selected="true">Tests</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link font-size-16 " data-toggle="tab" href="#categories" aria-controls="categories" role="tab" aria-selected="true">Categories</a></li>

            </ul>
        </div>
        <div class="col-md-2">
            <span class="float-right">
                <a class="btn btn-md btn-primary"  href="#" data-toggle="modal" data-target="#modal-create-package-categories">
                      <i class="wb-plus" aria-hidden="true"></i>
                    <span class="text hidden-sm-down" >Add Category</span>
                </a>
            </span>
        </div>
    </div>

    <div class="nav-tabs-horizontal" data-plugin="tabs">
        <div class="tab-content">
            <div class="tab-pane active" id="videos" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Videos</h4>
                        <div class="">
                            <a class="btn btn-md btn-primary" href="#" data-toggle="modal" data-target="#modal-choose-videos-folder">
                                <i class="wb-plus" aria-hidden="true"></i>
                                <span class="text hidden-sm-down">Add Video</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $tablePackageVideos->table(['id' => 'table-package-videos'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane " id="study-materials" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Study Materials</h4>
                        <div class="">
                            <a class="btn btn-md btn-primary"  href="#" data-toggle="modal" data-target="#modal-choose-document-folder">
                                <i class="wb-plus" aria-hidden="true"></i>
                                <span class="text hidden-sm-down">Add Study Material</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $tablePackageStudyMaterials->table(['id' => 'table-package-study-materials'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tests" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Tests</h4>
                        <div class="">
                            <a class="btn btn-md btn-primary"  href="{{route('admin.packages.tests.create', $package->id)}}" >
                                <i class="wb-plus" aria-hidden="true"></i>
                                <span class="text hidden-sm-down">Add Tests</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $tablePackageTests->table(['id' => 'table-package-tests'], true) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane " id="categories" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-white border-bottom px-20 py-15">
                        <h4 class="flex-fill">Categories</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {!! $tablePackageCategories->table(['id' => 'table-package-categories'], true) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    Create Package Categories Modal--}}
    <div class="modal fade" id="modal-create-package-categories" tabindex="-1" role="dialog" aria-labelledby="videoCategoryFolderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="package-category-form" action="{{route('admin.packages.category.store', $package->id)}}">
                    @csrf
                    <div class="modal-header">
                        <h3 class="modal-title" id="videoCategoryFolderLabel">Package Category</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row mt-2">
                            <label for="category_name" class="col-sm-2 col-form-label">Name*</label>
                            <div class="col-sm-10">
                                <input type="text" name="category_name" required class="form-control @error('category_name')
                                    is-invalid @enderror" id="category_name" placeholder="Category Name">
                                    @error('category_name')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('category_name') }}
                                    </span><br>
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    Create Package Video Modal--}}
    <div class="modal fade" id="modal-choose-videos-folder" tabindex="-1" role="dialog" aria-labelledby="videoUploadModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" id="package-video-create-form" action="{{route('admin.packages.videos.store', $package->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Choose Folder</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row ">
                            <label class="col-md-3 col-form-label">Thumbnail*</label>
                            <div class="col-md-9">
                                <input type="file" id="upload" name="thumbnail" placeholder="Thumnail"  accept="image/*"  class="form-control  @error('thumbnail') is-invalid @enderror" >
                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                   {{ $errors->first('thumbnail') }}
                                </span><br>
                                @enderror
                                <span class="text-info" role="alert"  style="display: inline;">
                                    <small>** Recommended size for cover pic :Max - 700 x 500</small>
                                </span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <label class="col-md-3 col-form-label">Category*</label>
                            <div class="col-md-9">
                                <select name="package_category_id" id="package_category_id" class="source form-control
                                    category @error('package_category_id') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach($package_categories as $package_category)
                                        <option @if(old('package_category_id') == $package_category->id ) selected @endif
                                        value="{{ $package_category->id }}">{{ $package_category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <input id="videos" name="videos[]"  hidden value="" type="text" >
                        </div>

                        <div class="row mt-3 mt-5">
                            <label class="col-md-3 col-form-label">Videos</label>
                            <div class="col-md-9 mt-5">
                                <div class="table-responsive">
                                    <div id="jstree_videos"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-md-3 col-form-label">Is demo?</label>
                            <div class="col-md-9" style="padding-top: 10px">
                                <input type="checkbox" id="is_demo" @if(old('is_demo') == 1) checked @endif class="checkbox" name="is_demo" value="1"  />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-choose-videos-folder" id="btn-choose-videos-folder" disabled>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{--    Create Package Document Modal--}}
    <div class="modal fade" id="modal-choose-document-folder" tabindex="-1" role="dialog" aria-labelledby="documentUploadModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="post" id="package-document-create-form" action="{{route('admin.packages.study-materials.store',$package->id)}}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Choose Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <label class="col-md-3 col-form-label">Title*</label>
                            <div class="col-md-9 pb-5">
                                <input type="text" name="title" required class="form-control @error('title')
                                    is-invalid @enderror" id="title" placeholder="Title">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Description*</label>
                            <div class="col-md-9 pb-5">
                               <textarea name="body" required placeholder="Description"  class="form-control @error('body') is-invalid @enderror" rows="5"
                                         id="body">{{ old('body') }}</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 col-form-label">Category*</label>
                            <div class="col-md-9">
                                <select name="document_package_category_id" id="document_package_category_id" class="source form-control
                                    category @error('document_package_category_id') is-invalid @enderror" style="width: 100%;"  required>
                                    <option></option>
                                    @foreach($package_categories as $package_category)
                                        <option @if(old('document_package_category_id') == $package_category->id ) selected @endif
                                        value="{{ $package_category->id }}">{{ $package_category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <input id="documents" hidden name="documents[]"  value="" type="text" >
                        </div>

                        <div class="row mt-3 mt-5">
                            <label class="col-md-3 col-form-label">Documents</label>
                            <div class="col-md-9 mt-5">
                                <div class="table-responsive">
                                    <div id="jstree_documents"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-choose-documents-folder" id="btn-choose-documents-folder" disabled>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $tablePackageVideos->scripts() !!}
    {!! $tablePackageStudyMaterials->scripts() !!}
    {!! $tablePackageCategories->scripts() !!}
    {!! $tablePackageTests->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            'use strict';

            $(".category").select2({
                placeholder: 'Select Category'
            });
            $(".questions").select2({
                placeholder: 'Select Question'
            });

            var errors = '{{ $errors->first('category_name') }}';

            if(errors){
                $('#modal-create-package-categories').modal('show');
            }

            var errors = '{{ $errors->first('thumbnail') }}';

            if(errors){
                $('#modal-choose-videos-folder').modal('show');
                $("#modal-choose-videos-folder #videos").val(selectedVideoFolder);
            }
            $( "#live-test-date-btn" ).click(function() {

                $('#date_time').val('');
            });

            $( "#live-test-duration-btn" ).click(function() {

                $('#duration').val('');
            });


            let $tablePackageVideos = $('#table-package-videos');
            $tablePackageVideos.on('click', '.button-delete', function (e) {
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
                        toastr.success('Package video successfully deleted');
                        $tablePackageVideos.DataTable().draw();
                        $tablePackageStudyMaterials.DataTable().draw();
                        $tablePackageCategories.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            let $tablePackageStudyMaterials = $('#table-package-study-materials');
            $tablePackageStudyMaterials.on('click', '.button-delete', function (e) {
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
                        toastr.success('Package study material successfully deleted');
                        $tablePackageStudyMaterials.DataTable().draw();
                        $tablePackageVideos.DataTable().draw();
                        $tablePackageCategories.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            let $tablePackageCategories = $('#table-package-categories');
            $tablePackageCategories.on('click', '.button-delete', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                let ladda = Ladda.create(this);
                ladda.start();

                alertify.okBtn("Delete")
                alertify.confirm("Are you sure? Study Materials and Videos Under this Category will be Deleted?", function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                        }
                    }).done(function (data, textStatus, jqXHR) {
                        toastr.success('Package Categories successfully deleted');
                        $tablePackageCategories.DataTable().draw();
                        $tablePackageStudyMaterials.DataTable().draw();
                        $tablePackageVideos.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            let $tablePackageStudyTests = $('#table-package-tests');
            $tablePackageStudyTests.on('click', '.button-delete', function (e) {
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
                        toastr.success('Package Test successfully deleted');
                        $tablePackageStudyTests.DataTable().draw();
                        $tablePackageStudyMaterials.DataTable().draw();
                        $tablePackageVideos.DataTable().draw();
                    }).fail(function(jqXHR, textStatus, errorThrown) {

                    }).always(function() {
                        ladda.stop();
                    });
                }, function () {
                    ladda.stop();
                });
            });

            ///////////////////////////////////////////// CREATE PACKAGE VIDEO  ////////////////////////////////////////

            var selectedVideoFolder = '';

            let $videoModal = $('#modal-choose-videos-folder');

            $videoModal.on('show.bs.modal', function (e) {
                $('#jstree_videos').jstree({
                    'core': {
                        'multiple' : true,
                        'data': function (node, cb) {
                            var $tree = this;

                            var path = node.id === '#' ? '' : node.id;

                            console.log(path);

                            $.ajax({
                                url: '{{ route('admin.videos.index') }}',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    id: path
                                },
                                success: function (response) {
                                    var contents = response.data;
                                    contents = $.map(contents, function (file, index) {
                                        return {
                                            id: file.id,
                                            text: file.name,
                                            icon: file.type == 1 ? 'far fa-folder' : 'far fa-file',
                                            children: file.type == 1,
                                            state: {
                                                disabled: file.type == 1
                                            }
                                        }
                                    });
                                    cb.call($tree, contents);
                                },
                                error: function () {
                                    cb.call($tree, []);
                                }
                            });
                        }
                    }
                });

                $('#jstree_videos').on("changed.jstree", function (e, data) {
                    selectedVideoFolder = data.selected;
                    $videoModal.find('.btn-choose-videos-folder').prop('disabled', false);
                    $videoModal.trigger('folder_choose', [selectedVideoFolder]);
                });

            });

            $.validator.addMethod('dimention', function(value, element, param) {
                if(element.files.length == 0){
                    return true;
                }
                var width = $(element).data('imageWidth');
                var height = $(element).data('imageHeight');
                if(width == 700 && height == 500){
                    return true;
                }else{
                    return false;
                }
            },'Please upload an image with 700 x 500 pixels dimension');

            $('#upload').change(function() {
                $('#upload').removeData('imageWidth');
                $('#upload').removeData('imageHeight');
                var file = this.files[0];
                var tmpImg = new Image();
                tmpImg.src=window.URL.createObjectURL( file );
                tmpImg.onload = function() {
                    var width = tmpImg.naturalWidth;
                    var height = tmpImg.naturalHeight;

                    $('#upload').data('imageWidth', width);
                    $('#upload').data('imageHeight', height);
                }
            });

            $videoModal.find('.btn-choose-videos-folder').click(function (e) {
                $('#package-video-create-form').validate({
                    rules: {
                        package_category_id: {
                            required: true,
                        },
                        thumbnail: {
                            required: true,
                            dimention:true,
                        },
                    }
                });
                $('#package-video-create-form').submit();
            });

            $('#modal-choose-videos-folder').on('folder_choose', function (e, path,contents) {
                $("#modal-choose-videos-folder #videos").val(selectedVideoFolder);
            });

            ///////////////////////////////////////////// CREATE PACKAGE DOCUMENT  /////////////////////////////////////

            var selectedDocumentFolder = '';

            let $documentModal = $('#modal-choose-document-folder');

            $documentModal.on('show.bs.modal', function (e) {
                $('#jstree_documents').jstree({
                    'core': {
                        'multiple' : true,
                        'data': function (node, cb) {
                            var $tree = this;

                            var path = node.id === '#' ? '' : node.id;

                            console.log(path);

                            $.ajax({
                                url: '{{ route('admin.documents.index') }}',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    id: path
                                },
                                success: function (response) {
                                    var contents = response.data;
                                    contents = $.map(contents, function (file, index) {
                                        return {
                                            id: file.id,
                                            text: file.name,
                                            icon: file.type == 1 ? 'far fa-folder' : 'far fa-file',
                                            children: file.type == 1,
                                            state: {
                                                disabled: file.type == 1
                                            }
                                        }
                                    });
                                    cb.call($tree, contents);
                                },
                                error: function () {
                                    cb.call($tree, []);
                                }
                            });
                        }
                    }
                });

                $('#jstree_documents').on("changed.jstree", function (e, data) {
                    selectedDocumentFolder = data.selected;
                    $documentModal.find('.btn-choose-documents-folder').prop('disabled', false);
                    $documentModal.trigger('folder_choose', [selectedDocumentFolder]);
                });

            });

            $documentModal.find('.btn-choose-documents-folder').click(function (e) {
                $('#package-document-create-form').validate({
                    rules: {
                        title: {
                            required: true,
                        },
                        body: {
                            required: true,
                            maxlength: 200,
                        },
                    },
                });
                $('#package-document-create-form').submit();
            });


            $('#modal-choose-videos-folder').on('folder_choose', function (e, path,contents) {
                $("#modal-choose-videos-folder #videos").val(selectedVideoFolder);
            });

            $('#modal-choose-document-folder').on('folder_choose', function (e, path,contents) {

                $("#modal-choose-document-folder #documents").val(selectedDocumentFolder);
            });


            //Sort Package Test Order
            $('#table-package-tests tbody').sortable({
                update: function() {
                    let package_test;
                    let package_tests = [];

                    $(this).find('tr').each(function() {
                        package_test = $(this).find('.package-test-id').val();
                        package_tests.push(package_test);
                    });

                    $.ajax({
                        url: '{{ route('admin.packages.tests.change-order') }}',
                        data: {
                            package_tests: package_tests
                        }
                    }).done(function() {
                        $('#table-package-tests').DataTable().draw();
                    });
                }
            });

        });
    </script>
@endpush

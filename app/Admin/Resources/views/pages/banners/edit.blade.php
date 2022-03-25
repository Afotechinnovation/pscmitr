@extends('admin::layouts.app')

@section('title', 'Banners')

@section('header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col">
                <h1 class="m-0 text-dark">Banners</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('admin.banners.index')}}">Banners</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="panel">
        <form id="edit-banner" method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <div class="col-md-9 offset-md-1">
                                <div class="crop-tool">
                                    <div class="card-body"  id="image-card" >
                                        <div id="upload-demo" ></div>
                                        <div id="upload-demo-i" name="image_viewport"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input  hidden type="text"  id="image-src" value="{{$banner->image}}">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Image<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <div class="input-group mb-3">
                                    <input  class="form-control @error('image') is-invalid @enderror" type="file" accept="image/*" style="padding-top: 3px;overflow: hidden"
                                            id="upload" name="file" >
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button" id="crop-btn" >
                                            Upload Image
                                        </button>
                                    </div>
                                </div>
                                @error('image')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('image') }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="hidden-inputs-container"></div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Title </label>
                            <div class="col-md-9">
                                <input id="title" name="title" type="text" class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Title" value="{{ old('title', $banner->title) }}" autocomplete="off">
                                @error('title')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Link </label>
                            <div class="col-md-9">
                                <input id="link" name="link" type="url" class="form-control @error('link') is-invalid @enderror"
                                       placeholder="LInk" value="{{ old('link', $banner->link) }}" autocomplete="off">
                                @error('link')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-2">
                                <input type="checkbox" name="status" id="status" class="form-check @error('status') is-invalid @enderror"
                                       placeholder="" autocomplete="off" value="{{ $banner->status }}"
                                       @if($banner->status) checked @endif>
                                @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" type="submit">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            /*//validate the form
            $('#edit-banner').validate({
                rules: {
                    link: {
                        required: false,
                        url: true,
                    },
                }
            });*/

            //set the croppie viewport and image dimensions
            var uploadCrop = $('#upload-demo').croppie({
                enableExif: true,
                viewport: {
                    width: 640,
                    height: 320,
                    type: 'rectangle',
                    enableZoom : true,
                    enableResize: false,
                },
                boundary: {
                    width: 642,
                    height: 322
                }
            });

            //bind already existing banner image to the viewport
            uploadCrop.croppie('bind', {
                url: $("#image-src").val()
            });

            //on click of the crop button, crop the image and set the cropped image to the hidden input with name image
            $('#crop-btn').on('click', function (){
                uploadCrop.croppie('result', {
                    size: 'original',
                    quality: 1,
                }).then(function (resp) {
                    $(".crop-tool").attr("hidden",false);
                    $('#photo').attr('src',resp);
                    $('#edit-banner').on('submit', function () {
                        $('#hidden-inputs-container').html(`<input type="hidden" name="image" value="${resp}">`);
                    });
                });
            });

            //on file change bind the image to the viewport and trigger the crop-btn
            $('#upload').on('change', function () {
                var filename = $(this).val().split('\\').pop();
                $('#file-text').val(filename);
                var reader = new FileReader();
                reader.onload = function (e) {
                    uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        $( "#crop-btn" ).trigger( "click" );
                    });
                };
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>
@endpush

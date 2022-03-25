@extends('admin::layouts.app')

@section('title', 'Testimonial')

@section('header')
    <h1 class="page-title">Testimonial</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.testimonials.index')}}">Testimonial</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST" action="{{ route('admin.testimonials.update', $testimonial->id) }}" enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Name<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name',$testimonial->name) }}"
                                       autocomplete="off">
                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Designation<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="designation" name="designation" type="text" class="form-control @error('designation') is-invalid @enderror" placeholder="Designation"
                                       value="{{ old('designation',$testimonial->designation) }}" autocomplete="off">
                                @error('designation')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Rating<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="rating" name="rating" type="text" class="form-control @error('rating') is-invalid @enderror"
                                       placeholder="Rating" value="{{ old('rating', $testimonial->rating) }}" autocomplete="off">
                                @error('rating')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Choose Image<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input type="file" onchange="loadFile(event)"  id="image" name="image"
                                       class="form-control @error('image') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                @error('image')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                 {{ $errors->first('image') }}
                                </span><br>
                                @enderror
                                <span class="text-info" role="alert"  style="display: inline;">
                                  <small> ** Recommended Maximum size for image - 300 x 300 </small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description<span class="required">*</span> </label>
                            <div class="col-md-9">
                              <textarea name="body" placeholder="Description" class="form-control @error('body') is-invalid @enderror"
                                        rows="5"   id="description">{{ old('body', $testimonial->body) }}</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cropped-testimonial-image p-5"  >
                                    <img width="100%" src="{{ $testimonial->image }}"  data-toggle="tooltip" data-placement="top" title="Cropped Image" id="cropped-testimonial-photo" class="img-thumbnail" ><br>
                                    <p class="text-center"><small class="text-info">Testimonial Image</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $testimonial)
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                    </div>
                    @endcan
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('cropped-testimonial-photo');
            var image_src = event.target.files[0];
            if(image_src){
                image.src = URL.createObjectURL(image_src);
            }
        }
        $(function () {


            $('#form-update').validate({

                rules: {
                    name: {
                        required: true,
                        maxlength: 50
                    },
                    designation: {
                        required: true,
                    },
                    rating: {
                        required: true,
                        number: true,
                        max: 5
                    },
                    body: {
                        required: true,
                        maxlength : 250
                    },
                }
            });


        });
    </script>
@endpush

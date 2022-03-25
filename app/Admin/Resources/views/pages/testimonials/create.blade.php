@extends('admin::layouts.app')

@section('title', 'Testimonial')

@section('header')
    <h1 class="page-title">Testimonial</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.testimonials.index')}}">Testimonial</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-create" method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6 mt-1">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                       placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="designation">Designation<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control @error('designation') is-invalid @enderror" id="designation" name="designation"
                                       placeholder="Designation" value="{{ old('designation') }}" autocomplete="off">
                                @error('designation')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="rating">Rating<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating"
                                       placeholder="Rating" value="{{ old('rating') }}" autocomplete="off">
                                @error('rating')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Choose Image<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input  class="form-control @error('image') is-invalid @enderror" type="file"
                                        onchange="loadFile(event)" accept="image/*" style="padding-top: 3px;overflow: hidden"
                                        id="cover_pic" name="image"  required >
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
                                  <textarea name="body" required placeholder="Description" class="form-control @error('body') is-invalid @enderror"
                                            rows="5"   id="body">{{ old('body') }}</textarea>
                                @error('body')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 col-form-label">Body<span class="required">*</span> </label>--}}
{{--                            <div class="col-md-9" >--}}
{{--                                <div class="border" id="editorjs"></div>--}}
{{--                                @error('body')--}}
{{--                                <span class="invalid-feedback" role="alert" style="display: inline;">--}}
{{--                                  {{ $errors->first('body') }}--}}
{{--                                </span>--}}
{{--                                <br>--}}
{{--                                @enderror--}}
{{--                                <input id="body" name="body" type="hidden">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="cropped-testimonial-image p-5" hidden >
                                    <img width="100%"  id="cropped-testimonial-photo" class="img-thumbnail" ><br>
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
                    @can('create', \App\Models\Testimonial::class)
                    <div class="col-md-12">
                        <button class="btn btn-primary float-right" type="submit">CREATE</button>
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
                $('.cropped-testimonial-image').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }

        $(function () {

            $('#form-create').validate({

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
                    image: {
                        required: true,
                    },
                    body: {
                        required: true,
                        maxlength : 250
                    },

                },

            });


        });
    </script>
@endpush

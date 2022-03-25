@extends('admin::layouts.app')

@section('title', 'Package Video')

@section('header')
    <h1 class="page-title">Package Video</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.packages.show',$package_video->package_id)}}">Package Video</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST"  enctype="multipart/form-data"
              action="{{route('admin.packages.videos.update', ['package' => $package_video->package_id, 'video' => $package_video->id])}}">
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row" >
                            <label class="col-md-3 col-form-label">Thumbnail*</label>
                            <div class="col-md-9">
                                <input type="file" onchange="loadImage(event)"  id="thumbnail" name="thumbnail"
                                       class="form-control @error('thumbnail') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                @error('thumbnail')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('thumbnail') }}
                                        </span><br>
                                @enderror
                                <span class="text-info" role="alert"  style="display: inline;">
                                      <small> ** Recommended size for cover pic : Max - 700 x 500</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Category<span class="required">*</span></label>
                            <div class="col-md-9">
                                <select name="category_id" id="category" class="source form-control
                                    category @error('category_id') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach($package_categories as $package_category)
                                        <option @if(old('package_category_id') == $package_category->id ) selected @endif
                                        value="{{ $package_category->id }}"  {{ $package_category->id == $package_video->category_id ? 'selected' : '' }}>{{ $package_category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Is Demo<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input type="checkbox" name="id_demo" hidden value="0">
                                <input type="checkbox" name="is_demo" id="is_demo" class="form-check @error('is_demo') is-invalid @enderror"
                                       placeholder="" autocomplete="off" value="1"
                                       @if($package_video->is_demo) checked @endif>
                                @error('is_demo')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="row" >
                            <div class="col-md-7 ">
                                <div class="cropped-cover-image">
                                <img width="100%" src="{{ $package_video->thumbnail }}"  data-toggle="tooltip" data-placement="top" title="Cropped Cover Picture" id="cropped-thumbnail" class="img-thumbnail" >
                                    <p class="text-center"><small class="text-center text-info">Thumbnail</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                 {{--   @can('update', $package_video)--}}
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                        </div>
                  {{--  @endcan--}}
                </div>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        var loadImage = function(event) {
            var image = document.getElementById('cropped-thumbnail');
            var image_src = event.target.files[0];
            if(image_src){
                image.src = URL.createObjectURL(image_src);
            }
        }
        $(function() {
            $(".category").select2({
                placeholder: 'Select Category'
            });

            $('#form-update').validate({
                rules: {
                    category_id: {
                        required: true,
                    }
                }
            })
        });
    </script>
@endpush

@extends('admin::layouts.app')

@section('title', 'Packages')

@section('header')
    <h1 class="page-title mb-2">Edit Package</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.packages.index')}}">Packages</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$package->name}}</li>
        </ol>
    </nav>
    <style>
        .modal-open .select2-container{
            z-index: 0 !important;
        }
    </style>
@endsection


@section('content')
<div class="panel">
    <form id="form-edit-package" method="POST" action="{{ route('admin.packages.update', $package->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="panel-body pt-40 pb-5">
            <div class="row">
                <div class="col-md-7 col-lg-7">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Course<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <x-inputs.courses id="course_id" required class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                @if(!empty(old('course_id', $package->course_id)))
                                    <option value="{{ old('course_id', $package->course_id) }}" selected>
                                        {{ old('course_id_text', empty($package->course) ? '' : $package->course->name) }}</option>
                                @endif
                            </x-inputs.courses>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Subject</label>
                        <div class="col-md-8">
                            <x-inputs.subjects id="subject_id" name="subjects[]" multiple  related="#course_id" class="{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
                                @if(!empty(old('subjects')))
                                    @php
                                        $subjects = json_decode(old('subjects_text'), true);
                                    @endphp

                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject['id'] }}" selected>{{ $subject['name'] ?? '' }}</option>
                                    @endforeach
                                @else
                                    @foreach($package->package_subjects as $package_subject)
                                        <option selected value="{{ $package_subject->id }}">{{ $package_subject->name }}</option>
                                    @endforeach
                                @endif
                            </x-inputs.subjects>
                        </div>
                    </div>
                    <input hidden name="package_subjects[]" id="package_subjects">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Chapter </label>
                        <div class="col-md-8">
                            <x-inputs.package-chapters id="chapter_id"  name="chapters[]"  multiple related="#subject_id" class="{{ $errors->has('chapter_id') ? ' is-invalid' : '' }}">
                                @if(!empty(old('chapters')))
                                    @php
                                    $chapters = json_decode(old('chapters_text'), true);
                                    @endphp

                                    @foreach($chapters as $chapter)
                                    <option value="{{ $chapter['id'] }}" selected>{{ $chapter['name'] ?? '' }}</option>
                                    @endforeach
                                @else
                                    @foreach($package->package_chapters as $package_chapter)
                                        <option selected value="{{ $package_chapter->id }}">{{ $package_chapter->name }}</option>
                                    @endforeach
                                @endif
                            </x-inputs.package-chapters>
                        </div>
                    </div>
                    <input hidden name="package_chapters[]" id="package_chapters">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Highlights<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <select name="package_highlights[]" id="package_highlights" multiple class="form-control
                                @error('package_highlights') is-invalid @enderror" required style="width: 100%;" >
                                <option></option>
                                @foreach($highlights as $highlight)
                                    <option
                                        @foreach($package->package_highlights as $package_highlight)
                                            @if($package_highlight->pivot->highlight_id == $highlight->id)
                                                selected
                                            @endif
                                        @endforeach
                                    value="{{$highlight->id}}">{{ $highlight->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Name<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <input id="name" name="name" type="text" required
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Package name" value="{{ old('name', $package->name) }}"
                                   autocomplete="off">
                            @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Display Name<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <input id="display_name" name="display_name" type="text" required
                                   class="form-control @error('display_name') is-invalid @enderror"
                                   placeholder="Package's display name" value="{{ old('display_name', $package->display_name) }}"
                                   autocomplete="off">

                            @error('display_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Image*</label>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input  class="form-control col-md-10" value=" {{ $package->image }} " required  type="text" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                        id="upload-file" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" data-toggle="modal"  data-target="#imageUploadModal" type="button" id="upload-image-btn" >
                                        Upload Image
                                    </button>
                                </div>
                                @error('image')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('image') }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="hidden-image-container"></div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Cover Picture*</label>
                        <div class="col-md-8">
                            <input  class="form-control @error('cover_pic') is-invalid @enderror" type="file"
                                    onchange="loadFile(event)" accept="image/*" style="padding-top: 3px;overflow: hidden"
                                    id="cover_pic" name="cover_pic"   >
                            @error('cover_pic')
                            <span class="invalid-feedback" role="alert" style="display: inline;">
                                        {{ $errors->first('cover_pic') }}
                                    </span><br>
                            @enderror
                            <span class="text-info" role="alert"  style="display: inline;">
                                    <small>** Recommended size for cover pic - 1200 x 600</small>
                                </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Price<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <input id="price" name="price" type="number" step="any"  required
                                   class="form-control @error('price') is-invalid @enderror"
                                   placeholder="Price" value="{{ old('price', $package->price) }}"
                                   autocomplete="off">
                            @error('price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Offer Price </label>
                        <div class="col-md-8">
                            <input id="offer_price" name="offer_price" type="number" step="any"
                                   class="form-control @error('offer_price') is-invalid @enderror"
                                   placeholder="Offer Price" value="{{ old('offer_price', $package->offer_price) }}"
                                   autocomplete="off">
                            @error('offer_price')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <input type="text" hidden id="valid_from" value="{{ $package->visible_from_date }}">
                        <input type="text" hidden id="valid_to" value="{{ $package->visible_to_date }}">
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Visibility<span class="required">*</span></label>
                        <div class="col-md-8">
                            <input id="visibility" name="visibility" type="text" required
                                   class="form-control @error('visibility') is-invalid @enderror"
                                   placeholder="Visibility" value="{{ old('visibility') }}"
                                   autocomplete="off">
                            @error('visibility')
                            <span class="invalid-feedback" role="alert" style="display: inline;">
                                    {{ $errors->first('visibility') }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Expire In<span class="required">*</span></label>
                        <div class="col-md-8">
                            <div class="input-group mb-3">
                                <input id="expire_on" name="expire_on" type="number" min="0" required
                                       class="form-control @error('expire_on') is-invalid @enderror"
                                       placeholder="EXpire In" value="{{ old('expire_on', $package->expire_on ) }}"
                                       autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary"  type="button" id="upload-image-btn" >
                                        Days
                                    </button>
                                </div>
                                @error('expire_on')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                    {{ $errors->first('expire_on') }}
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Description<span class="required">*</span> </label>
                        <div class="col-md-9">
                              <textarea name="description" placeholder="Description" class="form-control @error('description') is-invalid @enderror"
                                        rows="5"   id="description">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Contents Included<span class="required">*</span> </label>
                        <div class="col-md-9">
                            <div class="border @error('package_content') is-invalid @enderror" id="packageContentId"></div>
                            @error('package_content')
                            <span class="invalid-feedback" role="alert" style="display: inline;">
                                 {{ $errors->first('package_content') }}
                            </span>
                            <br>
                            @enderror
                            <input id="package_content" name="package_content" type="hidden">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Requirements<span class="required">*</span></label>
                        <div class="col-md-9">
                            <div class="border @error('requirements') is-invalid @enderror" id="editorRequirementId"></div>
                            @error('requirements')
                            <span class="invalid-feedback" role="alert" style="display: inline;">
                                 {{ $errors->first('requirements') }}
                            </span>
                            <br>
                            @enderror
                            <input id="requirements" name="requirements" type="hidden">
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-5">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="cropped-image p-5"  >
                                <img  src="{{ $package->image_url }}"   id="cropped-image" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Image</small></p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="cropped-cover-image p-5"  >
                                <img src="{{ $package->cover_pic }}"  id="cropped-cover-photo" class="img-thumbnail" >
                                <p class="text-center"><small class="text-center text-info">Cover Picture</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal" id="imageUploadModal"  role="dialog" aria-labelledby="imageUploadModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="imageUploadModalLabel">Upload Image</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="crop-tool">
                                    <div class="card-body"  id="image-card" >
                                        <div id="upload-package-image" ></div>
                                        <div id="upload-package-image-i" name="image_viewport"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3"> </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <input  class="form-control" required type="file" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                            id="package-image" name="file"  accept="image/*"  @error('file') is-invalid @enderror>
                                    @error('file')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                             {{ $errors->first('file') }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  id="crop-image-btn">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>

        var loadFile = function(event) {
            var image = document.getElementById('cropped-cover-photo');
            var image_src = event.target.files[0];
            if(image_src){
                $('.cropped-cover-image').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }

        $("#package_highlights").select2({
            placeholder: 'Select Highlights'
        });

        $("#visibility").daterangepicker({
            startDate: $('#valid_from').val(),
            endDate: $('#valid_to').val(),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

        $(function() {

            $('#form-edit-package').validate({
                ignore: '#editorjs *',
                course_id: {
                    required: true,
                },
                package_highlights: {
                    required: true,
                },
                name: {
                    required: true,
                    maxlength: 255
                },
                display_name: {
                    required: true,
                    maxlength: 255
                },
                title: {
                    required: true,
                    maxlength: 255
                },
                description: {
                    required: true,
                },
                price: {
                    required: true,
                    numeric: true,
                },
                visibility: {
                    required: true,
                },
                expire_on: {
                    required: true,
                    numeric: true,
                },
            });

            let package_requirements = @json($package->requirements);
            let requirements_data = JSON.parse(package_requirements);

            const requirements = new EditorJS({
                holder : 'editorRequirementId',
                placeholder: 'Requirements',
                data: requirements_data
            });

            let package_contents = @json($package->package_content);
            let package_content_data = JSON.parse(package_contents);

            const package_content = new EditorJS({
                holder : 'packageContentId',
                placeholder: 'Contents Included',
                data: package_content_data
            });

            $( "#subject_id" ).change(function() {
                var subjects = $( "#subject_id" ).val();
                $('#package_subjects').val(subjects);
            });

            $( "#chapter_id" ).change(function() {
                var chapters = $( "#chapter_id" ).val();
                $('#package_chapters').val(chapters);
            });

            //image upload
            $('input[type=file]').change(function() {
                $('.crop-tool ').attr("hidden", false);
            });

            //set the croppie viewport and image dimensions
            var cropPackageImage = $('#upload-package-image').croppie({
                enableExif: true,
                viewport: {
                    width: 370,
                    height: 250,
                    type: 'rectangle',
                    enableZoom : true,
                    enableResize: false,
                },
                boundary: {
                    width: 375,
                    height: 255
                }
            });

            //on click of the crop button, crop the image and set the cropped image to the hidden input with name image
            $('#crop-image-btn').on('click', function (){
                cropPackageImage.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    $(".cropped-image").attr("hidden",false);
                    $('#cropped-image').attr('src', resp);
                    $('#hidden-image-container').html(`<input type="hidden" name="image" value="${ resp }">`);
                });
            });

            //on file change bind the image to the viewport and trigger the crop-image-btn
            $('#package-image').on('change', function () {

                var fileExtension = ['jpeg', 'jpg', 'png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only formats are allowed : "+fileExtension.join(', '));
                    // alert();
                    $('#package-image').val('')
                }
                else{
                    var filename = $(this).val().split('\\').pop();
                    $('#file-text').val(filename);
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        cropPackageImage.croppie('bind', {
                            url: e.target.result
                        }).then(function(){
                            $( "#crop-image-btn" ).trigger( "click" );
                        });
                    };
                    reader.readAsDataURL(this.files[0]);

                    // To show filename in input area
                    $(this).prev('#upload-file').clone();
                    var file = $('#package-image')[0].files[0].name;
                    if(file) {
                        $('#upload-file-error').hide();
                        $('#upload-file').css('border-color', '#3e9a12');
                    }
                    $('#upload-file').val(file);
                }


            });

            $('#form-edit-package').on('submit', function () {
                requirements.save().then((data) => {
                    $('#requirements').val(JSON.stringify(data));
                }).catch((error) => {
                    console.log(error);
                });
                package_content.save().then((data) => {
                    $('#package_content').val(JSON.stringify(data));
                }).catch((error) => {
                    console.log(error);
                });
            });
        });
    </script>
@endpush

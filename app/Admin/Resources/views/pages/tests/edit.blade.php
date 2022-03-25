@extends('admin::layouts.app')

@section('title', 'Test')

@section('header')
    <h1 class="page-title">Test</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.tests.index')}}"> Tests</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
        <form id="form-update" method="POST" action="{{ route('admin.tests.update',  $test->id) }}"
              enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Course<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <x-inputs.courses id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('course_id', $test->course_id)))
                                        <option value="{{ old('course_id', $test->course_id) }}" selected>
                                            {{ old('course_id_text', empty($test->course) ? '' : $test->course->name) }}</option>
                                    @endif
                                </x-inputs.courses>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Category<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <select name="category" id="category"  class="form-control
                                    @error('category') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach( $testCategories as $testCategory )
                                        <option @if ( (old('category') == $testCategory->id) || $test->category_id == $testCategory->id ) selected @endif
                                        value="{{ $testCategory->id }}">{{ $testCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Name<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Total Question" value="{{ old('name',$test->name) }}"
                                       autocomplete="off">

                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="hidden-image-container"></div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Image*</label>
                            <div class="col-md-9">
                                <div class="input-group mb-3">
                                    <input  class="form-control col-md-10"  type="text" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                            id="upload-file" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" data-toggle="modal"  data-target="#imageUploadModal" type="button" id="upload-image-btn" >
                                            Upload Image
                                        </button>
                                    </div>
                                    @error('file')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('file') }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="display_name" class="col-md-3 col-form-label">Display Name*</label>
                            <div class="col-sm-9">
                                <input type="text" name="display_name"  required class="form-control @error('display_name')
                                    is-invalid @enderror" value="{{ old('display_name', $test->display_name) }}" id="display_name" placeholder="Display Name" >
                                @error('display_name')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('display_name') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Correct Answer Mark<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="correct_answer_marks" name="correct_answer_marks" type="text" step="any"
                                       class="form-control @error('correct_answer_marks') is-invalid @enderror"
                                       placeholder="Correct Answer Marks" value="{{ old('correct_answer_marks',$test->correct_answer_marks) }}"
                                       autocomplete="off">

                                @error('correct_answer_marks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Questions<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="total_questions" name="total_questions" type="text"
                                       class="form-control @error('total_questions') is-invalid @enderror"
                                       placeholder="Total Question" value="{{ old('total_questions',$test->total_questions) }}"
                                       autocomplete="off">

                                @error('total_questions')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Marks<span class="required"></span> </label>
                            <div class="col-md-9">
                                <input id="total_marks" name="total_marks" type="number" readonly
                                       class="form-control @error('total_marks') is-invalid @enderror"
                                       placeholder="Total Marks" value="{{ $test->total_marks}}"
                                       autocomplete="off">
                                @error('total_marks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cut_off_marks" class="col-md-3 col-form-label">Cut Off Marks*</label>
                            <div class="col-md-9">
                                <input type="text" name="cut_off_marks"  required class="form-control @error('cut_off_marks')
                                    is-invalid @enderror" id="cut_off_marks" placeholder="Cut Off Marks"
                                       value="{{old('cut_off_marks', $test->cut_off_marks)}}">
                                @error('cut_off_marks')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('cut_off_marks') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Total Time<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="total_time" name="total_time" type="time"  step="any"
                                       class="form-control @error('total_time') is-invalid @enderror"
                                       placeholder="Total Time" value="{{ old('total_time',$test->total_time) }}"
                                       autocomplete="off">

                                @error('total_time')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Negative Marks<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="negative_marks" name="negative_marks" type="text" step="any"
                                       class="form-control @error('negative_marks') is-invalid @enderror"
                                       placeholder="Negative Marks" value="{{ old('negative_marks',$test->negative_marks) }}"
                                       autocomplete="off">

                                @error('negative_marks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description*</label>
                            <div class="col-md-9 pb-5">
                               <textarea name="description" required placeholder="Description"  class="form-control @error('description')
                                   is-invalid @enderror" rows="5" id="description">{{ old('description', $test->description ) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-7">
                                <div class="cropped-image p-5">
                                    <img height="95%" src="{{ $test->image }}"  data-toggle="tooltip" data-placement="top" title="Cropped Image" id="cropped-image" class="img-thumbnail" ><br>
                                    <p class="text-center"><small class="text-info">Image</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $test)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" name="submit" value="update_tests" type="submit">UPDATE</button>
                        </div>
                    @endcan
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
                                            <div id="upload-blog-image" ></div>
                                            <div id="upload-blog-image-i" name="image_viewport"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input  class="form-control" required type="file" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                                id="blog-image" name="file"  accept="image/*"  @error('file') is-invalid @enderror>
                                        @error('file')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                             {{ $errors->first('file') }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" id="image-src" value="{{$test->image}}">
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

        $("#correct_answer_marks").on("keyup", function() {
            correct_answer_mark = $(this).val();
            $("#correct_answer_marks").val(correct_answer_mark);

            $("#total_questions").trigger("change");

        });
        $("#total_questions").on("keyup", function() {
            total_questions =  $(this).val();
            $("#total_questions").val(total_questions);

            $("#correct_answer_marks").trigger("change");

        });

        $('#correct_answer_marks').on('change', function(){

            input_total_questions =   $("#total_questions").val();
            correct_answer_mark = $("#correct_answer_marks").val();

            total_marks = correct_answer_mark * input_total_questions;
            $('#total_marks').val(total_marks);

        });

        $('#total_questions').on('change',function(){
            total_questions =  $('#total_questions').val();
            input_correct_answer_mark = $('#correct_answer_marks').val();

            total_marks = total_questions * input_correct_answer_mark;
            $('#total_marks').val(total_marks);


        });

        $("#questions").select2({
            placeholder: ' Select Questions'
        });

        $("#category").select2({
            placeholder: 'Select Category'
        });

        $(function() {
            $('#form-update').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    total_questions: {
                        required: true,
                        number: true,
                        min : 1
                    },
                    total_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    total_time: {
                        required: true,
                        number: true
                    },
                    negative_marks: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    correct_answer_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    display_name: {
                        required: true,
                        maxlength: 100
                    },
                    description: {
                        required: true,
                        maxlength: 350
                    },
                    cut_off_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },

                }
            })

            //////////////////////////////////////////////// Crop Blog Image ///////////////////////////////////////////
            //set the croppie viewport and image dimensions
            var cropBlogImage = $('#upload-blog-image').croppie({
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

            //bind already existing image to the viewport
            cropBlogImage.croppie('bind', {
                url: $("#image-src").val()
            });

            //on click of the crop button, crop the image and set the cropped image to the hidden input with name image
            $('#crop-image-btn').on('click', function (){
                cropBlogImage.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {
                    $(".cropped-image").attr("hidden",false);
                    $('#cropped-image').attr('src', resp);
                    $('#hidden-image-container').html(`<input type="hidden" name="image" value="${ resp }">`);
                });
            });

            //on file change bind the image to the viewport and trigger the crop-image-btn
            $('#blog-image').on('change', function () {

                var fileExtension = ['jpeg', 'jpg', 'png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only formats are allowed : "+fileExtension.join(', '));
                    // alert();
                    $('#blog-image').val('')
                }
                else {
                    var filename = $(this).val().split('\\').pop();
                    $('#file-text').val(filename);
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        cropBlogImage.croppie('bind', {
                            url: e.target.result
                        }).then(function(){
                            $( "#crop-image-btn" ).trigger( "click" );
                        });
                    };
                    reader.readAsDataURL(this.files[0]);

                    // to filename in input Area

                    var i = $(this).prev('#upload-file').clone();
                    var file = $('#blog-image')[0].files[0].name;
                    $('#upload-file').val(file);

                }

            });

        });
    </script>
@endpush

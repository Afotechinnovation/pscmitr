@extends('admin::layouts.app')

@section('title', 'Tests')

@section('header')
    <h1 class="page-title">Tests</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.tests.index')}}">Tests</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
        <form id="form-create" method="POST" action="{{ route('admin.tests.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Course<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <x-inputs.courses id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('course_id')))
                                        <option value="{{ old('course_id') }}" selected>{{ old('course_id_text') }}</option>
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
                                        <option @if (old('category') == $testCategory->id) selected @endif
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
                                       placeholder="Test Name" value="{{ old('name') }}"
                                       autocomplete="off">

                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Image<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <div class="input-group mb-3">
                                    <input  class="form-control col-md-10 required @error('image') is-invalid  @enderror"   type="text" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                            id="upload-file" readonly >
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" data-toggle="modal"  data-target="#imageUploadModal"  type="button" id="upload-image-btn" >
                                            Upload Image
                                        </button>
                                    </div>
                                    @error('image')
                                    <span class="invalid-feedback " role="alert" style="display: inline;">
                                        {{ $errors->first('image') }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="display_name" class="col-md-3 col-form-label">Display Name*</label>
                            <div class="col-sm-9">
                                <input type="text" name="display_name"  required class="form-control @error('display_name')
                                    is-invalid @enderror" id="display_name" placeholder="Display Name" value="{{old('display_name')}}">
                                @error('display_name')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('display_name') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correct_answer_marks" class="col-md-3 col-form-label">Correct Answer Marks*</label>
                            <div class="col-md-9">
                                <input type="text"  step="any" name="correct_answer_marks" required class="form-control @error('correct_answer_marks')
                                    is-invalid @enderror" id="correct_answer_marks" placeholder="Correct Answer Marks"
                                       value="{{old('correct_answer_marks')}}" >
                                @error('correct_answer_marks')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('correct_answer_marks') }}
                                    </span><br>
                                @enderror
                                <input type="hidden" id="input_correct_answer_mark"  value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_questions" class="col-md-3 col-form-label">Total Questions*</label>
                            <div class="col-sm-9">
                                <input type="text" name="total_questions"  required class="form-control @error('total_questions')
                                    is-invalid @enderror" id="total_questions" placeholder="Total Questions" value="{{old('total_questions')}}">
                                @error('total_questions')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('total_questions') }}
                                    </span><br>
                                @enderror
                                <input type="hidden" id="input_total_questions"  value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_marks" class="col-md-3 col-form-label">Total Marks</label>
                            <div class="col-sm-9">
                                <input type="text" readonly name="total_marks" required class="form-control @error('total_marks')
                                    is-invalid @enderror" id="total_marks" placeholder="Total Marks" value="{{old('total_marks')}}" >
                                @error('total_marks')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('total_marks') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_questions" class="col-md-3 col-form-label">Cut Off Marks*</label>
                            <div class="col-sm-9">
                                <input type="text" name="cut_off_marks"  required class="form-control @error('cut_off_marks')
                                    is-invalid @enderror" id="cut_off_marks" placeholder="Cut Off Marks" value="{{old('cut_off_marks')}}">
                                @error('cut_off_marks')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('cut_off_marks') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_time" class="col-md-3 col-form-label">Total Time*</label>
                            <div class="col-sm-9">
                                <input type="time" name="total_time" required class="form-control @error('total_time')
                                    is-invalid @enderror"  value="{{old('total_time')}}" id="total_time" placeholder="Total Time">
                                @error('total_time')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('total_time') }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="negative_marks" class="col-md-3 col-form-label">Negative Marks*</label>
                            <div class="col-md-9">
                                <input type="number" min="0" step="any" name="negative_marks" required class="form-control @error('negative_marks')
                                    is-invalid @enderror" id="negative_marks" placeholder="Negative Marks" value="{{old('negative_marks')}}" >
                                @error('negative_marks')
                                <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('negative_marks') }}
                                    </span><br>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_questions" class="col-md-3 col-form-label">Is Live Test</label>
                            <div class="col-md-2">
                                <input type="hidden" name="is_live_test" value="0">
                                <input type="checkbox" name="is_live_test" id="is_live_checkbox" class="form-check @error('is_live_test') is-invalid @enderror"
                                       placeholder="" autocomplete="off" value="1" @if(old('is_live_test') == 'checked') checked @endif>
                                @error('is_live_test')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div id="live_test_div" hidden >
                            <div class="form-group row">
                                <label for="total_questions" class="col-md-3 col-form-label">Live Test Date and Time</label>
                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <input type="datetime-local" name="live_test_date_time"  class="form-control @error('live_test_date_time')
                                            is-invalid @enderror" id="live_test_date_time" placeholder="Date and Time" value="{{old('live_test_date_time')}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="live-test-date-btn" >
                                                Cancel
                                            </button>
                                        </div>
                                        @error('date_time')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('date_time') }}
                                        </span><br>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="live_test_duration" class="col-md-3 col-form-label">Live Test Duration</label>
                                <div class="col-md-9">
                                    <div class="input-group mb-3">
                                        <input type="time" name="live_test_duration"  class="form-control @error('live_test_duration')
                                            is-invalid @enderror" id="live_test_duration" placeholder="Live Test Duration" value="{{old('live_test_duration')}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" id="live-test-duration-btn" >
                                                Cancel
                                            </button>
                                        </div>
                                        @error('live_test_duration')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('live_test_duration') }}
                                    </span><br>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Description*</label>
                            <div class="col-md-9 pb-5">
                               <textarea name="description" required placeholder="Description"  class="form-control @error('description')
                                   is-invalid @enderror" rows="5" id="description">{{ old('description') }}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="hidden-image-container"></div>
                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-7">
                                <div class="cropped-image p-5" hidden >
                                    <img width="100%"  id="cropped-image" class="img-thumbnail" ><br>
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
                    @can('create', \App\Models\Test::class)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">CREATE</button>
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
                                            <div id="upload-test-image" ></div>
                                            <div id="upload-test-image-i" name="image_viewport"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input  class="form-control" required type="file" placeholder="Upload Image" style="padding-top: 3px;overflow: hidden"
                                                id="test-image" name="file"  accept="image/*"  @error('file') is-invalid @enderror>
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
                    <button type="button" class="btn btn-secondary" id="close-modal" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(function() {

            $("#correct_answer_marks").on("keyup", function() {
                correct_answer_mark = $(this).val();
                $("#input_correct_answer_mark").val(correct_answer_mark);

                $("#total_questions").trigger("change");

            });
            $("#total_questions").on("keyup", function() {
                total_questions =  $(this).val();
                $("#input_total_questions").val(total_questions);

                $("#correct_answer_marks").trigger("change");

            });

            $('#correct_answer_marks').on('change', function(){

                input_total_questions =   $("#input_total_questions").val();
                correct_answer_mark = $("#correct_answer_marks").val();

                total_marks = correct_answer_mark * input_total_questions;
                $('#total_marks').val(total_marks);

            });

            $('#total_questions').on('change',function(){
                total_questions =  $('#total_questions').val();
                input_correct_answer_mark = $('#input_correct_answer_mark').val();

                total_marks = total_questions * input_correct_answer_mark;
                $('#total_marks').val(total_marks);

            });

            $("#category").select2({
                placeholder: 'Select Category'
            });

            $('#form-create').validate({
                rules: {
                    category: {
                        required: true,
                    },
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    course_id: {
                        required: true,
                    },
                    total_questions: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    total_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    cut_off_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    total_time: {
                        required: true,
                    },
                    correct_answer_marks: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    negative_marks: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    description: {
                        required: true,
                        maxlength: 350
                    },
                    display_name: {
                        required: true,
                        maxlength: 100
                    },
                    live_test_duration:{
                        required:"#is_live_checkbox:checked"
                    },
                    date_time:{
                        required:"#is_live_checkbox:checked"
                    },
                    image: {
                        required: true,
                    },

                }
            })

            //////////////////////////////////////////////// Crop Blog Image ///////////////////////////////////////////
            //set the croppie viewport and image dimensions
            var cropBlogImage = $('#upload-test-image').croppie({
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
            $('#test-image').on('change', function () {
                var fileExtension = ['jpeg', 'jpg', 'png'];
                if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                    // alert("Only formats are allowed : "+fileExtension.join(', '));
                    // alert();
                    $('#test-image').val('')
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

                    // to show filename in input Area

                    var i = $(this).prev('#upload-file').clone();
                    var file = $('#test-image')[0].files[0].name;
                    if(file) {
                        $('#upload-file-error').hide();
                        $('#upload-file').css('border-color', '#3e9a12');
                    }
                    $('#upload-file').val(file);
                }

            });

            $('#live-test-date-btn').click(function (e) {
                e.preventDefault();
                $('#date_time').val('');

            });
            $('#live-test-duration-btn').click(function (e) {
                e.preventDefault();
                $('#live_test_duration').val('');

            });

            $('#is_live_checkbox').click(function () {

                if($(this).is(":checked")) {
                    $('#live_test_div').attr("hidden", false);
                }
                else {
                    $('#live_test_div').attr("hidden", true);
                }

            });

        });
    </script>
@endpush

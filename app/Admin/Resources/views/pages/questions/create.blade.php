@extends('admin::layouts.app')

@section('title', 'Question')

@section('header')
    <h1 class="page-title">Question</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.questions.index')}}">All questions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-create" method="POST" action="{{ route('admin.questions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Course</label>
                            <div class="col-md-4">
                                <x-inputs.courses id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('course_id', $course->id ?? null)))
                                        <option value="{{ old('course_id', $course->id) }}" selected>
                                            {{ old('course_id_text', empty($course) ? '' : $course->name) }}</option>
                                    @endif
                                </x-inputs.courses>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Subject</label>
                            <div class="col-md-4">
                                <x-inputs.subjects id="subject_id" related="#course_id" class="{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('subject_id', $subject->id ?? null)))
                                        <option value="{{ old('subject_id', $subject->id) }}" selected>
                                            {{ old('subject_id_text', empty($subject) ? '' : $subject->name) }}</option>
                                    @endif
                                </x-inputs.subjects>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Chapter </label>
                            <div class="col-md-4">
                                <x-inputs.chapters id="chapter_id" related="#subject_id" class="{{ $errors->has('chapter_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('chapter_id', $chapter->id ?? null)))
                                        <option value="{{ old('chapter_id', $chapter->id) }}" selected>
                                            {{ old('chapter_id_text', empty($chapter) ? '' : $chapter->name) }}</option>
                                    @endif
                                </x-inputs.chapters>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Difficulty Level<span class="required">*</span> </label>
                            <div class="col-md-4">
                                <select name="difficulty_level" id="difficulty_level"  class="form-control
                                        @error('difficulty_level') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach( \App\Models\Question::$difficultyLevels as $difficultyLevel )
                                        <option @if(old("difficulty_level") == $difficultyLevel['value']) selected @endif
                                        @if($level == $difficultyLevel['value']) selected @endif
                                        value="{{ $difficultyLevel['value'] }}">{{ $difficultyLevel['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Type<span class="required">*</span> </label>
                            <div class="col-md-4">
                                <select name="question_type" id="question_type"  class="form-control
                                        @error('question_type') is-invalid @enderror" required style="width: 100%;" >
                                    <option></option>
                                    @foreach( \App\Models\Question::$questionTypes as $questionType )
                                        <option  @if(old("question_type") == $questionType['value']) selected @endif
                                        @if($type == $questionType['value']) selected @endif
                                        value="{{ $questionType['value'] }}">{{ $questionType['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Question Image</label>
                            <div class="col-md-4">
                                <input type="file" class="form-control" id="file" onchange="loadImage(event)"  name="file"  accept="image/*" >
                                @error('file')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                       <div class="form-group row">
                            <label class="col-md-2 col-form-label">Question<span class="required">*</span> </label>
                            <div class="col-md-8">
                                <textarea class="question-editor form-control  @error('question') is-invalid @enderror"  id="question" name="question" rows="14" >{{ old('question') }}</textarea>
                                @error('question')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                       </div>
                        <div id="section-options" @if(old('question_type') != 1) hidden @endif>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option 1<span class="required">*</span> </label>
                                <div class="col-md-8">
                                    <textarea class="form-control objective-option" id="option1" name="options[]" rows="4">{{ old('options.1') }}</textarea>
                                    @if( $errors->first('options.1') )
                                    <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.1') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2" style="padding-top: 85px" >
                                   <input type="checkbox" id="correct_option1" @if(old('correct_option') == 1) checked @endif class="checkbox" name="correct_option" value="1"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Image 1</label>
                                <div class="col-md-3">
                                    <input type="file" class="form-control"  onchange="loadFile1(event)" id="image"  name="images[]"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option 2<span class="required">*</span> </label>
                                <div class="col-md-8">
                                    <textarea class="form-control objective-option" id="option2" name="options[]" rows="4">{{ old('options.2') }}</textarea>
                                    @if( $errors->first('options.2') )
                                        <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.2') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2" style="padding-top: 85px">
                                    <input type="checkbox" id="correct_option2" @if(old('correct_option') == 2) checked @endif class="checkbox" name="correct_option" value="2" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"> Image 2</label>
                                <div class="col-md-3">
                                    <input type="file" class="form-control" id="image" onchange="loadFile2(event)"   name="images[]"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option 3<span class="required">*</span> </label>
                                <div class="col-md-8">
                                    <textarea class="form-control objective-option"  id="option3" name="options[]" rows="4">{{ old('options.3') }}</textarea>
                                    @if( $errors->first('options.3') )
                                        <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.3') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2" style="padding-top: 85px">
                                    <input type="checkbox" id="correct_option3" @if(old('correct_option') == 3) checked @endif class="checkbox" name="correct_option" value="3" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"> Image 3</label>
                                <div class="col-md-3">
                                    <input type="file" class="form-control" id="image" onchange="loadFile3(event)"  name="images[]"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option 4<span class="required">*</span> </label>
                                <div class="col-md-8">
                                    <textarea class="form-control objective-option" id="option4" name="options[]" rows="4">{{ old('options.4') }}</textarea>
                                    @if( $errors->first('options.4') )
                                        <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.4') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2" style="padding-top: 85px">
                                    <input type="checkbox" id="correct_option4" @if(old('correct_option') == 4) checked @endif class="checkbox" name="correct_option" value="4" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label"> Image 4</label>
                                <div class="col-md-3">
                                    <input type="file" class="form-control" id="image" onchange="loadFile4(event)" name="images[]"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option 5</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" id="option5" name="options[]" rows="4">{{ old('options.5') }}</textarea>
                                    @error('options.5')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2" style="padding-top: 85px">
                                    <input type="checkbox" id="correct_option5" @if(old('correct_option') == 5) checked @endif class="checkbox" name="correct_option" value="5" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Image 5</label>
                                <div class="col-md-3">
                                    <input type="file" class="form-control" id="image"  name="images[]" onchange="loadFile5(event)"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="section-true-or-false" @if(old('question_type') != 2) hidden @endif  >
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option<span class="required">*</span> </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 mt-2 pl-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_true" id="true" checked value="1">
                                            <label class="form-check-label" for="true">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_true" id="false" value="0" >
                                            <label class="form-check-label" for="false">False</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option  Image</label>
                                <div class="col-md-4">
                                    <input type="file" class="form-control" id="image" onchange="loadOptionImage(event)" name="image"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Exaplanation </label>
                            <div class="col-md-8">
                                <textarea class="form-control  @error('explanation') is-invalid @enderror"  id="explanation" name="explanation" rows="14" >{{ old('explanation') }}</textarea>
                                @error('explanation')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="question-image-preview-row p-5" hidden >
                            <img width="100%"  id="question-image-preview" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Question Image</small></p>
                        </div>
                        <div id="true-or-false-image-preview-div">
                            <div class="true-or-false-option-image-preview-row p-5" @if(old('question_type') != 2) hidden @endif >
                                <img width="100%"  id="true-or-false-option-image-preview" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info"> Option Image</small></p>
                            </div>
                        </div>

                        <div id="objective-image-preview-div" >
                            <div class=" objective-option-1-row p-5" @if(old('question_type') != 1) hidden @endif  >
                                <img width="100%"  id="objective-option-1" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Option 1 Image</small></p>
                            </div>
                            <div class=" objective-option-2-row p-5" hidden >
                                <img width="100%"  id="objective-option-2" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Option 2 Image</small></p>
                            </div>
                            <div class=" objective-option-3-row p-5" hidden >
                                <img width="100%"  id="objective-option-3" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Option 3 Image</small></p>
                            </div>
                            <div class=" objective-option-4-row p-5" hidden >
                                <img width="100%"  id="objective-option-4" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Option 4 Image</small></p>
                            </div>
                            <div class=" objective-option-5-row p-5" hidden >
                                <img width="100%"  id="objective-option-5" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Option 5 Image</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row justify-content-end">
                    @can('create', \App\Models\Question::class)
                        <div class="col-md-11">
                            <button class="btn btn-primary float-right " id="create-button" type="submit">CREATE</button>
                        </div>
                        <div class="col-md-1">
                            <input type="hidden" name="create_and_new" value="0" id="create-and-new">
                            <button class="btn btn-primary float-right" id="create-new" type="button">CREATE NEW</button>
                        </div>
                    @endcan
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
{{--    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>--}}
{{--    <script src="https://cdn.tiny.cloud/1/p7rjwoj09oo8wvsbhym3xq26d9y5ekfl8joeuxfpv9roexvn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <script type="text/javascript" >

        tinymce.init({
            selector: '#question',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
        tinymce.init({
            selector: '#option1',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
        tinymce.init({
            selector: '#option2',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
        tinymce.init({
            selector: '#option3',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
        tinymce.init({
            selector: '#option4',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
        tinymce.init({
            selector: '#option5',
            height: 200,
            /*plugins: 'imatheq image code save',*/
            plugins: [
                'imatheq advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code help'
            ],
            menubar   : true,
            statusbar : false,
            /*toolbar: ['undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link',
                      'code image save | imatheq'],*/
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help | imatheq',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'],
            paste_data_images: true,
            extended_valid_elements : "img[style|class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|imatheq-mml]",
            language: 'en',
        });
    // ClassicEditor
    //     .create( document.querySelector( '#question' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );

    ClassicEditor
        .create( document.querySelector( '#explanation' ), {
            ckfinder: {
                uploadUrl: '{{url('admin/questions/explanations/image_upload').'?_token='.csrf_token()}}'
            }
        },{
            alignment: {
                options: [ 'right', 'right' ]
            }} )
        .then( editor => {
            console.log( editor );
        })
        .catch( error => {
            console.error( error );
        })


    $(function() {

        let difficultyType = $("#question_type").val();

        if(difficultyType == 2){
            $( "#section-true-or-false" ).attr("hidden", false);
            $( "#section-options" ).attr("hidden", true);


        }else{
            $( "#section-options" ).attr("hidden", false);
            $( "#section-true-or-false" ).attr("hidden", true);

        }

        $('.checkbox').click(function(){
            $('.checkbox').each(function(){
                $(this).prop('checked', false);
            });
            $(this).prop('checked', true);
        })

        $("#difficulty_level").select2({
            placeholder: 'Choose Difficulty Level'
        });
        $("#section_id").select2({
            placeholder: 'Choose Section'
        });


        $("#question_type").select2({
            placeholder: 'Choose Question Type'
        });

        $( "#question_type" ).change(function() {

            if( $(this).val() == 1 ){

            }
            else{
                $( "#section-options" ).attr("hidden", true);
            }
            var type =  $(this).val();
            switch (type) {
                case '1':
                    // objective
                    $( "#section-options" ).attr("hidden", false);
                    $( "#section-true-or-false" ).attr("hidden", true);
                    $( ".objective-option" ).attr("required", true);
                    $( "#objective-image-preview-div" ).attr("hidden", false);
                    $( "#true-or-false-image-preview-div" ).attr("hidden", true);

                    break;
                case '2':
                    // true-or-false
                    $( "#section-true-or-false" ).attr("hidden", false);
                    $( "#section-options" ).attr("hidden", true);
                    $( "#objective-image-preview-div" ).attr("hidden", true);
                    $( "#true-or-false-image-preview-div" ).attr("hidden", false);

                    break;
                // case '3':
                //     $( "#section-true-or-false" ).attr("hidden", true);
                //     $( "#section-options" ).attr("hidden", true);
                //     $( "#section-descriptive" ).attr("hidden", false);
                //     break;

                default:
                    $( "#section-options" ).attr("hidden", true);
                    $( "#section-true-or-false" ).attr("hidden", true);

            }
        });

        $('#form-create').validate({
            // ignore: '#editorJs *',
            // ignore: [],
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                difficulty_level: {
                    required: true,
                },
                subject_id: {
                    required: true,
                },
                course_id: {
                    required: true,
                },
                // question: {
                //     required: true,
                // },

                chapter_id: {
                    required: true,
                },
                question_type: {
                    required: true,
                },

                correct_option: {
                    required: function () {
                        if($('#question_type').val() == '1') {
                            return true;
                        } else {
                            return false;
                        }
                    },
                },
            },
            messages: {
                correct_option: "Choose Correct Answer",
            }
        });


        $("#create-new").click(function (){

            $("#create-and-new").val(1);
            $("#form-create").submit();

        });

        $("#create-button").click(function (){

            $("#create-and-new").val(0);
        });

    });

        var loadImage = function(event) {
            var image = document.getElementById('question-image-preview');

            var image_src = event.target.files[0];
            if(image_src){
                $('.question-image-preview-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadOptionImage = function(event) {
            var image = document.getElementById('true-or-false-option-image-preview');

            var image_src = event.target.files[0];
            if(image_src){
                $('.true-or-false-option-image-preview-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadFile1 = function(event) {
            var image = document.getElementById('objective-option-1');

            var image_src = event.target.files[0];
            if(image_src){
                $('.objective-option-1-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadFile2 = function(event) {
            var image = document.getElementById('objective-option-2');

            var image_src = event.target.files[0];
            if(image_src){
                $('.objective-option-2-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadFile3 = function(event) {
            var image = document.getElementById('objective-option-3');

            var image_src = event.target.files[0];
            if(image_src){
                $('.objective-option-3-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadFile4 = function(event) {
            var image = document.getElementById('objective-option-4');

            var image_src = event.target.files[0];
            if(image_src){
                $('.objective-option-4-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }
        var loadFile5 = function(event) {
            var image = document.getElementById('objective-option-5');

            var image_src = event.target.files[0];
            if(image_src){
                $('.objective-option-5-row').attr('hidden', false);
                image.src = URL.createObjectURL(image_src);
            }
        }

    </script>
@endpush

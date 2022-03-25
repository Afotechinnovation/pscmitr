@extends('admin::layouts.app')

@section('title', 'Question')

@section('header')
    <h1 class="page-title">Question</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.questions.index') }}">All questions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-update" method="POST" action="{{ route('admin.questions.update', $question->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Course<span class="required">*</span> </label>
                            <div class="col-md-4">
                                <x-inputs.courses id="course_id" class="{{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('course_id', $question->course_id)))
                                        <option value="{{ old('course_id', $question->course_id) }}" selected>
                                            {{ old('course_id_text', empty($question->course) ? '' : $question->course->name) }}</option>
                                    @endif
                                </x-inputs.courses>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Subject<span class="required">*</span> </label>
                            <div class="col-md-4">
                                <x-inputs.subjects id="subject_id"  related="#course_id" class="{{ $errors->has('subject_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('subject_id', $question->id)))
                                        <option value="{{ old('subject_id', $question->subject_id) }}" selected>
                                            {{ old('subject_id_text', empty($question->subject) ? '' : $question->subject->name) }}</option>
                                    @endif
                                </x-inputs.subjects>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Chapter<span class="required">*</span> </label>
                            <div class="col-md-4">
                                <x-inputs.chapters id="chapter_id"  related="#subject_id" class="{{ $errors->has('chapter_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('chapter_id', $question->id)))
                                        <option value="{{ old('chapter_id', $question->chapter_id) }}" selected>
                                            {{ old('chapter_id_text', empty($question->chapter) ? '' : $question->chapter->name) }}</option>
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
                                        <option  value="{{ $difficultyLevel['value'] }}"
                                            {{ $question->difficulty_level == $difficultyLevel['value'] ? "selected" : "" }}>
                                            {{ $difficultyLevel['name'] }}
                                        </option>
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
                                        <option value="{{ $questionType['value'] }}"
                                            {{ $question->type == $questionType['value'] ? "selected" : "" }} >{{  $questionType['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Question Image </label>
                            <div class="col-md-4">
                                <input type="file" onchange="loadFile(event)"  class="form-control " id="question-image-add"  name="file" accept="image/*" >
                                @error('file')
                                <span class="invalid-feedback" role="alert"> {{ $errors->first('file') }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Question<span class="required">*</span> </label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="question" name="question" rows="14">{!! $question->question !!}</textarea>
                                @error('question')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div  id="section-options" @if( $question->type != \App\Models\Question::QUESTION_TYPE_OBJECTIVE ) hidden @endif>
                            @if( $question->type == 1 )
                                @foreach( $question->options as $key  => $option )
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">Option {{ $key+1 }} </label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" id="option{{ $key+1 }}" name="options[{{ $key+1 }}]" rows="4">{!! $option->option !!} </textarea>
                                            @if( $errors->first( 'options.'. ($key+1) ) )
                                                <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.'. ($key+1) ) }}</span>
                                            @endif

                                        </div>
                                        <input type="hidden" name="optionIds[]" value="{{$option->id}}">
                                        <div class="col-md-2" style="padding-top: 85px">
                                            <input type="checkbox" id="correct_option5" class="checkbox" name="correct_option" value="{{ $key+1 }}"
                                                   @if ($option->is_correct) checked @endif />
                                        </div>
                                    </div>
                                    <div class="form-group row option-row">
                                        <label class="col-md-2 col-form-label">Image {{ $key+1 }}</label>
                                        <div class="col-md-3">
                                            <input type="file" data-key="{{ $key }}" class="form-control image-option" value="{{ $option->image }}" name="images[]"  accept="image/*" >
                                            <input type="hidden" class="option-flag" name="option_flag[]" value="0">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Option 1 </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control objective-option" id="option1" name="options[]" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 85px" >
                                        <input type="checkbox" id="correct_option1" class="checkbox" name="correct_option" value="1"  />
                                    </div>
                                    <div class="row">
                                        @if( $errors->first('options.1') )
                                            <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.1') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Image 1</label>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control" onchange="loadFile1(event)"  id="image"  name="images[]"  accept="image/*" >
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Option 2 </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control objective-option" id="option2" name="options[]" rows="4"></textarea>
                                        @if( $errors->first('options.2') )
                                            <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.2') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2" style="padding-top: 85px">
                                        <input type="checkbox" id="correct_option2" class="checkbox" name="correct_option" value="2" />

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Image 2</label>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control" onchange="loadFile2(event)"  id="image"  name="images[]"  accept="image/*" >
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Option 3 </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control objective-option"  id="option3" name="options[]" rows="4"></textarea>
                                        @if( $errors->first('options.3') )
                                            <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.3') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2" style="padding-top: 85px">
                                        <input type="checkbox" id="correct_option3" class="checkbox" name="correct_option" value="3" />

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Image 3</label>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control" onchange="loadFile3(event)"  id="image"  name="images[]"  accept="image/*" >
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Option 4 </label>
                                    <div class="col-md-8">
                                        <textarea class="form-control objective-option" id="option4" name="options[]" rows="4"></textarea>
                                        @if( $errors->first('options.4') )
                                            <span class="invalid-feedback" role="alert" style="display: inline;"> {{ $errors->first('options.4') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-2" style="padding-top: 85px">
                                        <input type="checkbox" id="correct_option4" class="checkbox" name="correct_option" value="4" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Image 4</label>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control"  onchange="loadFile4(event)"  id="image"  name="images[]"  accept="image/*" >
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Option 5</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" id="option5" name="options[]" rows="4"></textarea>
                                    </div>
                                    <div class="col-md-2" style="padding-top: 85px">
                                        <input type="checkbox" id="correct_option5" class="checkbox" name="correct_option" value="5" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Image 5</label>
                                    <div class="col-md-3">
                                        <input type="file" class="form-control" onchange="loadFile5(event)"  id="image"  name="images[]"  accept="image/*" >
                                        @error('image')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div id="section-true-or-false"  @if($question->type != \App\Models\Question::QUESTION_TYPE_TRUE_OR_FALSE) hidden @endif>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option<span class="required">*</span> </label>
                                <div class="col-md-9">
                                    <div class="col-md-12 mt-2 pl-0">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_true" id="true"
                                                   value="1" {{ $trueOrFalseOption ? $trueOrFalseOption->is_correct == '1' ? 'checked' : '' : '' }} >
                                            <label class="form-check-label" for="true">True</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="is_true" id="false"
                                                   value="0"  {{ $trueOrFalseOption ? $trueOrFalseOption->is_correct == '0' ? 'checked' : '': '' }}>
                                            <label class="form-check-label" for="false">False</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">Option Image </label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" id="true-or-false-image"  name="image"  accept="image/*" >
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Explanation</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="explanation" name="explanation" rows="14">{!! $question->explanation !!}</textarea>
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

                        <div class="row question-image-row" >
                            <div class="col-md-10 p-5 question-image-preview-div @if(!$question->image) d-none @endif ">
                                    <img width="100%" src=" {{ url('storage/questions/image/'.$question->image) }}"  data-toggle="tooltip" data-placement="top" title="Question Image" id="cropped-question-image" class="img-thumbnail" ><br>
                                <p class="text-center"><small class="text-info">Question Image</small></p>
                            </div>
                        </div>

                        <div id="image-preview-true-or-false" @if( $question->type != \App\Models\Question::QUESTION_TYPE_TRUE_OR_FALSE ) hidden  @endif>
                            <div class="row" >
                                <div class="col-md-10 p-5 true-or-false-image-div @if($trueOrFalseOptionImage) @if(!$trueOrFalseOptionImage->image) d-none @else d-block @endif @endif" >
                                    <img width="75%" @if($trueOrFalseOptionImage) src="{{ $trueOrFalseOptionImage->image }}" @else src="" @endif data-toggle="tooltip" data-placement="top" title="Cropped Image" class="img-thumbnail true-or-false-option-image" ><br>
                                    <p class="text-center"><small class="text-info">True or False Option Image</small></p>
                                </div>
                            </div>
                            </div>
                            <div id="image-preview-objective" @if( $question->type != \App\Models\Question::QUESTION_TYPE_OBJECTIVE ) hidden @endif>
                                @foreach( $question->options as $key  => $option )
    {{--                                @if($option->image)--}}
                                    <div class="row  objective-image-row-{{ $key }} @if(!$option->image) d-none @endif" >
                                        <div class="col-md-10 p-5">
                                            <img width="75%" src="{{ $option->image }}"  data-toggle="tooltip" data-placement="top" title="Cropped Image"  class="img-thumbnail image-preview-{{$key}}" ><br>
                                            <p class="text-center"><small class="text-info">Objective Option {{ $key+1 }} Image</small></p>
                                        </div>

                                    </div>
    {{--                                @endif--}}
                                @endforeach
                            </div>

                            <div id="objective-image-preview-div" >
                                <div class=" objective-option-1-row p-5" hidden  >
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
                    <div class="row">
                        @can('update', $question)
                            <div class="col-md-12">
                                <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                                @if($lastRow->id !== $question->id)
                                    <a class="btn btn-primary float-right mr-5" href="{{ route('admin.questions.edit', $nextQuestionId) }}" type="button">NEXT</a>
                                @endif
                                @if($firstRow->id !== $question->id)
                                    <a class="btn btn-primary float-right mr-5" href="{{ route('admin.questions.edit', $previousQuestionId) }}" type="button">PREVIOUS</a>
                                @endif
                            </div>
                      @endcan
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @push('scripts')

        <script src="{{ asset('vendor/ckeditor-5/ckeditor.js') }}"></script>
        <script>
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
            ClassicEditor
                .create( document.querySelector( '#explanation' ), {
                    ckfinder: {
                        uploadUrl: '{{route('admin.ckeditor.upload').'?_token='.csrf_token()}}'

                    }
                },{
                    image:{
                        resizeOptions: [
                            {
                                name: 'resizeImage:original',
                                label: 'Original',
                                value: null
                            },
                            {
                                name: 'resizeImage:50',
                                label: '50%',
                                value: '50'
                            },
                            {
                                name: 'resizeImage:75',
                                label: '75%',
                                value: '75'
                            }
                        ],
                    },
                    alignment: {
                        options: [ 'right', 'right' ]
                    }} )
                .then( editor => {
                    console.log( editor );
                })
                .catch( error => {
                    console.error( error );
                })


            var loadFile = function(event) {
                var image = document.getElementById('cropped-question-image');

                var image_src = event.target.files[0];
                if(image_src){
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

            $(function() {

                $("#question-image-add").change(function() {

                    $('.question-image-preview-div').removeClass('d-none');
                });

                $("#true-or-false-image").change(function() {

                    $('.true-or-false-image-div').removeClass('d-none');
                });

                $("#true-or-false-image").change(function() {

                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.true-or-false-option-image').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }

                });


                $('.checkbox').click(function(){
                    $('.checkbox').each(function(){
                        $(this).prop('checked', false);
                    });
                    $(this).prop('checked', true);
                })

                $("#question_type").select2({
                    placeholder: 'Choose Question Type'
                });

                $("#difficulty_level").select2({
                    placeholder: 'Choose Difficulty Level'
                });
                $("#section_id").select2({
                    placeholder: 'Choose Section'
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
                            $( "#section-options" ).attr("hidden", false);
                            $( "#section-true-or-false" ).attr("hidden", true);
                            $( "#image-preview-true-or-false" ).attr("hidden", true);
                            $( "#image-preview-objective" ).attr("hidden", false);
                            $( "#objective-image-preview-div" ).show();

                            break;
                        case '2':
                            $( "#section-true-or-false" ).attr("hidden", false);
                            $( "#section-options" ).attr("hidden", true);
                            $( "#image-preview-objective" ).attr("hidden", true);
                            $( "#objective-image-preview-div" ).hide();
                            $( "#image-preview-true-or-false" ).attr("hidden", false);

                            break;
                        default:
                            $( "#section-options" ).attr("hidden", true);
                            $( "#section-true-or-false" ).attr("hidden", true);

                    }
                });

                $('#form-update').validate({
                    ignore: [],
                    rules: {
                        name: {
                            required: true,
                            maxlength: 255
                        },
                        difficulty_level: {
                            required: true,
                        },
                        question_type: {
                            required: true,
                        },
                        question: {
                            required: true,
                        },
                        subject_id: {
                            required: true,
                        },
                        course_id: {
                            required: true,
                        },
                        chapter_id: {
                            required: true,
                        },
                        options: {
                            required: true,
                        },
                        correct_option: {
                            required: function () {
                                if ($('#question_type').val() == '1') {
                                    return true;
                                } else {
                                    return false;
                                }
                            },
                        }
                    },
                })


                $(".image-option").change(function() {

                  $(this).closest('.option-row').find('.option-flag').val(1);

                  var key = $(this).attr('data-key');

                    $('.objective-image-row-'+key).removeClass('d-none');

                    if (this.files && this.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('.image-preview-'+key).attr('src', e.target.result);
                        }
                        reader.readAsDataURL(this.files[0]);
                    }

                });

            });
        </script>
    @endpush

@extends('admin::layouts.app')

@section('title', 'Blogs')

@section('header')
    <h1 class="page-title">Blog</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.blogs.index')}}">Blogs</a></li>
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
        <form id="form-update" method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group row mt-1">
                            <label class="col-md-3 col-form-label">Category<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <x-inputs.categories id="category_id" class="{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                                    @if(!empty(old('category_id', $blog->category_id)))
                                        <option value="{{ old('category_id', $blog->category_id) }}" selected>
                                            {{ old('category_id_text', empty($blog->category) ? '' : $blog->category->name) }}</option>
                                    @endif
                                </x-inputs.categories>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Title<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="title" name="title" type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Blog Title" value="{{ old('title', $blog->title) }}"
                                       autocomplete="off">
                                @error('title')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Related Blog </label>
                            <div class="col-md-9">
                                <select name="related_blogs[]" id="related_blogs" multiple class="form-control
                                    @error('related_blogs') is-invalid @enderror" style="width: 100%;" >
                                    <option></option>
                                    @foreach($articles as $article)
                                        <option
                                            @foreach($related_blogs as $related_blog)
                                            @if($related_blog->related_blog_id == $article->id) selected @endif
                                            @endforeach
                                            value=" {{ $article->id }}" >{{ $article->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Author<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="author" name="author" type="text" class="form-control @error('author') is-invalid @enderror"
                                       placeholder="Author" value="{{ old('author', $blog->author) }}" autocomplete="off">
                                @error('author')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

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
                        <div class="form-group row" >
                            <label class="col-md-3 col-form-label">Blog Type<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <select name="blog_type" id="blog_type" value="{{old('blog_type',$blog->blog_type)}}"  class="form-control
                                    @error('blog_type') is-invalid @enderror" style="width: 100%;"  >
                                    <option></option>
                                    @if($blogtypeArticle == 0)
                                        @foreach($blogTypes as $key => $blogType)
                                            <option  value="{{ $key }}"  @if($blog->blog_type==$key) selected='selected' @endif>
                                                {{$blogType}}</option>
                                        @endforeach
                                    @else
                                        <option></option>
                                        <option value="article" {{ $blog->blog_type == 'article' ? 'selected' : '' }}>ARTICLE</option>
                                    @endif

                                </select>
                                @error('blog_type')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="hidden-image-container"></div>

                        <div class="form-group row" id="blog_type_article"
                            @if( $blog->blog_type == \App\Models\Blog::BLOG_TYPE_VIDEO ) hidden  @endif>
                            <label class="col-md-3 col-form-label">Cover Picture*</label>
                            <div class="col-md-9">
                                    <input type="file" onchange="loadImage(event)"  id="cover_pic" name="cover_pic"
                                           class="form-control @error('cover_pic') is-invalid @enderror"  accept="image/*" style="padding-top: 3px;overflow: hidden">
                                    @error('cover_pic')
                                    <span class="invalid-feedback" role="alert" style="display: inline;">
                                            {{ $errors->first('cover_pic') }}
                                        </span><br>
                                    @enderror
                                    <span class="text-info" role="alert"  style="display: inline;">
                                      <small> ** Recommended size for cover pic : Min - 1200 x 600, Max - 1600 x 800</small>
                                    </span>
                            </div>
                        </div>


                        <div class="row">
                            <input id="video" name="video"  hidden value="" type="text" >
                        </div>

                        <div class="form-group row " id="blog_type_video"  @if( $blog->blog_type == \App\Models\Blog::BLOG_TYPE_ARTICLE ) hidden  @endif>
                            <label class="col-md-3 col-form-label">Video</label>
                            <div class="col-md-9">
                                <div class="table-responsive" id="video-blog-section">
                                    <div id="jstree_videos"></div>
                                </div>
                            </div>
                        </div>

                            <div id="hidden-cover-pic-container"></div>

                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Body<span class="required">*</span> </label>
                                    <div class="col-md-9" >
                                        <div class="border @error('body') is-invalid @enderror" id="editorDescriptionId" ></div>
                                        @error('body')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                                {{ $errors->first('body') }}
                                        </span>
                                        <br>
                                        @enderror
                                        <input id="body" name="body" type="hidden" >
                                    </div>
                                </div>
                        </div>

                    <div class="col-md-6 col-lg-6" >
                        <div class="row">
                            <div class="col-md-7">
                                <div class="cropped-image p-5">
                                    <img height="95%" src="{{ $blog->image }}"  data-toggle="tooltip" data-placement="top" title="Cropped Image" id="cropped-image" class="img-thumbnail" ><br>
                                    <p class="text-center"><small class="text-info">Image</small></p>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="cropped-cover-image p-5">
                                   @if($blog->blog_type == 'video')
                                        <iframe class="vid" src="{{$blog->video_src}}"  allow="autoplay; fullscreen; picture-in-picture"
                                                width="100%"  frameborder="1" webkitallowfullscreen mozallowfullscreen
                                                allowfullscreen>
                                        </iframe>
                                        <p class="text-center"><small class="text-center text-info">{{$blog->video->name}}</small></p>
                                    @else
                                        <img width="95%" src="{{ $blog->cover_pic }}"  data-toggle="tooltip" data-placement="top" title="Cropped Cover Picture" id="cropped-cover-photo" class="img-thumbnail" >
                                        <p class="text-center"><small class="text-center text-info">Cover Picture</small></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $blog)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">UPDATE</button>
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
                                                id="blog-image" name="file"  @error('file') is-invalid @enderror>
                                        @error('file')
                                        <span class="invalid-feedback" role="alert" style="display: inline;">
                                             {{ $errors->first('file') }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" id="image-src" value="{{$blog->image}}">
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

    <script src="{{ asset('web/js/video-player.js') }}"></script>
    <script>
        !function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):(t=t||self).edjsHTML=e()}(this,(function(){"use strict";var t={delimiter:function(){return"<br/>"},header:function(t){var e=t.data;return"<h"+e.level+"> "+e.text+" </h"+e.level+">"},paragraph:function(t){return"<p> "+t.data.text+" </p>"},list:function(t){var e=t.data,n="unordered"===e.style?"ul":"ol",r="";return e.items&&(r=e.items.map((function(t){return"<li> "+t+" </li>"})).reduce((function(t,e){return t+e}),"")),"<"+n+"> "+r+" </"+n+">"},image:function(t){var e=t.data,n=e.caption?e.caption:"Image";return'<img src="'+(e.file?e.file.url:"")+'" alt="'+n+'" />'},quote:function(t){var e=t.data;return"<blockquote> "+e.text+" </blockquote> - "+e.caption}};function e(t){return new Error(' [31m The Parser function of type "'+t+'" is not defined. \n\n  Define your custom parser functions as:  [34mhttps://github.com/pavittarx/editorjs-html#extend-for-custom-blocks  [0m')}return function(n){return void 0===n&&(n={}),Object.assign(t,n),{parse:function(n){return n.blocks.map((function(n){return t[n.type]?t[n.type](n):e(n.type)}))},parseBlock:function(n){return t[n.type]?t[n.type](n):e(n.type)}}}}));
    </script>
    <script>
        var loadImage = function(event) {
            var image = document.getElementById('cropped-cover-photo');
            var image_src = event.target.files[0];
            if(image_src){
                image.src = URL.createObjectURL(image_src);
            }
        }

        $(function () {

            let blog_body = @json( old('body', $blog->body) );
            let data = JSON.parse(blog_body);

            const editor = new EditorJS({
                holder : 'editorDescriptionId',
                placeholder: 'Description',

                tools: {
                    header: {
                        class: Header,
                        placeholder: 'Header'
                    },
                    image: {
                        class: ImageTool,
                        config: {
                            endpoints: {
                                byFile: '{{ route('admin.blogs.images.store') }}'
                            }
                        }
                    }
                },
                data: data

            });

            $("#related_blogs").select2({
                placeholder: ' Select Related Blogs'
            });
            $("#blog_type").select2({
                placeholder: ' Select Blog Type'
            });

            $('#form-update').validate({
                ignore: '#editorJs *',
                rules: {
                    title: {
                        required: true,
                        maxlength: 255
                    },
                    author: {
                        required: true,
                        maxlength: 255
                    },
                    category_id: {
                        required: true,
                    },
                }
            });

            @can('videos.view', \App\Models\Video::class)

            $('#jstree_videos').jstree({
                'core': {
                    'multiple': false,
                    'data': function (node, cb) {
                        var $tree = this;

                        var path = node.id === '#' ? '' : node.id;

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
                $("#video").val(selectedVideoFolder);
            });

            @endcan


            $("#blog_type").change(function () {
                var blog_types = $(this).val();
                if(blog_types == "video") {
                    $("#blog_type_video").attr('hidden', false);
                    $("#blog_type_article").attr('hidden', true);

                    $('#jstree_videos').jstree({
                        'core': {
                            'multiple': false,
                            'data': function (node, cb) {
                                var $tree = this;

                                var path = node.id === '#' ? '' : node.id;

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
                        $("#video").val(selectedVideoFolder);
                    });

                } else {
                    $("#blog_type_video").attr('hidden', true);
                    $("#blog_type_article").attr('hidden', false);
                }
            });


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

            $('#form-update').on('submit', function (e) {
                e.preventDefault();

                if ($('#form-update').valid()) {
                    editor.save().then((data) => {
                        $('#body').val(JSON.stringify(data));
                        $('#form-update')[0].submit();
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            });
        });


    </script>
@endpush

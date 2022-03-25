@extends('layouts.app')

@section('title', 'Blogs')

@section('meta')
    <meta property="og:title" content="{{ $blog->title }}" />
    <meta property="og:type" content="text" />
    <meta property="og:url" content="">
    <meta property="og:description" content="{{ $blog->description }}">
    <meta property="og:image" content="{{ $blog->image }}" />
@endsection

@section('content')

    <div class="post-title page-nav pt-lg--7 pt-lg--7 pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mt-3 mb-2"><a href="#" class="lh-2 display2-size display2-md-size mont-font text-grey-900 fw-700">{{$blog->title}}</a></h2>
                    <h6 class="font-xssss text-black-500 fw-600 ml-3 mt-3 d-inline-block">{{$blog->author}}</h6>
                    <h6 class="font-xssss text-grey-500 fw-600 ml-3 mt-3 d-inline-block">{{$blog->created_at}}</h6>
                    <ul class="mt-3 list-inline ">
{{--                        <h6 class="list-inline-item text-grey-900 font-xsssss fw-700">SHARE THIS - </h6>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <a href="whatsapp://send?text={{url('blogs/'.$blog->id)}}" data-action="share/whatsapp/share" class="btn-round-md " target="_blank" >--}}
{{--                                <i class="fa fa-whatsapp text-white"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="list-inline-item">
                            <a  href="https://www.facebook.com/sharer/sharer.php?u={{url('blogs/'.$blog->name_slug)}}" target="_blank" class="btn-round-md bg-facebook">
                                <i class="font-md fa fa-facebook text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/intent/tweet?text={{url('blogs/'.$blog->name_slug)}}" target="_blank"  class="btn-round-md bg-twiiter">
                                <i class="font-md fa fa-twitter text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url('blogs/'.$blog->name_slug))}}&summary={{$blog->description}}&source={{(env('APP_DOMAIN'))}}" target="_blank" class="btn-round-md bg-linkedin">
                                <i class="font-md fa fa-linkedin text-white"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="mailto:?subject={{$blog->title}}&body={{url('blogs/'.$blog->name_slug)}}" class="btn-round-md bg-mail">
                                <i class="font-md fa-md fa fa-envelope text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="post-image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if($blog->blog_type == \App\Models\Blog::BLOG_TYPE_ARTICLE )
                    <img src="{{$blog->cover_pic}}"  alt="blog-image" class="img-fluid rounded-lg">
                    @else
                        <iframe class="vid" src="{{$blog->video_src}}"  allow="autoplay; fullscreen; picture-in-picture"
                                width="100%" height="500px" frameborder="0" webkitallowfullscreen mozallowfullscreen
                                allowfullscreen>
                        </iframe>
                    @endif
                </div>
            </div>
            <div class="row ">
                <div class="card shadow-none w-100 border-0  pt-3 ">
                    <div class="row justify-content-center">
                        <div class="col-10 text-left ">
                            <p class="lh-32 drop-cap font-xs text-grey-600 mb-5" >
                                {!! $blog['body'] !!}
                            </p>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-xs-12 col-sm-6 ml-5 pl-lg--6 pl-sm--8" >
                            <ul class="mt-0 list-inline">
                                <h4 class="list-inline-item mr-5 text-grey-900 font-xs fw-700 mobile-share-button ">Share this article: </h4>
{{--                                <li class="list-inline-item">--}}
{{--                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{url('blogs/'.$blog->id)}}" class="btn-round-md bg-whatsup">--}}
{{--                                        <i class="font-xs ti-whatsapp text-white"></i>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                                <li class="list-inline-item ">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{url('blogs/'.$blog->name_slug)}}" class="btn-round-md bg-facebook " >
                                        <i class="font-xs ti-facebook text-white" ></i>
                                    </a>
                                </li>
                                <li class="list-inline-item"><a href="https://twitter.com/intent/tweet?text={{url('blogs/'.$blog->name_slug)}}" class="btn-round-md bg-twiiter">
                                        <i class="font-xs ti-twitter-alt text-white"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url('blogs/'.$blog->name_slug))}}&description={{$blog->description}}&source={{(env('APP_DOMAIN'))}}" target="_blank" class="btn-round-md bg-linkedin">
                                        <i class="font-xs ti-linkedin text-white"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item"><a href="#" class="btn-round-md bg-instagram"><i class="font-xs ti-instagram text-white"></i></a></li>
                                <li class="list-inline-item">
                                    <a href="http://pinterest.com/pin/create/button/?url={{url('blogs/'.$blog->name_slug)}}&description={{$blog->description}}" target="_blank" class="btn-round-md bg-pinterest">
                                        <i class="font-xs ti-pinterest text-white"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row justify-content-center m-2 pt-5">
                        <div class="col-md-4 ">
                            <a href="{{ url('courses') }}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 text-center font-xssss text-grey-900">Explore Our Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="post-content pt-lg--7 pt-lg--7 pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                @if($related_blogs->count() > 0)
                     <div class="col-lg-12 text-left">
                        <div class="card shadow-none w-100 border-0 next-article text-center pt-5 pb-5">
                         <h6 class="text-uppercase fw-600 ls-3 text-grey-500 font-xsss">Next Article</h6>
                          <div class="row card-scroll">
                              @foreach($related_blogs as $related_blog)
                                  <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
                                      <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden">
                                          <a href="{{ url('blogs/'. $related_blog->blog->name_slug) }}">
                                              <img src="{{ $related_blog->blog->image }}" alt="blog-image" class="w-100">
                                          </a>
                                          <div class="post-content p-md-3 pt-3">
                                              <h6 class="font-xssss text-grey-500 fw-600  float-md-left "> <i class="ti-calendar mr-2 "></i>
                                                  {{ \Carbon\Carbon::parse($related_blog->blog->created_at)->format('Y F d') }}</h6>
                                              <h6 class="font-xssss text-grey-500 fw-600 float-md-right text-center">
                                                  <i class="ti-user mr-2"></i>
                                                  {{ $related_blog->blog->author }}
                                              </h6>
                                              <div class="clearfix"></div>
                                              <h2 class="post-title mt-2 mb-2 pr-3 pl-3 blog-title-height ">
                                                  <a href="{{url('blogs/'. $related_blog->blog->name_slug)}}" class="lh-30 font-sm mont-font text-grey-800 fw-700 ">
                                                      {{ \Illuminate\Support\Str::limit($related_blog->blog->title, 20, $end='...')  }}
                                                  </a>
                                              </h2>
                                              <p class="font-xss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3 description-row">  {!! \Illuminate\Support\Str::limit($related_blog->blog->parsed_description, 25, $end=' ...') !!}</p>
                                              <a href="{{ url('blogs/'. $related_blog->blog->name_slug) }}" class="rounded-xl text-white bg-current w125 p-2 lh-32 font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>
                                          </div>
                                      </article>
                                  </div>
                              @endforeach
                          </div>

                        <div class="row justify-content-center">
                            <div class="col-md-4 ">
                                <a href="{{ url('blogs') }}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 text-center font-xssss text-grey-900">Explore More</a>
                            </div>
                        </div>
                    </div>
                @endif
                 @if($blog_comments->count() > 0)
                     <div class="col-8 offset-lg-2 comments-section bottom-border">
                         <div class="comments-list">
                             <h4 class="text-grey-900 font-sm fw-700 mt-5 mb-5">Comments</h4>
                             @foreach($blog_comments as $blog_comment)
                                 <div class="section full mb-5">
                                     <div class="row">
                                         <div class="col-lg-8 col-md-8 col-sm-9 col-xs-9 pl-3">
                                             <h4 class="mt-1 font-xss text-grey-900 fw-700">{{ $blog_comment->name }}</h4>
                                             <h6 class="text-grey-500 mb-1 mt-0 d-block fw-500 mb-0 ls-2">{{ $blog_comment->created_at }}</h6>

                                             <p class="font-xsss fw-400 lh-26 text-grey-500 mb-1 mt-2">{{ $blog_comment->comment }}</p>
                                         </div>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 @endif
            </div>
        </div>
    </div>

    <div class="post-comment pt-7 pb-7 bg-greyblue">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8  text-center">
                    <h4 class="mb-4 pb-3 text-grey-900 fw-700 font-xl">Leave a Comment</h4>
                    <form action="{{ route('blogs.ratings') }}" method="POST" id="blog-comment">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-3">
                                    <input type="text" name="name" required  class="form-control @error('name') is-invalid @enderror style2-input border-0 bg-color-none text-grey-700" value="{{old('name')}}" placeholder="Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group mb-3">
                                    <input type="email" name="email" required class="form-control @error('email') is-invalid @enderror style2-input border-0 bg-color-none text-grey-700" value="{{old('email')}}" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="name_slug" value="{{ $blog->name_slug }}">

                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <textarea class="form-control @error('comment') is-invalid @enderror w-100 border-0 h125 p-3 " id="comment"  name="comment" required placeholder="Message">{{old('comment')}}</textarea>
                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                    <span id="comment-message" class="text-danger d-none "> The message may not be greater than 255 characters.</span>
                                </div>
                                <div class="form-group">
                                   <button  @if(\Illuminate\Support\Facades\Auth::user()) type="submit" @else type="button"  data-toggle="modal" data-target="#Modallogin" @endif  class="form-control style2-input bg-current text-white font-xss fw-500 p-0 w175">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        //what you'll learn section html parsed and appended to <p>
        {{--let blog_body = @json( $blog->body );--}}
        {{--let blog_description = JSON.parse( blog_body );--}}

        {{--const edjsParser = edjsHTML();--}}
        {{--const  parsed_blog_descriptions = edjsParser.parse( blog_description );--}}

        {{--$(parsed_blog_descriptions).each(function( index, parsed_blog_description ) {--}}
        {{--    $("#blog-description").append( parsed_blog_description );--}}
        {{--});--}}

            $('#comment').bind('keyup', function(e){
            let message =  $('#comment').val().length;
            if(message > 255) {
            $("#comment-message").removeClass('d-none')
        }else {
            $("#comment-message").addClass('d-none')
        }
        });


    </script>
@endpush

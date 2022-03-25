@extends('layouts.app')

@section('title', 'Blogs')

<style>
    .tabs a:hover,
    .tabs a.active { background-color:#bbb; }
</style>

@section('content')

    @include('pages.includes.quiz')

    <div class="how-to-work pt-lg--5 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-12 col-lg-12 col-md-12 text-center mb-5">
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        @foreach($blog_categories as $key=> $blog_category)
                            <li class="list-inline-item  @if($category == $blog_category->id) active @endif">
                                <a class="fw-700 ls-3 font-md text-black text-uppercase  @if($category == $blog_category->id) active @endif ml-3"
                                   href="{{ route('blogs.index',  array_merge(request()->all(), ['category' => $blog_category->id,'page' => 1])) }}"
                                   role="tab" aria-controls="pills-course" aria-selected="true">
                                    {{ $blog_category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content mb-3">
                <div class="tab-pane show active" id="blogNavTab">
                    <div class="row card-scroll">
                        @foreach($blogs as $key => $blog)
                         <div class="col-xl-4 col-lg-6 col-md-6 col-xs-6 col-sm-6 mb-4">
                            <article class="post-article p-0 border-0 shadow-xss rounded-lg overflow-hidden">
                                <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank">
                                    <img src="{{ $blog->image }}" alt="blog-image" class="w-100">
                                </a>
                                <div class="post-content p-3">
                                    <h5 class="font-xssss text-grey-500 fw-600 float-left"><i class="ti-calendar mr-2"></i>
                                        {{Carbon\Carbon::parse($blog->created_at)->format('d M Y') }} </h5>
                                    @if($blog->blog_type == \App\Models\Blog::BLOG_TYPE_ARTICLE )
                                        <span class="font-xsssss fw-700  pl-2 pr-2 lh-25 text-uppercase rounded-lg ls-2 float-md-right text-sm-center alert-success d-inline-block text-success ">
                                           Article
                                         </span>
                                    @else
                                        <span class="font-xsssss fw-700  pl-2 pr-2 lh-25 text-uppercase rounded-lg ls-2 float-md-right text-sm-center alert-success d-inline-block text-success ">
                                           Video
                                         </span>
                                    @endif
                                    <div class="clearfix"></div>
                                    <h2 class="post-title mt-2 mb-2 pr-3 description-row">
                                        <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank" class="lh-30 font-sm mont-font text-grey-800 fw-700">
                                            {{ \Illuminate\Support\Str::limit( $blog->title, 20, $end=' ...') }}
                                        </a>
                                    </h2>
                                    <h6 class="font-xssss text-grey-500 fw-600"><i class="ti-user mr-2"></i> {{ $blog->author }}</h6>
                                    <p class="font-xsss fw-400 text-grey-500 lh-26 mt-0 mb-2 pr-3 description-row">  {!! $blog->parsed_description !!}</p>
{{--                                    <div class="row pt-1">--}}
{{--                                        <div class="star col-sm-6 float-left text-left mb-0">--}}
{{--                                            <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">--}}
{{--                                            <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">--}}
{{--                                            <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">--}}
{{--                                            <img src="{{ asset('web/images/star.png') }}" alt="star" class="w10 mr-1 float-left">--}}
{{--                                            <img src="{{ asset('web/images/star-disable.png') }}" alt="star" class="w10 float-left mr-2">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6 float-right text-left mb-0">--}}
{{--                                            <p class="review-link mt-0 font-xssss  mb-2 fw-500 text-grey-500 lh-3"> 2 customer review</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <div class="row justify-content-center">
                                        <a href="{{url('blogs/'. $blog->name_slug)}}" target="_blank" class="rounded-xl text-white bg-current w125 p-2 lh-32 text-center font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Read More</a>

                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </div>
                {{ $blogs->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection

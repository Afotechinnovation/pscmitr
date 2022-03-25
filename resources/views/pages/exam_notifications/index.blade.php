@extends('layouts.app')

@section('title', 'Exam Notifications')

<style>
    .tabs a:hover,
    .tabs a.active { background-color:#bbb; }
</style>

@section('content')

    @include('pages.includes.quiz')

    <div class="how-to-work pt-lg--5 pb-lg--4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="page-title style1 col-xl-6 col-lg-6 col-md-10 text-center mb-5">
                    <ul class="nav nav-tabs tabs-icon list-inline d-block w-100 text-center border-bottom-0 mt-4" id="myNavTabs">
                        @foreach($exam_categories as $key=> $exam_category)
                            <li class="list-inline-item  @if($category == $exam_category->name) active @endif">
                                <a class="fw-700 ls-3 font-md text-black text-uppercase  @if($category == $exam_category->id) active @endif ml-3"
                                   href="{{ route('exam-notifications',  array_merge(request()->all(), ['category' => $exam_category->id,'page' => 1])) }}"
                                   role="tab" aria-controls="pills-course" aria-selected="true">
                                    {{ $exam_category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if( $exam_notifications->count() > 0 )
                <div class="tab-content">
                    <div class="tab-pane show active"  id="notificationNavtabs">
                        <div class="row card-scroll">
                            @foreach($exam_notifications as $key => $exam_notification)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body ">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: {{ $exam_notification->exam_number }}</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{ $exam_notification->url }}"   target="_blank" class="text-dark text-grey-900">{{ $exam_notification->title }}</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply : {{ $exam_notification->last_date }}
                                                <a class="d-inline-block pl-3" download href="{{ $exam_notification->file }}" ><small><i class="ti-import pr-1"></i></small></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $exam_notifications->links('vendor.pagination.custom') }}
                </div>
            @endif
        </div>
    </div>

@endsection

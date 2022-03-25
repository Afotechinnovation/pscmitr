@extends('layouts.app')

@section('title', 'Exam Notifications')

@section('meta')
    <meta property="og:title" content="{{$exam_notification->title}}" />
    <meta property="og:type" content="text" />
    <meta property="og:url" content="">
    <meta property="og:description" content="{{$exam_notification->description}}">
    <meta property="og:image" content="{{$exam_notification->image}}" />
@endsection

@section('content')

    <div class="post-title page-nav pt-lg--7 pt-lg--7 pt-5 pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="mt-3 mb-2"><a href="#" class="lh-2 display2-size display2-md-size mont-font text-grey-900 fw-700">{{$exam_notification->title}}</a></h2>
                    <h6 class="font-xssss text-black-500 fw-600 ml-3 mt-3 d-inline-block">Last Date</h6>
                    <h6 class="font-xssss text-grey-500 fw-600 ml-3 mt-3 d-inline-block">{{$exam_notification->last_date}}</h6>
                    <h6 class="font-xssss text-black-500  fw-600 ml-3 mt-3 d-inline-block"><i class="ti-bookmark font-xs mr-2"></i></h6>
                    <ul class="mt-3 list-inline ">
                        {{--                        <h6 class="list-inline-item text-grey-900 font-xsssss fw-700">SHARE THIS - </h6>--}}
{{--                        <li class="list-inline-item">--}}
{{--                            <a href="whatsapp://send?text={{url('exam-notifications/'.$exam_notification->id)}}" data-action="share/whatsapp/share" class="btn-round-md " target="_blank" >--}}
{{--                                <i class="fa fa-whatsapp"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="list-inline-item">
                            <a  href="https://www.facebook.com/sharer/sharer.php?u={{url('exam-notifications/'.$exam_notification->id)}}" target="_blank" class="btn-round-md bg-facebook">
                                <i class="font-md fa fa-facebook text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/intent/tweet?text={{url('exam-notifications/'.$exam_notification->id)}}" target="_blank"  class="btn-round-md bg-twiiter">
                                <i class="font-md fa fa-twitter text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="http://www.linkedin.com/shareArticle?mini=true&url={{urlencode(url('exam-notifications/'.$exam_notification->id))}}&summary={{$exam_notification->description}}&source={{(env('APP_DOMAIN'))}}" target="_blank" class="btn-round-md bg-linkedin">
                                <i class="font-md fa fa-linkedin text-white"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="mailto:?subject={{$exam_notification->title}}&body={{url('exam-notifications/'.$exam_notification->id)}}" class="btn-round-md bg-mail">
                                <i class="font-md fa-md fa fa-envelope text-white" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12" id="exam-notification-description">
                    <p>{{$exam_notification->description}}</p>
                </div>
                <div class="col-lg-12 text-center mb-5">
                    @if($exam_notification->url)
                        <a href="{{$exam_notification->url}}" target="_blank" class="rounded-xl text-white bg-current w125 p-2 lh-32
                        font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Apply Now</a>
                    @endif

                    @if($exam_notification->file)
                        <a href="{{$exam_notification->file}}" download class="rounded-xl text-white bg-current w125 p-2 lh-32
                        font-xsss text-center fw-500 d-inline-block mb-0 mt-2">Download</a>
                    @endif
                </div>
            </div>

            <div class="col-lg-12 text-center pb-2">
                @if($exam_notification['relatedNotification']->count() > 0)
                    <div class="card shadow-none w-100 border-0 next-article text-center pt-5 pb-5">
                        <h6 class="text-uppercase fw-600 ls-3 text-grey-500 font-xsss">Next Article</h6>
                        <div class="row">
                            @foreach($exam_notification['relatedNotification'] as $related_exam_notification)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                                    <div class="card w-100 p-0 shadow-xss border-0 rounded-lg overflow-hidden mr-1">
                                        <div class="card-body">
                                            <span class="font-xsssss fw-700 pl-3 pr-3 lh-32 text-uppercase rounded-lg ls-2 bg-current d-inline-block text-white mr-1">Exam Number: {{ $related_exam_notification->exam_notification->exam_number }}</span>
                                            <h4 class="fw-700 font-xss mt-3 lh-28 mt-0"><a href="{{ $related_exam_notification->exam_notification->url }}"   target="_blank" class="text-dark text-grey-900">{{ $related_exam_notification->exam_notification->title }}</a></h4>
                                            <h6 class="font-xssss text-grey-500 fw-600 ml-0 mt-2"> Last Date of Apply : {{ $related_exam_notification->exam_notification->last_date }}
                                                <a class="d-inline-block pl-3" download href="{{ $related_exam_notification->exam_notification->file }}" ><small><i class="ti-import pr-1"></i></small></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="col-md-4 offset-4">
                                <a href="{{url('exam-notifications')}}" class="d-block p-2 lh-32 w-100 text-center bg-greylight fw-600 font-xssss text-grey-900">Explore More</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>

        //description html parsed and appended to <p>
        let exam_notification_body = @json( $exam_notification->body );
        let exam_notification_description = JSON.parse( exam_notification_body );

        const edjsParser = edjsHTML();
        const  parsed_exam_notification_descriptions = edjsParser.parse( exam_notification_description );

        $(parsed_exam_notification_descriptions).each(function( index, parsed_exam_notification_description ) {
            $("#exam-notification-description").append( parsed_exam_notification_description );
        });

    </script>
@endpush

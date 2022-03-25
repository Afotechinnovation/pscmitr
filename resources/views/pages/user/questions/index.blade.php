@extends('layouts.app')

@section('title', 'Questions')

@section('content')

    @include('pages.includes.quiz')

    <div class="blog-page pt-lg--5 pb-lg--7 pt-5 pb-5">
        <div class="container" id="question-search">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card rounded-xxl p-0 border-0 bg-no-repeat" style=" background-color: #e4f7fe; ">
                        <div class="card-body w-100 p-4">
                            <div class="side-wrap rounded-lg">
                                <div class="row" id="search-div">
                                    <div class="col-md-12">
                                        <form class="form-group" name="filter-question-form" id="filter-question-form" action="{{ route('user.questions.index') }}" method="GET">
                                            <div class="col-md-12">
                                                <div class="form-group icon-input mb-3">
                                                    <input type="text" name="search" id="search"  value="{{ request()->input('search') ? request()->input('search') : '' }}" class="form-control style1-input pl-5 border-size-md border-light font-xsss" placeholder="To search type and hit enter">
                                                    <i class="ti-search text-grey-500 font-xs"></i>
                                                    <input type="hidden" value="" name="questionId" id="questionId">
                                                    {{ csrf_field() }}
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-12 col-sm-8 col-lg-4">
                                                <button type="submit" data-question="question2" class="p-2 mt-3 border-0 d-inline-block mobile-content-center
                                                text-white fw-700 lh-30 rounded-lg ml-3 w100 font-xsssss ls-3 bg-info">SEARCH</button>
                                                <a href="#">
                                                  <a href="{{ route('user.questions.index') }}" > <button type="button"  class="p-2 mt-3 border-0 d-inline-block
                                                     fw-700 lh-30 rounded-lg ml-3 w100 font-xsssss ls-3 bg-grey-800">CLEAR</button></a>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(request()->input('search'))
                @if($searchQuestions->count() > 0)
                    <div class="row">
                        <div class="col-12 ">
                            <div class="accordion " id="accordionExample" >
                            @foreach($searchQuestions as $searchQuestion)
                                <div class="card bg-grey ">
                                    <div class="card-header" id="heading{{$searchQuestion->id}}">
                                         <h5 class="mb-0">
                                            <div class=" question-button " type="button" data-question-id="{{ $searchQuestion->id }}" data-toggle="collapse" data-target="#collapse{{$searchQuestion->id}}" aria-expanded="true" aria-controls="collapse{{$searchQuestion->id}}">
                                                  {!! $searchQuestion->question  !!}
                                            </div>
                                        </h5>
                                    </div>

                                    <div id="collapse{{$searchQuestion->id}}" class="collapse " aria-labelledby="heading{{$searchQuestion->id}}" data-parent="#accordionExample">
                                        <div class="card-body">
                                            @foreach( $searchQuestion->options as $key => $option )
                                                @if( $searchQuestion->type == \App\Models\Question::QUESTION_TYPE_OBJECTIVE )
                                                    @if( $option->is_correct )
                                                     <p class="font-xss pt-1 text-grey-800">{!!  $option->option  !!}</p>
                                                        @if($option->image)
                                                            <div class="option-images mobile-text-center">
                                                                <div class="imgContainer">
                                                                    <div class="row ">
                                                                        <div class="col px-2">
                                                                            <img src="{{ $option->image }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @else
                                                    <p class="font-xss pt-1 text-grey-800">  {{ $option->is_correct ? 'TRUE' : 'FALSE' }}</p>
                                                @endif
                                            @endforeach
                                            <div class="option-images mobile-text-center">
                                                <div class="imgContainer">
                                                    <div class="row">
                                                        <div class="col">
                                                            {!! $searchQuestion->explanation !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                    </div>
                @else
                    <center> No data available on search </center>
                @endif
            @else
                <div class="row">
                    <div class="col-xl-12 col-lg-12 mb-4">
                        <center> Search Your Questions </center>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript" >

        $("#question-search").on("contextmenu",function(e){
            return false;
        });

        $('#question-search').bind('cut copy paste', function (e) {
            e.preventDefault();
        });

        var _token = $('input[name="_token"]').val();

    $(document).ready(function(){

        $( "#search" ).autocomplete({
            source: function( request, response ) {

                $.ajax({
                    url:"{{route('user.autocomplete.fetch')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: _token,
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#search').val(ui.item.label);
                $('#questionId').val(ui.item.value);
                return false;
            }
        });

    });

    </script>

@endpush



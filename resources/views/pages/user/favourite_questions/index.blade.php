@extends('layouts.app')

@section('title', 'Tests')

@section('content')
    <div class="course-details pb-lg--7 pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card d-block w-100 border-0 shadow-xss rounded-lg overflow-hidden p-4">
                                    <div class="card-body mb-3 pb-0">
                                        <h2 class="fw-400 font-lg d-block">My  <b>Favourite Questions</b></h2>
                                    </div>
                                    <div class="card-body pb-0 table-responsive">
                                        @if($userFavouriteQuestions->count() > 0)
                                        <table id="fav-table" class="table table-bordered " >
                                            <thead>
                                            <tr>
                                                <th scope="col">S.No</th>
                                                <th scope="col">Question</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($userFavouriteQuestions as $userFavouriteQuestion)
                                                <tr class="text-grey-600">
                                                    <td >{{$loop->iteration }}</td>
                                                    <td>{!! $userFavouriteQuestion['question']->question  !!}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                         <p class="text-center">No data Available </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


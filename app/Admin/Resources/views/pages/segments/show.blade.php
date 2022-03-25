@extends('admin::layouts.app')

@section('title', 'Segments')

@section('header')
    <h1 class="page-title">Segments</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.user-segments.index')}}">Segments</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$user_segment->name}}</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card">
        <div class="card-body bg-grey-100">
            <a  class="btn btn-primary download ml-2 float-right text-white" data-segment-id="{{ $user_segment->id }}" >
                Download
            </a>
        </div>
        <div class="card-body">
            {!! $table->table(['id' => 'table-filtered-segments'], true) !!}
        </div>
    </div>
@endsection

@push('scripts')
    {!! $table->scripts() !!}
@endpush

@push('scripts')
    <script>
        $(function() {
            let $table = $('#table-filtered-segments');

            $('.download').click(function (e) {
                e.preventDefault();
                let id =  $(this).data('segment-id');
                let url =  '{{ url('admin/user-segment-results') }}' + '/'+ id+'/download';
                window.location.href = url;
            });
        })
    </script>
@endpush

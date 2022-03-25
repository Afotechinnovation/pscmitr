@extends('admin::layouts.app')

@section('title', 'Doubts')

@section('header')
    <h1 class="page-title">Doubts</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.doubts.index')}}">Doubts</a></li>
            <li class="breadcrumb-item active" aria-current="page">Show</li>
        </ol>
    </nav>
@endsection

@section('content')

   <div class="card">
       <div class="card-body p-0">
           <div class="card-header bg-white border-bottom p-20">
               <h4 class="card-title m-0">Doubt Details</h4>
           </div>
           <dl class="">
               <div class="row no-gutters align-items-center p-15">
                   <dd class="col-md-3 mb-sm-0">Test</dd>
                   <dt class="col-md-9">{{ $doubt->test->name }}</dt>
               </div>
               <div class="row no-gutters align-items-center bg-light p-15">
                   <dd class="col-md-3 mb-sm-0">Question</dd>
                   <dt class="col-md-9">{!! $doubt->question->question !!}</dt>
               </div>

               <div class="row no-gutters align-items-center p-15">
                   <dd class="col-md-3 mb-sm-0">User Name</dd>
                   <dt class="col-md-9">{{ $doubt->user->name }}</dt>
               </div>
               <div class="row no-gutters align-items-center p-15">
                   <dd class="col-md-3 mb-sm-0">Mobile</dd>
                   <dt class="col-md-9">{{ $doubt->user->mobile }}</dt>
               </div>
                <div class="row no-gutters align-items-center bg-light p-15">
                    <dd class="col-md-3 mb-sm-0">Doubt</dd>
                    <dt class="col-md-9">{{ $doubt->doubt }}</dt>
                </div>
           </dl>
           <form id="form-update" method="POST" action="{{ route('admin.doubts.update', $doubt->id) }}">
               @csrf
               @method('PUT')
               <div class="row no-gutters align-items-center p-15">
                   <dd class="col-md-3 mb-sm-0">Answer</dd>
                   <dt class="col-md-9">
                   <textarea name="answer" required placeholder="Answer" class="form-control @error('answer') is-invalid @enderror"
                             rows="5"  id="answer">{{ old('answer',$doubt->answer) }}</textarea>
                       @error('answer')
                       <span class="invalid-feedback" role="alert">{{ $message }}</span>
                       @enderror
                   </dt>
               </div>

               <hr/>
               <div class="panel-footer">
                   <div class="row">
{{--                       @can('update', $course)--}}
                           <div class="col-md-12">
                               <button class="btn btn-primary float-right" type="submit">UPDATE</button>
                           </div>
{{--                       @endcan--}}
                   </div>
               </div>

           </form>
       </div>
   </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#form-update').validate({
                rules: {
                    answer: {
                        required: true,
                        maxlength: 1000
                    }
                }
            })
        });
    </script>
@endpush

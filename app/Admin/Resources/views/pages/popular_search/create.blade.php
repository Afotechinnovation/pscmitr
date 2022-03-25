@extends('admin::layouts.app')

@section('title', 'Popular Search')

@section('header')
    <h1 class="page-title">Popular Search</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.popular-searches.index')}}">Course</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-create" method="POST" action="{{ route('admin.popular-searches.store') }}">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name<span class="required">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                       placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status </label>
                            <div class="col-md-2">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" name="status" id="status" class="form-check @error('status') is-invalid @enderror"
                                       placeholder="" autocomplete="off" value="1" @if(old('status') == 'checked') checked @endif>
                                @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('create', \App\Models\PopularSearch::class)
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit">CREATE</button>
                        </div>
                    @endcan
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#form-create').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 15,
                    }
                }
            })
        });
    </script>
@endpush

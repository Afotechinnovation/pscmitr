@extends('admin::layouts.app')

@section('title', 'Categories')

@section('header')
    <h1 class="page-title">Category</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.categories.index')}}">Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-create" method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="panel-body pt-40 pb-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label" for="name">Name</label>
                            <div class="col-md-9">
                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                       placeholder="Name" value="{{ old('name') }}" autocomplete="off">
                                @error('name')
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
                    @can('create', \App\Models\Category::class)
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
                        maxlength: 50
                    }
                }
            })
        });
    </script>
@endpush

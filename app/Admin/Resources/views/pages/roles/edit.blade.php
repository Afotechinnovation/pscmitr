@extends('admin::layouts.app')
@section('title', 'Roles')


@section('header')
    <h1 class="page-title">Roles</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.roles.index')}}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="panel">
        <form id="form-role-create" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="panel-body pt-40">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-2 col-form-label">Name<span class="required">*</span> </label>
                            <div class="col-md-6 col-lg-4">
                                <input id="name" name="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="" value="{{ old('name', $role->name) }}"
                                       autocomplete="off">

                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-lg-2 col-form-label">Permissions<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <div class="checkbox-custom checkbox-primary">
                                    <input type="checkbox" id="select-all">
                                    <label for="select-all">Select All</label>
                                </div>

                                <div id="permissions" class="row validator-group">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-4">
                                            <div class="checkbox-custom checkbox-primary permission">
                                                <input type="checkbox"
                                                       id="{{ \Illuminate\Support\Str::slug($permission->name) }}"
                                                       name="permissions[]"
                                                       value="{{ $permission->name }}"
                                                       @if(in_array($permission->name, old('permissions', $role->permissions->pluck('name')->toArray()))) checked @endif
                                                >
                                                <label for="{{ \Illuminate\Support\Str::slug($permission->name) }}">{{ $permission->display_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @error('permissions')
                                <span class="invalid-feedback" role="alert" style="display: inline-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-9">
                            <button id="btn-submit" type="submit" class="btn btn-primary ladda-butto" data-style="zoom-in">Update Role</button>
                        {{--<button id="btn-reset" type="reset" class="btn btn-default btn-outline">Reset</button>--}}
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')

@endpush

@push('scripts')
    <script>
        $(function() {
            $('#form-role-create').validate({
                rules: {
                    name: {
                        required: true
                    },
                    permissions: {
                        required: true
                    }
                }
            });

            $('#btn-reset').click(function () {
                $('#role').val("").trigger('change');
                $('#form-admin-create').resetForm();
            });

            $('#select-all').change(function () {
                $('#permissions').find('.permission > input').attr('checked', $('#select-all').is(':checked'));
            });
        });
    </script>
@endpush

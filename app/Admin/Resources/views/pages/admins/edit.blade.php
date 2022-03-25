@extends('admin::layouts.app')
@section('title', 'Admins')

@section('header')
    <h1 class="page-title">Admin</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--<h2>Admins</h2>--}}
    <div class="panel">
        <form id="form-admin-update" method="POST" action="{{ route('admin.admins.update', $admin->id) }}">
            @csrf
            @method('PUT')

            <div class="panel-body pt-40">
                <div class="row">
                    <div class="col-md-8 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Name<span class="required">*</span>: </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       placeholder="Full Name" value="{{ old('name', $admin->name) }}"
                                       autocomplete="off">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Phone<span class="required">*</span>: </label>
                            <div class="col-md-9">
                                <input id="phone" name="phone" readonly
                                       class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       value="{{ old('phone', $admin->mobile) }}"
                                       autocomplete="off">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Email<span class="required">*</span>: </label>
                            <div class="col-md-9">
                                <input id="email" name="email" type="email" readonly
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       placeholder="@email.com" value="{{ old('email', $admin->email) }}"
                                       autocomplete="off">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        @if($admin->is_super_admin != 1)
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Role<span class="required">*</span> </label>
                                <div class="col-md-9">
                                    <select  class="form-control @error('role_id') is-invalid @enderror" data-plugin="select2" data-placeholder="Select a Role" name="role_id" >
                                        <option></option>
                                        @foreach($roles as $role)
                                            <option @if($admin->role_id == $role->id) selected @endif value="{{ $role->id }}" >{{ old('role', $role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="active">Status </label>
                                <div class="col-md-9">
                                    <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
                                        <input id="is_active" name="is_active" type="checkbox"  @if(old('is_active', $admin->active)) checked @endif
                                               class="{{ $errors->has('is_active') ? ' is-invalid' : '' }}" >
                                        <label for="active"></label>
                                    </div>

                                    @if ($errors->has('is_active'))
                                        <span class="invalid-feedback" role="alert">{{ $errors->first('is_active') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <hr/>
            <div class="panel-footer">
                <div class="row">
                    @can('update', $admin)
                    <div class="col-md-9">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Update</button>
                        {{--<button id="btn-reset" type="reset" class="btn btn-default btn-outline">Reset</button>--}}
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
        'use strict';

        $('#form-admin-update').validate({
            rules: {
                role: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            }
        });

        $('#btn-reset').click(function() {
            $('#form-admin-update').resetForm();
        });


    });
</script>
@endpush

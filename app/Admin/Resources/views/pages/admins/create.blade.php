@extends('admin::layouts.app')
@section('title', 'Admins')

@section('header')
    <h1 class="page-title">Admin</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.admins.index')}}">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    {{--<h2>Admins</h2>--}}
    <div class="panel">
        <form class="confirm" id="form-admin-create" method="POST" action="{{ route('admin.admins.store') }}">
            @csrf

            <div class="panel-body pt-40">
                <div class="row">
                    <div class="col-md-8 col-lg-6">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Name<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="name" name="name" type="text" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Full Name" value="{{ old('name') }}"
                                       autocomplete="off">

                                @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Phone<span class="required">*</span> </label>
                            <div class="col-md-9">
                                @component('admin::components.input-phone', [
                                    'id' => 'mobile','required' => true,
                                    'class' => $errors->has('mobile') ? ' is-invalid' : ''
                                ])
                                {{ old('mobile') }}
                                @endcomponent

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Email<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <input id="email" name="email" type="email" required
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="@email.com" value="{{ old('email') }}"
                                       autocomplete="off">

                                @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Role<span class="required">*</span> </label>
                            <div class="col-md-9">
                                <select required  class="form-control @error('role_id') is-invalid @enderror" data-plugin="select2" data-placeholder="Select a Role" name="role_id" >
                                   <option></option>
                                    @foreach($roles as $role)
                                        <option @if(old('role_id') == $role->id) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
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
                    @can('create', \App\Models\Admin::class)
                    <div class="col-md-9">
                        <button id="btn-submit" type="submit" class="btn btn-primary">Save & Send Email</button>
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

        $('#form-admin-create').validate({
            rules: {
                role_id: {
                    required: true
                },
                name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '/admin/role/check_email_unique',
                        type: 'post',
                        data: {
                            email: function () {
                                return $('#email').val();
                            },
                            '_token': "{{ csrf_token() }}",
                        }
                    }
                },
                mobile: {
                    required: true,
                    number: true
                }
            },
            messages:{
                email: {
                    remote: "Email has been already taken"
                }
            }
        });

       /* $('#btn-reset').click(function() {
            $('#role').val("").trigger('change');
            $('#form-admin-create').resetForm();
        });*/

        $(".confirm").on("submit", function(){
            return confirm("Confirm email and phone are correct.");
        });

    });
</script>
@endpush

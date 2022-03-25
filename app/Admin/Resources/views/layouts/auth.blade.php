@extends('admin::layouts.blank')
@section('body_class', 'page-login-v3 layout-full')

@push('css')
    <link rel="stylesheet" href="{{ asset('/admin/css/login.css') }}">
@endpush

@push('js_vendor')
    <script src="{{ asset('/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('/admin/js/Plugin/jquery-placeholder.js') }}"></script>
    <script src="{{ asset('/admin/js/Plugin/material.js') }}"></script>
@endpush

@section('body')
<!-- Page -->
<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
        <div class="panel">
            <div class="panel-body">
                @section('header')
                    <div class="brand">
                        <img class="brand-img" src="{{ asset('admin/images/logo-blue.png') }}" alt="...">
                        <h2 class="brand-text font-size-18">{{ config('app.name') }} </h2>
                    </div>
                @show
                @yield('content')
            </div>
        </div>

        <footer class="page-copyright page-copyright-inverse">
            <p>Developed by <a class="text-light" href="">Pixbit Solutions</a> </p>
            <p>© 2018. All Right Reserved.</p>
        </footer>
    </div>
</div>
<!-- End Page -->
@endsection

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web/images/favicon.png') }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    @include('layouts.includes.css')
    @yield('meta')
    <style>

        @media only screen and (min-device-width: 300px) and (max-device-width: 600px){
            .custom-test-question{
                font-size: 55px !important;
            }
            .custom-question-li{
                font-size: 20px !important;
            }
            .custom-question-answered{
                font-size: 16px !important;
            }

        }
        @media only screen and (min-device-width: 601px) and (max-device-width: 1800px){
            .custom-test-question{
                font-size: 25px !important;
            }
            .custom-question-answered{
                font-size: 25px !important;
            }
        }
        /*@media (min-width:961px)*/
        /*{*/
        /*    .custom-test-question{*/
        /*        font-size: 25px !important;*/
        /*    }*/
        /*}*/
        /*@media (min-width:1025px) {*/
        /*    .custom-test-question{*/
        /*        font-size: 25px !important;*/
        /*    }*/
        /*}*/
        /*@media (min-width:1281px) {*/
        /*    .custom-test-question{*/
        /*        font-size: 25px !important;*/
        /*    }*/
        /*}*/
    </style>
</head>
<body class="color-theme-blue mont-font">
{{--<div class="preloader"></div>--}}
<div class="main-wrap">
    @include('layouts.includes.header')
    @yield('content')
    @include('layouts.includes.footer')
</div>
@include('layouts.includes.modals')
@include('layouts.includes.js')
</body>
</html>

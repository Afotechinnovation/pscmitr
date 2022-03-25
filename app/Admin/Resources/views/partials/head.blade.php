<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="bootstrap admin template">
<meta name="author" content="">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


<title>@yield('title') | {{ config('app.name') }}</title>

<link rel="apple-touch-icon" href="{{ asset('/admin/images/apple-touch-icon.png') }}">
<link rel="shortcut icon" href="{{ asset('/admin/images/favicon.ico') }}">

<!-- Stylesheets -->
<link rel="stylesheet" href="{{ mix('/admin/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ mix('/admin/css/bootstrap-extend.css') }}">
<link rel="stylesheet" href="{{ mix('/admin/css/site.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/css/custom.css') }}">

<!-- Plugins -->
<link rel="stylesheet" href="{{ asset('/vendor/animsition/animsition.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/asscrollable/asScrollable.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/switchery/switchery.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/intro-js/introjs.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/slidepanel/slidePanel.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/flag-icon-css/flag-icon.css') }}">

<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-fixedheader-bs4/dataTables.fixedheader.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-fixedcolumns-bs4/dataTables.fixedcolumns.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-rowgroup-bs4/dataTables.rowgroup.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-scroller-bs4/dataTables.scroller.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-select-bs4/dataTables.select.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/datatables.net-buttons-bs4/dataTables.buttons.bootstrap4.css') }}">

<link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/ladda/ladda.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/alertify/alertify.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/dropify/dropify.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/jquery-intlTelInput/css/intlTelInput.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-datepicker/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/summernote/summernote.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/summernote/summernote.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/magnific-popup/magnific-popup.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.0/croppie.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">


@stack('css_vendor')

@stack('css')

<!-- Fonts -->
<link rel="stylesheet" href="{{ asset('/fonts/web-icons/web-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('/fonts/brand-icons/brand-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('/fonts/font-awesome/css/font-awesome.min.css') }}">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
@stack('fonts')

<!--[if lt IE 9]>
<script src="{{ asset('/vendor/html5shiv/html5shiv.min.js') }}"></script>
<![endif]-->

<!--[if lt IE 10]>
<script src="{{ asset('/vendor/media-match/media.match.min.js') }}"></script>
<script src="{{ asset('/vendor/respond/respond.min.js') }}"></script>
<![endif]-->

<!-- Scripts -->
<script src="{{ asset('/vendor/breakpoints/breakpoints.js') }}"></script>

{{--chart--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
{{--<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>--}}

<script>
  Breakpoints();
</script>

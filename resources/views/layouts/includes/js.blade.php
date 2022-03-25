<script src="{{ asset('web/js/plugin.js') }}"></script>
<script src="{{ asset('web/js/aos.min.js') }}"></script>
<script src="{{ asset('web/js/scripts.js') }}"></script>
<script src="{{ asset('web/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.js') }}"></script>
<script src="{{ asset('/vendor/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.js') }}"></script>
<script src="{{ asset('web/js/bootstrap-datepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/editorjs-html@3.0.3/build/edjsHTML.browser.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@latest"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.0/croppie.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
{{-- autocomplete search--}}
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js" integrity="sha512-BHDCWLtdp0XpAFccP2NifCbJfYoYhsRSZOUM3KnAxy2b/Ay3Bn91frud+3A95brA4wDWV3yEOZrJqgV8aZRXUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<script src="https://github.com/chartjs/Chart.js/blob/master/docs/scripts/utils.js"></script>
<script  src="https://www.wiris.net/demo/plugins/app/WIRISplugins.js?viewer=image"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js" integrity="sha512-d4KkQohk+HswGs6A1d6Gak6Bb9rMWtxjOa0IiY49Q3TeFd5xAzjWXDCBW9RS7m86FQ4RzM2BdHmdJnnKRYknxw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/web/js/countdown.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>

<script>
    AOS.init();
    @if(session()->has('success'))
    toastr.success('{{session()->get('success') }}');
    @endif
    @if(session()->has('error'))
    toastr.error('{{session()->get('error') }}');
    @endif

    $('.select2').change(function() {
        $(this).valid();
    });
</script>
@stack('js')

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{$titulo}}</title>
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset("img/iconos/logo.png")}}"/>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="{{asset("vendor/fonts/fontawesome.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/fonts/tabler-icons.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/fonts/flag-icons.css")}}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset("vendor/css/rtl/core.css")}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset("vendor/css/rtl/theme-default.css")}}" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{asset("css/demo.css")}}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset("vendor/libs/node-waves/node-waves.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/perfect-scrollbar/perfect-scrollbar.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/typeahead-js/typeahead.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/apex-charts/apex-charts.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/swiper/swiper.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/flatpickr/flatpickr.css")}}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset("vendor/css/pages/cards-advance.css")}}"/>

    <!-- Datatable -->
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-bs5/datatables.bootstrap5.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css")}}"/>
    <!-- Row Group CSS-->
    <link rel="stylesheet" href="{{asset("vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css")}}"/>

    <link rel="stylesheet" href="{{asset("vendor/libs/sweetalert2/sweetalert2.css")}}"/>
    <link rel="stylesheet" href="{{asset("vendor/libs/toastr/toastr.css")}}" />
    <link rel="stylesheet" href="{{asset("vendor/libs/animate-css/animate.css")}}"/>

    <!-- login -->
    <link rel="stylesheet" href="{{asset("vendor/css/pages/page-auth.css")}}"/>

    <link rel="stylesheet" href="{{asset("vendor/libs/select2/select2.css")}}"/>

     <!-- autocomplete -->
    <link rel="stylesheet" href="{{asset('vendor/libs/autocompletejs_2.3/style.css')}}"/>

     <!-- autocomplete -->
    <link rel="stylesheet" href="{{asset('vendor/libs/tagify/tagify.css')}}"/>

    <!-- Jstree -->
    <link rel="stylesheet" href="{{asset('vendor/libs/jstree_jc/themes/default/style.css')}}">

    <link rel="stylesheet" href="{{asset('vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css')}}" />
    <link rel="stylesheet" href="{{asset('vendor/libs/jquery-timepicker/jquery-timepicker.css')}}" />

    <link rel="stylesheet" href="{{asset('vendor/libs/bs-stepper/bs-stepper.css')}}" />

    <!-- Dropzone -->
    <link rel="stylesheet" href="{{asset('vendor/libs/dropzone/dropzone.css')}}" />

    <!-- Helpers -->
    <script src="{{asset("vendor/js/helpers.js")}}"></script>
    <script src="{{asset("vendor/js/template-customizer.js")}}"></script>
    <script src="{{asset("js/config.js")}}"></script>
</head>
@routes

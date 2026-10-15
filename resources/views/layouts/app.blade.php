<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{asset("/")}}" data-template="vertical-menu-template">
<!-- START Head -->
@include("layouts.head", ["titulo"=>  env('APP_NAME')])
<!-- END Head -->

<body>
    <!-- START Carga -->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!--/ END Carga-->
    <!-- START Notificacion -->
    <div class="bs-toast toast toast-ex animate__animated my-2 top-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="toast-header">
            <i class="ti ti-bell ti-xs me-2"></i>
            <div id="toast_titulo" class="me-auto fw-medium"></div>
            <small class="text-muted">Justo ahora</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body pt-0"></div>
    </div>
    <!--/ END Notificacion -->

    <!-- START Notificacion internet-->
    <div class="bs-toast toast toast-placement-ex animate__animated my-2 bottom-0 start-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="">
        <div class="toast-header">
            <i class="ti ti-xs me-2"></i>
            <div id="toast_titulo" class="me-auto fw-medium"></div>
            <small class="text-muted">Justo ahora</small>
        </div>
        <div class="toast-body pt-0"></div>
    </div>
    <!--/ END Notificacion internet-->

    <div class="layout-wrapper layout-content-navbar  ">
        <div class="layout-container">
            <!-- START Menu -->
            @include("layouts.sidebar", ["path_controller" => $path_controller, "titulo"=> auth()->user()["persona"]["empresa"]->abreviatura_oficina])
            <!-- / END Menu -->
            <div class="layout-page">
                <!-- START Navbar -->
                @include("layouts.header")
                <!-- / END Navbar -->
                <div class="content-wrapper">
                    <!-- START Contenido -->
                    @yield("contenido")
                    <!-- END Contenido -->
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <!-- START Script -->
    @include("layouts.script")
    <!-- END Script -->
</body>
</html>

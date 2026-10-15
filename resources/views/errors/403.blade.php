<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{asset("/")}}" data-template="vertical-menu-template">
<!-- START Head -->
@include("layouts.head", ["titulo"=>"CODEtime"])
<!-- END Head -->

<body>
<div class="container-xxl">
  <div class="misc-wrapper text-center">
    <h2 class="mb-1 mt-4">Acceso denegado :(</h2>
    <p class="mb-4 mx-2">¡Ups! 😖 Lo sentimos, se ha producido un error ¡ el usuario no tiene los permisos correctos !</p>
    <a href="javascript:history.back()" class="btn btn-primary mb-4">Regresar a la p&aacute;gina anterior</a>
    <div>
      <img src="{{ asset('img/illustrations/page-misc-error.png') }}" alt="page-misc-error" width="235" class="img-fluid">
    </div>
  </div>
</div>
</body>
</html>
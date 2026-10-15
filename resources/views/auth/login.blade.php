<!DOCTYPE html>
<html lang="en" class="light-style  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{asset("/")}}" data-template="vertical-menu-template">
<meta charset="utf-8" />
<!-- START Head -->
@include("layouts.head", ["titulo"=> env('APP_NAME')])
<!-- END Head -->

<body>
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 m-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{asset("img/illustrations/banner.png")}}" alt="auth-login-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="illustrations/banner.png" data-app-dark-img="illustrations/auth-login-illustration-dark.png">
                    <img src="{{asset("img/illustrations/bg-shape-image-light.png")}}" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png">
                </div>
            </div>
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <!--<div class="app-brand mb-4">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{asset("img/illustrations/soluciones_medicas.png")}}">
                            </span>
                        </a>
                    </div>-->
                    <h4 class="mb-1 fw-bold">Bienvenido al Sistema de la DITT 👋</h4>
                    <p class="mb-3">Inicie sesión para acceder al sistema y disfrutar de todas sus funciones.</p>

                    <form class="mb-3" novalidate="novalidate" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control @if ($errors->has('usuario') AND $errors->first('usuario') != "Lo sentimos, las credenciales ingresadas no coinciden con ninguno de nuestros registros.") is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="Usuario" autofocus>
                            @if ($errors->has('usuario') AND $errors->first('usuario') != "Lo sentimos, las credenciales ingresadas no coinciden con ninguno de nuestros registros.")
                            <span class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                {{ $errors->first('usuario') }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Contrase&ntilde;a</label>
                                <!--<a href="auth-forgot-password-cover.html">
                                    <small>Olvide mi contraseña !</small>
                                </a>-->
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer border-validate"><i class="ti ti-eye-off"></i></span>
                                @error('password')
                                <span class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    {{ $errors->first('password') }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!--<div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me">
                                <label class="form-check-label" for="remember-me">
                                    Recordar contraseña
                                </label>
                            </div>
                        </div>-->
                        @if ($errors->has('usuario') AND $errors->first('usuario') == "Lo sentimos, las credenciales ingresadas no coinciden con ninguno de nuestros registros.")
                        <div class="alert alert-danger text-center mb-2 mt-3">
                            <p class="fv-plugins-message-container fv-plugins-message-container--enabled font-12 mb-0">
                                {{ $errors->first('usuario') }}
                            </p>
                        </div>
                        @enderror
                        <button class="btn btn-primary d-grid w-100">
                            Ingresar
                        </button>
                    </form>
                    <p class="text-center">
                        <span>Quieres saber m&aacute;s de nosotros?</span>
                        <a href="https://unsm.edu.pe/oficina/transferencia-tecnologica/" target="_blank">
                            <span> Ir a nuestra Fanpage</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
<script src="{{asset("js/main.js")}}"></script>
</body>

</html>

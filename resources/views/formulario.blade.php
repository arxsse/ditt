<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{asset("/")}}" data-template="front-pages">
<meta charset="utf-8" />
<!-- START Head -->
@include("layouts.head", ["titulo"=>"DITT"])
<link rel="stylesheet" href="{{asset('vendor/css/pages/front-page-help-center.css')}}" />
<link rel="stylesheet" href="{{asset('vendor/css/pages/front-page.css')}}" />
<link rel="stylesheet" href="{{asset('vendor/css/pages/front-page-landing.css')}}" />
<!-- END Head -->
<style type="text/css">
html,
body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

footer {
    position: relative;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #f8f9fa;
    text-align: center;
    z-index: 999;
}

</style>

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

    <nav class="layout-navbar shadow-none py-0 navbar-active position-absolute">
        <div class="container">
            <div class="navbar navbar-expand-lg landing-navbar px-3 px-md-4">
                <div class="navbar-brand app-brand demo d-flex py-0 py-lg-0 me-4">
                    <a href="{{ route('formulario') }}" class="app-brand-link">
                        <span class="app-brand-logo demo2">
                            <img src="{{asset('img/logo_ditt.png')}}" class="w-100">
                        </span>
                    </a>
                </div>
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <li>
                        <a href="https://unsm.edu.pe/" class="app-brand-link" target="_blank">
                            <span class="app-brand-logo demo2">
                                <img src="{{asset('img/logo_unsm.png')}}" class="w-100">
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative">
                <div class="container">
                    <div class="hero-text-box text-center mb-3">
                        <h1 class="text-primary hero-title display-6 fw-bold">Estamos para proteger tus ideas y respaldar tu talento</h1>
                        <h2 class="h6 mb-2">La Dirección de Innovación y Transferencia Tecnológica, pensando en ti, ha creado una forma rápida y sencilla para que envíes tu innovación, protegiendo tus ideas y facilitando su registro legal.</h2>
                        <a href="#" class="btn btn-label-youtube waves-effect"><span class="tf-icons ti ti-brand-youtube scaleX-n1-rtl me-md-1"></span><span class="d-none d-md-block">Ver Tutorial</span></a>
                    </div>
                    <div id="form_body-formulario" class="container">
                        <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example mb-0">
                            <div class="bs-stepper-header m-auto border-0 py-3">
                                <div class="step" data-target="#checkout-cart">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-icon">
                                            <svg viewBox="0 0 58 54">
                                                <use xlink:href='{{asset('img/svgs/icons/wizard-checkout-confirmation.svg')}}#wizardConfirm'></use>
                                            </svg>
                                        </span>
                                        <span class="bs-stepper-label">Datos</span>
                                    </button>
                                </div>
                                <div class="line">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                                <div class="step" data-target="#checkout-address">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-icon">
                                            <svg viewBox="0 0 54 54">
                                                <use xlink:href='{{asset('img/svgs/icons/wizard-checkout-address.svg')}}#wizardCheckoutAddress'></use>
                                            </svg>
                                        </span>
                                        <span class="bs-stepper-label">Archivo</span>
                                    </button>
                                </div>
                                <div class="line">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                                <div class="step" data-target="#checkout-payment">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-icon">
                                            <svg viewBox="0 0 58 54">
                                                <use xlink:href='{{asset('img/svgs/icons/wizard-checkout-payment.svg')}}#wizardPayment'></use>
                                            </svg>
                                        </span>
                                        <span class="bs-stepper-label">Integrantes</span>
                                    </button>
                                </div>
                                <div class="line">
                                    <i class="ti ti-chevron-right"></i>
                                </div>
                                <div class="step" data-target="#checkout-confirmation">
                                    <button type="button" class="step-trigger">
                                        <span class="bs-stepper-icon">
                                            <svg viewBox="0 0 58 54">
                                                <use xlink:href='{{asset('img/svgs/icons/wizard-checkout-cart.svg')}}#wizardCart'></use>
                                            </svg>
                                        </span>
                                        <span class="bs-stepper-label">Confirmaci&oacute;n</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content border-top">
                                <form id="wizard-checkout-form" onSubmit="return false">
                                    <input type="hidden" name="token" id="token" value="{{$token}}">
                                    <div id="checkout-cart" class="content">
                                        <div class="col-xl-12 col-xxl-12 mb-3 mb-xl-0">
                                            <div class="row fv-plugins-bootstrap5 fv-plugins-framework">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8 mb-2">
                                                    <div class="form-floating input-group input-group-merge">
                                                        <input type="text" class="form-control" name="titulo" id="titulo" placeholder="&nbsp;">
                                                        <label for="titulo">T&iacute;tulo*</label>
                                                        <span icon="titulo" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                                    </div>
                                                    <div id="msjerror_titulo" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-2"></div>
                                                @foreach($tipoderechoautor as $key => $item)
                                                @php
                                                $categoria = ($item->categoria == "1")? "Derecho de Autor" : "Patente";
                                                if($key == 0):
                                                $descripcion_ini = $item->descripcion;
                                                endif;
                                                @endphp
                                                <div class="col-md-4 mb-3">
                                                    <div class="form-check custom-option custom-option-icon position-relative checked">
                                                        <label class="form-check-label custom-option-content" for="idtipoderechoautor{{$key}}">
                                                            <span class="custom-option-body">
                                                                <i class="{{$item->icono}} ti-lg"></i>
                                                                <span class="custom-option-title mb-1">{{$item->descripcion}}</span>
                                                                <span class="badge @if($item->categoria == " 1") bg-label-facebook @else bg-label-linkedin @endif btn-pinned">{{$categoria}}</span>
                                                                <small>{{$item->resumen}}</small>
                                                            </span>
                                                            <input type="radio" class="form-check-input" name="idtipoderechoautor" id="idtipoderechoautor{{$key}}" data-descripcion="{{$item->descripcion}}" data-nrorequisito="{{$item->nrorequisito}}" data-requisito="{!! $item->requisito !!}" value="{{$item->id}}" onclick="select_tipoderechoautor(event, this)" @if($key==0) checked @endif>
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="align_center">
                                                    <span id="btn_anterior1" class="btn btn-label-github waves-effect me-2 disabled">
                                                        <i class="ti ti-arrow-narrow-left ti-xs"></i>
                                                        <span class="align-middle">Anterior</span>
                                                    </span>
                                                    <span id="btn_siguiente1" class="btn btn-primary waves-effect btn-next">
                                                        <i class="ti ti-arrow-narrow-right ti-xs"></i>
                                                        <span class="align-middle">Siguiente</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="checkout-address" class="content">
                                        <div class="row fv-plugins-bootstrap5 fv-plugins-framework">
                                            <div class="col-xl-12 col-xxl-12 mb-3 mb-xl-0">
                                                <div class="alert alert-dark" role="alert">
                                                    <div class="d-flex gap-3">
                                                        <div class="flex-shrink-0">
                                                            <i class="ti ti-bookmarks ti-sm alert-icon alert-icon-lg"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-medium m-0 mb-2"><b>Documentos a enviar : </b><span>Se debe subir los siguientes documentos en formato PDF (máximo 50 MB), utilizando exactamente los nombres que se indican a continuación: </span></div>
                                                            <template id="template_requisito">
                                                                <li>
                                                                    <span></span>
                                                                    <a href="" target="_blank">Ver ejemplo</a>
                                                                </li>
                                                            </template>
                                                            <ul class="list-unstyled mb-0" id="ul_requisito"></ul>
                                                            <ul class="list-unstyled mt-2 mb-0">
                                                                <li>Para convertir sus archivos a PDF use <a target="_blank" href="https://www.zamzar.com/"> Zamzar.com </a></li>
                                                                <li>Para comprimir PDF use <a target="_blank" href="https://www.pdf2go.com/es/comprimir-pdf"> pdf2go</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="section_urlcodigofuente"></div>
                                                <div class="card">
                                                    <div class="card-header d-flex justify-content-between pt-0 pb-2">
                                                        <h5 class="mb-0 card-title">Subir archivo</h5>
                                                        <span class="text-primary font-weight-bold align-center cursor-pointer" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover" data-bs-custom-class="popover-dark" data-bs-content="Solo se acepta formatos tipo (*.pdf)" title="Formatos aceptados"><i class="ti ti-info-circle text-primary"></i>&nbsp;Formatos</span>
                                                    </div>
                                                    <div class="card-body">
                                                        <div action="#" class="dropzone needsclick" id="dropzone-basic"></div>
                                                        <div id="msjerror_dropzone-basic" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="align_center">
                                                    <span id="btn_anterior2" class="btn btn-label-github waves-effect me-2 btn-prev">
                                                        <i class="ti ti-arrow-narrow-left ti-xs"></i>
                                                        <span class="align-middle">Anterior</span>
                                                    </span>
                                                    <span id="btn_siguiente2" class="btn btn-primary waves-effect btn-next">
                                                        <i class="ti ti-arrow-narrow-right ti-xs"></i>
                                                        <span class="align-middle">Siguiente</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="checkout-payment" class="content">
                                        <div class="card">
                                            <div class="alert alert-dark alert-dismissible d-flex align-items-baseline m-0" role="alert">
                                                <span class="alert-icon alert-icon-lg text-dark me-2">
                                                    <i class="ti ti-bookmarks ti-sm"></i>
                                                </span>
                                                <div class="d-flex flex-column ps-1">
                                                    <div class="fw-medium m-0"><b>Agrega a los integrantes del equipo de trabajo.</b></div>
                                                    <p class="mb-0">Los campos que contengan un ' * ', son obligatorios y es necesario que se ingrese la información correspondiente.</p>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <template id="template_integrante">
                                                    <div class="form_documento">
                                                        <div class="row fv-plugins-bootstrap5 fv-plugins-framework">
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg idfacultad" data-allow-clear="true" data-placeholder="Seleccione facultad*" data-tipo="1" required>
                                                                        <option></option>
                                                                        @foreach($facultad as $value)
                                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="select2-focus lb_idfacultad">Seleccione facultad*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_idfacultad"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg idoficina" data-allow-clear="true" data-placeholder="Seleccione oficina*" data-tipo="2" required>
                                                                        <option></option>
                                                                        @foreach($oficina as $value)
                                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="select2-focus lb_idoficina">Seleccione oficina*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_idoficina"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 align_center-right">
                                                                <span class="btn btn-label-danger d-none btn_eliminar">
                                                                    <i class="ti ti-x ti-xs me-1"></i>
                                                                    <span class="align-middle">Eliminar</span>
                                                                </span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg idtipo_documento_identidad" data-allow-clear="true" data-placeholder="Tipo de documento identidad*" required>
                                                                        <option></option>
                                                                        @foreach($tipo_documento_identidad as $value)
                                                                        <option value="{{$value->id}}" data-rango="{{$value->rango}}">{{$value->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="select2-focus">Tipo de documento identidad*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_idtipo_documento_identidad"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control numero_documento_identidad" data-index="1" placeholder="&nbsp;" oninput="numero_entero(event, this);consultar(this)" onpaste="pegar_entero(event)">
                                                                    <label class="numero_documento_identidad_label">N&uacute;mero documento identidad*</label>
                                                                    <span icon="numero_documento_identidad" class="input-group-text"><i class="ti ti-id"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_numero_documento_identidad"></div>
                                                            </div>
                                                            <div class="col-md-4 align_center-right">
                                                                <div class="form-check">
                                                                    <input name="principal" class="form-check-input principal" type="radio">
                                                                    <label class="form-check-label principal_label">Representante principal</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control apellido_paterno" placeholder="&nbsp;">
                                                                    <label class="apellido_paterno_label">Apellido paterno*</label>
                                                                    <span icon="apellido_paterno" class="input-group-text"><i class="ti ti-user"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_apellido_paterno"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control apellido_materno" placeholder="&nbsp;">
                                                                    <label class="apellido_materno_label">Apellido materno*</label>
                                                                    <span icon="apellido_materno" class="input-group-text"><i class="ti ti-user"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_apellido_materno"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control nombres" placeholder="&nbsp;">
                                                                    <label class="nombres_label">Nombres*</label>
                                                                    <span icon="nombres" class="input-group-text"><i class="ti ti-user"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_nombres"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg iddepartamento_actual" data-allow-clear="true" data-placeholder="Departamento actual*" required>
                                                                        <option></option>
                                                                        @foreach($departamento as $value)
                                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="select2-focus">Departamento actual*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_iddepartamento_actual"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg idprovincia_actual" data-allow-clear="true" data-placeholder="Provincia actual*" required>
                                                                        <option></option>
                                                                    </select>
                                                                    <label class="select2-focus">Provincia actual*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_idprovincia_actual"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg iddistrito_actual" data-allow-clear="true" data-placeholder="Distrito actual*" required>
                                                                        <option></option>
                                                                    </select>
                                                                    <label class="select2-focus">Distrito actual*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_iddistrito_actual"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control fecha_nacimiento" placeholder="&nbsp;">
                                                                    <label class="fecha_nacimiento_label">Fecha nacimiento*</label>
                                                                    <span icon="fecha_nacimiento" class="input-group-text"><i class="ti ti-calendar-event"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_fecha_nacimiento"></div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control tipocalle" placeholder="&nbsp;">
                                                                    <label class="tipocalle_label">Tipo calle*</label>
                                                                    <span icon="tipocalle" class="input-group-text"><i class="ti ti-map-2"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_tipocalle"></div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control direccion" placeholder="&nbsp;">
                                                                    <label class="direccion_label">Direcci&oacute;n*</label>
                                                                    <span icon="direccion" class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_direccion"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control correo" placeholder="&nbsp;">
                                                                    <label class="correo_label">Correo*</label>
                                                                    <span icon="correo" class="input-group-text"><i class="ti ti-mail"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_correo"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-floating input-group input-group-merge">
                                                                    <input type="text" class="form-control celular" placeholder="&nbsp;" maxlength="9" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                    <label class="celular_label">Celular*</label>
                                                                    <span icon="celular" class="input-group-text"><i class="ti ti-phone"></i></span>
                                                                </div>
                                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_celular"></div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="position-relative select2-material">
                                                                    <select class="select2 form-select form-select-lg idsexo" data-allow-clear="true" data-placeholder="Seleccione sexo*" required>
                                                                        <option></option>
                                                                        @foreach($sexo as $value)
                                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="select2-focus">Seleccione sexo*</label>
                                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback msjerror_idsexo"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="divider divider-dark text-end d-none">
                                                            <div class="divider-text">
                                                                <i class="ti ti-cut rotate-n90 text-dark"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                                <div id="formulario_integrante"></div>
                                                <div class="divider divider-primary my-1">
                                                    <div id="btn_editpersona" class="divider-text">
                                                        <span class="ml-5 badge bg-label-primary cursor-pointer" onclick="add_integrante(event)"><i class="ti ti-users-plus"></i> Agrear otro integrante</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="align_center">
                                            <span id="btn_anterior3" class="btn btn-label-github waves-effect me-2 btn-prev">
                                                <i class="ti ti-arrow-narrow-left ti-xs"></i>
                                                <span class="align-middle">Anterior</span>
                                            </span>
                                            <span id="btn_siguiente3" class="btn btn-primary waves-effect" onclick="guardar(event)">
                                                <i class="ti ti-brand-telegram ti-xs me-1"></i>
                                                <span class="align-middle">Enviar</span>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="checkout-confirmation" class="content">
                                        <div class="col-12 col-lg-8 offset-lg-2 text-center mb-3">
                                            <h4 class="mt-2 mb-0">¡ TODO CONFORME ! 😇</h4>
                                            <p><b id="tipo_derechoautor">Su solicitud para {{$descripcion_ini}} fue enviada correctamente</b></p>
                                            <p>Ante cualquier consulta, nos pondremos en contacto al número de celular <a id="celular_prin" href="javascript:void(0)"></a> o al correo <a id="correo_prin" target="_blank"></a>, pertenecientes al integrante principal, <b id="nombre_prin"></b></p>
                                            <p class="m-0">Agradecemos su confianza en la <b>Dirección de Innovación y Transferencia Tecnológica.</b></p>
                                            <p>¡Le enviamos un cordial saludo y nuestros mejores deseos para que tenga un excelente día!</p>
                                            <p><span class="fw-medium"><i class="ti ti-clock me-1"></i> Fecha de envio:&nbsp;</span> <b id="fecha_envio"></b></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- / Sections:End -->
    <footer class="landing-footer bg-body footer-text">
        <div class="footer-bottom py-3">
            <div class="container d-flex flex-wrap justify-content-between flex-md-row flex-column text-center text-md-start">
                <div class="mb-2 mb-md-0">
                    <span class="footer-text">©2025</span>
                    <span class="footer-text"> <b>Dirección de Innovación y Transferencia Tecnológica.</b> Todos los derechos reservados.</span>
                </div>
                <div>
                    <a href="javascript:void(0);" class="footer-link me-3">
                        <img src="{{ asset('img/iconos/facebook-light.png')}}" alt="facebook icon" data-app-light-img="iconos/facebook-light.png">
                    </a>
                    <a href="javascript:void(0);" class="footer-link me-3">
                        <img src="{{ asset('img/iconos/instagram-light.png')}}" alt="google icon" data-app-light-img="iconos/instagram-light.png">
                    </a>
                </div>
            </div>
        </div>
    </footer>
    @include("layouts.script")
    <!-- Main JS -->
    <script src="{{asset('vendor/js/front-main.js')}}"></script>
    <script src="{{asset('vendor/js/front-page-landing.js')}}"></script>
    <script src="{{asset('js/wizard-ex-checkout.js')}}"></script>
    <!-- Dropzone JS -->
    <script src="{{asset('js/form/formulario.js')}}"></script>
    <script type="text/javascript">
    data_tipoderechoautor = @json($tipoderechoautor);
    max_files = "<?php echo count($tipoderechoautor[0]->requisitosform) ?>";
    tabla_tipoderechoautor(@json($tipoderechoautor[0]->requisitosform));
    input_urlcodigofuente(<?php echo($tipoderechoautor[0]->id == 1) ? 'true' : 'false'; ?>);
    init_myDropzone()

    </script>
</body>

</html>

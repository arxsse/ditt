@extends("layouts.app", ["path_controller" => $path_controller])
@section("contenido")
<div class="container-xxl flex-grow-1 container-p-y pb-0">
    <div id="form_body-{{$path_controller}}" class="row">
        <div class="col-xl">
            <div class="card mb-12">
                <div class="card-header justify-content-between align-items-center">
                    <h5 class="mb-0">Resgistrar {{$modulo}}</h5>
                    <!-- START Form texto cabecera -->
                    @include("extras.form_cabecera_txt")
                    <!-- END Form texto cabecera -->
                </div>
                <div class="card-body">
                    <form id="form-{{$path_controller}}" onsubmit="md_guardar(event,'btn-save')" autocomplete="off">
                        <input type="hidden" name="id" id="id{{$prefix}}">
                        <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                            <div class="col-md-5">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idempresa{{$prefix}}" name="idempresa" data-allow-clear="true" data-placeholder="Empresa*" required>
                                        <option></option>
                                        @if(is_countable($empresa))
                                        @foreach($empresa as $value)
                                        <option value="{{$value->id}}">{{$value->razonsocial}}</option>
                                        @endforeach
                                        @else
                                        <option value="{{$empresa->id}}">{{$empresa->razonsocial}}</option>
                                        @endif
                                    </select>
                                    <label class="select2-focus" for="idempresa{{$prefix}}">Empresa*</label>
                                    <div id="msjerror_idempresa{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <input type="hidden" id="idpersona{{$prefix}}" name="idpersona">
                                <div id="autocomplete" class="form-floating input-group input-group-merge">
                                    <input type="text" class="form-control" id="nombre_completo{{$prefix}}" name="nombre_completo" placeholder="&nbsp;">
                                    <label for="idpersona{{$prefix}}">Buscar persona*</label>
                                    <span icon="idpersona{{$prefix}}" class="input-group-text border-lr-4px"><i class="ti ti-user-search"></i></span>
                                    <ul class="autocomplete-result-list"></ul>
                                </div>
                                <div id="msjerror_idpersona{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idroles{{$prefix}}" name="idroles[]" data-allow-clear="true" data-placeholder="Seleccione el rol*" multiple required>
                                        <option></option>
                                    </select>
                                    <div id="msjerror_idroles{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating input-group input-group-merge">
                                    <input type="text" class="form-control" id="usuario{{$prefix}}" name="usuario" placeholder="&nbsp;">
                                    <label for="usuario{{$prefix}}">Usuario*</label>
                                    <span icon="usuario{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                </div>
                                <div id="msjerror_usuario{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating input-group input-group-merge">
                                    <input type="text" class="form-control" id="password{{$prefix}}" name="password" placeholder="&nbsp;">
                                    <label for="password{{$prefix}}">Contraseña*</label>
                                    <span icon="password{{$prefix}}" class="input-group-text"><i class="ti ti-key"></i></span>
                                </div>
                                <div id="msjerror_password{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating input-group input-group-merge">
                                    <input type="text" class="form-control" id="password_confirmation{{$prefix}}" name="password_confirmation" placeholder="&nbsp;">
                                    <label for="password_confirmation{{$prefix}}">Confirmar contraseña*</label>
                                    <span icon="password_confirmation{{$prefix}}" class="input-group-text"><i class="ti ti-key"></i></span>
                                </div>
                            </div>
                            @if(auth()->user()->super_admin)
                            <div class="col-md-3 align_center">
                                <label class="switch">
                                    <input type="checkbox" class="switch-input" name="super_admin" id="super_admin{{$prefix}}">
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label"> ¿Super administrador?</span>
                                </label>
                            </div>
                            @endif
                        </div>
                </div>
            </div>
            <!-- START Form cabecera -->
            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => false])
            <!-- END Form cabecera -->
            </form>
        </div>
    </div>
</div>
</div>
</div>
@section("script")
<script type="text/javascript">
let _name_module_{{$path_controller}} = "{{$modulo}}"
let _path_padre_{{$path_controller}} = "{{$path_padre}}"
let _path_controller_{{$path_controller}} = "{{$path_controller}}"
let _prefix_{{$path_controller}} = "{{$prefix}}"
data_form = @json($data);
var data_empresa = @json($empresa);
var reset_true = false

</script>
<script src='{{asset("js/form/$path_padre/$path_controller/form.js")}}'></script>
@endsection
@endsection

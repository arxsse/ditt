@extends("layouts.app", ["path_controller" => $path_controller])
@section("contenido")
<div id="md-{{$path_controller}}" class="container-xxl flex-grow-1 container-p-y pb-0">
    <div id="form_body-{{$path_controller}}" class="row">
        <div class="col-6">
            <div class="card mb-12">
                <div class="card-header justify-content-between align-items-center py-3">
                    <h3 class="m-0">Reporte {{$modulo}}</h3>
                    <small class="text-muted form-texto">Por favor, complete todos los campos obligatorios (*) y luego genere su reporte personalizado.</small>
                </div>
                <div class="card-body">
                    <form id="form-{{$path_controller}}" class="m-0" onsubmit="generar_reporte(event)">
                        <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                            @if($path_controller != "repcama")
                            <div class="col-md-12">
                                <div class="form-floating input-group input-group-merge">
                                    <input type="text" class="form-control" id="rangofecha{{$prefix}}" name="rangofecha" placeholder="&nbsp;">
                                    <label for="rangofecha{{$prefix}}">Rango de fechas*</label>
                                    <span icon="rangofecha{{$prefix}}" class="input-group-text"><i class="ti ti-calendar-event"></i></span>
                                </div>
                                <div id="msjerror_rangofecha{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                            </div>
                            @endif
                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idempresa{{$prefix}}" name="idempresa" data-allow-clear="true" data-placeholder="Empresa*" onchange="traer_area(event, this)" required>
                                        @if(is_countable($empresa))
                                        <option></option>
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
                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idarea{{$prefix}}" name="idarea" data-allow-clear="true" data-placeholder="&Aacute;rea*" onchange="traer_especialidad(event, this)" required>
                                        <option></option>
                                    </select>
                                    <label class="select2-focus" for="idarea{{$prefix}}">&Aacute;rea*</label>
                                    <div id="msjerror_idarea{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idespecialidad{{$prefix}}" name="idespecialidad" data-allow-clear="true" data-placeholder="Especialidad*" required>
                                        <option></option>
                                    </select>
                                    <label class="select2-focus" for="{{$prefix}}">Especialidad*</label>
                                    <div id="msjerror_idespecialidad{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-5 align_center-right">
                                <label class="switch">
                                    <input type="checkbox" class="switch-input" name="otrapestana" id="otrapestana{{$prefix}}">
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label"> ¿Otra pestaña?</span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer align-content-center">
                            <button type="submit" class="btn btn-outline-youtube waves-effect" data-accion="pdf" onclick="generar_reporte(event, this)">
                                <i class="fa fa-file-pdf ti-xs mx-1"></i>
                                <span class="align-middle">Generar PDF</span>
                            </button>
                            <button type="submit" class="btn btn-outline-success waves-effect ml-1" data-accion="excel" onclick="generar_reporte(event, this)">
                                <i class="fa fa-file-csv ti-xs mx-1"></i>
                                <span class="align-middle">Generar Excel</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card mb-12" id="div_iframe">
                <section class="reporte_iframe">
                    <iframe class="embed-responsive-item" src="" width="100%" height="100%" border='0' frameborder='0' scrolling="yes" marginwidth="0" marginheight="0" vspace="0" hspace="0" id="reporte_iframe-{{$path_controller}}">
                    </iframe>
                </section>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
let _name_module_{{$path_controller}} = "{{$modulo}}"
let _path_padre_{{$path_controller}} = "{{$path_padre}}"
let _path_controller_{{$path_controller}} = "{{$path_controller}}"
let _prefix_{{$path_controller}} = "{{$prefix}}"
var data_empresa = @json($empresa);

</script>
<script src='{{asset("js/form/$path_padre/$path_controller/index.js")}}'></script>
@endsection
@endsection

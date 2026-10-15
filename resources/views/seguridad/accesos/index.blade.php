@extends("layouts.app", ["path_controller" => $path_controller])
@section("contenido")
<div class="container-xxl flex-grow-1 container-p-y pb-0">
    <div id="form_body-{{$path_controller}}" class="row">
        <div class="col-xl">
            <div class="card mb-12">
                <div class="card-header justify-content-between align-items-center">
                    <h5 class="mb-0">Filtrar</h5>
                </div>
                <div class="card-body">
                    <form id="form-{{$path_controller}}" class="m-0" onsubmit="guardar_accesos(event)">
                        <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">

                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idempresa{{$prefix}}" name="idempresa" data-allow-clear="true" data-placeholder="Empresa*" onchange="traer_rol_modulopadre(event, this);armar_jstree(event)" required>
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

                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idpadre{{$prefix}}" name="idpadre" data-allow-clear="true" data-placeholder="M&oacute;dulo padre*" onchange="armar_jstree(event)" required>
                                        <option></option>
                                    </select>
                                    <label class="select2-focus" for="idpadre{{$prefix}}">M&oacute;dulo padre*</label>
                                    <div id="msjerror_idpadre{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative select2-material">
                                    <select class="select2 form-select form-select-lg" id="idrole{{$prefix}}" name="idrole" data-allow-clear="true" data-placeholder="Rol*" onchange="armar_jstree(event)" required>
                                        <option></option>
                                    </select>
                                    <label class="select2-focus" for="idrole{{$prefix}}">Rol*</label>
                                    <div id="msjerror_idrole{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        	<button type="submit" class="btn btn-primary w-100" id="btn-save" onclick="guardar_accesos(event)" data-acciones="guardar-{{$path_controller}}">
                        		<span class="align-middle">Guardar</span>
                        	</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-12">
                <div class="card-header justify-content-between align-items-center">
                    <h5 class="mb-0">Lista de m&oacute;dulos y accesos</h5>
                </div>
                <div class="card-body">
                    <div id="jstree_{{$path_controller}}"></div>
                </div>
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

<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top modal-simple">
        <div class="modal-content p-4 pt-3 pb-2">
            <div id="modal_body-{{$path_controller}}" class="modal-body p-0">
                <div class="nav-align-top">
                    <ul class="modal-head nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#dt_basicos"><i class="ti ti-list-details ms-n1 me-2"></i>
                                Datos b&aacute;sicos</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#dt_otros" aria-controls="dt_otros" aria-selected="false"><i class="ti ti-notes ms-n1 me-2"></i>
                                Otros datos</button>
                        </li>
                    </ul>
                    <!-- START Form cabecera -->
                    @include("extras.form_cabecera")
                    <!-- END Form cabecera -->
                    <form id="form-{{$path_controller}}" onsubmit="md_guardar(event,'btn-save')">
                        <div class="tab-content p-0 py-2">
                            <input type="hidden" name="id" id="id{{$prefix}}">
                            <input type="hidden" name="idpais" id="idpais{{$prefix}}" value="1">
                            <div class="tab-pane fade show active" id="dt_basicos" role="tabpanel">
                                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                    <div class="col-md-4">
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
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idfacultad{{$prefix}}" name="idfacultad" data-allow-clear="true" data-placeholder="Seleccione facultad*" required>
                                                <option></option>
                                                @foreach($facultad as $value)
                                                <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="idfacultad{{$prefix}}">Seleccione facultad*</label>
                                            <div id="msjerror_idfacultad{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idtipopersona{{$prefix}}" name="idtipopersona" data-allow-clear="true" data-placeholder="Tipo de persona*" required>
                                                <option></option>
                                                @foreach($tipo_persona as $value)
                                                <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="idtipopersona{{$prefix}}">Tipo de persona*</label>
                                            <div id="msjerror_idtipopersona{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idtipo_documento_identidad{{$prefix}}" name="idtipo_documento_identidad" data-allow-clear="true" data-placeholder="Tipo de documento de identidad*" required>
                                                @foreach($tipo_documento_identidad as $value)
                                                <option value="{{$value->id}}" data-rango="{{$value->rango}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="idtipo_documento_identidad{{$prefix}}">Tipo de documento de identidad*</label>
                                            <div id="msjerror_idtipo_documento_identidad{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="numero_documento_identidad{{$prefix}}" name="numero_documento_identidad" placeholder="&nbsp;" oninput="consulta_sunat(this)">
                                            <label for="numero_documento_identidad{{$prefix}}">N&uacute;mero documento de identidad*</label>
                                            <span icon="numero_documento_identidad{{$prefix}}" class="input-group-text"><i class="ti ti-id"></i></span>
                                        </div>
                                        <div id="msjerror_numero_documento_identidad{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="apellido_paterno{{$prefix}}" name="apellido_paterno" placeholder="&nbsp;">
                                            <label for="apellido_paterno{{$prefix}}">Apellido paterno*</label>
                                            <span icon="apellido_paterno{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                        </div>
                                        <div id="msjerror_apellido_paterno{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="apellido_materno{{$prefix}}" name="apellido_materno" placeholder="&nbsp;">
                                            <label for="apellido_materno{{$prefix}}">Apellido materno*</label>
                                            <span icon="apellido_materno{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                        </div>
                                        <div id="msjerror_apellido_materno{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="nombres{{$prefix}}" name="nombres" placeholder="&nbsp;">
                                            <label for="nombres{{$prefix}}">Nombres*</label>
                                            <span icon="nombres{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                        </div>
                                        <div id="msjerror_nombres{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="iddepartamento_actual{{$prefix}}" name="iddepartamento_actual" data-allow-clear="true" data-placeholder="Departamento actual*" required>
                                                <option></option>
                                                @foreach($departamento as $value)
                                                <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="iddepartamento_actual{{$prefix}}">Departamento actual*</label>
                                            <div id="msjerror_iddepartamento_actual{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idprovincia_actual{{$prefix}}" name="idprovincia_actual" data-allow-clear="true" data-placeholder="Provincia actual*" required>
                                                <option></option>
                                            </select>
                                            <label class="select2-focus" for="idprovincia_actual{{$prefix}}">Provincia actual*</label>
                                            <div id="msjerror_idprovincia_actual{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="iddistrito_actual{{$prefix}}" name="iddistrito_actual" data-allow-clear="true" data-placeholder="Distrito actual*" required>
                                                <option></option>
                                            </select>
                                            <label class="select2-focus" for="iddistrito_actual{{$prefix}}">Distrito actual*</label>
                                            <div id="msjerror_iddistrito_actual{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="fecha_nacimiento{{$prefix}}" name="fecha_nacimiento" placeholder="&nbsp;">
                                            <label for="fecha_nacimiento{{$prefix}}">Fecha nacimiento*</label>
                                            <span icon="fecha_nacimiento{{$prefix}}" class="input-group-text"><i class="ti ti-calendar-event"></i></span>
                                        </div>
                                        <div id="msjerror_fecha_nacimiento{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="tipocalle{{$prefix}}" name="tipocalle" placeholder="&nbsp;">
                                            <label for="tipocalle{{$prefix}}">Tipo calle*</label>
                                            <span icon="tipocalle{{$prefix}}" class="input-group-text"><i class="ti ti-map-2"></i></span>
                                        </div>
                                        <div id="msjerror_tipocalle{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="direccion{{$prefix}}" name="direccion" placeholder="&nbsp;">
                                            <label for="direccion{{$prefix}}">Direcci&oacute;n*</label>
                                            <span icon="direccion{{$prefix}}" class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                        </div>
                                        <div id="msjerror_direccion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="correo{{$prefix}}" name="correo" placeholder="&nbsp;">
                                            <label for="correo{{$prefix}}">Correo*</label>
                                            <span icon="correo{{$prefix}}" class="input-group-text"><i class="ti ti-mail"></i></span>
                                        </div>
                                        <div id="msjerror_correo{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="celular{{$prefix}}" name="celular" placeholder="&nbsp;" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                            <label for="celular{{$prefix}}">Celular*</label>
                                            <span icon="celular{{$prefix}}" class="input-group-text"><i class="ti ti-phone"></i></span>
                                        </div>
                                        <div id="msjerror_celular{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idsexo{{$prefix}}" name="idsexo" data-allow-clear="true" data-placeholder="Seleccione sexo*" required>
                                                <option></option>
                                                @foreach($sexo as $value)
                                                <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="idsexo{{$prefix}}">Seleccione sexo*</label>
                                            <div id="msjerror_idsexo{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="dt_otros" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                            <div class="col-md-4">
                                                <div class="position-relative select2-material">
                                                    <select class="select2 form-select form-select-lg" id="iddepartamento_procedencia{{$prefix}}" name="iddepartamento_procedencia" data-allow-clear="true" data-placeholder="Departamento de procedencia" required>
                                                        <option></option>
                                                        @foreach($departamento as $value)
                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="select2-focus" for="iddepartamento_procedencia{{$prefix}}">Departamento de procedencia</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative select2-material">
                                                    <select class="select2 form-select form-select-lg" id="idprovincia_procedencia{{$prefix}}" name="idprovincia_procedencia" data-allow-clear="true" data-placeholder="Provincia de procedencia" required>
                                                        <option></option>
                                                    </select>
                                                    <label class="select2-focus" for="idprovincia_procedencia{{$prefix}}">Provincia de procedencia</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative select2-material">
                                                    <select class="select2 form-select form-select-lg" id="iddistrito_procedencia{{$prefix}}" name="iddistrito_procedencia" data-allow-clear="true" data-placeholder="Distrito de procedencia" required>
                                                        <option></option>
                                                    </select>
                                                    <label class="select2-focus" for="iddistrito_procedencia{{$prefix}}">Distrito de procedencia</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative select2-material">
                                                    <select class="select2 form-select form-select-lg" id="idestado_civil{{$prefix}}" name="idestado_civil" data-allow-clear="true" data-placeholder="Seleccione estado civil" required>
                                                        <option></option>
                                                        @foreach($estado_civil as $value)
                                                        <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="select2-focus" for="idestado_civil{{$prefix}}">Seleccione estado civil</label>
                                                    <div id="msjerror_idestado_civil{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- START Form cabecera -->
                            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => true, "extra" => "guardar_persona"])
                            <!-- END Form cabecera -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
data_form = @json($data);
tipo_persona = @json($tipo_persona);
var data_empresa = @json($empresa);

</script>
<script src='{{asset("js/form/$path_controller/script.js")}}'></script>
<script src='{{asset("js/form/$path_controller/form.js")}}'></script>

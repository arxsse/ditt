<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top modal-simple">
        <div class="modal-content p-4 pt-3 pb-2">
            <div id="modal_body-{{$path_controller}}" class="modal-body p-0">
                <div class="nav-align-top">
                    <ul class="modal-head nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#dt_basicos"><i class="ti ti-list-details ms-n1 me-2"></i>
                                Registrar {{$modulo}}</button>
                        </li>
                    </ul>
                    <!-- START Form cabecera -->
                    @include("extras.form_cabecera")
                    <!-- END Form cabecera -->
                    <div class="tab-content p-0 py-2">
                        <form id="form-{{$path_controller}}" onsubmit="md_guardar(event,'btn-save')">
                            <input type="hidden" name="id" id="id{{$prefix}}">
                            <div class="tab-pane fade show active" id="dt_basicos" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="card box shadow-none">
                                            <div class="card-body p-0">
                                                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                                    <div class="row m-0">

                                                        <div class="col-md-6">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="idpais{{$prefix}}" name="idpais" data-allow-clear="true" data-placeholder="Pa&iacute;s*" required>
                                                                    @if(is_countable($pais))
                                                                    <option></option>
                                                                    @foreach($pais as $value)
                                                                    <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                    @endforeach
                                                                    @else
                                                                    <option value="{{$pais->id}}">{{$pais->descripcion}}</option>
                                                                    @endif
                                                                </select>
                                                                <label class="select2-focus" for="idpais{{$prefix}}">Pa&iacute;s*</label>
                                                                <div id="msjerror_idpais{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="ruc{{$prefix}}" name="ruc" placeholder="&nbsp;" oninput="consulta_sunat(this)">
                                                                <label for="ruc{{$prefix}}">RUC*</label>
                                                                <span icon="ruc{{$prefix}}" class="input-group-text"><i class="ti ti-id"></i></span>
                                                            </div>
                                                            <div id="msjerror_ruc{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="razonsocial{{$prefix}}" name="razonsocial" placeholder="&nbsp;">
                                                                <label for="razonsocial{{$prefix}}">Raz&oacute;n social*</label>
                                                                <span icon="razonsocial{{$prefix}}" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                                            </div>
                                                            <div id="msjerror_razonsocial{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="abreviatura{{$prefix}}" name="abreviatura" placeholder="&nbsp;">
                                                                <label for="abreviatura{{$prefix}}">Abreviatura*</label>
                                                                <span icon="abreviatura{{$prefix}}" class="input-group-text"><i class="ti ti-loader-quarter"></i></span>
                                                            </div>
                                                            <div id="msjerror_abreviatura{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="oficina{{$prefix}}" name="oficina" placeholder="&nbsp;">
                                                                <label for="oficina{{$prefix}}">Oficina*</label>
                                                                <span icon="oficina{{$prefix}}" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                                            </div>
                                                            <div id="msjerror_oficina{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="abreviatura_oficina{{$prefix}}" name="abreviatura_oficina" placeholder="&nbsp;">
                                                                <label for="abreviatura_oficina{{$prefix}}">Abreviatura oficina*</label>
                                                                <span icon="abreviatura_oficina{{$prefix}}" class="input-group-text"><i class="ti ti-loader-quarter"></i></span>
                                                            </div>
                                                            <div id="msjerror_abreviatura_oficina{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="direccion{{$prefix}}" name="direccion" placeholder="&nbsp;">
                                                                <label for="direccion{{$prefix}}">Dirección*</label>
                                                                <span icon="direccion{{$prefix}}" class="input-group-text"><i class="ti ti-map-pin"></i></span>
                                                            </div>
                                                            <div id="msjerror_direccion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="celular{{$prefix}}" name="celular" placeholder="&nbsp;" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                <label for="celular{{$prefix}}">Celular</label>
                                                                <span icon="celular{{$prefix}}" class="input-group-text"><i class="ti ti-phone"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="iddepartamento{{$prefix}}" name="iddepartamento" data-allow-clear="true" data-placeholder="Departamento" required>
                                                                    <option></option>
                                                                    @foreach($departamento as $value)
                                                                    <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label class="select2-focus" for="iddepartamento{{$prefix}}">Departamento</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="idprovincia{{$prefix}}" name="idprovincia" data-allow-clear="true" data-placeholder="Provincia" required>
                                                                    <option></option>
                                                                </select>
                                                                <label class="select2-focus" for="idprovincia{{$prefix}}">Provincia</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="iddistrito{{$prefix}}" name="iddistrito" data-allow-clear="true" data-placeholder="Distrito" required>
                                                                    <option></option>
                                                                </select>
                                                                <label class="select2-focus" for="iddistrito{{$prefix}}">Distrito</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between pt-0 pb-2">
                                                <h5 class="mb-0 card-title">Subir logo</h5>
                                                <span class="text-primary font-weight-bold align-center cursor-pointer" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-dark" data-bs-content="Solo se acepta formatos tipo (*.jpg, *.png, *.jpeg, *.svg)" title="Formatos aceptados"><i class="ti ti-info-circle text-primary"></i>&nbsp;Formatos</span>
                                            </div>
                                            <div class="card-body">
                                                <div action="#" class="dropzone needsclick" id="dropzone-basic"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- START Form cabecera -->
                            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => true])
                            <!-- END Form cabecera -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
data_form = @json($data);

</script>
<script src='{{asset("js/form/$path_padre/$path_controller/script.js")}}'></script>

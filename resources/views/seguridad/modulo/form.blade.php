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

                                    <div class="col-md-8">
                                        <div class="card box shadow-none">
                                            <div class="card-body p-0">
                                                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                                    <div class="row m-0">
                                                        <div class="col-md-5">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="idempresa{{$prefix}}" name="idempresa" data-allow-clear="true" data-placeholder="Empresa*" onchange="traer_padre_boton(event, this)" required>
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
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="descripcion{{$prefix}}" name="descripcion" placeholder="&nbsp;">
                                                                <label for="descripcion{{$prefix}}">Descripci&oacute;n*</label>
                                                                <span icon="descripcion{{$prefix}}" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                                            </div>
                                                            <div id="msjerror_descripcion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="idpadre{{$prefix}}" name="idpadre" data-allow-clear="true" data-placeholder="Selecciona el padre" required>
                                                                    <option></option>
                                                                </select>
                                                                <label class="select2-focus" for="idpadre{{$prefix}}">Selecciona el padre</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="abreviatura{{$prefix}}" name="abreviatura" placeholder="&nbsp;">
                                                                <label for="abreviatura{{$prefix}}">Abreviatura</label>
                                                                <span icon="abreviatura{{$prefix}}" class="input-group-text"><i class="ti ti-loader-quarter"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="url{{$prefix}}" name="url" placeholder="&nbsp;">
                                                                <label for="url{{$prefix}}">Url*</label>
                                                                <span icon="url{{$prefix}}" class="input-group-text"><i class="ti ti-external-link"></i></span>
                                                            </div>
                                                            <div id="msjerror_url{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="icono{{$prefix}}" name="icono" placeholder="&nbsp;" onkeyup="text_icono(event, this, '#form-icono{{$path_controller}}')">
                                                                <label for="icono{{$prefix}}">Icono</label>
                                                                <button class="input-group-text text-primary waves-effect border-right border-right-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i id="form-icono{{$path_controller}}" class="ti ti-square-rounded-chevron-down-filled"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    @include('extras.iconos',["idicono" => "#icono$prefix", "formicono" => "#form-icono$path_controller"])
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating input-group input-group-merge">
                                                                <input type="text" class="form-control" id="orden{{$prefix}}" name="orden" placeholder="&nbsp;">
                                                                <label for="orden{{$prefix}}">Orden*</label>
                                                                <span icon="orden{{$prefix}}" class="input-group-text"><i class="ti ti-arrows-sort"></i></span>
                                                            </div>
                                                            <div id="msjerror_orden{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                                        </div>
                                                        <div class="col-md-4 align_center-right">
                                                            <label class="switch">
                                                                <input type="checkbox" class="switch-input" name="accesos_directo" id="accesos_directo{{$prefix}}">
                                                                <span class="switch-toggle-slider">
                                                                    <span class="switch-on"></span>
                                                                    <span class="switch-off"></span>
                                                                </span>
                                                                <span class="switch-label"> ¿Acceso directo?</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card box shadow-none">
                                            <div class="card-body p-0">
                                                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                                    <div class="row m-0">

                                                        <div class="col-md-12">
                                                            <div class="position-relative select2-material">
                                                                <select class="select2 form-select form-select-lg" id="idboton{{$prefix}}" name="idboton" data-allow-clear="true" onchange="select_boton(event,this)" data-placeholder="Agregar bot&oacute;n" required>
                                                                    <option></option>
                                                                </select>
                                                                <label class="select2-focus" for="idboton{{$prefix}}">Agregar bot&oacute;n</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="table-responsive text-nowrap">
                                                            	<!-- Template ---->
            	                                                <template id="template_boton">
            	                                                	<tr>
            															<td class="nro text-center">1</td>
            															<td class="descripcion_boton text-center font-weight-600">
            																<i></i>
            																<span></span>
            															</td>
            															<td class="text-center">
            																<button class="btn_eliminar dropdown-item btn-outline-danger align_center">
            																	<i class="ti ti-trash"></i>
            																</button>
            															</td>
            														</tr>
            	                                                </template>
                                                                <table class="dt-multilingual table datatable">
                                                                    <thead class="table-light border border-top-0">
                                                                        <tr>
                                                                            <th width="05%" class="text-center text-primary">#</th>
                                                                            <th width="70%" class="text-center text-primary">Bot&oacute;n</th>
                                                                            <th width="25%" class="text-center text-primary">Acci&oacute;n</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="table_boton"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
var data_boton = @json($data_boton);
var data_empresa = @json($empresa);

</script>
<script src='{{asset("js/form/$path_padre/$path_controller/script.js")}}'></script>

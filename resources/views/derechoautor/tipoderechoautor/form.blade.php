<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-top modal-simple">
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
                                <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                    <div class="col-md-6">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="categoria{{$prefix}}" name="categoria" data-allow-clear="true" data-placeholder="Categor&iacute;a*" required>
                                                <option></option>
                                                <option value="1">Derecho de Autor</option>
                                                <option value="2">Patente</option>
                                            </select>
                                            <label class="select2-focus" for="categoria{{$prefix}}">Pa&iacute;s*</label>
                                            <div id="msjerror_categoria{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="icono{{$prefix}}" name="icono" placeholder="&nbsp;" onkeyup="text_icono(event, this, '#form-icono{{$path_controller}}')">
                                            <label for="icono{{$prefix}}">Icono*</label>
                                            <button class="input-group-text text-primary waves-effect border-right border-right-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i id="form-icono{{$path_controller}}" class="ti ti-square-rounded-chevron-down-filled"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @include('extras.iconos',["idicono" => "#icono$prefix", "formicono" => "#form-icono$path_controller"])
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="descripcion{{$prefix}}" name="descripcion" placeholder="&nbsp;">
                                            <label for="descripcion{{$prefix}}">Descripci&oacute;n*</label>
                                            <span icon="descripcion{{$prefix}}" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                        </div>
                                        <div id="msjerror_descripcion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="orden{{$prefix}}" name="orden" placeholder="&nbsp;" oninput="numero_entero(event, this)" onpaste="pegar_entero(event)">
                                            <label for="orden{{$prefix}}">Orden*</label>
                                            <span icon="orden{{$prefix}}" class="input-group-text"><i class="ti ti-arrows-sort"></i></span>
                                        </div>
                                        <div id="msjerror_orden{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Resumen*</label>
                                        <textarea class="form-control bootstrap-maxlength-example" id="resumen{{$prefix}}" name="resumen" rows="6"></textarea>
                                        <div id="msjerror_resumen{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- START Form footer -->
                            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => true])
                            <!-- END Form footer -->
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

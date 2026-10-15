<div class="modal fade" id="md-{{$path_controller}}_reset" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-simple">
        <div class="modal-content p-4 pt-3 pb-2">
            <div id="modal_body-{{$path_controller}}" class="modal-body p-0">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#dt_basicos"><i class="ti ti-list-details ms-n1 me-2"></i>
                                Cambiar Contraseña</button>
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
                                    <div class="col-12 col-md-12">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="nombre_completo{{$prefix}}" name="nombre_completo" placeholder="&nbsp;" disabled="true">
                                            <label for="nombre_completo{{$prefix}}">Nombre completo</label>
                                            <span icon="nombre_completo{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="usuario{{$prefix}}" name="usuario" placeholder="&nbsp;" disabled="true">
                                            <label for="usuario{{$prefix}}">Usuario</label>
                                            <span icon="usuario{{$prefix}}" class="input-group-text"><i class="ti ti-user"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="password{{$prefix}}" name="password" placeholder="&nbsp;">
                                            <label for="password{{$prefix}}">Contraseña*</label>
                                            <span icon="password{{$prefix}}" class="input-group-text"><i class="ti ti-key"></i></span>
                                        </div>
                                        <div id="msjerror_password{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="password_confirmation{{$prefix}}" name="password_confirmation" placeholder="&nbsp;">
                                            <label for="password_confirmation{{$prefix}}">Confirmar contraseña*</label>
                                            <span icon="password_confirmation{{$prefix}}" class="input-group-text"><i class="ti ti-key"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- START Form cabecera -->
                            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => true, "extra" => "guardar_reset"])
                            <!-- END Form cabecera -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var reset_true = true
data_form = @json($data);

</script>

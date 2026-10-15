<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-top modal-simple">
        <div class="modal-content p-4 pt-3 pb-2">
            <div id="modal_body-{{$path_controller}}" class="modal-body p-0">
                <div class="nav-align-top">
                    <ul class="modal-head nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#dt_basicos"><i class="ti ti-list-details ms-n1 me-2"></i>
                                Cambiar proceso de la {{$modulo}}</button>
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
                                            <select class="select2 form-select form-select-lg" id="idproceso{{$prefix}}" name="idproceso" data-allow-clear="true" data-placeholder="Proceso*" onchange="select_proceso(event, this)" required>
                                                <option></option>
                                                @foreach($proceso as $value)
                                                <option value="{{$value->id}}">{{$value->descripcion}}</option>
                                                @endforeach
                                            </select>
                                            <label class="select2-focus" for="idproceso{{$prefix}}">Proceso*</label>
                                            <div id="msjerror_idproceso{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 align_center">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="fecha_registro{{$prefix}}" value="{{date('d-m-Y')}}" disabled placeholder="&nbsp;">
                                            <label for="fecha_registro{{$prefix}}">Fecha*</label>
                                            <span icon="fecha_registro{{$prefix}}" class="input-group-text"><i class="ti ti-calendar-event"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 align_center">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="hora_registro{{$prefix}}" value="{{date('h:i:s a')}}" disabled placeholder="&nbsp;">
                                            <label for="hora_registro{{$prefix}}">Hora*</label>
                                            <span icon="hora_registro{{$prefix}}" class="input-group-text"><i class="ti ti-clock-hour-1"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="nrocargo{{$prefix}}" name="nrocargo" placeholder="&nbsp;" disabled>
                                            <label for="nrocargo{{$prefix}}">Nro. Cargo</label>
                                            <span icon="nrocargo{{$prefix}}" class="input-group-text"><i class="ti ti-number"></i></span>
                                        </div>
                                        <div id="msjerror_nrocargo{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="nroexpediente{{$prefix}}" name="nroexpediente" placeholder="&nbsp;" disabled>
                                            <label for="nroexpediente{{$prefix}}">Nro. Expediente</label>
                                            <span icon="nroexpediente{{$prefix}}" class="input-group-text"><i class="ti ti-number"></i></span>
                                        </div>
                                        <div id="msjerror_nroexpediente{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="urlresolucion{{$prefix}}" name="urlresolucion" placeholder="&nbsp;" disabled>
                                            <label for="urlresolucion{{$prefix}}"></label>
                                            <span icon="urlresolucion{{$prefix}}" class="input-group-text"><i class="ti ti-unlink"></i></span>
                                        </div>
                                        <div id="msjerror_urlresolucion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-8">
                                        <label class="form-label" for="observacion{{$prefix}}"></label>
                                        <textarea class="form-control bootstrap-maxlength-example" id="observacion{{$prefix}}" name="observacion" rows="4" maxlength="400" disabled></textarea>
                                        <div id="msjerror_observacion{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-4 align_center-right">
                                        <label class="switch">
                                            <input type="checkbox" class="switch-input" name="noticorreo" id="noticorreo{{$prefix}}">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-on"></span>
                                                <span class="switch-off"></span>
                                            </span>
                                            <span class="switch-label"> ¿Notificar integrantes?</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- START Form cabecera -->
                            @include("extras.form_footer", ["path_controller"=> $path_controller, "prefix" => $prefix, "modal" => true, "extra" => "guardar_proceso"])
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
<script src='{{asset("js/form/$path_padre/$path_controller/script_proceso.js")}}'></script>

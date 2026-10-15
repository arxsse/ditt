<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top modal-simple">
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

                                    <div class="col-md-5">
                                        <div class="position-relative select2-material">
                                            <select class="select2 form-select form-select-lg" id="idempresa{{$prefix}}" name="idempresa" data-allow-clear="true" data-placeholder="Empresa*" required>
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

                                    <div class="col-md-7">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="name{{$prefix}}" name="name" placeholder="&nbsp;">
                                            <label for="name{{$prefix}}">Nombre*</label>
                                            <span icon="name{{$prefix}}" class="input-group-text"><i class="ti ti-file-pencil"></i></span>
                                        </div>
                                        <div id="msjerror_name{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating input-group input-group-merge">
                                            <input type="text" class="form-control" id="abreviatura{{$prefix}}" name="abreviatura" placeholder="&nbsp;">
                                            <label for="abreviatura{{$prefix}}">Abreviatura</label>
                                            <span icon="abreviatura{{$prefix}}" class="input-group-text"><i class="ti ti-blockquote"></i></span>
                                        </div>
                                        <div id="msjerror_abreviatura{{$prefix}}" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
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
data_form = @json($data)

</script>
<script src='{{asset("js/form/$path_padre/$path_controller/script.js")}}'></script>
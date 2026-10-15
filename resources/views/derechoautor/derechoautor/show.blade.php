@php use Illuminate\Support\Facades\Crypt; @endphp
<div class="modal fade" id="md-{{$path_controller}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-top modal-simple modal-refer-and-earn">
        <div class="modal-content p-4 pt-3 pb-2">
            <div class="modal-body p-2">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3 class="m-0">Datos de la solicitud</h3>
                    <p class="text-muted">Aquí podrás visualizar los datos contenidos en la solicitud.</p>
                </div>
                <div id="wizard-create-app" class="bs-stepper vertical shadow-none">
                    <div class="bs-stepper-header border-0 p-1">
                        <div class="step" data-target="#details">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="ti ti-file-text ti-sm"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Datos</span>
                                    <span class="bs-stepper-subtitle">Detalle de la solicitud</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#destinatario">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="ti ti-user-share ti-sm"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Integrante</span>
                                    <span class="bs-stepper-subtitle">Integrantes de la solicitud</span>
                                </span>
                            </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#requisito">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle"><i class="ti ti-paperclip ti-sm"></i></span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title text-uppercase">Requisito</span>
                                    <span class="bs-stepper-subtitle">Requisitos de la solicitud</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content py-0 p-3">
                        <div id="details" class="content">
                            <table class="table border border-{{str_replace("bg-", "", $data["proceso"]->clase)}}">
                                <thead>
                                    <tr class="bg-{{str_replace("bg-", "", $data["proceso"]->clase)}}">
                                        <th class="text-center" colspan="2">
                                            <span>{{$data->titulo}}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-0" width="65%">
                                            <span class="fw-bold me-2">Tipo: </span>
                                            <span>{{$data->tipoderechoautor->descripcion}}</span>
                                        </td>
                                        <td class="py-0" width="25%" rowspan="7">
                                            <div class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework">
                                                <div class="col-md-12">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="bg-label-primary rounded-3 text-center mb-3 pt-4">
                                                                <img class="img-fluid" src="{{ asset('img/illustrations/girl-with-laptop.png')}}" alt="Card girl image" width="140">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Fecha: </span>
                                            <span>{{$data->fecha." | ".$data->hora}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Nro. Cargo: </span>
                                            <span>{{$data->nrocargo}} </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Nro. Expediente: </span>
                                            <span>{{$data->nroexpediente}} </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Formateria:</span>
                                            @foreach($data["formatos"] as $key => $item)
                                            <a href="{{ route('derechoautor.formateria', ["id" => $data->id, "urlejemplo" => $item->urlejemplo]) }}" target="_blank">{{$item->descripcion}}</a>
                                            @if(count($data["formatos"]) != $key+1)
                                                <span>┊</span>
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Proceso:</span>
                                            <span class="badge {{$data["proceso"]->clase}}">{{$data["proceso"]->descripcion}}</span>
                                        </td>
                                    </tr>
                                    <!--<tr>
                                        <td class="py-0">
                                            <span class="fw-bold me-2">Observaci&oacute;n: </span>
                                            <span>{{$data->observacion}} </span>
                                        </td>
                                    </tr>-->
                                    <tr>
                                        <td class="py-0">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="py-0">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="destinatario" class="content">
                            <div class="col-md mb-4 mb-md-2">
                                <div class="accordion mt-3" id="accordionWithIcon">
                                    @foreach($data["integrantes"] as $key => $item)
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header d-flex align-items-center">
                                            <button type="button" class="accordion-button align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#accordionWithIcon-{{$key}}" aria-expanded="false">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-wrapper">
                                                        <div class="avatar me-2">
                                                            <span class="avatar-initial rounded-circle bg-label-secondary"><i class="ti ti-user text-body ti-sm"></i></span>
                                                        </div>
                                                    </div>
                                                    <span class="d-flex align-items-start flex-column">
                                                        <span class="h6 mb-0">{{$item["persona"]->nombre_completo}}</span>
                                                        @if($item->principal == true)
                                                        <span class="badge bg-primary">Principal</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="accordionWithIcon-{{$key}}" class="accordion-collapse collapse">
                                            <div class="accordion-body px-0">
                                                <div class="accordion-body d-flex align-items-baseline flex-wrap flex-xl-nowrap flex-sm-nowrap flex-md-wrap p-0">
                                                    <table class="table table-sm table-borderless text-nowrap m-0">
                                                        <tr>
                                                            <td><b>Tipo Documento Identidad : </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]["tipo_documento_identidad"]->descripcion}} ( {{$item["persona"]["tipo_documento_identidad"]->abreviatura}} )</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>N&uacute;mero Identidad</b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]->numero_documento_identidad}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nombre Completo: </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]->nombre_completo}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Ubicaci&oacute;n Actual: </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]["distrito_actual"]["provincia"]["departamento"]->descripcion}} - {{$item["persona"]["distrito_actual"]["provincia"]->descripcion}} - {{$item["persona"]["distrito_actual"]->descripcion}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Fecha Nacimiento: </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]->fecha_nacimiento}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Tipo Calle : </b></td>
                                                            <td class="fw-medium">{{$item["persona"]->tipocalle}}</td>
                                                            <td><b>Direcci&oacute;n : </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]->direccion}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Correo : </b></td>
                                                            <td class="fw-medium">{{$item["persona"]->correo}}</td>
                                                            <td><b>Celular : </b></td>
                                                            <td class="fw-medium">{{$item["persona"]->celular}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Sexo : </b></td>
                                                            <td class="fw-medium" colspan="3">{{$item["persona"]["sexo"]->descripcion}}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="requisito" class="content">
                            <div class="row">
                                @if(count($data["requisitos"]) > 0)
                                @foreach($data["requisitos"] as $key => $item)
                                <div class="col-md-4">
                                    <a href="{{$item->path_file}}/{{$data->id}}/{{$item->rutadocumento}}" target="_blank">
                                        <div class="card card-border-shadow-danger">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                    <div class="avatar me-2">
                                                        <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-pdf ti-md"></i></span>
                                                    </div>
                                                </div>
                                                <a class="mb-1 fw-bold text-dark link" href="{{$item->path_file}}/{{$data->id}}/{{$item->rutadocumento}}" target="_blank">{{$item->descripcion}}</a>
                                                <p class="mb-0">
                                                    <span class="fw-medium me-1">{{round($item->sizedocumento/1000, 1)}}</span>
                                                    <small class="text-muted">KB</small>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                                @else
                                <div class="alert alert-secondary d-flex align_center" role="alert">
                                    <span class="alert-icon text-warning me-2">
                                        <i class="ti ti-alert-square-rounded ti-xs"></i>
                                    </span>
                                    <span class="text-dark">Ups..! este expediente no cuenta con requisitos.</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='{{asset("js/form/$path_padre/$path_controller/show.js")}}'></script>

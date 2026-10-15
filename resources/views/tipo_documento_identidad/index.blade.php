@extends("layouts.app", ["path_controller" => $path_controller])
@section("contenido")
<div class="container-xxl flex-grow-1 container-p-y pb-0">
    <div class="card">
        <div class="card-datatable table-responsive">
        	<div class="dataTables_wrapper dt-bootstrap5 no-footer">
	            <div class="card-header flex-column flex-md-row py-3">
	                <!-- START Cabecera-->
                    @include('extras.cabecera',['titulo' => $modulo])
                    <!-- END Cabecera-->

	                <!-- START Botones-->
                    @include('extras.botones',['path_controller' => "$path_controller"])
                    <!-- END Botones-->
	            </div>
	        </div>
	        <hr class="mx-2 my-0">
            <table id="dt-{{$path_controller}}" realid="{{$path_controller}}" class="dt-multilingual table datatable">
                <thead>
                	<tr>
						<th width="05%">#</th>
						<th width="70%">Descripci&oacute;n</th>
						<th width="20%">Abreviatura</th>
						<th width="20%">Rango</th>
                        <th width="05%">Estado</th>
					</tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="div_md-{{$path_controller}}"></div>
@section("script")
<script type="text/javascript">
let _path_controller_{{$path_controller}} = "{{$path_controller}}"
let _name_module_{{$path_controller}} = "{{$modulo}}"
let _prefix_{{$path_controller}} = "{{$prefix}}"

</script>
<script src='{{asset("js/form/$path_controller/index.js")}}'></script>
<script src='{{asset("js/form/$path_controller/form.js")}}'></script>
@endsection
@endsection

<div class="dt-buttons btn-group flex-wrap">
@foreach ($boton as $key => $row)
	@can($row["funcion"].'-'.$path_controller .'_'.session('auth_empresa').'_'.session('auth_rol'))
	<button id="btn-{{$row["funcion"]}}" class="{{$row["clase"]}}" type="button">
		<span>
			<i class="{{$row["icono"]}}"></i>
			@if($row["id"] != 3 )
			<span class="d-none d-sm-inline-block">{{$row["descripcion"]}}</span>
			@endif
		</span>
	</button>
	@endcan
@endforeach
</div>
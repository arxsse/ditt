<div class="dp-block">
    <div class="head-label text-center d-flex">
        <h4 class="card-title mb-0">Lista de {{$titulo}}</h4>
        <button onclick="actualizar_datatable(event)" type="button" class="btn text-nowrap d-inline-block px-1 py-0 mt-1 btn_actualizar">
            <span class="tf-icons ti-sm ti ti-rotate-clockwise-2 text-primary"></span>
        </button>
        @can($btn_filtro->funcion."-".$path_controller.'_'.session('auth_empresa').'_'.session('auth_rol'))
        <button onclick="abrir_filtro(event)" type="button" class="btn text-nowrap d-inline-block px-0 py-0 mt-1 btn_filtro">
            <span class="tf-icons {{$btn_filtro->icono}} {{$btn_filtro->clase}}"></span>
        </button>
        @endcan
    </div>
    @can($btn_filtro->funcion."-".$path_controller.'_'.session('auth_empresa').'_'.session('auth_rol'))
    @include('extras.filtro', ["filtro" => $filtro])
    @endcan
</div>

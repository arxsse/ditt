<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/empresa/' . auth()->user()->persona->idempresa . '/' . auth()->user()->persona->empresa->rutaimagen) }}">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">&nbsp;{{$titulo}}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @foreach ($menu as $key => $row)
        @if(count($row['submenu']) > 0)
        @php
        $path_controller_actual = (isset($url_actual))? $url_actual : $path_controller;
        $array_url = explode("|", substr($row["urls"], 0, -1));
        @endphp
        <li class="menu-item @if(array_search($path_controller_actual, $array_url) !== false) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons {{$row["icono"]}}"></i>
                <div data-i18n="{{$row["text"]}}">{{$row["text"]}}</div>
            </a>
            @include("extras.submenu",["submenu"=>$row["submenu"], "path_controller" => $path_controller_actual])
        </li>
        @endif
        @endforeach
    </ul>
</aside>

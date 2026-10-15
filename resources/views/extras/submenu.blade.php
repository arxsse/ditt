<ul class="menu-sub">
    @foreach($submenu as $key => $modulo)
        @if(!$modulo["index"])
            @php continue; @endphp
        @endif
        @if(count($modulo["submenu"]) == 0)
        <li class="menu-item @if((isset($path_controller_url)? $path_controller_url: $path_controller) == $modulo["url"]) active @endif">
            <a href="{{url($modulo["url"])}}" class="menu-link">
                <div data-i18n="{{$modulo["text"]}}">{{$modulo["text"]}}</div>
            </a>
        </li>
        @else
        @php
        $path_controller_actual = $path_controller;
        $array_url = explode("|", substr($modulo["urls"], 0, -1));
        @endphp
        <li class="menu-item @if(array_search($path_controller_actual, $array_url) !== false) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons {{$modulo["icon"]}}"></i>
                <div data-i18n="{{$modulo["text"]}}">{{$modulo["text"]}}</div>
            </a>
            @include("extras.submenu",["submenu"=>$modulo["submenu"], "path_controller" => $path_controller])
        </li>
        @endif
    @endforeach
</ul>
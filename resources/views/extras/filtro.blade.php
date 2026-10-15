<div id="div-filtros" class="d-none mt-1">
    @foreach($filtro as $row)
    <div class="btn-group">
        <button type="button" id="filtro{{$row[0]["tipo"]}}" class="btn btn-label-primary dropdown-toggle waves-effect" data-bs-toggle="dropdown" aria-expanded="false">{{$row[0]["texto"]}}</button>
        <ul class="dropdown-menu">
            @foreach($row as $row1)
            <li class="li-filtro" data-tipo="{{$row1["tipo"]}}" data-texto="{{$row1["texto"]}}" data-filtro="{{$row1["filtro"]}}" data-default="{{$row1["default"]}}"><a class="dropdown-item" href="javascript:void(0);">{{$row1["texto"]}}</a></li>
            @endforeach
        </ul>
    </div>
    @endforeach
</div>

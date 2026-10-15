<div class="modal-footer @if($modal) pt-2 @else gap-2 @endif">
    <button type="submit" class="btn btn-outline-primary waves-effect" id="btn-save" onclick="md_guardar(event, this)" @if(isset($extra)) data-acciones="{{$extra}}-{{$path_controller}}" @else data-acciones="guardar-{{$path_controller}}" @endif>
        <i class="ti ti-device-floppy ti-xs me-1"></i>
        <span class="align-middle">Guardar</span>
    </button>
    @if($modal)
    <button type="reset" class="btn btn-label-youtube waves-effect m-0" data-bs-dismiss="modal" aria-label="Close">
        <!--<i class="ti ti-x ti-xs me-1"></i>-->
        <span class="align-middle">Cancelar</span>
    </button>
    @else
    <button id="cancelar{{$prefix}}" class="btn btn btn-label-youtube waves-effect pl-2" data-repeater-delete>
        <!--<i class="ti ti-x ti-xs me-1"></i>-->
        <span class="align-middle">Cancelar</span>
    </button>
    @endif
</div>
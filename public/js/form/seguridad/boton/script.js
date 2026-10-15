//------------------------------------------------------------- Extras
draggable(document.querySelector('#md-' + _path_controller_boton), '.modal-head')
$('#form-' + _path_controller_boton + ' .select2').select2({ dropdownParent: $('#md-' + _path_controller_boton) })

//------------------------------------------------------------- Init
function init() {
    if (data_form.mostrar)
        $("#mostrar" + _prefix_boton).click()
    
    if (data_form.es_boton)
        $("#es_boton" + _prefix_boton).click()
}
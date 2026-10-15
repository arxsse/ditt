//------------------------------------------------------------- Extras
draggable(document.querySelector('#md-' + _path_controller_derechoautor), '.modal-head')
$('#form-' + _path_controller_derechoautor + ' .select2').select2({ dropdownParent: $('#md-' + _path_controller_derechoautor) })

function select_proceso(e, obj) {
    let idproceso = obj.value

    document.querySelector('label[for="observacion' + _prefix_derechoautor + '"]').textContent = "Observación (máx. 400 caracteres)"
    $('#observacion' + _prefix_derechoautor).attr('disabled', true)
    document.querySelector('label[for="urlresolucion' + _prefix_derechoautor + '"]').textContent = "Url resolución"
    $('#urlresolucion' + _prefix_derechoautor).attr('disabled', true)
    $('#nrocargo' + _prefix_derechoautor).attr('disabled', true)
    $('#nroexpediente' + _prefix_derechoautor).attr('disabled', true)

    switch (idproceso) {
        case '2':
        case '3':
            document.querySelector('label[for="observacion' + _prefix_derechoautor + '"]').textContent = "Observación* (máx. 400 caracteres)"
            $('#observacion' + _prefix_derechoautor).removeAttr('disabled')
            break;
        case '4':
            $('#nrocargo' + _prefix_derechoautor).removeAttr('disabled')
            $('#nroexpediente' + _prefix_derechoautor).removeAttr('disabled')
            break;
        case '5':
            document.querySelector('label[for="urlresolucion' + _prefix_derechoautor + '"]').textContent = "Url resolución*"
            $('#urlresolucion' + _prefix_derechoautor).removeAttr('disabled')
            $('#nrocargo' + _prefix_derechoautor).removeAttr('disabled')
            $('#nroexpediente' + _prefix_derechoautor).removeAttr('disabled')
            break;
        default:
            break;
    }
}

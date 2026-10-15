//------------------------------------------------------------- Variables globales
var editar = false
var files_aceptados = 'image/jpg, image/png, image/jpeg, image/svg'
files_tmp = []

//------------------------------------------------------------- Extras
draggable(document.querySelector('#md-' + _path_controller_empresa), '.modal-head')
$('#form-' + _path_controller_empresa + ' .select2').select2({ dropdownParent: $('#md-' + _path_controller_empresa) })
"use strict";
[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e) { return new bootstrap.Popover(e) })
init_myDropzone(null)

//------------------------------------------------------------- Ubigeo
$('#iddepartamento' + _prefix_empresa).change(function(e) {
    e.preventDefault()
    get_provincia('ubigeo', $(this).val(), editar, 'm', _path_controller_empresa, _prefix_empresa, data_form)
})
$('#idprovincia' + _prefix_empresa).change(function(e) {
    e.preventDefault()
    get_distrito('ubigeo', $(this).val(), editar, 'm', _path_controller_empresa, _prefix_empresa, data_form)
})


//------------------------------------------------------------- RUC
$('#ruc' + _prefix_empresa).on('input', function(event) {
    const solo_numeros = /^["0-9","+"," "]+$/.test(event.target.value)
    if (!solo_numeros) $(this).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
})

//------------------------------------------------------------- Celular
$('#celular' + _prefix_empresa).on('input', function(event) {
    const solo_numeros = /^["0-9","+"," "]+$/.test(event.target.value)
    if (!solo_numeros) $(this).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
})

//------------------------------------------------------------- Consulta SUNAT
function consulta_sunat(obj) {
    var ruc = obj.value

    const solo_numeros = /^[0-9]+$/.test(ruc)
    if (!solo_numeros) $('#ruc' + _prefix_empresa).val(function(i, oldValue) { return oldValue.replace(/\D/g, '') })

    ruc = (ruc.length > 11) ? ruc.slice(0, 11) : ruc
    obj.value = ruc
    if (ruc.length == 11) {
        $('#razonsocial' + _prefix_empresa).val('')
        $.ajax({
            url: route('persona.consulta_sunat', encodeURI(ruc)),
            beforeSend: function() { loading('m', _path_controller_empresa, 'start') },
            success: function(response) {
                if (response.message) { return false }
                $('#razonsocial' + _prefix_empresa).val(response.nombre)
                if (response.direccion != '-')
                    $('#direccion' + _prefix_empresa).val(response.direccion)
            },
            complete: function() { loading('m', _path_controller_empresa, 'end') },
        })
    }
}

function init_myDropzone(data_file) {
    Dropzone.autoDiscover = false, desctroy_dropzone();
    var myDropzone = new Dropzone("div#dropzone-basic", {
        acceptedFiles: files_aceptados,
        previewTemplate: prev_dropzone,
        addRemoveLinks: !0,
        maxFiles: 1,
        init: function() {
            if (data_file) {
                var mockFile = { name: data_file.nombre, size: data_file.size, edit: true }
                this.emit("addedfile", mockFile)
                this.emit("thumbnail", mockFile, data_file.ruta)
                this.emit("complete", mockFile)
                this.files.push(mockFile)
                files_tmp.push(mockFile)
            }
        },
        success: function(file, response) {
            const compro = files_tmp.findIndex(x => x.name == file.name)
            if (compro != -1) {
                remover_file = true
                toastar.warning('Notificación ' + _name_module_empresa, 'Se elimino los archivos duplicados')
                myDropzone.removeFile(myDropzone.files[compro])
                remover_file = false
            } else {
                files_tmp.push(file)
            }
        }
    })
}

//------------------------------------------------------------- Init
function init() {
    if (data_form.distrito != null) {
        editar = true
        $('#iddepartamento' + _prefix_empresa).val(data_form.distrito.provincia.iddepartamento).trigger('change')
    }

    if (data_form.rutaimagen != null) {
        init_myDropzone({ 'ruta': data_form.path_file + data_form.id + '/' + data_form.rutaimagen, 'nombre': data_form.rutaimagen, 'size': data_form.sizeimagen })
    }
}

//------------------------------------------------------------- Variables globales
var __jstree = ""
var _idpadre = false
var _idrole = false

//------------------------------------------------------------- Extras
$(".select2").length && $(".select2").each(function() {
    $(this).select2({ dropdownParent: $(this).parent() })
})


//------------------------------------------------------------- Localstore
if (localStorage.getItem("accesos")) {
    var datos = localStorage.getItem("accesos").split('-')
    _idpadre = datos[2]
    _idrole = datos[3]

    $('#idempresa' + _prefix_accesos).val(datos[1]).trigger('change')
    toastar.success('Notificación ' + _name_module_accesos, datos[0])
    setTimeout(deletemsj_localstore("accesos"), 100)

} else if (!data_empresa.length) {
    $('#idempresa' + _prefix_accesos).val(data_empresa.id).trigger('change')
}

//------------------------------------------------------------- Traer rol y modulo padre
function traer_rol_modulopadre(e, obj) {
    e.preventDefault()
    if ($(obj).val() == "") {
        $("#idpadre" + _prefix_accesos).html("").val("").select2("close")
        $("#idrole" + _prefix_accesos).html("").val("").select2("close")
        return false
    }
    get_modulopadre($(obj).val(), _idpadre, _idrole)
}

//------------------------------------------------------------- Modulo padre
function get_modulopadre(id, idpadre, idrole) {
    $.ajax({
        url: route('modulo.get_modulopadre'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('f', _path_controller_accesos, 'start') },
        success: function(response) {
            let list = "<option></option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' >" + val["descripcion"] + "</option>"
            })
            $("#idpadre" + _path_controller_accesos).html(list)
            idpadre && $('#idpadre' + _prefix_accesos).val(idpadre).trigger('change')
            get_role(id, idrole)
        },
        complete: function() { loading('f', _path_controller_accesos, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Rol
function get_role(id, idrole) {
    $.ajax({
        url: route('role.get_role'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('f', _path_controller_accesos, 'start') },
        success: function(response) {
            let list = "<option></option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' >" + val["name"] + "</option>"
            })
            $("#idrole" + _path_controller_accesos).html(list)
            idrole && $('#idrole' + _prefix_accesos).val(idrole).trigger('change')
            _idpadre = false
            _idrole = false
        },
        complete: function() { loading('f', _path_controller_accesos, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Jstree
function armar_jstree(e) {
    e.preventDefault()

    limpieza(_path_controller_accesos)
    $('#jstree_' + _path_controller_accesos).jstree('destroy')
    __jstree = $('#jstree_' + _path_controller_accesos).jstree({
        'plugins': ["wholerow", "checkbox", "types"],
        'core': {
            "themes": {
                "responsive": false
            },
            'data': {
                'url': route(_path_controller_accesos + '.acceso'),
                'data': function(node) {
                    return { id: node.id, idempresa: $("#idempresa" + _prefix_accesos).val(), idpadre: $("#idpadre" + _prefix_accesos).val(), idrole: $("#idrole" + _prefix_accesos).val() }
                }
            }
        }
    })
}

//------------------------------------------------------------- Guardar
function guardar_accesos(e) {
    e.preventDefault()
    let post_data = new FormData($($("#form-" + _path_controller_accesos))[0])
    var cont_true = 0
    var cont_false = 0

    __jstree != "" && __jstree.find('li').each(function(i, element) {
        var link = $(element).find('a.jstree-anchor')
        var __id = this.id.split('-')
        if (__id[0] == 'f') {
            if ($(element).attr("aria-selected")) {
                if ($(element).attr("aria-selected").toString() == 'true') {
                    cont_true++
                    post_data.append("accesos_true[" + cont_true + "][id]", this.id)
                } else {
                    cont_false++
                    post_data.append("accesos_false[" + cont_false + "][id]", this.id)
                }
            } else if ($(link).attr("aria-selected").toString() == 'true') {
                cont_true++
                post_data.append("accesos_true[" + cont_true + "][id]", this.id)
            } else {
                cont_false++
                post_data.append("accesos_false[" + cont_false + "][id]", this.id)
            }
        }
    })

    //for (var pair of post_data.entries()) { console.log(pair[0] + ', ' + pair[1]) } return false
    $.ajax({
        url: route(_path_controller_accesos + '.store'),
        type: 'POST',
        data: post_data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() { loading('f', _path_controller_accesos, 'start') },
        success: function(response) {
            localStorage.accesos = "Datos grabados correctamente-" + $("#idempresa" + _prefix_accesos).val() + "-" + $("#idpadre" + _prefix_accesos).val() + "-" + $("#idrole" + _prefix_accesos).val()
            location.reload()
        },
        complete: function() { loading('f', _path_controller_accesos, 'end') },
        error: function(e) {
            if (e.status == 422) {
                recorer_errores(e.responseJSON.errors, _path_controller_accesos, _prefix_accesos)
            } else {
                mostrar_errores_externos(e)
            }
        }
    })
}

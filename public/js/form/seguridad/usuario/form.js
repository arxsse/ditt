//------------------------------------------------------------- Extras
var array_role = []
if (data_form.length != 0){
    init()
}else if (!data_empresa.length){
    $('#idempresa' + _prefix_usuario).val(data_empresa.id).trigger('change')
    get_role(data_empresa.id, false)
}

$(".select2").length && $(".select2").each(function() {
    $(this).select2({ dropdownParent: $(this).parent() })
})

$('#idroles' + _prefix_usuario).on("select2:select", function(evt) {
    var elm = $(evt.params.data.element)
    $(this).append(elm)
    $(this).trigger('change.select2')
})

//------------------------------------------------------------- Select empresa
$("#idempresa" + _prefix_usuario).on("change", function(e) {
    e.preventDefault()
    if ($(this).val() == "") {
        $("#idroles" + _prefix_usuario).html("").val("").select2("close")
        return false
    }

    if ($(this).val() > 0) {
        $("#idpersona" + _prefix_usuario).val("")
        $("#nombre_completo" + _prefix_usuario).val("")
    }
    get_role($(this).val(), false)
})

function get_role(id, _edit) {
    $.ajax({
        url: route('role.get_role'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('f', _path_controller_usuario, 'start') },
        success: function(response) {
            let list_p = ""
            let list = ""
            $(response).each(function(key, val) {
                if (_edit && val["id"] == data_form.idrole)
                    list_p = "<option value='" + val["id"] + "' >" + val["name"] + "</option>"
                else
                    list += "<option value='" + val["id"] + "' >" + val["name"] + "</option>"
            })
            $("#idroles" + _prefix_usuario).html(list_p + list)
            if (_edit) $('#idroles' + _prefix_usuario).val(data_form.idroles)

        },
        complete: function() { loading('f', _path_controller_usuario, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Init
function init() {
    $.each(data_form, function(key, val) {
        $("#" + key + _prefix_usuario, "#form-" + _path_controller_usuario).val(val)
    })
    get_role(data_form.idempresa, true)

    if (data_form.super_admin)
        $("#super_admin" + _prefix_usuario).click()
    
    if (reset_true == true) return false
    $("#password" + _prefix_usuario, "#form-" + _path_controller_usuario).val("******")
    $("#password_confirmation" + _prefix_usuario, "#form-" + _path_controller_usuario).val("******")
    $("#password" + _prefix_usuario, "#form-" + _path_controller_usuario).attr("disabled", true)
    $("#password_confirmation" + _prefix_usuario, "#form-" + _path_controller_usuario).attr("disabled", true)
}

//------------------------------------------------------------- Cancelar
$(document).on("click", "#cancelar" + _prefix_usuario, function(e) {
    e.preventDefault()
    window.location.href = route(_path_controller_usuario + ".index")
})

//------------------------------------------------------------- Autocomplete
if ($("#autocomplete").length) {
    new Autocomplete('#autocomplete', {
        search: input => {
            return new Promise(resolve => {
                if (input.length < 2 || $("#idempresa" + _prefix_usuario).val() == "") {
                    return resolve([])
                }
                fetch(route("persona.buscar", [encodeURI(input)]))
                    .then(response => response.json())
                    .then(data => {
                        const results = data.search.map((result, index) => {
                            return { ...result, index }
                        })
                        resolve(results)
                    })
            })
        },

        renderResult: (result, props) => {
            return `
          <li ${props}>
            <div class="wiki-title">
              ${result.numero_documento_identidad}
            </div>
            <div class="wiki-snippet">
                ${result.nombre_completo}
            </div>
          </li>`
        },

        getResultValue: result => result.nombre_completo,
        onSubmit: result => {
            var evento = window.event || event
            evento.preventDefault()
            $("#idpersona" + _prefix_usuario).val(result.id)
        }
    })
}

//------------------------------------------------------------- Guardar, editar, eliminar y reset
form.register(_path_controller_usuario, {
    reset: function(id) {
        get_modal(_path_controller_usuario, _prefix_usuario, "reset", id, "_reset")
    },
    eliminar_restaurar: function(id, obj) {
        var $self = this
        let accion__ = obj.getAttribute('data-action')
        let textaccion_ = (accion__.substring(0, 7)) + 'ado'

        Swal.fire({
            title: "Confirmar",
            text: "¿Desea " + accion__ + " el registro seleccionado?",
            icon: "question",
            showCancelButton: !0,
            showLoaderOnConfirm: !0,
            confirmButtonText: "Confirmar",
            customClass: { confirmButton: "btn btn-outline-primary waves-effect", cancelButton: "btn btn-label-youtube waves-effect" }
        }).then(function(t) {
            if (t.isConfirmed) {
                $.ajax({
                    url: route(_path_controller_usuario + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_usuario, 'Registro ' + textaccion_ + ' correctamente')
                        $self.callback(response)
                        init_btn()
                    },
                    error: function(e) {
                        mostrar_errores_externos(e)
                    }
                })
            }
        })
    },
    guardar: function() {
        var $self = this
        let _form = "#form-" + _path_controller_usuario
        let post_data = new FormData($(_form)[0])
        if (data_form.length != 0)
            post_data.delete('password')

        //for (var pair of post_data.entries()) { console.log(pair[0] + ', ' + pair[1]) }; return false
        $.ajax({
            url: route(_path_controller_usuario + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() { loading('f', _path_controller_usuario, 'start') },
            success: function(response) {
                localStorage.usuario = "Datos grabados correctamente."
                $("#cancelar" + _prefix_usuario).trigger("click")
            },
            complete: function() { loading('f', _path_controller_usuario, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_usuario, _prefix_usuario)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })

    },
    guardar_reset: function() {
        var $self = this
        let _form = "#form-" + _path_controller_usuario
        let post_data = new FormData($(_form)[0])

        $.ajax({
            url: route(_path_controller_usuario + '.store_reset'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_usuario, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_usuario, 'Datos grabados correctamente')
                $self.callback(response)
                close_modal(_path_controller_usuario + "_reset")
            },
            complete: function() { loading('m', _path_controller_usuario, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_usuario, _prefix_usuario)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })

    },
    callback: function(data) {
        grilla.reload(_path_controller_usuario)
    }
})

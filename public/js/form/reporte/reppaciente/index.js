//------------------------------------------------------------- Extras
$(".select2").length && $(".select2").each(function() {
    $(this).select2({ dropdownParent: $(this).parent() })
})
$('#rangofecha' + _prefix_reppaciente).daterangepicker({ todayHighlight: !0, orientation: isRtl ? "auto right" : "auto left" })

//------------------------------------------------------------- Traer area
function traer_area(e, obj) {
    e.preventDefault()
    if ($(obj).val() == "") {
        $("#idarea" + _prefix_reppaciente).html("").val("").select2("close")
        $("#idespecialidad" + _prefix_reppaciente).html("").val("").select2("close")
        return false
    }
    get_area($(obj).val())
}

//------------------------------------------------------------- Get area
function get_area(id) {
    $.ajax({
        url: route('area.get_area'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('m', _path_controller_reppaciente, 'start') },
        success: function(response) {
            let list = "<option></option>"
            list += "<option value='#'>Todos</option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' >" + val["descripcion"] + "</option>"
            })
            $("#idarea" + _prefix_reppaciente).html(list)
        },
        complete: function() { loading('m', _path_controller_reppaciente, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}


//------------------------------------------------------------- Traer especialidad
function traer_especialidad(e, obj) {
    e.preventDefault()
    if ($(obj).val() == "") {
        $("#idespecialidad" + _prefix_reppaciente).html("").val("").select2("close")
        return false
    }

    if ($(obj).val() == "#") {
        let list = "<option></option>"
        list += "<option value='#'>Todos</option>"
        $("#idespecialidad" + _prefix_reppaciente).html(list)
        setTimeout(() => { $("#idespecialidad" + _prefix_reppaciente).val('#').trigger('change') }, 10)
        return false
    }
    get_especialidad($(obj).val())
}

//------------------------------------------------------------- Get especialidad
function get_especialidad(id) {
    $.ajax({
        url: route('especialidad.get_especialidad'),
        type: 'GET',
        data: { idarea: id },
        dataType: 'json',
        beforeSend: function() { loading('m', _path_controller_reppaciente, 'start') },
        success: function(response) {
            let list = "<option></option>"
            list += "<option value='#'>Todos</option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' >" + val["descripcion"] + "</option>"
            })
            $("#idespecialidad" + _prefix_reppaciente).html(list)
            setTimeout(() => { $("#idespecialidad" + _prefix_reppaciente).val('#').trigger('change') }, 10)
        },
        complete: function() { loading('m', _path_controller_reppaciente, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}


//------------------------------------------------------------- Generar reporte
function generar_reporte(e, obj) {
    e.preventDefault()
    let accion = $(obj).data('accion')
    let _form = '#form-' + _path_controller_reppaciente
    let post_data = $(_form).serialize() + '&accion=' + accion

    $(obj).attr('disabled', true).prepend('<span class="spinner-grow" role="status" aria-hidden="true"></span>')
    $.ajax({
        url: route(_path_controller_reppaciente + '.generar_reporte'),
        type: 'GET',
        data: post_data,
        dataType: 'json',
        success: function(response) {
            post_data += '&validacion=true'
            let id = 'reporte_iframe-' + _path_controller_reppaciente
            let url_web = _path_controller_reppaciente + '.generar_reporte'

            limpieza(_path_controller_reppaciente)
            if ($('#otrapestana' + _prefix_reppaciente).prop('checked')) {
                return window.open(route(url_web, post_data))
            }
            traer_contenido_html(id, url_web, post_data)
        },
        complete: function() { $(obj).removeAttr('disabled').find('.spinner-grow').remove() },
        error: function(e) {
            $(obj).removeAttr('disabled').find('.spinner-grow').remove()
            if (e.status == 422) {
                recorer_errores(e.responseJSON.errors, _path_controller_reppaciente, _prefix_reppaciente)
            } else {
                mostrar_errores_externos(e)
            }
        }
    })

}

//------------------------------------------------------------- Init
if (!data_empresa.length)
    $('#idempresa' + _prefix_reppaciente).val(data_empresa.id).trigger('change')

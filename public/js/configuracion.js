//------------------------------------------------------------- Variables globales
let selected = ""
let data_form = ""
let btn_el_rest = "#btn-destroy"
let msj_sesion = "La sesión ya expiró, por favor cierre sesión y vuelva a ingresar."
let msj_soporte = "Hubo problemas internos, por favor comunicate de inmediato con SOPORTE."
let msj_accesos = "Lo sentimos, usted no tiene los permisos para realizar dicha acción."
let msj_denegada = "El registro actual no tiene las opciones de editar y eliminar."
let mover_modal = ""
var stepper = ""

// Dropzone
var remover_file = false
var files_tmp = []
let prev_dropzone = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename text-dark link" data-dz-name onclick="ver_archivo(event)"></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`

// Filtros
let filtro_estado = 1
let filtro_empresa = -1

tippy('.btn_actualizar', { content: "Actualizar", placement: 'top', arrow: true })
tippy('.btn_filtro', { content: "Filtros", placement: 'top', arrow: true })
tippy('.btn_guardarcache', { content: "Guardado temporal de la venta", placement: 'top', arrow: true })
tippy('.btn_eliminarcache', { content: "Reiniciar guardado temporal de la venta", placement: 'top', arrow: true })

//Toquen
csrf_token($('meta[name="csrf-token"]').attr('content'))

//------------------------------------------------------------- Carga
$('.loader-wrapper').fadeOut('slow', function() { $(this).remove() })

//------------------------------------------------------------- Ver texto
$('.mastexto').click(function(e) {
    e.preventDefault()
    $(this).toggleClass('vertexto')
})

//------------------------------------------------------------- Numero entero
function numero_entero(e, obj) {
    const solo_numeros = /^["0-9","+"," "]+$/.test(e.target.value)
    if (!solo_numeros) $(obj).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
}

//------------------------------------------------------------- Pegar solo numero decimal
function pegar_entero(e) {
    const text_pegado = (e.clipboardData || window.clipboardData).getData('text').trim()
    const solo_numeros = /^\d+$/
    if (!solo_numeros.test(text_pegado)) e.preventDefault()
}

//------------------------------------------------------------- Numero decimal
function numero_decimal(e, obj) {
    const solo_numeros = /^[0-9]+(\.[0-9]{0,4})?$/.test(e.target.value)
    if (!solo_numeros) $(obj).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
}

//------------------------------------------------------------- Pegar solo numero decimal
function pegar_decimal(e) {
    const text_pegado = (e.clipboardData || window.clipboardData).getData('text').trim()
    const solo_numeros = /^(\d+|\d*\.\d{0,4})$/
    if (!solo_numeros.test(text_pegado)) e.preventDefault()
}

//------------------------------------------------------------- Ubigeo Provincia
function get_provincia(tipo, iddepartamento, editar_, loading_, path_controller_, prefix_, data_form_) {
    let label = (tipo == 'ubigeo') ? 'Provincia' : 'Provincia de ' + tipo
    tipo = (tipo == 'ubigeo') ? '' : '_' + tipo

    if (iddepartamento == '' || iddepartamento == null) {
        $('#idprovincia' + tipo + prefix_).html('')
        $('#iddistrito' + tipo + prefix_).html('')
        return false
    }

    $('#idprovincia' + tipo + prefix_).html('')
    $('#iddistrito' + tipo + prefix_).html('')
    $.ajax({
        url: route('ubigeo.get_provincia', encodeURI(iddepartamento)),
        beforeSend: function() { loading(loading_, path_controller_, 'start') },
        success: function(response) {
            var select = document.getElementById('idprovincia' + tipo + prefix_)
            let opt_lab = document.createElement('option')
            opt_lab.setAttribute('label', label)
            select.appendChild(opt_lab)

            response.map((e, index) => {
                let opt = document.createElement('option')
                opt.value = e.id
                opt.innerHTML = e.descripcion
                select.appendChild(opt)
            })

            switch (tipo) {
                case '_procedencia':
                    if (editar_) $('#idprovincia' + tipo + prefix_).val(data_form_.distrito_procedencia.provincia.id).trigger('change')
                    break
                case '_actual':
                    if (editar_) $('#idprovincia' + tipo + prefix_).val(data_form_.distrito_actual.provincia.id).trigger('change')
                    break
                default:
                    if (editar_) $('#idprovincia' + tipo + prefix_).val(data_form_.distrito.provincia.id).trigger('change')
                    break
            }
        },
        complete: function() { loading(loading_, path_controller_, 'end') },
    })
}

//------------------------------------------------------------- Ubigeo Distrito
function get_distrito(tipo, idprovincia, editar_, loading_, path_controller_, prefix_, data_form_) {
    let label = (tipo == 'ubigeo') ? 'Distrito' : 'Distrito de ' + tipo
    tipo = (tipo == 'ubigeo') ? '' : '_' + tipo

    if (idprovincia == '' || idprovincia == null) {
        $('#iddistrito' + tipo + prefix_).html('')
        return false
    }

    $('#iddistrito' + tipo + prefix_).html('')
    $.ajax({
        url: route('ubigeo.get_distrito', encodeURI(idprovincia)),
        beforeSend: function() { loading(loading_, path_controller_, 'start') },
        success: function(response) {
            var select = document.getElementById('iddistrito' + tipo + prefix_)
            let opt_lab = document.createElement('option')
            opt_lab.setAttribute('label', label)
            select.appendChild(opt_lab)

            response.map((e, index) => {
                let opt = document.createElement('option')
                opt.value = e.id
                opt.innerHTML = e.descripcion
                select.appendChild(opt)
            })

            switch (tipo) {
                case '_procedencia':
                    if (editar_) $('#iddistrito' + tipo + prefix_).val(data_form_.distrito_procedencia.id).trigger('change')
                    break
                case '_actual':
                    if (editar_) $('#iddistrito' + tipo + prefix_).val(data_form_.distrito_actual.id).trigger('change')
                    break
                default:
                    if (editar_) $('#iddistrito' + tipo + prefix_).val(data_form_.distrito.id).trigger('change')
                    break
            }
            editar = false
        },
        complete: function() { loading(loading_, path_controller_, 'end') },
    })
}

//------------------------------------------------------------- Destruir Dropzone
function desctroy_dropzone() {
    remover_file = true
    $('.dropzone').each(function() {
        let dzControl = $(this)[0].dropzone
        if (dzControl) dzControl.destroy()
    })
    remover_file = false

    const dropzoneElement = document.querySelector("div#dropzone-basic")
    if (dropzoneElement) {
        dropzoneElement.innerHTML = `
            <div class="dz-message needsclick">
                <p class="fs-6 note needsclick pt-3 mb-2">
                    Arrastra y suelta tu archivo aquí o 
                    <a href="javascript:void(0)" class="text-info text-link" id="btnBrowse">busca tu archivo</a>
                </p>
            </div>
        `
    }
}


//------------------------------------------------------------- Inframe
function traer_contenido_html(id, url_web, data) {
    var url = route(url_web, data)
    $("#" + id).attr('src', url)
}

function recorer_errores(data, path_controller_, prefix_) {
    limpieza(path_controller_)
    $.each(data, function(i, item) {
        if (i == 'required_accesos') {
            toastar.warning('Notificación accesos', 'Es necesario eliminar los permisos en el módulo accesos antes de continuar.')
        }
        if (i == 'idpersona') {
            $(`#nombre_completo${prefix_}`).addClass('is-invalid')
        }

        if (i == 'required_apertura') {
            toastar.warning('Notificación caja', item)
        }

        $(`#${i+prefix_}`).addClass('is-invalid')
        $(`[for="${i+prefix_}"]`).addClass('is_invalid')
        //$(`[icon="${i+prefix_}"] i`).addClass('is_invalid')
        if (document.querySelector(`#msjerror_${i+prefix_}`))
            $(`#msjerror_${i+prefix_}`).html(item)
    })
    $('#form-' + path_controller_ + ' .is-invalid').first().focus()

}
//------------------------------------------------------------- configuracion datatable
$(document).ready(function() {
    if ($('.datatable').length) {
        $.extend($.fn.dataTable.defaults, {
            bLengthChange: false,
            processing: true,
            serverSide: true,
            destroy: true,
            responsive: true,
            autoWidth: false,
            ordering: true,
            rowId: "id",
        })
    }
})

//------------------------------------------------------------- Cambiar password
function cambiar_password(e) {
    e.preventDefault()

    var $self = this
    let _form = "#form-password_change"
    let post_data = $(_form).serialize()

    $.ajax({
        url: route('home' + '.password_change'),
        type: 'POST',
        data: post_data,
        cache: false,
        processData: false,
        beforeSend: function() {
            //loading()
        },
        success: function(response) {
            swal({ title: "Todo correcto", text: "Se han cambiado la contraseña. Redirigiendo al login...", timer: 3000, showConfirmButton: !1, type: "success" })
            setTimeout(reload, 3000)
        },
        complete: function() {
            //loading("complete")
        },
        error: function(e) {

            //Msj($("#descripcion"), "Ingrese Descripcion ","","above",false)
            if (e.status == 422) { //Errores de Validacion
                limpieza('password_change')
                $.each(e.responseJSON.errors, function(i, item) {
                    if (i == 'referencias') {
                        toastr.warning(item, 'Notificación de Módulo Inicio')
                    }

                    $('#' + i + "_home").addClass('is_invalid')
                    $('.select2-' + i + "_home").addClass('select2-is_invalid')
                    $('.' + i + "_home").removeClass('d-none')
                    $('.' + i + "_home").attr('data-content', item)
                    $('.' + i + "_home").addClass('msj_error_exist')

                })
                $("#form-password_change" + " .msj_error_exist").first().popover('show')

            } else {
                mostrar_errores_externos(e)
            }
        }
    })
}

//------------------------------------------------------------- Actualizar datatable
function actualizar_datatable(e) {
    e.preventDefault()
    table.ajax.reload()
}

//------------------------------------------------------------- Csrf token
function csrf_token(csrf_token) {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrf_token } })
}

//------------------------------------------------------------- Borrar localStore
const deletemsj_localstore = (id) => {
    localStorage.removeItem(id)
}

/*------------------------------------------------------------- Notificacion
function notificacion_url(e, obj, id) {
    e.preventDefault()
    var url = $(obj).attr('data-url')

    $.ajax({
        url: route('marcar_notificacion'),
        type: 'POST',
        data: { id: id, estado: 2 },
        beforeSend: function() {},
        success: function(response) {
            window.location.href = url
        },
        complete: function() {

        },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}*/

/*class TimeSpan {
    constructor(milisegundos) {
        this.Value = milisegundos
        for (const def of TimeSpan.definiciones) {
            this[def.key] = this.Value / def.factor
        }
    }

    toString() {
        let res = []
        let value = this.Value
        for (const def of TimeSpan.definiciones) {
            if (this[def.key] < 1 || value == 0) continue
            let intPart = Math.floor(value / def.factor)

            value = value - (intPart * def.factor)
            let nombre = intPart == 1 ? def.nombre.substring(0, def.nombre.length - 1) : def.nombre
            res.push(`${intPart} ${nombre}`)

        }

        return res.join(", ")
    }
    valueOf() {
        return this.value
    }
    static FromMiliseconds(ms) {
        return new TimeSpan(ms)
    }
    static FromSeconds(s) {
        return new TimeSpan(s * 1000)
    }

    static definiciones = [
        { key: 'TotalYears', factor: 60 * 60 * 24 * 365 * 1000, nombre: "Años" },
        { key: 'TotalDays', factor: 60 * 60 * 24 * 1000, nombre: "Días" },
        { key: 'TotalHours', factor: 60 * 60 * 1000, nombre: "Horas" },
        { key: 'TotalMinutes', factor: 60 * 1000, nombre: "Minutos" },
        { key: 'TotalSeconds', factor: 1 * 1000, nombre: "Segundos" }
    ]
}*/


//------------------------------------------------------------- Cambiar rol
function cambiar_rol(id) {
    $.ajax({
        url: route('cambiar_rol', id),
        type: 'GET',
        cache: false,
        processData: false,
        beforeSend: function() {},
        success: function(response) {
            localStorage.mensaje = "Se ha cambiado el rol"
            location.reload()
        },
        complete: function() {},
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Select tr
$(".datatable").on('click', 'tr', function(e) {
    selected = table.row(this).data()

    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected')
        if (document.querySelectorAll(btn_el_rest).length && table.row(this).data() != undefined) { init_btn() }
        if (typeof resumendia === 'function') { graficos_resumendia(data_cajadia, 1) }
    } else {
        table.$('tr.selected').removeClass('selected')
        $(this).addClass('selected')

        //selecionar el estado
        if (document.querySelectorAll(btn_el_rest).length && table.row(this).data() != undefined) {

            if (table.row(this).data()["deleted_at"] == null) {
                init_btn()
            } else {
                $(btn_el_rest).html('<span><i class="ti ti-rotate-clockwise-2"></i></span>')
                $(btn_el_rest).attr("data-action", "restaurar")
                $(btn_el_rest).removeClass("text-danger")
                $(btn_el_rest).addClass("text-success")
            }
        }

        if (typeof resumendia === 'function' && table.row(this).data() != undefined) { resumendia(selected.id) }

    }

})

//------------------------------------------------------------- Alertas
var alertas = function() {
    function warning(titulo = '', texto = 'Seleccione un registro.', tipo = 'warning', texto_bnt = 'Entendido') {
        Swal.fire({
            title: titulo,
            text: texto,
            type: tipo,
            icon: tipo,
            showClass: { popup: "animate__animated animate__shakeX" },
            customClass: { confirmButton: "btn btn-outline-primary waves-effect" },
            buttonsStyling: !1
        })
    }
    return { warning: warning }

}()

//------------------------------------------------------------- Toastar
var toastar = function() {
    const elem = document.querySelector(".toast-ex")
    const elem1 = document.querySelector(".toast-placement-ex")
    let a, i, r, l;

    function c(t) {
        t && null !== t._element && (
            elem && (elem.classList.remove(a, n), elem.querySelector(".ti").classList.remove(a)), t.dispose()
        )
    }

    function c1(t) {
        t && null !== t._element && (
            elem1 && (elem1.classList.remove(a, n), elem1.querySelector(".ti").classList.remove(a)), t.dispose()
        )
    }

    function success(titulo = 'Notificación', texto = 'Datos guardados correctamente.') {
        elem.querySelector("#toast_titulo").textContent = titulo
        elem.querySelector(".toast-body").textContent = texto
        r && c(r),
            a = 'text-success',
            n = 'animate__bounceInRight',
            elem.classList.add(n),
            elem.querySelector(".ti").classList.add(a),
            (r = new bootstrap.Toast(elem)).show()
    }

    function warning(titulo = 'Notificación CODEtime', texto = 'Ups !!.') {
        elem.querySelector("#toast_titulo").textContent = titulo
        elem.querySelector(".toast-body").textContent = texto
        r && c(r),
            a = 'text-warning',
            n = 'animate__bounceInRight',
            elem.classList.add(n),
            elem.querySelector(".ti").classList.add(a),
            (r = new bootstrap.Toast(elem)).show()
    }

    function con_internet(titulo = 'CODEtime') {
        elem1.setAttribute('data-bs-delay', '6000')
        elem1.querySelector("#toast_titulo").textContent = titulo
        elem1.querySelector(".toast-body").textContent = "Se ha restaurado la conexión a internet."
        r && c1(r),
            a = 'text-success',
            n = 'animate__bounceInRight',
            elem1.classList.add(n),
            elem1.querySelector(".ti").classList.add(a),
            elem1.querySelector(".ti").classList.add('ti-wifi'),
            (r = new bootstrap.Toast(elem1)).show()
    }

    function sin_internet(titulo = 'CODEtime') {
        elem1.setAttribute('data-bs-delay', '1000000')
        elem1.querySelector("#toast_titulo").textContent = titulo
        elem1.querySelector(".toast-body").textContent = "En este momento no tienes conexión a internet."
        r && c1(r),
            a = 'text-danger',
            n = 'animate__bounceInRight',
            elem1.classList.add(n),
            elem1.querySelector(".ti").classList.add(a),
            elem1.querySelector(".ti").classList.add('ti-wifi-off'),
            (r = new bootstrap.Toast(elem1)).show()
    }

    return { success: success, warning: warning, con_internet: con_internet, sin_internet: sin_internet }

}()

//------------------------------------------------------------- Grilla
var grilla = function() {

    function _get_real_id(idobject) {
        if ($("table[realid='" + idobject + "']").length == 1) {
            var table = "dt-" + idobject

            var realId = "#" + table

            if ($.fn.DataTable.isDataTable(realId)) {
                return table
            } else {
                console.log(idobject + " podria no ser una instancia de DataTables")
            }
        } else {
            console.log("El objeto DOM no existe o existe mas de una instancia para " + idobject)
        }

        return false
    }

    function get_data(idobject, iRow) {
        var table = _get_real_id(idobject)

        if (table !== false) {
            var api = $("#" + table).DataTable()

            if (iRow === undefined) {
                if (api.$("tr.selected").length) {
                    iRow = api.$("tr.selected")
                } else if (api.$("tr.DTTT_selected[role='row']").length) {
                    iRow = api.$("tr.DTTT_selected[role='row']")
                }
            }

            if (iRow !== undefined) {
                return api.row(iRow).id() || null
            }
        }
        return null
    }

    function get_id(idobject, iRow) {
        var row = get_data(idobject, iRow)

        if (row != null) {
            return row
        }
        return null
    }

    function reload(idobject, bool) {
        var table = _get_real_id(idobject)
        if (typeof bool != 'boolean')
            bool = true

        if (table !== false) {
            $("#" + table).DataTable().draw(bool)
        }
    }

    return { get_id: get_id, get_data: get_data, reload: reload }

}()

//------------------------------------------------------------- Modal
var form = function() {
    var aControllers = []

    function clearfix(keyvar) {
        keyvar = $.trim(keyvar)
        keyvar = keyvar.replace(/\W+/g, "")
        keyvar = keyvar.replace(/\s+/g, "")
        return keyvar
    }

    function register(key, val, replace) {
        key = clearfix(key)

        if (typeof replace != "boolean")
            replace = false

        if (key != "") {
            if (replace === true) { // nueva asignacion
                aControllers[key] = val
            } else if (!(key in aControllers)) { // no existe el registro
                aControllers[key] = val
            } else if (!$.isPlainObject(val)) { // no es un objeto
                aControllers[key] = val
            } else if ($.isEmptyObject(val)) { // objeto esta vacio
                aControllers[key] = val
            } else { // extendemos nomas
                var object = $.extend({}, get(key), val)
                aControllers[key] = object
            }
        }
    }

    function get(key) {
        key = clearfix(key)
        if (!(key in aControllers)) {
            console.log("key " + key + " not found")
            return {}
        }

        return aControllers[key]
    }

    return { register: register, get: get }
}()


//------------------------------------------------------------- Abrir modal
const get_modal = (_paht, _prefix, funcion = "create", id = null, extra = null) => {
    var _ruta = _paht
    _paht = (extra == null) ? _paht : _paht + extra

    $.ajax({
        url: route(_ruta + "." + funcion, id),
        type: 'GET',
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            $("#div_md-" + _paht).html(response)
            if (data_form.length != 0) {
                $.each(data_form, function(key, val) {
                    switch (key) {
                        case 'documento':
                        case 'rutaimagen':
                            console.log(key)
                            break
                        case 'icono':
                        case 'icon':
                            if (val) {
                                $("#" + key + _prefix, "#form-" + _paht).val(val)
                                set_icono(val, '#form-' + key + _paht)
                            }
                            break
                        default:
                            if (document.querySelector('#' + key + _prefix, '#form-' + _paht + '.clase2'))
                                $('#' + key + _prefix, '#form-' + _paht).val(val).trigger('change')
                            else
                                $('#' + key + _prefix, '#form-' + _paht).val(val)
                            break
                    }
                })
                if (typeof init === 'function')
                    setTimeout(() => { init() }, 200)

            } else if (typeof init_create === 'function') {
                setTimeout(() => { init_create() }, 200)
            }
        },
        complete: function() { $("#md-" + _paht).modal('toggle') },
        error: function(e) {
            $("#div_md-" + _paht).html('')
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Cerrar modal
const close_modal = (_paht) => {
    $("#md-" + _paht).modal("hide")
}

//------------------------------------------------------------- Acciones modal
const md_guardar = (e, obj) => {
    e.preventDefault()
    let accion = ($(obj).data('acciones')).split('-')
    switch (accion[0]) {
        case "guardar_reset":
            form.get(accion[1]).guardar_reset()
            break
        case "guardar_proceso":
            form.get(accion[1]).guardar_proceso()
            break
        case "guardar_persona":
            form.get(accion[1]).guardar_persona()
            break
        default:
            form.get(accion[1]).guardar()
            break
    }
}

const text_icono = (e, obj, id_icono) => {
    let valor = ($(obj).val() == '') ? 'ti ti-square-rounded-chevron-down-filled' : $(obj).val()
    set_icono(valor, id_icono)
}

//------------------------------------------------------------- Selec icono
const selecionar_icono = (e, obj, id_input, id_icono, valor) => {
    set_icono(valor, id_icono)
    $(id_input).val(valor)
}

//------------------------------------------------------------- Ver icono
const set_icono = (valor, id_icono) => {
    $(id_icono).attr('class', '')
    $(id_icono).addClass(valor)
}

//------------------------------------------------------------- Limpieza
const limpieza = (_paht, idform = false) => {
    var id = (idform) ? _paht : '#form-' + _paht
    $(id + ' .is-invalid').removeClass('is-invalid')
    $(id + ' .is_invalid').removeClass('is_invalid')
    $(id + ' .is_invalidfile').removeClass('is_invalidfile')
    $('.invalid-feedback').html('')
}

const init_btn = () => {
    if (document.querySelectorAll(btn_el_rest).length) {
        $(btn_el_rest).attr("class", "")
        $(btn_el_rest).html('<span><i class="fa-regular fa-trash-can mx-1"></i></span>')
        $(btn_el_rest).attr("data-action", " eliminar")
        $(btn_el_rest).addClass("btn btn-outline text-danger")
    }
}

//------------------------------------------------------------- Errores
const mostrar_errores_externos = (e) => {
    if (e.status == 419) {
        console.log(msj_sesion)
    } else if (e.status == 413) {
        toastar.warning('Notificación', 'Los archivos seleccionados superan el tamaño máximo permitido. Revise los archivos e inténtelo nuevamente.')
    } else if (e.status == 500) {
        const msj_error = (e.responseJSON.message) ? msj_soporte : e.responseJSON.message
        toastar.warning('Notificación CODEtime', msj_error)
    } else if (e.status == 403) {
        toastr.warning(msj_accesos, 'Notificación accesos')
    }
}

//------------------------------------------------------------- Loding
const loading = (opcion, path, accion, id = null) => {
    // opcion : m --> modal || f --> formulario
    switch (opcion) {
        case 'm':
            if (accion == 'start') {
                $('#modal_body-' + path).block({ message: '<span class="align_center text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><p class="m-0">&nbspGargando...</p></span>', css: { backgroundColor: "transparent", border: "0" }, overlayCSS: { backgroundColor: "var(--bg_cargar)", opacity: .8 } })
            } else {
                $('#modal_body-' + path).unblock()
            }
            break
        case 'f':
            if (accion == 'start') {
                $('#form_body-' + path).block({ message: '<span class="align_center text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><p class="m-0">&nbspGargando...</p></span>', css: { backgroundColor: "transparent", border: "0" }, overlayCSS: { backgroundColor: "var(--bg_cargar)", opacity: .8 } })
            } else {
                $('#form_body-' + path).unblock()
            }
            break
        case 'x':
            if (accion == 'start') {
                $('body').block({ message: '<span class="align_center text-primary"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><p class="m-0">&nbspGargando...</p></span>', css: { backgroundColor: "transparent", border: "0" }, overlayCSS: { backgroundColor: "var(--bg_cargar)", opacity: .8 } })
            } else {
                $('body').unblock()
            }
            break
        default:
            console.log('Aca falta')
            break
    }
}

/*const loading2 = (accion, element, efecto) => {
    efecto = (efecto === undefined) ? 'loader_principal' : efecto
    if (accion == 'star')
        return $(element).addClass(efecto)
    return $(element).removeClass(efecto)

}*/

//------------------------------------------------------------- Mover modal
function mover_mouse({ movementX, movementY }) {
    let getContainerStyle = window.getComputedStyle(mover_modal)
    let leftValue = parseInt(getContainerStyle.left)
    let topValue = parseInt(getContainerStyle.top)
    mover_modal.style.left = `${leftValue + movementX}px`
    mover_modal.style.top = `${topValue + movementY}px`
}

const draggable = (id, handle) => {
    mover_modal = id
    $(handle).on('mousedown', () => { mover_modal.addEventListener('mousemove', mover_mouse) })
    $(handle).on('mouseup contextmenu', () => { mover_modal.removeEventListener('mousemove', mover_mouse) })
}

//------------------------------------------------------------- Filtros
function abrir_filtro(e) {
    e.preventDefault()
    $('#div-filtros').toggleClass('d-none')
}

$('.li-filtro').click(function(e) {
    e.preventDefault()
    change_filtro($(this).data())
})

function change_filtro(obj) {
    eval('filtro_' + obj.tipo + `='${obj.filtro}'`)
    document.getElementById('filtro' + obj.tipo).textContent = (obj.texto.length > 12) ? obj.texto.substring(0, 12) + '...' : obj.texto
    table.ajax.reload()
}

//------------------------------------------------------------- Internet
const volvio_inter = () => {
    toastar.con_internet()
}

function conexion_internet() {
    if (window.navigator.onLine) {
        setTimeout(volvio_inter, 500)
    } else {
        toastar.sin_internet()
    }
}
window.addEventListener('online', conexion_internet)
window.addEventListener('offline', conexion_internet)

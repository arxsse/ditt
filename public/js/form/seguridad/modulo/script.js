//------------------------------------------------------------- Variables globales
var array_boton = []

//------------------------------------------------------------- Extras
draggable(document.querySelector('#md-' + _path_controller_modulo), '.modal-head')
$('#form-' + _path_controller_modulo + ' .select2').select2({ dropdownParent: $('#md-' + _path_controller_modulo) })

//------------------------------------------------------------- Traer rol y modulo padre
function traer_padre_boton(e, obj) {
    e.preventDefault()
    if ($(obj).val() == "") {
        $("#idpadre" + _prefix_modulo).html("").val("").select2("close")
        $("#idboton" + _prefix_modulo).html("").val("").select2("close")
        return false
    }
    get_padre($(obj).val())
    get_boton($(obj).val())
}

//------------------------------------------------------------- Modulo padre
function get_padre(id) {
    $.ajax({
        url: route(_path_controller_modulo + '.get_padre'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('m', _path_controller_modulo, 'start') },
        success: function(response) {
            let list = "<option></option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' >" + val["descripcion"] + "</option>"
            })
            $("#idpadre" + _path_controller_modulo).html(list)
        },
        complete: function() { loading('m', _path_controller_modulo, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

//------------------------------------------------------------- Boton
function get_boton(id) {
    $.ajax({
        url: route('boton.get_boton'),
        type: 'GET',
        data: { idempresa: id },
        dataType: 'json',
        beforeSend: function() { loading('m', _path_controller_modulo, 'start') },
        success: function(response) {
            let list = "<option></option>"
            $(response).each(function(key, val) {
                list += "<option value='" + val["id"] + "' data-descripcion='" + val["descripcion"] + "' data-icono='" + val["icono"] + "' >" + val["descripcion"] + "</option>"
            })
            $("#idboton" + _path_controller_modulo).html(list)
        },
        complete: function() { loading('m', _path_controller_modulo, 'end') },
        error: function(e) {
            mostrar_errores_externos(e)
        }
    })
}

function select_boton(event, obj) {
    event.preventDefault()
    let id = parseInt($(obj).val())
    let descripcion = $(obj).find(':selected').attr('data-descripcion')
    let icono = $(obj).find(':selected').attr('data-icono')
    var data = []

    if (id == 0 || isNaN(id)) { return false }
    var comprobar = array_boton.find(element => (element.idboton === id)) ? true : false
    if (comprobar) {
        toastar.warning('Notificación ' + _name_module_modulo, 'El boton ya fue agregada')
        setTimeout(limpiar_select2(), 10)
        return false
    }
    array_boton.push({ id: null, idboton: id, descripcion: descripcion, icono: icono })

    //---- Crear tabla
    document.getElementById("table_boton").innerHTML = ""
    crear_tabla()
    setTimeout(limpiar_select2(), 10)
}

function crear_tabla() {
    const lista = document.querySelector('#table_boton')
    const template = document.querySelector('#template_boton').content
    const fragment = document.createDocumentFragment()
    array_boton.forEach((data, index) => {
        array_boton[index].id = index + 1
        template.querySelector('.nro').textContent = index + 1
        template.querySelector('.descripcion_boton i').setAttribute("class", data.icono)
        template.querySelector('.descripcion_boton span').textContent = data.descripcion
        template.querySelector('.btn_eliminar').setAttribute("onclick", "eliminar_boton(event," + index + ")")
        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })
}

function eliminar_boton(e, id) {
    e.preventDefault()
    array_boton.splice(id, 1)
    document.getElementById("table_boton").innerHTML = ""
    crear_tabla()
}

function limpiar_select2(id) {
    $("#idboton" + _prefix_modulo).select2("val", 0)
}

//------------------------------------------------------------- Init create
function init_create() {
    if (!data_empresa.length)
        $('#idempresa' + _prefix_modulo).val(data_empresa.id).trigger('change')
}

//------------------------------------------------------------- Init
function init() {
    if (data_form.accesos_directo)
        $("#accesos_directo" + _prefix_modulo).click()

    if (data_form.idpadre)
        $('#idpadre' + _prefix_modulo).val(data_form.idpadre).trigger('change')

    if (data_boton.length) {
        data_boton.forEach((datos, index) => {
            array_boton.push({ id: datos.id, idboton: datos.idboton, descripcion: datos.boton.descripcion, icono: datos.boton.icono })
        })

        //---- Crear tabla
        document.getElementById("table_boton").innerHTML = ""
        crear_tabla()
    }
}

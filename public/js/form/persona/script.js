//------------------------------------------------------------- Variables globales
var editar = false

//------------------------------------------------------------- Extras
draggable(document.querySelector('#md-' + _path_controller_persona), '.modal-head')
$('#form-' + _path_controller_persona + ' .select2').select2({ dropdownParent: $('#md-' + _path_controller_persona) })
$('#fecha_nacimiento' + _prefix_persona).datepicker({ todayHighlight: !0, orientation: isRtl ? "auto right" : "auto left" })

//------------------------------------------------------------- Exten
if (typeof _path_controller_prestamo == 'string') {
    if (editpersona == false) {
        $('#idempresa' + _prefix_persona).val(1).trigger('change')
        $('#idtipopersona' + _prefix_persona).val(1).trigger('change')

        setTimeout(() => {
            const input = document.getElementById('numero_documento_identidad' + _prefix_persona)
            input.value = dni_temporal
            input.dispatchEvent(new Event("input", { bubbles: true }))
            input.focus()
        }, 800)
    }
    setTimeout(() => { $('#numero_documento_identidad' + _prefix_persona).focus() }, 800)
}

//------------------------------------------------------------- Celular
$('#celular' + _prefix_persona).on('input', function(e) {
    const solo_numeros = /^["0-9","+"," "]+$/.test(e.target.value)
    if (!solo_numeros) $(this).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
})

//------------------------------------------------------------- DNI
$('#numero_documento_identidad' + _prefix_persona).on('input', function(e) {
    const solo_numeros = /^["0-9","+"," "]+$/.test(e.target.value)
    if (!solo_numeros) $(this).val(function(i, oldValue) { return oldValue.substring(0, oldValue.length - 1) })
})

//------------------------------------------------------------- Ubigeo
$('#iddepartamento_procedencia' + _prefix_persona).change(function(e) {
    e.preventDefault()
    get_provincia('procedencia', $(this).val(), editar, 'm', _path_controller_persona, _prefix_persona, data_form)
})
$('#idprovincia_procedencia' + _prefix_persona).change(function(e) {
    e.preventDefault()
    get_distrito('procedencia', $(this).val(), editar, 'm', _path_controller_persona, _prefix_persona, data_form)
})

$('#iddepartamento_actual' + _prefix_persona).change(function(e) {
    e.preventDefault()
    get_provincia('actual', $(this).val(), editar, 'm', _path_controller_persona, _prefix_persona, data_form)
})

$('#idprovincia_actual' + _prefix_persona).change(function(e) {
    e.preventDefault()
    get_distrito('actual', $(this).val(), editar, 'm', _path_controller_persona, _prefix_persona, data_form)
})

//------------------------------------------------------------- Consulta SUNAT
function consulta_sunat(obj) {
    if ($('#apellido_paterno' + _prefix_persona).val().trim() !== '' || $('#apellido_materno' + _prefix_persona).val().trim() !== '' || $('#nombres' + _prefix_persona).val().trim() !== '') {

        $('#apellido_paterno' + _prefix_persona).val('')
        $('#apellido_materno' + _prefix_persona).val('')
        $('#nombres' + _prefix_persona).val('')
    }

    const solo_numeros = /^[0-9]+$/.test(obj.value)
    if (!solo_numeros) $('#ruc' + _prefix_persona).val(function(i, oldValue) { return oldValue.replace(/\D/g, '') })

    let idtipodocumento = document.getElementById('idtipo_documento_identidad' + _prefix_persona)
    if (idtipodocumento.value < 1) { return $(this).val('') }

    let selected_option = idtipodocumento.options[idtipodocumento.selectedIndex]
    const longitud = selected_option.dataset.rango
    let numero_documento = document.getElementById('numero_documento_identidad' + _prefix_persona)
    let numero_documento_value = numero_documento.value

    if (numero_documento_value.length > longitud) { return numero_documento.value = numero_documento_value.slice(0, longitud) }

    if (numero_documento_value.length == 8 && longitud == 8) {
        $.ajax({
            url: route('persona.consulta_sunat', encodeURI(numero_documento_value)),
            beforeSend: function() { loading('m', _path_controller_persona, 'start') },
            success: function(response) {
                if (response.message) { return false }

                let nombres = response.nombres.toLowerCase().split(' ')
                let nombres_capitalizados = nombres.map(function(nombre) {
                    return nombre.charAt(0).toUpperCase() + nombre.slice(1)
                })

                let apellido_paterno = response.apellidoPaterno.toLowerCase()
                let primer_letra_apellido = apellido_paterno.charAt(0).toUpperCase()
                let resto_apellido = apellido_paterno.slice(1)

                let apellido_materno = response.apellidoMaterno.toLowerCase()
                let primer_letra_materno = apellido_materno.charAt(0).toUpperCase()
                let resto_materno = apellido_materno.slice(1)

                $('#apellido_paterno' + _prefix_persona).val(primer_letra_apellido + resto_apellido)
                $('#apellido_materno' + _prefix_persona).val(primer_letra_materno + resto_materno)
                $('#nombres' + _prefix_persona).val(nombres_capitalizados.join(' '))
            },
            complete: function() { loading('m', _path_controller_persona, 'end') },
        })
    }
}

//------------------------------------------------------------- Apellido paterno
$('#apellido_paterno' + _prefix_persona).on('input', function(e) {
    const primer_letra_mayuscula = e.target.value.charAt(0).toUpperCase()
    const resto_letras_minusculas = e.target.value.slice(1).toLowerCase()
    const nuevo_valor = primer_letra_mayuscula + resto_letras_minusculas
    $(this).val(nuevo_valor)
})

//------------------------------------------------------------- Apellido materno
$('#apellido_materno' + _prefix_persona).on('input', function(e) {
    const primer_letra_mayuscula = e.target.value.charAt(0).toUpperCase()
    const resto_letras_minusculas = e.target.value.slice(1).toLowerCase()
    const nuevo_valor = primer_letra_mayuscula + resto_letras_minusculas
    $(this).val(nuevo_valor)
})

//------------------------------------------------------------- Nombres
$('#nombres' + _prefix_persona).on('input', function(e) {
    // Reemplazar múltiples espacios por un solo espacio
    const nuevo_valor = e.target.value.replace(/\s+/g, ' ')

    const nombres_formateados = nuevo_valor.split(' ').map(nombre => {
        const primer_letra_mayuscula = nombre.charAt(0).toUpperCase()
        const resto_letras_minusculas = nombre.slice(1).toLowerCase()
        return primer_letra_mayuscula + resto_letras_minusculas
    })

    const nuevo_valorFormateado = nombres_formateados.join(' ')
    $(this).val(nuevo_valorFormateado)
})

//------------------------------------------------------------- Init create
function init_create() {
    if (!data_empresa.length)
        $('#idempresa' + _prefix_persona).val(data_empresa.id).trigger('change')
}

//------------------------------------------------------------- Init
function init() {
    $('#fecha_nacimiento' + _prefix_persona).val(data_form.fecha_nacimiento).datepicker('update')
    if (data_form.distrito_procedencia != null) {
        editar = true
        $('#iddepartamento_procedencia' + _prefix_persona).val(data_form.distrito_procedencia.provincia.iddepartamento).trigger('change')
    }
    if (data_form.distrito_actual != null) {
        editar = true
        $('#iddepartamento_actual' + _prefix_persona).val(data_form.distrito_actual.provincia.iddepartamento).trigger('change')

    }
}

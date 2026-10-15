//------------------------------------------------------------- Variables globales
var files_aceptados = 'application/pdf'
var pdfDataURL = null
var files_tmp = []
var index_ = 0
var editar = false
var data_tipoderechoautor = []
var data_requisitos = []
var max_files = 1

//------------------------------------------------------------- Extras
"use strict";
[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e) { return new bootstrap.Popover(e) })
crear_tabla()

//------------------------------------------------------------- Tipo derecho autor
function select_tipoderechoautor(e, obj) {
    let descripcion = $(obj).attr('data-descripcion')
    let idtipoderechoautor = obj.value
    let indextipoderechoautor = data_tipoderechoautor.findIndex(x => x.id == idtipoderechoautor)
    let compro = (data_tipoderechoautor[indextipoderechoautor].id == 1) ? true : false;

    $('#tipo_derechoautor').text('Su solicitud para ' + descripcion + ' fue enviada correctamente')
    max_files = data_tipoderechoautor[indextipoderechoautor].requisitosform.length
    tabla_tipoderechoautor(data_tipoderechoautor[indextipoderechoautor].requisitosform)
    input_urlcodigofuente(compro)
    init_myDropzone()
    files_tmp = []
}

function input_urlcodigofuente(compo = false) {
    if (compo) {
        $('#section_urlcodigofuente')
            .addClass("col-md-12 mt-4 mb-3 px-4")
            .html(`
                <div class="form-floating input-group input-group-merge">
                    <input type="text" class="form-control" name="urlcodigofuente" id="urlcodigofuente" placeholder="&nbsp;">
                    <label for="urlcodigofuente">URL c&oacute;digo fuente*</label>
                    <span icon="urlcodigofuente" class="input-group-text"><i class="ti ti-code"></i></span>
                </div>
                <div id="msjerror_urlcodigofuente" class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
            `);
    } else {
        $('#section_urlcodigofuente')
            .removeClass("col-md-12 mt-4 mb-3 px-4")
            .empty();
    }
}

function tabla_tipoderechoautor(datos) {
    const lista = document.querySelector('#ul_requisito')
    const template = document.querySelector('#template_requisito').content
    const fragment = document.createDocumentFragment()
    document.getElementById("ul_requisito").innerHTML = ""

    data_requisitos = datos
    datos.forEach((data, index) => {
        template.querySelector('li span').innerHTML = "-&nbsp;" + data.descripcion + "&nbsp;&nbsp;"
        template.querySelector('li a').setAttribute("href", data.urlejemplo)
        if (data.urlejemplo.trim() === "") {
            template.querySelector('li a').classList.add("d-none");
        } else {
            template.querySelector('li a').classList.remove("d-none");
        }

        const clone = template.cloneNode(true)
        fragment.appendChild(clone)
        lista.appendChild(fragment)
    })
}

function add_integrante(e) {
    e.preventDefault()
    crear_tabla()
}

function crear_tabla() {
    const lista = document.querySelector('#formulario_integrante')
    const template = document.querySelector('#template_integrante').content
    const fragment = document.createDocumentFragment()

    template.querySelector('.form_documento').id = "form_documento" + index_
    template.querySelector('.form_documento').setAttribute("data-id", index_)

    template.querySelector('.idfacultad').id = "idfacultad" + index_
    template.querySelector('.idfacultad').name = "idfacultad" + index_
    template.querySelector('.lb_idfacultad').htmlFor = "idfacultad" + index_
    template.querySelector('.idfacultad').setAttribute("onchange", "select_facu_ofi(event, this, " + index_ + ")")
    template.querySelector('.msjerror_idfacultad').id = "msjerror_idfacultad" + index_

    template.querySelector('.idoficina').id = "idoficina" + index_
    template.querySelector('.idoficina').name = "idoficina" + index_
    template.querySelector('.lb_idoficina').htmlFor = "idoficina" + index_
    template.querySelector('.idoficina').setAttribute("onchange", "select_facu_ofi(event, this, " + index_ + ")")
    template.querySelector('.msjerror_idoficina').id = "msjerror_idoficina" + index_

    template.querySelector('.idtipo_documento_identidad').id = "idtipo_documento_identidad" + index_
    template.querySelector('.idtipo_documento_identidad').name = "idtipo_documento_identidad" + index_
    template.querySelector('.msjerror_idtipo_documento_identidad').id = "msjerror_idtipo_documento_identidad" + index_

    template.querySelector('.numero_documento_identidad').id = "numero_documento_identidad" + index_
    template.querySelector('.numero_documento_identidad').name = "numero_documento_identidad" + index_
    template.querySelector('.numero_documento_identidad_label').htmlFor = "numero_documento_identidad" + index_
    template.querySelector('.numero_documento_identidad').setAttribute("data-index", index_)
    template.querySelector('.msjerror_numero_documento_identidad').id = "msjerror_numero_documento_identidad" + index_

    template.querySelector('.principal').id = "principal" + index_
    template.querySelector('.principal').value = "principal" + index_
    template.querySelector('.principal_label').htmlFor = "principal" + index_

    template.querySelector('.apellido_paterno').id = "apellido_paterno" + index_
    template.querySelector('.apellido_paterno').name = "apellido_paterno" + index_
    template.querySelector('.apellido_paterno_label').htmlFor = "apellido_paterno" + index_
    template.querySelector('.msjerror_apellido_paterno').id = "msjerror_apellido_paterno" + index_

    template.querySelector('.apellido_materno').id = "apellido_materno" + index_
    template.querySelector('.apellido_materno').name = "apellido_materno" + index_
    template.querySelector('.apellido_materno_label').htmlFor = "apellido_materno" + index_
    template.querySelector('.msjerror_apellido_materno').id = "msjerror_apellido_materno" + index_

    template.querySelector('.nombres').id = "nombres" + index_
    template.querySelector('.nombres').name = "nombres" + index_
    template.querySelector('.nombres_label').htmlFor = "nombres" + index_
    template.querySelector('.msjerror_nombres').id = "msjerror_nombres" + index_

    template.querySelector('.iddepartamento_actual').id = "iddepartamento_actual" + index_
    template.querySelector('.iddepartamento_actual').name = "iddepartamento_actual" + index_
    template.querySelector('.iddepartamento_actual').setAttribute("onchange", "get_provincia_form(event, this, " + index_ + ")")
    template.querySelector('.msjerror_iddepartamento_actual').id = "msjerror_iddepartamento_actual" + index_

    template.querySelector('.idprovincia_actual').id = "idprovincia_actual" + index_
    template.querySelector('.idprovincia_actual').name = "idprovincia_actual" + index_
    template.querySelector('.idprovincia_actual').setAttribute("onchange", "get_distrito_form(event, this, " + index_ + ")")
    template.querySelector('.msjerror_idprovincia_actual').id = "msjerror_idprovincia_actual" + index_

    template.querySelector('.iddistrito_actual').id = "iddistrito_actual" + index_
    template.querySelector('.iddistrito_actual').name = "iddistrito_actual" + index_
    template.querySelector('.msjerror_iddistrito_actual').id = "msjerror_iddistrito_actual" + index_

    template.querySelector('.fecha_nacimiento').id = "fecha_nacimiento" + index_
    template.querySelector('.fecha_nacimiento').name = "fecha_nacimiento" + index_
    template.querySelector('.fecha_nacimiento_label').htmlFor = "fecha_nacimiento" + index_
    template.querySelector('.msjerror_fecha_nacimiento').id = "msjerror_fecha_nacimiento" + index_

    template.querySelector('.tipocalle').id = "tipocalle" + index_
    template.querySelector('.tipocalle').name = "tipocalle" + index_
    template.querySelector('.tipocalle_label').htmlFor = "tipocalle" + index_
    template.querySelector('.msjerror_tipocalle').id = "msjerror_tipocalle" + index_

    template.querySelector('.direccion').id = "direccion" + index_
    template.querySelector('.direccion').name = "direccion" + index_
    template.querySelector('.direccion_label').htmlFor = "direccion" + index_
    template.querySelector('.msjerror_direccion').id = "msjerror_direccion" + index_

    template.querySelector('.correo').id = "correo" + index_
    template.querySelector('.correo').name = "correo" + index_
    template.querySelector('.correo_label').htmlFor = "correo" + index_
    template.querySelector('.msjerror_correo').id = "msjerror_correo" + index_


    template.querySelector('.celular').id = "celular" + index_
    template.querySelector('.celular').name = "celular" + index_
    template.querySelector('.celular_label').htmlFor = "celular" + index_
    template.querySelector('.msjerror_celular').id = "msjerror_celular" + index_


    template.querySelector('.idsexo').id = "idsexo" + index_
    template.querySelector('.idsexo').name = "idsexo" + index_
    template.querySelector('.msjerror_idsexo').id = "msjerror_idsexo" + index_

    template.querySelector('.divider').id = "divider" + index_
    if (index_ > 0) {
        template.querySelector('.btn_eliminar').id = "btn_eliminar" + index_
        template.querySelector('.btn_eliminar').setAttribute("onclick", "eliminar_integrante(event," + index_ + ")")
    }
    const clone = template.cloneNode(true)
    fragment.appendChild(clone)
    lista.appendChild(fragment)

    $("#idfacultad" + index_).select2()
    $("#idoficina" + index_).select2()
    $("#idtipo_documento_identidad" + index_).select2()
    $("#iddepartamento_actual" + index_).select2()
    $("#idprovincia_actual" + index_).select2()
    $("#iddistrito_actual" + index_).select2()
    $("#idsexo" + index_).select2()

    $('#fecha_nacimiento' + index_).datepicker({ todayHighlight: !0, orientation: isRtl ? "auto right" : "auto left" })

    if (index_ == 0) {
        document.getElementById('principal' + index_).checked = true
    } else {
        const elementos = document.querySelectorAll('.form_documento')
        const penultimo = elementos[elementos.length - 2]
        const dataId = penultimo.getAttribute('data-id')

        $("#divider" + dataId).removeClass('d-none')
        $("#btn_eliminar" + index_).removeClass('d-none')

        if ((document.querySelectorAll('.form_documento').length - 1) == 1) {
            $("#divider0").removeClass('d-none')
        }
    }
    index_++
}

function select_facu_ofi(e, obj, index) {
    e.preventDefault()
    let id = parseInt($(obj).val())
    if (id == 0 || isNaN(id)) { return false }

    let tipo = $(obj).data('tipo')
    if (tipo == 1) {
        setTimeout(function() {
            $('#idoficina' + index).select2("val", 0)
            $('#idoficina' + index).data('select2')
                .$container.find('.select2-selection__placeholder').text('Seleccione oficina');
            $('label[for="idoficina' + index + '"]').html('Seleccione oficina')

            $('#idfacultad' + index).data('select2')
                .$container.find('.select2-selection__placeholder').text('Seleccione facultad*');
            $('label[for="idfacultad' + index + '"]').html('Seleccione facultad*')
        }, 100)

    } else {
        setTimeout(function() {
            $('#idfacultad' + index).select2("val", 0)
            $('#idfacultad' + index).data('select2')
                .$container.find('.select2-selection__placeholder').text('Seleccione facultad');
            $('label[for="idfacultad' + index + '"]').html('Seleccione facultad')

            $('#idoficina' + index).data('select2')
                .$container.find('.select2-selection__placeholder').text('Seleccione oficina*');
            $('label[for="idoficina' + index + '"]').html('Seleccione oficina*')

        }, 100)
    }
}

function eliminar_integrante(e, id) {
    e.preventDefault()
    Swal.fire({
        title: "Confirmar",
        text: "¿Desea eliminar el registro seleccionado?",
        icon: "question",
        showCancelButton: !0,
        showLoaderOnConfirm: !0,
        confirmButtonText: "Confirmar",
        customClass: { confirmButton: "btn btn-outline-primary waves-effect", cancelButton: "btn btn-label-youtube waves-effect" }
    }).then(function(t) {
        if (t.isConfirmed) {
            const elementos = document.querySelectorAll('.form_documento')
            const ultimo = elementos[elementos.length - 1]
            const dataId = ultimo.getAttribute('data-id')

            if (id == dataId) {
                const penultimo = elementos[elementos.length - 2]
                const dataId = penultimo.getAttribute('data-id')
                $("#divider" + dataId).addClass('d-none')
            }

            const elemento = document.getElementById("form_documento" + id)
            elemento.parentNode.removeChild(elemento)
            if (document.querySelectorAll('.form_documento').length == 1) {
                $("#divider0").addClass('d-none')
            }
        }
    })
}

function get_provincia_form(e, obj, index) {
    e.preventDefault()
    get_provincia('actual', obj.value, editar, 'f', 'formulario', index, data_form)
}

function get_distrito_form(e, obj, index) {
    e.preventDefault()
    get_distrito('actual', obj.value, editar, 'f', 'formulario', index, data_form)
}

function consultar(obj) {
    let token = $('#token').val()
    let index = $(obj).data('index')
    let tipodocumento = $('#idtipo_documento_identidad' + index).val()
    const longitud = $('#idtipo_documento_identidad' + index).find(':selected').attr('data-rango')

    if (tipodocumento < 1) {
        return $(obj).val('')
    }
    if (obj.value.length > longitud) {
        return obj.value = obj.value.slice(0, longitud)
    }

    if (obj.value.length == 8 && longitud == 8) {
        $.ajax({
            url: route('formulario.consultar'),
            data: { token: token, tipodocumento: encodeURI(tipodocumento), nrodocumento: encodeURI(obj.value) },
            beforeSend: function() { loading('f', 'formulario', 'start') },
            success: function(response) {
                limpieza('#wizard-checkout-form', true)
                datos_integrante(response, index)
            },
            complete: function() { loading('f', 'formulario', 'end') },
        })
    }
}

function datos_integrante(data, index) {
    $.each(data, function(key, val) {
        switch (key) {
            case 'apellidoPaterno':
            case 'apellidoMaterno':
                let key_ = (key == 'apellidoPaterno') ? 'apellido_paterno' : 'apellido_materno'
                if (val != null) {
                    let apellido = val.toLowerCase()
                    let primer_letra_apellido = apellido.charAt(0).toUpperCase()
                    let resto_apellido = apellido.slice(1)
                    val = primer_letra_apellido + resto_apellido
                }
                $('#' + key_ + index, '#wizard-checkout-form').val(val)
                break
            case 'nombres':
                if (val != null) {
                    let nombre = val.toLowerCase().split(' ')
                    let nombres_capitalizados = nombre.map(function(nombre) {
                        return nombre.charAt(0).toUpperCase() + nombre.slice(1)
                    })
                    val = nombres_capitalizados.join(' ')
                }
                $('#' + key + index, '#wizard-checkout-form').val(val)
                break
            case 'distrito_actual':
                if (val != null) {
                    editar = true
                    data_form = data
                    val = val.provincia.iddepartamento
                }
                $('#iddepartamento_actual' + index).val(val).trigger('change')
                break
            case 'fecha_nacimiento':
                $('#' + key + index).val(val).datepicker('update')
                break
            default:
                if (document.querySelector('#' + key + index, '#wizard-checkout-form .clase2'))
                    $('#' + key + index, '#wizard-checkout-form').val(val).trigger('change')
                else
                    $('#' + key + index, '#wizard-checkout-form').val(val)
                break
        }
    })
    setTimeout(function() { data_form = "" }, 1000)
}

//------------------------------------------------------------- Dropzone
function init_myDropzone() {
    Dropzone.autoDiscover = false
    desctroy_dropzone()

    var myDropzone = new Dropzone("div#dropzone-basic", {
        acceptedFiles: files_aceptados,
        previewTemplate: prev_dropzone,
        addRemoveLinks: true,
        maxFiles: max_files,
        maxFilesize: 50,
        success: function(file, response) {
            const compro = files_tmp.findIndex(x => x.name == file.name);
            if (compro != -1) {
                remover_file = true
                toastar.warning('Notificación ', 'Se eliminó el archivo duplicado')
                myDropzone.removeFile(myDropzone.files[compro])
                remover_file = false
            } else {
                files_tmp.push(file)
            }
            limpieza('#wizard-checkout-form', true)

            if (file.type === "application/pdf") {
                const reader = new FileReader()
                reader.onload = function(e) {
                    pdfDataURL = e.target.result
                }
                reader.readAsDataURL(file)
            } else {
                pdfDataURL = null
            }
        }
    })
}

function ver_archivo(e) {
    e.preventDefault()
    if (pdfDataURL) {
        const nuevaPestana = window.open()
        if (nuevaPestana) {
            nuevaPestana.document.write(`
                    <html>
                        <head><title>Previsualización PDF</title></head>
                        <body style="margin:0">
                            <embed src="${pdfDataURL}" type="application/pdf" width="100%" height="100%"/>
                        </body>
                    </html>
                `)
        } else {
            alert("El navegador bloqueó la nueva pestaña. Activa los popups.")
        }
    }
}

function guardar(e) {
    e.preventDefault()

    let _form = "#wizard-checkout-form"
    let post_data = new FormData($(_form)[0])
    post_data.append('integrates_total', index_)
    post_data.append('files_tmp_total', files_tmp.length)
    files_tmp.forEach((file, i) => {
        post_data.append('files_tmp-' + i, file)
    })

    $.ajax({
        url: route('formulario.store'),
        type: 'POST',
        data: post_data,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() { loading('f', 'formulario', 'start') },
        success: function(response) {
            $('#celular_prin').text($('#celular' + response.index).val())

            $('#correo_prin').text($('#correo' + response.index).val())
            $('#correo_prin').attr("href", "mailto:" + $('#correo' + response.index).val())

            $('#nombre_prin').text(
                $('#nombres' + response.index).val() + ' ' +
                $('#apellido_paterno' + response.index).val() + ' ' +
                $('#apellido_materno' + response.index).val()
            )
            $('#fecha_envio').text(response.fecha + ' ' + response.hora)
            stepper.next()
        },
        complete: function() { loading('f', 'formulario', 'end') },
        error: function(e) {
            if (e.status == 422) {
                limpieza('#wizard-checkout-form', true)
                $.each(e.responseJSON.errors, function(i, item) {
                    $(`#${i}`).addClass('is-invalid')
                    $(`[for="${i}"]`).addClass('is_invalid')
                    if (document.querySelector(`#msjerror_${i}`))
                        $(`#msjerror_${i}`).html(item)

                    if (i == 'required_principal') {
                        toastar.warning('Notificación', item)
                    }

                    if(i == 'required_files'){
                    $("#dropzone-basic").addClass("is_invalidfile");
                    $("#msjerror_dropzone-basic").html(item);
                    }
                })

                if (document.querySelector('#checkout-cart .is-invalid')) {
                    $('#btn_anterior3').one('click', function() {
                        $('#btn_anterior2').trigger('click')
                    })
                    $('#btn_anterior3').trigger('click')
                }
                if (document.querySelector('#checkout-address .is-invalid') || document.querySelector('#checkout-address .is_invalidfile')) {
                    $('#btn_anterior3').trigger('click')
                }

                $('#wizard-checkout-form .is-invalid').first().focus()
            } else {
                mostrar_errores_externos(e)
            }
        }
    })
}

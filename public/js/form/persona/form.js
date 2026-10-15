form.register(_path_controller_persona, {
    nuevo: function() {
        get_modal(_path_controller_persona, _prefix_persona)
    },
    editar: function(id) {
        get_modal(_path_controller_persona, _prefix_persona, "edit", id)
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
                    url: route(_path_controller_persona + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success(titulo_notificacion, 'Registro ' + textaccion_ + ' correctamente')
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
    guardar_persona: function() {
        var $self = this
        let _form = '#form-' + _path_controller_persona
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_path_controller_persona + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_persona, 'start') },
            success: function(response) {
                close_modal(_path_controller_persona)
                toastar.success('Notificación persona', 'Datos grabados correctamente')

                //------------------------------------------------------------- Exten
                if (typeof _path_controller_prestamo == 'string') {
                    $("#idpersona" + _prefix_prestamo).val(response.id)
                    datos_cliente(response)
                    return false
                }
                $self.callback(response)

            },
            complete: function() { loading('m', _path_controller_persona, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    limpieza(_path_controller_persona)
                    $.each(e.responseJSON.errors, function(i, item) {
                        if (i == 'required_accesos')
                            return toastr.warning('Error al eliminar funciones , primero es necesario quitar los accesos', titulo_notificacion)

                        $(`#${i+_prefix_persona}`).addClass('is-invalid')
                        $(`[for="${i+_prefix_persona}"]`).addClass('is_invalid')
                        //$(`[icon="${i+_prefix_persona}"] i`).addClass('is_invalid')
                        $(`#msjerror_${i+_prefix_persona}`).html(item)
                    })

                    if (document.querySelector('#dt_basicos .is-invalid'))
                        $('.nav-tabs button[data-bs-target="#dt_basicos"]').tab('show')
                    else
                        $('.nav-tabs button[data-bs-target="#dt_otros"]').tab('show')

                    $('#form-' + _path_controller_persona + ' .is-invalid').first().focus()
                }
                if (e.status != 422)
                    mostrar_errores_externos(e)
            }
        })
    },
    callback: function(data) { grilla.reload(_path_controller_persona) }
})

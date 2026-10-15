form.register(_path_controller_tipo_documento_identidad, {
    nuevo: function() {
        get_modal(_path_controller_tipo_documento_identidad, _prefix_tipo_documento_identidad)
    },
    editar: function(id) {
        get_modal(_path_controller_tipo_documento_identidad, _prefix_tipo_documento_identidad, "edit", id)
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
                    url: route(_path_controller_tipo_documento_identidad + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_tipo_documento_identidad, 'Registro ' + textaccion_ + ' correctamente')
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
        let _form = '#form-' + _path_controller_tipo_documento_identidad
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_path_controller_tipo_documento_identidad + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_tipo_documento_identidad, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_tipo_documento_identidad)
                $self.callback(response)
                close_modal(_path_controller_tipo_documento_identidad)
            },
            complete: function() { loading('m', _path_controller_tipo_documento_identidad, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_tipo_documento_identidad, _prefix_tipo_documento_identidad)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) { grilla.reload(_path_controller_tipo_documento_identidad) }
})

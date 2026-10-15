form.register(_path_controller_boton, {
    nuevo: function() {
        get_modal(_path_controller_boton, _prefix_boton)
    },
    editar: function(id) {
        get_modal(_path_controller_boton, _prefix_boton, "edit", id)
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
                    url: route(_path_controller_boton + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_boton, 'Registro ' + textaccion_ + ' correctamente')
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
        let _form = '#form-' + _path_controller_boton
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_path_controller_boton + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_boton, 'start') },
            success: function(response) {
                loading('#form-' + _path_controller_boton, 'stop')
                toastar.success('Notificación ' + _name_module_boton, 'Datos grabados correctamente')
                $self.callback(response)
                close_modal(_path_controller_boton)
            },
            complete: function() { loading('m', _path_controller_boton, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_boton, _prefix_boton)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) { grilla.reload(_path_controller_boton) }
})

form.register(_path_controller_derechoautor, {
    proceso: function(id) {
        get_modal(_path_controller_derechoautor, _prefix_derechoautor, "proceso", id)
    },
    editar: function(id) {
        get_modal(_path_controller_derechoautor, _prefix_derechoautor, "edit", id)
    },
    show: function(id) {
        get_modal(_path_controller_derechoautor, _prefix_derechoautor, "show", id)
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
                    url: route(_path_controller_derechoautor + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_derechoautor, 'Registro ' + textaccion_ + ' correctamente')
                        $self.callback()
                        init_btn()
                    },
                    error: function(e) {
                        mostrar_errores_externos(e)
                    }
                })
            }
        })
    },
    guardar_proceso: function() {
        var $self = this
        let _form = "#form-" + _path_controller_derechoautor
        let post_data = new FormData($(_form)[0])

        $.ajax({
            url: route(_path_controller_derechoautor + '.store_proceso'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_derechoautor, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_derechoautor, 'Datos grabados correctamente')
                $self.callback(response)
                close_modal(_path_controller_derechoautor)
            },
            complete: function() { loading('m', _path_controller_derechoautor, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_derechoautor, _prefix_derechoautor)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })

    },
    callback: function() { grilla.reload(_path_controller_derechoautor) }
})

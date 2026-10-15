form.register(_path_controller_requisito, {
    nuevo: function() {
        get_modal(_path_controller_requisito, _prefix_requisito)
    },
    editar: function(id) {
        get_modal(_path_controller_requisito, _prefix_requisito, "edit", id)
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
                    url: route(_path_controller_requisito + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_requisito, 'Registro ' + textaccion_ + ' correctamente')
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
    guardar: function() {
        var $self = this
        let _form = '#form-' + _path_controller_requisito
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_path_controller_requisito + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_requisito, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_requisito)
                $self.callback()
                close_modal(_path_controller_requisito)
            },
            complete: function() { loading('m', _path_controller_requisito, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_requisito, _prefix_requisito)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function() { grilla.reload(_path_controller_requisito) }
})

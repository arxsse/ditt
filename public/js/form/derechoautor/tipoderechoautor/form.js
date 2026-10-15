form.register(_path_controller_tipoderechoautor, {
    nuevo: function() {
        get_modal(_path_controller_tipoderechoautor, _prefix_tipoderechoautor)
    },
    editar: function(id) {
        get_modal(_path_controller_tipoderechoautor, _prefix_tipoderechoautor, "edit", id)
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
                    url: route(_path_controller_tipoderechoautor + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_tipoderechoautor, 'Registro ' + textaccion_ + ' correctamente')
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
        let _form = '#form-' + _path_controller_tipoderechoautor
        let post_data = $(_form).serialize()

        $.ajax({
            url: route(_path_controller_tipoderechoautor + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_tipoderechoautor, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_tipoderechoautor)
                $self.callback()
                close_modal(_path_controller_tipoderechoautor)
            },
            complete: function() { loading('m', _path_controller_tipoderechoautor, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_tipoderechoautor, _prefix_tipoderechoautor)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function() { grilla.reload(_path_controller_tipoderechoautor) }
})

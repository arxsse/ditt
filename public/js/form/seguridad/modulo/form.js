form.register(_path_controller_modulo, {
    nuevo: function() {
        get_modal(_path_controller_modulo, _prefix_modulo)
    },
    editar: function(id) {
        get_modal(_path_controller_modulo, _prefix_modulo, "edit", id)
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
                    url: route(_path_controller_modulo + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_modulo, 'Registro ' + textaccion_ + ' correctamente')
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
        var $self = this;
        let _form = "#form-" + _path_controller_modulo
        let post_data = new FormData($(_form)[0])
        
        array_boton.forEach((datos, index) => {
            post_data.append("boton[" + index + "][index]", index)
            post_data.append("boton[" + index + "][id]", datos.id)
            post_data.append("boton[" + index + "][idboton]", datos.idboton)
        })
        //for (var pair of post_data.entries()) {console.log(pair[0]+ ', ' + pair[1]);} return false
        $.ajax({
            url: route(_path_controller_modulo + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_modulo, 'start') },
            success: function(response) {
                loading('#form-' + _path_controller_modulo, 'stop')
                toastar.success('Notificación ' + _name_module_modulo, 'Datos grabados correctamente')
                $self.callback(response)
                close_modal(_path_controller_modulo)
            },
            complete: function() { loading('m', _path_controller_modulo, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_modulo, _prefix_modulo)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) { grilla.reload(_path_controller_modulo) }
})

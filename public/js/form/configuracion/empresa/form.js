form.register(_path_controller_empresa, {
    nuevo: function() {
        get_modal(_path_controller_empresa, _prefix_empresa)
    },
    editar: function(id) {
        get_modal(_path_controller_empresa, _prefix_empresa, "edit", id)
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
                    url: route(_path_controller_empresa + '.destroy', 'delete'),
                    data: { id: id, accion: accion__ },
                    type: 'DELETE',
                    success: function(response) {
                        toastar.success('Notificación ' + _name_module_empresa, 'Registro ' + textaccion_ + ' correctamente')
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
        let _form = '#form-' + _path_controller_empresa
        let post_data = new FormData($(_form)[0])
        post_data.append('files_tmp_total', files_tmp.length)
        files_tmp.forEach((file, i) => {
            if(file.edit){
                post_data.append('files_tmp-' + i +'[name]', file.name)
                post_data.append('files_tmp-' + i +'[size]', file.size)
            }else{
                post_data.append('files_tmp-' + i, file)
            }
        })

        //for (var pair of post_data.entries()) { console.log(pair[0] + ', ' + pair[1]) }; return false
        $.ajax({
            url: route(_path_controller_empresa + '.store'),
            type: 'POST',
            data: post_data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() { loading('m', _path_controller_empresa, 'start') },
            success: function(response) {
                toastar.success('Notificación ' + _name_module_empresa)
                $self.callback(response)
                close_modal(_path_controller_empresa)
            },
            complete: function() { loading('m', _path_controller_empresa, 'end') },
            error: function(e) {
                if (e.status == 422) {
                    recorer_errores(e.responseJSON.errors, _path_controller_empresa, _prefix_empresa)
                } else {
                    mostrar_errores_externos(e)
                }
            }
        })
    },
    callback: function(data) { grilla.reload(_path_controller_empresa) }
})

//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()

    //------------------------------------------------------------- Localstore
    if (localStorage.getItem("usuario")) {
        toastar.success('Notificación ' + _name_module_usuario, localStorage.getItem("usuario"))
        setTimeout(deletemsj_localstore("usuario"), 100)
    }
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_usuario).DataTable({
        ajax: {
            url: route(_path_controller_usuario + '.grilla'),
            data: function(d) {
                d.empresa = filtro_empresa
                d.estado = filtro_estado
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            { data: 'persona.nombre_completo' },
            { data: 'persona.numero_documento_identidad' },
            { data: 'usuario' },
            {
                data: 'estado',
                orderable: false,
                searchable: false,
                className: "text-center"
            }
        ],
        order: [
            [1, 'ASC'],
            [2, 'ASC']
        ]
    })
}

var filterSearch = document.getElementById('buscar_datatable')
filterSearch.addEventListener('keyup', function(e) {
    table.search(e.target.value).draw()
})

//------------------------------------------------------------- Nuevo
$("#btn-create").on("click", function(e) {
    e.preventDefault()
    window.location.href = route(_path_controller_usuario + ".create")
})

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_usuario)
    if (id != null) {
        window.location.href = route(_path_controller_usuario + ".edit", id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_usuario)
    if (id != null) {
        form.get(_path_controller_usuario).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

//----------------------------------------------------------- Resetear
$("#btn-reset").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_usuario)
    if (id != null) {
        form.get(_path_controller_usuario).reset(id)
    } else {
        alertas.warning("Ups..!")
    }
})

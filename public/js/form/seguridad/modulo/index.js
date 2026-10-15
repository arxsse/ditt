//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_modulo).DataTable({
        ajax: {
            url: route(_path_controller_modulo + '.grilla'),
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
            {
                data: 'padre',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data)
                        return data.descripcion
                    return ''
                }
            },
            { data: 'descripcion' },
            { data: 'url' },
            {
                data: 'icono',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            { data: 'orden', className: "text-center" },
            {
                data: 'estado',
                orderable: false,
                searchable: false,
                className: "text-center"
            }
        ],
        order: [
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
    form.get(_path_controller_modulo).nuevo()
})

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_modulo)
    if (id != null) {
        form.get(_path_controller_modulo).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_modulo)
    if (id != null) {
        form.get(_path_controller_modulo).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

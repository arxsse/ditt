//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_boton).DataTable({
        ajax: {
            url: route(_path_controller_boton + '.grilla'),
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
            { data: 'descripcion' },
            { data: 'funcion' },
            {
                data: 'icono',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            {
                data: 'es_boton',
                orderable: false,
                searchable: false,
                className: "text-center",
                render: function(data, type, row) {
                    if (data == false) {
                        return "No"
                    }
                    return "Si";
                }
            },
            { data: 'orden',className: "text-center" },
            {
                data: 'estado',
                orderable: false,
                searchable: false,
                className: "text-center"
            }
        ],
        order: [
            [1, 'ASC']
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
    form.get(_path_controller_boton).nuevo()
})

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_boton)
    if (id != null) {
        form.get(_path_controller_boton).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_boton)
    if (id != null) {
        form.get(_path_controller_boton).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_tipoderechoautor).DataTable({
        ajax: {
            url: route(_path_controller_tipoderechoautor + '.grilla'),
            data: function(d) {
                d.estado = filtro_estado
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'categoria',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 1)
                        return 'Derecho de Autor'
                    return 'Patente'
                }
            },
            { data: 'descripcion' },
            {
                data: 'icono',
                orderable: false,
                searchable: false,
                className: "text-center"
            },
            { data: 'orden', className: 'text-center' },
            {
                data: 'estado',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
        ],
        order: [
            [4, 'ASC']
        ]
    })
}

var filterSearch = document.getElementById('buscar_datatable')
filterSearch.addEventListener('keyup', function(e) {
    table.search(e.target.value).draw()
})

//------------------------------------------------------------- Nuevo
$('#btn-create').on('click', function(e) {
    e.preventDefault()
    form.get(_path_controller_tipoderechoautor).nuevo()
})

//------------------------------------------------------------- Editar
$('#btn-edit').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_tipoderechoautor)
    if (id != null) {
        form.get(_path_controller_tipoderechoautor).editar(id)
    } else {
        alertas.warning('Ups..!')
    }
})

//------------------------------------------------------------- Eliminar
$('#btn-destroy').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_tipoderechoautor)
    if (id != null) {
        form.get(_path_controller_tipoderechoautor).eliminar_restaurar(id, this)
    } else {
        alertas.warning('Ups..!')
    }
})

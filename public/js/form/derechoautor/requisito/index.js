//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_requisito).DataTable({
        ajax: {
            url: route(_path_controller_requisito + '.grilla'),
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
            { data: 'tipoderechoautor.orden', visible: false },
            { data: 'tipoderechoautor.descripcion' },
            { data: 'descripcion' },
            {
                data: 'urlejemplo',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    if (data) {
                        let textoCorto = data.length > 25 ? data.substring(0, 25) + '...' : data;
                        return '<a href="' + data + '" target="_blank">' + textoCorto + '</a>';
                    }
                    return '';
                }
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
            [1, 'ASC'],
            [5, 'ASC']
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
    form.get(_path_controller_requisito).nuevo()
})

//------------------------------------------------------------- Editar
$('#btn-edit').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_requisito)
    if (id != null) {
        form.get(_path_controller_requisito).editar(id)
    } else {
        alertas.warning('Ups..!')
    }
})

//------------------------------------------------------------- Eliminar
$('#btn-destroy').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_requisito)
    if (id != null) {
        form.get(_path_controller_requisito).eliminar_restaurar(id, this)
    } else {
        alertas.warning('Ups..!')
    }
})

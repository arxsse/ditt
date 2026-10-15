//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_derechoautor).DataTable({
        ajax: {
            url: route(_path_controller_derechoautor + '.grilla'),
            data: function(d) {
                d.empresa = filtro_empresa
                d.estado = filtro_estado
            }
        },
        columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            { data: 'tipoderechoautor.descripcion' },
            { data: 'titulo' },
            { data: 'integranteprin.persona.nombre_completo', orderable: false },
            { data: 'fecha', className: 'text-center' },
            {
                data: 'detalle',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'proceso',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function(data, type, row) {
                    return '<span class="badge ' + data.clase + '">' + data.descripcion + '</span>'
                }
            }
        ],
        order: [
            [4, 'DESC']
        ]
    })
}

var filterSearch = document.getElementById('buscar_datatable')
filterSearch.addEventListener('keyup', function(e) {
    table.search(e.target.value).draw()
})

//------------------------------------------------------------- Editar
$('#btn-proceso').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_derechoautor)
    if (id != null) {
        form.get(_path_controller_derechoautor).proceso(id)
    } else {
        alertas.warning('Ups..!')
    }
})

//------------------------------------------------------------- Editar
$('#btn-edit').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_derechoautor)
    if (id != null) {
        form.get(_path_controller_derechoautor).editar(id)
    } else {
        alertas.warning('Ups..!')
    }
})

//------------------------------------------------------------- Show
function abrir_show(e, obj, id) {
    e.preventDefault()
    setTimeout(function() { $('tr#' + id).addClass('selected') }, 200)
    form.get(_path_controller_derechoautor).show(id)
}

//------------------------------------------------------------- Eliminar
$('#btn-destroy').on('click', function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_derechoautor)
    if (id != null) {
        form.get(_path_controller_derechoautor).eliminar_restaurar(id, this)
    } else {
        alertas.warning('Ups..!')
    }
})

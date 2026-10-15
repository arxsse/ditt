//------------------------------------------------------------- Variables globales
let titulo_notificacion = 'Notificación ' + _name_module_persona

//------------------------------------------------------------- Cargar al Inicio
$(document).ready(function() {
    load_datatable()
})

//------------------------------------------------------------- Datatable
const load_datatable = () => {
    table = $('#dt-' + _path_controller_persona).DataTable({
        ajax: {
            url: route(_path_controller_persona + '.grilla'),
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
            { data: 'numero_documento_identidad', className: "text-center" },
            { data: 'nombre_completo' },
            { data: 'correo' },
            { data: 'celular', className: "text-center" },
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
    form.get(_path_controller_persona).nuevo()
})

//------------------------------------------------------------- Editar
$("#btn-edit").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_persona)
    if (id != null) {
        form.get(_path_controller_persona).editar(id)
    } else {
        alertas.warning("Ups..!")
    }
})

//------------------------------------------------------------- Eliminar
$("#btn-destroy").on("click", function(e) {
    e.preventDefault()
    var id = grilla.get_id(_path_controller_persona)
    if (id != null) {
        form.get(_path_controller_persona).eliminar_restaurar(id, this)
    } else {
        alertas.warning("Ups..!")
    }
})
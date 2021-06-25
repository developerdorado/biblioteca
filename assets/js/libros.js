
    let datatables = $('#results').DataTable( {
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "searchPlaceholder": "Buscar...",
            "sSearch": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "<div id=\"loading\" class=\"text-center\"><div class=\"lds-ripple\"><div></div><div></div></div></div>",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Útimo",
                "sNext": "<a href=\"javascript:void();\" style=\"outline: none;\" aria-controls=\"datatable-basic\" data-dt-idx=\"0\" tabindex=\"0\" class=\"\"><i class=\"fas fa-angle-right\"></i></a>",
                "sPrevious": "<a href=\"javascript:void();\" style=\"outline: none;\" aria-controls=\"datatable-basic\" data-dt-idx=\"0\" tabindex=\"0\" class=\"\"><i class=\"fas fa-angle-left\"></i></a>"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "processing": true,
        "serverSide": true,
        "ajax": "./api/api.php?action=get_books",
        lengthMenu: [
            [10, 50, 100],
            [10, 50, 100]
        ],
        "order": [
            [0, "desc"]
        ],
        "autoWidth": false,
    columns: [
        {   data: 'idlib',
            searchable: true,
            sortable: true
         },
        {   data: 'nombre_libro',
            searchable: true,
            visible: true
        },
        {   data: 'fecha_ingreso',
            searchable: true,
            sortable: true 
        },
        {   data: 'estado',
            searchable: true,
            sortable: true,
            render: function (data, type, row, meta) {
                var estado = "";
                var color = "";
                if(row.estado == 1){
                    estado = "PRESTADO";
                    color = "danger"
                }else{
                    estado = "DISPONIBLE";
                    color = "success";
                }

                return `<span class=\"btn btn-outline-${color} btn-sm estados\">${ estado }</span>`;
            
            } 
        },
        {   data: 'actions',
            render: function (data, type, row, meta) {
            
            return `
            <a class="btn btn-sm edit" data-bs-toggle="modal" data-bs-target="#editarLibro">
            <i class="fas fa-pencil-alt fa-lg"></i>
            </a>
            <a class="btn btn-sm" data-id-libro="${row.idlib}" onClick="javascript:alert('Funcion no disponible: Esta funcion esta pensada para ver el historial detallado de las veces que se ha prestado este libro.');">
            <i class="fas fa-history fa-lg"></i>
            </a>
            <a class="btn btn-sm" data-id-libro="${row.idlib}" onClick="javascript:alert('Funcion no disponible: Esta funcion esta pensada para eliminar el libro de la BD.');">
            <i class="fas fa-trash fa-lg"></i>
            </a>`;
           }
        },
      ],
      responsive: true,
      drawCallback: () => {
          $('[data-toggle="tooltip"]').tooltip();
      },

    } );

    editar_libro("#results tbody", datatables);

    function reload() {
        return datatables.ajax.reload();
    }

    $("#registro_libro").submit(function(event) {
        $('#guardar_libro').attr("disabled", true);
    
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "./api/api.php?action=save_libro",
            data: parametros,
            beforeSend: function(objeto) {
            },
            success: function(datos) {
                if ('error' in datos) {
                   toastr.error(datos.error);
                } else {
                    toastr.success(datos.message);
                    $("#registro_libro")[0].reset();
                    reload()
                }
                $('#guardar_libro').attr("disabled", false);
            }
        });
        event.preventDefault();
    })
    
    $("#edit_libro").submit(function(event) {
        $('#editar_libro').attr("disabled", true);
    
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "./api/api.php?action=edit_libro",
            data: parametros,
            beforeSend: function(objeto) {
                //table.ajax.reload();
            },
            success: function(datos) {
                if ('error' in datos) {
                    toastr.error(datos.error);
                } else {
                    toastr.success(datos.message);
                    reload();
                }
                $('#editar_libro').attr("disabled", false);
            }
        });
        event.preventDefault();
    })


    function editar_libro(tbody, datatable) {
        $(tbody).on("click", "a.edit", function() {
            let data = datatable.row($(this).parents('tr')).data();
            console.log(data);
            var cc = 0;
            $('#editarLibro').on('shown.bs.modal', function(event) {
                var modal = $(this);
                modal.find('.modal-body #idlib').val(data.idlib)
                console.log(modal.find('.modal-body #idlib'));
                modal.find('.modal-body #nombre_libro').val(data.nombre_libro)
                //$(this).off('show.bs.modal');
            })
        });
    }


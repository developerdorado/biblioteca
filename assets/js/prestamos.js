
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
        "serverSide": false,
        "ajax": "./api/api.php?action=get_prestamos",
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
        {   data: 'nombre',
            searchable: true,
            sortable: true,
            render: function (data, type, row, meta) {
                return row.nombre + " " +row.apellido;
            
            } 
        },
        {   data: 'fecha_limite',
            searchable: true,
            visible: true
        },
        {   data: 'estado_prestamo',
            searchable: true,
            sortable: true,
            render: function (data, type, row, meta) {
                var estado = "";
                var color = "";
                if(row.estado_prestamo == "ACTIVO"){
                    estado = "ACTIVO";
                    color = "danger"
                }else{
                    estado = "FINALIZADO";
                    color = "success";
                }

                return `<span class=\"btn btn-outline-${color} btn-sm estados\">${ estado }</span>`;
            
            } 
        },
        {   data: 'actions',
            render: function (data, type, row, meta) {
            
                return `
                <a class="btn btn-sm edit" data-bs-toggle="modal" data-bs-target="#editarPrestamo">
                <i class="fas fa-pencil-alt fa-lg"></i>
                </a>
                <a class="btn btn-sm" data-id-libro="${row.idlib}" onClick="javascript:alert('Funcion no disponible: Esta funcion esta pensada para ver el historial detallado de los cambio de estado de este libro.');">
                <i class="fas fa-history fa-lg"></i>
                </a>
                <a class="btn btn-sm" data-id-libro="${row.idlib}" onClick="javascript:alert('Funcion no disponible: Esta funcion esta pensada para eliminar el prestamo de la BD.');">
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

    editar_prestamo("#results tbody", datatables);

    function reload() {
        return datatables.ajax.reload();
    }

    $("#registro_prestamo").submit(function(event) {
        $('#guardar_prestamo').attr("disabled", true);
    
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "./api/api.php?action=save_prestamo",
            data: parametros,
            beforeSend: function(objeto) {
            },
            success: function(datos) {
                if ('error' in datos) {
                   toastr.error(datos.error);
                } else {
                    toastr.success(datos.message);
                    $("#registro_prestamo")[0].reset();
                    reload()
                }
                $('#guardar_prestamo').attr("disabled", false);
            }
        });
        event.preventDefault();
    })
    
    $("#editar_prestamo").submit(function(event) {
        $('#edit_prestamo').attr("disabled", true);
    
        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "./api/api.php?action=edit_prestamos",
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
                $('#edit_prestamo').attr("disabled", false);
            }
        });
        event.preventDefault();
    })


    function editar_prestamo(tbody, datatable) {
        $(tbody).on("click", "a.edit", function() {
            let data = datatable.row($(this).parents('tr')).data();
            console.log(data);
            var cc = 0;
            $('#editarPrestamo').on('shown.bs.modal', function(event) {
                var modal = $(this);
                modal.find('.modal-body #edit_idlib').val(data.idlib)
                modal.find('.modal-body #edit_nombre_libro').val(data.nombre_libro)
                modal.find('.modal-body #estado_prestamo').val(data.estado_prestamo)
                modal.find('.modal-body #identificacion').val(data.identificacion)
                modal.find('.modal-body #nombre').val(data.nombre)
                modal.find('.modal-body #apellido').val(data.apellido)
                modal.find('.modal-body #fecha_nacimiento').val(data.fecha_nacimiento)
                modal.find('.modal-body #telefono').val(data.telefono)
                modal.find('.modal-body #fecha_limite').val(data.fecha_limite)
                //$(this).off('show.bs.modal');
            })
        });
    }



    $(function() {
    
        $("#idlib").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "./api/api.php?action=autocomplete",
                    type: "GET",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nombre_libro,
                                nombre_libro: item.nombre_libro,
                                idlib: item.idlib,
                                estado: item.estado,
                                success: item.success,
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                event.preventDefault(); //preventing default methods
                if(ui.item.success == "false"){
                    $('#guardar_prestamo').attr("disabled", true);
                    $('#nombre_libro').val(ui.item.nombre_libro);
                }else{
                    $('#guardar_prestamo').attr("disabled", false);
                    $("#idlib").val(ui.item.idlib); // display the selected text
                    $('#nombre_libro').val(ui.item.nombre_libro);
                    if(ui.item.estado == 1){
                        $('#estado').text("PRESTADO");
                        $('#estado').addClass('btn-outline-danger').removeClass('btn-outline-success');
                    }else{
                        $('#estado').text("DISPONIBLE");
                        $('#estado').addClass('btn-outline-success').removeClass('btn-outline-danger');
                    }
                }
                
            },
            minLength: 2,
        }).bind('focus', function() {
            $('.ui-autocomplete').css('z-index', '9999999999999999999').css('left', '0px');
        });
    });
    
    $("#idlib").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $("#idlib").val("");
            $("#nombre_libro").val("");
            $("#estado").text("STATUS");
            
    
        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $("#idlib").val("");
            $("#nombre_libro").val("");
            $("#estado").text("STATUS");
        }
    });
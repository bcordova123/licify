



function tabla(url,id){
   
    var dataTable = $('#'+id).DataTable({  
        dom: 'Bflrtip',
        "lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "Todos"] ],
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copiar',
                className: 'btn btn-primary mb-2',
              /*  exportOptions: {
                    columns: [1,2,3,4]
                } */
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                className: 'btn btn-success mb-2',
              /*  exportOptions: {
                    columns: [1,2,3,4]
                } */
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                className: 'btn btn-info mb-2',
             /*  exportOptions: {
                    columns: [1,2,3,4]
                } */
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                className: 'btn btn-danger mb-2',
              /*  exportOptions: {
                    columns: [1,2,3,4]
                } */
            }
            
        ],
        pageLength: 10,
        "autoWidth": false,
        "processing": true,  
        "serverSide": true,
        "language": {
         "sProcessing":     "Procesando...",
         "sLengthMenu":     "Mostrar _MENU_ registros",
         "sZeroRecords":    "No se encontraron resultados",
         "sEmptyTable":     "Ningún dato disponible en esta tabla",
         "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
         "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
         "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
         "sInfoPostFix":    "",
         "sSearch":         "Buscar:",
         "sUrl":            "",
         "sInfoThousands":  ",",
         "sLoadingRecords": "Cargando...",
         "oPaginate": {
             "sFirst":    "Primero",
             "sLast":     "Último",
             "sNext":     "Siguiente",
             "sPrevious": "Anterior"
         },
         "oAria": {
             "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
             "sSortDescending": ": Activar para ordenar la columna de manera descendente"
         }
     },
        "order":[],  
        "ajax":{  
             url: url,  
             type: "POST",
             data: function ( data ) {
                console.log(data);
            },
            error:function(err, status){
             // what error is seen(it could be either server side or client side.
             console.log(err.responseText);
         }
        },
        "columnDefs":[  
             {  
                  "targets":[0],  
                  "orderable": false,  
             },  
        ], 
         
   });  
}

// "targets":[0, 5,6],  


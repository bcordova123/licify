

<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mis busquedas</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Mis clientes</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="clientes" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>Nombre</th>
                <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                foreach($datos as $value):
                    ?>                
                    <tr>
                    <td><?=$value["nombre"]?></td>
                    <td style="text-align: center">
                        <!-- <button class="btn bg-gradient-primary btn-sm" onclick="cargarmodal('<?=$value["uuid"]?>')">
                        <i class="fas fa-edit"></i>
                        Ver</button> -->
                <button type="button" class="btn bg-gradient-primary btn-sm" data-toggle="modal" data-target="#modal-xl" onclick="cargarmodal('<?=$value["uuid"]?>')">                 
                  <i class="fas fa-edit"></i> Ver
                </button>
                    </td>
                    </tr>
                <?php
                    endforeach;
                ?>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
<div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title">Mis busquedas</h1>              
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <h3 class="">Nombre de la busqueda: <span id="nombre2" name="nombre2"></span></h3>              
              <span>Tipos de licitaciones: <span id="tipos2" name="tipos2"> </span></span>
              <br>
              <br>
            <table id="clientes" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>Codigo</th>  
                <th>Termino</th>                              
                </tr>
                </thead>
                <tbody id="tabla2">             
                    <tr>                
                    </tr>
                  </tbody>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
            <button class="btn btn-primary" style=" display:contents ">Save changes</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script>
  $(function () {
  //  $("#table_facturacion").DataTable();
    $('#clientes').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    }); 
  });
  function cargarmodal(uuid){
   console.log(uuid);
        $.ajax({
            url: "<?=base_url('clientes/busquedas')?>",
            type: "POST",
            data: {"uuid_cliente":uuid},
            dataType: 'json',
            success: function(respuesta) {
                $('#modal-xl').modal(); 
                //$('.modal-backdrop').remove();
                var span = "<span>";
                    span+=respuesta.data.nombre.nombre+"</span>";
                $("#nombre2").html(span);
                var span2 = "<span>";
                    span2+=respuesta.data.tipos.tipos+"</span>";
                $("#tipos2").html(span2);
                var tabla ="";
                $.each(respuesta.data.busqueda, function(i, value) {                      
                  tabla+= "<tr>";                  
                  tabla+="<td>"+value.segmento_cod+"</td>"; 
                  tabla+="<td>"+value.termino+"</td>";                   
                  tabla+="</tr>";
                  
                }); 
                $("#tabla2").html(tabla);
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        }); 
    }
  function verDetalle(uuid) {
    //console.log(uuid);
    $.ajax({
                url: "<?=base_url('clientes/busquedas')?>",
                type: "POST",
                data: {"uuid_cliente":uuid},
                dataType: 'json',
                success: function(data) {
                  //console.log(data);
                  $("#content-licitor").html(data.template);
                  //$('#content-licitor').load(data.template);
            /* if (data.status) {
             $.notify({
                            // options
                            title: 'Correcto, ',
                            message: data.reason
                        },{
                            // settings
                            type: 'success',
                            hideDuration: 7,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                            
                        });
         } else if (!data.status) { 
            $.notify({
                                // options
                                title: 'Advertencia, ',
                                message: data.reason
                            },{
                                // settings
                                type: 'warning',
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },
                                
                            });

        } else {
            $.notify({
                                // options
                                title: 'Error, ',
                                message: 'Error desconocido' 
                            },{
                                // settings
                                type: 'danger',
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },
                                
                            });
        } */    
                },
                error: function() {
                      console.log("No se ha podido obtener la información");
                  }
            });



  }

</script>
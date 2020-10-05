

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
              <h3 class="card-title">Detalle de la busqueda del cliente: <?=$nombre["nombre"]?></h3>
              <br>
              <span>Tipos de licitaciones: <?=$busqueda[0]["tipos"]?></span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">


              <table id="clientes" class="table table-bordered table-hover">

                <thead>
                <tr>
                <th>Termino</th>
                <th>Codigo</th>                
                </tr>
                </thead>
                <tbody>

                <?php
                
                foreach($busqueda as $value):
                    ?>                
                    <tr>
                    <td><?=$value["termino"]?></td>
                    <td><?=$value["segmento_cod"]?></td>
                    
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


</script>
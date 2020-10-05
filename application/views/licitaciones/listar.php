

<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<?php $licitaciones = $licitaciones["hits"]["hits"] ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Resultados de su búsqueda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Buscar</li>
              <li class="breadcrumb-item active"><a href="#">Licitaciones</a></li>
            </ol>
          </div>
        </div>

        <span class="mr-2">
          <i class="fas fa-fire text-red"></i> Recién publicada
        </span>

          <span class="mr-2">
            <i class="fas fa-clock text-primary"></i> Cierra pronto
          </span>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Se han encontrado <?= $hits ?> licitaciones</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="table_facturacion" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Codigo Externo</th>
                  <th>Titulo</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                foreach($licitaciones as $item) {

                    $value = $item["_source"];

                    ?>
                
                    <tr>
                    <td style='width: 13%' ><?= date('d M Y - H:i', strtotime($value["Fechas_FechaPublicacion"])) ?></td>
                    <td style='width: 10%'><?=$value["CodigoExterno"]?></td>
                    <td> 
                    
                    <?php 

                        $hoy = strtotime("now");
                        $time = strtotime($value["Fechas_FechaPublicacion"]);
                        $dias = abs($time - $hoy) / (60 * 60 * 24);

                    if($dias < 1) {
                      echo "<span style='color: red'><i class='fas fa-fire' style='margin-right: 5px'></i></span>";
                    }
                    ?>


                    <?php 

                      $hoy = strtotime("now");
                      $time = strtotime($value["Fechas_FechaCierre"]);
                      $dias = round($time - $hoy) / (60 * 60 * 24);


                      if($dias < 8 && $dias > 0) {
                        echo "<span style='color: blue'><i class='fas fa-clock' style='margin-right: 5px'></i></span>";
                      } else if($dias <= 0) {
                        echo "<span style='color: gray'><i class='fas fa-times' style='margin-right: 5px'></i></span>";
                      }
                    ?>

                    <?=$value["Nombre"]?></td>

                    <td style="text-align: center; width: 20%">
                        <form id="showDetalle-<?=$value["CodigoExterno"]?>" name="<?=$value["CodigoExterno"]?>" method="GET" action="Facturacion/voucher/<?=$value["CodigoExterno"]?>" >
                            <button id="btnDetalle-<?=$value["CodigoExterno"]?>"  class="btn bg-gradient-primary btn-sm" type="submit">
                                <i class="fas fa-download"></i>
                                Ver detalle
                            </button>
                        </form>
                    </td>
                    </tr>

                <?php
                    }
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
    $('#table_facturacion').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": true
    }); 


    $("form[id^='showDetalle']").submit(function(e){
        e.preventDefault();
        var form = this;

        console.log(this.name);

        $('#btnDetalle-' + form.name).attr("disabled", true);
        $('#btnDetalle-' + form.name).html("<i class='fas fa-download'></i>   Descargando ...");

        $('#content-licitor').load("Utils/loading", function() {
              $('#content-licitor').load("Search/buscar/" + form.name, function() {
              });
          });


        return;
    });
  });

  function descargarVoucher(nroBoleta) {
      
  }

</script>
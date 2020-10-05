

<link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Facturación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Cuenta</a></li>
              <li class="breadcrumb-item active">Facturación</li>
            </ol>
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
              <h3 class="card-title">El detalle de sus pagos</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="table_facturacion" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>Fecha</th>
                  <th>Identificador Pago</th>
                  <th>Búsqueda</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>

                <?php
                
                foreach($pagos as $value) {
                    ?>
                
                    <tr>
                    <td><?=$value["fecha_pago"]?></td>
                    <td><?=$value["numero_orden"]?></td>
                    <td><?=$value["cliente"]?></td>
                    <td style="text-align: center">
                        <form id="downloadVoucher-<?=$value["numero_orden"]?>" name="<?=$value["numero_orden"]?>" method="GET" action="Facturacion/voucher/<?=$value["numero_orden"]?>" >
                            <button id="btnDownload-<?=$value["numero_orden"]?>"  class="btn bg-gradient-primary btn-sm" type="submit">
                                <i class="fas fa-download"></i>
                                Descargar comprobante
                            </button>

                            <button id="btnFactura-<?=$value["numero_orden"]?>" disabled class="btn bg-gradient-danger btn-sm" style="margin-left: 5%">
                                <!-- <i class="fas fa-download"></i> -->
                                Factura no disponible
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
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    }); 


    $("form[id^='downloadVoucher']").submit(function(e){
        e.preventDefault();
        var form = this;

        console.log(this.name);

        $('#btnDownload-' + form.name).attr("disabled", true);
        $('#btnDownload-' + form.name).html("<i class='fas fa-download'></i>   Descargando ...");

        form.submit();

        setTimeout(function(){
          //  $('#btnDownload-' + form.name).removeAttr("disabled");
            $('#btnDownload-' + form.name).toggleClass('bg-gradient-primary');
            $('#btnDownload-' + form.name).toggleClass('bg-gradient-success');
            $('#btnDownload-' + form.name).html("<i class='fas fa-check'></i>   Descargada");
        }, 3000);

        return;
    });
  });

  function descargarVoucher(nroBoleta) {
      
  }

</script>
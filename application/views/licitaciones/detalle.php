
<?php $licitacion = $licitacion["_source"] ?>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Licitación: <?= $licitacion["CodigoExterno"] ?> 
            <small>

                <?php
                  if($follow) {
                    ?>
                    <button id="btnFollow" onclick="follow(this)" class="btn bg-gradient-success btn-sm" style="margin-left: 15px">Siguiendo</button>
                    <?php
                  } else {
                    ?>
                    <button id="btnFollow" onclick="follow(this)" class="btn bg-gradient-primary btn-sm" style="margin-left: 15px">Seguir</button>
                    <?php
                  }
                ?>

              
            </small>
          </h1> 
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Buscar</li>
            <li class="breadcrumb-item">Licitaciones</li>
            <li class="breadcrumb-item active"><a href="#"><?= $licitacion["CodigoExterno"] ?></a</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <div class="col-12 col-sm-12 col-lg-12">
        <div class="card card-primary card-outline card-outline-tabs">
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Información de la Licitación</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-fechas-tab" data-toggle="pill" href="#custom-tabs-fechas-home" role="tab" aria-controls="custom-tabs-fechas-home" aria-selected="false">Fechas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Información del Comprador</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill" href="#custom-tabs-three-messages" role="tab" aria-controls="custom-tabs-three-messages" aria-selected="false">Ordenes de Compra</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
              <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                <div class="col-12">
                  <p class="lead">Licitación</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:20%">Nombre:</th>
                        <td><?= $licitacion["Nombre"] ?></td>
                      </tr>
                      <tr>
                        <th>Descripción:</th>
                        <td><?= $licitacion["Descripcion"] ?></td>
                      </tr>
                      <tr>
                        <th>Monto Estimado:</th>
                        <td><?php if(array_key_exists("montoestimado", $licitacion)) { echo $licitacion["montoestimado"]; } else { echo "No informado"; } ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              <div class="tab-pane fade" id="custom-tabs-fechas-home" role="tabpanel" aria-labelledby="custom-tabs-three-fechas-tab">
                <div class="col-12">
                  <p class="lead">Fechas</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:20%">Fecha publicación:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaPublicacion"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha inicio de preguntas:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaInicio"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha fin de preguntas:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaFinal"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha publicación de respuestas:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaPubRespuestas"])) ?></td>
                      </tr>
                      <tr>
                        <th style="color: red">Fecha de cierre:</th>
                        <td style="color: red"><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaCierre"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha apertura técnica:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaActoAperturaTecnica"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha apertura económica:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaActoAperturaEconomica"])) ?></td>
                      </tr>
                      <tr>
                        <th>Fecha adjudicación:</th>
                        <td><?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaAdjudicacion"])) ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>




              <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">

                <div class="col-12">
                  <p class="lead">Comprador</p>

                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:20%">Codigo de Organismo:</th>
                        <td><?= $licitacion["Comprador_CodigoOrganismo"] ?></td>
                      </tr>
                      <tr>
                        <th>Nombre de Organismo:</th>
                        <td><?= $licitacion["Comprador_NombreOrganismo"] ?></td>
                      </tr>
                      <tr>
                        <th>Rut Unidad:</th>
                        <td><?= $licitacion["Comprador_RutUnidad"] ?></td>
                      </tr>
                      <tr>
                        <th>Codigo de Unidad:</th>
                        <td><?= $licitacion["Comprador_CodigoUnidad"] ?></td>
                      </tr>
                      <tr>
                        <th>Dirección:</th>
                        <td><?= $licitacion["Comprador_DireccionUnidad"] ?>, <?= $licitacion["Comprador_ComunaUnidad"] ?>, <?= $licitacion["Comprador_RegionUnidad"] ?></td>
                      </tr>
                      <tr>
                        <th>Cantidad de Reclamos:</th>
                        <td><?= $licitacion["CantidadReclamos"] ?></td>
                      </tr>
                      
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel" aria-labelledby="custom-tabs-three-messages-tab">
               Esta licitación no presenta ordenes de compra asociadas.
             </div>
           </div>
         </div>
         <!-- /.card -->
       </div>
     </div>

     
     <!-- Timelime example  -->
     <div class="row">
      <div class="col-md-12">
        <!-- The time line -->
        <div class="timeline">
          <!-- timeline time label -->
          <div class="time-label">
            <span class="bg-green"><?=$licitacion["Estado"]?></span>
          </div>
          <!-- /.timeline-label -->
          

          <!-- ADJUDICACION TIME -->
          <?php 
          if($licitacion["Estado"] == "Adjudicada") {
            ?>

            <!-- timeline item -->
            <div>
              <i class="fas fa-balance-scale bg-green"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> <?= date('d M Y - H:i', strtotime($licitacion["Adjudicacion_Fecha"])) ?></span>
                <h3 class="timeline-header">Se ha adjudicado esta licitación a <?=$licitacion["Adjudicacion_NumeroOferentes"]?> oferentes .</h3>
                <div class="timeline-body">

                  <?php
                  foreach($licitacion["Items"] as $x => $item) {

                    if(array_key_exists("Adjudicacion", $item)) {
                    ?>
                    <a href="#" id="<?= $item["Adjudicacion"]["RutProveedor"]; ?>">
                      <?= $item["Adjudicacion"]["NombreProveedor"]; ?>
                    </a>   
                    se ha adjudicado $<?=str_replace(',','.',number_format( ($item["Adjudicacion"]["MontoUnitario"] *  $item["Adjudicacion"]["Cantidad"])))?>
                    <br/>
                    <?php
                    }
                  }
                  ?>
                </div>
                <div class="timeline-footer">
                  <a href="<?= $licitacion["Adjudicacion_UrlActa"] ?>" target="_blank" class="btn btn-primary btn-sm">Revisar el acta oficial</a>
                </div>
              </div>
            </div>
            <!-- END timeline item -->
            <?php
          }
          ?>

          <?php 
          if($licitacion["Estado"] == "Desierta") {
            ?>

            <!-- timeline item -->
            <div>
              <i class="fas fa-landmark bg-gray"></i>
              <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> <?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaCreacion"])) ?></span>
                <h3 class="timeline-header no-border"><a href="#"><?= $licitacion["Comprador_NombreOrganismo"] ?></a> ha creado esta licitación</h3>
              </div>
            </div>
            <!-- END timeline item -->

            <?php
          }
          ?>


          <?php 
          
          if(date('Y-m-d H:i:s', strtotime($licitacion["Fechas_FechaCierre"])) < date('Y-m-d H:i:s')) {

          ?>
          

          <!-- timeline item -->
          <div>
            <i class="fas fa-times bg-gray"></i>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> <?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaCierre"])) ?></span>
              <h3 class="timeline-header no-border"><a href="#"><?= $licitacion["Comprador_NombreOrganismo"] ?></a> ha cerrado esta licitación</h3>
            </div>
          </div>
          <!-- END timeline item -->

            <?php 
            }
            ?>


          <!-- timeline item -->
          <div>
            
            <i class="fas fa-check bg-gray" style="color: green"></i>
            
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> <?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaPublicacion"])) ?></span>
              <h3 class="timeline-header no-border"><a href="#"><?= $licitacion["Comprador_NombreOrganismo"] ?></a> ha publicado esta licitación</h3>
            </div>
          </div>
          <!-- END timeline item -->

          <!-- timeline item -->
          <div>
            <i class="fas fa-landmark bg-gray"></i>
            <?php setlocale(LC_TIME, 'es_CO.UTF-8'); ?>
            <div class="timeline-item">
              <span class="time"><i class="fas fa-clock"></i> <?= date('d M Y - H:i', strtotime($licitacion["Fechas_FechaCreacion"])) ?></span>
              <h3 class="timeline-header no-border"><a href="#"><?= $licitacion["Comprador_NombreOrganismo"] ?></a> ha creado esta licitación</h3>
            </div>
          </div>
          <!-- END timeline item -->
          <div>
            <i class="fas fa-clock bg-gray"></i>
          </div>
          
        </div>
      </div>
      <!-- /.col -->
    </div>
  </div>
  <!-- /.timeline -->

</section>
<!-- /.content -->


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Items solicitados</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

  <?php 
          foreach($licitacion["Items"] as $item) {
            ?>

    <div class="row">
      <div class="col-md-4">
        <div class="card card-outline collapsed-card">
          <div class="card-header">
            <h3 class="card-title"><?=$item["NombreProducto"]?></h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            The body of the card
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>


    <?php
          }
    ?>

    

  </div>
</section>


</div>


<script> 

          function follow(button) {
            if($(button).hasClass('bg-gradient-success')) {
              $(button).removeClass("bg-gradient-success");
              $(button).addClass("bg-gradient-primary");
              $(button).html("Seguir");
            } else {
              $(button).removeClass("bg-gradient-primary");
              $(button).addClass("bg-gradient-success");
              $(button).html("Siguiendo");
            }
          }

</script>
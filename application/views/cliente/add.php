<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mercado Publico</title>
    <?php
    $this->load->view('comun/css'); 
    ?>
</head>

<body id="page-top">
    <?php
        $this->load->view('comun/navbar'); 
    ?>
    <div id="wrapper">
        <?php
            $this->load->view('comun/menu'); 
        ?>
        <!--START CONTENT-->
        <div id="content-wrapper">
        <div class="container-fluid mt--9">
      <div class="row">
        <div class="col-md-12">
                    <h1 class="float-left"><?=$page_name?></h1>
                    
                </div>
                <div class="col-md-12"><hr></div>
        <div class="col-md-12 pb-5">
          <div>
            <div class="card-body">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">       
                </div>
                <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                  
                  <form method="post" action="<?=base_url()."clientes/add"?>">                                       
                    <div class="row">
                      <div class="col-md-8 offset-md-2 col-sm-12">      

                        <div class="form-group">
                          <label class="form-control-label">Razón Social:</label>
                          <input required class="form-control" name="nombre" type="text" placeholder="Ingrese nombre">
                        </div>                         
                        <div class="form-group">
                          <label class="form-control-label">Rut:</label>
                          <input required class="form-control" name="rut" id="rut" type="text" placeholder="Ingrese un rut" maxlength="12">
                        </div> 
                        <div class="form-group">
                          <label class="form-control-label">Correo:</label>
                          <input required class="form-control" name="email" type="text" placeholder="Ingrese un correo valido">
                        </div> 
                        
                        
                        <div class="form-group mt-3">
                          <button class="btn btn-success btn-block" type="submit">Listo, guardar</button>
                        </div>   
                      </div>
                    </div>
                  </form> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        </div>
        <!--END CONTENT-->
    </div>

    <?php 
        $this->load->view('comun/footer');
        $this->load->view('comun/js');
        $this->load->view('comun/js_datatables');
    ?>

    <script>

    $(document).ready(function(){  
        tabla("<?php echo base_url() . 'clientes/fetch_client'; ?>",'client_data');
        $('#client_data').removeClass('no-footer');
        $('#client_data').removeClass('dataTable');
    });  
   $(function(){
        $("#rut")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){
         /* $("#rut").addClass("is-invalid")
          $("#contenedor").addClass("has-danger")
          ok=false;*/
        })
        .on('rutValido', function(){
          /* $("#rut").removeClass("is-invalid")
           $("#contenedor").removeClass("has-danger")
           $("#contenedor").addClass("has-success")
           $("#rut").addClass("is-valid")
           ok=true;*/
        });
  });
    </script>
</body>
</html>
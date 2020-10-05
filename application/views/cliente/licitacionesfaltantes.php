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
                    
                </div>
                <div class="col-md-12"><hr></div>
        <div class="col-md-12 pb-5">
          <div>
            <div class="card-body">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">       
                </div>
                <div class="tab-pane fade show active" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                  
                  <form method="post" action="<?=base_url()."clientes/add_plan2"?>">                                       
                    <div class="row">
                      <div class="col-md-8 offset-md-2 col-sm-12"> 
                        
                        
                        <div class="form-group mt-3">
                          <button class="btn btn-success btn-block" type="submit">Crear Filtro</button>
                        </div>   
                      </div>
                    </div>
                  </form> 
                  <div class="col-md-12 pb-5">
                    <?php 

                    $Fechas = "";
                      krsort($fechas);
                      $Fechas=implode("<br> ", $fechas) ?>
                  <table border="1">
                    <thead>
                      <tr>Fechas</tr>
                    </thead>
                    <tbody>
                      <td>
                        
                        <?= $Fechas?>
                        
                      </td>
                    </tbody>
                  </table>


                  </div>

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
</body>
</html>
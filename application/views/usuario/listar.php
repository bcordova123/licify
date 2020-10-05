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
        <div class="container-fluid">
            <!-- Page Content -->
            
            <div class="row">
                <div class="col-md-6">
                    <h1 class="float-left"><?=$page_name?></h1>
                </div>
                <!--
                <div class="col-md-6">
              
                    <div class="row mt-2">
                        <div>
                            <label class="switch">
                            <input type="checkbox"  id ="mactivos">
                            <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    
                    
                    

                </div>-->
                <div class="col-md-6">
                    <button class="float-right btn btn-info">Crear usuario</button>
                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-12">
                    <div class="table-responsive mb-5">
                    <table class="table" id="user_data">
                        <thead>
                            <th>Avatar</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Ver</th>
                            <th>Desactivar</th>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
            <?php //PON TU CÓDIGO ACÁ ?>
            
            

            <?php //TERMINA TU CÓDIGO ACÁ ?>
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
        tabla("<?php echo base_url() . 'usuarios/fetch_user'; ?>",'user_data');
        $('#user_data').removeClass('no-footer');
        $('#user_data').removeClass('dataTable');
    });  
   
    </script>
</body>
</html>
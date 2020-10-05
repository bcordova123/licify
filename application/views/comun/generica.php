<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mercado Publico - Login</title>

    <?php
    $this->load->view('comun/css'); 
  ?>

</head>

<body class="login bg-dark">

    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-body">
                <img class="logo" src="<?=base_url()?>assets/img/logo-california.png">
                <form>
                    <div class="form-group">
                      
                        <div class="form-label-group" id="div_texto">
                            <p class="text-info text-center"><?=$mensaje?></p>
                        </div>
                   
                </form>
                <div class="text-center">

                    <a class="d-block small mt-3" href="<?=base_url()?>auth">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $this->load->view('comun/js');
  ?>

    


</body>

</html>
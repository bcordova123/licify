<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Bryan Cordova">

    <title>Mercado Publico - Registro</title>

    <?php
    $this->load->view('comun/css'); 
  ?>

</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
      <img src="https://fotos.subefotos.com/9d156d0a705d368d0226d9ec5626ba46o.png" alt="Licify Logo" style="height: 50px;">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Registro de usuarios</p>

      <form method="post" onsubmit="event.preventDefault(); registro();">
        <div class="input-group mb-3">
            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre o Razón social"
            required="required" autofocus="autofocus">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="email" id="correo" name="correo" class="form-control" placeholder="Email"
            required="required" autofocus="autofocus">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña"
            required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" id="password2" name="password2" class="form-control" placeholder="Contraseña"
            required="required">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               Estoy de acurdo con los <a href="#">terminos</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
              <button class="btn btn-primary btn-block btn-radius" type="submit">Registrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Registrate con Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Registrate con Google+
        </a>
      </div>

      <a class="d-block small mt-3" href="<?=base_url()?>auth">¿Usted ya tiene una cuenta? Inicie sesión</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>

<?php 
$this->load->view('comun/js');
?>
<script>
    function registro(){
        var nombre = $('#nombre').val();
        var correo = $('#correo').val();
        var password = $('#password').val();
        var password2 = $('#password2').val();
        $.ajax({
        url: "<?=base_url('auth/registro')?>",
        type: "POST",
        data: {"nombre":nombre,"correo":correo,"password":password,"password2":password2},
        success: function(data) {
            if (data.status) {
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
                } 
        },
        error: function() {
          console.log("No se ha podido obtener la información");
        }
    }); 
    }
</script>
</body>
</html>

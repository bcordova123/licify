<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Licitame.cl - Log in</title>

    <?php
    $this->load->view('comun/css'); 
  ?>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <img src="https://fotos.subefotos.com/9d156d0a705d368d0226d9ec5626ba46o.png" alt="Licify Logo" style="height: 50px;">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresa ahora</p>

      <form>
        
        <div class="input-group mb-3">
          
            <input type="email" id="inputEmail" class="form-control" placeholder="Correo"
            required="required" autofocus="autofocus">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" id="inputPassword" class="form-control" placeholder="Contraseña"
            required="required" onkeydown="if (event.keyCode == 13) { login(); return false; }">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          
            <div class="icheck-success d-inline">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recuerdame
              </label>
            </div>
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <a class="btn btn-primary btn-block btn-radius" href="#" onclick = "login();">Ingresar</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- O -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Ingresa con Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Ingresa con Google+
        </a>
      </div>
      <!-- /.social-auth-links -->
      <p class="mb-1">
          <a class="d-block small mt-3" href="<?=base_url()?>auth/view_forgotPassword">¿Olvidó su
              Contraseña?</a>
      </p>
      <p class="mb-0">
        <a class="text-center" href="#" onclick = "registro();">¿No tienes cuenta? Regístrate</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- AdminLTE App -->
<?php 
$this->load->view('comun/js');
?>

<script>
    function login() {
        
        if ($("#inputEmail").val() != null && $("#inputEmail").val() != "" && $("#inputPassword").val() != null && $("#inputPassword").val() != "") {
            var form = new FormData();
        form.append("email",$("#inputEmail").val() );
        var sha11 = sha1($("#inputPassword").val());
        form.append("clave",sha11);


        var loading = new Loading({
					loadingBgColor: 	'rgba(0, 0, 0,0)',
                    discription: 'Cargando, espere...',
			    	defaultApply: 	true,
		});
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "<?=base_url()?>auth/ajax_login",
            "method": "POST",
            "processData": false,
            "contentType": false,
            "mimeType": "multipart/form-data",
            "data": form
        }

        $.ajax(settings).done(function(response) {
            console.log(response);
            loading.out();
            if (response=="false") {
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'Credenciales incorrectas' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });  
            }else{
                window.location.replace("<?=base_url()?>welcome");
            }
        });

        }else{
            $.notify({
                    // options
                    title: 'Error, ',
                    message: 'No puede ingresar campos vacíos' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                }); 
        }

        
    }

    function registro(){
        window.location.replace("<?=base_url()?>auth/cargar_registro");        
    }
    </script>
</body>
</html>

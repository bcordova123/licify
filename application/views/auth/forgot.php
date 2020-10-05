<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Mercado Publico - Registro</title>

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
      <p class="login-box-msg">
¿Olvidaste tu contraseña? Aquí puede recuperar fácilmente una nueva contraseña.</p>

      <form>
          <div class="form-group">
              <div class="form-label-group" id="div_email">
                  <input type="email" id="inputEmail" class="form-control" placeholder="Email"
                      required="required" autofocus="autofocus">
              </div>
              <div class="form-label-group" id="div_texto" style="display:none;">
                  <p class="text-success">Las instrucciones para reestablecer su contraseña fueron enviadas a su correo.</p>
              </div>
          </div>

          <a class="btn btn-primary btn-block btn-radius" href="#" onclick="repass();" id="boton">Recuperar contraseña</a>
      </form>
      <div class="text-center">

          <a class="d-block small mt-3" href="<?=base_url()?>auth">Volver</a>
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<?php 
$this->load->view('comun/js');
?>

<script>
  function repass(){
    
    var form = new FormData();
    form.append("email", $("#inputEmail").val());

    var loading = new Loading({
          loadingBgColor: 	'rgba(0, 0, 0,0)',
                    discription: 'Cargando, espere...',
            defaultApply: 	true,
    });

    var settings = {
        "async": true,
        "crossDomain": true,
        "url": "<?=base_url()?>auth/ajax_forgot",
        "method": "POST",
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
    }

    $.ajax(settings).done(function(response) {
      loading.out();
            if (response=="false") {
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'Email no registrado en la plataforma' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });  
            }else{
                $('#div_email').hide();
                $('#boton').hide();
                $('#div_texto').show();
            }
        console.log(response);
    });
  }

</script>

</body>
</html>

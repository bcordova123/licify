<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>California - Login</title>

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
                    <div class="form-group" id="pass">
                        <div class="form-label-group" id="pass1">
                            <input type="password" id="inputPass1" class="form-control" placeholder="Nueva contraseña"
                                required="required" autofocus="autofocus">
                            <label for="inputPass1">Nueva contraseña</label>
                        </div>
                        <br>
                        <div class="form-label-group" id="pass2">
                            <input type="password" id="inputPass2" class="form-control" placeholder="Repita contraseña"
                                required="required" autofocus="autofocus">
                            <label for="inputPass2">Confirme su contraseña</label>
                        </div>
                        
                    </div>
                    <div class="form-label-group" id="div_texto" style="display:none;">
                            <p class="text-success">Su contraseña se ha reestablecido correctamente.</p>
                        </div>
                    <a class="btn btn-primary btn-block btn-radius" href="#" onclick="repass();" id="boton">Cambiar contraseña</a>
                </form>
                <div class="text-center">

                    <a class="d-block small mt-3" href="<?=base_url()?>auth">Ir a la plataforma</a>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $this->load->view('comun/js');
  ?>
<script>
    function repass(){
      if ($("#inputPass1").val() == $("#inputPass2").val()) {
        var form = new FormData();
        form.append("uuid","<?=$uuid?>");
        var sha11 = sha1($("#inputPass1").val());
        form.append("password",sha11);


        var loading = new Loading({
					loadingBgColor: 	'rgba(0, 0, 0,0)',
                    discription: 'Cargando, espere...',
			    	defaultApply: 	true,
		});
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "<?=base_url()?>auth/ajax_changePass",
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
                    message: 'Ha ocurrido un error con su solicitud' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });  
            }else{
                $('#pass').hide();
                $('#boton').hide();
                $('#div_texto').show();
            }
        });
      }else{
        $.notify({
                    // options
                    title: 'Error, ',
                    message: 'Las contraseñas no coinciden' 
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
    

</script>
  
</body>

</html>
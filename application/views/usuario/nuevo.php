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
                <div class="col-md-12">
                    <h1 class="float-left"><?=$page_name?></h1>
                    
                </div>
                <div class="col-md-12"><hr></div>
                <div class="container-fluid">
                    <form method="post" action="<?=base_url()?>usuarios/nuevo" enctype="multipart/form-data" onsubmit = "return validando();">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                        
                        <div class="mb-1" id="pre_foto" style="background-color:#ccc;width:100%;height:300px;background-size:cover;"></div>
                        <label class="btn btn-primary btn-block mb-3" for="avatar" >Subir Avatar</label>
                        <input type="file" name="avatar" id="avatar" style="display:none;">

                        <div class="form-group">
                            <label>Perfil</label>
                            <select class="form-control" name="perfil_uuid">
                            <?php
                                foreach ($perfiles as $perfil) {
                                        if ($perfil["uuid"]==$this->config->item('uuid_administrador')) {
                                            if ($this->session->userdata('usuario')["perfil_uuid"]==$this->config->item('uuid_administrador')) {
                                                ?>
                                                    <option value="<?=$perfil["uuid"]?>"><?=$perfil["nombre"]?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="<?=$perfil["uuid"]?>"><?=$perfil["nombre"]?></option>
                                            <?php 
                                        }
                                }
                            ?>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-6">
                        <h3>Datos personales</h3>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input required class="form-control" type="text" placeholder="Nombre" onchange ="val_remove_class('nombre');" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input required class="form-control" type="text" placeholder="Apellidos" onchange ="val_remove_class('apellidos');" name="apellidos" id="apellidos">
                        </div>
                        <div class="form-group">
                            <label>Rut</label>
                            <input required class="form-control" type="text" placeholder="Rut" name="rut" id="rut">
                        </div>
                        <div class="form-group">
                            <label>Teléfono celular</label>
                            <input required class="form-control" type="text" placeholder="Teléfono" name="telefono" id="telefono">
                        </div>
                        <h3 class="mt-4">Datos de sesión</h3>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input required class="form-control" type="email" placeholder="E-mail" name="email" id="email" onchange = "verificar();">
                        </div>
                       
                        <label>¿Desea activar este usuario?</label>
                        <div class="form-group form-check"> 
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" value="1" name="status">
                            <label class="form-check-label" for="exampleCheck1">Activar usuario</label>
                        </div>
                        <div class="form-group mt-5">
                            <button  class="btn btn-success btn-block" type="submit">Guardar</button>
                        </div>
                        
                        </div>
                  
                    </div>
                    </form>           
                </div>
                
            
        </div>
        </div>
        <!--END CONTENT-->
    </div>
    <?php 
    $this->load->view('comun/footer');
    $this->load->view('comun/js');
    
    ?>

    <script>

    function val_remove_class(inp){
        console.log(inp);
        if ($('#'+inp).val()!=null && $('#'+inp).val().length>3) {
            $('#'+inp).removeClass("error");
        }
    }

    function validando(){
            
            var contador=0;
           
            if (verificar()) {
                contador++;
            }
           
            if($("#nombre").val() == null || $("#nombre").val() ==""){
                $("#nombre").addClass("error");
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'Verificar nombre' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                contador++;
            }else{
                $("#nombre").removeClass("error");
            }
            if($("#apellidos").val() == null || $("#apellidos").val() == ""){
                $("#apellidos").addClass("error");
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'verificar apellido' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                contador++;
            }else{
                $("#apellidos").removeClass("error");
            }
            if($("#rut").val() == null || $("#rut").val() == ""){
                $("#rut").addClass("error");
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'verificar rut' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                contador++;
            }else{
                $("#rut").removeClass("error");
            }
            if($("#telefono").val() == "" || $("#telefono").val() == null ){
                $("#telefono").addClass("error");
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'verificar telefono' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                contador++;
            }else{
                $("#telefono").removeClass("error");
            }
            if (contador == 0) {
                return true;
            }else{
               console.log("si que hay errores");

                return false;
            } 
        }

    function verificar(){
        var form = new FormData();
        form.append("email", $("#email").val());

        var settings = {
        "async": true,
        "crossDomain": true,
        "url": "<?=base_url()?>usuarios/ajax_verifyemail",
        "method": "POST",
        "processData": false,
        "contentType": false,
        "mimeType": "multipart/form-data",
        "data": form
        }
        
        //.className.replace(" error", "");
        $.ajax(settings).done(function (response) {
        console.log(response);
            if (response == "false") {
                $("#email").addClass("error");
                $.notify({
                    // options
                    title: 'Error, ',
                    message: 'El email ya esta registrado...' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                return false;
            }else{
                $("#email").removeClass("error");
                return true;
            }


        });
    }


    /*Imagen preliminar*/
    $(":input").inputmask();
    $("#telefono").inputmask({
        "mask": "+56 9 99999999"
    });
    $(function(){
        $("#rut")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){
            console.log("sergio gay");
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

    function readURL(input,id)
    {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $(''+id+'').css('background-image', 'url('+e.target.result+')');
        }
        reader.readAsDataURL(input.files[0]);
    }
    }

    $("#avatar").change(function()
    {
    if ((this.files[0].size/1000) > 3000)
    {
        alert("El tamaño de la imágen no puede superar los 3MB");
    }
    else
    {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp','svg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1)
        {
        $('#pre_foto').css('background-image', "");
        alert("Formato de la imágen debe ser "+fileExtension.join(', '));
        }
        else
        {
        readURL(this,"#pre_foto");
        }
    }
    });



    </script>
</body>
</html>
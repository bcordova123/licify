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
                    <form method="post" action="<?=base_url()?>usuarios/edit" enctype="multipart/form-data" id="formulario" onsubmit = "return validar();">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                        
                        <div class="mb-1" id="pre_foto" style="background-color:#ccc;width:100%;height:300px;background-size:cover; background-image:url('<?=base_url().$usuario["avatar"]?>')"></div>
                        <label class="btn btn-primary btn-block mb-3" for="avatar" >Subir Avatar</label>
                        <input type="file" name="avatar" id="avatar" style="display:none;">

                        <?php 
                        if($this->session->userdata('usuario')["perfil_uuid"]!=$this->config->item('uuid_vendedor')){
                        ?>
                        <div class="form-group">
                            <label>Perfil</label>

                            <select class="form-control" name="perfil_uuid">
                            <?php
                                foreach ($perfiles as $perfil) {
                                        if ($perfil["uuid"]==$this->config->item('uuid_administrador')) {
                                            if ($this->session->userdata('usuario')["perfil_uuid"]==$this->config->item('uuid_administrador')) {
                                                ?>
                                                    <option value="<?=$perfil["uuid"]?>"
                                                    <?php if($usuario["perfil_uuid"]==$perfil["uuid"]){echo "selected";} ?>
                                                    ><?=$perfil["nombre"]?></option>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            <option value="<?=$perfil["uuid"]?>"
                                            <?php if($usuario["perfil_uuid"]==$perfil["uuid"]){echo "selected";} ?>
                                            ><?=$perfil["nombre"]?></option>
                                            <?php 
                                        }
                                        
                                }
                            ?>
                            </select>
                        </div>
                        <?php 
                        }
                        ?>
                        </div>
                        <div class="col-md-6">
                        <h3>Datos personales</h3>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input required class="form-control" type="text" placeholder="Nombre" name="nombre" id="nombre" onchange = "val_remove_class('nombre');" value="<?=$usuario["nombre"]?>">
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input required class="form-control" type="text" placeholder="Apellidos" name="apellidos" id="apellidos" onchange = "val_remove_class('apellidos');" value="<?=$usuario["apellidos"]?>">
                        </div>
                        <div class="form-group">
                            <label>Rut</label>
                            <input required class="form-control" type="text" placeholder="Rut" name="rut" id="rut" onchange = "val_remove_class('rut');" value="<?=$usuario["rut"]?>">
                        </div>
                        <div class="form-group">
                            <label>Teléfono celular</label>
                            <input required class="form-control" type="text" placeholder="Teléfono" name="telefono" id="telefono" onchange = "val_remove_class('telefono');" value="<?=$usuario["telefono"]?>">
                        </div>
                        <h3 class="mt-4">Datos de sesión</h3>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input required class="form-control" type="email" placeholder="E-mail" name="email" id="email" onchange = "ajax_verify_mail_update();"  value="<?=$usuario["email"]?>">
                        </div>
                        <?php
                        if ($usuario["uuid"]==$this->session->userdata('usuario')["uuid"]) {
                            ?>
                            <h3 class="mt-4">Generar nueva contraseña</h3>
                            <div class="form-group">
                            <label>Enviar enlace al correo</label>
                            <br>
                            <button class="btn btn-outline-success btn-block" type="button" id = "generar_pass"  onclick = "ajax_send_password();">Generar contraseña</button>                            </div>
                            <?php
                        }
                        ?>
                        <?php 
                        if($this->session->userdata('usuario')["perfil_uuid"]!=$this->config->item('uuid_vendedor')){
                        ?>
                        <label>¿Desea activar este usuario?</label>
                        <div class="form-group form-check"> 
                            <input required type="checkbox" class="form-check-input" id="exampleCheck1" value="1" name="status"  <?php if($usuario["status"]==1){echo "checked";} ?>>
                            <label class="form-check-label" for="exampleCheck1">Activar usuario</label>
                        </div>
                        <?php 
                        }
                        ?>
                        <div class="form-group mt-5">
                        <input name = "uuid_usuario"  type="hidden" value = "<?=$usuario["uuid"]?>" id = "uuid_usuario">
                            <button class="btn btn-warning btn-block" type="submit">Guardar</button>
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

        function validar(){

            var contador=0;
           
            if (ajax_verify_mail_update()) {
                contador++;
            }
           
            if($("#nombre").val() == null || $("#nombre").val() ==""){
                $("#nombre").addClass("error");
                contador++;
            }else{
                $("#nombre").removeClass("error");
            }
            if($("#apellidos").val() == null || $("#apellidos").val() == ""){
                $("#apellidos").addClass("error");
                contador++;
            }else{
                $("#apellidos").removeClass("error");
            }
            if($("#rut").val() == null || $("#rut").val() == ""){
                $("#rut").addClass("error");
                contador++;
            }else{
                $("#rut").removeClass("error");
            }
            if($("#telefono").val() == "" || $("#telefono").val() == null ){
                $("#telefono").addClass("error");
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

        function val_remove_class(inp){
            console.log(inp);
            if ($('#'+inp).val()!=null) {
                $('#'+inp).removeClass("error");
            }
        }

        function ajax_send_password(){
            var form = new FormData();
            
            var email = "<?=$this->session->userdata('usuario')["email"]?>";
            form.append("email", email);
           
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

            $.ajax(settings).done(function (response) {
                if (response == "true") {
                    $("#generar_pass").attr('disabled','disabled');
                    $("#generar_pass").text('Correo enviado exitosamente');
                    $.notify({
                    // options
                    title: 'Info, ',
                    message: 'Correo enviado con exito' 
                },{
                    // settings
                    type: 'info',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                }
                if (response == "false") {
                    $.notify({
                    // options
                    title: 'Error, ',
                    message: 'Fallo el envio, intente de nuevo' 
                },{
                    // settings
                    type: 'danger',
                    animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                    },
                    
                });
                }
                
            });
        }

        function ajax_verify_mail_update(){
            var form = new FormData();
            form.append("email", $("#email").val());
            form.append("uuid", "<?=$usuario["uuid"]?>");
            var settings = {
                "async": true,
                "crossDomain": true,
                "url": "<?=base_url()?>usuarios/ajax_verifyemail_update",
                "method": "POST",
                "processData": false,
                "contentType": false,
                "mimeType": "multipart/form-data",
                "data": form
            }

            $.ajax(settings).done(function (response) {
                if (response=="false") {
                    $("#email").addClass("error");
                    return false;
                }
                if (response=="true") {
                    $("#email").removeClass("error");
                    return true;
                }
            });
        }


    
    $(":input").inputmask();
    $("#telefono").inputmask({
        "mask": "+56 9 99999999"
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
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
            <div class="col-md-6" >
                
                <button class="float-right btn btn-info" onclick="cargarmodalagregar();">Crear cliente</button>
                <button class="float-right btn btn-info" onclick="send_email();">Enviar correo</button>
                <button class="float-right btn btn-info" onclick="send_email_cron();">Enviar correo cron</button>
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-12">
                <div class="table-responsive mb-5">
                    <table class="table" id="client_data">
                        <thead>
                            <th>Razón Social</th>
                            <th>Estado</th> 
                            <th>Editar</th>
                            <th>Acción</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <center>
        <div id="editar" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom">
            <header class="w3-container w3-teal">
                <h2>Modificar Cliente</h2> 
                <button class="w3-button w3-display-topright" type="button" data-dismiss="modal" aria-label="Close">
                &times;</button>
            </header>
            <div class="w3-container">
              <form method="post" id="formulario" onsubmit="event.preventDefault(); send_edit();">
                <div class="row">
                    <div class="col-md-10 offset-md-1" >                                            
                        <h3>Datos personales</h3>
                        <div class="form-group">
                            <label>Razón social</label>
                            <input required class="form-control" type="text" placeholder="Nombre" name="nombre" id="nombre" onchange = "val_remove_class('nombre');" value="">
                        </div>                        
                        <div class="form-group">
                            <label>Rut</label>
                            <input required class="form-control" maxlength="12" type="text" placeholder="Rut" name="rut" id="rut" onchange= "val_remove_class('rut');" digit>
                        </div>   
                        <div class="form-group">
                            <label>Correo</label>
                            <input required class="form-control" type="email" placeholder="Correo" name="email" id="email" onchange = "val_remove_class('email');" value="">
                        </div>                                                                               
                        <div class="form-group mt-5">
                            <input name = "uuid_cliente"  type="hidden" value = "" id = "uuid_cliente">
                            <button class="btn btn-warning btn-block" type="submit">Guardar</button>
                        </div>                        
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>
</center>
    <center>
        <div id="agregar" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom">
            <header class="w3-container w3-teal">
                <h2>Agregar Cliente</h2> 
                <button class="w3-button w3-display-topright" type="button" data-dismiss="modal" aria-label="Close">
                &times;</button>
            </header>
            <div class="w3-container">
              <form method="post" id="formulario1" onsubmit="event.preventDefault(); send_insert();">
                <div class="row">
                    <div class="col-md-10 offset-md-1" >                                            
                        <h3>Datos personales</h3>
                        <div class="form-group">
                            <label>Razón social</label>
                            <input required class="form-control" type="text" placeholder="Nombre" name="nombre2" id="nombre2" value="">
                        </div>                        
                        <div class="form-group">
                            <label>Rut</label>
                            <input required class="form-control" maxlength="12" type="text" placeholder="Rut" name="rut2" id="rut2">
                        </div>   
                        <div class="form-group">
                            <label>Correo</label>
                            <input required class="form-control" type="email" placeholder="Correo" name="email2" id="email2" value="">
                        </div>                                                                               
                        <div class="form-group mt-5">
                            <input name = "uuid_cliente"  type="hidden" value = "" id = "uuid_cliente">
                            <button class="btn btn-warning btn-block" type="submit">Guardar</button>
                        </div>                        
                    </div>
                </div>
            </form> 
        </div>
    </div>
</div>
</center>
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
        //Cargamos los datos a la Tabla con el metodo del controlador que dibuja los resultados!
        tabla("<?php echo base_url() . 'clientes/fetch_client'; ?>",'client_data');
        $('#client_data').removeClass('no-footer');
        $('#client_data').removeClass('dataTable');
    });      
    //Abre el modal Agregar Cliente
    function cargarmodalagregar(){
        $('#agregar').modal();
        $("#formulario1")[0].reset();
        $('.modal-backdrop').remove();
        $("#rut2").removeClass("is-valid");
        $("#rut2").removeClass("is-invalid");
    }
    //Carga el Modal Editar Cliente
    function cargarmodal(uuid){
        $.ajax({
            url: "<?=base_url('clientes/view_modificar')?>",
            type: "POST",
            data: {"uuid_cliente":uuid},
            success: function(respuesta) {
                //window.location.reload(); 
                $('#editar').modal(); 
                $("#rut").removeClass("is-valid");
                $("#rut").removeClass("is-invalid");
                $('.modal-backdrop').remove();                
                $.each($.parseJSON(respuesta), function(key,value){
                  $("#nombre").val(value.nombre);
                  $("#rut").val(value.rut);
                  $("#email").val(value.email);
                  $("#uuid_cliente").val(value.uuid);
                  });
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        });
    }
    function val_remove_class(inp){
        if ($('#'+inp).val()!=null) {
            $('#'+inp).removeClass("error");
        }
    }
    //Activar Cliente
    function activar_cliente(uuid){
        $.ajax({
            url: "<?=base_url('clientes/subir_cliente')?>",
            type: "POST",
            async: true,
            data: {"uuid_cliente":uuid},
            success: function(respuesta) {
              $('#client_data').DataTable().ajax.reload();
              console.log(respuesta);
                //window.location.reload();   
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        });
    }
    //Desactivar Cliente
    function desactivar_cliente(uuid){
        $.ajax({
          url: "<?=base_url('clientes/bajar_cliente')?>",
          type: "POST",
          async: true,
          data: {"uuid_cliente":uuid},
          success: function(respuesta) {
              //window.location.reload(); 
              $('#client_data').DataTable().ajax.reload();
          },
          error: function() {
            console.log("No se ha podido obtener la información");
        }
    });
    }
    //Enviar Correo
    function send_email(){
        $.ajax({
          url: "<?=base_url('clientes/find_licitaciones2')?>",
          type: "POST",
          success: function(respuesta) {
              //window.location.reload();
            $.ajax({
                url: "<?=base_url('clientes/send_mail2')?>",
                data: {"respuesta":JSON.stringify(respuesta)},
                type: "POST",
                success: function(respuesta2) {
                    //window.location.reload();
                    console.log(respuesta2);
                }
            });                
          },
          error: function(error) {
            //console.log(error);
            console.log("No se ha podido obtener la información");
            }
        });
    }
    function send_email_cron(){
        $.ajax({
          url: "<?=base_url('clientes/cron_enviar')?>",
          type: "POST",
          success: function(respuesta) {
              //window.location.reload();
              console.log(respuesta);               
          },
          error: function(error) {
            //console.log(error);
            console.log("No se ha podido obtener la información");
            }
        });
    }
    //Editar datos Cliente
    function send_edit(){
        $.ajax({
            url: "<?=base_url()?>clientes/edit",
            type: "POST",
            data: {"nombre":$("#nombre").val(),"email":$("#email").val(),"rut":$("#rut").val(),
            "uuid_cliente":$("#uuid_cliente").val()},
            success: function(data)
            { 
                $('#editar').modal('hide');
                $('#client_data').DataTable().ajax.reload();
                if (data.status){
                 $.notify({
                                // options
                                title: 'Correcto, ',
                                message: 'Datos actualizados' 
                            },{
                                // settings
                                type: 'success',
                                hideDuration: 7,
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },

                            });
                }else if (!data.status){ 
                $.notify({
                                    // options
                                    title: 'Error, ',
                                    message: data.reason
                                },{
                                    // settings
                                    type: 'danger',
                                    animate: {
                                        enter: 'animated fadeInDown',
                                        exit: 'animated fadeOutUp'
                                    },

                                });

                        }else{
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
            }
        });
   }
   //Agrega . y - al Rut
   $(function(){
        $("#rut")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){
              $("#rut").addClass("is-invalid")
              $("#contenedor").addClass("has-danger")
              ok=false;
            })
        .on('rutValido', function(){
               $("#rut").removeClass("is-invalid")
               $("#contenedor").removeClass("has-danger")
               $("#contenedor").addClass("has-success")
               $("#rut").addClass("is-valid")
               ok=true;
            });
    });
    $(function(){
        $("#rut2")
        .rut({formatOn: 'keyup', validateOn: 'keyup'})
        .on('rutInvalido', function(){
              $("#rut2").addClass("is-invalid")
              $("#contenedor").addClass("has-danger")
              ok=false;
          })
        .on('rutValido', function(){
               $("#rut2").removeClass("is-invalid")
               $("#contenedor").removeClass("has-danger")
               $("#contenedor").addClass("has-success")
               $("#rut2").addClass("is-valid")
               ok=true;
           });
    });
//Insertamos los datos que manda el modal!
    function send_insert(){
        var nombre = $("#nombre2").val();
        var rut = $("#rut2").val();
        var email = $("#email2").val();
        console.log(nombre,rut,email);
        $.ajax({
            url: "<?=base_url()?>clientes/add",
            type: "POST",
            data: {"nombre":nombre,"email":email,"rut":rut},
            success: function(data)
            { 
            $('#agregar').modal('toggle');
            $('#client_data').DataTable().ajax.reload();
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
             }else if(!data.status) { 
                        $.notify({
                            // options
                            title: 'Error, ',
                            message: data.reason
                        },{
                        // settings
                            type: 'danger',
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },

                        });
                    }else {
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
            }
        });
    }
</script>
</body>
</html>
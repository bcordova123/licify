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
                    <form method="post" action="<?=base_url()?>clientes/edit" id="formulario">
                    <div class="row">
                        <div class="col-md-4 offset-md-1">                                            
                            <h3>Datos personales</h3>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input required class="form-control" type="text" placeholder="Nombre" name="nombre" id="nombre" onchange = "val_remove_class('nombre');" value="<?=$cliente["nombre"]?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Rut</label>
                            <input required class="form-control" maxlength="12" type="text" placeholder="Rut" name="rut" id="rut" onchange = "val_remove_class('rut');" value="<?=$cliente["rut"]?>">
                        </div>   
                        <div class="form-group">
                            <label>Correo</label>
                            <input required class="form-control" type="email" placeholder="Correo" name="email" id="email" onchange = "val_remove_class('email');" value="<?=$cliente["email"]?>">
                        </div>                               
                        
                        
                        <div class="form-group mt-5">
                        <input name = "uuid_cliente"  type="hidden" value = "<?=$cliente["uuid"]?>" id = "uuid_cliente">
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

        function val_remove_class(inp){
            console.log(inp);
            if ($('#'+inp).val()!=null) {
                $('#'+inp).removeClass("error");
            }
        }

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


    </script>
</body>
</html>
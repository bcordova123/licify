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
        <ul class="sidebar navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="<?=base_url()?>home">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Mercado Publico</span>
    </a>
  </li>

  <?php
      #OPCIONES JEFATURA Y ADMINISTRADOR
  $uuid_admin='79b7ee41-91d4-11e9-b941-0cc47a6c172a';
  $uuid_jefe='872ffd06-92a1-11e9-b941-0cc47a6c172a';
  if ($this->session->userdata('usuario')["perfil_uuid"]==$uuid_admin || $this->session->userdata('usuario')["perfil_uuid"]==$uuid_jefe) {
    ?>

<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-address-book"></i>
        <span>Cliente</span>
      </a>
      <div class="dropdown-menu"aria-labelledby="pagesDropdown" >
        
        <form name="form1" method="post" action="<?=base_url()."clientes/action"?>">
          <select name="select1" id="select1" onchange="select_cliente()">
          </select>
        </form>  
      </div>
    </li>

<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Mis Clientes</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <a class="dropdown-item" href="<?=base_url()?>clientes/view_add">Nuevo</a>
        <button class="dropdown-item" onclick="cargar_lista()">Cargar</button>
        <a class="dropdown-item" href="<?=base_url()?>clientes/listar_clientes">Todos</a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Planes de Acceso</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <a class="dropdown-item" href="<?=base_url()?>planes/view_nuevo">Nuevo</a>
        <a class="dropdown-item" href="<?=base_url()?>planes">Listar</a>
      </div>
    </li>



    
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Usuarios</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <a class="dropdown-item" href="<?=base_url()?>usuarios/view_nuevo">Nuevo</a>
        <a class="dropdown-item" href="<?=base_url()?>usuarios">Listar</a>
      </div>
    </li>

    <?php 
  }
  ?>

</ul>
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
                </div>
            -->
                <div class="col-md-6" >
                    <button class="float-right btn btn-info">Crear cliente</button>
                </div>
                <div class="col-md-12"><hr></div>
                <div class="col-md-12">
                    <div class="table-responsive mb-5">
                    <table class="table" id="client_data">
                        <thead>
                            <th>Razón Social</th>
                            <th>Email</th>
                            <th>Estado</th> 
                            <th>Editar</th>
                            <th>Acción</th>
                        </thead>
                        <tbody>
                            <?php 
                            if (isset($clientes)):
                            foreach ($clientes as $key => $value):?>
                                <td><?=$value['nombre']?></td>
                                <td><?=$value['email']?></td>
                                <td><?=$value['status']?></td>
                                <td></td>
                                <td></td>
                            <?php endforeach; endif;?>
                        </tbody>
                       
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
                          <form method="post" action="<?=base_url()?>clientes/edit" id="formulario">
                            <div class="row">
                                <div class="col-md-10 offset-md-1" >                                            
                                <h3>Datos personales</h3>
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input required class="form-control" type="text" placeholder="Nombre" name="nombre" id="nombre" onchange = "val_remove_class('nombre');" value="">
                                </div>
                        
                                <div class="form-group">
                                    <label>Rut</label>
                                    <input required class="form-control" maxlength="12" type="text" placeholder="Rut" name="rut" id="rut" onchange= "val_remove_class('rut');" value="">
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
        tabla("<?php echo base_url() . 'clientes/fetch_client'; ?>",'client_data');
        $('#client_data').removeClass('no-footer');
        $('#client_data').removeClass('dataTable');
    });  
    function cargarmodal(uuid){

        //$('#editar').style.display=('init'); 

        $.ajax({
          url: "<?=base_url('clientes/view_modificar')?>",
          type: "POST",
          data: {"uuid_cliente":uuid},
          success: function(respuesta) {
              //window.location.reload(); 
              $('#editar').modal(); 
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
            console.log(inp);
            if ($('#'+inp).val()!=null) {
                $('#'+inp).removeClass("error");
            }
        }
    function activar_cliente(uuid){
        $.ajax({
          url: "<?=base_url('clientes/subir_cliente')?>",
          type: "POST",
          async: true,
          data: {"uuid_cliente":uuid},
          success: function(respuesta) {

            console.log(respuesta);
              //window.location.reload();   

          },
          error: function() {
                console.log("No se ha podido obtener la información");
            }
      });
    }
    function desactivar_cliente(uuid){
        $.ajax({
          url: "<?=base_url('clientes/bajar_cliente')?>",
          type: "POST",
          async: true,
          data: {"uuid_cliente":uuid},
          success: function(respuesta) {
              //window.location.reload(); 

          },
          error: function() {
                console.log("No se ha podido obtener la información");
            }
      });
    }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script type="text/javascript">

 $(document).ready(function(){


    $.ajax({
    url: "<?=base_url('clientes/select_cliente')?>",
    type: "POST",
    success: function(respuesta) {

      $.each($.parseJSON(respuesta), function(key,value){

        value.forEach(function(element) {

          var s = document.form1.select1;
          //Ahora para crear el objeto option que le vas a añadir seria
          var option = document.createElement("option");
          option.value = element.uuid;
          option.text = element.nombre;
          if (option.value == "<?= $this->session->userdata('cliente');?>") {
            option.selected = true;
          }
          s.append(option) // y aqui lo añadiste

        });
      });


      console.log(respuesta);
    },
    error: function() {
          console.log("No se ha podido obtener la información");
      }
    });

});

    function select_cliente(){

      /* Para obtener el valor */
      var uuid = document.getElementById("select1").value;       
      /* Para obtener el texto */
      var nombre = document.getElementById("select1");
      var selected = nombre.options[nombre.selectedIndex].text;
      console.log(selected);

      $.ajax({
          url: "<?=base_url('clientes/action')?>",
          type: "POST",
          data: {"uuid_cliente":uuid,"nombre":selected},
          success: function(respuesta) {
              window.location.reload();            
          },
          error: function() {
                console.log("No se ha podido obtener la información");
            }
      });
    }

    function cargar_lista(){

      $.ajax({
          url: "<?=base_url('clientes/listar_clientes')?>",
          type: "GET",
          success: function(respuesta) {
                console.log("Lista cargada");  

                $("#content-wrapper").html(respuesta);     
          },
          error: function() {
                console.log("No se ha podido obtener la información");
            }
      });
    }



</script>
</body>
</html>
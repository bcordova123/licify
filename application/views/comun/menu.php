<ul class="sidebar navbar-nav">
    <div style="text-align: center">
        <i class="far fa-address-book" style="color: white;"><span style="color: white;"> <font face="Arial"> Clientes </font> </i></span>
        <form name="form1" method="post" action="<?=base_url()."clientes/action"?>">
          <select name="select1" id="select1" onchange="select_cliente()">
            <option value="0">Seleccionar cliente</option>
          </select>
        </form>  
    </div>
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
        <span>Licitaciones faltantes</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <a class="dropdown-item" href="<?=base_url()?>clientes/filter">Todas</a>
        <a class="dropdown-item" href="<?=base_url()?>clientes/ordenes">Ordenes de Compra</a>
        </a>
      </div>
    </li>




<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-fw fa-folder"></i>
        <span>Mis Clientes</span>
      </a>
      <div class="dropdown-menu" aria-labelledby="pagesDropdown">
        <a class="dropdown-item" href="<?=base_url()?>clientes">Todos</a>
        <a class="dropdown-item" href="<?=base_url()?>clientes/cargar_page_filter">Filtros</a>
        <a class="dropdown-item" href="<?=base_url()?>clientes/horarios">Mis Horarios</a>
        <!--<button class="dropdown-item" onclick="cargar_lista()">Cargar</button>    -->    
        
        
        <!--<a class="dropdown-item" href="<?=base_url()?>clientes/listar_clientes">Todos</a>-->
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
        <a class="dropdown-item" href="<?=base_url()?>planes/cargar_multi_select">Multi select</a>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">

  jQuery(document).ready(function($) {
    $("#select1").select2({
    tags: true
    });
  });
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
          s.append(option); // y aqui lo añadiste

        });
      });


      //console.log(respuesta);
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
      //console.log(selected);

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

                $("#container").html(respuesta);     
          },
          error: function() {
                console.log("No se ha podido obtener la información");
            }
      });
    }



</script>
      <!-- Main Sidebar Container -->
      <style>
      .center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
      </style>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <img src="https://fotos.subefotos.com/9d156d0a705d368d0226d9ec5626ba46o.png" alt="LICIFY Logo" class="brand-image img-square"
          style="opacity: .8">
        <!--   <span class="brand-text font-weight-light">LICITOR </span> -->
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="<?=base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block"><?=$this->session->userdata('usuario')['nombre'];?></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
         

          <li class="nav-header">INICIO</li>

          <li class="nav-item">
            <a id="estadisticas" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Estadísticas
              <!--  <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>


          <li class="nav-header">LICITACIONES</li>


        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-eye"></i>
              <p>
                Búsquedas
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">Nuevo!</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a id="new_busqueda" class="nav-link">
                  <i class="nav-icon fas fa-cart-plus"></i>
                  <p>Nueva búsqueda</p>
                  <span class="badge badge-danger right">-10%</span>
                </a>
              </li>
              <li class="nav-item">
                <a id="busquedas" class="nav-link">
                  <i class="nav-icon fas fa-search-dollar"></i>
                  <p>Mis búsquedas</p>
                </a>
              </li>

              <li class="nav-item">
                <a id="horarios" class="nav-link">
                  <i class="nav-icon fas fa-stopwatch"></i>
                  <p>Mis horarios</p>
                </a>
              </li>
              
            </ul>
          </li>


          <li class="nav-header">ESTUDIOS DE DATA</li>

          <li class="nav-item">
            <a id="estadisticas" class="nav-link">
              <i class="nav-icon fas fa-x"></i>
              <p>
                Próximamente
               <!-- <span class="badge badge-warning right">Pronto</span> -->
              </p>
            </a>
          </li>


          <li class="nav-header">CUENTA</li>
          <li class="nav-item">
            <a id="facturacion" class="nav-link">
              <i class="nav-icon fas fa-money-check-alt"></i>
              <p>
                Facturación
              <!--  <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuración
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register</p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forgot Password</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-header">AYUDA</li>

        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                ¿Cómo funciona?
              <!--  <span class="badge badge-info right">2</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-inbox"></i>
              <p>Soporte</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
<script>
  $( document ).ready(function() {

    // INICIO
    $('#content-licitor').load("Utils/loading", function() {
      $('#content-licitor').load( "Estadisticas/index", function() {
        $("#estadisticas").attr('onclick', 'navegacion(0, this)');
      });
    });


    // BUSQUEDAS
    $("#new_busqueda").attr('onclick', 'navegacion(1, this)');  
    $("#busquedas").attr('onclick', 'navegacion(2, this)');      
    $("#horarios").attr('onclick', 'navegacion(3, this)'); 



    // CUENTA
    $("#facturacion").attr('onclick', 'navegacion(8, this)'); 


    // SEARCH
    $("#formSearch").submit(function(e){
        e.preventDefault();

        var form = this;
        var query = $("#query-search").val();

        if(query === undefined || query === "") {
          return;
        }

        var estado = $("#filter-estado").val();
        var tipo = $("#filter-tipo").val();
        var region = $("#filter-region").val();

        query = query.replace(new RegExp(" ", 'g'), "%20");

        $('#content-licitor').load("Utils/loading", function() {
          $('#content-licitor').load("Search/buscar2/" + query + "/" + estado + "/" + tipo + "/" + region, function() {
        });
      });
        return;
    });

    $("#dropdown-filter").on('click', function (event) {
        $("#dropdown-filter-menu").toggleClass('show');
    });

   /* $('body').on('click', function (e) {

    if (!$('.dropdown-item').is(e.target) 
        && !$('select.select2').is(e.target) 
        && $('#dropdown-filter').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ) {
        $('#dropdown-filter-menu').removeClass('show');
    } 
});*/

});
  function navegacion(numero, elem){

    $(elem).removeAttr('onclick');

    $('#content-licitor').load("Utils/loading", function() {
      switch(numero) {
      case 0:
        $('#content-licitor').load("Estadisticas/index", function() {
          $(elem).attr('onclick', 'navegacion(' + numero + ', this)');
        });
      break;
      case 1:
        $('#content-licitor').load("Home/index", function() {
          $(elem).attr('onclick', 'navegacion(' + numero + ', this)');
        });
      break;
      case 2:
        $('#content-licitor').load("Clientes/index", function() {
          $(elem).attr('onclick', 'navegacion(' + numero + ', this)');
        });
      break;
      case 3:
        $('#content-licitor').load("Clientes/horarios", function() {
          $(elem).attr('onclick', 'navegacion(' + numero + ', this)');
        });
      break;
      case 8:
        $('#content-licitor').load("Facturacion/index", function() {
          $(elem).attr('onclick', 'navegacion(' + numero + ', this)');
        });
      break;
      }
    });
  }

  function applyFiltros() {
    $("#dropdown-filter-menu").toggleClass('show');

    var query = $("#query-search").val();

    if(query !== undefined && query !== "") {
      $("#btnSearchSubmit").click();
    }

  }

</script>
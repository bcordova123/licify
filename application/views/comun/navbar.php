
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto ml-md-2">
            <div class="input-group">
                <!-- <label type="text" style="color: green;font-size:20px;margin-top: 5px" aria-label="Search" aria-describedby="basic-addon2">Bienvenido: <?=$this->session->userdata('usuario')['nombre'];  ?></label> -->
            </div>        
        </ul>

        <!-- FORM BUSQUEDA -->
        <form id="formSearch" class="form-inline ml-6 col-lg-4">
          <div class="input-group input-group-sm" style="width: 100%">
            <input id="query-search" class="form-control form-control-navbar" type="search" placeholder="Buscar tus licitaciones" aria-label="Search">
            <div class="input-group-append">
              <button id="btnSearchSubmit" class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </form>


        <!-- FILTER BUSQUEDA -->
        <ul class="navbar-nav">
        <li class="nav-item dropdown">
        <a id="dropdown-filter" class="nav-link" >
          <i class="fas fa-filter"></i>
          <span class="badge badge-danger navbar-badge">0</span>
        </a>
        <div id="dropdown-filter-menu" class="dropdown-menu dropdown-menu-lg xl dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Filtro de licitaciones</span>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item">
            <i class="fas fa-file-medical-alt mr-6" style="margin-right: 5px"></i> Estado
            <span class="float-right text-muted text-sm" style="width: 50%">
                <select id="filter-estado" class="select2 loat-right text-muted text-sm" style="width: 100%">
                      <option value="TODOS">Todos los estados</option>
                      <option value="Publicada" selected="selected">Publicada</option>
                      <option value="Cerrada">Cerrada</option>
                      <option value="Adjudicada">Adjudicada</option>
                      <option value="Desierta">Desierta</option>
                      <option value="Revocada">Revocada</option>
                      <option value="Suspendida">Suspendida</option>
                </select>
            </span>
          </a>
          <div class="dropdown-divider"></div>
          <a  class="dropdown-item">
            <i class="fas fa-thumbtack mr-6" style="margin-right: 5px"></i> Tipo de licitación 
            <span class="float-right text-muted text-sm" style="width: 50%">
              <select id="filter-tipo" class="select2 loat-right text-muted text-sm " style="width: 100%">
                    <option value="TODOS" selected="selected" >Todos los tipos</option>
                    <option value="L1">(L1) Lic. Pública < 100 UTM</option>
                    <option value="LE">(LE) Lic. Pública >= 100 y < 1000 UTM</option>
                    <option value="LP">(LP) Lic. Pública >= 1.000 UTM & < 2.000 UTM</option>
                    <option value="LQ">(LQ) Lic. Pública >= 2.000 UTM & < 5.000 UTM</option>
                    <option value="LR">(LR) Lic. Pública >= 5.000 UTM</option>
                    <option value="LS">(LS) Lic. Pública Serv. Personales Especializados</option>
                    <option value="O1">(O1) Lic. Pública de Obras</option>
                    <option value="E2">(E2) Lic. Privada Inferior < 100 UTM</option>
                    <option value="CO">(CO) Lic. Privada >= 100 UTM & < 1000 UTM</option>
                    <option value="B2">(B2) Lic. Privada >= 1000 UTM & < 2000 UTM</option>
                    <option value="H2">(H2) Lic. Privada >= 2000 UTM & < 5000 UTM</option>
                    <option value="I2">(I2) Lic. Privada > 5000 UTM</option>
                    <option value="O2">(O2) Lic. Privada de Obras</option>
                </select>
            </span>
          </a>
          <div class="dropdown-divider"></div>
          <a  class="dropdown-item">
            <i class="fas fa-globe-americas mr-6" style="margin-right: 5px"></i> Región
            <span class="float-right text-muted text-sm" style="width: 50%">
              <select id="filter-region" class="select2 loat-right text-muted text-sm " style="width: 100%">
                      <option value="TODOS" selected="selected">Todas las regiones</option>
                      <option value="1">Región Metropolitana de Santiago</option>
                      <option value="2">Región Aysén del General Carlos Ibáñez del Campo</option>
                      <option value="3">Región de Antofagasta</option>
                      <option value="4">Región de Arica y Parinacota</option>
                      <option value="5">Región de Atacama</option>
                      <option value="6">Región de Coquimbo</option>
                      <option value="7">Región de la Araucanía</option>
                      <option value="8">Región de los Lagos</option>
                      <option value="9">Región de Los Ríos</option>
                      <option value="10">Región de Magallanes y de la Antártica</option>
                      <option value="11">Región de Tarapacá</option>
                      <option value="12">Región de Valparaíso</option>
                      <option value="13">Región del Biobío</option>
                      <option value="14">Región del Libertador General Bernardo O´Higgins</option>
                      <option value="15">Región del Maule</option>
                      <option value="16">Región del Ñuble</option>
                </select>
              </span>
          </a>
          <div class="dropdown-divider"></div>
          <a onclick="applyFiltros()" class="bg-primary dropdown-item dropdown-footer " style="color: #fff">Aplicar filtros</a>
        </div>
      </li>
      </ul>


      <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <!-- <a class="dropdown-item" href="<?=base_url()?>usuarios/view_modificar/<?=$this->session->userdata('usuario')["uuid"]?>">Mi perfil</a> -->
                <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="<?=base_url()?>auth/logout">Salir</a>
                </div>
            </li>
        </ul>
      </nav>

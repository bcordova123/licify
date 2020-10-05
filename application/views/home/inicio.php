<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Licitame.cl | APP</title>


  <?php
    $this->load->view('comun/css'); 
  ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
      <!-- /.navbar -->
      <!-- Main Sidebar Container -->
      <?php
        $this->load->view('comun/navbar'); 
        $this->load->view('comun/menu2'); 
      ?>
<div id="content-licitor" class="col-md-12">
</div>
  <!-- /.control-sidebar -->
  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2019 <a href="https://saargo.com">Saargo SPA</a>.</strong>
    <small>Todos los derechos reservados.</small>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>
</div>
<?php 
$this->load->view('comun/js');
?>
</body>
</html>

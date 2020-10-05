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
            </div>
            <div class="col-md-12"><hr></div>
            <div class="col-md-12">
                <div class="table-responsive mb-5">
                    <table class="table" id="client_data">
                        <thead>                          
                            <th>Rut</th>
                            <th>Razón Social</th>
                            <th>Filtros</th>
                            <th>Acción</th>
                        </thead>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
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
        tabla("<?php echo base_url().'clientes/fetch_client_filtros'; ?>",'client_data');
        $('#client_data').removeClass('no-footer');
        $('#client_data').removeClass('dataTable');
    }); 
    function cargarbusqueda(uuid_cliente){        
        $.ajax({
            url: "<?=base_url('clientes/edit_busqueda')?>",
            type: "POST",
            data: {"uuid_cliente":uuid_cliente},
            dataType: 'html',
            success: function(respuesta) {
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
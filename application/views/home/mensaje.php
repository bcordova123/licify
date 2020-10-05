<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mercado Planes</title>
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css_wizard/roboto-font.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- datepicker -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css_wizard/jquery-ui.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css_wizard/style.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <?php
    $this->load->view('comun/css'); 
    ?>  

</head>
<body>
<?php
    $this->load->view('comun/navbar'); 
    ?>
    <div id="wrapper">
        <?php
        $this->load->view('comun/menu'); 
        ?>
                <!--START CONTENT-->
	<div class="page-content" style="background-image: url('<?=base_url()?>assets/images/wizard-v3.jpg')">
		<div class="wizard-v3-content">
			<div class="wizard-form">         
				<div class="wizard-header">
                    <h3 class="heading">El pago no se pudo realizar!</h3>		
				</div>
		        <div class="form-register">		
			            <section>
			                <div class="col-md-12 inner">
			                	<div class="form-row">
									<div class="form-holder form-holder-2 ">
                                    <a href="<?=base_url()."home"?>" class="btn btn-danger col-md-2 offset-md-5">Volver al medio de pago?</a>                                  
                                        </label>
                                    </div>                                    
								</div>
							</div>
			            </section>	
                </div>                
            <?php endif;?>
			</div>        
		</div>
    </div>
    <?php 
$this->load->view('comun/footer');
$this->load->view('comun/js');
?>
    <script src="https://cdn.kushkipagos.com/kushki-checkout.js"></script>
	<script src="<?=base_url()?>assets/js/jquery.steps.js"></script>
    <script src="<?=base_url()?>assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>    
    <script>        

    </script>

</body>
</html>


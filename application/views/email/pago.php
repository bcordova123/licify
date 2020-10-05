<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
	body, html {
		width: 100%;
	}
	body {
		font-family: sans-serif; 
		font-size: 13px;
		color: #555;
	}
	.row {
		display: table; 
		width: 100%;
	}
	.col,
	.col-3,
	.col-6,
	.col-9,
	.col-12 {
		padding: 5px 10px;
		display: table-cell; 
		vertical-align: middle;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;    
		box-sizing: border-box;
	}
	.col-3 {
		width: 25%;
	}
	.col-6 {
		width: 50%; 
	}
	.col-9 {
		width: 75%;
	}
	.col-12 {
		width: 100%; 
	}
	#licitaciones {
		background: #f8f8f8; 
		width: 800px; 
		margin: 0 auto; 
		padding: 30px; 
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;    
		box-sizing: border-box;
	}
	.top-header {
		width: 100%; 
		margin-bottom: 30px; 
		display: table; 
		overflow: hidden;
	}
	.bottom-header {
		border: 1px solid #34D185;
		border-bottom: 0;
	}
	.table-wrap {
		border: 1px solid #34D185;
		border-bottom: 0;
	}
	
	@media only screen and (max-width: 769px) {
		#licitaciones {
			width: 100%!important;
		}
		.col,
		.col-3,
		.col-6,
		.col-9,
		.col-12 {
			width: 100%!important;
			display: block;
		}
		.date {
			text-align: left!important;
		}
	}
</style>
</head>
<body>
<div id="licitaciones">
	<div class="header">
		<div class="top-header">
			<div class="col-6">
				<img src="https://fotos.subefotos.com/9d156d0a705d368d0226d9ec5626ba46o.png" alt="Licify Logo" style="height: 50px;">
			</div>
			<div class="col-6 date" style="text-align: right;">
				<?php $fecha = date('d-m-Y');?>
				<span>Fecha:<?=$fecha;?></span>
			</div>
		</div>
		<div class="bottom-header">
			<div class="row">
				<div class="col-12" style="background: #34D185;"><strong style="color: #fff;">Pago realizado con exito</strong></div>
			</div>	
            <h3 class="text-success">Transacción aceptada</h3>
                <p>La transacción se ha procesado correctamente</p>
                <span><?=$mensaje?></span>
                <h4>Detalles de la compra</h4>
                <table class="table">
                      <tr>
                          <th>Orden de compra</th>
                          <td><?=$orden_compra?></td>
                      </tr>
                      <tr>
                          <th>Tipo de pago</th>
                          <td><?=$tipo_pago?></td>
                      </tr>
                      <tr>
                          <th>Cuotas</th>
                          <td><?=$cuotas?></td>
                      </tr>
                      <tr>
                          <th>Tarjeta</th>
                          <td><?=$card_detail?></td>
                      </tr>
                      <tr>
                          <th>Total</th>
                          <td><?=$amount?></td>
                      </tr>
                      <tr>
                          <th>Fecha de pago</th>
                          <td><?=$fecha_pago?></td>
                      </tr>
                      <tr>
                          <th>Fecha de expiración</th>
                          <td><?=$termino?></td>
                      </tr>
                  </table>                
                 <h4>Busquedas compradas</h4>
                 <table>
                 <tr>
                    <th>Tipos</th>
                    <td><?=$busqueda[0]["tipos"]?></td>
                </tr>
                 </table>
                    
                    <table class="table">
                   <thead>
                     <th>Nombre</th>
                     
                   </thead>
                  <?php
                      foreach ($busqueda as $busq) {
                        ?>
                        <tr>
                          <td><?=$busq["termino"]?></td>
                        </tr>
                        <?php
                      }

                    ?>
                   
                 </table>		
		</div>
	</div>
	
	<div class="content">				
		<div class="teal" style="margin-top: 30px;">
			<h3 style="margin: 0 0 3px 0;">Equipo Licify</h3>
			<p style="margin: 0 0 3px 0;">Fono: (56-2) 1111 0000</p>
			<p style="margin: 0 0 3px 0;">Email: contacto@licify.cl</p>
			<p style="margin: 0 0 3px 0;">Condell 105, Providencia, Santiago – Chile</p>
			<p style="margin: 0 0 3px 0;"><a style="color: #34D185; text-decoration: none;" href="http://www.licify.cl">www.licify.cl</a></p>
		</div>
		
	</div>
</div>
</body>
</html>

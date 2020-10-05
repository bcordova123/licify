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
				<div class="col-12" style="background: #34D185;"><strong style="color: #fff;">DATOS DEL CLIENTE</strong></div>
			</div>
			<?php if (isset($plan)):?>
				<?php 
					$Nombre = $plan['Nombre'];
                	$Plan = $plan['Plan'];
                	
					?>
			<div class="row" style="border-bottom: 1px solid #34D185;">
				<div class="col" style="width: 30%;"><strong>Nombre</strong></div>
				<div class="col" style="width: 70%;"><?=$Nombre?></div>
			</div>
			<?php foreach ($Plan as $key => $value):
				$Licitaciones = $value['Licitaciones'];
				
				array_multisort(array_column($Licitaciones, "Fechas_FechaCierre"), SORT_DESC, $Licitaciones);
				if (count($Licitaciones) > 0):
					?>
			<div class="row" style="border-bottom: 1px solid #34D185;">
				<div class="col" style="width: 30%;"><strong>Termino de Busqueda</strong></div>
				<div class="col" style="width: 70%;"><?=$value['Termino']?></div>
			</div>
		</div>
	</div>
	
	<div class="content">
		<div class="table-wrap">
			<div class="thead">
				<div class="row" style="background: #34D185;">
					<div class="col" style="width: 15%;"><strong style="color: #fff;">Cód. Externo</strong></div>
					<div class="col" style="width: 15%;"><strong style="color: #fff;">Licitación</strong></div>
					<div class="col" style="width: 10%;"><strong style="color: #fff;">Región</strong></div>
					<div class="col" style="width: 10%;"><strong style="color: #fff;">Monto</strong></div>
					<div class="col" style="width: 10%;"><strong style="color: #fff;">Fecha Cierre</strong></div>
					<div class="col" style="width: 10%;"><strong style="color: #fff;">Link</strong></div>
					<div class="col" style="width: 10%;"><strong style="color: #fff;">Estado</strong></div>
				</div>
			</div>
			<?php 
				foreach ($Licitaciones as $key => $value2): 				
				$CodigoExterno = $value2['CodigoExterno'];
            	$Nombre = $value2['Nombre'];
            	$Region = $value2['Comprador_RegionUnidad'];
				$Monto = $value2['montoestimado'];
				$monto2 = (int)$Monto;
            	//$monto_chileno = (int)$Monto;
            	$Moneda = $value2['Moneda'];

            	if ($Moneda == "CLP") {
					setlocale(LC_MONETARY, 'es_CL');
					$monto_transformado = money_format('%i', $monto2);
					$monto_2 = explode((","),$monto_transformado);
					$monto_3 = explode((" "), $monto_2[0]);
					$monto_chileno = "$".$monto_3[1];
            		}elseif ($Moneda == "USD") {
						setlocale(LC_MONETARY, 'en_US');
						$monto_chileno = money_format('%i', $monto2);
            			}elseif ($Moneda == "EUR") {
            				setlocale(LC_MONETARY, 'en_GB');
							$monto_chileno = money_format('%i', $monto2);
            				}elseif ($Moneda == "CLF") {
            					$monto_chileno = "UF ".$monto2;
            					}elseif ($Moneda == "UTM") {
            						$monto_chileno = "UTM ".$monto2;
            					}
            	if (is_null($Monto)) {
            	  $monto_chileno = "No disponible";
				}
				$Cierre = $value2['Fechas_FechaCierre'];
				$Cierre2 = explode((" "), $Cierre);
				$Cierre3 = explode(("-"), $Cierre2[0]);
				$Hora = explode((":"), $Cierre2[1]);
            	$Link = "http://www.mercadopublico.cl/Procurement/Modules/RFB/DetailsAcquisition.aspx?idlicitacion=".$CodigoExterno;            
             	$Estado = $value2['Estado'];
				?>
			<div class="tbody">
				<div class="row" style="border-bottom: 1px solid #34D185;">
					<div class="col" style="width: 15%;"><?=$CodigoExterno?></div>
					<div class="col" style="width: 15%;"><?=$Nombre?></div>
					<div class="col" style="width: 10%;"><?=$Region?></div>
					<div class="col" style="width: 10%;"><?=$monto_chileno?></div>
					<div class="col" style="width: 10%;"><?=$Cierre3[2]."-".$Cierre3[1]."-".$Cierre3[0]." ".$Hora[0].":".$Hora[1]?></div>
					<div class="col" style="width: 10%;"><a href="<?=$Link?>" target="_blank"><img src="https://fotos.subefotos.com/239cefd53565468f0464967ca3eeeb65o.png" alt="Botón Ver" style="display: block; width: 60px;"></a></div>
					<div class="col" style="width: 10%;"><?=$Estado?></div>
				</div>
			</div>
			<?php endforeach; endif;?>
			<?php endforeach; endif; ?>
		</div>
		
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

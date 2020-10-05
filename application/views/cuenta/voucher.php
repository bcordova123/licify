<html>
    <head>

<style>
@page {
    margin: 1cm !important;
            /*margin: 20px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important; */
        }

</style>
    
    </head>
    <body>
<table style="width: 630px; margin: 0 auto;">
	<thead>
		<tr>
			<td>
				<table width="100%" style="font-size: 9px; font-family: sans-serif;">
					<tbody>
						<tr>
							<td><img src="<?=base_url()?>assets/img/logo-licify.png" alt="Licitame.cl Logo" style="width: 200px;"></td>
							<td align="right"><span class="date">Santiago, Chile</span></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tbody>
						<tr>
							<td height="10"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="font-size: 9px; font-family: sans-serif;">
					<tbody>
						<tr>
							<td style="width: 20%"><strong>RAZÓN SOCIAL</strong></td>
							<td style="width: 80%">LICITAME S.P.A.</td>
						</tr>
						<tr>
							<td style="width: 20%"><strong>RUT</strong></td>
							<td style="width: 80%">93.027.000-8</td>
						</tr>
             
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" >
					<tbody>
						<tr>
							<td height="10" ></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="border: 1px solid #0084C7; border-collapse: collapse; font-size: 9px; font-family: sans-serif; ">
					<tbody>
						<tr>
							<td colspan="2" style="background: #0084C7; padding: 5px 10px; color: #fff; " ><strong>DETALLE DEL PAGO</strong></td>
						</tr>
                        <tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>NRO. COMPROBANTE</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?=$voucher[0]["numero_orden"]?></td>
						</tr>
						<tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>CLIENTE</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?=strtoupper($usuario["nombre"])?> <?=strtoupper($usuario["apellidos"])?></td>
						</tr>
						<tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>RUT</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;">aaa</td>
						</tr>
					<!--	<tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>DIRECCIÓN FACTURACIÓN</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;">Independencia 1721, Valparaiso</td>
						</tr>
						<tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>DIRECCION DESPACHO</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;">Independencia 1721, Valparaiso</td>
                        </tr> -->
                        <tr><!-- //contado TR = 0, credito = 1 contado CH = 2, contado TA = 3, contado EF = 4 -->
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>FECHA DE TRANSACCION</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?= date('d/m/Y H:i:s', strtotime($voucher[0]["fecha_pago"])) ?></td>
                        </tr>
                        <tr><!-- //contado TR = 0, credito = 1 contado CH = 2, contado TA = 3, contado EF = 4 -->
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>FORMA DE PAGO</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?=$voucher[0]["tipo_pago"]?></td>
                        </tr>
                        <!-- //contado TR = 0, credito = 1 contado CH = 2, contado TA = 3, contado EF = 4 -->
                      <!--  <tr>
							<td style="width: 25%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><strong>CUOTAS</strong></td>
							<td style="width: 75%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?php if($voucher[0]["cuotas"] > 0) echo $voucher[0]["cuotas"] ?></td>
                        </tr> -->

					</tbody>
				</table>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<table width="100%" >
					<tbody>
						<tr>
							<td height="10"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="border: 1px solid #0084C7; border-collapse: collapse; font-size: 9px; font-family: sans-serif;">
					<thead>
						<tr>
                            <td style="background: #0084C7; width: 10%; padding: 5px 10px; color: #fff; text-align: center;"><strong>CODIGO</strong></td>
							<td style="background: #0084C7; width: 65%; padding: 5px 10px; color: #fff; text-align: center;"><strong>DESCRIPCIÓN DEL SEGMENTO</strong></td>
							<td style="background: #0084C7; width: 10%; padding: 5px 10px; color: #fff; text-align: center;"><strong>CANTIDAD</strong></td>
                            <td style="background: #0084C7; width: 15%; padding: 5px 10px; color: #fff; text-align: center;"><strong>PRECIO</strong></td>
						</tr>
					</thead>
					<tbody>

                    <?php 

                        $i=1;
                        $sumCantidad = 0;
                        foreach ($voucher as $x => $producto) {
                            $sumCantidad = $sumCantidad+1;
                            ?>

						<tr>
                            <td style="background: #e9f1f4; width: 10%; padding: 5px 10px; border-bottom: 1px solid #0084C7; text-align: center;"><?= $producto["segmento_cod"] ?></td>
							<td style="background: #e9f1f4; width: 65%; padding: 5px 10px; border-bottom: 1px solid #0084C7;"><?= $producto["termino"] ?></td>
							<td style="width: 10%; padding: 5px 10px; border-bottom: 1px solid #0084C7; text-align: center;">1</td>
                            <td style="width: 15%; padding: 5px 10px; border-bottom: 1px solid #0084C7; text-align: right;">0.05 UF</td>
                        </tr>
                        <?php
							if ($i%12==0) {
								?>
									<div style="page-break-after: always;"></div>
								<?php
							}
                        }
                    ?>
					</tbody>
					<tfoot>
                        <tr>
							<th style="width: 10%; padding: 10px; border-bottom: 1px solid #0084C7; text-align: right;"><strong></strong></th>
							<th style="width: 65%; padding: 10px; border-bottom: 1px solid #0084C7; text-align: right;"><strong>TOTALES PARCIALES</strong></th>
							<th style="width: 10%; padding: 10px; border-bottom: 1px solid #0084C7; text-align: center;"><strong><?=$sumCantidad?></strong></th>
							<th style="width: 15%; padding: 10px; border-bottom: 1px solid #0084C7; text-align: right;"><strong><?=($sumCantidad * 0.05)?> UF</strong></th>
						</tr>
						
					</tfoot>
				</table>
			</td>
		</tr>
        <tr>
			<td>
				<table width="100%" style="border: 1px solid #0084C7; border-collapse: collapse; font-size: 9px; font-family: sans-serif;">
					<tbody>
						<tr>
                            <td style="background: #0084C7; width: 70%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7;"><strong>TOTAL NETO</strong></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"><strong>$<?=str_replace(',','.',number_format(20000))?></strong></td>
                        </tr>
                        <tr>
                            <td style="background: #0084C7; width: 70%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7;"><strong>DESCUENTOS</strong></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"><strong>$<?=str_replace(',','.',number_format(20000))?></strong></td>
                        </tr>
                        <tr>
                            <td style="background: #0084C7; width: 70%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7;"><strong>SUBTOTAL</strong></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"><strong>$<?=str_replace(',','.',number_format(20000))?></strong></td>
                        </tr>
                        <tr>
                            <td style="background: #0084C7; width: 70%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7;"><strong>IVA</strong></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"><strong>$<?=str_replace(',','.',number_format(20000))?></strong></td>
                        </tr>
                        <tr>
                            <td style="background: #0084C7; width: 70%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7;"><strong>TOTAL</strong></td>
							<td style="background: #0084C7; width: 15%; padding: 2px 10px; color: #fff; border-bottom: 1px solid #0084C7; text-align: center;"><strong>$<?=str_replace(',','.',number_format(20000))?></strong></td>
                        </tr>
					</tbody>
				</table>
			</td>
		</tr>	
	</tbody>
	<tfoot>
		<tr>
			<td>
				<table width="100%">
					<tbody>
						<tr>
							<td height="10"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%" style="border: 1px solid #0084C7; border-collapse: collapse; font-size: 9px; font-family: sans-serif;">
					<thead>
						<tr>
							<td style="background: #0084C7; width: 50%; padding: 5px 10px; color: #fff; text-align: center;"><strong>CONDICIONES COMERCIALES</strong></td>
							<td style="background: #0084C7; width: 50%; padding: 5px 10px; color: #fff; text-align: center;"><strong>DESPACHO</strong></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td valign="top" style="border: 1px solid #0084C7;">
								<table width="100%" style="font-size: 9px; font-family: sans-serif;">
									<tr>
										<td style="width: 25%; padding: 5px 10px; vertical-align: top;"><strong>PAGOS</strong></td>
										<td style="width: 75%; padding: 5px 10px; vertical-align: top;">
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx:</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
										</td>
									</tr>
									<tr>
										<td style="width: 25%; padding: 5px 10px; vertical-align: top;"><strong>VALIDEZ DE COTIZACIÓN</strong></td>
										<td style="width: 75%; padding: 5px 10px; vertical-align: top;">
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
										</td>
									</tr>
								</table>
							</td>
							<td valign="top" style="border: 1px solid #0084C7;">
								<table width="100%" style="font-size: 9px; font-family: sans-serif;">
									<tr>
										<td style="width: 100%; padding: 5px 10px; vertical-align: top;">
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
											<p style="margin: 0 0 5px 0;">xxxxxxxxxxxxxxxxxxxxx</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tbody>
						<tr>
							<td height="10"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tbody style="font-size: 9px; font-family: sans-serif;">
						<tr>
							<td>
								<h3 style="margin: 0 0 3px 0;">Equipo Licitame.cl</h3>
								<h4 style="margin: 0 0 3px 0; font-size: 9px;">Ejecutivo de ventas Distribución</h4>
								<p style="margin: 0 0 3px 0;">Móvil: (56-9) 9801 0548 | Fono: (56-2) 2939 4000 anexo 4040</p>
								<p style="margin: 0 0 3px 0;">Avenida Providencia 1760  of. 1203, Providencia, Santiago – Chile</p>
								<p style="margin: 0 0 3px 0;"><a style="color: #0084C7; text-decoration: none;" href="https://www.licitame.cl">www.licitame.cl</a> <span style="color: #0084C7;">|</span></p>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tfoot>
</table>
</body>
</html>
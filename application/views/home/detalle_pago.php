<form action="<?=base_url()."webpay/pagoNormal"?>" method="post">
    <h3>3° Paga con WebPay</h3>
    
    <h3>Datos de compra</h3>
    <span>Número de orden:   <input type="text" name="numero_orden" id="numero_orden" value="<?=$datos['numero_orden']?>" disabled></span>
    <br>
    <span>Nombre comprador:   <input type="text" name="nombre" value="asd" disabled></span>
    <br>
    <span>Correo comprador:   <input type="text" name="email" value="<?=$datos['email']?>" disabled></span>
    <br>
    <?php
    if(isset($meses)){
        $duracion = "";
        $fecha = date('Y-m-d H:i:s');
        if ($meses == "monthly") {
            $fecha2 = date("Y-m-d H:i:s",strtotime($fecha."+ 1 month"));
            $duracion = $fecha2;
        }elseif ($meses == "quarterly") {
            $fecha2 = date("Y-m-d H:i:s",strtotime($fecha."+ 3 month"));
            $duracion = $fecha2;
        }
    }
    ?>
    <span>Termino del servicio:   <input type="text" id="termino" name="termino" value="<?=$duracion?>" disabled></span>   
    <br>
	<span>Total a pagar:   <input type="text" name="monto" value="<?=$monto?>" disabled></span>    
</form>
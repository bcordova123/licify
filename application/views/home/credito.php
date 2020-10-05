<?php

	$query = $this->db->query('select uuid() as "uuid"');
    $result=$query->row_array();
    $uuid = $result["uuid"];

?>
<form id="kushki-pay-form" action="<?=base_url()."home/kushki_post"?>" method="post">
    <input type="hidden" name="cart_id" value="<?=$uuid?>">
	<h3>Subscripción</h3>
	<input type="checkbox" name="meses" value="monthly"checked>Mensual
	<input type="checkbox" name="meses" value="quarterly">Trimestral (-10%)
	
</form>
<!--
	onsubmit="event.preventDefault(); filtro2();
	action="<?=base_url()."home/kushki_post"?>"
<div class="form-row">
	<div class="form-holder form-holder-2">
		<label class="form-row-inner">
			<input type="text" name="nombre" id="nombre" class="form-control" required>
			<span class="label">Nombre del titular(*)</span>
			<span class="border"></span>
		</label>
	</div>
</div>	
<div class="form-row">
	<div class="form-holder ">
		<label class="form-row-inner">
			<input type="text" name="tarjeta" id="tarjeta" class="form-control" required digit>
			<span class="label">Número de Tarjeta(*)</span>
			<span class="border"></span>
		</label>
    </div>
    <div class="form-holder">
		<label class="form-row-inner">
			<input type="text" name="cvv" id="cvv" class="form-control" required digit>
			<span class="label">CVV(*)</span>
			<span class="border"></span>
		</label>
	</div>
</div>
<div class="form-row form-row-date form-row-date-1">
	<div class="form-holder form-holder-2">
		<label for="date" class="special-label">Fecha Expiración(*)</label>
		<select name="month_1" id="month_1">
			<option value="Mes" disabled selected>Mes</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
			<option value="10">Octubre</option>
			<option value="11">Noviembre</option>
			<option value="12">Diciembre</option>
		</select>
		<select name="year_1" id="year_1">
			<option value="Año" disabled selected>Año</option>
			<option value="2018">2018</option>
			<option value="2019">2019</option>
			<option value="2020">2020</option>
			<option value="2021">2021</option>
            <option value="2022">2022</option>
			<option value="2023">2023</option>
			<option value="2024">2024</option>
			<option value="2025">2025</option>
			<option value="2026">2026</option>
			<option value="2027">2027</option>
			<option value="2028">2028</option>
			<option value="2029">2029</option>

		</select>
	</div>
</div>-->


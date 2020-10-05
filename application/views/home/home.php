<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css_wizard/roboto-font.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- datepicker -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css_wizard/jquery-ui.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css_wizard/style.css"/>
    <link href="<?=base_url()?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
<!--START CONTENT-->
	<div class="page-content" style="background-image: url('<?=base_url()?>assets/images/wizard-v3.jpg')">
		<div class="wizard-v3-content ">
			<div class="wizard-form">
				<div class="wizard-header">
                    <h3 class="heading">Creación de busqueda</h3>
                    <!--Agregar un remove class para el segundo div del ribbon, con un script que maneje si es prueba o de pago-->
                        <div class="ribbon-wrapper ribbon-xl">
                            <div class="ribbon bg-secondary">
                              Prueba Gratis
                            </div>
                        </div>
				</div>
		        <div class="form-register">
		        	<div id="form-total">
		        		<!-- SECTION 1 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-account"></i></span>
                            <span class="step-text">Cliente</span>                            
                        </h2>
                        
			            <section>
			                <div class="inner">
                                <h3>1°: Crea tu cliente</h3>
                                <br>
			                	<div class="form-row">
									<div class="form-holder form-holder-2">
										<label class="form-row-inner">
                                        <?php 
                                            if (isset($nombre_cliente)):
                                        ?>
											<input type="text" name="nombre" id="nombre" class="form-control" value="<?=$nombre_cliente['nombre']?>" required>
                                        <?php else: ?>
                                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                                        <?php endif;?>
											<span class="label">Nombre</span>
					  						<span class="border"></span>
                                        </label>
                                        
                                    </div>  
                                    <input type="radio" name="meses" value="monthly"checked>Mensual 
	                                <input type="radio" name="meses" value="quarterly">Trimestral (-10%)                                  
								</div>
							</div>
			            </section>
						<!-- SECTION 2 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-lock"></i></span>
                            <span class="step-text">Busquedas</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<h3>2°: Crea tu busqueda</h3>
			                	<div class="row">                 
                    <div class="col-lg-8 offset-md-2">
                    
                        <form method="post" onsubmit="event.preventDefault(); filtro2();">                          
                            <div class="input-group"> 
                            <h4>Ingresa tus Filtros</h4>                           
                                <select id="selectTags" class="form-control" multiple="multiple" style="width:80%;">                                 
                                </select>
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Buscar!</button>
                              </span>
                            </div>
                            <div class="col-lg-12">
                            <span>Selecciona los tipos deseados:</span>
                        <?php 
                        if (isset($tipos_cliente)):
                            foreach ($tipos as $key => $value):
                                $exist = false;     
                                foreach ($tipos_cliente as $tipasos){
                                    if($value['tipo'] == $tipasos){
                                        $exist = true;
                                    }                                              
                                }
                            if (!$exist):
                            ?>
                            <input class="tipos" type="checkbox" name="tipos[]" id="tipos" value="<?=$value['tipo']?>"><?=$value['tipo']?>
                                    <?php else: ?>
                            <input class="tipos" type="checkbox" name="tipos[]" id="tipos" value="<?=$value['tipo']?>"checked><?=$value['tipo']?>
                            <?php endif; endforeach; else: ?>
                            <?php 
                                foreach ($tipos as $key => $value):                            
                            ?>
                                <input class="tipos" type="checkbox" name="tipos[]" value="<?=$value['tipo']?>"checked><?=$value['tipo']?>
                        <?php endforeach; endif;?>
                            </div>                            
                        </form>
                    </div>
                </div>
                <br>
                    <div class="row">
                        <div class="col-md-4 offset-md-1">
                            <select name="select1" id="search" class="form-control" style="height: 100%" multiple="multiple">
                            </select>
                        </div>
                        
                        <div class="col-md-2" style="margin-top: 20%">
                            <button type="button" id="search_rightAll" class="btn btn-block"><i class="fas fa-angle-double-right"></i></button>
                            <button type="button" id="search_rightSelected" class="btn btn-block"><i class="fas fa-angle-right"></i></button>
                            <button type="button" id="search_leftSelected" class="btn btn-block"><i class="fas fa-angle-left"></i></button>
                            <button type="button" id="search_leftAll" class="btn btn-block"><i class="fas fa-angle-double-left"></i></button>
                        </div>                            
                        <div class="select3 col-md-4">
                            <select name="to" id="search_to" class="form-control" style="height: 100%" multiple="multiple">
                            <?php 
                                if (isset($filtros)):
                                foreach ($filtros as $value):
                                    $uuid_cliente = $value['cliente_uuid'];                                                            
                                ?>
                                    <option value="<?=$value['segmento_cod']?>"><?=$value['termino']?></option>                                    
                                <?php endforeach; endif;?>
                            </select>
                        </div>                                                                     
                    </div>
							</div>
			            </section>
			            <!-- SECTION 3 -->
			            <h2>
			            	<span class="step-icon"><i class="zmdi zmdi-card"></i></span>
                            <span class="step-text">Pago</span>
                            <input type="hidden" name="total" id="total" value="">
			            </h2>
			            <section>
			                <div class="inner">
                            
                                <!-- <div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<label class="pay-1-label" onclick="cargar_pago(1)"><img src="<?=base_url()?>assets/images/wizard_v3_icon_1.png" alt="pay-1">Tarjeta de Credito</label>
										<label class="pay-2-label" onclick="cargar_pago(2)"><img src="<?=base_url()?>assets/images/wizard_v3_icon_2.png" alt="pay-2">Tarjeta de Debito</label>
			                		</div>
			                	</div> -->
                                <div id="pago">                                    
                                </div>			                	
							</div>
			            </section>

		        	</div>
                </div>
			</div>        
		</div>
    </div>    
    <script src="<?=base_url()?>assets/plugins/select2/js/select2.min.js"></script> 
	<script src="<?=base_url()?>assets/js/jquery.steps.js"></script>
    <script src="<?=base_url()?>assets/js/main.js"></script>       
    <script>   
         $(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '1000',
				'hideDuration': '1000',
				'timeOut': '5000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		}); 
        function filtro2(){
            var cadena = $('#selectTags').val();
            var categorias = new Array();
            var select_to = $('#search_to option').attr('selected', 'selected');            
            //var seleccionados = $('#search_to').text();
            $.each(select_to, function( index, select ) {
                //console.log(select.value,select.text);
                categorias.push(select.value+"-"+select.text);
            });
            $('#search').empty();
            
            $.ajax({
                url: "<?=base_url('planes/filtrar_multi_select')?>",
                type: "POST",
                async: true,
                data: {"filtros":cadena,"categorias":categorias},
                success: function(respuesta) {
                    var resultado = new Array();
                    $.each(respuesta, function(key,value){
                        if(value != null){
                        value.forEach(function(element) {                                         
                            //hacemos el split para obtener el nombre de la categoria a mostrar y la subimos a un array con su respectivo codigo
                            var texto = element.nombre.split('/');
                            //Pusheamos los datos, el texto va a delante del codigo para poder ordenar el arreglo alfabeticamente
                            resultado.push(texto[2]+"-"+element.codigo);
                        });    
                        }                
                    });
                    resultado.sort();
                    resultado.forEach(function(result){
                        //Multi select izquierdo
                        var multi_left = document.getElementById("search");
                        //Ahora para crear el objeto option que le vas a añadir seria
                        var option = document.createElement("option");
                        //separamos el codigo de categoria con el nombre de la categoria para poder setearles los datos al objeto option
                        var texto = result.split('-');
                        //valor del objeto option
                        option.value = texto[1];
                        //Nombre del objeto option
                        option.text = texto[0];
                        //Adjuntamos todo lo seteado a el multi select que obtuvimos
                        multi_left.append(option); 
                    });
                    //window.location.reload(); 
                    //$('#client_data').DataTable().ajax.reload();
                    
                },
                error: function() {
                  console.log("No se ha podido obtener la información");
                }
            });
            //console.log(arregloDeSubCadenas); // la consola devolverá: ["cadena", "de", "texto"]
        }
        jQuery(document).ready(function($) {
            $("#selectTags").select2({
            tags: true,
            tokenSeparators: [',', ' ']
            });
            $('#search').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Buscar..." autocomplete="off"/>',
                    right: '<input type="text" name="q" class="form-control" placeholder="Buscar..." autocomplete="off"/>',
                },
                fireSearch: function(value) {
                    return value.length > 1;
                }
            });
            $("#form-total-t-2").attr('onclick', 'set_precio()');                   
        });  
        function set_precio(){
        var nombre = $('#nombre').val();
        var meses = $('input:radio[name=meses]:checked').val();
        //var total = $('#total').val();
        var categorias = new Array();
        var select_to = $('#search_to option').attr('selected', 'selected');            
        //var seleccionados = $('#search_to').text();
        $.each(select_to, function( index, select ) {
            //console.log(select.value,select.text);
            categorias.push(select.value+"-"+select.text);
        });
        var selectedItems = new Array();		
            $(".tipos:checked").each(function(){
			selectedItems.push($(this).val());
		    });  
            $.ajax({
                url: "http://190.196.222.45/licify/home/generar_busqueda",
                type: "POST",
                data: {"nombre":nombre,"categorias":categorias,"tipos":selectedItems},
                success: function(respuesta) {
                    $.ajax({                                
                        url: "http://190.196.222.45/licify/home/cargarpago",
                        type: "POST",
                        //data: {"valor":1},
                        data: {"meses":meses},
                        dataType: 'json',
                        success: function(data) {
                            total = data.total;
                            $("#pago").html(data.template);
                        },
                        error: function() {
                          console.log("No se ha podido obtener la información");
                        }
                    });                             
                },
                error: function() {
                  console.log("No se ha podido obtener la información");
                }
            });
        }
        function cargar_pago(valor){                
            $.ajax({
            url: "<?=base_url('home/cargarpago')?>",
            type: "POST",
            data: {"valor":valor},
            dataType: 'json',
            success: function(respuesta) {
                total = respuesta.total;
                $("#pago").html(respuesta.template);
                if (respuesta.valor == 1) {
                    var kushki = new KushkiCheckout({
                form: "kushki-pay-form",
                merchant_id: "20000000107509727000",
                amount: total,
                currency: "CLP",
      	        payment_methods:["credit-card"], // Payments Methods enabled
                is_subscription: true, // Optional
      	        inTestEnvironment: true, 
      	        regional:false // Optional
                });
                }else if (respuesta.valor == 2) {
                    var kushki = new KushkiCheckout({
                    form: "kushki-pay-form",
                    merchant_id: "20000000107509727000",
                    amount: "1.14",
                    currency: "CLP",
                  	payment_methods:["cash"] , // Payments Methods enabled
                  	inTestEnvironment: true
                });
                }
                
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        }); 
        }
        function pagando(){
            $.ajax({
            url: "<?=base_url('home/kushki_post')?>",
            type: "POST",
            success: function(respuesta) {
                console.log(respuesta);
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        });
        }

</script>
</body>
</html>    
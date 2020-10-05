<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mercado Planes</title>
    <?php
    $this->load->view('comun/css');
    ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
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
                    <div class="col-lg-8 offset-md-2">
                        <h2>Ingresa tus Filtros</h2>
                        <form method="post" onsubmit="event.preventDefault(); filtro2();">
                            <div class="input-group">
                                <select id="selectTags" class="form-control" multiple="multiple"> 
                                </select>
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Buscar!</button>
                              </span>
                            </div>
                            <div>
                            <span>Selecciona los tipos de licitaciones deseadas</span>
                            <?php 
                                foreach ($tipos as $key => $value):                            
                            ?>
                                <input class="tipos" type="checkbox" name="tipos[]" id="tipos" value="<?=$value['tipo']?>"checked><?=$value['tipo']?>
                                <?php endforeach;?>
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
                            <select name="to" id="search_to" class="form-control" style="height: 100%" multiple="multiple"></select>
                        </div>                        
                        <button type="button" class="btn btn-primary col-md-2 offset-md-5" style="margin-top: 5%" onclick="crear_filtros();">Enviar</button>
                        
                    </div>
            </div>
            <!--END CONTENT-->
        </div>

        <?php 
        $this->load->view('comun/footer');
        $this->load->view('comun/js');
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
        
        <script>
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
        });

        function crear_filtros(){ 
            var selectedItems = new Array();		
            $(".tipos:checked").each(function(){
			selectedItems.push($(this).val());
		    });           
            //var tipos = $('.tipos').attr('checked');
            var categorias = new Array();
            var select_to = $('#search_to option').attr('selected', 'selected');            
            //var seleccionados = $('#search_to').text();
            $.each(select_to, function( index, select ) {
                //console.log(select.value,select.text);
                categorias.push(select.value+"-"+select.text);
            });

            $.ajax({
                url: "<?=base_url('clientes/add_filter')?>",
                type: "POST",
                data: {"categorias":categorias,"tipos":selectedItems},
                success: function(data) {
            if (data.status) {
             $.notify({
                            // options
                            title: 'Correcto, ',
                            message: data.reason
                        },{
                            // settings
                            type: 'success',
                            hideDuration: 7,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                            
                        });
         } else if (!data.status) { 
            $.notify({
                                // options
                                title: 'Advertencia, ',
                                message: data.reason
                            },{
                                // settings
                                type: 'warning',
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },
                                
                            });

        } else {
            $.notify({
                                // options
                                title: 'Error, ',
                                message: 'Error desconocido' 
                            },{
                                // settings
                                type: 'danger',
                                animate: {
                                    enter: 'animated fadeInDown',
                                    exit: 'animated fadeOutUp'
                                },
                                
                            });
        }    
                },
                error: function() {
                      console.log("No se ha podido obtener la información 12312312");
                  }
            });
            //console.log(categorias);
            //console.log(hola);
        }    
        </script>
        
    </body>
    </html>
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
                    <div class="col-md-12">
                        <h1 class="float-left"><?=$page_name?></h1>

                    </div>
                    <div class="col-md-12"><hr></div>
                    <div class="container-fluid">
                    <?php //print_r($moleculas);?>
                        <form method="POST" action="<?=base_url()?>planes/crear_plan">
                            <div class="form-group">
                                <h3>Seleccione Cliente</h3>
                                <select name="cliente" class="form-control">

                                    <?php
                                    
                                    foreach ($clientes as $clave) {
                                        echo "<option value='".$clave["uuid"]."'>";
                                        echo $clave["nombre"];
                                        echo "</option>";
                                    }

                                    ?>

                                </select>

                            </div>

                            <br/>

                            <h3>Seleccione categorias</h3>
                            <input class='tags' id="tags" name="tags"  />

                            <br/>

                            <button id="btnCrear" class="btn btn-success"  type="submit" >Crear un Plan</button>
                            <!-- onclick="crearPlan()" -->
                        </form>
                    </div>
                </div>
            </div>
            <!--END CONTENT-->

        </div>

        <?php 
        $this->load->view('comun/footer');
        $this->load->view('comun/js');
        ?>

        <script>

            var myTrueTags = [];

            $(document).ready(function() {

                var myArray = <?php print(json_encode($categorias)); ?>;

                $.each(myArray, function(index, objeto) {
                    myTrueTags.push(objeto.Items_CodigoCategoria + " | " + objeto.Items_Categoria);
                });

                var myTaggeable = $('[name=tags]').tagify({

                    // [regex] split tags by any of these delimiters ("null" to cancel)
                    delimiters: ",", 

                    // regex pattern to vali<a href="https://www.jqueryscript.net/time-clock/">date</a> input by. 
                    pattern: null, 

                    // maximum number of tags
                    maxTags: Infinity, 

                    // exposed callbacks object to be triggered on certain events
                    callbacks: {}, 

                    // automatically adds the text which was inputed as a tag when blur event happens
                    addTagOnBlur: false, 

                    // allow tuplicate tags
                    duplicates: false, 

                    // is this list has any items, then only allow tags from this list
                    whitelist: myTrueTags, 

                    // a list of non-allowed tags
                    blacklist: [],

                    // should ONLY use tags allowed in whitelist
                    enforceWhitelist: false, 

                    // tries to autocomplete the input's value while typing
                    autoComplete: true, 

                    dropdown: {
                        classname: '',
                        enabled: 0, // minimum input characters needs to be typed for the dropdown to show
                        maxItems: 100
                    }

                }).on('add', function(e, tagName){
                 //   console.log();
                 // $('[name=tags]').data('tagify')
             })
                .on('remove', function(e, tagName){
                          // on remove
                      })
                .on('duplicate', function(e, tagName){
                      // on duplicate
                  })
                .on('maxTagsExceed', function(e){
                      // on maxTagsExceed
                  })
                .on('blacklisted', function(e, tagName){
                      // on blacklisted
                  })
                .on('notWhitelisted', function(e, tagName){
                      // on notWhitelisted
                  });;

            });

        </script>
    </body>
    </html>
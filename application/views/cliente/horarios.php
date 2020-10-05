

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$page_name?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-8">
            <div class="info-box col-sm-6 ">
                <form action="" onsubmit="event.preventDefault(); crear_horario();" method="post">                                       		               
                            <label class="success">Fija tu Horario para recibir correos en estas horas (*)</label>		                	
                            <center>
                                <?php 
                                if (isset($cada_hora)):
                                    $cantidad_horas = count($cada_hora);                                    
                                    foreach ($cada_hora as $value):                                                                
                                ?>
                                <input class="horas" type="time" name="hora[]" value="<?=$value?>" step="1800">                                 
                                <?php endforeach;endif;
                                switch ($cantidad_horas) {
                                    case $cantidad = 1:
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        break;

                                    case $cantidad = 2:
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        break;
                                    case $cantidad = 3:
                                        echo '<input class="horas" type="time" name="hora[]" value="" step="1800">';
                                        break;                                    
                                }                                                                
                                ?> 
                               </center>
                           <br>                                                 
                        <button class="btn btn-primary col-md-12" type="submit">Guardar!</button>  
                                          
                </form>                       
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <script >   
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
    function crear_horario(){   
        //console.log("hola");     
        var selectedDias = new Array();		
            $(".dias:checked").each(function(){
            selectedDias.push($(this).val());
            }); 
        var selectedHoras = new Array();		
            $(".horas").each(function(){
                if($(this).val() != ""){
                selectedHoras.push($(this).val());
                }
            });
        $.ajax({
            url: "<?=base_url('clientes/horario')?>",
            type: "POST",
            data: {"dias":selectedDias,"horas":selectedHoras},
            success: function(data) {
                if (data.status) {                   
		            toastr.success(data.reason);		            
                  /*   $.notify({
                                   // options
                                   title: 'Correcto, ',
                                   message: data.reason
                               },{
                                   // settings
                                   type: 'success',
                                   hideDuration: 3,
                                   animate: {
                                       enter: 'animated fadeInDown',
                                       exit: 'animated fadeOutUp'
                                   },

                               }); */
                } else if (!data.status) { 
                    toastr.warning(data.reason);
                   /* $.notify({
                                       // options
                                       title: 'Advertencia, ',
                                       message: data.reason
                                   },{
                                       // settings
                                       type: 'warning',
                                        // whether to auto-hide the notification
                                        autoHide: true,
                                        // if autoHide, hide after milliseconds
                                        autoHideDelay: 500,
                                       animate: {
                                           enter: 'animated fadeInDown',
                                           exit: 'animated fadeOutUp'
                                       },

                                   }); */

                } else {
                    
                    toastr.error("Error desconocido");
                    /* $.notify({
                                        // options
                                        title: 'Error, ',
                                        message: 'Error desconocido' 
                                    },{
                                        // settings
                                        type: 'danger',
                                        hideDuration: 3,
                                        animate: {
                                            enter: 'animated fadeInDown',
                                            exit: 'animated fadeOutUp'
                                        },
                                        
                                    }); */
                } 
            },
            error: function() {
              console.log("No se ha podido obtener la información");
            }
        });       
    }  
</script>
</div>
  <!-- /.content-wrapper -->            


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    
    <style>
        @-webkit-keyframes rotating /* Safari and Chrome */ {
            from {
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
            }
            @keyframes rotating {
            from {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
            }
            .rotating {
            -webkit-animation: rotating 2s linear infinite;
            -moz-animation: rotating 2s linear infinite;
            -ms-animation: rotating 2s linear infinite;
            -o-animation: rotating 2s linear infinite;
            animation: rotating 2s linear infinite;
            }
    </style>
  </head>
  <body>
  <div class="container-fluid h-100" style="margin-top:5%;">
    <div class="row justify-content-center align-items-center h-100">
            <div class="col-sm-12 mr-auto ml-auto text-left">
                <img src="<?=base_url()?>assets/img/logo-licify.png" width="250px">
                <h3 class="text-success">Transacción aceptada</h3>
                <p>La transacción se ha procesado correctamente</p>
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
                 
                 <br><br>
                 <button class="btn btn-secondary btn-block fixed-bottom btn-lg"  onclick="volver();" style="background-color:#9145CB !important;border-radius:none !important;">Continuar</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script type='text/javascript'>
 
            function volver(){
                window.location.replace("<?=base_url()."home"?>");
            }	

			//function callFromJSToAndroid() { Android.metodoDemo1(); }	
	</script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
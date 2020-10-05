<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">    
  </head>
  <body>
  <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
            <div class="col-sm-12 text-center">
            <br>
                <img src="https://fotos.subefotos.com/9d156d0a705d368d0226d9ec5626ba46o.png" width="250px">
                <h1>Transacción rechazada</h1>
                <p>Su error puede deberse a las siguientes causas</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Anulación por parte del cliente</li>
                    <li class="list-group-item">Error en su tarjeta de pago</li>
                    <li class="list-group-item">Webpay fuera de servicio</li>
                    </ul>
                    <br><br>
                 <button class="btn btn-secondary btn-block fixed-bottom" onclick="volver();" style="background-color:#28a745 !important;">Sácame de aquí</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type='text/javascript'>
		  function volver(){
                window.location.replace("<?=base_url()."home"?>");
            }	
  	</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  </body>
</html>
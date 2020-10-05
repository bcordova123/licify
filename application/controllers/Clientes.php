<?php
class Clientes extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Usuario_Model');
    $this->load->model('Cliente_Model');
    $this->load->model('Api_Model');
  }


  public function view_add(){
    $data["page_name"]="Nuevo registro cliente";
    $this->load->view("cliente/add", $data);
  }
  public function index(){
    $uuid = $this->session->userdata('usuario')["uuid"];
    $resultado = $this->Cliente_Model->get_clientes_useruuid($uuid);
    //$data["page_name"]="Listar clientes";
    $data["datos"]=$resultado;
    //print_r($resultado);
    $this->load->view("home/busquedas", $data);

  }
  public function cargar_page_filter(){
    $data["page_name"] = "Listar filtros de clientes";
    //$data['clientes']  = $this->cargar_filtros();
    $this->load->view("cliente/filter",$data);
  }
  public function add() {
    $nombre=$this->input->post("nombre");
    $email=$this->input->post("email");
    $rut=$this->input->post("rut");
    $uuid_usu = $this->session->userdata('usuario')['uuid'];
    $query = $this->db->query('select uuid() as "uuid"');
    $result=$query->row_array();
    $uuid=$result["uuid"];
    if ($nombre != null && $nombre != "" && $rut != null && $rut != "" && $email != null && $email != "") {
          $rut_sin_puntos = str_replace('.', "", $rut); //elimino puntos
          $numerosentrada = explode("-", $rut_sin_puntos); //separo rut de dv
          $verificador = $numerosentrada[1]; //asigno valor de dv
          $numeros = strrev($numerosentrada[0]);  //separo rut de dv
          $count = strlen($numeros); //asigno la longitud del string en este caso 8
          $count = $count -1; //resto uno al contador para comenzar mi ciclo ya que las posiciones empiezan de 0
          $suma = 0;
          $recorreString = 0;
          $multiplo = 2;
          for ($i = 0; $i <= $count ; $i++) {   //inicio ciclo hasta la posicion 7
              $resultadoM = $numeros[$recorreString]*$multiplo; // recorro string y multiplico 
              $suma = $suma + $resultadoM; // se suma resultado de multiplicacion por ciclo
              if ($multiplo == 7) { 
                $multiplo = 2;
              }else{
                $multiplo++;
                }              
              $recorreString++;
          }
            $resto = $suma%11;
            $dv = 11 - $resto;
            if ($dv == 11) {
              $dv = 0;
            }
            if ($dv == 10) {
              $dv = "K";
              $dv2 = "k";
            }
            if ($verificador == $dv || $verificador == $dv2) {
              $insert = array(
              'uuid' => $uuid,
              'nombre' => $nombre,
              'email' => $email,
              'rut' => $rut,
              'usu_uuid' => $uuid_usu,
              'status' => 1
              );
              $this->Cliente_Model->add($insert);
              $response = ["status" => true, "reason" => "Cliente creado exitosamente!"];
              header('Content-Type: application/json'); 
              echo json_encode($response);
            }else {
                //$this->session->set_flashdata('mensaje_rut_invalido',"Invalido");
                //$this->session->set_flashdata('mensaje_error',"No se actualizaron datos");
                $response = ["status" => false, "reason" => "Rut Inválido"];
              }
    }else{
      $response = ["status" => false, "reason" => "Datos incorrectos!"];
      header('Content-Type: application/json'); 
      echo json_encode($response);
      }
  }
  public function delete(){

  }


  public function fetch_client() {  
    perfil_superior();
    $uuid = $this->session->userdata('usuario')["uuid"];
    $fetch_data = $this->Cliente_Model->make_datatables($uuid);  
    $data = array();
    /*
    if ($uuid_cliente==null) {
        redirect('clientes/','refresh');
    }
    
    $data["page_name"] = "Modificar cliente";

    $data["cliente"] = $this->Cliente_Model->get_cliente_byuuid($uuid_cliente);

    if ($data["cliente"] == null) {
        redirect('clientes/','refresh');
      }*/

      foreach($fetch_data as $row)  
      {  
       $sub_array = array();  
       $sub_array[] = $row->nombre;
       if ($row->status==1) {
        $sub_array[] = '<span class="text-success">Activo</span>';
      }else{
        $sub_array[] = '<span class="text-danger">Desactivado</span>';
      }                


      $sub_array[] = "<button class='btn btn-warning' onclick='cargarmodal(\"".$row->UUID."\")' >
      <i class='fas fa-pencil-alt'></i></button>";  

         //$sub_array[] = '<a href="'.base_url().'clientes/view_modificar/'.$row->UUID.'" class="btn btn-warning">Ver</a>';  

      if ($row->status == 1) {
           # code...

        $sub_array[] = "<button class='btn btn-danger' onclick='desactivar_cliente(\"".$row->UUID."\")' >
        <i class='fas fa-toggle-off'></i></button>";
         //$sub_array[] = '<a href="'.base_url().'clientes/bajar_cliente/'.$row->UUID.'" class="btn btn-danger"><i class="fas fa-toggle-off"></i></a>';  
      }
      if ($row->status == 0) {
           # code...
        $sub_array[] = "<button class='btn btn-success' onclick='activar_cliente(\"".$row->UUID."\")' >
        <i class='fas fa-toggle-on'></i></button>";  
         //$sub_array[] = '<a href="'.base_url().'clientes/subir_cliente/'.$row->UUID.'" class="btn btn-success"><i class="fas fa-toggle-on"></i></a>';  
      }
      if ($row->status == 2) {
        # code...
     $sub_array[] = "No pagado";  
      //$sub_array[] = '<a href="'.base_url().'clientes/subir_cliente/'.$row->UUID.'" class="btn btn-success"><i class="fas fa-toggle-on"></i></a>';  
   }

      $data[] = $sub_array;  
    }  
    $output = array(  
     "draw"         =>     intval($_POST["draw"]),  
     "recordsTotal"      =>      $this->Cliente_Model->get_all_data($uuid),  
     "recordsFiltered"     =>     $this->Cliente_Model->get_filtered_data($uuid),  
     "data"   =>     $data  
   );  
  //  var_dump($output);
  //  die();
    //echo $this->db->last_query(); die();
    echo json_encode($output);  
  }  
        //Function Bryan
          public function filter(){
        //$data['uuid_cliente'] = $uuid_cliente;

            $data['page_name'] = "Generar Filtro";
        //$data['segmentos'] = $this->Api_Model->get_segmentos();
        //$data['tipos'] = $this->Api_Model->get_tipo();

            //Fechas faltantes de las licitaciones
            $fecha = date('2014-01-01');
            $fecha2 = date('Y-m-d');
            $licitaciones = $this->Api_Model->licitaciones_aldia($fecha,$fecha2);
            $fechasfaltantes = array();
            $fechastotales = array();

            foreach ($licitaciones as $key => $licitacion) {
              array_push($fechastotales, $licitacion['Fechas']);
            }
            
            $exist = false;
            for ($i=1; $i <= 2071 ; $i++) {
              $exist = false;
              foreach ($fechastotales as $key => $f) {
                if ($f==$fecha) {
                  $exist = true;
                }       
              }
              if (!$exist) {
                array_push($fechasfaltantes, $fecha);
              }

              $fecha = date("Y-m-d",strtotime($fecha."+1 days")); 

            }
            $data['fechas'] = $fechasfaltantes;
            $this->load->view('cliente/licitacionesfaltantes',$data);
          }

          
          public function add_plan(){
            $uuid_usu = $this->session->userdata('usuario')['uuid'];
            $segmento = $this->input->post('segmento');
            $insert = array(
              'usu_uuid' => $uuid_usu,
              'segmento_cod' => $segmento
            );
            $this->Api_Model->add_plan($insert);
        //redirect('Clientes/index');
            redirect("clientes","refresh");
          }
          public function add_plan2(){
            $uuid_usu = $this->session->userdata('usuario')['uuid'];
            $aux_plan = $this
            ->input
            ->post('segmento');

            $tags = json_decode($aux_plan, true);

            if (count($tags) < 1)
            {
              $this
              ->session
              ->set_flashdata("error", "Sin planes a registrar");
            }
            else
            {

            // DELETE FIRST BEFORE ADD
              $isDeleted = $this
              ->db
              ->query('delete from PLAN where usu_uuid = "' . $uuid_usu . '"');

              if ($isDeleted)
              {
                foreach ($tags as $value)
                {

                  $idSegmento = trim(explode('|', $value['value']) [0]);

                  $nuevoPlan['usu_uuid'] = $uuid_usu;
                  $nuevoPlan['segmento_cod'] = $idSegmento;

                  $t = $this->Api_Model->add_plan($nuevoPlan);
                }

                $this
                ->session
                ->set_flashdata("exito", "Plan creado exitosamente");

              }
              else
              {
                $this
                ->session
                ->set_flashdata("error", "Error inesperado");
              }
            }

            redirect("clientes", "refresh");
          }

          public function select_cliente(){
            $uuid = $this->session->userdata('usuario')["uuid"];
            $datos['clientes'] = $this->Cliente_Model->get_clientes_useruuid($uuid);
            echo (json_encode($datos));
          }
          public function bajar_cliente(){
            $uuid_cliente = $this->input->post('uuid_cliente');
            $status = array(
              'status' => 0
            );
            $this->Cliente_Model->update($uuid_cliente,$status);          
          }
          public function subir_cliente(){
            $uuid_cliente = $this->input->post('uuid_cliente');
            $status = array(
              'status' => 1
            );
            $this->Cliente_Model->update($uuid_cliente,$status);          
          }
          public function action(){
            $response = [];
            $uuid_cliente = $this->input->post('uuid_cliente');

            if ($uuid_cliente != null && $uuid_cliente != "") {
              $this->session->set_userdata('cliente',$uuid_cliente);
              $response=["status" => "UUID GUARDADA"];
            }else{
              $response=["status" => "No se ha podido obtener la información"];
            }
            echo json_encode($response);

          }
          public function view_modificar(){
            is_login();

            $uuid = $this->input->post('uuid_cliente');

            if ($uuid == null) {
              redirect('clientes/','refresh');
            }          

            $data["cliente"] = $this->Cliente_Model->get_cliente_byuuid($uuid);

            if ($data["cliente"] == null) {
              redirect('clientes/','refresh');
            }
            echo json_encode($data);
          }
          public function edit(){
            is_login();
            $uuid = $this->input->post('uuid_cliente');
            $nombre = $this->input->post('nombre');
            $rut = $this->input->post('rut');    //recibo rut    
            $email = $this->input->post('email');
            $resultado = $this->Cliente_Model->verify_email_update($email,$uuid);
            $resultado2 = $this->Cliente_Model->verify_rut_update($rut,$uuid);
            if ($resultado != null) {   
              $response = ["status" => false, "reason" => "El Correo ingresado ya existe"];
              header('Content-Type: application/json'); 
              echo json_encode($response);
              die();
            }elseif ($resultado2 != null) {
              $response = ["status" => false, "reason" => "El Rut ingresado ya existe"];
              header('Content-Type: application/json'); 
              echo json_encode($response);
              die();
            }else{
                $response = ["status" => true];  
              }
            $rut_sin_puntos = str_replace('.', "", $rut); //elimino puntos
            $numerosentrada = explode("-", $rut_sin_puntos); //separo rut de dv
            $verificador = $numerosentrada[1]; //asigno valor de dv
            $numeros = strrev($numerosentrada[0]);  //separo rut de dv
            if (is_numeric($numerosentrada[0])) {
              $response = ["status" => true]; 
            }else{
                $response = ["status" => false, "reason" => "El rut no es Valido"];
                header('Content-Type: application/json'); 
                echo json_encode($response);
                die();
              }
            $count = strlen($numeros); //asigno la longitud del string en este caso 8
            $count = $count -1; //resto uno al contador para comenzar mi ciclo ya que las posiciones empiezan de 0
            $suma = 0;
            $recorreString = 0;
            $multiplo = 2;
            for ($i = 0; $i <= $count ; $i++) {   //inicio ciclo hasta la posicion 7
                $resultadoM = $numeros[$recorreString]*$multiplo; // recorro string y multiplico 
                $suma = $suma + $resultadoM; // se suma resultado de multiplicacion por ciclo
                if ($multiplo == 7) { 
                  $multiplo = 2;
                }else{
                  $multiplo++;
                }                
                $recorreString++;
            }
              $resto = $suma%11;
              $dv = 11 - $resto;
              if ($dv == 11){
                $dv = 0;
              }if ($dv == 10){
                  $dv = "k";
                  $dv2 = "K";                  
                }if ($verificador == $dv || $verificador == $dv2){
                    $cliente = [
                      "nombre" => $nombre,
                      "rut" => $rut,
                      "email" => $email,
                    //"fecha_modificacion" => date('Y-m-d H:i:s')      
                    ];
                    $this->Cliente_Model->update($uuid,$cliente);    
                    //$this->session->set_flashdata('mensaje_rut_valido',"Valido");
                    //$this->session->set_flashdata('mensaje_exito',"Usuario actualizado");
                    $response = ["status" => true];  
                  }else {
                      //$this->session->set_flashdata('mensaje_rut_invalido',"Invalido");
                      //$this->session->set_flashdata('mensaje_error',"No se actualizaron datos");
                      $response = ["status" => false, "reason" => "Rut Inválido"];  
                    }
            header('Content-Type: application/json'); 
            echo json_encode($response);
            //redirect('clientes/view_modificar/'.$uuid,'refresh');
            }

            public function listar_clientes(){
              $login = $this->session->userdata('login');
              if (isset($login)) {      
                $lista['page_name'] = "Listar Clientes";      
                $uuid = $this->session->userdata('usuario')['uuid'];
                $lista['clientes'] = $this->Cliente_Model->clientes_usuario($uuid);
                $this->load->view("cliente/list", $lista);
            //echo json_encode($lista);
              }else{
                show_404();
              }
            }

          public function ordenes(){
            //$data['uuid_cliente'] = $uuid_cliente;
            $data['page_name'] = "Ver orden";
            //$data['segmentos'] = $this->Api_Model->get_segmentos();
            //$data['tipos'] = $this->Api_Model->get_tipo();
            //Fechas faltantes de las licitaciones
            $fecha = date('2014-01-01');
            $fecha2 = date('Y-m-d');
            $licitaciones = $this->Api_Model->ordenes_aldia($fecha,$fecha2);
            $fechasfaltantes = array();
            $fechastotales = array();
            foreach ($licitaciones as $key => $licitacion) {
              array_push($fechastotales, $licitacion['Fechas']);
            }
            $exist = false;
            for ($i=1; $i <= 2071 ; $i++) {
              $exist = false;
              foreach ($fechastotales as $key => $f) {
                if ($f==$fecha) {
                  $exist = true;
                }       
              }
              if (!$exist) {
                array_push($fechasfaltantes, $fecha);
              }
              $fecha = date("Y-m-d",strtotime($fecha."+1 days")); 
            }
            $data['fechas'] = $fechasfaltantes;
            $this->load->view('cliente/licitacionesfaltantes',$data);
          }
        public function find_licitaciones(){

             $fecha = date('Y-m-d H:i:s');
             //$uuid_usu = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
             $uuid_usu = $this->session->userdata('usuario')["uuid"];
             $respuesta = $this->Api_Model->find_licitaciones($fecha);
             $items = $this->Api_Model->find_licitacion2($uuid_usu,$fecha);
             $notificacion = $this->Api_Model->verify_notificacion($uuid_usu);       
             $licitacion = array();
             $licitacionitems = array();
             //Recorremos la respuesta para obtener los codigos de todas las licitaciones
             foreach ($respuesta as $key => $value) {
               
               $codigoexterno = $value["CodigoExterno"];
               $licitacionitems = array();
               //Recorremos la otra consulta para obtener los todos los items 
               foreach ($items as $key => $value2) {
      
                 $idlicitacion = $value2["LicitacionID"];
                 //solo si los codigos son iguales, se suben a un arreglo para insertarlo, en el arreglo final con todos los datos
                 if ($idlicitacion == $codigoexterno) {              
                     
                   $item = array(
                     'IdLicitacion' => $value2['LicitacionID'],
                     'Categoria' => $value2['CodigoCategoria'],
                     'Descripcion_item' => $value2['Descripcion_Item']
                   );
                   array_push($licitacionitems, $item);
      
                 }
      
               }
               //solo si la licitacion tiene items se podran cargar al arreglo final
               if ($licitacionitems != null) {
               //Cremos el objeto, le pasamos los datos y lo subimos al arreglo
               $licitacionfinal = [
                 'CodigoExterno' => $value['CodigoExterno'],
                 'Nombre' => $value['Nombre'],
                 'Estado' => $value['Estado'],
                 'Fechas_FechaCreacion' => $value['Fechas_FechaCreacion'],
                 'Fechas_FechaCierre' => $value['Fechas_FechaCierre'],
                 'Comprador_RegionUnidad' => $value['Comprador_RegionUnidad'],
                 'montoestimado' => $value['montoestimado'],
                 'Items' => $licitacionitems
               ];
               //subimos al arreglo todos los datos que contiene el objeto
               array_push($licitacion, $licitacionfinal);
               //Agregamos los codigos que nos sirven en la tabla notifacion con el uuid de quien hizo el filtro
      
               }
      
             }
             //Notificacion
             $aux="";
              $aux2="";
              //Declaramos un booleano
              $exist = false;
              
             foreach ($licitacion as $key => $licita){
      
               $codigo = $licita['CodigoExterno'];
      
               if ($notificacion!=null) {
                 $aux="primer if";
                 foreach ($notificacion as $key => $n) {
                     if ($n["CodigoExterno"]==$codigo) {
                       $aux2 = $aux2.$n["CodigoExterno"]."%";
                       //si encuentra coincidencia manda verdadero el booleano para que no agrege el codigo si ya existe
                       $exist = true;
                     }          
                 }
                 //Si no existe el codigo, lo inserta.
                 if (!$exist) {
                   $notificar = array(
                       'usu_uuid' => $uuid_usu,
                       'CodigoExterno' => $codigo
                     );
                     $this->Api_Model->add_notificacion($notificar);
                 }
      
               }else {
                 $aux2="primer else";
                 $notificar = array(
                       'usu_uuid' => $uuid_usu,
                       'CodigoExterno' => $codigo
                     );
                     $this->Api_Model->add_notificacion($notificar);
               }          
             }
      
               $response = ["licitaciones" => $licitacion];  
               header('Content-Type: application/json'); 
               //echo json_encode($response);
               echo json_encode($response);
      
            }

        public function send_mail(){

            $data = $this->input->post('respuesta');
            $datos = json_decode($data,true);
            $correos = "";
            $correos.='dosorio@saargo.com';
            $para=$correos;
            $this->load->library('email');
      
            $config = array(
                       'protocol'  => 'smtp',
                       'smtp_host' => 'ssl://smtp.googlemail.com',
                       'smtp_port' => 465,
                       'smtp_user' => 'igneexd@gmail.com',
                       'smtp_pass' => 'google42302506',
                       'mailtype'  => 'html',
                       'charset'   => 'utf-8'
                   );
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
    
            //$data['datos'] = json_decode($this->find_licitaciones());    
    
            $html = '';
            $html .= "<style type=text/css>";
            $html .= "th{color: #000000; font-weight: bold; background-color: #FFFFFF;text-align:center}";
            $html .= "td{background-color: #FFFFFF; color: #000000; border: black 5px solid; text-align:center}";
            $html .= "</style>";
            $html .= "<table width='50%' border='10'>";
            
            $CodigoExterno = "";
            $Nombre = "";
            $Estado = "";
            $Tipo = "";
            $Region = "";
            $Monto = "";
            $Comprador = "";
            $Cierre = "";
            $Link = "";   
            $n=0;
            /*
            // Licitaciones con sus respectivos items !!!!
            foreach ($datos['licitaciones'] as $value) 
                {
                  $html .= "<tr>
                      <th>CodigoExterno</th>
                      <th>Descripción</th>
                      <th>Estado</th>                      
                      </tr>";
                $CodigoExterno = $value['CodigoExterno'];
                $Descripcion = $value['Descripcion'];
                $Estado = $value['Estado'];
                $Items = $value['Items'];
                    $html .= "<tr>
                              <td>".$CodigoExterno."</td>
                              <td>".$Descripcion."</td>
                              <td>".$Estado."</td>
                              </tr>
                              <tr>
                              <th>Items</th>
                              <th>Categorias  </th>
                              <th>Descripcion Items</th>
                              </tr>";
                    
                    foreach ($Items as $key => $value2) {
                      $html .= "
                              
                              <tr>
                              <td>".$value2['IdLicitacion']."</td>
                              <td>".$value2['Categoria']."</td>
                              <td>".$value2['Descripcion_item']."</td></tr>";
                      
                }
              }*/
                    
              $html .= "<tr>
                  <th>CodigoExterno</th>
                  <th>Licitación</th>
                  <th>Región</th>
                  <th>Monto</th>
                  <th>Fecha Cierre</th>
                  <th>Link</th>
                  <th>Estado</th>                      
                  </tr>";         
            array_multisort(array_column($datos['licitaciones'], "Fechas_FechaCierre"), SORT_DESC, $datos['licitaciones']);
            foreach ($datos['licitaciones'] as $value) 
            {          
            $CodigoExterno = $value['CodigoExterno'];
            $Nombre = $value['Nombre'];
            $Region = $value['Comprador_RegionUnidad'];
            $Monto = $value['montoestimado'];
            if (is_null($Monto)) {
              $Monto = "No disponible";
            }
            $Cierre = $value['Fechas_FechaCierre'];
            
            $Link = "http://www.mercadopublico.cl/Procurement/Modules/RFB/DetailsAcquisition.aspx?idlicitacion=".$CodigoExterno;            
            $Estado = $value['Estado'];
                $html .= "<tr>
                          <td>".$CodigoExterno."</td>
                          <td>".$Nombre."</td>
                          <td>".$Region."</td>                          
                          <td>".$Monto."</td>
                          <td>".$Cierre."</td>
                          <td>".$Link."</td>
                          <td>".$Estado."</td>
                          </tr>";
              
            
            }
            $html .= "</table>";
            
            $this->email->from('ventas@california.cl','Equipo Licify');
            $this->email->subject('Hemos encontrado una licitación que puedes ofertar');
            $this->email->to($para);
            $this->email->message($html);
            $PRUEBA = $this->email->send();

          }
          /*
           $clientes = array(
                "rut" => $value['rut'],
                "nombre" => $value['nombre'];

              );*/
        //Carga las busquedas de los clientes
        public function fetch_client_filtros() { 
          //$uuid = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
          $uuid = $this->session->userdata('usuario')["uuid"];
          $resultado = $this->Cliente_Model->get_clientes_useruuid($uuid); 
          $clientes = array();
          $filtros = array();
          $data = array();
            foreach ($resultado as $key => $value) {
              $filtros = array();
              $cliente_uuid = $value['uuid'];              
              $cargar_filtros = $this->Cliente_Model->get_filtros_clientes_useruuid($cliente_uuid); 
              if ($cargar_filtros != null) {                                  
                foreach ($cargar_filtros as $key => $value2) {
                  $uuid_client = $value2['cliente_uuid'];
                      if ($cliente_uuid == $uuid_client) {
                      $each_filtro = array(          
                        "segmento_cod" => $value2['segmento_cod'],      
                        "termino" => $value2['termino'],
                        "cliente_uuid" => $value2['cliente_uuid']
                      );
                      array_push($filtros, $each_filtro);
                      }
                }
              }
              if ($filtros != null) {
                $datos_cliente = [
                'rut' => $value['rut'],
                'nombre' => $value['nombre'],
                'cliente_uuid' => $value['uuid'],
                'busqueda' => $filtros];

              array_push($clientes, $datos_cliente);
              }                
            }

              foreach($clientes as $value3)  
              {
                if ($value3['rut'] == null) {
                  $value3['rut'] = "";
                }
               $sub_array = array();  
               $sub_array[] = $value3['nombre'];
               $sub_array[] = $value3['rut'];            
               $busqueda = $value3['busqueda'];

               $sub_arr = "";
               $sub_arr .= "<td>";
               foreach ($busqueda as $filtrando) {
                 if ($busqueda != null) {
                  $sub_arr .= "- ".$filtrando['termino'];                  
                  if ($filtrando > 1) {
                    $sub_arr .= "<br>";
                  }
                  $sub_arr .= "</td>";
                 }

               }
               
               $sub_arr .= "</td>";
              array_push($sub_array, $sub_arr);
              $sub_array[] = "<td><button class='btn btn-warning' onclick='cargarbusqueda(\"".$filtrando['cliente_uuid']."\")' >
              <i class='fas fa-pencil-alt'></i></button></td>"; 
              $data[] = $sub_array;  
            }
            $output = array(  
             "draw"         =>     intval($_POST["draw"]),  
             "recordsTotal"      =>      $this->Cliente_Model->get_all_data_busquedas($uuid),  
             "recordsFiltered"     =>     $this->Cliente_Model->get_filtered_data_busqueda($uuid),  
             "data"   =>     $data  
           );  
          //  var_dump($output);
          //  die();
            //echo $this->db->last_query(); die();
            echo json_encode($output);
            
  
              
          } 

          public function add_filter(){
            $categorias = $this->input->post("categorias");
            $uuid_cliente = $this->input->post("uuid_cliente");
            $tipos = $this->input->post("tipos");
            $fecha = date('Y-m-d H:i:s');
            $all_tipos = "";
            
            if (!is_null($uuid_cliente)) {
            }else {
              $uuid_cliente = $this->session->userdata('cliente');
            }
            $uuid_usu = $this->session->userdata('usuario')["uuid"];
            $busqueda_cliente = $this->Cliente_Model->find_filtros_clientes($uuid_cliente);
            $exist = false;
            if ($uuid_cliente == null || $uuid_cliente == "") {
              $response = ["status" => false, "reason" => "Selecciona un cliente!"];
              header('Content-Type: application/json');          
              echo json_encode($response); 
              die();
            }
            if ($categorias == null || $categorias == "") {
              $response = ["status" => false, "reason" => "Ingresar filtros"];
              header('Content-Type: application/json');          
              echo json_encode($response); 
              die();
            }
            if ($uuid_cliente != null) {
              if ($busqueda_cliente != null) {
                //si ya existen busquedas las dejamos desabilitadas para ingresar las nuevas
                $status = array(
                  "status" => 0
                );
                $this->Cliente_Model->update_busqueda($uuid_cliente,$status);
                if ($tipos != null && $tipos != "") {
                  foreach ($tipos as $tipos_selected) {
                    $all_tipos .= $tipos_selected." ";
                  }
                }
                foreach ($categorias as $key => $value) {         
                  //Explode de el - que viene en el arreglo, para poder ingresar la busqueda, tambien validar que no se agreguen filtros con el mismo codigo de categoria a la tabla busqueda para el mismo cliente
                  $filtros = explode("-", $value);
                      $busqueda_insert = array(
                            "segmento_cod" => $filtros[0],
                            "termino" => $filtros[1],
                            "cliente_uuid" => $uuid_cliente,
                            "usu_uuid" => $uuid_usu,
                            "fecha_creacion" => $fecha,
                            "tipos" => $all_tipos,
                            "status" => 1
                          );
                      $this->Api_Model->add_busqueda($busqueda_insert);                                         
                } 
                $response = ["status" => true, "reason" => "Filtros creados exitosamente!"];                  
              }else{
                if ($tipos != null && $tipos != "") {
                  foreach ($tipos as $tipos_selected) {
                    $all_tipos .= $tipos_selected." ";
                  }
                }
                foreach ($categorias as $key => $value) {         
                  //Explode de el - que viene en el arreglo, para poder ingresar la busqueda, tambien validar que no se agreguen filtros con el mismo codigo de categoria a la tabla busqueda para el mismo cliente
                  $filtros = explode("-", $value);
                      $busqueda_insert = array(
                            "segmento_cod" => $filtros[0],
                            "termino" => $filtros[1],
                            "cliente_uuid" => $uuid_cliente,
                            "usu_uuid" => $uuid_usu,
                            "fecha_creacion" => $fecha,
                            "tipos" => $all_tipos,
                            "status" => 1
                          );
                      $this->Api_Model->add_busqueda($busqueda_insert);
                      $response = ["status" => true, "reason" => "Filtros creados exitosamente!"];                     
                }  
              }         
            }else{
              $response = ["status" => false, "reason" => "Selecciona un cliente!"];                             
            }
            header('Content-Type: application/json');          
            echo json_encode($response); 

            //$this->Api_Model->add_busqueda($busqueda);
          }

          public function find_licitaciones2(){
            //$fecha = date('2019-09-12');
            $fecha = date('Y-m-d');
            //$uuid_usu = "20b935f6-91d4-11e9-b941-0cc47a6c172a";            
            $uuid_usu = $this->session->userdata('usuario')["uuid"];
            //Trae las busquedas para los clientes del usuario
            $busquedas = $this->Api_Model->find_busqueda_all_clientes($uuid_usu);
            //Todos los clientes del usuario
            $clientes = $this->Api_Model->find_all_clientes($uuid_usu);          
            $licitaciones = array();
            $plan_cliente = array();
            $cliente_plan = array();   
              foreach ($clientes as $cliente) {
                $uuid = $cliente['uuid'];
                $plan_cliente = array();
                  foreach ($busquedas as $busqueda) {
                    //print_r("busqueda"); 
                      $cliente_uuid = $busqueda['uuid'];
                      $segmento_cod = $busqueda['segmento_cod'];
                      $tipos = $busqueda['tipos'];                    
                      //Trae todas las licitaciones que en su item tengan el codigo de categoria igual al de todas las busquedas            
                      $respuesta = $this->Api_Model->find_licitacion_bycodigo($uuid_usu,$fecha,$tipos);
                      $licitaciones = array();      
                      if ($uuid == $cliente_uuid) {
                        foreach ($respuesta as $value2) {
                  //  print_r("respuesta"); 
                            $categoria_codigo = $value2['CodigoCategoria'];
                          // print_r($segmento_cod);
                          // print_r($categoria_codigo);
                            if ($segmento_cod == $categoria_codigo) {       
                           // print_r("entre");
                               $licita = [
                                'CodigoExterno' => $value2['CodigoExterno'],
                                'Nombre' => $value2['Nombre'],
                                'Estado' => $value2['Estado'],
                                'Fechas_FechaPublicacion' => $value2['Fechas_FechaPublicacion'],
                                'Fechas_FechaCierre' => $value2['Fechas_FechaCierre'],
                                'Comprador_RegionUnidad' => $value2['Comprador_RegionUnidad'],
                                'montoestimado' => $value2['montoestimado'],
                                'Moneda' => $value2['Moneda']
                               ];
                               array_push($licitaciones, $licita);
                            }
                        }
                        if ($licitaciones != null) {
                              $plan = [
                               'uuid_cliente' => $cliente_uuid,
                               'Termino' => $busqueda['termino'],
                               'Categoria_Codigo' => $busqueda['segmento_cod'],
                               'Licitaciones' => $licitaciones
                              ];
                              array_push($plan_cliente, $plan);
                        }
                      }
                  }  
                  if ($plan_cliente != null) {
                      $plan2 = [
                       'Nombre' => $cliente['nombre'],
                       'uuid' => $cliente['uuid'],
                       'Plan' => $plan_cliente
                      ];
                      array_push($cliente_plan, $plan2);
                  }                  
              }          
              //Notificacion
              $aux="";
              $aux2="";
              //Declaramos un booleano
              $exist = false; 
              $fecha_notificacion = date('Y-m-d H:i:s');             
              foreach ($cliente_plan as $key => $licitar){
                $uuid_cliente = $licitar['uuid'];
                $Plan = $licitar['Plan'];
                //$Licitaciones = $licitar['Licitaciones'];
                $notificacion = $this->Api_Model->verify_notificacion($uuid_cliente);                  
                  foreach ($Plan as $key2 => $licitar2) {                   
                    foreach ($licitar2['Licitaciones'] as $key3 => $lici) {
                      $exist = false;
                      $codigo = $lici['CodigoExterno'];
                      if ($notificacion!=null) {
                        $aux="primer if";
                        foreach ($notificacion as $n) {
                            if ($n["CodigoExterno"] == $codigo) {
                              $aux2 = $aux2.$n["CodigoExterno"]."%";
                              //si encuentra coincidencia manda verdadero el booleano para que no agrege el codigo si ya existe
                              $exist = true;    
                              //agregar solo notificaciones que no fueron enviadas
                              //Si la licitacion fue notificada se borra del array que contiene la licitacion para no volver a envia
                              unset($cliente_plan[$key]['Plan'][$key2]['Licitaciones'][$key3]);
                            }          
                        }
                        //Si no existe el codigo, lo inserta.
                        if (!$exist) {
                          $notificar = array(
                              'cliente_uuid' => $uuid_cliente,
                              'CodigoExterno' => $codigo,
                              'fecha_notificacion' => $fecha_notificacion,
                              'status' => 1
                            );
                            $this->Api_Model->add_notificacion($notificar);
                        }            
                      }else {
                        $aux2="primer else";
                        $notificar = array(
                              'cliente_uuid' => $uuid_cliente,
                              'CodigoExterno' => $codigo,
                              'fecha_notificacion' => $fecha_notificacion,
                              'status' => 1
                            );
                            $this->Api_Model->add_notificacion($notificar);
                      } 
                    }                
                  }                            
              }  
              $response = ["Planes" => $cliente_plan];  
              header('Content-Type: application/json'); 
              echo json_encode($response);                
                                                                
          }

        public function send_mail2(){
            //$fecha = date('Y-m-d');
            $data = $this->input->post('respuesta');
            $datos = json_decode($data,true);
            //$correo_usu = "bcordova@saargo.com";
            $correo_usu = $this->session->userdata('usuario')["email"];
            $pasa = false;
            if ($datos != null) {
              foreach ($datos['Planes'] as $value) 
              { 
                $uuid_cliente = $value['uuid'];
                $pasa = false;
                $data = array();
                $data['plan'] = $value;       
                $Plan = $value['Plan'];
                foreach ($Plan as $value2) {
                  $Licitacion = $value2['Licitaciones'];
                  if (count($Licitacion) > 0) {
                    $pasa = true;
                  }
                }
                if ($pasa) {
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 2
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];                     
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);                  
                    }
                  }
                $template = $this->load->view('email/mailing',$data,TRUE);
                $finalData = array (
                      'personalizations' => array (
                          0 => array (
                            'to' => array (
                              0 => array (
                                'email' => $correo_usu,
                              ),
                            ),
                        'subject' => $value['Nombre']." - ".'Hemos encontrado una licitación que puedes ofertar | '.rand(1, 99999),
                          ),
                      ),
                    'content' =>
                    array (
                      0 =>
                      array (
                        'type' => 'text/html',
                        'value' => $template,
                      ),
                    ),
                    //El que manda el correo
                    'from' =>
                    array (
                      'email' => 'bcordova@saargo.com',
                      'name ' => 'Equipo Licify',
                    ),
                    //Al que se responde el correo
                    'reply_to ' =>
                    array (
                      'email' => 'bcordova@saargo.com',
                      'name ' => 'Equipo Licify',
                    ),
                );
                $dataSend = json_encode($finalData);                
                $secretKey = "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";
                $url = "https://api.sendgrid.com/v3/mail/send";
                $request_headers =  array('Content-Type:application/json', 'Authorization: Bearer ' . $secretKey, 'Content-Length:' . strlen($dataSend));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($ch);
                if (curl_errno($ch))
                {                  
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 3
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];                    
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);
                    }
                  }
                    $hola = "Error: " . curl_error($ch);
                }
                else
                {
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 4
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);
                    }
                  }
                    $hola = $data;
                    curl_close($ch);
                }
                echo json_encode("Se encontraron licitaciones");
                print_r($hola);
                //print_r($request_headers);
                //var_dump($hola);
                }elseif(!$pasa){
                  echo json_encode("No se encontraron licitaciones");
                }
              }
            }
            //array_multisort(array_column($datos['Planes'][0]['Licitaciones'], "Fechas_FechaCierre"), SORT_DESC, $datos['Planes'][0]['Licitaciones']);
          }
          public function find_licitaciones3($uuid_usu){
            $fecha = date('Y-m-d');
            //Trae las busquedas para los clientes del usuario
            $busquedas = $this->Api_Model->find_busqueda_all_clientes($uuid_usu);
            //Todos los clientes del usuario
            $clientes = $this->Api_Model->find_all_clientes($uuid_usu);          
            $licitaciones = array();
            $plan_cliente = array();
            $cliente_plan = array();   
            if ($busquedas != null) {
              foreach ($clientes as $cliente) {
                $uuid = $cliente['uuid'];
                $plan_cliente = array();
                  foreach ($busquedas as $busqueda) {
                      $cliente_uuid = $busqueda['uuid'];
                      $segmento_cod = $busqueda['segmento_cod'];
                      $tipos = $busqueda['tipos'];                    
                      //Trae todas las licitaciones que en su item tengan el codigo de categoria igual al de todas las busquedas            
                      $respuesta = $this->Api_Model->find_licitacion_bycodigo($uuid_usu,$fecha,$tipos);
                      $licitaciones = array();      
                      if ($uuid == $cliente_uuid) {
                        foreach ($respuesta as $value2) {
                            $categoria_codigo = $value2['CodigoCategoria'];
                            if ($segmento_cod == $categoria_codigo) {       
                               $licita = [
                                'CodigoExterno' => $value2['CodigoExterno'],
                                'Nombre' => $value2['Nombre'],
                                'Estado' => $value2['Estado'],
                                'Fechas_FechaPublicacion' => $value2['Fechas_FechaPublicacion'],
                                'Fechas_FechaCierre' => $value2['Fechas_FechaCierre'],
                                'Comprador_RegionUnidad' => $value2['Comprador_RegionUnidad'],
                                'montoestimado' => $value2['montoestimado'],
                                'Moneda' => $value2['Moneda']
                               ];
                               array_push($licitaciones, $licita);
                            }
                        }
                        if ($licitaciones != null) {
                              $plan = [
                               'uuid_cliente' => $cliente_uuid,
                               'Termino' => $busqueda['termino'],
                               'Categoria_Codigo' => $busqueda['segmento_cod'],
                               'Licitaciones' => $licitaciones
                              ];
                              array_push($plan_cliente, $plan);
                        }
                      }
                  }  
                  if ($plan_cliente != null) {
                      $plan2 = [
                       'Nombre' => $cliente['nombre'],
                       'uuid' => $cliente['uuid'],
                       'Plan' => $plan_cliente
                      ];
                      array_push($cliente_plan, $plan2);
                  }                  
              }                 
              //Notificacion
              $aux="";
              $aux2="";
              $fecha_notificacion = date('Y-m-d H:i:s');  
              //Declaramos un booleano
              $exist = false;              
              foreach ($cliente_plan as $key => $licitar){
                $uuid_cliente = $licitar['uuid'];
                $Plan = $licitar['Plan'];
                //$Licitaciones = $licitar['Licitaciones'];
                $notificacion = $this->Api_Model->verify_notificacion($uuid_cliente);                  
                  foreach ($Plan as $key2 => $licitar2) {                   
                    foreach ($licitar2['Licitaciones'] as $key3 => $lici) {
                      $exist = false;
                      $codigo = $lici['CodigoExterno'];
                      if ($notificacion!=null) {
                        $aux="primer if";
                        foreach ($notificacion as $n) {
                            if ($n["CodigoExterno"] == $codigo) {
                              $aux2 = $aux2.$n["CodigoExterno"]."%";
                              //si encuentra coincidencia manda verdadero el booleano para que no agrege el codigo si ya existe
                              $exist = true;    
                              //Si la licitacion fue notificada se borra del array que contiene la licitacion para no volver a envia
                              unset($cliente_plan[$key]['Plan'][$key2]['Licitaciones'][$key3]);
                            }          
                        }
                        //Si no existe el codigo, lo inserta.
                        if (!$exist) {
                          $notificar = array(
                              'cliente_uuid' => $uuid_cliente,
                              'CodigoExterno' => $codigo,
                              'fecha_notificacion' => $fecha_notificacion,
                              'status' => 1
                            );
                            $this->Api_Model->add_notificacion($notificar);
                        }            
                      }else {
                        $aux2="primer else";
                        $notificar = array(
                              'cliente_uuid' => $uuid_cliente,
                              'CodigoExterno' => $codigo,
                              'fecha_notificacion' => $fecha_notificacion,
                              'status' => 1
                            );
                            $this->Api_Model->add_notificacion($notificar);
                      } 
                    }                
                  }                            
              }                
              $response = $cliente_plan;  
              return $response;                
            }      
        }            
          public function send_mail3($email,$respuesta){
            //Bool para ver si existe un Plan
            $pasa = false;
            //Recorremos la respuesta estructurada desde Find_licitacion3
            if ($respuesta != null) {
              //La recorremos para obtener los valores
              foreach ($respuesta as $value) 
              { 
                //sacamos el id del cliente para ver sus busquedas
                $uuid_cliente = $value['uuid'];
                //Limpiamos la variable por si existen Planes
                $pasa = false;
                //Hacemos una variable array
                $data = array();
                //le pasamos los datos en el espacio plan toda la data de la respuesta
                $data['plan'] = $value;   

                //Pasamos los valores de los planes del usuario a la variable Plan
                $Plan = $value['Plan'];
                //Recorremos Plan para ver los datos que trae
                foreach ($Plan as $value2) {
                  //Pasamos las licitaciones existentes a una variable
                  $Licitacion = $value2['Licitaciones'];
                  //Preguntamos si existen mas de 0 licitaciones en ese arreglo
                  if (count($Licitacion) > 0) {
                    //Si existe pasamos a true, significando que existen licitaciones, perminiendonos enviar el correo
                    $pasa = true;
                  }
                }
                //Condición para ver si existen Licitaciones entonces mandamos los datos a la vista donde esta el email 
                //y poder cargar los datos en ella
                if ($pasa) {
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 2
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];                     
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);                  
                    }
                  }
                  //pasamos los datos a la vista mailing
                $template = $this->load->view('email/mailing',$data,TRUE);
                //Armamos el formato de envio que acepta la API de sendgrid
                $finalData = array (
                      'personalizations' => array (
                          0 => array (
                            'to' => array (
                              0 => array (
                                'email' => $email,//'bcordova@saargo.com',
                              ),
                            ),
                            //Asunto del correo, con el rand es un numero aleatorio, para que no se repitan los correos
                        'subject' => $value['Nombre']." - ".'Hemos encontrado una licitación que puedes ofertar | '.rand(1, 99999),
                          ),
                      ),
                    'content' =>
                    array (
                      0 =>
                      array (
                        //pasamos el resultado de la vista mailing por ser el valor a enviar
                        'type' => 'text/html',
                        'value' => $template,
                      ),
                    ),
                    //El que manda el correo
                    'from' =>
                    array (
                      'email' => 'bcordova@saargo.com',
                      'name ' => 'Equipo Licify',
                    ),
                    //Al que se responde el correo
                    'reply_to ' =>
                    array (
                      'email' => 'bcordova@saargo.com',
                      'name ' => 'Equipo Licify',
                    ),
                );
                //Pasamos las configuraciones en formato json a otra variable
                $dataSend = json_encode($finalData);
                //key necesaria para mandar el correo
                $secretKey = "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";
                //ruta de la api sendgrid para enviar correos
                $url = "https://api.sendgrid.com/v3/mail/send";
                //encabezados que necesita la api para poder mandar el correo, con la key y las configuraciones
                $request_headers =  array('Content-Type:application/json', 'Authorization: Bearer ' . $secretKey, 'Content-Length:' . strlen($dataSend));
                //Iniciamos Curl para pasar los datos a la API(Creo que hace eso)
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($ch);
                //Si existe algun error se guarda en esa variable
                if (curl_errno($ch))
                {
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 3
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];                    
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);
                    }
                  }
                    $hola = "Error: " . curl_error($ch);
                }
                else
                {
                  foreach ($Plan as $value2) {
                    $status = array(
                      "status" => 4
                    );
                    $Licitacion = $value2['Licitaciones'];
                    foreach ($Licitacion as $licitaciones_notificadas) {
                      $CodigoExterno = $licitaciones_notificadas['CodigoExterno'];
                      $this->Api_Model->update_notificacion($uuid_cliente,$CodigoExterno,$status);
                    }
                  }
                    //Si no existen errores se cierra sendgrid
                    $hola = $data;
                    curl_close($ch);
                }
                //Mostramos si se enviaron licitaciones                
                echo json_encode("Se encontraron licitaciones");
                //print_r($data);
                //print_r($request_headers);
                //var_dump($hola);
                }elseif(!$pasa){
                  echo json_encode("No se encontraron licitaciones");
                }
              }
            }
          }
        public function edit_busqueda(){
          $uuid_cliente = $this->input->post('uuid_cliente');
          $filtros_cliente = $this->Cliente_Model->get_filtros_clientes_useruuid($uuid_cliente);
          $tipos_cliente = $this->Cliente_Model->get_filtros_clientes_useruuid_tipo($uuid_cliente);          
          $select_tipos = $tipos_cliente["tipos"];
          $tipasos = rtrim($select_tipos," ");
          $cada_tipo = explode(" ", $tipasos);
          $data['tipos_cliente'] = $cada_tipo;
          $data['filtros'] = $filtros_cliente;
          $data["tipos"] = $this->Api_Model->tipos();          
          $this->load->view('cliente/edit_filtros',$data);
        }
        public function cron_enviar(){
          //$uuid_usu = "f32832c2-c9d0-11e9-a344-ba761658d185";
          $usuarios = $this->Cliente_Model->all_users();
           //$uuid_usu = "ac8114d4-9de8-11e9-b04e-ba761658d185";
           //$correo_usu = "'asalas@saargo.com'";
           //$uuid_usu = "e19e0e7a-e09d-11e9-ab88-ba761658d185";           
           if ($usuarios != null) {
            foreach ($usuarios as $all_users) {            
              $uuid_usu = $all_users['uuid'];            
              $correo_usu = $all_users['email'];
              //$all_dias = $this->Cliente_Model->find_horarios_usuario_dias($uuid_usu); 
              $all_horas = $this->Cliente_Model->find_horarios_usuario_horas($uuid_usu);
              //$dia_actual = date("w");
              $hora_actual = date("H:i");
              $pasa_dia = false;
              $pasa_hora = false;
              //Dias seleccionados por el usuario
              //$select_dias = $all_dias["dia"];
              //$dias = rtrim($select_dias," ");
              //$cada_dia = explode(" ", $dias);
              //Horas seleccionadas por el usuario
              $select_horas = $all_horas["horas"];
              $horas = rtrim($select_horas," ");
              $cada_hora = explode(" ", $horas);

              //foreach ($cada_dia as $value) {
              //  if ($value == $dia_actual) {
              //    $pasa_dia = true;
              //  }
              //}
              foreach ($cada_hora as $value2) {
                if ($value2 == $hora_actual) {
                  $pasa_hora = true;
                }
              }
              //var_dump($pasa_dia." - ".$pasa_hora);
              
              if ($pasa_hora) {
                $licita = $this->find_licitaciones3($uuid_usu);
                if ($licita != null) {
                //$respuesta = json_decode($licita,true);
                $send = $this->send_mail3($correo_usu,$licita); 
                //var_dump($send);
                echo $send;
              } 
              }                                  
            } 
           }                 
        //fin cron
        }
        public function horarios(){
          //si el usuario esta logeado puede generar una busqueda
          is_login();  
          $data["page_name"]="Ingresa tu horario";
          //uuid usuario
          $uuid_usu = $this->session->userdata('usuario')['uuid'];
          //$all_dias = $this->Cliente_Model->find_horarios_usuario_dias($uuid_usu); 
          $all_horas = $this->Cliente_Model->find_horarios_usuario_horas($uuid_usu); 
          //Dias seleccionados por el usuario
          //$select_dias = $all_dias["dia"];
          //$dias = rtrim($select_dias," ");
          //$cada_dia = explode(" ", $dias);
          //Horas seleccionadas por el usuario
          $select_horas = $all_horas["horas"];
          $horas = rtrim($select_horas," ");
          $cada_hora = explode(" ", $horas);
          //Enviamos los dias y las horas a la vista          
          //$data['cada_dia'] = $cada_dia;
          $data['cada_hora'] = $cada_hora;
          $this->load->view("cliente/horarios",$data);
        }
        public function horario(){
          //si el usuario esta logeado puede generar una busqueda
          is_login();              
          //uuid usuario
          $uuid_usu = $this->session->userdata('usuario')['uuid'];
          //$all_dias = "";
          $all_horas = "";
          //$dias = $this->input->post("dias");
          $horas = $this->input->post("horas");
          if ($horas != "") {
            //foreach ($dias as $value) {
            //  $all_dias .= $value." ";
            //}
            foreach ($horas as $value2) {
              $all_horas .= $value2." ";
            }
          }
          if ($all_horas != "") {                    
            $horario = array(
              "dias" => "1 2 3 4 5 6 0",
              "hora" => $all_horas,
            );
            $this->Cliente_Model->update_horario($uuid_usu, $horario); 
            $response = ["status" => true, "reason" => "Horario actualizado exitosamente!"];
            header('Content-Type: application/json'); 
            echo json_encode($response);                       
          }else{
            $response = ["status" => false, "reason" => "Ingresa al menos 1 hora!"];
            header('Content-Type: application/json'); 
            echo json_encode($response);  
          }
          //print(date("w"));
          //$this->load->view("cliente/horario_horas", $data);
        }
        public function busquedas(){
          is_login();
          $uuid_cliente = $this->input->post("uuid_cliente");          
          $data["nombre"] = $this->Cliente_Model->get_clientes_error($uuid_cliente);
          $data["busqueda"] = $this->Cliente_Model->get_filtros_clientes_useruuid($uuid_cliente);
          $data["tipos"] = $this->Cliente_Model->get_filtros_clientes_useruuid_tipo($uuid_cliente);
/*           print_r($data["busqueda"]);
          die(); */
          //$template = $this->load->view("home/detallebusquedas", $data,true);
          $response = ["status" => true, "reason" => "Busquedas encontradas!", "data" => $data];
          header('Content-Type: application/json'); 
          echo json_encode($response); 
          //print_r($response);
        }

  }
?>

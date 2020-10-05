<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {


    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('api');
        $this->load->model('Api_Model');
        $this->load->model('Cliente_Model');
    }

    /*SERVICIO PING*/
    public function init_get(){




        $response=["status"=>"0","status" => "asd"];  
        header('Content-Type: application/json'); 
        echo json_encode($response);
    }


    /*SERVICIO LOGIN
        STATUS: 1 -> TOKEN INCORRECTO
        STATUS: 0 -> CORRECTO
        STATUS: 3 -> USUARIO NO EXÍSTE
        STATUS: 4 -> VIENEN CAMPOS VACÍOS
    */
    public function login_post(){
        $email=$this->post('email');
        $password=$this->post('password');
        if ($email==null || $password==null) {
            $response=["status"=>4];
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        }

        $u=$this->Api_Model->login($email,$password);
        if($u!=null){
            $token=$this->Api_Model->uuid();
            $usuario=["token"=>$token,"ultimo_acceso"=>date('Y:m:d h:i:s')];
            $this->Api_Model->token_update($usuario,$u["uuid"]);
            $response=["status"=>0,"usuario"=>$u,"token"=>$token];
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        }else{
            $response=["status"=>3];
            header('Content-Type: application/json');
            echo json_encode($response);
            die();
        }

    }

    public function configuraciones_get() {
        $configuraciones=[
            "base_url"=>"http://190.196.222.45/california/"
        ];
        $response=["status"=>0,"configuraciones"=>$configuraciones];
        header('Content-Type: application/json');
        echo json_encode($response);
        die();
    }

    public function send_mail_post(){

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
            $aux="";
            $aux2="";
            //Declaramos un booleano
            $exist = false;
            $response = ["licitaciones" => $licitacion];  
            header('Content-Type: application/json'); 
            //echo json_encode($response);
            echo json_encode($response);
      
            }

        

    


    public function find_busqueda_post($uuid_cliente){

        $respuesta=$this->Api_Model->get_busqueda_uuid($uuid_cliente);
        $cod_segmento = $respuesta[0]['cod_segmento'];
        $valor = $respuesta[0]['valor_tipo'];
        $PRUEBA=$this->Api_Model->find_filter($valor,$cod_segmento);
        $response=["status"=>$respuesta,"status2" => $cod_segmento];  
        header('Content-Type: application/json'); 
        echo json_encode($response);
       }

    public function now_licitacion_post(){
        $fecha = date('Y-m-d H:i:s');
        $segmento=$this->post('segmento');
        $resputa=$this->Api_Model->get_licitacion($fecha, $segmento);
        $response=["status"=>$resputa];  
        header('Content-Type: application/json'); 
        echo json_encode($response);
       }





    public function find_licitacion_post(){
        $fecha = date('Y-m-d H:i:s');
        $uuid_usu = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
        //$uuid_usu = $this->session->userdata('usuario')['uuid'];
        $respuesta = $this->Api_Model->find_licitacion($uuid_usu,$fecha);
        /*
        foreach ($respuesta["licitacion"] as $key => $value) {

          $codigoexterno = $value["CodigoExterno"];
          $items = $this->Api_Model->find_items_licitacion($codigoexterno);

          $response=["Licitacion" => $items]; 
          header('Content-Type: application/json'); 
          echo json_encode($response);
        }*/


        $response=["status"=>$respuesta["status"], "licitacion"=> $respuesta["licitacion"]];  
        header('Content-Type: application/json'); 
        echo json_encode($response);
       }





       public function find_licitaciones_post(){
        $fecha = date('Y-m-d H:i:s');
        $uuid_usu = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
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
            'Descripcion' => $value['Descripcion'],
            'Estado' => $value['Estado'],
            'Fecha' => $value['Fechas_FechaCreacion'],
            'Items' => $licitacionitems
          ];
          //subimos al arreglo todos los datos que contiene el objeto
          array_push($licitacion, $licitacionfinal);
          //Agregamos los codigos que nos sirven en la tabla notifacion con el uuid de quien hizo el filtro

          }

        }
        $aux="";
         $aux2="";
         //Declaramos un booleano
         $exist = false;
         /*
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
        }*/

          $response=["licitacion" => $licitacion,"aux"=>$items,"aux2"=>$aux2];  
          header('Content-Type: application/json'); 
          echo json_encode($response);


       }

       public function licitaciones_fechas_post(){
            $fecha = date('2014-01-01');
            $fecha2 = date('2019-09-16');
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
            //$this->load->view('cliente/licitacionesfaltantes', $fechasfaltantes);

            $response = ["Faltantes" => $fechasfaltantes];  
            header('Content-Type: application/json'); 
            echo json_encode($response);
       }
       public function ordenes_fechas_post(){
            $fecha = date('2014-01-01');
            $fecha2 = date('2019-09-16');
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
            //$this->load->view('cliente/licitacionesfaltantes', $fechasfaltantes);

            $response = ["Faltantes" => $fechasfaltantes];  
            header('Content-Type: application/json'); 
            echo json_encode($response);
       }
       public function cargar_filtros_post(){

          $uuid = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
          //$uuid = $this->session->userdata('usuario')["uuid"];
          $resultado = $this->Cliente_Model->get_clientes_useruuid($uuid);
          
          $data["page_name"]="Listar Filtros de los clientes";
          $clientes = array();
          $filtros = array();

          foreach ($resultado as $key => $value) {
              $filtros = array();
              $cliente_uuid = $value['uuid'];              

              $cargar_filtros = $this->Cliente_Model->get_filtros_clientes_useruuid($cliente_uuid);

              if ($cargar_filtros == null) {

                $each_filtro = array(          
                      "segmento_cod" => "Sin datos",      
                      "nombre_busqueda" => "Sin datos"
                    );
                array_push($filtros, $each_filtro);
                
              }else{
                  foreach ($cargar_filtros as $key => $value2) {
    
                    $uuid_client = $value2['cliente_uuid'];
    
                        if ($cliente_uuid == $uuid_client) {
    
                        $each_filtro = array(          
                          "segmento_cod" => $value2['segmento_cod'],      
                          "nombre_busqueda" => $value2['nombre']
                        );
                        array_push($filtros, $each_filtro);
                        }

                  }
              }
              if ($filtros != null) {

                $datos_cliente = [
                'rut' => $value['rut'],
                'nombre' => $value['nombre'],
                'busqueda' => $filtros];

              array_push($clientes, $datos_cliente);
              }
              
  
              
            }
              $response = ["filtros" => $clientes];  
              header('Content-Type: application/json'); 
              //echo json_encode($response);
              echo json_encode($clientes);

          

        }
          public function send_mail2(){

            $data = $this->input->post('respuesta');
            $datos = json_decode($data,true);
            $correos = "";
            $correos.='bcordova@saargo.com';
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
    
              $html .= "<tr>
                  <th>CodigoExterno</th>
                  <th>Licitación</th>
                  <th>Región</th>
                  <th>Monto</th>
                  <th>Fecha Cierre</th>
                  <th>Link</th>
                  <th>Estado</th>                      
                  </tr>";         
            array_multisort(array_column($datos, "Fechas_FechaCierre"), SORT_DESC, $datos['licitaciones']);
            foreach ($datos as $value) 
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
          public function find_licitaciones2_post(){
            $fecha = date('2019-09-12');
             //$fecha = date('Y-m-d H:i:s');
             $uuid_usu = "20b935f6-91d4-11e9-b941-0cc47a6c172a";
             //$uuid_usu = $this->session->userdata('usuario')["uuid"];
             $respuesta = $this->Api_Model->find_licitacion_bycodigo($uuid_usu,$fecha);
             return json_encode($respuesta);
      
            }

       



}

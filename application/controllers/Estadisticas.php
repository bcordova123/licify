<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Estadisticas extends CI_Controller {
        public function __construct()
        {
          parent::__construct();
          $this->load->model('Usuario_Model');
          $this->load->model('Cliente_Model');
          $this->load->model('Api_Model');
        }      
    
        public function index()
        {
            //is_login();

            $data = [];
            $data["licitaciones"] = $this->getLicitacionesToday();
            $data["ocompra"] = $this->getOcompraToday();



        /*    $uuid_busqueda = $this->session->userdata('uuid_busqueda');
            $uuid_cliente = $this->session->userdata('uuid_cliente');   
            if ($uuid_busqueda != null && $uuid_cliente != null) {
                $filtros_cliente = $this->Cliente_Model->get_filtros_clientes_error($uuid_busqueda);
                $tipos_cliente = $this->Cliente_Model->get_filtros_clientes_error_tipo($uuid_busqueda);
                $nombre_cliente = $this->Cliente_Model->get_clientes_error($uuid_cliente);                              
                $select_tipos = $tipos_cliente["tipos"];
                $tipasos = rtrim($select_tipos," ");
                $cada_tipo = explode(" ", $tipasos);
                $data['tipos_cliente'] = $cada_tipo;
                $data['filtros'] = $filtros_cliente;
                $data['nombre_cliente'] = $nombre_cliente;
            }
            //$data["page_name"]="Prueba Elastic Search";
            $data["tipos"] = $this->Api_Model->tipos();  */
            
            $this->load->view('home/estadisticas', $data);
            
        }


        public function licitaciones($scroll) {

            $result = [];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/licitaciones/_search');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"query\":{\"range\":{\"Fechas_FechaPublicacion\":{\"gte\":\"now-1d/d\",\"lte\":\"now/d\"}}},\"sort\":[{\"Fechas_FechaPublicacion\":{\"order\":\"desc\"}}],\"size\":50}");


            $headers = array();
            $headers[] = 'Accept: */*';
            $headers[] = 'Accept-Encoding: UTF-8';
            $headers[] = 'Authorization: Basic ZWxhc3RpYzpzWmtuYUNLbmhLUEozamlzTWw1TGF4YjM=';
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            $data = [];
            $data["licitaciones"] =  json_decode($result, true);
            $data["hits"] = $data["licitaciones"]["hits"]["total"]["value"];


            $this->load->view('licitaciones/listar', $data);
        }



        private function getLicitacionesToday() {
            $result = [];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/licitaciones/_search');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"track_total_hits\":true,\"query\":{\"range\":{\"Fechas_FechaPublicacion\":{\"gte\":\"now-1d/d\",\"lte\":\"now/d\"}}},\"size\":0}");

            $headers = array();
            $headers[] = 'Accept: */*';
            $headers[] = 'Accept-Encoding: UTF-8';
            $headers[] = 'Authorization: Basic ZWxhc3RpYzpzWmtuYUNLbmhLUEozamlzTWw1TGF4YjM=';
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Host: 22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243';
            $headers[] = 'User-Agent: PostmanRuntime/7.18.0';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            return $result;
        }

        private function getOcompraToday() {
            $result = [];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/ocompra/_search');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"track_total_hits\":true,\"query\":{\"range\":{\"Fechas_FechaEnvio\":{\"gte\":\"now-1d/d\",\"lte\":\"now/d\"}}},\"size\":0}");

            $headers = array();
            $headers[] = 'Accept: */*';
            $headers[] = 'Accept-Encoding: UTF-8';
            $headers[] = 'Authorization: Basic ZWxhc3RpYzpzWmtuYUNLbmhLUEozamlzTWw1TGF4YjM=';
            $headers[] = 'Cache-Control: no-cache';
            $headers[] = 'Connection: keep-alive';
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Host: 22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243';
            $headers[] = 'User-Agent: PostmanRuntime/7.18.0';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);

            return $result;
        }



        public function elastic_querys(){
            $curl = curl_init();        
            curl_setopt($curl, CURLOPT_URL, 'http://35.245.110.168/elasticsearch/licitacion/_search');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "{\"from\":0,\"size\":5,\"query\":{\"bool\":{\"must\":{\"query_string\":{\"fields\":[\"comprador_nombreorganismo\"],\"query\": \"Vialidad\"}},\"should\": [{\"query_string\": {\"fields\":[\"tipo\"],\"query\":\"LE\"}},{\"query_string\":{\"fields\":[\"fuentefinanciamiento\"],\"query\": \"Sectorial\"}},{\"query_string\":{\"fields\":[\"adjudicacion_numero\"],\"query\": \"0719\",\"boost\":1000}}]}},\"aggs\": {}}");
            curl_setopt($curl, CURLOPT_POST, 1);
            $headers = array();
            $headers[] = 'Authorization: Basic dXNlcjpwYjVpS3VDVms2d2I=';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                $respuesta= "cURL Error #:" . $err;
                $response=["status"=>$respuesta];  
            header('Content-Type: application/json'); 
            echo json_encode($response);
            } else {
                $respuesta = true;
                $response=["status"=>$response];  
                header('Content-Type: application/json'); 
                echo json_encode($response);
            }                
        }
        public function generar_busqueda(){
            //si el usuario esta logeado puede generar una busqueda
            is_login();              
            //uuid usuario
            $uuid_usu = $this->session->userdata('usuario')['uuid'];
            //uuid busqueda, solo estara este dato si ocurrio algun error en el pago
            $uuid_busqueda = $this->session->userdata('uuid_busqueda');
            //uuid cliente, solo estara este dato si ocurrio algun error en el pago
            $uuid_cliente = $this->session->userdata('uuid_cliente'); 
            //busquedas seleccionadas
            $categorias = $this->input->post("categorias");
            //Estaran todos los tipos seleccionados
            $all_tipos = "";
            //Tipos seleccionados
            $tipos = $this->input->post("tipos");
            //Fecha actual 
            $fecha = date('Y-m-d H:i:s');
            //Ajustamos los tipos seleccionados a la bd
            $total_nuevo = 0;
            //total de categorias seleccionadas
            $total_nuevo = count($categorias);
            //Numero de orden, fecha actual en milisegundos + numero aleatorio
            $milisegundos = round(microtime(true) * 1000);
            $numero_orden = (string)($milisegundos.rand(1,9999));
            //print_r($numero_orden);
            
            if (isset($uuid_busqueda)) {                
                //Si existen tipos los vamos agregando a un string 
                if ($tipos != null && $tipos != "") {                    
                    foreach ($tipos as $tipos_selected) {
                        $all_tipos .= $tipos_selected." ";
                    }
                    $tipos = array(
                        "tipos" => $all_tipos
                    );
                    //actualizamos los datos
                    $this->Cliente_Model->update_busqueda_byuuid_busqueda($uuid_busqueda,$tipos); 
                  }
            }
            
            //Sirve para dar tiempo de expiración a una variable de sesión en codeigniter
            //$this->session->mark_as_temp('total_categorias', 300);
            
            //Total de la busqueda anterior si ocurrio un fallo
            $total_anterior = $this->session->userdata('total_categorias');
            
            if (isset($total_anterior)) {
                
                $codigos = array();                     
                    $filtros_cliente = $this->Cliente_Model->get_filtros_clientes_error($uuid_busqueda);
                    foreach ($categorias as $value) {
                        $existe = false;
                        $filtros = explode("-", $value);
                        array_push($codigos, $filtros[0]);
                        foreach ($filtros_cliente as $value2) {
                           $cod_segmento = $value2['segmento_cod'];
                           if ($cod_segmento == $filtros[0]) {
                                $existe = true;                                
                           }
                        }
                        if (!$existe) {
                            $busqueda_insert = array(
                                  "segmento_cod" => $filtros[0],
                                  "termino" => $filtros[1],
                                  "cliente_uuid" => $uuid_cliente,
                                  "usu_uuid" => $uuid_usu,
                                  "fecha_creacion" => $fecha,
                                  "tipos" => $all_tipos,
                                  "uuid_busqueda" => $uuid_busqueda,
                                  "numero_orden" => $numero_orden,
                                  "status" => 0
                                );
                            $this->Api_Model->add_busqueda($busqueda_insert);                             
                        }                                    
                    }                
                $orden = array("numero_orden" => $numero_orden);
                $this->Cliente_Model->update_busqueda_byuuid_busqueda($uuid_busqueda,$orden);
                $this->Cliente_Model->delete_busquedas($codigos,$uuid_busqueda);
                //var_dump($total_nuevo." - ".$total_anterior);                
                $this->session->set_userdata('total_categorias', $total_nuevo);
            }
            //Validamos si el usuario no cambio el nombre a la busqueda
            if (isset($uuid_cliente)) {
                //nombre del cliente creado anteriormente
                $nombre_cliente = $this->Cliente_Model->get_clientes_error($uuid_cliente);   
                //nombre del cliente de la busqueda
                $nombre = $this->input->post("nombre"); 
                if ($nombre_cliente['nombre'] != $nombre) {
                    $nuevo_nombre = array(
                        "nombre" => $nombre
                    );
                    $this->Cliente_Model->update($uuid_cliente,$nuevo_nombre);
                }
            }
            //Validamos si no viene una busqueda creada anteriormente para no insertar datos demas
            if (!isset($uuid_busqueda) && !isset($uuid_cliente)) {
                //nombre del cliente de la busqueda
                $nombre = $this->input->post("nombre");                
                //uuid cliente
                $query = $this->db->query('select uuid() as "uuid_cliente"');
                $result=$query->row_array();
                $uuid_cliente = $result["uuid_cliente"];
                //fijamos la uuid de cliente en sesion para usarla mas adelante
                $this->session->set_userdata('uuid_cliente', $uuid_cliente);
                //uuid busqueda
                $query2 = $this->db->query('select uuid() as "uuid_busqueda"');
                $result2=$query2->row_array();
                $uuid_busqueda = $result2["uuid_busqueda"];
                //fijamos la uuid de busquedas en sesion para usarla mas adelante
                $this->session->set_userdata('uuid_busqueda', $uuid_busqueda);
                //variable de sesion del total de categorias seleccionadas
                $this->session->set_userdata('total_categorias', $total_nuevo);
                //Boolean para ver si se realizo la creacion del cliente y de las busquedas
                $listo = false;
                if ($nombre != "" && $nombre != null && $categorias != null && $categorias != "") {
                    //Se crea el cliente
                    $insert = array(
                        'uuid' => $uuid_cliente,
                        'nombre' => $nombre,
                        'usu_uuid' => $uuid_usu,
                        'status' => 0
                        );
                    $this->Cliente_Model->add($insert);
                    //Si existen tipos los vamos agregando a un string 
                if ($tipos != null && $tipos != "") {
                    foreach ($tipos as $tipos_selected) {                    
                      $all_tipos .= $tipos_selected." ";
                    }
                  }
                  //se crea la busqueda
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
                              "uuid_busqueda" => $uuid_busqueda,
                              "numero_orden" => $numero_orden,
                              "status" => 0
                            );
                        $this->Api_Model->add_busqueda($busqueda_insert);                                         
                  } 
                  $listo = true;
                }
            }else{
                $listo = true;
            }       
            if ($listo) {
                $response = ["status" => true, "reason" => "Busqueda creada existosamente!"];
                header('Content-Type: application/json'); 
                echo json_encode($response);
            }else{
                $response = ["status" => false, "reason" => "Algo anda mal, revisa tus datos!"];
                header('Content-Type: application/json'); 
                echo json_encode($response);
            }            
        }
        public function cargarpago(){
            is_login();
            $uuid_busqueda = $this->session->userdata('uuid_busqueda');
            $uuid_usu = $this->session->userdata('usuario')['uuid'];
            $categorias_cantidad = $this->session->userdata('total_categorias');
            $meses = $this->input->post("meses");
            $monto_final = "";
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.sbif.cl/api-sbifv3/recursos_api/uf?apikey=5f4c9e35ac78212e879807c406b1eff22890497f&formato=json",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Host: api.sbif.cl",
                "Postman-Token: c227cfd3-588c-499a-a1d6-ee7e7849839c,a1dce9c8-4392-4852-b2cc-a47ee2deee71",
                "User-Agent: PostmanRuntime/7.17.1",
                "cache-control: no-cache"
              ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              echo "cURL Error #:" . $err;
            }else {   
                $result = array();             
                $result = json_decode($response,true);
                $uf = $result["UFs"][0]["Valor"];
                $valor_uf = str_replace(".","",$uf);   
                $valor_final_uf = (float)str_replace(",",".",$valor_uf);   
                if($meses == "monthly"){
                    $cobro = $valor_final_uf * 0.05;
                    $total = $categorias_cantidad * $cobro;
                }elseif ($meses == "quarterly") {
                    $cobro = ($valor_final_uf * 0.05)*0.90;
                    $total = ($categorias_cantidad * $cobro)*3;
                }                                
               // print_r($total);                
                $total2 = round($total);
                $monto_final = "";
                $monto_final .= $total2;
                $this->session->set_userdata('monto_final', $monto_final);
                $datos['datos'] = $this->Cliente_Model->datos_compra($uuid_busqueda,$uuid_usu);
                $datos['monto'] = $monto_final;
                $datos['meses'] = $meses;
            }            
            $template = $this->load->view('home/detalle_pago',$datos,TRUE);          
            $response = ["status" => true, "reason" => "Busqueda creada existosamente!","template" => $template];
            header('Content-Type: application/json'); 
            echo json_encode($response); 
                           
        }
        //Kushki cargarpago
        //public function cargarpago(){
        //    is_login();
        //    $valor = $this->input->post("valor");
        //    $categorias_cantidad = $this->session->userdata('total_categorias');
        //    $monto_final = "";
        //    $curl = curl_init();
        //    curl_setopt_array($curl, array(
        //      CURLOPT_URL => "https://api.sbif.cl/api-sbifv3/recursos_api/uf?apikey=5f4c9e35ac78212e879807c406b1eff22890497f&formato=json",
        //      CURLOPT_RETURNTRANSFER => true,
        //      CURLOPT_ENCODING => "",
        //      CURLOPT_MAXREDIRS => 10,
        //      CURLOPT_TIMEOUT => 30,
        //      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //      CURLOPT_CUSTOMREQUEST => "GET",
        //      CURLOPT_HTTPHEADER => array(
        //        "Accept: */*",
        //        "Accept-Encoding: gzip, deflate",
        //        "Cache-Control: no-cache",
        //        "Connection: keep-alive",
        //        "Host: api.sbif.cl",
        //        "Postman-Token: c227cfd3-588c-499a-a1d6-ee7e7849839c,a1dce9c8-4392-4852-b2cc-a47ee2deee71",
        //        "User-Agent: PostmanRuntime/7.17.1",
        //        "cache-control: no-cache"
        //      ),
        //    ));
        //    $response = curl_exec($curl);
        //    $err = curl_error($curl);
        //    curl_close($curl);
        //    if ($err) {
        //      echo "cURL Error #:" . $err;
        //    }else {   
        //        $result = array();             
        //        $result = json_decode($response,true);
        //        $uf = $result["UFs"][0]["Valor"];
        //        $valor_uf = str_replace(".","",$uf);   
        //        $valor_final_uf = (float)str_replace(",",".",$valor_uf);     
        //        $cobro = $valor_final_uf * 0.05;
        //        $total = $categorias_cantidad * $cobro;
        //        $total2 = round($total);
        //        $monto_final .= $total2;
        //        $this->session->set_userdata('monto_final', $monto_final);
        //    }            
        //    $bool = false;
        //    if ($valor == 1) {
        //        //$valor_a_pagar = $uf * $categorias_cantidad;
        //        $template = $this->load->view('home/credito',null,TRUE);
        //        $bool = true;
        //        //$template = $this->load->view('email/mailing',$data,TRUE);
        //    }elseif ($valor == 2) {
        //        $template = $this->load->view('home/debito',null,TRUE);
        //        $bool = true;
        //    }   
        //    if ($bool) {
        //        $response = ["status" => true, "reason" => "Busqueda creada existosamente!", "total" => $monto_final, "template" => $template,"valor" => $valor];
        //        header('Content-Type: application/json'); 
        //        echo json_encode($response); 
        //    }                  
        //}

        public function kushki_post(){
            /* array(5)
            {
                ["cart_id"]=> string(3) "123"
                ["kushkiToken"]=> string(32) "4948ac3791944192a3477dce1c911079"
                ["kushkiPaymentMethod"]=> string(4) "card"
                ["kushkiDeferredType"]=> string(3) "all"
                ["kushkiDeferred"]=> string(1) "5"
            }
            array(5)
            {
                ["cart_id"]=> string(3) "123"
                ["kushkiToken"]=> string(32) "f5128e11f3864ae4b5e4ea8e596b1a43"
                ["kushkiPaymentMethod"]=> string(4) "card"
                ["kushkiDeferredType"]=> string(3) "all"
                ["kushkiDeferred"]=> string(1) "5"
            }
            “01” = Fixed installments with interest.
            “02” = Months of grace with interest.
            “03” = Monthly payment by month with interest.
            “04” = Fixed installments withouth interest.
            “05” = Months of grace withouth interest.
            “06” = Monthly payment by month withouth interest.
            “07” = Special without interest.
            “50” = Supermaxi promo.
            */
            var_dump($_POST);
            die();
            $fecha_actual = date('Y-m-d');
            //uuid usuario
            $uuid_usu = $this->session->userdata('usuario')['uuid'];  
            //consulta para traer los datos del usuario
            $datos_usuario = $this->Usuario_Model->get_user($uuid_usu);
            //nombre usuario
            $nombre = $datos_usuario["nombre"];            
            //apellidos usuario
            $apellidos = $datos_usuario["apellidos"];
            //correo usuario
            $email = $datos_usuario["email"];
            //var_dump();
            //uuid card          
            $cart_id =$this->input->post('cart_id');
            //Token de subscripcion
            $kushkiToken =$this->input->post('kushkiToken');
            //Tipo de subscripción
            $meses =$this->input->post('meses');
            //Nombre de la subscripción
            $nombre_plan = "";
            if ($meses == "monthly") {
                $nombre_plan = "Mensual";
            }elseif ($meses == "quarterly") {
                $nombre_plan = "Trimestral";
            }
            //Valor a cobrar
            $valor = $this->session->userdata('monto_final');
            //Tipo de moneda
            $moneda = "CLP";
            //Inicio de la API
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api-uat.kushkipagos.com/subscriptions/v1/card",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"token\":\"".$kushkiToken."\",\"planName\":\"".$nombre_plan."\",\"periodicity\":\"".$meses."\",\"contactDetails\":{\"firstName\":\"".$nombre."\",\"lastName\":\"".$apellidos."\",\"email\":\"".$email."\"},\"amount\":{\"subtotalIva\":0,\"subtotalIva0\":".$valor.",\"ice\":0,\"iva\":0,\"currency\":\"".$moneda."\"},\"startDate\":\"".$fecha_actual."\"}",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                "private-merchant-id: 20000000100314333000"
            ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $r = json_decode($response,true);
            curl_close($curl);
            if ($err) {
                $meh=["status"=>false,"respuesta"=>$err];
                header('Content-Type: application/json');
                echo json_encode($meh);
            }else{                
                $subscriptionId = $r["subscriptionId"];                
                if (isset($subscriptionId)) {               
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api-uat.kushkipagos.com/subscriptions/v1/card/".$subscriptionId."/authorize",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "{\"amount\":{\"ice\":0,\"iva\":0,\"subtotalIva\":0,\"subtotalIva0\":".$valor.",\"currency\":\"CLP\"},\"fullResponse\":true}",
                        CURLOPT_HTTPHEADER => array(
                          "content-type: application/json",
                          "private-merchant-id: 20000000100314333000"
                        ),
                      ));
                    $response = curl_exec($curl);
                    $r = json_decode($response,true);
                    $err = curl_error($curl);
                    curl_close($curl);
                    if ($err) {
                        $meh=["status"=>false,"respuesta"=>$err];
                        header('Content-Type: application/json');
                        echo json_encode($meh);
                    } else {
                        print_r($r);
                        var_dump($r["ticketNumber"],$subscriptionId);
                    }
                    
                }else{
                    $exito['exito'] = false;
                    $this->session->unset_userdata('monto_final');
                    $this->load->view('home/mensaje',$exito,false);
                }
                //$meh=["status"=>true,"respuesta"=>$r];
                //header('Content-Type: application/json');
                //echo json_encode($meh);
                
                /* $response=["licitaciones"=>"ok"];
                header('Content-Type: application/json');
                echo json_encode($response); */
            }
        }
    }
    /* End of file Controllername.php */
?>
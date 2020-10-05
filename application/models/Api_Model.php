<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Api_Model extends CI_Model {
    
            
            public function __construct()
            {
                parent::__construct();
                //Do your magic here
            }
            
            public function uuid()
            {
                $query = $this->db->query('select uuid() as "uuid"');
                $result=$query->row_array();
                return $result["uuid"];           
            }

            public function token_update($usuario,$user_uuid){
                $this->db->where('uuid', $user_uuid);
                $this->db->update('USUARIO', $usuario);
            }

            public function login($email,$password){
                $this->db->select('*');
                $this->db->where('email', $email);
                $this->db->where('clave', sha1($password));
                $this->db->where('status', 1);
                return $this->db->get('USUARIO')->row_array();
            }
    
            public function verify_token($token){
                $this->db->select('*');
                $this->db->where('token', $token);
                return $this->db->get('USUARIO')->row_array();
            }
            
            public function verify_email($email){
                $this->db->select('*');
                $this->db->where('email', $email);
                return $this->db->get('USUARIO')->row_array();
            }
        
            public function get_user($uuid){
                $this->db->select('*');
                $this->db->where('uuid', $uuid);
                return $this->db->get('USUARIO')->row_array();
                
            }
        
            public function add_user($usuario){
                $this->db->insert('USUARIO', $usuario);
            }
            // Metodos bryan
            public function find_filter($valor,$codigo){

                $this->db->select('*');
                $this->db->where('SEGMENTO.cod_segmento',$codigo);
                $segmento=$this->db->get('SEGMENTO')->row_array();
                $this->db->select('LICITACION_ITEM.Descripcion,LICITACION.Tipo,LICITACION_ITEM.CodigoCategoria');
                $this->db->join('LICITACION_ITEM','LICITACION_ITEM.LicitacionID = LICITACION.CodigoExterno');
                $this->db->where('LICITACION.Tipo',$valor);
                $this->db->where('LICITACION_ITEM.CodigoCategoria >', $segmento['rango_inicio']);
                $this->db->where('LICITACION_ITEM.CodigoCategoria <', $segmento['rango_final']);
                $this->db->limit('1000');
                return $this->db->get('LICITACION')->result_array();
            }
            public function get_segmentos(){
             $this->db->select('*');
             $this->db->order_by('nombre', 'asc');
             return $this->db->get('SEGMENTO')->result_array();
            }

            public function get_tipo(){
             $this->db->select('*');
             return $this->db->get('TIPO_LICITACION')->result_array();

            }
            public function add_busqueda($busqueda){
                $this->db->insert('BUSQUEDA', $busqueda);
            }
            public function get_busqueda_uuid($uuid_cliente){
             $this->db->select('TIPO_LICITACION.valor_tipo,SEGMENTO.cod_segmento');
             $this->db->join('SEGMENTO', 'SEGMENTO.cod_segmento = BUSQUEDA.cod_segmento');
             $this->db->join('TIPO_LICITACION', 'TIPO_LICITACION.id_tipo_licitacion = BUSQUEDA.tipo_licitacion_id');    
             $this->db->where('cliente_uuid',$uuid_cliente);         
             return $this->db->get('BUSQUEDA')->result_array();
            }

            public function get_licitacion($fecha){
                //$dia = date('Y-m-d H:i:s'); 
                //DATE_FORMAT(NOW(),"%Y-%m-%d %h:%i:%s")
                $this->db->select('LICITACION.Descripcion,LICITACION.Estado,LICITACION.Fechas_FechaCreacion');
                $this->db->where('LICITACION.Fechas_FechaCreacion <=', $fecha);
                $this->db->where('LICITACION.Estado','Publicada');
                $this->db->limit('1000');
                return $this->db->get('LICITACION')->result_array();   
            }
            public function add_plan($plan){
                $this->db->insert('PLAN', $plan);
            }
            public function find_licitacion($usuario,$fecha){
                // CREO EL OBJETO
                $response = [];
                $response["status"] = false;
                $response["licitacion"] = null;
                // CONSULTO EL PLAN
                $planes = [];
                $this->db->select('*');
                $this->db->where('PLAN.usu_uuid',$usuario);
                $plan = $this->db->get('PLAN')->result_array();

                foreach ($plan as $key => $value) {
                    array_push($planes, $value['segmento_cod']);
                }
                // CONSULTO LOS SEGMENTO DEL PLAN
                $this->db->select('*');
                $this->db->where_in('SEGMENTO.cod_segmento',$planes);
                $segmento = $this->db->get('SEGMENTO')->result_array();
                // CONSULTO LAS LICITACIONES

                $this->db->select('LICITACION.CodigoExterno, LICITACION.Nombre,LICITACION.Descripcion as Descripcion Licitacion,LICITACION.Estado,LICITACION.Fechas_FechaCreacion, LICITACION_ITEM.LicitacionID, LICITACION_ITEM.Descripcion as Descripcion Item');
                $this->db->join('LICITACION_ITEM','LICITACION_ITEM.LicitacionID = LICITACION.CodigoExterno');
                $this->db->where('LICITACION.Fechas_FechaCreacion =', $fecha);
                $this->db->where('LICITACION.Estado','Publicada');
                $this->db->group_start();
                foreach ($segmento as $key => $value) {
                    $this->db->or_group_start();
                    $this->db->where('LICITACION_ITEM.CodigoCategoria >', $value['rango_inicio']);
                    $this->db->where('LICITACION_ITEM.CodigoCategoria <', $value['rango_final']);
                    $this->db->group_end();
                }
                $this->db->group_end();                
                $this->db->limit(100);

                $tmpLicitaciones = $this->db->get('LICITACION')->result_array();
                $licitacionResponse = [];

                foreach ($tmpLicitaciones as $key => $value) {
                    if(!array_key_exists($value['CodigoExterno'], $licitacionResponse)) {
                        $licitacion = [];
                        $licitacion["Nombre"] = $value['Nombre'];
                        $licitacion["CodigoExterno"] = $value['CodigoExterno'];
                        $licitacion["Descripcion"] = $value['Descripcion Licitacion'];
                        $licitacion["Fecha de publicacion"] = $value['Fechas_FechaCreacion'];                        
                        $licitacion["Items"] = [];
                        $licitacionResponse[$value['CodigoExterno']] = $licitacion;
                    }
                }
                foreach ($tmpLicitaciones as $key => $value) {
                    if(array_key_exists($value['LicitacionID'], $licitacionResponse)) {
                        $item = [];
                        $item["Descripcion"] = $value['Descripcion Item'];
                        array_push($licitacionResponse[$value['LicitacionID']]["Items"], $item);            
                    }
                }
                $response["licitacion"] = $licitacionResponse;
                return $response;
                //return $segmento;
            }
            public function find_licitaciones($fecha){
                $this->db->select('LICITACION.CodigoExterno,LICITACION.Nombre,LICITACION.Fechas_FechaCreacion,LICITACION.Estado,LICITACION.Comprador_RegionUnidad,LICITACION.montoestimado,LICITACION.Fechas_FechaCierre');
                $this->db->where('LICITACION.Fechas_FechaCreacion <=',$fecha);
                $this->db->where('LICITACION.Estado','Publicada');
                //$this->db->order_by("LICITACION.Fechas_FechaCierre","asc");
                $this->db->limit(500);
                $licitaciones = $this->db->get('LICITACION')->result_array();
                return $licitaciones;
            }
            public function find_licitacion2($usuario,$fecha){                
                // CONSULTO EL PLAN
                $planes = [];
                $this->db->select('*');
                $this->db->where('PLAN.usu_uuid',$usuario);
                $plan = $this->db->get('PLAN')->result_array();

                foreach ($plan as $key => $value) {
                    array_push($planes, $value['segmento_cod']);
                }
                // CONSULTO LOS SEGMENTO DEL PLAN
                $this->db->select('*');
                $this->db->where_in('SEGMENTO.cod_segmento',$planes);
                $segmento = $this->db->get('SEGMENTO')->result_array();
                // CONSULTO LAS LICITACIONES

                $this->db->select('LICITACION_ITEM.LicitacionID,LICITACION_ITEM.Descripcion as Descripcion_Item, LICITACION_ITEM.CodigoCategoria,LICITACION_ITEM.NombreProducto');
                $this->db->join('LICITACION','LICITACION.CodigoExterno = LICITACION_ITEM.LicitacionID');
                $this->db->where('LICITACION.Fechas_FechaCreacion <=', $fecha);
                $this->db->where('LICITACION.CodigoEstado', 5);
                $this->db->group_start();
                foreach ($segmento as $key => $value) {
                    $this->db->or_group_start();
                    $this->db->where('LICITACION_ITEM.CodigoCategoria >', $value['rango_inicio']);
                    $this->db->where('LICITACION_ITEM.CodigoCategoria <', $value['rango_final']);
                    $this->db->group_end();
                }
                $this->db->group_end();                
                $this->db->limit(500);

                $tmpLicitaciones = $this->db->get('LICITACION_ITEM')->result_array();
                
                return $tmpLicitaciones;
                //return $segmento;
            }
            //funcion correcta para buscar las licitaciones acorde a las busquedas de los clientes
            public function find_licitacion_bycodigo($usuario,$fecha,$tipos){                
                // CONSULTO EL PLAN
                $fecha2 = date("Y-m-d",strtotime($fecha."- 1 month"));
                //$fecha2 = date('2014-01-01');
                $planes = [];
                $error = null;
                $this->db->select('distinct (BUSQUEDA.segmento_cod)');
                $this->db->where('BUSQUEDA.usu_uuid',$usuario);
                $this->db->where('BUSQUEDA.status',1);
                $plan = $this->db->get('BUSQUEDA')->result_array();                
                foreach ($plan as $value) {
                    array_push($planes, $value['segmento_cod']);
                }             
                // CONSULTO LAS LICITACIONES
                if ($planes != null) {
                    $this->db->select('distinct(LICITACION.CodigoExterno),LICITACION.Nombre,LICITACION.Fechas_FechaPublicacion,LICITACION.Estado,LICITACION.Comprador_RegionUnidad,LICITACION.montoestimado,LICITACION.Fechas_FechaCierre,LICITACION_ITEM.CodigoCategoria,LICITACION.Moneda,LICITACION.Tipo');
                    $this->db->join('LICITACION_ITEM','LICITACION_ITEM.LicitacionID = LICITACION.CodigoExterno');
                    $this->db->where('LICITACION.Fechas_FechaPublicacion <=', $fecha);
                    $this->db->where('LICITACION.Fechas_FechaPublicacion >=', $fecha2);
                    $this->db->where('LICITACION.Fechas_FechaCierre >', $fecha);
                    $this->db->where('LICITACION.CodigoEstado', 5);
                    if (isset($tipos) && !empty($tipos)) {                        
                        $tipasos = rtrim($tipos," ");
                        $cada_tipo = explode(" ", $tipasos);
                            if (count($cada_tipo) > 0) {
                                $this->db->where_in('LICITACION.Tipo', $cada_tipo);
                            }                                                    
                    }                    
                    $this->db->where_in('LICITACION_ITEM.CodigoCategoria',$planes);
                    $tmpLicitaciones = $this->db->get('LICITACION')->result_array();                    
                    return $tmpLicitaciones;
                }else {
                    return $error;
                }
                //return $segmento;
            }
            public function find_all_clientes($usu_uuid){
                $this->db->select('CLIENTE.nombre,CLIENTE.uuid');
                $this->db->where('CLIENTE.usu_uuid',$usu_uuid);
                $this->db->where('CLIENTE.status', 1);
                $busqueda = $this->db->get('CLIENTE')->result_array();
                return $busqueda;
            }
            public function find_busqueda_all_clientes($usu_uuid){
                $this->db->select('CLIENTE.nombre,BUSQUEDA.segmento_cod,BUSQUEDA.termino,CLIENTE.uuid,BUSQUEDA.tipos');
                $this->db->join('CLIENTE','CLIENTE.uuid = BUSQUEDA.cliente_uuid');
                $this->db->where('BUSQUEDA.usu_uuid',$usu_uuid);
                $this->db->where('BUSQUEDA.status',1);
                $this->db->where('CLIENTE.status', 1);                
                $busqueda = $this->db->get('BUSQUEDA')->result_array();
                return $busqueda;
            }
            public function add_notificacion($notificacion){
                $this->db->insert('NOTIFICACION', $notificacion);
            }
            public function update_notificacion($uuid_cliente,$codigo,$object){
                $status_notify = 0;
                foreach ($object as $value) {
                  $status_notify = $value;
                }
                $this->db->where('NOTIFICACION.cliente_uuid', $uuid_cliente);
                $this->db->where('NOTIFICACION.CodigoExterno', $codigo);
                if ($status_notify == 2) {
                    $this->db->where('NOTIFICACION.status', 1);
                }elseif($status_notify == 3){
                    $this->db->where('NOTIFICACION.status', 2);
                }elseif ($status_notify == 4) {
                    $this->db->where('NOTIFICACION.status', 2);                
              }
              $this->db->update('NOTIFICACION', $object);
            }
            public function verify_notificacion($uuid){
                $this->db->select('NOTIFICACION.CodigoExterno');
                $this->db->where('NOTIFICACION.cliente_uuid',$uuid);
                $this->db->where('NOTIFICACION.status !=',3);
                return $this->db->get('NOTIFICACION')->result_array();
            }            
            public function licitaciones_aldia($fecha,$fecha2){

                $this->db->select('distinct SUBSTRING(Fechas_FechaCreacion, 1, 10) as Fechas');
                $this->db->where('LICITACION.Fechas_FechaCreacion >=',$fecha);
                $this->db->where('LICITACION.Fechas_FechaCreacion <=',$fecha2);
                $this->db->order_by('Fechas_FechaCreacion');
                $Fechas = $this->db->get('LICITACION')->result_array();                
                return $Fechas;
            }
            
            public function ordenes_aldia($fecha,$fecha2){

                $this->db->select('distinct SUBSTRING(Fechas_FechaCreacion, 1, 10) as Fechas');
                $this->db->where('OCOMPRA.Fechas_FechaCreacion >=',$fecha);
                $this->db->where('OCOMPRA.Fechas_FechaCreacion <=',$fecha2);
                $this->db->order_by('Fechas_FechaCreacion');
                $Fechas = $this->db->get('OCOMPRA')->result_array();                
                return $Fechas;
            }
            public function tipos(){
                $this->db->select('*');
                $tipos=$this->db->get('TIPOS_LICITACIONES')->result_array();
                return $tipos;
            }


    }
    
    /* End of file Api_Model.php */
?>
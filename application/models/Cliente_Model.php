<?php
class Cliente_Model extends CI_Model {


  public function add($object){
    $this->db->insert('CLIENTE', $object);
  }

  public function delete($uuid=null){
    $this->db->where('uuid', $uuid);
    $this->db->delete('CLIENTE');
  }

  public function update($uuid=null,$object){
    $this->db->where('uuid', $uuid);
    $this->db->update('CLIENTE', $object);
  }
  
  public function get() {
    $this->db->select('*');
    $this->db->order_by("nombre", "asc");
    return $this->db->get('CLIENTE')->result_array();
  }

  function get_filtered_data($uuid){  
   $this->make_query($uuid);  
   $query = $this->db->get();  
   return $query->num_rows();  
 }   


 var $table = "CLIENTE";


 public function make_query($uuid)  
 {
   $table = "CLIENTE";
   $order_column = array("nombre",null, null);  
   $this->db->select("uuid as UUID, nombre,rut,email,status");  
   $this->db->order_by('nombre', 'asc');  
   $this->db->where('usu_uuid',$uuid);
          //   $this->db->join('perfil', 'perfil.uuid = usuario.perfil_uuid', 'left');
   $this->db->from('CLIENTE'); 
             #FILTROS PERSONALIZADOS
             #END FILTROS PERSONALIZADOSv

   if(isset($_POST["search"]["value"]) && $_POST["search"]["value"]!=null)  
   {  
    $search_string=$_POST["search"]["value"];
    $this->db->where("(CLIENTE.nombre LIKE '%".$search_string."%')", NULL, FALSE); 
                  // OR usuario.email LIKE '%".$search_string."%'  
  }  
  if(isset($_POST["order"]))  
  {  
    //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
  }  
  else  
  {  
    $this->db->order_by('nombre', 'asc');  
  } 
}  

public function make_datatables($uuid) {  

 $this->make_query($uuid);  

 if($_POST['length'] != -1)  
 {  
  $this->db->limit($_POST['length'], $_POST['start']);  
}  
$query = $this->db->get();  
return $query->result();  
} 


public function make_query_filtros($uuid)  
 {
   $table = "BUSQUEDA";
   //$order_column = array("nombre",null, null);  
   $this->db->select('SEGMENTO.nombre,BUSQUEDA.segmento_cod,BUSQUEDA.cliente_uuid');
   $this->db->join('SEGMENTO','SEGMENTO.cod_segmento = BUSQUEDA.segmento_cod');  
   $this->db->where('cliente_uuid',$uuid);
          //   $this->db->join('perfil', 'perfil.uuid = usuario.perfil_uuid', 'left');
   $this->db->from('BUSQUEDA'); 
             #FILTROS PERSONALIZADOS
             #END FILTROS PERSONALIZADOSv
   if(isset($_POST["search"]["value"]) && $_POST["search"]["value"]!=null)  
   {  
    $search_string=$_POST["search"]["value"];
    $this->db->where("(SEGMENTO.nombre LIKE '%".$search_string."%')", NULL, FALSE); 
                  // OR usuario.email LIKE '%".$search_string."%'  
  }  
  if(isset($_POST["order"]))  
  {  
    //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
  }  
  else  
  {  
    $this->db->order_by('SEGMENTO.nombre', 'asc');  
  } 
}
public function make_datatables_filtros($uuid) {  

 $this->make_query_filtros($uuid);  

 if($_POST['length'] != -1)  
 {  
  $this->db->limit($_POST['length'], $_POST['start']);  
}  
$query = $this->db->get();  
return $query->result();  
} 

public function get_clientes_useruuid($uuid){
  $this->db->select('*');
  $this->db->where('CLIENTE.usu_uuid',$uuid);
  $this->db->where('CLIENTE.status', 1);
  $clientes = $this->db->get('CLIENTE')->result_array();
  return $clientes;
}

public function get_filtros_clientes_useruuid($uuid){
  $this->db->select('BUSQUEDA.termino,BUSQUEDA.segmento_cod,BUSQUEDA.cliente_uuid,BUSQUEDA.id_busqueda,BUSQUEDA.tipos');
  $this->db->where('cliente_uuid',$uuid);
  $this->db->where('status',1);
  
  $busqueda = $this->db->get('BUSQUEDA')->result_array();
  return $busqueda;
}
public function get_filtros_clientes_useruuid_tipo($uuid){
  $this->db->select('BUSQUEDA.tipos');
  $this->db->where('cliente_uuid',$uuid);
  $this->db->where('status',1);
  $busqueda = $this->db->get('BUSQUEDA')->row_array();
  return $busqueda;
}
public function get_filtros_clientes_error($uuid_busqueda){
  $this->db->select('BUSQUEDA.termino,BUSQUEDA.segmento_cod,BUSQUEDA.cliente_uuid,BUSQUEDA.id_busqueda,BUSQUEDA.tipos');
  $this->db->where('uuid_busqueda',$uuid_busqueda);
  //$this->db->order_by("BUSQUEDA.termino", "asc");
  $busqueda = $this->db->get('BUSQUEDA')->result_array();
  return $busqueda;
}
public function get_filtros_clientes_error_tipo($uuid_busqueda){
  $this->db->select('BUSQUEDA.tipos');
  $this->db->where('uuid_busqueda',$uuid_busqueda);
  $busqueda = $this->db->get('BUSQUEDA')->row_array();
  return $busqueda;
}
public function get_clientes_error($uuid){
  $this->db->select('CLIENTE.nombre');
  $this->db->where('uuid',$uuid);
  $busqueda = $this->db->get('CLIENTE')->row_array();
  return $busqueda;
}
public function delete_busquedas($codigo,$uuid_busqueda){
  $this->db->where_not_in('BUSQUEDA.segmento_cod', $codigo);
  $this->db->where('BUSQUEDA.uuid_busqueda', $uuid_busqueda);
  $this->db->delete('BUSQUEDA');
}


function get_all_data($usu_uuid)  
{  
 $this->db->select("*");
 $this->db->where('usu_uuid',$usu_uuid);  
 $this->db->from($this->table);  
 return $this->db->count_all_results();  
}  

function get_all_data_busquedas($uuid_usu)  
{  
  $this->db->select("distinct(BUSQUEDA.cliente_uuid) as clientes");
  $this->db->join("CLIENTE","CLIENTE.uuid = BUSQUEDA.cliente_uuid");  
  $this->db->where("CLIENTE.status",1);
  $this->db->where("BUSQUEDA.usu_uuid",$uuid_usu);
  $this->db->get('BUSQUEDA');   
 return $this->db->count_all_results();  
} 
function get_filtered_data_busqueda($uuid){ 

  $this->db->select("distinct(BUSQUEDA.cliente_uuid) as clientes");
  $this->db->join("CLIENTE","CLIENTE.uuid = BUSQUEDA.cliente_uuid");  
  $this->db->where("CLIENTE.status",1);
  $this->db->where("BUSQUEDA.usu_uuid",$uuid);
  $query = $this->db->get('BUSQUEDA');  
  return $query->num_rows();  

} 


public function get_cliente_byuuid($uuid_cliente){

  $this->db->select('CLIENTE.uuid,CLIENTE.nombre,CLIENTE.rut,CLIENTE.email');
  $this->db->where('CLIENTE.uuid',$uuid_cliente);
  $cliente = $this->db->get('CLIENTE')->row_array();
  return $cliente;
}
public function verify_email_update($email,$uuid){
          $this->db->select('*');
          $this->db->where('email', $email);
          $this->db->where('uuid !=', $uuid);
          return $this->db->get('CLIENTE')->row_array();          
       }
public function verify_rut_update($rut,$uuid){
          $this->db->select('*');
          $this->db->where('rut', $rut);
          $this->db->where('uuid !=', $uuid);
          return $this->db->get('CLIENTE')->row_array();          
       }       
public function clientes_usuario($uuid){
  $this->db->select('CLIENTE.nombre,CLIENTE.email,CLIENTE.status,CLIENTE.rut');
  $this->db->where('CLIENTE.usu_uuid',$uuid);
  $this->db->order_by("nombre", "asc");
  $clientes = $this->db->get('CLIENTE')->result_array();
  return $clientes;
}      
public function busqueda_clientes_licitaciones($termino){
  $this->db->select('distinct(CATEGORIAS.Items_CodigoCategoria) as codigo, CATEGORIAS.Items_Categoria as nombre');
  $this->db->like('CATEGORIAS.Items_Categoria', $termino, 'both');
  $this->db->order_by("CATEGORIAS.Items_Categoria", "asc");
  $licitaciones = $this->db->get('CATEGORIAS')->result_array();
  return $licitaciones;
}
public function find_filtros_clientes($uuid){
  $this->db->select('BUSQUEDA.segmento_cod as codigo');
  $this->db->where('BUSQUEDA.cliente_uuid',$uuid);
  $this->db->where('BUSQUEDA.status', 1);
  $filtros = $this->db->get('BUSQUEDA')->result_array();
  return $filtros;
}
public function delete_busqueda($uuid_cliente,$usu_uuid){
  $this->db->where('cliente_uuid', $uuid_cliente);
  $this->db->where('usu_uuid', $usu_uuid);
  $this->db->delete('BUSQUEDA');
}
public function update_busqueda($uuid_cliente,$object){
  $this->db->where('cliente_uuid', $uuid_cliente);
  $this->db->update('BUSQUEDA', $object);
}

public function update_busqueda_byuuid_busqueda($uuid_busqueda,$object){
  $this->db->where('uuid_busqueda', $uuid_busqueda);
  $this->db->update('BUSQUEDA', $object);
}

public function all_users(){
  $this->db->select('USUARIO.uuid,USUARIO.email');
  $this->db->where('USUARIO.status',1);
  $usuarios = $this->db->get('USUARIO')->result_array();
  return $usuarios;
}

public function insert_pago($object){
  $this->db->insert('PAGOS', $object);
}
public function insert_horario($object){
  $this->db->insert('HORARIOS_CORREO', $object);
}
public function update_horario($usu_uuid,$object){
  $this->db->where('usu_uuid', $usu_uuid);
  $this->db->update('HORARIOS_CORREO', $object);
}
public function find_horarios_usuario($uuid){
  $this->db->select('HORARIOS_CORREO.dias as dia, HORARIOS_CORREO.hora');
  $this->db->where('HORARIOS_CORREO.usu_uuid',$uuid);
  $filtros = $this->db->get('HORARIOS_CORREO')->result_array();
  return $filtros;
}
public function find_horarios_usuario_dias($uuid){
  $this->db->select('HORARIOS_CORREO.dias as dia');
  $this->db->where('HORARIOS_CORREO.usu_uuid',$uuid);
  $horario = $this->db->get('HORARIOS_CORREO')->row_array();
  return $horario;
}
public function find_horarios_usuario_horas($uuid){
  $this->db->select('HORARIOS_CORREO.hora as horas');
  $this->db->where('HORARIOS_CORREO.usu_uuid',$uuid);
  $horario = $this->db->get('HORARIOS_CORREO')->row_array();
  return $horario;
}

public function datos_compra($uuid_busqueda,$uuid_usu){
  $this->db->select('distinct(BUSQUEDA.numero_orden),USUARIO.nombre,USUARIO.email');
  $this->db->join('USUARIO','USUARIO.uuid = BUSQUEDA.usu_uuid'); 
  $this->db->where('BUSQUEDA.usu_uuid',$uuid_usu); 
  $this->db->where('BUSQUEDA.uuid_busqueda',$uuid_busqueda);
  $compra = $this->db->get('BUSQUEDA')->row_array();
  return $compra;
}
public function find_busqueda_pagada($uuid_busqueda){
  $this->db->select('distinct(BUSQUEDA.tipos),BUSQUEDA.termino');
  $this->db->where('BUSQUEDA.uuid_busqueda',$uuid_busqueda);
  $busquedas = $this->db->get('BUSQUEDA')->result_array();
  return $busquedas;
}


public function moleculas(){
  $fecha = date("Y-m-d");
  $cat_medicamentos = [];
  $this->db->select('CATEGORIAS.Items_CodigoCategoria');
  $this->db->where('CATEGORIAS.Items_CodigoCategoria >=', '50000000');
  $this->db->where('CATEGORIAS.Items_CodigoCategoria <=', '59999999');
  $categoria = $this->db->get('CATEGORIAS')->result_array();
  foreach ($categoria as $key => $value) {
    array_push($cat_medicamentos, $value['Items_CodigoCategoria']);
  }
  $codigo_items_oc = [];
  $this->db->select('OCOMPRA.Codigo,OCOMPRA.Comprador_FonoContacto,OCOMPRA.Comprador_MailContacto,OCOMPRA.Comprador_ComunaUnidad, OCOMPRA.Comprador_NombreOrganismo, OCOMPRA.Comprador_RutUnidad,OCOMPRA.Proveedor_Nombre,OCOMPRA.Proveedor_RutSucursal,OCOMPRA.Proveedor_Comuna,OCOMPRA.Proveedor_FonoContacto,OCOMPRA.Proveedor_MailContacto,OCOMPRA.Fechas_FechaCreacion,OCOMPRA_ITEM.OCompraID, OCOMPRA_ITEM.Items_Producto, OCOMPRA_ITEM.Items_Cantidad, OCOMPRA_ITEM.Items_EspecificacionComprador,OCOMPRA_ITEM.Items_Total');
  $this->db->join('OCOMPRA_ITEM','OCOMPRA_ITEM.OCompraID = OCOMPRA.Codigo');
  $this->db->where('OCOMPRA.Fechas_FechaCreacion >=','2017-10-01 00:00:00');
  //$this->db->where('OCOMPRA.Fechas_FechaCreacion <=', $fecha);
  $this->db->where_in('OCOMPRA_ITEM.Items_CodigoCategoria',$cat_medicamentos);
  //https://www.msdmanuals.com/es-cl/hogar/ap%C3%A9ndices/nombres-de-los-medicamentos-gen%C3%A9rico-y-comercial/nombre-de-los-medicamentos-gen%C3%A9rico-y-comercial
  $this->db->group_start();
  $this->db->like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Anfotericina B');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'ABELCET');  
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'FUNGIZONE');  
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'AMBISOME');  
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Caspofungina');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'CANCIDAS');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Micafungina');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'MYCAMINE');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Anidulafungina');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'ECALTA');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'ERAXIS');
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Voriconazol');    
  $this->db->or_like('OCOMPRA_ITEM.Items_EspecificacionComprador', 'Vfend');
  $this->db->group_end(); 
  //$this->db->limit(1000);
  $ordenes_compra = $this->db->get('OCOMPRA')->result_array();
  $ordenesResponse = [];
  foreach ($ordenes_compra as $key => $value) {
      if(!array_key_exists($value['Codigo'], $ordenesResponse)) {
        if ($value['Fechas_FechaCreacion'] == null) {
          $value['Fechas_FechaCreacion'] = "Sin asignar";
        }
          $orden = [];          
          $orden["Nombre_comprador"] = $value['Comprador_NombreOrganismo'];
          $orden["Rut_comprador"] = $value['Comprador_RutUnidad']; 
          $orden["Comuna_comprador"] = $value['Comprador_ComunaUnidad']; 
          $orden["Telefono_comprador"] = $value['Comprador_FonoContacto'];  
          $orden["Correo_comprador"] = $value['Comprador_MailContacto']; 
          $orden["Proveedor"] = $value['Proveedor_Nombre'];  
          $orden["Rut_proveedor"] = $value['Proveedor_RutSucursal'];                  
          $orden["Comuna_proveedor"] = $value['Proveedor_Comuna'];
          $orden["Telefono_proveedor"] = $value['Proveedor_FonoContacto'];
          $orden["Correo_proveedor"] = $value['Proveedor_MailContacto'];
          $orden["Fechas_FechaCreacion"] = $value['Fechas_FechaCreacion'];
          $orden["Items"] = [];
          $ordenesResponse[$value['Codigo']] = $orden;
      }
  }
  foreach ($ordenes_compra as $key => $value) {
      if(array_key_exists($value['OCompraID'], $ordenesResponse)) {
          $item = [];
          $item["ID_OCompra"] = $value['OCompraID'];
          $item["Producto"] = $value['Items_Producto'];
          $item["Cantidad"] = $value['Items_Cantidad'];
          $item["Especificacion"] = $value['Items_EspecificacionComprador'];
          $item["Total"] = $value['Items_Total'];
          array_push($ordenesResponse[$value['OCompraID']]["Items"], $item);            
      }
  }
  $response["Ordenes_compra"] = $ordenesResponse;
  return $ordenes_compra;
}

}
?>
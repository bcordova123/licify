<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Usuario_Model extends CI_Model {

        /*DATA TABLES*/
        var $table = "USUARIO";  
        var $order_column = array(null, "USUARIO.nombre","USUARIO.email","PERFIL.nombre","USUARIO.status",null,null);  
        
        function make_query()  
        {
             $this->db->select('USUARIO.*, PERFIL.nombre as "perfil", USUARIO.nombre as "nombre_usuario"');  
             $this->db->join('PERFIL', 'PERFIL.uuid = USUARIO.perfil_uuid', 'left');
             $this->db->from($this->table); 
             
             #FILTROS PERSONALIZADOS
             
             #END FILTROS PERSONALIZADOS

             if(isset($_POST["search"]["value"]) && $_POST["search"]["value"]!=null)  
             {  
                  $search_string=$_POST["search"]["value"];
                  $this->db->where("(USUARIO.nombre LIKE '%".$search_string."%' OR PERFIL.nombre LIKE '%".$search_string."%' OR USUARIO.apellidos LIKE '%".$search_string."%' OR USUARIO.email LIKE '%".$search_string."%')", NULL, FALSE);   
             }  
             if(isset($_POST["order"]))  
             {  
                  $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
             }  
             else  
             {  
                  $this->db->order_by('USUARIO.nombre', 'asc');  
             } 
           
        }  

        function make_datatables(){  
             $this->make_query();  

             if($_POST["length"] != -1)  
             {  
                  $this->db->limit($_POST['length'], $_POST['start']);  
             }  
             $query = $this->db->get();  
             return $query->result();  
        } 

        function get_filtered_data(){  
             $this->make_query();  
             $query = $this->db->get();  
             return $query->num_rows();  
        }   
            
        function get_all_data()  
        {  
             $this->db->select("*");  
             $this->db->from($this->table);  
             return $this->db->count_all_results();  
        }  
        /*END DATA TABLES*/
    
        public function get_perfiles(){
             $this->db->select('*');
             $this->db->order_by('nombre', 'asc');
             return $this->db->get('PERFIL')->result_array();
        }

        public function add($usuario) {
          $this->db->insert('USUARIO', $usuario);          
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

       public function verify_email_update($email,$uuid){

          $this->db->select('*');
          $this->db->where('email', $email);
          $this->db->where('uuid !=', $uuid);
          return $this->db->get('USUARIO')->row_array();
          
       }

       public function update($uuid,$usuario){
          $this->db->where('uuid', $uuid);  
          $this->db->update('USUARIO', $usuario);
       }
       public function get_email_user($uuid){
          $this->db->select('USUARIO.email');
          $this->db->where('uuid', $uuid);
          return $this->db->get('USUARIO')->row_array();
       }


    }
    
    /* End of file Usuario_Model.php */
    
?>
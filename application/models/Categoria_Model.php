<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Categoria_Model extends CI_Model {
      
        /*DATA TABLES*/
        var $table = "CATEGORIAS";  
       // var $order_column = array(null, "plan.nombre","plan.email","perfil.nombre","plan.status",null,null);  
        

        function get_filtered_data(){  
             $this->make_query();  
             $query = $this->db->get();  
             return $query->num_rows();  
        }       
        function get_all_data()  
        {  
             $this->db->select("*");  
             return $this->db->get('CATEGORIAS')->result_array();
        }  
        /*END DATA TABLES*/

        public function add($categoria){
          $t=$this->db->insert('CATEGORIAS', $categoria);    
          return $t;      
        }


        public function get_planes(){
          $this->db->select('*');
          return $this->db->get('CATEGORIAS')->row_array();
       }

       public function get_plan_by_id($idCategoria){
          $this->db->select('*');
          $this->db->where('Items_CodigoCategoria', $idCategoria);
          return $this->db->get('CATEGORIAS')->row_array();
       }

     
       public function update($idCategoria, $plan){
          $this->db->where('Items_CodigoCategoria', $idCategoria);  
          $this->db->update('CATEGORIAS', $plan);
       }
    }
    
    /* End of file Plan_Model.php */
    
?>
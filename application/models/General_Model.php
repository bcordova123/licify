<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class General_Model extends CI_Model {
    
        public function uuid()
        {
            $query = $this->db->query('select uuid() as "uuid"');
            $result=$query->row_array();
            return $result["uuid"];           
        }
    
    }
    
    /* End of file General_Model.php */
    
?>
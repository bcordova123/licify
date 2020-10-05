<?php

class Modelo_general extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function uuid(){
            $query = $this->db->query('select uuid() as "uuid"');
            $result=$query->row_array();
            return $result["uuid"];   
        }

}

?>
<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Auth_Model extends CI_Model {
    
        public function login($email, $password){

            $this->db->select('*');
            $this->db->where('email', $email);
            $this->db->where('clave', sha1($password));
            $this->db->where('status', 1);
            
                        
            return $this->db->get('USUARIO')->row_array();
            
            
        }

        public function forgotPass($email){

            $this->db->select('*');
            $this->db->where('email', $email);
            $this->db->where('status', 1);

            return $this->db->get('USUARIO')->row_array();
            
            
        }

        public function insertPass($object){

            $this->db->insert('RECUPERAR_PASSWORD', $object);
            
        }

        public function verifyRePass($uuid){

            $this->db->select('*');
            $this->db->where('uuid', $uuid);
            $this->db->where('fecha_uso', null);
            $this->db->where('status', 0);
            return $this->db->get('RECUPERAR_PASSWORD') ->row_array();
  
        }
        public function updateRePass($uuid,$object){

            $this->db->where('uuid', $uuid);
            $this->db->update('RECUPERAR_PASSWORD', $object);
            
        }
        public function anularRePass($usuario_uuid){

            $this->db->where('usuario_uuid', $usuario_uuid);
            $this->db->update('RECUPERAR_PASSWORD', ["status"=>1]);
            
        }
        public function updateUser($uuid,$object){

            $this->db->where('uuid', $uuid);
            $this->db->update('USUARIO', $object);
            
        }
       

    }
    
    /* End of file Auth.php */
    
?>
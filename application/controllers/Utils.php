<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Utils extends CI_Controller {
        public function __construct()
        {
          parent::__construct();
        }      
    
        public function index()
        {
            is_login();
        }

        public function error_404() {
            is_login();
            $this->load->view('cuenta/facturacion');
        }

        public function loading() {
            is_login();
            $this->load->view('comun/loading', null);
        }

    }
    /* End of file Controllername.php */
?>
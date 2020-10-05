<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    require_once(APPPATH."third_party/dompdf/autoload.inc.php");
    
    class Facturacion extends CI_Controller {
        public function __construct()
        {
          parent::__construct();
          $this->load->model('Usuario_Model');
          $this->load->model('Cliente_Model');
          $this->load->model('Api_Model');
          $this->load->model('Facturacion_Model');
        }      
    
        public function index()
        {
            is_login();

            $user = $this->session->userdata('usuario')['uuid'];

            $data = [];
            $data["pagos"] = $this->Facturacion_Model->get_pagos_by_user($user);
            
            $this->load->view('cuenta/facturacion', $data);
            
        }


        public function verVoucher() {

            $voucher = $this->Facturacion_Model->get_voucher(15731889431959243);
            $data["voucher"] = $voucher;
            $data["usuario"] = $this->Usuario_Model->get_user($voucher[0]["usu_uuid"]);

            $this->load->view('cuenta/voucher', $data);
        }

        public function voucher($nroBoleta) {
            is_login();

            if($nroBoleta == null) {
                echo "ERROR";
            } else {
               // $this->generarVoucher(15731518590801580);
                $this->generarVoucher($nroBoleta);
            }
        }


        private function generarVoucher($nroBoleta) {
                set_time_limit(0);

                $options = new Dompdf\Options();
                $options->set('isRemoteEnabled', true);
                $dompdf=new Dompdf\Dompdf($options);
                
                $data["titulo"] = "Boleta_".$nroBoleta;
                $voucher = $this->Facturacion_Model->get_voucher($nroBoleta);
                $data["voucher"]=$voucher;
                $data["usuario"] = $this->Usuario_Model->get_user("ac8114d4-9de8-11e9-b04e-ba761658d185"); //   $voucher[0]["usu_uuid"]);

                // LOAD HTML CONTENT
                $htmlcontent = $this->load->view('cuenta/voucher', $data, TRUE);
                $dompdf->load_html($htmlcontent);

                $dompdf->setPaper('A4','portrait');
                $dompdf->render();
                $out = $dompdf->output(); #ALMACENAR PDF EN VARIABLE

                file_put_contents('./uploads/Boleta_'.$nroBoleta.'.pdf', $out);


              //  $dompdf->stream("Boleta_".$nroBoleta, array('Attachment'=>1));
                //unlink('./uploads/cotizacion_'.$id_unica.'.pdf');
            
         
        }

        
    }
    /* End of file Controllername.php */
?>
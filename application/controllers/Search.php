<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Search extends CI_Controller {
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
            
        }

        public function buscar($codigo) {
            is_login();
            $response = $this->traerLicitacion($codigo);

            if($response["found"]) {

                $data = [];
                $data["licitacion"] = $response;
                $data["follow"] = false;

                $this->load->view("licitaciones/detalle", $data);
                return;

            } else {
                $response = $this->traerOcompra($codigo);

                if($response["found"]) {

                    $data = [];
                    $data["ocompra"] = $response;
                    $data["follow"] = false;

                    $this->load->view("licitaciones/detalle", $data);
                    return;
                } else {
                    header("HTTP/1.1 404 Not Found");
                    return  print_r("404");
                }
            }
        }


        // METODO QUE BUSCA EN TODOS LADOS
        public function buscar2($query, $state, $tipo, $region) {
            is_login();
            $query = str_replace("%20", " ", $query);
            $region = str_replace("slash", "/", $region);

            switch($state) {
                case "TODOS":
                    $state = "";
                break;
                case "Publicada":
                case "Cerrada":
                case "Adjudicada":
                case "Desierta":
                case "Revocada":
                case "Suspendida":
                    $state = "{\"query_string\":{\"fields\":[\"Estado\"],\"query\":\"".$state."\"}},";
                break;
                default:
                    return print_r("OPCION NO VALIDA");
            }

            switch($tipo) {
                case "TODOS":
                    $tipo = "";
                break;
                case "L1":
                case "LE":
                case "LP":
                case "LQ":
                case "LR":
                case "LS":
                case "O1":
                case "E2":
                case "CO":
                case "B2":
                case "H2":
                case "I2":
                case "O2":
                    $tipo = "{\"query_string\":{\"fields\":[\"Tipo\"],\"query\":\"".$tipo."\"}},";
                break;
                default:
                    return print_r("OPCION NO VALIDA");
            }


            if($region == "TODOS") {
                $region = "";
            } else {
                switch($region) {
                    case "1": 
                        $region = "Región Metropolitana de Santiago";
                    break;
                    case "2":
                        $region = "Región Aysén del General Carlos Ibáñez del Campo";
                    break;
                    case "3": 
                        $region ="Región de Antofagasta";
                    break;
                    case "4": 
                        $region = "Región de Arica y Parinacota";
                    break;
                    case "5": 
                        $region = "Región de Atacama";
                    break;
                    case "6": 
                        $region = "Región de Coquimbo";
                    break;
                    case "7": 
                        $region = "Región de la Araucanía";
                    break;
                    case "8": 
                        $region = "Región de los Lagos";
                    break;
                    case "9": 
                        $region = "Región de Los Ríos";
                    break;
                    case "10": 
                        $region = "Región de Magallanes y de la Antártica";
                    break;
                    case "11": 
                        $region = "Región de Tarapacá";
                    break;
                    case "12": 
                        $region = "Región de Valparaíso";
                    break;
                    case "13":
                        $region = "Región del Biobío";
                    break;
                    case "14": 
                        $region = "Región del Libertador General Bernardo O´Higgins";
                    break;
                    case "15": 
                        $region = "Región del Maule";
                    break;
                    case "16": 
                        $region = "Región del Ñuble";
                    break;
                    default:
                        return print_r("OPCION NO VALIDA");
                }
                $region = "{\"multi_match\":{\"query\":\"".$region."\",\"operator\":\"AND\",\"fields\":[\"Comprador_RegionUnidad\"]}},";
            }

            

            $resultado = $this->complexQuerySearch($query, $state, $tipo, $region);

            $data["hits"] = $resultado["hits"]["total"]["value"];
            $data["licitaciones"] = $resultado;

            $this->load->view("licitaciones/listar", $data);
        }


        private function complexQuerySearch($query, $state, $tipo, $region) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/licitaciones/_search');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"track_total_hits\":true,\"size\":20,\"sort\":[{\"Fechas_FechaPublicacion\":{\"order\":\"desc\"}}],\"query\":{\"bool\":{\"must\":[".$state.$tipo.$region."{\"multi_match\":{\"query\":\"".$query."\",\"operator\":\"AND\",\"fields\":[\"CodigoExterno.keyword\",\"Nombre\",\"Descripcion\",\"Comprador_NombreOrganismo\",\"Items.Categoria\",\"Items.Descripcion\",\"Items.Adjudicacion.RutProveedor\",\"Items.Adjudicacion.NombreProveedor\"]}}]}}}");


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
                throw new Exception();
            }
            curl_close($ch);

            return json_decode($result, true);

        }




        private function traerLicitacion($codigo) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/licitaciones/_doc/'.$codigo);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

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
                throw new Exception();
            }
            curl_close($ch);

            return json_decode($result, true);
        }

        private function traerOcompra($codigo) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://22d2c60dd33443c5b078165261156ae7.us-east-1.aws.found.io:9243/ocompra/_doc/'.$codigo);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

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
                throw new Exception();
            }
            curl_close($ch);

            return json_decode($result, true);
            
        }

        public function follow() {

        }

        
    }
    /* End of file Controllername.php */
?>
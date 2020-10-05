<?php

class Facturacion_Model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
        }

        public function uuid(){
            $query = $this->db->query('select uuid() as "uuid"');
            $result=$query->row_array();
            return $result["uuid"];   
        }


        public function get_pagos_by_user($uuid) {
            $this->db->select('PAGOS.numero_orden, PAGOS.fecha_pago, PAGOS.tipo_pago, CLIENTE.nombre as "cliente"' );
            $this->db->from('PAGOS');
            $this->db->join('BUSQUEDA', 'BUSQUEDA.uuid_busqueda = PAGOS.busqueda_uuid');
            $this->db->join('CLIENTE', 'CLIENTE.uuid = BUSQUEDA.cliente_uuid');
            $this->db->where('PAGOS.usu_uuid', $uuid);
            $this->db->group_by(array("PAGOS.numero_orden", "PAGOS.fecha_pago", "PAGOS.tipo_pago", "CLIENTE.nombre"));

            return $this->db->get()->result_array();   
        }

        public function get_voucher($nroBoleta) {
            $this->db->select('*');
            $this->db->from('PAGOS');
            $this->db->join('BUSQUEDA', 'BUSQUEDA.uuid_busqueda = PAGOS.busqueda_uuid');
            $this->db->join('CLIENTE', 'CLIENTE.uuid = BUSQUEDA.cliente_uuid');
            $this->db->where('PAGOS.numero_orden', $nroBoleta);
            $this->db->limit(500);
        //    $this->db->group_by(array("PAGOS.numero_orden", "PAGOS.fecha_pago", "PAGOS.tipo_pago", "CLIENTE.nombre"));

            return $this->db->get()->result_array();   
        }


        


}

?>
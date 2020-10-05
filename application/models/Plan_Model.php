<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Plan_Model extends CI_Model
{

    /*DATA TABLES*/
    var $table = "PLANES";
    // var $order_column = array(null, "plan.nombre","plan.email","perfil.nombre","plan.status",null,null);
    

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this
            ->db
            ->get();
        return $query->num_rows();
    }
    function get_all_data()
    {
        $this
            ->db
            ->select("*");
        return $this
            ->db
            ->get('PLANES')
            ->result_array();
    }
    /*END DATA TABLES*/

    public function add($plan)
    {
        return $this
            ->db
            ->insert('PLANES', $plan);
    }

    public function get_planes($uuid)
    {
        $this
            ->db
            ->select('*');
        return $this
            ->db
            ->get('PLANES')
            ->row_array();
    }

    public function update($uuid, $plan)
    {
        $this
            ->db
            ->where('uuid', $uuid);
        $this
            ->db
            ->update('PLANES', $plan);
    }

    public function make_query()
    {

        $table = "PLANES";
        $order_column = array(
            "cl.nombre",
            null,
            null
        );

        $this
            ->db
            ->select('PLANES.uuid as "uuid", CLIENTE.nombre as "nombre", PLANES.id_categoria as "id_categoria", CATEGORIAS.Items_Categoria as "categoria"');
        $this
            ->db
            ->join('CLIENTE', 'CLIENTE.uuid = PLANES.id_cliente', 'left');
        $this
            ->db
            ->join('CATEGORIAS', 'CATEGORIAS.Items_CodigoCategoria = PLANES.id_categoria', 'left');
        $this
            ->db
            ->from($table);

        #FILTROS PERSONALIZADOS
        #END FILTROS PERSONALIZADOS
        if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != null)
        {
            $search_string = $_POST["search"]["value"];
            $this
                ->db
                ->where("(CLIENTE.nombre LIKE '%" . $search_string . "%')", NULL, false);
            // OR usuario.email LIKE '%".$search_string."%'
            
        }
        if (isset($_POST["order"]))
        {
            $this
                ->db
                ->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else
        {
            $this
                ->db
                ->order_by('nombre', 'asc');
        }

    }

    public function make_datatables()
    {
        $this->make_query();

        if ($_POST['length'] != - 1)
        {
            $this
                ->db
                ->limit($_POST['length'], $_POST['start']);
        }
        $query = $this
            ->db
            ->get();
        return $query->result();
    }

}

/* End of file Plan_Model.php */

?>

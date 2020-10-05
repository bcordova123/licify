<?php
class Categorias extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Cliente_Model');
  }


  public function view_add(){
    $data["page_name"]="Nuevo registro categoria";
    $this->load->view("cliente_view/add", $data);
  }
  public function index(){

    $resultado = $this->Categorias_Model->get();

    $data["page_name"]="Listar registros de categorias";
    $data["datos"]=$resultado;

    $this->load->view("categorias/list", $data);

  }

  public function add() {

    $object=[];

    $nombre=trim($this->input->post("nombre"));
    $object["nombre"]=$nombre;


    $query = $this->db->query('select uuid() as "uuid"');
    $result=$query->row_array();
    $uuid=$result["uuid"]; 
    $object["uuid"] = $uuid;

    $this->Cliente_model->add($object);
    $this->session->set_flashdata("exito","Registro creado exitosamente");
    redirect("categoria","refresh");
  }
  
  public function delete(){

  }

  

  public function fetch_category() {  
            perfil_superior();
            $fetch_data = $this->Categorias_Model->make_datatables();  
            $data = array();

            foreach($fetch_data as $row)  
            {  
                 $sub_array = array();  
                 $sub_array[] = $row->nombre;
                 
                 $sub_array[] = '<a href="'.base_url().'Cliente_controller/view_modificar/'.$row->UUID.'" class="btn btn-warning">Ver</a>';  

                 $sub_array[] = '<a href="'.base_url().'Cliente_controller/view_modificar/'.$row->UUID.'" class="btn btn-warning">Ver</a>';  
                
                 $data[] = $sub_array;  
            }  
            $output = array(  
                 "draw"                    =>     intval($_POST["draw"]),  
                 "recordsTotal"          =>      $this->Categorias_Model->get_all_data(),  
                 "recordsFiltered"     =>     $this->Categorias_Model->get_filtered_data(),  
                 "data"                    =>     $data  
            );  
          //  var_dump($output);
          //  die();
            //echo $this->db->last_query(); die();
            echo json_encode($output);  
       }  
}
?>
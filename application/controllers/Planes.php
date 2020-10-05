<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Planes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_Model');
        $this
            ->load
            ->model('Plan_Model');
        $this
            ->load
            ->model('Categoria_Model');
        $this
            ->load
            ->model('Cliente_Model');

    }

    /* Listar planes */
    public function index()
    {
        perfil_superior();
        $data["page_name"] = "Crear nuevo Plan";

        $this
            ->load
            ->view('plan/listar', $data);
    }



    public function enviarMail($idCliente) {
            
            $mensaje = "AQUI VA TODO 2";
            $para =  "asalas@saargo.com";//$email;
            $url = base_url();
            $boton = "Ir al portal";
            $asunto = "BOTS";
            
            email($mensaje,$para,$url,$boton,$asunto,"password");
    }


    public function crear_plan()
    {
        $cliente = $this
            ->input
            ->post('cliente');
        $aux_plan = $this
            ->input
            ->post('tags');
        $tags = json_decode($aux_plan, true);
        if (count($tags) < 1)
        {
            $this
                ->session
                ->set_flashdata("error", "Sin planes a registrar");
        }
        else
        {
            // DELETE FIRST BEFORE ADD
            $isDeleted = $this
                ->db
                ->query('delete from PLANES where id_cliente = "' . $cliente . '"');

            if ($isDeleted)
            {
                foreach ($tags as $value)
                {

                    $idCategoria = trim(explode('|', $value['value']) [0]);

                    $query2 = $this
                        ->db
                        ->query('select uuid() as "uuid"');
                    $result = $query2->row_array();
                    $uuid = $result["uuid"];

                    $nuevoPlan = [];
                    $nuevoPlan["uuid"] = $uuid;
                    $nuevoPlan['id_cliente'] = $cliente;
                    $nuevoPlan['id_categoria'] = $idCategoria;
                    $t = $this
                        ->Plan_Model
                        ->add($nuevoPlan);
                }

                $this
                    ->session
                    ->set_flashdata("exito", "Plan creado exitosamente");

            }
            else
            {
                $this
                    ->session
                    ->set_flashdata("error", "Error inesperado");
            }
        }

        redirect("planes", "refresh");
    }

    /* Vista nuevo plan */
    public function view_nuevo()
    {
        perfil_superior();
        $data["page_name"] = "Nuevo plan";
        
        $data["clientes"] = $this
            ->Cliente_Model
            ->get();
        $data["categorias"] = $this
            ->Categoria_Model
            ->get_all_data();
        //$data["moleculas"] = $this->Cliente_Model->moleculas();
        $this
            ->load
            ->view('plan/nuevo', $data);
    }

    /*Vista modificar perfil de plan*/
    public function view_modificar($uuid = null)
    {
        is_login();
        if ($uuid == null)
        {
            redirect('planes/', 'refresh');
        }
        if ($this
            ->session
            ->userdata('perfil_uuid') == $this
            ->config
            ->item('uuid_vendedor'))
        { #SI USUARIO ES VENDEDOR NO PUEDE ACCEDER A OTROS UUID
            if ($uuid != $this
                ->session
                ->userdata('uuid'))
            {
                redirect('planes/', 'refresh');
            }
        }
        $data["page_name"] = "Modificar plan";
        $data["plan"] = $this
            ->Plan_Model
            ->get_user($uuid);
        if ($data["plan"] == null)
        {
            redirect('planes/', 'refresh');
        }
        $data["perfiles"] = $this
            ->Plan_Model
            ->get_perfiles();
        $this
            ->load
            ->view('plan/modificar', $data);
    }

    public function nuevo()
    {
        perfil_superior();
        $email = $this
            ->input
            ->post('email');
        $resultado = $this
            ->Plan_Model
            ->verify_email($email);
        if ($this
            ->input
            ->post() == null)
        {
            redirect('planes/view_nuevo', 'refresh');
        }
        if ($resultado != null)
        {
            $this
                ->session
                ->set_flashdata('mensaje_error', "El correo ingresado ya existe");

            redirect('planes/view_nuevo', 'refresh');

        }
        $uuid = $this
            ->General_Model
            ->uuid();
        $nombre = $this
            ->input
            ->post('nombre');
        $apellidos = $this
            ->input
            ->post('apellidos');
        $rut = $this
            ->input
            ->post('rut');
        $telefono = $this
            ->input
            ->post('telefono');
        $perfil_uuid = $this
            ->input
            ->post('perfil_uuid');
        $status = $this
            ->input
            ->post('status');

        if ($status != null)
        {
            $status = 1;
        }
        else
        {
            $status = 0;
        }

        $avatar = "assets/img/default.png";

        if ($_FILES['avatar']['size'] > 100)
        {
            $config['upload_path'] = './uploads/avatars';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
            $config['max_size'] = 3200;
            $config['file_name'] = $uuid;
            $this
                ->load
                ->library('upload', $config);
            if (!$this
                ->upload
                ->do_upload('avatar'))
            {
                $this
                    ->session
                    ->set_flashdata('mensaje_error', "Ocurrió un problema al subir el avatar");
            }
            else
            {
                $data = $this
                    ->upload
                    ->data();
                //$foto =  strstr($data["full_path"], "uploads/direcciones/");
                $avatar = strstr($data["full_path"], "uploads/avatars/");
            }
        }
        $pre_clave = uniqid();
        $clave = sha1(sha1($pre_clave));
        $plan = ["uuid" => $uuid, "nombre" => $nombre, "apellidos" => $apellidos, "rut" => $rut, "telefono" => $telefono, "email" => $email, "perfil_uuid" => $perfil_uuid, "status" => $status, "clave" => $clave, "avatar" => $avatar];

        $this
            ->Plan_Model
            ->add($plan);
        $this
            ->session
            ->set_flashdata('mensaje_exito', "Plan creado correctamente");
        $mensaje = "Estimado " . $nombre . "<br> las credenciales para su primer inicio de sesión son las siguentes <br> <strong> Plan: " . $email . "</strong> <br> <strong>Clave: " . $pre_clave . "</strong>";
        $para = $email;
        $url = base_url();
        $boton = "Ir al portal";
        $asunto = "CREDENCIALES DE ACCESO";

        email($mensaje, $para, $url, $boton, $asunto, "password");
        redirect('planes/index', 'refresh');

    }

    public function edit()
    {
        is_login();
        $uuid = $this
            ->input
            ->post('uuid_plan');
        $nombre = $this
            ->input
            ->post('nombre');
        $apellidos = $this
            ->input
            ->post('apellidos');
        $rut = $this
            ->input
            ->post('rut');
        $telefono = $this
            ->input
            ->post('telefono');

        $status = $this
            ->input
            ->post('status');

        $email = $this
            ->input
            ->post('email');
        $resultado = $this
            ->Plan_Model
            ->verify_email_update($email, $uuid);
        if ($this
            ->input
            ->post() == null)
        {

            redirect('planes/view_nuevo', 'refresh');
        }
        if ($resultado != null)
        {
            $this
                ->session
                ->set_flashdata('mensaje_error', "El correo ingresado ya existe");

            redirect('planes/view_nuevo', 'refresh');

        }

        if ($status != null)
        {
            $status = 1;
        }
        else
        {
            $status = 0;
        }
        $plan = ["uuid" => $uuid, "nombre" => $nombre, "apellidos" => $apellidos, "rut" => $rut, "telefono" => $telefono, "email" => $email, "status" => $status, "fecha_modificacion" => date('Y-m-d H:i:s') ];
        if ($this
            ->input
            ->post('perfil_uuid') != null)
        {
            $plan["perfil_uuid"] = $this
                ->input
                ->post('perfil_uuid');
        }
        if ($this
            ->input
            ->post('clave') != null)
        {
            $plan["clave"] = sha1(sha1($this
                ->input
                ->post('clave')));
        }
        $avatar = "";

        if (isset($_FILES['avatar']))
        {
            if ($_FILES['avatar']['size'] > 100)
            {
                $config['upload_path'] = './uploads/avatars';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
                $config['max_size'] = 3200;
                $config['file_name'] = $uuid;
                $this
                    ->load
                    ->library('upload', $config);
                if (!$this
                    ->upload
                    ->do_upload('avatar'))
                {
                    $this
                        ->session
                        ->set_flashdata('mensaje_error', "Ocurrió un problema al subir el avatar");
                }
                else
                {
                    $data = $this
                        ->upload
                        ->data();
                    //$foto =  strstr($data["full_path"], "uploads/direcciones/");
                    $avatar = strstr($data["full_path"], "uploads/avatars/");
                    $plan["avatar"] = $avatar;
                }
            }

        }

        $this
            ->Plan_Model
            ->update($uuid, $plan);

        $this
            ->session
            ->set_flashdata('mensaje_exito', "Plan actualizado");
        redirect('planes/view_modificar/' . $uuid, 'refresh');

    }

    /*AJAX*/
    function fetch_planes()
    {
        perfil_superior();
        $fetch_data = $this
            ->Plan_Model
            ->make_datatables();
        $data = array();
        foreach ($fetch_data as $row)
        {
            $sub_array = array();
            $sub_array[] = $row->nombre;
            $sub_array[] = $row->id_categoria;
            $sub_array[] = $row->categoria;

            $sub_array[] = '<a href="' . base_url() . 'planes/view_modificar/' . $row->uuid . '" class="btn btn-warning">Ver</a>';
            $sub_array[] = '<a href="' . base_url() . 'planes/view_modificar/' . $row->uuid . '" class="btn btn-warning">Ver</a>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]) ,
            "recordsTotal" => $this
                ->Plan_Model
                ->get_all_data() ,
            "recordsFiltered" => $this
                ->Plan_Model
                ->get_filtered_data() ,
            "data" => $data
        );
        //var_dump($output);
        //die();
        //echo $this->db->last_query(); die();
        echo json_encode($output);
    }

    /*
       Cambia el estado de un plan
    */
    function status($uuid)
    {
        perfil_superior();
        if ($uuid == $this
            ->session
            ->userdata('plan') ["uuid"])
        {
            #MENSAJE ERROR
            $this
                ->session
                ->set_flashdata('mensaje_error', "No puedes cambiar tu propio estado");
            redirect('planes/index', 'refresh');
        }
        $resultado = $this
            ->Plan_Model
            ->get_user($uuid);
        if ($resultado["status"] == 1)
        {
            $plan = ["status" => 0, "fecha_modificacion" => date('Y-m-d H:i:s') ];
            $mensaje = "Desactivado";
        }
        else
        {
            $plan = ["status" => 1, "fecha_modificacion" => date('Y-m-d H:i:s') ];
            $mensaje = "Activado";
        }
        $this
            ->Plan_Model
            ->update($uuid, $plan);

        #MENSAJE EXITO
        $this
            ->session
            ->set_flashdata('mensaje_exito', "Plan " . $mensaje);
        redirect('planes/index', 'refresh');

    }

    function ajax_verifyemail()
    {
        is_login();
        $email = $this
            ->input
            ->post('email');
        $resultado = $this
            ->Plan_Model
            ->verify_email($email);
        if ($resultado != null)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }
    }

    function ajax_verifyemail_update()
    {
        is_login();
        $email = $this
            ->input
            ->post('email');
        $uuid = $this
            ->input
            ->post('uuid');
        $resultado = $this
            ->Plan_Model
            ->verify_email_update($email, $uuid);
        if ($resultado != null)
        {
            echo "false";
        }
        else
        {
            echo "true";
        }
    }
    //funciones Bryan
    public function cargar_multi_select(){
        $data["page_name"] = "Busqueda prueba";
        $data["tipos"] = $this->Api_Model->tipos();
        $this->load->view('plan/multi_select', $data);
    }
    public function filtrar_multi_select(){
        //Datos delos filtros que vienen desde ajax
        $filtros = $this->input->post('filtros');
        //Tomamos las categorias seleccionadas de un filtro anterior
        $categorias_select = $this->input->post('categorias');
        //Array vacio
        $all_categorias = array();
        $prueba = array();
        //Si vienen filtros entramos
        if ($filtros != null && $filtros != "") {
            //Recorremos los filtros para mandarlos a la consulta
            foreach ($filtros as $value) {                    
                $categorias = $this->Cliente_Model->busqueda_clientes_licitaciones($value);  
                //Si categoria tiene datos entramos
                if ($all_categorias != null && $all_categorias != "") {
                    //recorremos las categorias que tenemos para mandar
                    foreach ($all_categorias as  $categorias_subidas) { 
                        //La recorremos de nuevo para obtener los datos que tienen adentro los array y obtener el codigo de cada una
                        foreach ($categorias_subidas as $key => $value) {   
                            //codigo de las categorias subidas en all_categorias
                            $codigo_all_categorias = $value['codigo'];
                            //ahora recorremos las categorias del segundo filtro para obtener el codigo y comparar con los codigos subidos
                            foreach ($categorias as $key2 => $value2) {
                                $categorias_codigo_filtros = $value2['codigo'];                                
                                //Se comapran los codigos
                                if ($codigo_all_categorias == $categorias_codigo_filtros) {
                                    //Borramos el codigo que se repite antes de subir
                                    unset($categorias[$key2]);
                                }
                            }
                        }
                    } 
                    //recorremos categorias para obtener los datos que tiene adentro y no subirlos como array a otro array
                    foreach ($categorias as $cat) {
                        //subimos el dato al array en la posicion 0 donde se encuentran todas las categorias                   
                        array_push($all_categorias[0], $cat);      
                    }      
                }else {
                    //Si All categorias no tiene datos subimos todos
                    array_push($all_categorias, $categorias);
                }                            
            }
            //Se reajustan las posiciones del array por si no entra a la condicion y el arreglo no quede vacio!!!
            $prueba = array_values($all_categorias[0]);
            //Si selecciono alguna categoria entra
            if ($categorias_select != null && $categorias_select != "") {
                //Recorro todas las categorias que existen
                foreach ($all_categorias as $key4 => $todas_categorias) {
                    //La recorremos de nuevo para obtener los datos que tienen adentro los array y obtener el codigo de cada una                    
                    foreach ($todas_categorias as $key5 => $categorias_todas) {
                        //Codigo de cada categoria
                        $codigo2 = $categorias_todas['codigo'];
                        //Recorremos las categorias saleccionadas
                        foreach ($categorias_select as $categorias_select2) {
                            //Hacemos un explote para sacar el codigo de la cadena que viene en el array
                            $cat = explode(("-"),$categorias_select2);
                            //Validamos si los codigos que mandaremos son iguales a los seleccionados
                            if ($codigo2 == $cat[0]) {
                                //print_r($cat[0]."-".$cat[1]);
                                //print_r($all_categorias[0][$key5]);
                                //Si son iguales lo borramos para no tener datos duplicados
                                unset($all_categorias[0][$key5]);
                                //Reajustamos el array para que no se pierdan posiciones y crashee El each de javascript
                                $prueba = array_values($all_categorias[0]);
                                //Si se encuentra una vuelve a iniciar el foreach
                                continue;
                            }
                        }
                    }
                }                                        
            }            
        }
            //Asignamos el array reajustado al array que mandaremos
            $all_categorias[0] = $prueba;
            //cabecera de envio para que sepa que es formato json
            header('Content-Type: application/json'); 
            //mandamos en formato json al Ajax
            echo json_encode($all_categorias);
    }

    public function elastic_querys(){
        $curl = curl_init();        
        curl_setopt($curl, CURLOPT_URL, 'http://35.245.110.168/elasticsearch/licitacion/_search');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "{\"from\":0,\"size\":5,\"query\":{\"bool\":{\"must\":{\"query_string\":{\"fields\":[\"comprador_nombreorganismo\"],\"query\": \"Vialidad\"}},\"should\": [{\"query_string\": {\"fields\":[\"tipo\"],\"query\":\"LE\"}},{\"query_string\":{\"fields\":[\"fuentefinanciamiento\"],\"query\": \"Sectorial\"}},{\"query_string\":{\"fields\":[\"adjudicacion_numero\"],\"query\": \"0719\",\"boost\":1000}}]}},\"aggs\": {}}");
        curl_setopt($curl, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = 'Authorization: Basic dXNlcjpwYjVpS3VDVms2d2I=';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $respuesta= "cURL Error #:" . $err;
            $response=["status"=>$respuesta];  
        header('Content-Type: application/json'); 
        echo json_encode($response);
        } else {
            $respuesta = true;
            $response=["status"=>$response];  
            header('Content-Type: application/json'); 
            echo json_encode($response);
        }
        
    }
}
/* End of file Planes.php */
?>

<?php 
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Usuarios extends CI_Controller {
    
        
        public function __construct()
        {
            parent::__construct();
            
            $this->load->model('Usuario_Model');
            $this->load->model('Cliente_Model');
        }
        

        /*Listar usuarios*/
        public function index()
        {
            perfil_superior();
            $data["page_name"]="Listar usuarios";
            $this->load->view('usuario/listar', $data);
        }

        /*Vista nuevo usuario*/
        public function view_nuevo(){
            perfil_superior();
            $data["page_name"]="Nuevo usuario";
           $data["perfiles"]=$this->Usuario_Model->get_perfiles();
           $this->load->view('usuario/nuevo', $data);
        }

        /*Vista modificar perfil de usuario*/
        public function view_modificar($uuid = null){
            is_login();
            if ($uuid==null) {
                redirect('usuarios/','refresh');
            }
            if($this->session->userdata('perfil_uuid')==$this->config->item('uuid_vendedor')){ #SI USUARIO ES VENDEDOR NO PUEDE ACCEDER A OTROS UUID
                if ($uuid!=$this->session->userdata('uuid')) {
                    redirect('usuarios/','refresh');
                }
            }
            $data["page_name"]="Modificar usuario";
            $data["usuario"]=$this->Usuario_Model->get_user($uuid);
            if ($data["usuario"]==null) {
                redirect('usuarios/','refresh');
            }
            $data["perfiles"]=$this->Usuario_Model->get_perfiles();
            $this->load->view('usuario/modificar', $data);
         }

        public function nuevo(){
            perfil_superior();
            $email=$this->input->post('email');
            $resultado = $this->Usuario_Model->verify_email($email);
            if ($this->input->post()==null) {
                redirect('usuarios/view_nuevo','refresh');
            }
            if ($resultado!=null) {
                $this->session->set_flashdata('mensaje_error',"El correo ingresado ya existe");
    
                redirect('usuarios/view_nuevo','refresh');
                
            }
            $uuid=$this->General_Model->uuid();
            $nombre=$this->input->post('nombre');
            $apellidos=$this->input->post('apellidos');
            $rut=$this->input->post('rut');
            $telefono=$this->input->post('telefono');
            $perfil_uuid=$this->input->post('perfil_uuid');
            $status=$this->input->post('status');

            if ($status!=null) {
                $status=1;
            }else{
                $status=0;
            }

            $avatar="assets/img/default.png";

				if ($_FILES['avatar']['size'] > 100)
					{
						$config['upload_path']          = './uploads/avatars';
						$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
						$config['max_size']             = 3200;
						$config['file_name']			= $uuid;
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload('avatar'))
						{
							$this->session->set_flashdata('mensaje_error',"Ocurrió un problema al subir el avatar");
						}
					else
					{
						$data = $this->upload->data();
						//$foto =  strstr($data["full_path"], "uploads/direcciones/");
						$avatar = strstr($data["full_path"], "uploads/avatars/");
					}
            }
            $pre_clave = uniqid();
            $clave = sha1(sha1($pre_clave));
            $usuario = [
                "uuid" => $uuid,
                "nombre" => $nombre,
                "apellidos" => $apellidos,
                "rut" => $rut,
                "telefono" => $telefono,
                "email" => $email,
                "perfil_uuid" => $perfil_uuid,
                "status"=> $status,
                "clave" => $clave,
                "avatar" => $avatar
            ];
            $horario = array(
                "dias" => "0 1 2 3 4 5 6",
                "hora" => "09:00 13:00 17:00",
                "usu_uuid" => $uuid
              );
            $this->Usuario_Model->add($usuario);
            $this->Cliente_Model->insert_horario($horario);             
			$this->session->set_flashdata('mensaje_exito',"Usuario creado correctamente");
            $mensaje = "Estimado ".$nombre."<br> las credenciales para su primer inicio de sesión son las siguentes <br> <strong> Usuario: ".$email."</strong> <br> <strong>Clave: ".$pre_clave."</strong>";
            $para = $email;
            $url = base_url();
            $boton = "Ir al portal";
            $asunto = "CREDENCIALES DE ACCESO";
            
            
            //$hola = mail($mensaje,$para,$url,$boton,$asunto,"password");
            $hola = mail($para,$asunto,$mensaje,$url);
            //redirect('usuarios/index','refresh');
            echo $hola;
        }

        public function edit(){
            is_login();
            $uuid=$this->input->post('uuid_usuario');
            $nombre=$this->input->post('nombre');
            $apellidos=$this->input->post('apellidos');
            $rut=$this->input->post('rut');
            $telefono=$this->input->post('telefono');
            
            $status=$this->input->post('status');
            
            $email=$this->input->post('email');
            $resultado = $this->Usuario_Model->verify_email_update($email,$uuid);
            if ($this->input->post()==null) {
                
                redirect('usuarios/view_nuevo','refresh');
            }
            if ($resultado!=null) {
                $this->session->set_flashdata('mensaje_error',"El correo ingresado ya existe");
    
                redirect('usuarios/view_nuevo','refresh');
                
            }
           

            if ($status!=null) {
                $status=1;
            }else{
                $status=0;
            }
            $usuario = [
                "uuid" => $uuid,
                "nombre" => $nombre,
                "apellidos" => $apellidos,
                "rut" => $rut,
                "telefono" => $telefono,
                "email" => $email,
                "status"=> $status,
                "fecha_modificacion" => date('Y-m-d H:i:s')      
            ];
            if ($this->input->post('perfil_uuid')!=null) {
                $usuario["perfil_uuid"]=$this->input->post('perfil_uuid');
            }
            if ($this->input->post('clave')!=null) {
                $usuario["clave"]=sha1(sha1($this->input->post('clave')));
            }
            $avatar="";

                if (isset($_FILES['avatar'])) {
                    if ($_FILES['avatar']['size'] > 100)
					{
						$config['upload_path']          = './uploads/avatars';
						$config['allowed_types']        = 'gif|jpg|png|jpeg|bmp';
						$config['max_size']             = 3200;
						$config['file_name']			= $uuid;
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload('avatar'))
						{
							$this->session->set_flashdata('mensaje_error',"Ocurrió un problema al subir el avatar");
						}
					else
					{
						$data = $this->upload->data();
						//$foto =  strstr($data["full_path"], "uploads/direcciones/");
                        $avatar = strstr($data["full_path"], "uploads/avatars/");
                        $usuario["avatar"]=$avatar;
					}
                }

				
            }
            
            $this->Usuario_Model->update($uuid,$usuario);
			
            $this->session->set_flashdata('mensaje_exito',"Usuario actualizado");
            redirect('usuarios/view_modificar/'.$uuid,'refresh');
            
        }
        
        /*AJAX*/
        function fetch_user(){  
           perfil_superior();

            $fetch_data = $this->Usuario_Model->make_datatables();  
            $data = array();  



            foreach($fetch_data as $row)  
            {  
                 $sub_array = array();  
                 $sub_array[] = '<img width="80" src="'.base_url().$row->avatar.'">';  
                 $sub_array[] = $row->nombre_usuario." ".$row->apellidos;  
                 $sub_array[] = $row->email;  
                 $sub_array[] = $row->perfil;
                 if ($row->status==1) {
                    $sub_array[] = '<span class="text-success">Activo</span>';
                 }else{
                    $sub_array[] = '<span class="text-danger">Desactivado</span>';
                 }
                 
                 $sub_array[] = '<a href="'.base_url().'usuarios/view_modificar/'.$row->uuid.'" class="btn btn-warning">Ver</a>';  
                 if ($row->status==1) {
                    $sub_array[] = '<a  href="'.base_url().'usuarios/status/'.$row->uuid.'" class="btn btn-danger">Desactivar</a>'; 

                 }else{
                    $sub_array[] = '<a  href="'.base_url().'usuarios/status/'.$row->uuid.'" class="btn btn-success">Activar</a>'; 

                 }
                
                 $data[] = $sub_array;  
            }  

            $output = array(  
                 "draw"                    =>     intval($_POST["draw"]),  
                 "recordsTotal"          =>      $this->Usuario_Model->get_all_data(),  
                 "recordsFiltered"     =>     $this->Usuario_Model->get_filtered_data(),  
                 "data"                    =>     $data  
            );  
            //var_dump($output);
            //die();
            //echo $this->db->last_query(); die();

            echo json_encode($output);  
       }  

       /*
       Cambia el estado de un usuario
       */ 
       function status($uuid){
            perfil_superior();
            if ($uuid==$this->session->userdata('usuario')["uuid"]) {
              #MENSAJE ERROR
              $this->session->set_flashdata('mensaje_error',"No puedes cambiar tu propio estado");
              redirect('usuarios/index','refresh');
            }
            $resultado=$this->Usuario_Model->get_user($uuid);
            if ($resultado["status"]==1) {
                $usuario = [
                    "status"=> 0,
                    "fecha_modificacion" => date('Y-m-d H:i:s')      
                ];
                $mensaje = "Desactivado";
            }else{
                $usuario = [
                    "status"=> 1,
                    "fecha_modificacion" => date('Y-m-d H:i:s')      
                ];
                $mensaje = "Activado";
            }
            $this->Usuario_Model->update($uuid,$usuario);

            #MENSAJE EXITO
            $this->session->set_flashdata('mensaje_exito',"Usuario ".$mensaje);
            redirect('usuarios/index','refresh');
        
   
       }

       function ajax_verifyemail(){
        is_login();
        $email=$this->input->post('email');
        $resultado = $this->Usuario_Model->verify_email($email);
        if ($resultado!=null) {
            echo "false";
        }else{
            echo "true";
        }
       }

       function ajax_verifyemail_update(){
        is_login();
        $email=$this->input->post('email');
        $uuid=$this->input->post('uuid');
        $resultado = $this->Usuario_Model->verify_email_update($email,$uuid);
        if ($resultado!=null) {
            echo "false";
        }else{
            echo "true";
        }
       }

       /* public function send_password(){


        $pre_clave = uniqid();
        $email=$this->input->post('email');
        $nombre=$this->input->post('nombre');

        $mensaje = "Estimado ".$nombre."<br> las credenciales para su primer inicio de sesión son las siguentes <br> <strong> Usuario: ".$email."</strong> <br> <strong>Clave: ".$pre_clave."</strong>";
        $para = $email;
        $url = base_url();
        $boton = "Ir al portal";
        $asunto = "CREDENCIALES DE ACCESO";
            
            
        email($mensaje,$para,$url,$boton,$asunto,"password");
       } */
    
    }
    
    /* End of file Controllername.php */
    
?>
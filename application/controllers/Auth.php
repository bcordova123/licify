<?php
    
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Auth extends CI_Controller {
        public function __construct()
        {
          parent::__construct();
          $this->load->model('Usuario_Model');
          $this->load->model('Cliente_Model');
          $this->load->model('Api_Model');
          $this->load->model('Auth_Model');
        } 
    
        public function index()
        {
            if ($this->session->userdata('usuario')!=null) {
                redirect('Welcome','refresh');
            }
            $this->load->view('auth/login');
            
        }

        public function view_forgotPassword(){
            if ($this->session->userdata('usuario')!=null) {
                redirect('Welcome','refresh');
            }
            $this->load->view('auth/forgot');
        }

        public function logout(){
            
            $this->session->unset_userdata('usuario');
            $this->session->unset_userdata('cliente');
            $this->session->unset_userdata('uuid_busqueda');
            $this->session->unset_userdata('uuid_cliente');
            $this->session->unset_userdata('total_categorias');
            $this->session->unset_userdata('monto_final');
            $this->session->unset_userdata('fecha_termino');
            redirect('auth','refresh');                
        }

        public function ajax_forgot(){
            
            $email = $this->input->post('email');
            if ($email == null || $email != "") {
                

                $resultado = $this->Auth_Model->forgotPass($email);
                $this->Auth_Model->anularRePass($resultado["uuid"]);

                if ($resultado != null) {
                    // como creo el uuid para la tabla recuperar_password?
                    // como llamo un campo del $resultado para poder insertar en recuperar_password?
                    $object["status"]=0;
                    $object["uuid"] = $this->General_Model->uuid();
                    $object["usuario_uuid"] = $resultado["uuid"];
                    
                    $this->Auth_Model->insertPass($object);
                    $mensaje ="Estimado usuario, para recuperar su contraseña presione el boton que se encuentra mas abajo, si no, puede copiar el link en el navegador. <strong>ESTE ENLACE ESTARÁ DISPONIBLE SOLO 24 HORAS.</strong>";
                    $para = $email;
                    $url = base_url()."auth/view_repass/".$object["uuid"];
                    $boton = "Cambiar contraseña";
                    $asunto = "RECUPERAR CONTRASEÑA";
                    email($mensaje,$para,$url,$boton,$asunto,"forgot");

                    echo "true";
                    die();
                }else{
                    echo "false";
                    die();
                }
            }
              
            #email($mensaje=null,$para=null,$url=null,$boton=null,$asunto=null,$tipo=null);
            
            echo "true";
            die();
        }

        public function view_repass($uuid = null){
            if ($uuid != null) {
                $this->load->model('Auth_Model');
                $resultado = $this->Auth_Model->verifyRePass($uuid);
                // verificar fechas para vencimiento de link en 1 dia
                $datetime1 = date_create($resultado["fecha_solicitud"]); 
                $datetime2 = date_create(date('Y-m-d H:i:s')); 
                
                // calculates the difference between DateTime objects 
                $interval = date_diff($datetime1, $datetime2); 
                $final= $interval->format('%a');
                if ($final>0) {
                    $data["mensaje"]="Este enlace ha caducado";
                    $this->load->view('comun/generica', $data);
                    
                }

                if ($resultado != null) {
                    $data["uuid"] = $uuid;
                    $this->load->view('auth/newpass', $data);
                }else{
                    $data["mensaje"]="Este enlace ha caducado";
                    $this->load->view('comun/generica', $data);
                   
                }

                
                
            }
        }

        public function ajax_login(){

			header('Access-Control-Allow-Origin: *');
            $email = $this->input->post('email');
            $password = $this->input->post('clave');
            if ($email != null && $email != "" && $password != null && $password != "") {
                
                $this->load->model('Auth_Model');

                $resultado = $this->Auth_Model->login($email,$password);
                if ($resultado != null) {
                    
                    $this->session->set_userdata('usuario',$resultado);
                    $this->session->set_userdata('login',"logeado");
                    
                    echo "true";
                }else{
                    echo "false";
                    die();
                }

            }else {
                echo "false";
                die();
            }
            
        }

        public function ajax_changePass(){
            
            $pass = $this->input->post('password');
            $uuid = $this->input->post('uuid');
            if (is_null($pass) || is_null($uuid)) {
                echo "false";
                die();
            }else{
                $this->load->model('Auth_Model');
                $respuesta = $this->Auth_Model->verifyRePass($uuid);
                if($respuesta != null){
                    $object=[
                        "clave"=>sha1($pass),
                        "fecha_modificacion"=>date('Y-m-d H:i:s')
                    ];
                    $this->Auth_Model->updateRePass($uuid,["fecha_uso"=>date('Y-m-d H:i:s')]);
                    $this->Auth_Model->updateUser($respuesta["usuario_uuid"],$object);
                }
                echo "true";
                die();
            }
            
        }

        public function cargar_registro(){
            $this->load->view('auth/registro');
        }
        public function registro(){            
            $nombre = $this->input->post('nombre');
            $email = $this->input->post('correo');
            $pass = $this->input->post('password');
            $pass2 = $this->input->post('password2');
            $count_pass = strlen($pass);
            //clave encriptada
            //$passHash = password_hash($pass, PASSWORD_BCRYPT); 
            $passHash = sha1(sha1($pass));
            //var_dump($passHash);
            //Con este comando verificamos si la contraseña enviada es igual a la encriptada
            //$hola = password_verify("123456", $passHash);
            if ($nombre != null && $nombre != "") {
                if ($email != null & $email != "") {
                    if ($pass != null && $pass != "") {
                        if ($pass2 != null && $pass2 != "") {
                            if ($pass == $pass2) {
                                if ($count_pass >= 5) {                                    
                                    $verificar_correo = $this->Usuario_Model->verify_email($email);
                                    if ($verificar_correo == null) {
                                        $uuid["uuid"] = $this->General_Model->uuid();
                                        $fecha = date("Y-m-d");
                                        $usuario = array(
                                             "uuid" => $uuid["uuid"],
                                             "nombre" => $nombre,
                                             "apellidos" => " ",
                                             "email" => $email,
                                             "clave" => $passHash,
                                             "status" => 1,
                                             "fecha_creacion" => $fecha,
                                             "perfil_uuid" => "97488200-91d4-11e9-b941-0cc47a6c172a",
                                             "token" => " ",
                                             "rut" => " "
                                         );
                                        $this->Usuario_Model->add($usuario);
                                        $response = ["status" => true, "reason" => "Usuario creado!"];
                                        header('Content-Type: application/json'); 
                                        echo json_encode($response);
                                    }else {
                                        $response = ["status" => false, "reason" => "El correo ya existe!"];
                                        header('Content-Type: application/json'); 
                                        echo json_encode($response);
                                    }                                    
                                }else {
                                    $response = ["status" => false, "reason" => "Las contraseñas deben tener mas de 4 caracteres!"];
                                    header('Content-Type: application/json'); 
                                    echo json_encode($response);
                                }
                            }else { 
                                $response = ["status" => false, "reason" => "Las contraseñas deben ser iguales!"];
                                header('Content-Type: application/json'); 
                                echo json_encode($response);
                            }
                        }else {
                            $response = ["status" => false, "reason" => "Se requiere confirmar la contraseña!"];
                            header('Content-Type: application/json'); 
                            echo json_encode($response);
                        }
                    }else {
                        $response = ["status" => false, "reason" => "Se requiere una contraseña!"];
                        header('Content-Type: application/json'); 
                        echo json_encode($response);
                    }
                }else {
                    $response = ["status" => false, "reason" => "Se requiere un correo!"];
                    header('Content-Type: application/json'); 
                    echo json_encode($response);
                }                
            }else{
                $response = ["status" => false, "reason" => "Se requiere un nombre!"];
                header('Content-Type: application/json'); 
                echo json_encode($response);
            }
        }
    
    }
    
    /* End of file Auth.php */
    
?>
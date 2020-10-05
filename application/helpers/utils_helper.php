<?php
    function is_login(){
        $CI =& get_instance();
		$CI->load->library('session');
		if ($CI->session->userdata('usuario')["uuid"]!=null) {
				return true;
		}else{
			redirect('auth/logout','refresh');
		}
	}
	function perfil_superior(){
        $CI =& get_instance();
		$CI->load->library('session');
		$uuid_admin=$CI->config->item('uuid_administrador');
		$uuid_jefe=$CI->config->item('uuid_jefe');
		if ($CI->session->userdata('usuario')["uuid"]!=null && $CI->session->userdata('usuario')["perfil_uuid"]==$uuid_admin || $CI->session->userdata('usuario')["perfil_uuid"]==$uuid_jefe) {
				return true;
		}else{
			redirect('auth/logout','refresh');
		}
	}
	
	function email($mensaje=null,$para=null,$url=null,$boton=null,$asunto=null,$tipo=null){
		$CI =& get_instance();       
        $CI->load->library('email');
        $CI->email->set_newline("\r\n");
        $CI->email->set_mailtype("html");
		
		switch ($tipo) {
			case 'forgot':
				$data["asunto"]=$asunto;
				$data["mensaje"]=$mensaje;
				$data["boton"]=$boton;
				$data["url"]=$url;
				$template=$CI->load->view('email/forgot',$data,TRUE);
			break;

			case 'password':
				$data["asunto"]=$asunto;
				$data["mensaje"]=$mensaje;
				$data["boton"]=$boton;
				$data["url"]=$url;
				$template=$CI->load->view('email/forgot',$data,TRUE);
			break;
			
			case 'pago':
				$data["asunto"]=$asunto;
				$url["mensaje"]=$mensaje;
				$template = $CI->load->view('email/pago', $url,TRUE);
				//$template=$CI->load->view('email/pago',$data,TRUE);
			break;

			default:
				# code...
			break;
		}
		
		$finalData =
		array (
		  'personalizations' =>
		  array (
			0 =>
			array (
			  'to' =>
			  array (
				0 =>
				array (
				  'email' => $para,
			  ),
			),
			  'subject' => $asunto,
		  ),
		),
		  'content' =>
		  array (
			0 =>
			array (
			  'type' => 'text/html',
			  'value' => $template,
		  ),
		),
		  'from' =>
		  array (
			'email' => 'bcordova@saargo.com',
            'name ' => 'Equipo Licify',
		),
		  'reply_to ' =>
		  array (
			'email' => 'bcordova@saargo.com',
            'name ' => 'Equipo Licify',
		),
	);


	  $dataSend = json_encode($finalData);


	  $secretKey = "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";
	  $url = "https://api.sendgrid.com/v3/mail/send";

	  $request_headers =  array('Content-Type:application/json', 'Authorization: Bearer ' . $secretKey);
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	  curl_setopt($ch, CURLOPT_POST, true);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSend);
	  curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  $data = curl_exec($ch);

	  if (curl_errno($ch))
	  {
		  $hola = "Error: " . curl_error($ch);
	  }
	  else
	  {
		  $hola = $data;
		  curl_close($ch);
	  }
	}
?>
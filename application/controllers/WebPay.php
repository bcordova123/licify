<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webpay extends CI_Controller {

	public function __construct()
    {
		
        parent::__construct();
	   // Your own constructor code
	   $this->load->model('Cliente_Model');
	   $this->load->model('Usuario_Model');
    }

	public function pagonormal(){		
			
			$buyOrder = $this->input->post('numero_orden');
			$termino = $this->input->post('termino');
			$this->session->set_userdata('fecha_termino', $termino);			
			$total = $this->session->userdata('monto_final');
			//remplazar las functions por consultas a la base de datos, para obtener el numero de orden
			//TRAER TOTAL con los datos del usuario
			$sessionId=$buyOrder;
			require_once( APPPATH.'libraries/webpay/webpay.php' );
			require_once( APPPATH.'certificates/cert-normal.php' );
			//$sample_baseurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
			$configuration = new Configuration();
			$configuration->setEnvironment($certificate['environment']);
			$configuration->setCommerceCode($certificate['commerce_code']);
			$configuration->setPrivateKey($certificate['private_key']);
			$configuration->setPublicCert($certificate['public_cert']);
			$configuration->setWebpayCert($certificate['webpay_cert']);
			$webpay = new Webpay_($configuration);
			
			//if en variable
			//$action = isset($_GET["action"]) ? $_GET["action"] : 'init';

			/** URL de retorno */
			$urlReturn = base_url()."WebPay/webpayResult";
			$urlFinal  = base_url()."WebPay/webpayAnular";
				$result = $webpay->getNormalTransaction()->initTransaction($total, $buyOrder, $sessionId, $urlReturn, $urlFinal);
				if (!empty($result->token) && isset($result->token))
				{   
					$token = $result->token;
					$next_page = $result->url;
					$datos["token"]=$token;
					$datos["next_page"]=$next_page;
					$template = $this->load->view('webpay/next', $datos,TRUE);
					$response = ["status" => true, "reason" => "Pagando","template" => $template];
            		header('Content-Type: application/json'); 
            		echo json_encode($response); 
				}
				else
				{
					redirect('webpay/webpayAnular','refresh');
				}
				
	}

	public function webpayResult(){
		require_once( APPPATH.'libraries/webpay/webpay.php' );
		require_once( APPPATH.'certificates/cert-normal.php' );

		//$sample_baseurl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

		$configuration = new Configuration();
		$configuration->setEnvironment($certificate['environment']);
		$configuration->setCommerceCode($certificate['commerce_code']);
		$configuration->setPrivateKey($certificate['private_key']);
		$configuration->setPublicCert($certificate['public_cert']);
		$configuration->setWebpayCert($certificate['webpay_cert']);

		/** Creacion Objeto Webpay */
		$webpay = new Webpay_($configuration);
		if (!isset($_POST["token_ws"]) || $_POST["token_ws"]==null)
		{
			redirect('webpay/webpayAnular','refresh');
		}
		$token = filter_input(INPUT_POST, 'token_ws');
		$result = $webpay->getNormalTransaction()->getTransactionResult($token);

		if ($result->detailOutput->responseCode === 0) {
			switch ($result->detailOutput->paymentTypeCode) {
				case "VD":
				$tipo_pago="DEBITO";
				break;
				case "VN":
				$tipo_pago="CRÉDITO NORMAL";
				break;
				case "VC":
				$tipo_pago="CRÉDITO CUOTAS";
				break;
				case "SI":
				$tipo_pago="CRÉDITO 3 CUOTAS SIN INTERÉS";
				break;
				case "S2":
				$tipo_pago="CRÉDITO 2 CUOTAS SIN INTERÉS";
				break;
				case "NC":
				$tipo_pago=$result->detailOutput->sharesNumber."CRÉDITO CUOTAS SIN INTERÉS";
				break;
				default:
				$tipo_pago="---";
				break;
			}			
			$datos["orden_compra"]=$result->detailOutput->buyOrder;
			$datos["tipo_pago"]=$tipo_pago;
			$datos["amount"]=$result->detailOutput->amount;
			$datos["cuotas"]=$result->detailOutput->sharesNumber;
			$datos["card_detail"]=$result->cardDetail->cardNumber;
			$datos["fecha_pago"]=date("Y-m-d h:m:s");
			
			$uuid_busqueda = $this->session->userdata('uuid_busqueda');
			$uuid_cliente = $this->session->userdata('uuid_cliente'); 
			//AGREGAR FECHA DE EXPIRACIÓN!!!!!!	
			$fecha_termino = $this->session->userdata('fecha_termino');		
			$datos["termino"] = $fecha_termino;	
			$datos['busqueda']= $this->Cliente_Model->find_busqueda_pagada($uuid_busqueda); 

			$query = $this->db->query('select uuid() as "uuid"');
			$result=$query->row_array();
			$uuid = $result["uuid"];
			$uuid_usu = $this->session->userdata('usuario')['uuid'];
			$objeto = array(
				"uuid" => $uuid,
				"numero_orden" => $datos["orden_compra"],
				"token" => $token,
				"cuotas" => $datos["cuotas"],
				"meses" => null,
				"busqueda_uuid" => $uuid_busqueda,
				"usu_uuid" => $uuid_usu,
				"monto" => $datos["amount"],
				"ip" => null,
				"tipo_tarjeta" => null,
				"nombre_banco" => null,
				"tipo_pago" => $tipo_pago,
				"referencia_transaccion" => null,
				"fecha_pago" => $datos["fecha_pago"],
				"fecha_expiracion" => $fecha_termino,
				"status" => 1
			);
			$this->Cliente_Model->insert_pago($objeto);
			$status = array(
				"status" => 1
			);
			$this->Cliente_Model->update_busqueda_byuuid_busqueda($uuid_busqueda,$status);                                     
			$this->Cliente_Model->update($uuid_cliente,$status);
			$this->session->unset_userdata('uuid_busqueda');
			$this->session->unset_userdata('uuid_cliente');
			$this->session->unset_userdata('total_categorias');
			$this->session->unset_userdata('monto_final');
			$this->session->unset_userdata('fecha_termino');			
			
			$correo = $this->Usuario_Model->get_email_user($uuid_usu);
			$mensaje ="Estimado usuario, Muchas gracias por comprar las busquedas, le estaran llegando correos con las licitaciones correspondientes a tales bsuquedas.</strong>";
            $para = $correo["email"];
            $asunto = "PAGO REALIZADO";
            email($mensaje,$para,$datos,NULL,$asunto,"pago");
	  		$this->load->view('webpay/ok_webpay', $datos);								
		} else {
			redirect('WebPay/webpayAnular','refresh');
		}
	}		
	public function webpayAnular(){
		$this->load->view('webpay/error_webpay');
    }
}
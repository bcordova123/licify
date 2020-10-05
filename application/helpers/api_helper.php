<?php defined('BASEPATH') OR exit('No direct script access allowed');

    function token_($token){
        if ($token=="12341234") {
            return true;
        }else{
            $response=["status"=>1]; 
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die();        
    }

    function token($token){
        $CI =& get_instance();
        $CI->load->model('Model');
        $o=$CI->Model->verify_token($token);

        if ($o!=null) {
            return true;
        }else{
            $response=["status"=>1]; 
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        die();        
    }

    

?>
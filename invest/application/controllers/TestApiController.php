<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;
 


class TestApiController extends RestController

//class invest extends CI_Controller
{

    function index()
{
  

$this->load->library('Rest',$config);
}

public function __construct()
    { 
     
        parent::__construct();
        //parent::__construct();
        $this->load->model('DetailModel');
     

    }
    public function test1()
    {
        echo 'First API test';
    }

    public function jwt_enc_post()

    {

        $data = json_decode(file_get_contents('php://input'),true);
        
        $CI =& get_instance();

        $token = $auth->generateToken($data);
        echo $token;

    }

    public function test_post()
    {
       $auth = new AUTHORIZATION();
       $data = json_decode(file_get_contents('php://input'),true);
        $token = $auth->generateToken($data);
        echo $token;
    }

    public function test2_post()
    {
       $auth = new AUTHORIZATION();
       $data = json_decode(file_get_contents('php://input'),true);
       $headers = $this->input->request_headers();
        $data2 = $headers['jauth'];


        $res = $auth->validateToken($data2);
        var_dump($res);
    }




    public function jwt_dec_post()
    {

        //$jwt = new JWT();

       
       
        // $data = file_get_contents('php://input');
        // $rqst = json_decode($data, true);
        $data = json_decode(file_get_contents('php://input'),true);

            $SecretKey = "starresttest";
            
            // $data = array (
            
            // "userId"=>'12444',
            
            // "email"=>'rax@gmail.com',
            
            // "userType"=>'tester' );
            
            $token = $jwt->encode($rqst, $SecretKey, 'HS256');
            
            echo $token;

    }




   }


?>
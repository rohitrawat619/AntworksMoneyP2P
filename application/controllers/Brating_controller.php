<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brating_controller extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Brating');
	}

	public function index()
	{
          

	}
	
	  public function getCreditScoreApiCallFunction(){
      

			        $arr = explode(' ', str_replace('  ', ' ', $this->input->post('Borrowername')));
                $num = count($arr);
                $first_name = $middle_name = $last_name = null;
                if ($num == 1) {
                    $first_name = $arr['0'];
                    $last_name = $arr['0'];
                }
                if ($num == 2) {
                    $first_name = $arr['0'];
                    $last_name = $arr['1'];
                }
                if ($num > 2) {
                    $first_name = $arr['0'];
                    $last_name = $arr['2'];
                }
     $resp =    $this->Brating->getCreditScoreAPI(
			$this->input->post('mobileNo')
			,$first_name
			,$last_name
			,'free'
			,$this->session->userdata('user_id'),
			$this->input->post('experian_source')
			); 
			$resp = json_decode($resp,true);
       // getCreditScoreAPI($mobileNo,$fname,$lname,$creditScoreRequestType,$user_id,$experian_source); // 'creditScoreRequestType' => free/paid
				
	 $respData['msg']= $resp['msg'];
	 $respData['creditScoreRequestType'] = $resp['creditScoreRequestType'];
	 $respData['score'] = $resp['score'];
	 
	 echo "<script>
             alert('".json_encode($respData)."'); 
             window.history.go(-1);
     </script>";
	  exit;
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Social_profile extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
		
        $this->load->model(array('Borrower_social_model'));
        $this->load->library('form_validation');
    }

    public function get_borrower_details_social_profile()
   {
	       $this->load->library('encrypt');
		   $encode_mobile = $this->input->get('id');
           $decode_mobile = $this->encrypt->decode($encode_mobile);
            if ($decode_mobile !='') {
                $response = $this->Borrower_social_model->get_borrower_details_credit_line_social_profile($decode_mobile);
                echo json_encode($response);
                
            } else {
                $response = array("error_msg" => 'Please enter valid Mobile No.');
                echo json_encode($response);
            }
       
    }

    

}

?>
<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Borrowerres extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
		// Prevent session cookies from being set
        header_remove('Set-Cookie');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->load->model(array('Borrowermodel', 'Borroweraddmodel'));
        $this->load->database();
    }

    public function registration_credit_line_1_post()
    {
        //file_put_contents('logs/notification-log.txt', date('Y-m-d H:i:s') . ' - Announcement' . PHP_EOL, FILE_APPEND);
        
            $_POST = json_decode(file_get_contents('php://input'), true);
			
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[p2p_borrowers_list.email]');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('r_state', 'State', 'trim|required');
            $this->form_validation->set_rules('r_city', 'City', 'trim|required');
            /*$this->form_validation->set_rules('residence_type', 'Residence type', 'trim|required');
            $this->form_validation->set_rules('r_address', 'Address', 'trim|required');*/
            $this->form_validation->set_rules('r_pincode', 'Pincode', 'trim|required');
            //$this->form_validation->set_rules('latitude', 'Latitude', 'trim|required');
            //$this->form_validation->set_rules('longitude', 'Longitude', 'trim|required');
            $this->form_validation->set_rules('highest_qualification', 'Highest Qualification', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->registration_credit_line_1();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }
        
    }

    public function registration_credit_line_2_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            $this->form_validation->set_rules('occuption_id', 'Occuption', 'trim|required');
            $this->form_validation->set_rules('company_type', 'Company Type', 'trim|required');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('salary_process', 'Salary Process', 'trim|required');
            $this->form_validation->set_rules('net_monthly_income', 'Monthly Income', 'trim|required');

            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->registration_credit_line_2($this->input->post('borrower_id'));
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }

    public function update_borrower_details_post()
    {
        //file_put_contents('log', date('Y-m-D H:i:s') . file_get_contents('php://input').PHP_EOL, FILE_APPEND);
       /*  $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('vendor_id', 'Vendor ID', 'trim|required');
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');

            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->update_registration_credit_line();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function get_borrower_details_post()
    {
		// Custom cookie setting without 'Expires'
    setcookie('p2p_2018_2019_session', session_id(), 0, "/", ".antworksp2p.com", true, true);

        
        /* $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('mobile', 'mobile', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->get_borrower_details_credit_line();

                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
				
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     */
	 }
	  public function video_kyc_post()
    {
       /*  $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            $this->form_validation->set_rules('kyc_data', 'kyc_data', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->Borroweraddmodel->borrower_video_kyc();
                $response = array('status' => 1, 'msg' => 'success',);
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function credit_line_3_post()
    {
        $auth = $this->middleware->auth();
        if ($auth) {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $response = array('status' => 1, 'msg' => 'This should only take few seconds.');
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }
	public function loan_eligibility_status_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->loan_eligibility_status();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function disbursement_request_post()
    {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            $this->form_validation->set_rules('loan_id', 'loan_id', 'trim|required');
			$method['disbursment_method'] = "";
			
            if ($this->form_validation->run() == TRUE) {
                $partner_id=$this->input->post('partner_id');
                if ($partner_id!="" &&  $partner_id!=null && !empty($partner_id)) {
                    $this->db->select('disbursment_method');
                    $this->db->where('partner_id',$partner_id);
                    $method=$this->db->from('partners_theme')->get()->row_array();
                    
                }
				//echo "<pre>";print_r($method);die();

                $this->db->where('borrower_id', $this->input->post('borrower_id'));
                $this->db->where('id', $this->input->post('loan_id'));
                $this->db->set('disbursement_request', 1);
                $this->db->update('p2p_loan_list');


                if($method['disbursment_method']=="both" || $method['disbursment_method']=="manual"){

                    $this->db->where('borrower_id', $this->input->post('borrower_id'));
                    $this->db->set('step_9', 1);
                    $this->db->update('p2p_borrower_steps_credit_line');   
					//die("check");
                }
                else{
                $this->db->where('borrower_id', $this->input->post('borrower_id'));
                $this->db->set('step_6', 1);
                $this->db->update('p2p_borrower_steps_credit_line');
                }
                $response = array('status' => 1, 'msg' => 'Accepted successfully');

                //$response = $this->Borroweraddmodel->disbursement_request();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }
    }
	public function credit_line_sanction_details_post()
    {
        /* $auth = $this->middleware->auth();
        if ($auth) { */
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower_id', 'trim|required');
            $this->form_validation->set_rules('loan_id', 'loan_id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                //$response = array('status' => 1, 'approved_loan' => 1000, 'approved_tenor' => '1 Month', 'approved_interest_rate' => '12 %', 'amount_to_pay' => '1120');
                $response = $this->Borroweraddmodel->credit_line_sanction_details();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }

        /* }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED); */
    }
	public function generate_esign_post()
    {
       
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'borrower ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->e_sign($this->input->post('borrower_id'));
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }
    }
	public function generate_enach_post()
    {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $this->form_validation->set_rules('borrower_id', 'Borrower ID', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->generate_enach($this->input->post('borrower_id'));
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }
        
    }
	public function borrower_social_loan_post()
    {
            $_POST = json_decode(file_get_contents('php://input'), true);
			$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
			$this->form_validation->set_rules('borrower_id', 'Borrower Id', 'trim|required');
			$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('loan_purpose', 'Loan Purpose', 'trim|required');
            $this->form_validation->set_rules('tenure', 'Tenure', 'trim|required');
            $this->form_validation->set_rules('roi', 'ROI', 'trim|required');
            
            if ($this->form_validation->run() == TRUE) {
                $response = $this->Borroweraddmodel->loan_details();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            } else {
                $errmsg = array("error_msg" => validation_errors());
                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                return;
            }
    }
#Old function 18-01-24
    
} ?>

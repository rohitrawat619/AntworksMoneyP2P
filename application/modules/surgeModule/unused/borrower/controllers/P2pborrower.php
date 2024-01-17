<?php

class P2pborrower extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('P2pborrowermodel', 'P2papiborrower/Borroweraddmodel'));
        $this->money = $this->load->database('money', true);
        error_reporting(0);
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login";
        exit;
    }

    public function step_1()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/borrowers";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_1($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_2()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_2";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_2($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_3()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_3";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_3($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_4()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_4";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_4($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_5()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_5";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_5($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_6()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_6";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_6($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function step_7()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/step_7";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers_Step_7($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower_steps/step_1', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function action_update_steps()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $response = $this->P2pborrowermodel->action_update_steps();
            $this->session->set_flashdata('notification',array('error'=>0,'message'=>$response['msg']));
            redirect(base_url().'p2padmin/p2pborrower/'.$this->input->post('step'));
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function borrower_rating()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            redirect(base_url() . 'p2padmin/borrowers');
            $data['results'] = $this->P2padminmodel->get_borrower_rating();
            $data['pageTitle'] = "Borrower Rating";
            $data['title'] = "Lender Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower/borrower-rating1', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function update_borrower_rating()
    {
        echo "<pre>";
        print_r($_POST);
        exit;
    }

    public function borrowers()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "p2padmin/p2pborrower/borrowers";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower/borrower-list', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function viewborrower($borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $data['list'] = $this->P2pborrowermodel->get_borrower_details($borrower_id);
           
            $data['basic_response'] = $this->P2pborrowermodel->borrower_basic_filter_response($data['list']['borrower_id']);
            $data['experian_details'] = $this->P2pborrowermodel->getExperian_details($data['list']['borrower_mobile']);
            $data['panresponse'] = $this->P2pborrowermodel->getPanresponse($data['list']['borrower_mobile']);
//            pr($data['panresponse']);
            $data['bankaccountresponse'] = $this->P2pborrowermodel->bankaccountresponse_v1($data['list']['borrower_mobile']);
            $data['credit_decision_response'] = $this->P2pborrowermodel->credit_decision_response($data['list']['borrower_id']);
            $data['borrower_requests'] = $this->P2pborrowermodel->borrowerRequest($data['list']['borrower_id']);
            $data['e_kyc'] = $this->P2pborrowermodel->getEkyc($data['list']['borrower_id']);
            $data['steps'] = $this->P2pborrowermodel->getBorrowerallsteps($data['list']['borrower_id']);

            $data['pageTitle'] = "Borrower Details";

            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower/borrower-details', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function appdetails($b_borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'document' || $this->session->userdata('role') == 'recovery' || $this->session->userdata('role') == 'agentrecovery')) {
            $this->load->model('Appdetailsmodel');
            $data['app_installed'] = $this->Appdetailsmodel->borrowerAppdetails($b_borrower_id);
            $data['contactDetails'] = $this->Appdetailsmodel->getContactdetails($b_borrower_id);
            $data['pageTitle'] = "Contact Details";

            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
//			$this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower/borrower-app-details', $data);
            $this->load->view('templates-admin/footer', $data);

        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function view_experian_response($borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $this->load->model('P2PCreditenginemodel');
            $data['rating'] = $this->P2PCreditenginemodel->Engine($borrower_id);
//            pr($data);
            $data['pageTitle'] = "Borrower Details";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower/view_creditreport', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function bankstatement_response($borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $result = $this->P2pborrowermodel->getBankresponse($borrower_id);
            $response = json_decode($result['whatsloan_response'], true);
            $data['result'] = $response['result'];
//        echo "<pre>";
//        print_r($data['result']); exit;
            $data['pageTitle'] = "Borrower Account Response";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-creditops/header', $data);
            $this->load->view('templates-creditops/nav', $data);
            $this->load->view('borrower/bank_account_analysis', $data);
            $this->load->view('templates-creditops/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function updateborrower()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function resendverificationlink()
    {
        if ($this->session->userdata('admin_state') == TRUE && (($this->session->userdata('role') == 'admin') || $this->session->userdata('role') == 'Teamleader')) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[p2p_lender_list.email]');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Borrowermodel');
                $response = $this->Borrowermodel->resendVerificationmail();
                if ($response) {
                    echo json_encode($response, true);
                    exit;
                } else {
                    echo json_encode(array('status' => 0, 'msg' => 'Something went wrong! Please contact to system administrator'), true);
                    exit;
                }

            } else {

                echo json_encode(array('status' => 0, 'msg' => validation_errors()), true);
                exit;

            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function reinitiateExperian()
    {
		
        if ($this->session->userdata('admin_state') == TRUE && ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'teamleader')) {
            $this->load->library('form_validation');
            $borrower_info = $this->P2pborrowermodel->get_borrower_details($this->input->post('b_borrower_id'));
			
            if ($borrower_info) {

                $arr = explode(' ', str_replace('  ', ' ', $borrower_info['Borrowername']));
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
                $dob = str_replace('-', '', $borrower_info['borrower_dob']);
                $_POST = array_merge($_POST, array(
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'b_borrower_id' => $borrower_info['b_borrower_id'],
                    'dob' => $dob,
                    'loan_amount' => $borrower_info['loan_amount'],
                    'tenor_months' => $borrower_info['tenor_months'],
                    'borrower_pan' => $borrower_info['borrower_pan'],
                    'borrower_mobile' => $borrower_info['borrower_mobile'],
                    'borrower_email' => $borrower_info['borrower_email'],
                    'r_address' => $borrower_info['r_address'],
                    'r_address1' => $borrower_info['r_address1'] ? $borrower_info['r_address1'] : '',
                    'borrower_city' => $borrower_info['borrower_city'],
                    'r_state' => $borrower_info['r_state'],
                    'r_pincode' => $borrower_info['r_pincode'],
                ));
				//pr($_POST);exit;
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
                $this->form_validation->set_rules('loan_amount', 'Applied loan amount', 'trim|required');
                $this->form_validation->set_rules('tenor_months', 'tenor_months', 'trim|required');
                $this->form_validation->set_rules('borrower_pan', 'borrower_pan', 'trim|required');
                $this->form_validation->set_rules('borrower_mobile', 'borrower_mobile', 'trim|required');
                $this->form_validation->set_rules('borrower_email', 'borrower_email', 'trim|required');
                $this->form_validation->set_rules('r_address', 'r_address', 'trim|required');
                //$this->form_validation->set_rules('r_address1', 'r_address1', 'trim|required');
                $this->form_validation->set_rules('borrower_city', 'borrower_city', 'trim|required');
                $this->form_validation->set_rules('r_state', 'r_state', 'trim|required');
                $this->form_validation->set_rules('r_pincode', 'r_pincode', 'trim|required');
                if ($this->form_validation->run() == TRUE) {
					
			$query = $this->db->get_where('p2p_borrower_experian_response', array('mobile' => $borrower_info['borrower_mobile']));

			  if ($this->db->affected_rows() == 0) {
			
			    $query = $this->money->get_where('premium_plan_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
				
				if ($this->money->affected_rows() == 0) {
                 
				$query = $this->money->get_where('cc_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
					
				if ($this->money->affected_rows() == 0) {
					
				$query = $this->money->get_where('all_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
					
				if ($this->money->affected_rows() == 0) {	
					
					
                    $xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="http://nextgenws.ngwsconnect.experian.com">
   <SOAP-ENV:Header />
   <SOAP-ENV:Body>
      <urn:process>
         <urn:cbv2String><![CDATA[<INProfileRequest>
   <Identification>
      <XMLUser>cpu2ant_prod044</XMLUser>
      <XMLPassword>Antworks@1234</XMLPassword>
   </Identification>
   <Application>
      <FTReferenceNumber></FTReferenceNumber>
      <CustomerReferenceID>' . $borrower_info['borrower_id'] . '</CustomerReferenceID>
      <EnquiryReason>13</EnquiryReason>
      <FinancePurpose>99</FinancePurpose>
      <AmountFinanced>' . $borrower_info['loan_amount'] . '</AmountFinanced>
      <DurationOfAgreement>' . $borrower_info['tenor_months'] . '</DurationOfAgreement>
      <ScoreFlag>1</ScoreFlag>
      <PSVFlag></PSVFlag>
   </Application>
   <Applicant>
      <Surname>' . $last_name . '</Surname>
      <FirstName>' . $first_name . '</FirstName>
      <MiddleName1 />
      <MiddleName2 />
      <GenderCode>2</GenderCode>
      <IncomeTaxPAN>' . $borrower_info['borrower_pan'] . '</IncomeTaxPAN>
      <PAN_Issue_Date />
      <PAN_Expiration_Date />
      <PassportNumber />
      <Passport_Issue_Date />
      <Passport_Expiration_Date />
      <VoterIdentityCard />
      <Voter_ID_Issue_Date />
      <Voter_ID_Expiration_Date />
      <Driver_License_Number />
      <Driver_License_Issue_Date />
      <Driver_License_Expiration_Date />
      <Ration_Card_Number />
      <Ration_Card_Issue_Date />
      <Ration_Card_Expiration_Date />
      <Universal_ID_Number />
      <Universal_ID_Issue_Date />
      <Universal_ID_Expiration_Date />
      <DateOfBirth>' . $dob . '</DateOfBirth>
      <STDPhoneNumber />
      <PhoneNumber>' . $borrower_info['borrower_mobile'] . '</PhoneNumber>
      <Telephone_Extension />
      <Telephone_Type />
      <MobilePhone>' . $borrower_info['borrower_mobile'] . '</MobilePhone>
      <EMailId>' . $borrower_info['borrower_email'] . '</EMailId>
   </Applicant>
   <Details>
      <Income />
      <MaritalStatus />
      <EmployStatus />
      <TimeWithEmploy />
      <NumberOfMajorCreditCardHeld>5</NumberOfMajorCreditCardHeld>
   </Details>
   <Address>
      <FlatNoPlotNoHouseNo>' . $borrower_info['r_address'] . '</FlatNoPlotNoHouseNo>
      <BldgNoSocietyName>' . $borrower_info['r_address1'] . '</BldgNoSocietyName>
      <RoadNoNameAreaLocality></RoadNoNameAreaLocality>
      <City>' . $borrower_info['borrower_city'] . '</City>
      <State>' . $borrower_info['r_state'] . '</State>
      <PinCode>' . $borrower_info['r_pincode'] . '</PinCode>
   </Address>
  
   <AdditionalAddress>
      <FlatNoPlotNoHouseNo />
      <BldgNoSocietyName />
      <RoadNoNameAreaLocality />
      <Landmark />
      <State />
      <PinCode />
   </AdditionalAddress>
</INProfileRequest>
]]></urn:cbv2String>
      </urn:process>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_PORT => "8443",
                        CURLOPT_URL => "https://connect.experian.in:8443/ngwsconnect/ngws",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 60,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $xml,
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: text/xml",
                        ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $year = date("Y");
                        $month = date("m");
                        $filename = FCPATH . "experien/reports/" . $year;
                        $filename2 = FCPATH . "experien/reports/" . $year . "/" . $month;
                        if (file_exists($filename) == true) {
                            if (file_exists($filename2) == false) {
                                mkdir($filename2, 0777);
                            }
                        } else {
                            mkdir($filename, 0777);
                            if (file_exists($filename2) == false) {
                                mkdir($filename2, 0777);
                            }
                        }
                        $report_file_name = "experien/reports/" . $year . "/" . $month . "/report_" . $this->input->post('b_borrower_id') . "_" . date('m-d-Y_H-i-s') . ".xml";
                        $file_experian = FCPATH . $report_file_name;
                        if (file_exists($file_experian)) {
                            $report_file_name = "experien/reports/" . $year . "/" . $month . "/report_" . $this->input->post('b_borrower_id') . "_" . uniqid() . ".xml";
                        }
                        $myfile = fopen($report_file_name, "w");
                        fwrite($myfile, htmlspecialchars_decode($response));
                        fclose($myfile);
                        $arr_response = array(
                            'borrower_id' => $this->input->post('borrower_id'),
                            'borrower_request' => $xml,
                            'experian_response_file' => $report_file_name,

                        );
                        $this->db->insert('p2p_borrower_experian_response', $arr_response);

                        	$arr_response_all = array(
								'user_id' =>$this->input->post('borrower_id'),
								'mobile' => $borrower_info['borrower_mobile'],
								'request_data' => $xml,
								'experian_file' => $file_experian,
                                'experian_source' => 'credit line',
								'experian_xml_file' =>$report_file_name,
							);
					   $this->money->insert('all_experian_data', $arr_response_all);

                        $dataSteps = array(
                            'step_5' => 1,
                        );
                        $this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->update('p2p_borrower_steps', $dataSteps);
                        $this->load->model('Creditenginemodel');
                        $this->Creditenginemodel->Engine($this->input->post('borrower_id'));
                        //
                        $msg = "User Record Update Successfully";
                        $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                        redirect(base_url() . 'p2padmin/p2pborrower/viewborrower/' . $this->input->post('b_borrower_id'));
                    }
                }
				}
				}
			  }
			  }
				else {
                    $errmsg = validation_errors();
                    $this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
                    redirect(base_url() . 'p2padmin/p2pborrower/viewborrower/' . $this->input->post('b_borrower_id'));
                }

            } else {
                $msg = "User Record Not Found. Please verify details and try again.";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'p2padmin/p2pborrower/viewborrower/' . $this->input->post('b_borrower_id'));
            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function update_borrower_pan()
    {
        if ($this->session->userdata('admin_state') == TRUE && (($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader'))) {
            $response = $this->P2pborrowermodel->update_borrower_pan();
        } else {
            $response = array(
                'status' => 0,
                'msg' => 'Your session had expired. Please Re-Login',
            );
        }
        echo json_encode($response);
        exit;
    }

    public function update_borrower_pan_v2()
    {
        if ($this->session->userdata('admin_state') == TRUE && (($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader'))) {
            $response = $this->P2pborrowermodel->update_borrower_pan_v2();
        } else {
            $response = array(
                'status' => 0,
                'msg' => 'Your session had expired. Please Re-Login',
            );
        }
        echo json_encode($response);
        exit;
    }

    public function acceptborrowerRequest()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $result = $this->P2pborrowermodel->acceptborrowerRequest();
            if ($result) {
                echo 1;
            } else {
                echo 2;
            }
            exit;
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function verifyPanstep()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            if ($this->input->post('borrowerId')) {
                $this->db->where('borrower_id', $this->input->post('borrowerId'));
                $this->db->set('step_3', 1);
                $this->db->update('p2p_borrower_steps');
                if ($this->db->affected_rows() > 0) {
                    $response = array(
                        'status' => 1,
                        'msg' => "PAN update successfully",
                    );
                } else {
                    $response = array(
                        'status' => 0,
                        'msg' => "OOPS! Something went wrong please check you credential and try again",
                    );
                }
            } else {
                $response = array(
                    'status' => 0,
                    'msg' => "Wrong Approach! Please try again or contact system administrator",
                );
            }
            echo json_encode($response);
            exit;
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function verifyBankdetails()
    {
        if ($this->session->userdata('admin_state') == TRUE && (($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader'))) {
            if ($this->input->post('borrowerId')) {
                $query = $this->db->select('is_verified')->get_where('p2p_borrower_bank_details', array('borrower_id' => $this->input->post('borrowerId')));
                if ($this->db->affected_rows() > 0) {
                    $is_verified = $query->row()->is_verified;
                    if ($is_verified == 1) {
                        $response = array(
                            'status' => 0,
                            'msg' => "Already Active",
                        );
                    } else {
                        $query = $this->db->select('fav_id')->order_by('id', 'desc')->get_where('p2p_borrower_bank_res', array('borrower_id' => $this->input->post('borrowerId')));
                        if ($this->db->affected_rows() > 0) {
                            $this->load->model('Requestmodel');
                            $result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
                            $keys = (json_decode($result_keys, true));
                            if ($keys['razorpay_Testkey']['status'] == 1) {
                                $api_key = $keys['razorpay_Testkey']['key'];
                                $api_secret = $keys['razorpay_Testkey']['secret_key'];

                            }
                            if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

                                $api_key = $keys['razorpay_razorpay_Livekey']['key'];
                                $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

                            }
                            $fav_id = $query->row()->fav_id;
                            if ($fav_id) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations/" . $fav_id,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => "",
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_USERPWD => $api_key . ':' . $api_secret,
                                ));

                                $response = curl_exec($curl);
                                $err = curl_error($curl);

                                curl_close($curl);

                                if ($err) {
                                    echo "cURL Error #:" . $err;
                                } else {
                                    //pr($response); exit;
                                    $res = json_decode($response, true);
                                    if ($res['results']['account_status'] == 'active') {
                                        $bank_res_arr = array(
                                            'bank_name' => $res['fund_account']['bank_account']['bank_name'],
                                            'bank_registered_name' => $res['results']['registered_name'],
                                            'is_verified' => '1',
                                        );
                                        $this->db->where('borrower_id', $this->input->post('borrowerId'));
                                        $this->db->update('p2p_borrower_bank_details', $bank_res_arr);
                                    }
                                    $this->db->where('borrower_id', $this->input->post('borrowerId'));
                                    $this->db->where('fav_id', $fav_id);
                                    $this->db->set('razorpay_response_fav', $response);
                                    $this->db->update('p2p_borrower_bank_res');
                                    $response = array(
                                        'status' => 1,
                                        'msg' => "Update successfully",
                                    );

                                }
                            } else {
                                $response = array(
                                    'status' => 0,
                                    'msg' => "Wrong Approach! Please try again or contact system administrator.",
                                );
                            }


                        } else {
                            $response = array(
                                'status' => 0,
                                'msg' => "Wrong Approach! Please try again or contact system administrator.",
                            );
                        }
                    }

                } else {
                    $response = array(
                        'status' => 0,
                        'msg' => "No record found",
                    );
                }
            } else {
                $response = array(
                    'status' => 0,
                    'msg' => "Validation error! Please check your detail and try again",
                );
            }
            echo json_encode($response);
            exit;
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }


    /////////////////////////////////////////
    ///
    public function downloadBorrowers()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Download', 'Download', 'required');
            $this->form_validation->set_rules('start_date', 'start_date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $dates = explode('-', $this->input->post('start_date'));
                $start_date = date('Y-m-d', strtotime($dates[0]));
                $end_date = date('Y-m-d', strtotime($dates[1]));
                $this->db->select("BL.borrower_id AS B_Borrower_ID,
                           BL.name AS BorrowerName,
                           BL.email AS EMAIL,
                           BL.mobile AS MOBILE,
                           BL.gender AS GENDER,
                           BL.dob AS DATEOFBIRTH,
                           BL.marital_status,
                           BL.pan,
                           PQ.qualification AS QUALIFICATION_NAME,
                           ODT.name AS OccuptionName,
                           BR.experian_score AS EXPERIANSCORE,
                           BR.antworksp2p_rating AS Antworksp2pRating,
                           BANK.bank_name,                       
                           BANK.account_number,                       
                           BANK.ifsc_code,
                            addr.r_address AS address1,
                            addr.r_address1 AS address2,
                            addr.r_city AS city,
                            addr.r_pincode AS r_pincode,
                            SE.state AS state,
                            bod.net_monthly_income,
                            PD.loan_amount,
                            PD.loan_description,
                            PD.prefered_interest_min,
                            PD.prefered_interest_max,
                            IF(BS.step_2 = 1, 'Payment Done', 'Payment Not Done') AS second_step,
                            CASE
                              WHEN BS.step_3 = 1 THEN 'KYC Complete'
                              WHEN BS.step_3 = 2 THEN 'Invalid Response'
                              WHEN BS.step_3 = 3 THEN 'No Record Found'
                              
                              END AS Step_third_kyc,
                            CASE
                              WHEN BS.step_6 = 1 THEN 'Bank Account Verify'
                              WHEN BS.step_6 = 2 THEN 'Bank Statement Upload'
                              WHEN BS.step_6 = 3 THEN 'No Record Found'
                             
                              END AS Bank_account_verify,
                              if(BS.step_7 = 1, 'Profile Confirmed', 'Not Confirmed') AS Step7,
                              if(BS.step_8 = 1, 'Listed', 'Not Listed') AS Step8,
                              BL.created_date AS borrower_created_date
                              
                          ");
                $this->db->from('p2p_borrowers_list AS BL');
                $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
                $this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = BL.occuption_id', 'left');
                $this->db->join('ant_borrower_rating AS BR', 'ON BR.borrower_id = BL.id', 'left');
                $this->db->join('p2p_borrower_address_details addr', 'addr.borrower_id=BL.id', 'left');
                $this->db->join('p2p_proposal_details PD', 'PD.borrower_id=BL.id', 'left');
                $this->db->join('p2p_state_experien SE', 'SE.code=addr.r_state', 'left');
                $this->db->join('p2p_borrower_steps BS', 'BS.borrower_id=BL.id', 'left');
                $this->db->join('p2p_borrower_bank_details AS BANK', 'ON BANK.borrower_id = BL.id', 'left');
                $this->db->join('p2p_borrower_occuption_details AS bod', 'ON bod.borrower_id = BL.id', 'left');
                $this->db->where('DATE(BL.created_date) >= ', $start_date);
                $this->db->where('DATE(BL.created_date) <= ', $end_date);
                $this->db->order_by('BL.id', 'desc');
                $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
                if ($this->db->affected_rows() > 0) {
                    $this->load->dbutil();
                    $this->load->helper('file');
                    $this->load->helper('download');
                    $delimiter = ",";
                    $newline = "\r\n";
                    $filename = "Borrowerdetails.csv";
                    $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                    force_download($filename, $data);
                } else {

                    $msg = "Sorry no record found";
                    $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                    redirect(base_url() . 'p2padmin/p2pborrower/borrowers');

                }
            } else {
                $msg = validation_errors();
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'p2padmin/p2pborrower/borrowers');
            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function downloadBorrowers_disbursal()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Download', 'Download', 'required');
            $this->form_validation->set_rules('start_date', 'start_date', 'required');
            if ($this->form_validation->run() == TRUE) {
                $dates = explode('-', $this->input->post('start_date'));
                $start_date = date('Y-m-d', strtotime($dates[0]));
                $end_date = date('Y-m-d', strtotime($dates[1]));
                $this->db->select("
                           BL.id AS borrower_id,
                           BL.borrower_id AS b_borrower_id,
                           '0' as D,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.gender,
                           BL.dob,
                           BL.marital_status,
                           BL.pan,
                           BL.created_date AS borrowerCreationdate,
                           BL.occuption_id as occuption,
                           BL.highest_qualification as qualification,
                           
                           addr.r_address AS address1,
                            addr.r_address1 AS address2,
                            addr.r_city AS city,
                            addr.r_state,
                            addr.r_pincode AS pincode,
                            
                           BANK.bank_name,                       
                           BANK.account_number,                       
                           BANK.ifsc_code,
                           '0' as loan,
                            BR.experian_score,
                           BR.antworksp2p_rating,
                           BR.experian_response,
                           BR.overall_leveraging_ratio,
                           BR.leverage_ratio_maximum_available_credit,
                           BR.limit_utilization_revolving_credit,
                           BR.outstanding_to_limit_term_credit,
                           BR.outstanding_to_limit_term_credit_including_past_facilities,
                           BR.short_term_leveraging,
                           BR.revolving_credit_line_to_total_credit,
                           BR.short_term_credit_to_total_credit,
                           BR.secured_facilities_to_total_credit,
                           BR.fixed_obligation_to_income,
                           BR.no_of_active_accounts,
                           BR.variety_of_loans_active,
                           BR.no_of_credit_enquiry_in_last_3_months,
                           BR.no_of_loans_availed_to_credit_enquiry_in_last_12_months,
                           BR.history_of_credit_oldest_credit_account,
                           BR.limit_breach,
                           BR.overdue_to_obligation,                           
                           BR.overdue_to_monthly_income,
                           BR.number_of_instances_of_delay_in_past_6_months,
                           BR.number_of_instances_of_delay_in_past_12_months,
                           BR.number_of_instances_of_delay_in_past_36_months,
                           BR.cheque_bouncing,
                           BR.credit_summation_to_annual_income,
                           BR.digital_banking,
                           BR.savings_as_percentage_of_annual_income,
                           BR.present_residence,
                           BR.city_of_residence,
                           BR.highest_qualification,
                           BR.age,
                           BR.experience,
                           '' as total_contact,
                           '' as classification                              
                          ");
                $this->db->from('p2p_borrowers_list AS BL');

                $this->db->join('ant_borrower_rating AS BR', 'ON BR.borrower_id = BL.id', 'left');
                $this->db->join('p2p_borrower_address_details addr', 'addr.borrower_id=BL.id', 'left');
                $this->db->join('p2p_borrower_bank_details AS BANK', 'ON BANK.borrower_id = BL.id', 'left');

                $this->db->where('DATE(BL.created_date) >= ', $start_date);
                $this->db->where('DATE(BL.created_date) <= ', $end_date);
                $this->db->order_by('BL.id', 'desc');
                $query = $this->db->get();
//        echo "<pre>";
//        echo $this->db->last_query(); exit;
                if ($this->db->affected_rows() > 0) {
                    $this->load->dbutil();
                    $this->load->helper('file');
                    $this->load->helper('download');
                    $delimiter = ",";
                    $newline = "\r\n";
                    $filename = "Borrowerdetails.csv";
                    $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                    force_download($filename, $data);
                } else {

                    $msg = "Sorry no record found";
                    $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                    redirect(base_url() . 'p2padmin/p2pborrower/borrowers');

                }
            } else {
                $msg = validation_errors();
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'p2padmin/p2pborrower/borrowers');
            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function downloadratingborrower()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $this->db->select("BL.borrower_id AS B_Borrower_ID,
                           BL.name AS BorrowerName,
                           BL.email AS EMAIL,
                           BL.mobile AS MOBILE,
                           BR.*
                           ");
            $this->db->from('p2p_borrowers_list AS BL');
            $this->db->group_by('BL.id');
            $this->db->join('ant_borrower_rating AS BR', 'ON BR.borrower_id = BL.id', 'OUTER JOIN');
            $this->db->order_by('BL.id', 'desc');
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                $this->load->dbutil();
                $this->load->helper('file');
                $this->load->helper('download');
                $delimiter = ",";
                $newline = "\r\n";
                $filename = "Borrowerdetailsexperian.csv";
                $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
                force_download($filename, $data);
            } else {

            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

}

?>

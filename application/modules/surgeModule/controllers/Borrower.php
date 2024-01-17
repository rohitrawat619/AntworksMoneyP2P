<?php

class Borrower extends CI_Controller
{			
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('P2pborrowermodel', 'Borroweraddmodel'));
		$this->load->model('Basicfiltermodel');
		$this->load->helper('url');
		$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
		//$this->load->model('Common_model');
		$this->load->library('form_validation');
		$this->load->helper('custom');
		$this->load->library('pagination');
		
		error_reporting(0);
					// $database_name = $this->cldb->database;
			//	echo "Database Name: ".$database_name;
			// $this->check_role();
		$this->partner_id = $this->session->userdata('partner_id');
		//	print_r($this->session->userdata());
	}
	

		
	
	
	public function borrowers()
    {
		
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
			// echo base_url();die();
            $config["base_url"] = base_url() . "borrowerModule/borrower/borrowers";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
			// echo $config["total_rows"];die();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            $config['full_tag_open'] = "<div class='new-pagination'>";
            $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);
			
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
			// print_r($data['list']);die();
            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
			
            $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower/borrower-list', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }

    }


	public function viewborrower($borrower_id)
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
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
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower/borrower-details', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }

    }
	
	

	
    public function step_1()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_1	";
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
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
          $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_2()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_2	";
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
            $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
           $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_3()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_3";
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
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_4()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_4";
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
            $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
           $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_5()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_5";
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
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_6()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_6";
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
            $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
           $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function step_7()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            $config = array();
            $config["base_url"] = base_url() . "/borrowerModule/borrower/step_7";
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
            $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('borrower_steps/step_1', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }



	public function rule()
    {
        // if ($this->session->userdata('admin_state') == TRUE) {
            $data['rule'] = $this->Basicfiltermodel->get_latest_rule();
            $data['occupation_list'] = $this->Basicfiltermodel->get_occupation();
            $data['qualification_list'] = $this->Basicfiltermodel->get_qualification();
            $data['company_category_list'] = $this->Basicfiltermodel->company_category_list();
//            pr($data['company_category_list']);
            $data['pageTitle'] = "Basic Filter Rules";
            $data['title'] = "Basic Filter Rules";
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('basic-filter/basic-filter', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }

    public function report()
    {
        // if ($this->session->userdata('admin_state') == TRUE) {
            $where = array();
            $data['age_success_fail'] = $this->Basicfiltermodel->get_age_success_fail($where);
            $data['get_pan_success_fail'] = $this->Basicfiltermodel->get_pan_success_fail($where);
            $data['get_pincode_success_fail'] = $this->Basicfiltermodel->get_pincode_success_fail($where);
            $data['get_Qualification_success_fail'] = $this->Basicfiltermodel->get_Qualification_success_fail($where);
            $data['get_Occupation_success_fail'] = $this->Basicfiltermodel->get_Occupation_success_fail($where);
            $data['get_Company_success_fail'] = $this->Basicfiltermodel->get_Company_success_fail($where);
            $data['get_salary_success_fail'] = $this->Basicfiltermodel->get_salary_success_fail($where);
            $data['get_credit_score_success_fail'] = $this->Basicfiltermodel->get_credit_score_success_fail($where);
            $data['pageTitle'] = "Basic Filter Rules Report";
            $data['title'] = "Basic Filter Rules Report";
           $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
            $this->load->view('basic-filter/basic', $data);
            // $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('template-surgeModule/footer');
        // } else {
        //     $msg = "Your session had expired. Please Re-Login";
        //     $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
        //     redirect(base_url() . 'login/admin-login');
        // }
    }


	public function list_for_disbursement()
    {
        $results = array();
        $query = $this->cldb
            ->select("bl.name, email, mobile, ll.loan_no, ll.id, ll.borrower_id, ll.approved_loan_amount, ll.approved_interest, ll.approved_tenor, ll.loan_processing_charges, ll.loan_tieup_fee,
            ll.disburse_amount, ll.date_created
            ")
            ->join('p2p_borrowers_list as bl', 'on bl.id = ll.borrower_id')
            ->get_where('p2p_loan_list as ll', array('ll.disbursement_request' => 1, 'll.disbursed_flag IS NULL' => null));
			// echo $this->cldb->last_query();die();
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
        }
        $data['list'] = $results;
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
        $this->load->view('loan-list',$data);
        $this->load->view('template-surgeModule/footer');

    }

	public function disbursement_request_list()
    {
        $results = array();
        $query = $this->cldb
            ->select("bl.name, email, mobile, 
            ll.loan_no, ll.id, ll.borrower_id, ll.approved_loan_amount, ll.approved_interest, ll.approved_tenor, ll.loan_processing_charges, ll.loan_tieup_fee, ll.disburse_amount, ll.date_created, ll.loan_status")
            ->join('p2p_borrowers_list as bl', 'on bl.id = ll.borrower_id')
            ->get_where('p2p_loan_list as ll', array('ll.disbursement_request' => 1, 'll.disbursed_flag' => 1));
			//echo $this->db->last_query();
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
        }
        $data['list'] = $results;
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
        $this->load->view('disbursed-request-list',$data);
        $this->load->view('template-surgeModule/footer');
    }
		
	


}

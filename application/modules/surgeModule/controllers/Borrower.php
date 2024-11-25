<?php

class Borrower extends CI_Controller
{			
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('P2pborrowermodel', 'Borroweraddmodel', 'disbursementModel','Basicfiltermodel'));
		$this->load->helper('url');
		//$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
		$this->cldb = $this->load->database('credit-line', TRUE);
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
		$this->paginationUrl = base_url() . "surgeModule/borrower/";
		$this->baseUrl = $this->paginationUrl;
	}
	

		/***********2024-feb-08******************/
			public function action_update_steps()
    {
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {
            $response = $this->P2pborrowermodel->action_update_steps();
            $this->session->set_flashdata('notification',array('error'=>0,'message'=>$response['msg']));
            // redirect(base_url().'p2padmin/p2pborrower/'.$this->input->post('step'));
            redirect(base_url().'surgeModule/borrower/viewborrower');
        // } else {
            // $msg = "Your session had expired. Please Re-Login";
            // $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            // redirect(base_url() . 'login/admin-login');
        // }
    }



public function filter_report()
    {
        // if ($this->session->userdata('admin_state') == TRUE) {
            $where = array();

            if (!$this->input->post('start_date')){
                $msg = "Please select date";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'surgeModule/borrower/filter_report');

            }

            if ($this->input->post('View')){

                  $dates_arr = explode('-', $this->input->post('start_date'));
                  $where['date(created_date) >='] = date('Y-m-d', strtotime($dates_arr[0]));
                  $where['date(created_date) <='] = date('Y-m-d', strtotime($dates_arr[1]));
            }

            $data['age_success_fail'] = $this->Basicfiltermodel->get_age_success_fail($where);
            $data['get_pan_success_fail'] = $this->Basicfiltermodel->get_pan_success_fail($where);
            $data['get_pincode_success_fail'] = $this->Basicfiltermodel->get_pincode_success_fail($where);
            $data['get_Qualification_success_fail'] = $this->Basicfiltermodel->get_Qualification_success_fail($where);
            $data['get_Occupation_success_fail'] = $this->Basicfiltermodel->get_Occupation_success_fail($where);
            $data['get_Company_success_fail'] = $this->Basicfiltermodel->get_Company_success_fail($where);
            $data['get_salary_success_fail'] = $this->Basicfiltermodel->get_salary_success_fail($where);
            $data['get_credit_score_success_fail'] = $this->Basicfiltermodel->get_credit_score_success_fail($where);


            if ($this->input->post('Download')){
                error_reporting(0);
                $filename = date('Ymd') . '.csv';
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Type: application/csv; ");
                $handle = fopen('php://output', 'w');
                fputcsv($handle, array(
                    'Basic filtration criteria',
                    'Total Visitor',
                    'Count of Pass(After particular filtration criteria)',
                    'Count of Stop/Decline(After particular filtration criteria)',
                ));

                fputcsv($handle, array(
                    '1. DOB',
                    $data['age_success_fail']['success'] + $data['age_success_fail']['fail'],
                    $data['age_success_fail']['success'],
                    $data['age_success_fail']['fail'],
                ));
                /*fputcsv($handle, array(
                    '2. PAN not validate with filled details',
                    $data['get_pan_success_fail']['success'] + $data['get_pan_success_fail']['fail'],
                    $data['get_pan_success_fail']['success'],
                    $data['get_pan_success_fail']['fail'],
                ));*/
                fputcsv($handle, array(
                    '2. Negative PIN CODE',
                    $data['get_pincode_success_fail']['success'] + $data['get_pincode_success_fail']['fail'],
                    $data['get_pincode_success_fail']['success'],
                    $data['get_pincode_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '3. Qualification',
                    $data['get_Qualification_success_fail']['success'] + $data['get_Qualification_success_fail']['fail'],
                    $data['get_Qualification_success_fail']['success'],
                    $data['get_Qualification_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '4. Occupation',
                    $data['get_Occupation_success_fail']['success'] + $data['get_Occupation_success_fail']['fail'],
                    $data['get_Occupation_success_fail']['success'],
                    $data['get_Occupation_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '5. Company not match with our CAT list',
                    $data['get_Company_success_fail']['success'] + $data['get_Company_success_fail']['fail'],
                    $data['get_Company_success_fail']['success'],
                    $data['get_Company_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '6. Salary',
                    $data['get_salary_success_fail']['success'] + $data['get_salary_success_fail']['fail'],
                    $data['get_salary_success_fail']['success'],
                    $data['get_salary_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '7. Experian',
                    $data['get_credit_score_success_fail']['success'] + $data['get_credit_score_success_fail']['fail'],
                    $data['get_credit_score_success_fail']['success'],
                    $data['get_credit_score_success_fail']['fail'],
                ));

                fclose($handle); exit;
            }

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

    public function action()
    {

            $response = $this->Basicfiltermodel->add_update_rule();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $response['msg']));
            redirect(base_url() . '/surgeModule/borrower/action');

    }



    public function company_list()
    {

            $data['company_list'] = $this->Basicfiltermodel->company_list();
            $data['pageTitle'] = "Basic Filter Company List";
            $data['title'] = "Basic Filter Company List";
            $this->load->view('template-surgeModule/header');
        $this->load->view('template-surgeModule/nav');
            $this->load->view('basic-filter/company-list', $data);
            $this->load->view('template-surgeModule/footer');

    }

    public function negative_pincode_list()
    {

            $data['pincode_list'] = $this->Basicfiltermodel->negative_pincode_list();
            $data['pageTitle'] = "Basic Filter Negative Pincode List";
            $data['title'] = "Basic Filter Negative Pincode List";
            $this->load->view('template-surgeModule/header');
        $this->load->view('template-surgeModule/nav');
            $this->load->view('basic-filter/negative-pincode-list', $data);
            $this->load->view('template-surgeModule/footer');

    }



    public function export_company_list()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Companylist.csv";
        $result = $this->db->get_where('p2p_list_company');
        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            $msg = "We could not found any Data.";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . '/surgeModule/borrower/company_list');
        }
    }

    public function export_pincode_list()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Negative_Pincode.csv";
        $result = $this->db->get_where('negative_pincode');
        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            $msg = "We could not found any Data.";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . '/surgeModule/borrower/negative_pincode_list');
        }
    }
	/**************2024-feb-08****************/
	
	public function borrowers()
    {
		
        // if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'Teamleader') {
          /*  $this->load->library("pagination");*/
            $config = array();
			// echo base_url();die();
            $config["base_url"] = $this->paginationUrl."/borrowers";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
			// echo $config["total_rows"];die();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);
			
            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

            $data["pagination"] = $this->pagination->create_links();
            $data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
			$data['base_url'] = $this->paginationUrl;			// print_r($data['list']);die();
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
           //dated:2024-jan-17 $data['experian_details'] = $this->P2pborrowermodel->getExperian_details($data['list']['borrower_mobile']);
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_1";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['base_url'] = $this->paginationUrl;
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
          ///*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_2	";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
          //  $config['full_tag_open'] = "<div class='new-pagination'>";
           // $config['full_tag_close'] = "</div>";

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['base_url'] = $this->paginationUrl;
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_3";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['base_url'] = $this->paginationUrl;
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_4";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$data['base_url'] = $this->paginationUrl;
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_5";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$data['base_url'] = $this->paginationUrl;		
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_6";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			
			$data['base_url'] = $this->paginationUrl;
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
          /*  $this->load->library("pagination");*/
            $config = array();
            $config["base_url"] = $this->paginationUrl."step_7";
            $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
            $config["per_page"] = 100;
            $config["uri_segment"] = 3;
            $config['num_links'] = 10;
            /* $config['full_tag_open'] = "<div class='new-pagination'>"; */

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

			$data['base_url'] = $this->paginationUrl;
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
		
    public function loan_disbursed(){
		$postVal = $this->input->post();
	   if (!empty($postVal['loan_no'])) {
		   $this->cldb->where('loan_no', $postVal['loan_no']);
		   $this->cldb->set('loan_status', 1);
		   $this->cldb->set('approved_interest', $postVal['disburseROI']);
		   $this->cldb->set('approved_loan_amount', $postVal['disburseAmount']);
		   $this->cldb->set('disburse_amount', $postVal['disburse_amount']);
		   $this->cldb->set('disbursement_date', date('Y-m-d h:i:s'));
		   $this->cldb->update('p2p_loan_list');
		   $response['status'] = 1;
		   $response['message'] = 'Amount Disbursed Successfully';
		   echo json_encode($response);
		   exit;
	   }else {
		   $response['status'] = 0;
		   $response['message'] = 'Something wrong!';
		   echo json_encode($response);
		   exit;
	   }	
	}
	
	
	
	
	//*************disburse management**********//
	    public function disburse_pending_list(){
        $disburseRequest =1;
        $status = NULL; 
    
        $config = array(
            "base_url" => $this->baseUrl . "disburse_pending_list",
            "total_rows" => $this->disbursementModel->getCountDisburseListStatus($disburseRequest, $status),
            "per_page" => 20,
            "uri_segment" => 4
        );
    
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
    
        $data["links"] = $this->pagination->create_links();   
        $data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page, $disburseRequest, $status);
    
        // Debugging
        // echo "<pre>";
        // print_r($config);
        // die();
    
        $data['page'] = $page;
		 $this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
        $this->load->view('borrower/disbursement_pending_list', $data);
		$this->load->view('template-surgeModule/footer');
    }
    
    public function update_disburse_status(){
        $ids = $this->input->post('ids');
        $loanStatus = $this->input->post('status');
        $amount = $this->input->post('amount');
        $roi = $this->input->post('roi');
        // echo $ids."!".$loanStatus;die();
        if($loanStatus==3){ // generate_bank_file 
            
            $csv_data = $this->generate_bank_file_excel($ids);
            // echo $csv_data;die();
            $update_disburse_status['query'] =	$this->disbursementModel->update_disburse_status($loanStatus, $ids,$amount,$roi);
        if ($update_disburse_status) {
            $update_disburse_status['status'] = 1;
            $update_disburse_status['message'] = 'Update successful';
        } else {
            $update_disburse_status['status'] = 0;
            $update_disburse_status['message'] = 'Update Failed';
        }
        
        $update_disburse_status['csv_data'] = $csv_data;
        echo json_encode($update_disburse_status);
        die();
                /******ending of generate bank file function use**********/
        }
        
        else{
        $update_disburse_status = $this->disbursementModel->update_disburse_status($loanStatus, $ids,$amount,$roi);
        
        if ($update_disburse_status) {
            echo json_encode(array('status' => 1, 'message' => 'Update successful'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Update failed'));
        }
        die();
    }
    }

    public function generate_bank_file_excel($LoanId){
                // $LoanId = 2;
                $respResultSet = $this->disbursementModel->generate_bank_file_excel($LoanId);
           //     print_r($respResultSet); die();
        $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download'); 
       $delimiter = ",";
       $newline = "\r\n";
       
       $projectName = "Bank_file";
       $start_date = "";
       $end_date="";
       //print_r($respResultSet);
       if($respResultSet){
               $filename = $projectName."__product_from-".$start_date." To-".$end_date.".csv";
              //	echo $respResultSet;
           $data = $this->dbutil->csv_from_result($respResultSet, $delimiter, $newline);
       	// force_download($filename, $data);
               return  $data;
           }else{
               return "hello data";
           }
   }


	public function disburse_list_generate_bank_file(){
        $disburseRequest =1;
        $status = 1;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_generate_bank_file";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		 $this->load->view('template-surgeModule/header');
		 $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($data);die();
		$data['page'] = $page;
		$this->load->view('borrower/disbursement_generate_bank_file',$data);
		
		 $this->load->view('template-surgeModule/footer');
    }


    public function disburse_list_under_process(){
        $disburseRequest =1;
        $status = 3;
$config["base_url"] =$this->baseUrl . "disburse_list_under_process";
$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
$config["per_page"] = 20;
$config["uri_segment"] = 4;
$this->pagination->initialize($config);
$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

$data["links"] = $this->pagination->create_links();	

$this->load->view('template-surgeModule/header');
$this->load->view('template-surgeModule/nav');
$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
$data['page'] = $page;
// echo "<pre>";print_r($data);die();
$this->load->view('borrower/disburse_list_under_process',$data);

 $this->load->view('template-surgeModule/footer');    
    }


    public function disburse_list_disbursed(){
        $disburseRequest =1;
        $status = 4;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModule/header');
		 $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('borrower/disbursement_list',$data);
		$this->load->view('template-surgeModule/footer');
    }


    public function disburse_pending_rejected_list(){
        $disburseRequest =1;
        $status = 2;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('borrower/disburse_pending_rejected_list',$data);
		$this->load->view('template-surgeModule/footer');
    }

    public function disbursement_under_process_rejected_list(){
        $disburseRequest =1;
        $status = 5;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		$this->load->view('template-surgeModule/header');
		$this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('borrower/disbursement_under-process_rejected_list',$data);
		$this->load->view('template-surgeModule/footer');
    }
	


}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lender_registration extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Lendermodel', 'Requestmodel'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['states'] = $this->Requestmodel->get_state();
        $data['qualification'] = $this->Requestmodel->highest_qualification();
        $data['occuptions'] = $this->Requestmodel->get_occuption();
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/lender/lender-register',$data);
        $this->load->view('templates/footer',$data);
    }

    public function lender_register()
    {
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('highest_qualification', 'Qualification', 'required');
        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
        $this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
        $this->form_validation->set_rules('pan', 'Pancard No', 'required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('address1', 'address1', 'required');
        $this->form_validation->set_rules('state_code', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'required');
        $this->form_validation->set_rules('occupation', 'occupation', 'required');
        if($this->input->post('occupation') == 1)
        {
            $this->form_validation->set_rules('employed_company1', 'Company type', 'required');
            $this->form_validation->set_rules('company_name1', 'Company name', 'required');
            $this->form_validation->set_rules('net_monthly_income1', 'Net monthly income', 'required');
        }
        if($this->input->post('occupation') == 2)
        {
            $this->form_validation->set_rules('industry_type2', 'Industry type', 'required');
            $this->form_validation->set_rules('total_experience2', 'Total experience', 'required');
            $this->form_validation->set_rules('turnover_last_year2', 'Turnover last year', 'required');
            $this->form_validation->set_rules('turnover_last2_year2', 'Turnover last 2 year', 'required');
        }
        if($this->input->post('occupation') == 3)
        {
            $this->form_validation->set_rules('professional_type3', 'Professional type', 'required');
            $this->form_validation->set_rules('total_experience3', 'Total experiance', 'required');
            $this->form_validation->set_rules('turnover_last_year3', 'Last year turnover', 'required');
            $this->form_validation->set_rules('turnover_last2_year3', 'Last 2 year turnover', 'required');
        }
        if($this->input->post('occupation') == 4)
        {
            $this->form_validation->set_rules('company_type4', 'Company type', 'required');
            $this->form_validation->set_rules('company_name4', 'Company name', 'required');
            $this->form_validation->set_rules('net_monthly_income4', 'Net monthly income', 'required');
        }
        if($this->input->post('occupation') == 5)
        {
            $this->form_validation->set_rules('pursuing5', 'Pursuing course', 'required');
            $this->form_validation->set_rules('institute_name5', 'institute_name5', 'required');
            $this->form_validation->set_rules('net_monthly_income5', 'Net monthly income', 'required');
        }
        if($this->input->post('occupation') == 6)
        {
            $this->form_validation->set_rules('net_monthly_income6', 'Net monthly income', 'required');
        }
        $this->form_validation->set_rules('term_and_condition', 'Term and condition', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $result = $this->Lendermodel->add_lender();
            if($result){
                $msg="Thank you for registering with Antworks P2P. We have sent you an activation link on your email id, Please follow the link to verify your email.";
                $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
                redirect(base_url().'lender-register/thank-you');
            }
            else{
                $errmsg = "OOPS! Something went wrong please check you credential and try again";
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
                redirect(base_url().'lender-registration');
            }
        }
        else{
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification',array('error'=>0,'message'=>$errmsg));
            redirect(base_url().'lender-registration');
        }
    }

    public function verify_email()
    {
        $verify_code =$this->input->get('verify_code');
        $verify_hash = $this->input->get('verify_hash');
        $hash = $this->input->get('hash');
        if($verify_code && $verify_hash && $hash)
        {
            $data['result'] = $this->Lendermodel->verify_lender($verify_code, $verify_hash, $hash);

            $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
            $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
            $data['keywords']='';
            $this->load->view('templates/header',$data);
            $this->load->view('templates/nav',$data);
            $this->load->view('templates/collapse-nav',$data);
            $this->load->view('frontend/lender/verify-email',$data);
            $this->load->view('templates/footer');

        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login"; exit;
        }

    }

    public function thankyou()
    {
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/lender/thankyou',$data);
        $this->load->view('templates/footer',$data);
    }

}

?>
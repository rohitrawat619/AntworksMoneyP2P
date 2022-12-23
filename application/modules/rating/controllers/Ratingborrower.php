<?php
class Ratingborrower extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Ratingmodel'));
        if( $this->session->userdata('admin_state') == TRUE ){

        }
        else{
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/admin-login');
        }
        error_reporting(0);
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function borrowerKyc()
    {
        $data['kyc'] = $this->Ratingmodel->borrowerKyc(1);
        $data['kycDoctype'] = $this->Ratingmodel->kycDoctype(1);
        $response = json_decode($data['kyc']['whatsloan_response'], true);
        $data['bank_analysis'] = $response['result'];
//        echo "<pre>";
//        print_r( $data['bank_analysis']); exit;
        $data['pageTitle'] = 'Borrower ';
        $this->load->view('templates-admin/header');
        $this->load->view('templates-admin/nav', $data);
        $this->load->view('templates-admin/header-below', $data);
        $this->load->view('profile-details',$data);
        $this->load->view('templates-admin/footer');
    }
}
?>
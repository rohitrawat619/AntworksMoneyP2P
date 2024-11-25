<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kyc_module extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->db_money = $this->load->database('db_money', true);
		$this->load->model('Kyc_model');
		$this->load->library('pagination');
	}

	
	public function index()
	{
		
		if($this->session->userdata('admin_state') === TRUE && $this->session->userdata('role') === 'admin')
		  {
			$data['kyc_products'] = $this->Kyc_model->product_list();
			
			$data['pageTitle'] = 'KYC Product List';
			$data['pageName'] = 'KYC Product List';
			$this->load->view('templates-admin/header', $data);
			$this->load->view('templates-admin/nav', $data);
			$this->load->view('product-list', $data);
			$this->load->view('templates-admin/footer', $data);
			
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}

	public function kyc_rule($productId='')
	{
		if($this->session->userdata('admin_state') === TRUE && $this->session->userdata('role') === 'admin')
		  {
			$product_kyc_rule = $this->Kyc_model->product_kyc_rule($productId);
			$data['product_kyc_rule'] = $product_kyc_rule;
			
			$data['pageTitle'] = $product_kyc_rule[0]['product_name'].' - KYC Rule';
			$data['pageName'] = $product_kyc_rule[0]['product_name'].' - KYC Rule';
			$data['productId'] = $productId;
			
			$this->load->view('templates-admin/header', $data);
			$this->load->view('templates-admin/nav', $data);
			$this->load->view('product-kyc-details', $data);
			$this->load->view('templates-admin/footer', $data);
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}
	public function action()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
			$productId = $this->input->post('product_id');
            $response = $this->Kyc_model->add_update_rule();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $response['msg']));
            redirect(base_url() . 'kyc_module/kyc_rule/'.$productId);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }
   
	public function kyc_client_list()
	{
		if($this->session->userdata('admin_state') === TRUE && $this->session->userdata('role') === 'admin')
		  {
			$data['client_list'] = $this->Kyc_model->client_list();
			
			$data['pageTitle'] = 'KYC Client List';
			$data['pageName'] = 'KYC Client List';
			$this->load->view('templates-admin/header', $data);
			$this->load->view('templates-admin/nav', $data);
			$this->load->view('kyc/client-list', $data);
			$this->load->view('templates-admin/footer', $data);
			
		} else {
			$msg = "Please Login First";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'login/admin-login');
		}
	}
	public function addClient()
		{
			$data['pageTitle'] = "Add Client";
			$data['title'] = "Add Client";
			$this->load->view('templates-admin/header',$data);
			$this->load->view('templates-admin/nav',$data);
			$this->load->view('kyc/add-client',$data);
			$this->load->view('templates-admin/footer',$data);
		}
    public function action_add_edit_client()
	{
		$api_secret = md5(uniqid().rand(1000000, 9999999));
		$data_array = array(
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'mobile' => $this->input->post('mobile'),
			'company_name' => $this->input->post('company_name'),
			'api_key' => random_int(100000, 999999),
			'api_secret' => $api_secret,
			'status' => $this->input->post('status'),
		);
		
		if($this->input->post('id')!=''){
			unset($data_array['api_key']);
			unset($data_array['api_secret']);
			$this->db->where('id', $this->input->post('id'));
		    $this->db->update('kyc_api_client_secret', $data_array);
			$msg = 'Update';
		}else{
			$this->db->insert('kyc_api_client_secret', $data_array);
			$msg = 'added';
		}
		
			$msg = "Client ".$msg." successfully";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'kyc_module/kyc_client_list');
		
	}
	public function update_client($id)
	{
		$data['data'] = $this->Kyc_model->get_kyc_client_details($id);
		$data['pageTitle'] = "Edit Client";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('kyc/edit-client',$data);
		$this->load->view('templates-admin/footer',$data);
	}
    	
}

?>

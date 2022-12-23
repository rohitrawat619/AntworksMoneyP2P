<?php

class Offers extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Offermodel');
		error_reporting(0);
	}

	public function index()
	{

		$data['pageTitle'] = 'Offers';
		$data['lists'] = $this->Offermodel->getOffers();
		$this->load->view('templates-admin/header', $data);
		$this->load->view('templates-admin/nav', $data);
		$this->load->view('offers-list');
		$this->load->view('Offerjs');
		$this->load->view('templates-admin/footer');
	}

	public function Addnewoffer()
	{
		$data['pageTitle'] = 'Offers';
		$data['categories'] = $this->Offermodel->getcategory();
		$data['app_pages'] = $this->Offermodel->getApppages();
		$data['banks'] = $this->Offermodel->get_offer_bank();
		$data['payment_methods'] = $this->Offermodel->get_offer_payment_method();
		$data['total_positions'] = 20;
		$this->load->view('templates-admin/header', $data);
		$this->load->view('templates-admin/nav', $data);
		$this->load->view('offers');
		$this->load->view('Offerjs');
		$this->load->view('templates-admin/footer');
	}

	public function addOffer()
	{
		$this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required');
		$this->form_validation->set_rules('offer_type', 'Offer Type', 'trim|required');
		if ($this->input->post('coupon_code_type') == 'Single') {
			$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		}
		$this->form_validation->set_rules('discount_reward_type', 'Discount Reward Type', 'trim|required');
		$this->form_validation->set_rules('min_transaction_amount', 'Discount Reward Type', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
            $this->Offermodel->addOffer();
		} else {
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
			redirect(base_url('offers'));
		}


	}

	public function updateOffer()
	{
//		echo "<pre>";
//		print_r($_POST); exit;
		$this->form_validation->set_rules('offer_name', 'Offer Name', 'trim|required');
		$this->form_validation->set_rules('offer_type', 'Offer Type', 'trim|required');
		if ($this->input->post('coupon_code_type') == 'Single') {
			$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		}
		$this->form_validation->set_rules('discount_reward_type', 'Discount Reward Type', 'trim|required');
		$this->form_validation->set_rules('min_transaction_amount', 'Discount Reward Type', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$this->Offermodel->updateOffer();
		} else {
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
			redirect(base_url('offers'));
		}


	}

	public function addCategory()
	{
		$this->form_validation->set_rules('add_category_name', 'Category Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
          $response = $this->Offermodel->addCategory();
		} else {
			$errmsg = validation_errors();
			$response = array(
				'status' => 0,
				'msg' => strip_tags($errmsg)
			);
		}
		echo json_encode($response);
		exit;
	}

	public function addApppage()
	{
		$this->form_validation->set_rules('add_app_page', 'APP Page', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$response = $this->Offermodel->addApppage();
		} else {
			$errmsg = validation_errors();
			$response = array(
				'status' => 0,
				'msg' => strip_tags($errmsg)
			);
		}
		echo json_encode($response);
		exit;
	}

	public function editoffer($id)
	{
		$result = $this->Offermodel->getOfferdetails($id);
		$data['pageTitle'] = 'Edit Offers';
		$data['offer'] = $result['offer_details'];
		$data['banks'] = $this->Offermodel->get_offer_bank();
		$data['payment_methods'] = $this->Offermodel->get_offer_payment_method();
		$data['categories'] = $this->Offermodel->getcategory();
		$data['app_pages'] = $this->Offermodel->getApppages();
		$data['coupons'] = $result['couponIds'];
		$data['home_position'] = $this->Offermodel->getHomeposition($id);
		$data['offer_position'] = $this->Offermodel->getOfferposition($id);
		$data['app_pages_position'] = $this->Offermodel->getApppageposition($id);
		$data['total_positions'] = 20;
//		echo "<pre>";
//		print_r($data['offer']); exit;
		$this->load->view('templates-admin/header', $data);
		$this->load->view('templates-admin/nav', $data);
		$this->load->view('edit-offersq');
		$this->load->view('Offerjs');
		$this->load->view('templates-admin/footer');
	}

}

?>

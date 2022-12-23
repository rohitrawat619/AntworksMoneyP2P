<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bidding extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('Biddingmodel'));
	}
	
	public function index()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			redirect(base_url().'dashboard/');
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}

	public function disbursement_cases()
	{

		$data['list'] = $this->Biddingmodel->approved();
            echo "<pre>";
		print_r($data['list']); exit;
			$data['pageTitle'] = "Active Bid";
			$this->load->view('templates-admin/header');
			$this->load->view('templates-admin/nav',$data);
			$this->load->view('templates-admin/header-below',$data);
			$this->load->view('activebid',$data);
			$this->load->view('templates-admin/footer');

	}
}
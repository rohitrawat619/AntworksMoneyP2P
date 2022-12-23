<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Browse_lenders extends CI_Controller {
	private $perPage = 20;
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database(); error_reporting(0);
		$this->load->model(array('Requestmodel', 'adminlender/Adminlendermodel'));
	}

	public function index()
	{

            $data['title'] = "Lender List";
            $data['description'] = "Lender List";
            $data['keywords'] = "Lender List";
            $this->load->view('templates/header',$data);
            $this->load->view('templates/nav',$data);
            $this->load->view('templates/collapse-nav',$data);
            $this->load->view('frontend/lender/lenders-list',$data);
            $this->load->view('templates/footer');

	}
}

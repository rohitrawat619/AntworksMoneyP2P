<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emi_cal extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->database();
	}

	public function index()
	{
		$data['pageTitle'] = "EMI Calculator";
		$data['title']='EMI Calculator - Calculate EMI on Home, Car and Personal Loans';
		$data['description']='EMI Calculator: Calculate Loan EMI in 2 Mins & Check your Car,Personal & Home Loan EMI with Flexible Loan Calculator & Yearly & Monthly EMI’s with the real EASE';
		$data['keywords']='';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/nav',$data);
		$this->load->view('templates/collapse-nav',$data);
		$this->load->view('frontend/common-pages/emi-calculator',$data);

		$this->load->view('templates/footer',$data);
	}
	
}
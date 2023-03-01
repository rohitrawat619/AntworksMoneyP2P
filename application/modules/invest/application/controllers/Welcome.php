<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('home');
		$this->load->helper('url');
	}
	public function index()
	{
		$arr['data']=$this->home->page('home');
		$this->load->view('header');
		$this->load->view('page',$arr);
		$this->load->view('footer');
	}
	public function about()
	{
		$arr['data']=$this->home->page('about');
		$this->load->view('header');
		$this->load->view('page',$arr);
		$this->load->view('footer');
	}
	public function contact($id)
	{
		$arr['data']=$this->home->page('contact');
		$this->load->view('header');
		$this->load->view('page',$arr);
		$this->load->view('footer');
	}
	
	public function insert_data()
	{
		$data['name']=$this->input->post('name');
		$data['city']=$this->input->post('city');
		$this->home->insert_data($data);

		echo "Submitted Successfully";

		$arr['data']=$this->home->page('home');
		$this->load->view('header');
		$this->load->view('page',$arr);
		$this->load->view('footer');
		
	}
	
	public function update_data()
	{
		$data['name']='Sumit';
		$data['city']='Noida';
		$id=1;
		$this->home->update_data($id,$data);
	}
	public function delete_data()
	{
		$data['id']=1;
		$this->home->delete_data($data);
	}
	public function get_data()
	{
		$arr=$this->home->get_data(2);
		echo '<pre>';
		print_r($arr);
	}

	public function basetest()
		{
			echo base_url();
		}


}

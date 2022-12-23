<?php
class Calling extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Callingmodel');
	}

	public function call()
	{
       $this->Callingmodel->call($this->input->post('phone'), $this->input->post('tvs_sl_NO'));
	}

}

?>

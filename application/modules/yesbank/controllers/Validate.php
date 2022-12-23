<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Validate extends REST_Controller{

	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
	}

	public function validate_post()
	{
		$headers = $this->input->request_headers();
		echo "<pre>";
		print_r($headers); exit;
	}
}
?>

<?php
class Aaa extends CI_Controller
{
  public function __construct()
  {
  	parent::__construct();
  }

	public function index()
	{

		echo $crypted_pass = hash('SHA512', 'P@P__admin2@2@!!'); exit;
		$crypted_pass_with_key = $crypted_pass.'JL4lpysoQ22kkr2S';
		echo $generated_password = hash('SHA512', $crypted_pass_with_key);

		exit;

		//$this->load->model('Updateoccuption');

		//$result = $this->Updateoccuption->index();
//		echo "<pre>";
//		print_r($result);
		exit;
	}
}
?>

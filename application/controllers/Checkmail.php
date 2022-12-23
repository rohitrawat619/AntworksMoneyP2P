<?php
class Checkmail extends CI_Controller
{
  public function __construct()
  {
  	parent::__construct();
  }

	public function index()
	{

		$this->load->database();
		$this->load->model('p2padmin/Sendemailborrowermodel');
		$result = $this->Sendemailborrowermodel->invalidPan();exit;
//		$result = $this->Sendemailmodel->sendautoInvestmentoff();$lenderId, $email, $mobile, $confirmation = 'Y'
//		$result = $this->Sendemailmodel->sendautoInvestmentoff($lenderId = 470, $lender_name = 'Dinesh Kumar Sharma', $email = 'dinesh.knmiet@gmail.com', $mobile = 9910719994, $confirmation = 'Y');
		//$result = $this->Sendemailmodel->sendPayOutConfirmation($lenderId = 470, $lender_name = 'Dinesh Kumar Sharma', $payOutamount = "50000", $email = 'dinesh.knmiet@gmail.com', $mobile = 9910719994, $confirmation = 'Y');
//		echo "<pre>";
//		print_r($result); exit;
	}
}
?>

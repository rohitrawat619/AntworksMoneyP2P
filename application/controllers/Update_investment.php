<?php
class Update_investment extends CI_Controller
{
  public function __construct()
  {
  	parent::__construct();
  }

	public function index()
	{
		$this->load->database();
		$this->load->model('surgeapi/Invest_model');
		$result = $this->Invest_model->update_investment_cron();
       var_dump($result);exit;
	}
}
?>

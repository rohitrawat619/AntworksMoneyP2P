<?php
require APPPATH . '/libraries/REST_Controller.php';

class Offersapi extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Offermodel');
	}

	public function getHomeoffers_get()
	{
		$results = $this->Offermodel->getOffers();
		if($results)
		{
			$response = array(
				'status'=>1,
				'results'=>$results,
				'msg' => 'Records Found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		else{
			$response = array(
				'status'=>0,
				'results'=>'',
				'msg'=>'no record found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	}

	public function getCategories_get()
	{

		$results = $this->Offermodel->getcategory();
		if($results)
		{
			$response = array(
				'status'=>1,
				'results'=>$results,
				'msg' => 'Records Found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		else{
			$response = array(
				'status'=>0,
				'results'=>'',
				'msg'=>'no record found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	}

	public function getOfferdetails_post()
	{
		$req = json_decode(file_get_contents('php://input'), true);
		$results = $this->Offermodel->getOfferdetails($req['offer_id']);
		if($results)
		{
			$response = array(
				'status'=>1,
				'results'=>$results,
				'msg' => 'Records Found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		else{
			$response = array(
				'status'=>0,
				'results'=>'',
				'msg'=>'no record found'
			);
			$this->set_response($response, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	}

}

?>

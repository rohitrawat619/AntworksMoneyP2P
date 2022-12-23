<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Recharge extends REST_Controller{

	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->money_db = $this->load->database('money', true);
	}

	protected $username = 'HR1527';
	protected $password = '9999908300';
	protected $rechargeUrl = "https://portal.specificstep.com/neo/api";

	public function getListofcircle_get()
	{
		$result['results'] = $this->money_db->get_where('specificstep_list_of_circle')->result_array();
		$this->set_response($result, REST_Controller::HTTP_OK);
		return;
	}

	public function getListofoperator_get()
	{
		$result['results'] = $this->money_db->get_where('specificstep_list_of_operator')->result_array();
		$this->set_response($result, REST_Controller::HTTP_OK);
		return;
	}

	public function rechargeApi_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('circlecode', 'Recharge circle code.', 'required');
		$this->form_validation->set_rules('operatorcode', 'Recharge operator code.', 'required');
		$this->form_validation->set_rules('amount', 'Recharge amount.', 'required');
		$this->form_validation->set_rules('number', 'Recharge phone/DTH number.', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'utransactionid' => uniqid(),
				'circlecode' => $this->input->post('circlecode'),
				'operatorcode' => $this->input->post('operatorcode'),
				'number' => $this->input->post('number'),
				'amount' => $this->input->post('amount')
			);
//			echo "<pre>"; exit;
//			echo $this->rechargeUrl.'?'.http_build_query($config_recharge); exit;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->rechargeUrl.'?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function mnpApi_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('mobile', 'mobile no', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'UtransactionID' => uniqid(),
				'mobile' => $this->input->post('mobile')
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://portal.specificstep.com/neo/mnp?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function checkRechargestatus_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		if($this->input->post('ssid'))
		{
			$this->form_validation->set_rules('ssid', 'Transaction SS ID.', 'required');
		}
		else {
			$this->form_validation->set_rules('utransactionid', 'Transaction ID provided by the user.', 'required');
		}
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'utransactionid' => $this->input->post('utransactionid'),
				'ssid' => $this->input->post('ssid'),
				'gettransid' => true,
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->rechargeUrl.'/status?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function fetchPlan_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('circle', 'Circle Name.', 'required');
		$this->form_validation->set_rules('operator', 'Operator Name.', 'required');
		$this->form_validation->set_rules('type', 'mobile / dth.', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'circle' => $this->input->post('circle'),
				'operator' => $this->input->post('operator'),
				'type' => $this->input->post('type'),
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://portal.specificstep.com/neo/plan?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function complain_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('type', 'Complain Type. - SSID/Other', 'required');
		$this->form_validation->set_rules('msg', 'Complain Message.', 'required');
		$this->form_validation->set_rules('utransid', 'SSID.', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'type' => $this->input->post('type'),
				'msg' => $this->input->post('msg'),
				'utransid' => $this->input->post('utransid'),
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->rechargeUrl.'/postcomplain?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function complainStatus_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('complain_id', 'Complain ID', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_recharge = array(
				'username' => $this->username,
				'password' => $this->password,
				'complain_id' => $this->input->post('complain_id'),
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->rechargeUrl.'/complainstatus?'.http_build_query($config_recharge),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$errmsg = array("error_msg"=>$err);
				$this->set_response($errmsg, REST_Controller::HTTP_OK);
				return;
			} else {
				$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
				return;
			}
		} else {
			$errmsg = array("error_msg"=>validation_errors());
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function callBackresponseRecharge_get()
	{
		echo "<pre>";
		print_r($_GET); exit;
	}
}

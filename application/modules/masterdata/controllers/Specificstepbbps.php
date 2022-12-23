<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Specificstepbbps extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        $this->money_db = $this->load->database('money', true);
    }

    protected $username = 'HR1527';
    protected $password = '9999908300';
    protected $bbpsUrl = "https://portal.specificstep.com/neo/bbps";

    public function getCategories_get(){
        $result['results'] = $this->money_db->select('Service_Name')->group_by('Service_Name')->get_where('specificstep_bbps', array('Service_Name !=' => ''))->result_array();
        $this->set_response($result, REST_Controller::HTTP_OK);
        return;
    }

    public function getBillers_post()
    {
        $client_request = json_decode(file_get_contents('php://input'), true);
        $result['results'] = $this->money_db->select('*')->get_where('specificstep_bbps', array('Service_Name' => $client_request['Service_Name']))->result_array();
        $this->set_response($result, REST_Controller::HTTP_OK);
        return;

    }

    public function getbillersbyName_post()
    {
        $client_request = json_decode(file_get_contents('php://input'), true);
        $where = "Operator_Name LIKE '%".$client_request['Operator_Name']."%'";
        $result['results'] = $this->money_db->select('*')->where($where)->get_where('specificstep_bbps', array('Service_Name' => $client_request['Service_Name']))->result_array();
        $this->set_response($result, REST_Controller::HTTP_OK);
        return;

    }

    public function getOperatordetails_post()
    {
        $client_request = json_decode(file_get_contents('php://input'), true);
        if($client_request['Operator_Code'])
        {
            $result['results'] = $this->money_db->select('*')->get_where('specificstep_bbps', array('Operator_Code' => $client_request['Operator_Code']))->row_array();
            $this->set_response($result, REST_Controller::HTTP_OK);
            return;
        }
    }

    public function billFetch_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('Operator_Code', 'Recharge operator code.', 'required');
		$this->form_validation->set_rules('number', 'Biller Service number/Customer No.', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_bbps = array(
				'username' => $this->username,
				'password' => $this->password,
				'operatorcode' => $this->input->post('Operator_Code'),
				'utransactionid' => uniqid(),
				'number' => $this->input->post('number'),
				'field1' => $this->input->post('field1'),
				'field2' => $this->input->post('field2'),
				'field3' => $this->input->post('field3'),
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->bbpsUrl.'/bill?'.http_build_query($config_bbps),
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

	public function billPay_post()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('Operator_Code', 'Recharge operator code.', 'required');
		$this->form_validation->set_rules('number', 'Biller Service number/Customer No.', 'required');
		$this->form_validation->set_rules('amount', 'Recharge amount', 'required');
		$this->form_validation->set_rules('customermobile', 'Customer Mobile Number', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_bbps = array(
				'username' => $this->username,
				'password' => $this->password,
				'operatorcode' => $this->input->post('Operator_Code'),
				'utransactionid' => uniqid(),
				'amount' => $this->input->post('amount'),
				'number' => $this->input->post('number'),
				'lat' => '958686868',
				'long' => '958686868',
				'agentid' => $this->username,
				'paymentmode' => 'wallet',
				'customermobile' => 'customermobile',
				'field1' => $this->input->post('field1'),
				'field2' => $this->input->post('field2'),
				'field3' => $this->input->post('field3'),
			);
			echo "<pre>";
			echo  $this->bbpsUrl.'?'.http_build_query($config_bbps); exit;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->bbpsUrl.'?'.http_build_query($config_bbps),
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
				$this->set_response($response, REST_Controller::HTTP_OK);
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

	public function getBalance_get()
	{
		$config_bbps = array(
			'username' => $this->username,
			'password' => $this->password
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://portal.specificstep.com/neo/bbps/balance?' . http_build_query($config_bbps),
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
			$errmsg = array("error_msg" => $err);
			$this->set_response($errmsg, REST_Controller::HTTP_OK);
			return;
		} else {
			$this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
			return;
		}

		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function checking_recharge_status()
	{
		$client_request = json_decode(file_get_contents('php://input'), true);
		$_POST = $client_request;
		$this->form_validation->set_rules('transactionid', 'Transaction ID', 'required');
		$this->form_validation->set_rules('utransactionid', 'utransactionid', 'required');
		if ($this->form_validation->run() == TRUE) {
			$config_bbps = array(
				'username' => $this->username,
				'password' => $this->password,
				'transactionid' => $this->input->post('transactionid'),
				'utransactionid' => $this->input->post('utransactionid'),
			);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->bbpsUrl.'/status?'.http_build_query($config_bbps),
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
				$this->set_response($response, REST_Controller::HTTP_OK);
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

	public function getReponsebbpsPay_get()
	{

		$callback_response = json_encode($_GET);

		$arr['callback_response'] = $callback_response;

		$this->money_db->insert('specificstep_callback_response', $arr);

		 $response = array('transactionID' => $this->input->get('Txid'),
							'utransactionid' => $this->input->get('utransid'),
							'number' => $this->input->get('Number'),
							'amount' => $this->input->get('Amount'),
							'status' => $this->input->get('Status'),
							'msg' => $this->input->get('Message'),
							'oprefid' => $this->input->get('Oprefid'),
							'opref_id' => $this->input->get('opref_id')
						);
		 echo "<pre>";
		 print_r($response); exit;

	}

	public function fet_get()
	{

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://portal.specificstep.com/neo/bbps/bill?username=HR1527&password=9999908300&operatorcode=36&utransactionid=ANTFIN998763ABC&number=6000026367",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"cache-control: no-cache",
				"postman-token: 4ff50c9c-4e0c-2687-be1d-860bd1457a3f"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}
	}
}

?>

<?php
require APPPATH . '/third_party/crypt/vendor/autoload.php';
require APPPATH . '/libraries/REST_Controller.php';
use phpseclib\Crypt;
class Yesbankpaymentapi extends REST_Controller{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
	}

	public function ePaymentapi_post()
	{
		$this->load->library('form_validation');
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			if ($this->input->server('PHP_AUTH_USER') === 'ANTFIN)2020(' && $this->input->server('PHP_AUTH_PW') === 'ANTP@P@260#') {
				$client_request = json_decode(file_get_contents('php://input'), true);
				$_POST = $client_request;
				$this->form_validation->set_rules('amount', 'Amount Number 16,2 Mandatory', 'trim|required');
				$this->form_validation->set_rules('beneficiary_ifsc', 'Beneficiary IFSC', 'trim|required');
				$this->form_validation->set_rules('beneficiary_account_no', 'Beneficiary Account Number', 'trim|required');
				$this->form_validation->set_rules('beneficiary_name', 'Beneficiary Name', 'trim|required');
				$this->form_validation->set_rules('EmailAddress', 'Beneficiary EmailAddress', 'trim|required');
				$this->form_validation->set_rules('MobileNumber', 'Beneficiary MobileNumber', 'trim|required');
				$this->form_validation->set_rules('CreditorReferenceInformation', 'Beneficiary CreditorReferenceInformation', 'trim|required');
				$this->form_validation->set_rules('AddressLine', 'Beneficiary AddressLine', 'trim|required');
				$this->form_validation->set_rules('PostCode', 'Beneficiary PostCode', 'trim|required');
				$this->form_validation->set_rules('TownName', 'Beneficiary TownName', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					$arr_epayment = array(
						'Data' => array(
							"ConsentId" => "453733",
							"Initiation" => array(
								"InstructionIdentification" => "ANTFIN" . rand(100000, 999999),
								"EndToEndIdentification" => "",
								"InstructedAmount" => array(
									"Amount" => $this->input->post('amount'),
									"Currency" => "INR",
								),
								"DebtorAccount" => array(
									"Identification" => "000190600017042",
									"SecondaryIdentification" => "453733",
								),
								"CreditorAccount" => array(
									"SchemeName" => $this->input->post('beneficiary_ifsc'),
									"Identification" => $this->input->post('beneficiary_account_no'),
									"Name" => $this->input->post('beneficiary_name'),
									"Unstructured" => array(
										"ContactInformation" => array(
											"EmailAddress" => $this->input->post('EmailAddress'),
											"MobileNumber" => $this->input->post('MobileNumber'),
										),
									),
								),
								"RemittanceInformation" => array(
									"Reference" => "FRESCO-101",
									"Unstructured" => array(
										"CreditorReferenceInformation" => $this->input->post('CreditorReferenceInformation'),
									),
								),
								"ClearingSystemIdentification" => "ANY",

							),

						),
						"Risk" => array(
							"DeliveryAddress" => array(
								"AddressLine" => array(
									$this->input->post('AddressLine'),
								),
								"StreetName" => "Acacia Avenue",
								"BuildingNumber" => "27",
								"PostCode" => $this->input->post('PostCode'),
								"TownName" => $this->input->post('TownName'),
								"CountySubDivision" => array(
									"MH"
								),
								"Country" => "IN"
							),
						),
					);
//                echo json_encode($arr_epayment); exit;
					$curl = curl_init();

					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://uatsky.yesbank.in/app/uat/api-banking/domestic-payments",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => json_encode($arr_epayment),
						CURLOPT_HTTPHEADER => array(
							"authorization: Basic dGVzdGNsaWVudDpPeFljb29sQDEyMw==",
							"cache-control: no-cache",
							"content-type: application/json",
							"x-ibm-client-id: df8d194c-33be-44c6-8fb8-27ad46de035a",
							"x-ibm-client-secret: I1eS0aB3vD2nN1dT6lS5bN7yK4tP8fV4cI0tP3fI3lL7uV3eW2"
						),
					));
					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
						$this->set_response("Internal server error", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
						return;
					}
					$arr_response = array(
						'status' => 1,
						'response' => json_decode($response, true)
					);
					$this->set_response($arr_response, REST_Controller::HTTP_OK);
					return;
				} else {
					$arr_response = array(
						'status' => 0,
						'response' => '',
						'error_response' => strip_tags(validation_errors()),
					);
					$this->set_response($arr_response, REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
			}
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function upiPayapi_post()
	{
		$this->load->library('form_validation');
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
			if ($this->input->server('PHP_AUTH_USER') === 'ANTFIN)2020(' && $this->input->server('PHP_AUTH_PW') === 'ANTP@P@260#') {
				$_POST = array();
				$client_request = json_decode(file_get_contents('php://input'), true);
                $_POST = $client_request;
				$this->form_validation->set_rules('amount', 'Amount Number 16,2 Mandatory', 'trim|required');
				$this->form_validation->set_rules('payee_name', 'Payee Name Character 50 Mandatory', 'trim|required');
				$this->form_validation->set_rules('payee_mobile', 'Payee Mobile No Character 12 Optional', 'trim|required');
				$this->form_validation->set_rules('payee_vpa_type', 'PAYEE VPA TYPE Account/ VPA Character 12 Mandatory', 'trim|required');
				$this->form_validation->set_rules('payee_virtual_address', 'Payee Virtual Address Character 255 Mandatory', 'trim|required');
				if($this->input->post('payee_vpa_type') == 'Account')
				{
					$this->form_validation->set_rules('payee_account_no', 'Payee Account Number Number 18 Mandatory', 'trim|required');
					$this->form_validation->set_rules('payee_ifsc_code', 'Payee IFSC Alphanumeric 20 Conditional Mandatory', 'trim|required');
				}
				if ($this->form_validation->run() == TRUE) {
					$pay_id = "ANTFIN".rand(100000,999999);
					$arr_upiPayment = array(
						'YES0000000050953', //PG Merchant ID PG Merchant ID Character 16 Mandatory
						$pay_id, //Order No Unique Merchant Order Number Character 30 Mandatory
						'test', //Transaction Note Order summary description Character 50 Mandatory
						$this->input->post('amount'), //Amount Transaction Amount Number 16,2 Mandatory
						'INR', //Currency Transaction currency Character 3 Mandatory
						'P2P', //Payment Type P2P Character 5 Mandatory
						'Pay', //Transaction Type Pay Character 10 Mandatory
						'7399', //Merchant Category Code 7399 Character 4 Mandatory
						'', //Expiry Time Applicable only for Collect Requests (YYYY:MM:DD HH:MM:SS). For Future use Character 20 Optional
						$this->input->post('payee_account_no'), //Payee Account Number Payee Account Number Number 18 Conditional Mandatory
						$this->input->post('payee_ifsc_code'), //Payee IFSC Payee IFSC Alphanumeric 20 Conditional Mandatory
						'', //Payee Aadhaar No Aadhaar No Character 15 Optional
						$this->input->post('payee_mobile'), //Payee Mobile No Payee Mobile No Character 12 Optional
						$this->input->post('payee_virtual_address'), //Payee Virtual Address Payee Virtual Address Character 255 Mandatory
						'', //Sub Merchant ID Sub-Merchant ID (Not to be used) Character 16 Optional
						'', //White Listed Accounts Whitelisted Accounts (Not to be used) Alpha- Numeric 500 Optional
						'', //Payee MMID Payee MMID Number 100 Optional
						'', //Ref. URL Ref. URL Character 100 Optional
						'UPI', //Transfer Type UPI Character 50 Mandatory
						$this->input->post('payee_name'), //Payee Name Payee Name Character 50 Mandatory
						'', //Payee Address Payee Address (Not to be used) Alphanumeric with special character 35 Optional
						'', //Payee Email Email address of the Payee (Not to be used) Character 255 Optional
						'', //Payer Account No Payer Account Number Alphanumeric 20 Optional
						'', //Payer IFSC Payer IFSC Alphanumeric 12 Optional
						'', //PAYER MB NO Payer Mobile No Character 12 Optional
						$this->input->post('payee_vpa_type'), //PAYEE VPA TYPE Account/ VPA Character 12 Mandatory
						'', //Additional Field 1 For future use Character 100 Optional
						'', //Additional Field 2 For future use Character 100 Optional
						'', //Additional Field 3 For future use Character 100 Optional
						'', //Additional Field 4 For future use Character 100 Optional
						'', //Additional Field 5 For future use Character 100 Optional
						'', //Additional Field 6 For future use Character 100 Optional
						'', //Additional Field 7 For future use Character 100 Optional
						'', //Additional Field 8 For future use Character 100 Optional
						'NA', //Additional Field 9 For future use Character 100 Optional
						'NA', //Additional Field 10 For future use Character 100 Optional
					);
					$yes_bank_request = implode('|', $arr_upiPayment);

					$secureKey = "e77fcc649d9a7aea8603b9cda427060d";
					$enc_data = $this->encryptValue($yes_bank_request, $secureKey);
					$request = array(
						'requestMsg' => $enc_data,
						'pgMerchantId' => "YES0000000050953",
					);
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_PORT => "444",
						CURLOPT_URL => "https://uatsky.yesbank.in:444/app/uat/upi/mePayServerReqImps",
						CURLOPT_SSH_PRIVATE_KEYFILE => 'D:/Yes/selfsigned.jks',
						CURLOPT_SSLCERT => 'D:/Yes/selfsigned.pem',
						CURLOPT_SSLCERTPASSWD => 'Antworks@165',
						CURLOPT_SSL_VERIFYHOST => 0,
						CURLOPT_SSL_VERIFYPEER => TRUE,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => json_encode($request),
						CURLOPT_HTTPHEADER => array(
							"content-type: application/json",
							"x-ibm-client-id: 4d12d9ac-7a38-4c35-a73f-1d5d27815106",
							"x-ibm-client-secret: N3jH8xH5iQ0oV5hN2hL4oL1bK2bH8cG8uI0pX6yV8tF0wG6wI3"
						),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
						$this->set_response("Internal server error", REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
						return;
					}

					$decr_data = $this->decryptValue($response, $secureKey);
					$yes_bank_response = explode('|', $decr_data);

					$arr_response = array(
						'status' => 1,
						'response' => $decr_data
					);
					$this->set_response($arr_response, REST_Controller::HTTP_OK);
					return;
				}
				else{
					$arr_response = array(
						'status' => 0,
						'response' => '',
						'error_response' => strip_tags(validation_errors()),
					);
					$this->set_response($arr_response, REST_Controller::HTTP_BAD_REQUEST);
					return;
				}
			}
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		return;
	}

	public function encryptValue($inputVal, $secureKey)
	{


		$key = '';
		for ($i = 0; $i < strlen($secureKey) - 1; $i += 2) {
			$key .= chr(hexdec($secureKey[$i] . $secureKey[$i + 1]));
		}


		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$pad = $block - (strlen($inputVal) % $block);
		$inputVal .= str_repeat(chr($pad), $pad);

		$encrypted_text = bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $inputVal, MCRYPT_MODE_ECB));


		return $encrypted_text;
	}

	public function decryptValue($inputVal, $secureKey)
	{

		$key = '';
		for ($i = 0; $i < strlen($secureKey) - 1; $i += 2) {
			$key .= chr(hexdec($secureKey[$i] . $secureKey[$i + 1]));
		}

		$encblock = '';
		for ($i = 0; $i < strlen($inputVal) - 1; $i += 2) {
			$encblock .= chr(hexdec($inputVal[$i] . $inputVal[$i + 1]));
		}

		$decrypted_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encblock, MCRYPT_MODE_ECB);

		return $decrypted_text;

	}
}

?>

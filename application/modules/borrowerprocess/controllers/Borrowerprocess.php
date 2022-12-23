<?php
require_once APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

class Borrowerprocess extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Borrowerprocessmodel');
		$this->load->model('Requestmodel');
		$this->load->library('form_validation');

	}

	public function index()
	{
		redirect(base_url() . 'borrower/dashboard');
	}


	public function list_my_proposal()
	{

		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$data['pageTitle'] = "List My Proposal";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/nav', $data);

			$this->load->view('list-my-proposal', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	////
	public function payment()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$this->load->model('Membershipplanmodel');
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
            #Check Membership Plan
            $data['membership'] = $this->Membershipplanmodel->checkMembershipplan();
			if($data['membership']){
				redirect(base_url().'borrowerprocess/kyc-updation');
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];

			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){

				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

			}
			$api = new Api($api_key, $api_secret);
			$order = $api->order->create(array(
					'amount' => 590*100,
					'currency' => 'INR'
				)
			);
			$data['order_id'] = $order->id;
			$data['api_key'] = $api_key;
			$data['pageTitle'] = "Payment";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('payment', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	public function payment_unsuccessful()
	{

		if ($this->session->userdata('borrower_state') == TRUE) {
			$data['title'] = 'payment Successful';
			$this->load->view('template-borrower/header', $data);
			$this->load->view('payment-unsuccessful', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	public function payment_successful()
	{

		if ($this->session->userdata('borrower_state') == TRUE) {
			$data['title'] = 'payment Successful';
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('payment-successful', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	//
	public function kyc_updation()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$current_step = 0;
			$data['info'] = $this->Borrowerprocessmodel->borrower_info();
			
			#Bypass
			$dataSteps = array(
				'step_3' => 5,
				'modified_date' => date('Y-m-d H:i:s'),
			);
			$this->Borrowerprocessmodel->updateSteps($dataSteps);
			$api_response = array(
				'borrower_id' => $this->session->userdata('borrower_id'),
				'api_name' => 'pan',
				'response' => '',
			);
			$this->Borrowerprocessmodel->saveApiResponse($api_response);
			$current_step = 1;
			$data['steps']['step_3'] = 5;
			#End
			
			if ($data['steps']['step_3'] == 0) {
				$arr_borrower = array(

					'headers' => array(
						"client_code" => "ANTW3476",
						"sub_client_code" => "ANTW3476",
						"channel_code" => "WEB",
						"channel_verison" => "1",
						"stan" => strtotime(date('Y-m-d H:i:s')).uniqid(),
						"client_ip" => "",
						"transmission_datetime" => (string)strtotime(date('Y-m-d H:i:s')),
						"operation_mode" => "SELF",
						"run_mode" => "TEST",
						"actor_type" => "TEST",
						"user_handle_type" => "EMAIL",
						"user_handle_value" => $data['info']['email'],
						"location" => "NA",
						"function_code" => "VERIFY_PAN",
						"function_sub_code" => "DATA"
					),

					'request' => array(
						'pan_details' => array(
							"pan_number" => $data['info']['pan'],
							"name" => $data['info']['name'],
							"dob" => date('d/m/Y', strtotime($data['info']['dob'])),
							"document" => ""
						),
					)


				);
				$borrower_pan_json = json_encode($arr_borrower);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://prod.veri5digital.com/service/api/1.0/verifyUserIdDoc ",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $borrower_pan_json,
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/json"),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					echo "cURL Error #:" . $err;
				} else {
					$res = json_decode($response, true);
				}
				if($res['response_status']['status'] == "SUCCESS" && $res['verification_status'] == "SUCCESS")
				{
					$dataSteps = array(
						'step_3' => 1,
						'modified_date' => date('Y-m-d H:i:s'),
					);
					$this->Borrowerprocessmodel->updateSteps($dataSteps);
					$api_response = array(
						'borrower_id' => $this->session->userdata('borrower_id'),
						'api_name' => 'pan',
						'response' => $response,
					);
					$this->Borrowerprocessmodel->saveApiResponse($api_response);
					$current_step = 1;
				}
				#API Error
				if($res['response_status']['status'] == "SUCCESS" && $res['verification_status'] == "FAIL" && $res['response_status']['message'] == 'Unknown Error Occurred. Please try after some time.')
				{
					$dataSteps = array(
						'step_3' => 5,
						'modified_date' => date('Y-m-d H:i:s'),
					);
					$this->Borrowerprocessmodel->updateSteps($dataSteps);
					$api_response = array(
						'borrower_id' => $this->session->userdata('borrower_id'),
						'api_name' => 'pan',
						'response' => $response,
					);
					$this->Borrowerprocessmodel->saveApiResponse($api_response);
					$current_step = 1;
				}
				
				else{
					if($res['response_status']['message'] == 'PAN format is correct and PAN number is correct matching against DOB. However, Name is Incorrect.')
					{
						$dataSteps = array(
							'step_3' => 1,
							'modified_date' => date('Y-m-d H:i:s'),
						);
						$this->Borrowerprocessmodel->updateSteps($dataSteps);
						$api_response = array(
							'borrower_id' => $this->session->userdata('borrower_id'),
							'api_name' => 'pan',
							'response' => $response,
						);
						$this->Borrowerprocessmodel->saveApiResponse($api_response);
						$current_step = 1;
					}
					else{
						$dataSteps = array(
							'step_3' => 3,
							'modified_date' => date('Y-m-d H:i:s'),
						);
						$this->Borrowerprocessmodel->updateSteps($dataSteps);

						$api_response = array(
							'borrower_id' => $this->session->userdata('borrower_id'),
							'api_name' => 'pan',
							'response' => $response,
						);
						$this->Borrowerprocessmodel->saveApiResponse($api_response);
						$current_step = 0;
					}

				}

			}
			if ($data['steps']['step_3'] == 2 || $data['steps']['step_3'] == 3) {
				$data['apiresponse'] = $this->Borrowerprocessmodel->getpanApiresponse($api_name = 'pan');

			}
			$data['pageTitle'] = "Kyc Updation";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			if ($current_step == 0) {
				$this->load->view('kyc-updation-after-invalid', $data);
			} else {
				$this->load->view('kyc-updation', $data);
			}
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	//
	public function credit_bureau()
	{
		error_reporting(E_ALL);
		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$borrower_info = $this->Borrowerprocessmodel->borrower_info();
			$proposal_info = $this->Borrowerprocessmodel->get_currentopen_proposal();
			$arr = explode(' ', $borrower_info['name']);
			$num = count($arr);
			$first_name = $middle_name = $last_name = null;
			if ($num == 1) {
				$first_name = $arr['0'];
				$last_name = $arr['0'];
			}
			if ($num == 2) {
				$first_name = $arr['0'];
				$last_name = $arr['1'];
			}
			if ($num > 2) {
				$first_name = $arr['0'];
				$last_name = $arr['2'];
			}
			$dob = str_replace('-', '', $borrower_info['dob']);
			$curl = curl_init();
			$xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="http://nextgenws.ngwsconnect.experian.com">
   <SOAP-ENV:Header />
   <SOAP-ENV:Body>
      <urn:process>
         <urn:cbv2String><![CDATA[<INProfileRequest>
   <Identification>
      <XMLUser>cpu2ant_prod01</XMLUser>
      <XMLPassword>20@March20</XMLPassword>
   </Identification>
   <Application>
      <FTReferenceNumber></FTReferenceNumber>
      <CustomerReferenceID>' . $borrower_info['borrower_id'] . '</CustomerReferenceID>
      <EnquiryReason>13</EnquiryReason>
      <FinancePurpose>99</FinancePurpose>
      <AmountFinanced>' . $proposal_info['loan_amount'] . '</AmountFinanced>
      <DurationOfAgreement>' . $proposal_info['tenor_months'] . '</DurationOfAgreement>
      <ScoreFlag>1</ScoreFlag>
      <PSVFlag></PSVFlag>
   </Application>
   <Applicant>
      <Surname>' . $last_name . '</Surname>
      <FirstName>' . $first_name . '</FirstName>
      <MiddleName1 />
      <MiddleName2 />
      <GenderCode>2</GenderCode>
      <IncomeTaxPAN>' . $borrower_info['pan'] . '</IncomeTaxPAN>
      <PAN_Issue_Date />
      <PAN_Expiration_Date />
      <PassportNumber />
      <Passport_Issue_Date />
      <Passport_Expiration_Date />
      <VoterIdentityCard />
      <Voter_ID_Issue_Date />
      <Voter_ID_Expiration_Date />
      <Driver_License_Number />
      <Driver_License_Issue_Date />
      <Driver_License_Expiration_Date />
      <Ration_Card_Number />
      <Ration_Card_Issue_Date />
      <Ration_Card_Expiration_Date />
      <Universal_ID_Number />
      <Universal_ID_Issue_Date />
      <Universal_ID_Expiration_Date />
      <DateOfBirth>' . $dob . '</DateOfBirth>
      <STDPhoneNumber />
      <PhoneNumber>' . $borrower_info['mobile'] . '</PhoneNumber>
      <Telephone_Extension />
      <Telephone_Type />
      <MobilePhone>' . $borrower_info['mobile'] . '</MobilePhone>
      <EMailId />
   </Applicant>
   <Details>
      <Income />
      <MaritalStatus />
      <EmployStatus />
      <TimeWithEmploy />
      <NumberOfMajorCreditCardHeld>5</NumberOfMajorCreditCardHeld>
   </Details>
   <Address>
      <FlatNoPlotNoHouseNo>' . $borrower_info['r_address'] . '</FlatNoPlotNoHouseNo>
      <BldgNoSocietyName>' . $borrower_info['r_address1'] . '</BldgNoSocietyName>
      <RoadNoNameAreaLocality></RoadNoNameAreaLocality>
      <City>' . $borrower_info['r_city'] . '</City>
      <State>' . $borrower_info['r_state'] . '</State>
      <PinCode>' . $borrower_info['r_pincode'] . '</PinCode>
   </Address>
  
   <AdditionalAddress>
      <FlatNoPlotNoHouseNo />
      <BldgNoSocietyName />
      <RoadNoNameAreaLocality />
      <Landmark />
      <State />
      <PinCode />
   </AdditionalAddress>
</INProfileRequest>
]]></urn:cbv2String>
      </urn:process>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
			curl_setopt_array($curl, array(
				CURLOPT_PORT => "8443",
				CURLOPT_URL => "https://connect.experian.in:8443/ngwsconnect/ngws",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 60,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $xml,
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: text/xml",
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
			} else {

				$year = date("Y");
				$month = date("m");
				$filename = FCPATH . "experien/reports/" . $year;
				$filename2 = FCPATH . "experien/reports/" . $year . "/" . $month;

				if (file_exists($filename) == true) {
					if (file_exists($filename2) == false) {
						mkdir($filename2, 0777);
					}
				} else {
					mkdir($filename, 0777);
					if (file_exists($filename2) == false) {
						mkdir($filename2, 0777);
					}
				}
				$report_file_name = "experien/reports/" . $year . "/" . $month . "/report_" . $this->session->userdata('borrower_generated_id'). "_". date('m-d-Y_H-i-s') . ".xml";
				$file_experian = FCPATH . $report_file_name;
				if(file_exists($file_experian))
				{
					$report_file_name = "experien/reports/" . $year . "/" . $month . "/report_". $this->session->userdata('borrower_generated_id'). "_" . uniqid() . ".xml";
				}

				$myfile = fopen($report_file_name, "w");
				fwrite($myfile, htmlspecialchars_decode($response));
				fclose($myfile);
				$arr_response = array(
					'borrower_id' => $this->session->userdata('borrower_id'),
					'borrower_request' => $xml,
					'experian_response_file' => $report_file_name,

				);
				$this->Borrowerprocessmodel->addExperian_response($arr_response);
				$dataSteps = array(
					'step_5' => 1,
				);
				$this->Borrowerprocessmodel->updateSteps($dataSteps);
				//Credit Engine
				$this->load->model('Creditenginemodel');
				$this->Creditenginemodel->Engine($this->session->userdata('borrower_id'));
				//
				redirect(base_url() . 'borrowerprocess/bank-account-verify');

			}

		}
		else{
			redirect(base_url() . 'login/borrower');
		}
	}
	//
	/////////////////////////////////////////////Bank Accounts Process
	public function bank_account_verify()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['verified'] = $this->Borrowerprocessmodel->getBankdetails();
			if ($data['verified']) {
				$data['bank_list'] = $this->Borrowerprocessmodel->get_Banklist();
				$data['title'] = 'Bank Account Verify';
				$this->load->view('template-borrower/header', $data);
				$this->load->view('template-borrower/process', $data);
				$this->load->view('bank_account_verified', $data);
				$this->load->view('template-borrower/footer', $data);
			} else {
				$data['bank_list'] = $this->Borrowerprocessmodel->get_Banklist();
				$data['title'] = 'Bank Account Verify';
				$this->load->view('template-borrower/header', $data);
				$this->load->view('template-borrower/process', $data);
				$this->load->view('bank_account_verify', $data);
				$this->load->view('template-borrower/footer', $data);
			}

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	public function bank_statemant()
	{

		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$data['account_info'] = $this->Borrowerprocessmodel->getBankdetails();
			$data['title'] = 'Bank Statement';
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('bank_statemant', $data);
			$this->load->view('template-borrower/footer', $data);
		} else {
			redirect(base_url() . 'login/borrower');
		}


	}

	public function add_bank()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {

			$data['account_info'] = $this->Borrowerprocessmodel->getBankdetails();
			$data_session = json_encode(array(
				'cSess' => $_SESSION['cobSession'],
				'uSess' => $_SESSION['userSession'],
			));
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.whatsloan.com/v1/bank/getToken",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $data_session,
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: application/json",
					"token: " . WHATAPP_TOKEN . ""
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				$res = json_decode($response, true);
			}
			$data['token'] = $res['result'];
			$data['title'] = 'Bank Statement';
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('add-bank', $data);
			$this->load->view('template-borrower/footer', $data);
		} else {
			redirect(base_url() . 'login/borrower');
		}

	}

	public function returnResponse()  //After Result Get bank, Get Analysis
	{
		if ($this->session->userdata('borrower_state') == TRUE) {

			if (isset($_GET['JSONcallBackStatus'])) {
				$response = json_decode($_GET['JSONcallBackStatus'], true);
				if ($response[0]['providerAccountId']) {
					///////////////////////////////////////////////Get Bank
					$data_session = json_encode(array(
						'cSess' => $_SESSION['cobSession'],
						'uSess' => $_SESSION['userSession'],
					));
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_URL => "https://api.whatsloan.com/v1/bank/getAccounts ",
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 60,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $data_session,
						CURLOPT_HTTPHEADER => array(
							"cache-control: no-cache",
							"content-type: application/json",
							"token: " . WHATAPP_TOKEN . ""
						),
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
						echo "cURL Error #:" . $err;
					} else {
						$res = json_decode($response, true);
						if ($res['result']['account'][0]['id']) {
							$data_session = json_encode(array(
								'cSess' => $_SESSION['cobSession'],
								'uSess' => $_SESSION['userSession'],
								'accId' => $res['result']['account'][0]['id'],
							));
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_URL => "https://api.whatsloan.com/v1/bank/getAnalysis  ",
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 60,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "POST",
								CURLOPT_POSTFIELDS => $data_session,
								CURLOPT_HTTPHEADER => array(
									"cache-control: no-cache",
									"content-type: application/json",
									"token: " . WHATAPP_TOKEN . ""
								),
							));

							$response = curl_exec($curl);
							$err = curl_error($curl);

							curl_close($curl);

							if ($err) {
								echo "cURL Error #:" . $err;
							} else {

								$this->Borrowerprocessmodel->saveAnalysisaccount($res['result']['account'][0]['id'], $response);


								$borrower_file_info = array(
									'borrower_id' => $this->session->userdata('borrower_id'),
									'docs_type' => 'online_bank_statement',
									'docs_no' => $res['result']['account'][0]['id'],
									'whatsloan_response' => $response,
									'date_added' => date('Y-m-d H:i:s'),
								);
								$insert_id = $this->Borrowerprocessmodel->insert_kyc_statement($borrower_file_info);

								$dataSteps = array(
									'step_6' => 2,
								);
								$this->Borrowerprocessmodel->updateSteps($dataSteps);

								redirect(base_url() . 'borrowerprocess/profile-confirmation');
							}
						}
					}
				}
			} else {
				redirect(base_url() . 'borrowerprocess/bank-statemant');
			}
		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	///
	/// APIS
	public function bank_account_verification()
	{
		
		if ($this->session->userdata('borrower_state') == TRUE) {
			$this->db->get_where('p2p_borrower_bank_details', array('borrower_id' => $this->session->userdata('borrower_id')));
			if($this->db->affected_rows()>0)
        	{
				$dataSteps = array(
					'step_6'=>1,
				);
				$this->Borrowerprocessmodel->updateSteps($dataSteps);
				redirect(base_url().'borrowerprocess/bank-statemant');
			}
			$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
			$this->form_validation->set_rules('caccount_no', 'Conform account no', 'trim|required|matches[account_no]');
			$this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'trim|required');
			if ($this->form_validation->run() == TRUE) {
				$data = json_encode(
					array(
						"fund_account" => array(
							"account_type" => 'bank_account',
							"bank_account" => array(
								"name" => $this->session->userdata('name'),
								"ifsc" => $this->input->post('ifsc_code'),
								"account_number" => $this->input->post('account_no'),
							),
						),
						"amount" => "100",
						"currency" => "INR",
						"notes" => array(
							"random_key_1" => "",
							"random_key_2" => "",
						),
					)
				);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/json",
						"authorization: Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v",
					),
				));
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				if ($err) {
					///alert emil to admin
				} else {
					$res = json_decode($response, true);
					$bank_res = array(
						'borrower_id'=>$this->session->userdata('borrower_id'),
						'fav_id'=>$res['id']?$res['id']:'',
						'razorpay_response_bank_ac'=>$response,
					);
					$this->db->insert('p2p_borrower_bank_res', $bank_res);
					if($res['id'])
					{
						$bank_data = array(
							'borrower_id'=>$this->session->userdata('borrower_id'),
//							'bank_name'=>$this->session->userdata('name'),
							'account_number'=>$this->input->post('account_no'),
							'ifsc_code'=>$this->input->post('ifsc_code'),
							'is_verified'=>0,
						);
						$this->Borrowerprocessmodel->updateBankaccountno($bank_data);
						$dataSteps = array(
							'step_6'=>1,
						);
						$this->Borrowerprocessmodel->updateSteps($dataSteps);
						redirect(base_url().'borrowerprocess/bank-statemant');
					}
					else{
						$msg = "Incorrect information, please check your details";
						$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
						redirect(base_url().'borrowerprocess/bank-account-verify');
					}
				}
			}
			else{
				$msg = "Incorrect information, please check your details";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url().'borrowerprocess/bank-account-verify');
			}

		} else {
			$msg = "Please login first";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'login/borrower');
		}
	}

	public function wRegistration()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {

			$result = $this->Borrowerprocessmodel->wRegistration();
			$data = json_encode(array(
				'loginName' => $this->session->userdata('email'),
				'email' => $this->session->userdata('email'),
				'password' => $result['password'],
			));
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://api.whatsloan.com/v1/bank/regUser",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache",
					"content-type: application/json",
					"token: " . WHATAPP_TOKEN . ""
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				$res = json_decode($response, true);
				if ($res['success'] == 1) {
					$this->Borrowerprocessmodel->is_registerW($result['id']);
					return true;
				}
			}
		} else {
			redirect(base_url() . 'login/borrower');
		}

	}

	public function wLogin()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$result = $this->Borrowerprocessmodel->wLogin();
			if ($result) {
				$data = json_encode(array(
					'loginName' => $this->session->userdata('email'),
					'password' => $result['password'],
				));
				$curl = curl_init();

				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://api.whatsloan.com/v1/bank/userLogin",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $data,
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"content-type: application/json",
						"token: " . WHATAPP_TOKEN . ""
					),
				));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					echo "cURL Error #:" . $err;
				} else {
					$response = json_decode($response, true);
					$_SESSION['userSession'] = $response['result']['user']['session']['userSession'];
					$_SESSION['cobSession'] = $response['result']['cobSession'];
					return true;
				}
			} else {

			}
		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	public function statementParseAndCommit() /////////////////// Upload PDF Document and Get Analysis
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$this->load->model('borroweraction/Borrowerkycmodel');
			$config['upload_path'] = "./assets/borrower-documents";
			$config['allowed_types'] = 'pdf';
			$config['encrypt_name'] = TRUE;
			$config['max_width'] = '0';
			$config['max_height'] = '0';
			$config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload("bank_statement_file")) {
				$data = $this->upload->data();
				$borrower_file_info = array(
					'borrower_id' => $this->session->userdata('borrower_id'),
					'docs_type' => 'bank_statement',
					'docs_name' => $data['file_name'],
					'date_added' => date('Y-m-d H:i:s'),
				);
				$insert_id = $this->Borrowerprocessmodel->insert_kyc_statement($borrower_file_info);
				$dataSteps = array(
					'step_6' => 2,
				);
				$this->Borrowerprocessmodel->updateSteps($dataSteps);

				redirect(base_url() . 'borrowerprocess/profile-confirmation');
				/*
				$filepath = FCPATH . 'assets/borrower-documents/' . $borrower_file_info['docs_name'];
				$filename = realpath($filepath);
				$url = 'https://api.whatsloan.com/v1/bank/statementParseAndCommit';
				$finfo = new finfo(FILEINFO_MIME_TYPE);
				$mimetype = $finfo->file($filename);
				$ch = curl_init($url);
				$request_headers = array(
					"token: ".WHATAPP_TOKEN.""
				);
				$cfile = curl_file_create($filename, $mimetype, basename($filename));
				$data = array('file' => $cfile,
							  'bankName'=>$this->input->post('bank_name'),
							  'cSess'=>$this->session->userdata('cobSession'),
							  'uSess'=>$this->session->userdata('userSession')
				);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				$r = curl_getinfo($ch);
				if ($response) {
					$res = json_decode($response, true);
					$itemAccountId = @$res['result']['ManualAccount']['ManualAccountType']['Bank']['itemAccountId'];
					if($itemAccountId) {
						$data_session = json_encode(array(
							'cSess' => $_SESSION['cobSession'],
							'uSess' => $_SESSION['userSession'],
							'accId' => $itemAccountId,
						));
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_URL => "https://api.whatsloan.com/v1/bank/getAnalysis  ",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $data_session,
							CURLOPT_HTTPHEADER => array(
								"cache-control: no-cache",
								"content-type: application/json",
								"token: ".WHATAPP_TOKEN.""
							),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {
							echo "cURL Error #:" . $err;
						} else {
							$data = array(
								'doc_id' => $insert_id,
								'whatsloan_response' => $response,
							);
							$this->Borrowerprocessmodel->updateStatementresponse($data);
							$dataSteps = array(
								'step_6' => 2,
							);
							$this->Borrowerprocessmodel->updateSteps($dataSteps);
							redirect(base_url() . 'borrowerprocess/profile-confirmation');
						}

						redirect(base_url() . 'borrowerprocess/profile-confirmation');
					}
					else{
						$dataSteps = array(
							'step_6' => 2,
						);
						$this->Borrowerprocessmodel->updateSteps($dataSteps);
						redirect(base_url() . 'borrowerprocess/profile-confirmation');
					}
				} */
			} else {
				$error = $this->upload->display_errors();
				//echo $error; exit;
				$msg = "Some error was occurred, please try again";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'borrowerprocess/bank-statemant');
			}
		} else {
			redirect(base_url() . 'login/borrower');
		}
	}



	//////////// END Bank Account Process


	///////Profile Confirmation Step
	public function profile_confirmation()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();
			$data['borrower_info'] = $this->Borrowerprocessmodel->borrower_info_details();
			if ($data['borrower_info']['occuption_id'] == 1) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 2) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 3) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 4) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 5) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 6) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 7) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			$data['kycDoctype'] = $this->Borrowerprocessmodel->kycDoctype();

			$data['currentopen_proposal'] = $this->Borrowerprocessmodel->get_currentopen_proposal();

			$data['pageTitle'] = "List My Proposal";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('profile-details', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	function confirm_profile_confirmation()
	{
		$dataSteps = array(
			'step_7' => 1,
		);
		$this->Borrowerprocessmodel->updateSteps($dataSteps);
		redirect(base_url() . 'borrowerprocess/live-listing');
	}
	///

	///////Profile Confirmation Step
	public function live_listing()
	{

		if ($this->session->userdata('borrower_state') == TRUE) {
			$current_step = $this->Borrowerprocessmodel->steps();
			if ($current_step != $this->uriSegmant()) {
				redirect(base_url() . $current_step);
			}
			$data['steps'] = $this->Borrowerprocessmodel->getBorrowersteps();

			$data['proposal'] = $this->Borrowerprocessmodel->get_currentopen_proposal();
			$this->load->model('Creditenginemodel');
			$this->Creditenginemodel->Engine($this->session->userdata('borrower_id'));
			$data['rating'] = $this->Borrowerprocessmodel->getRating();
			if ($data['steps']['step_2'] == 0) {
				redirect(base_url() . 'borrowerprocess/payment');

			}
			$data['borrower_info'] = $this->Borrowerprocessmodel->borrower_info_details();
			if ($data['borrower_info']['occuption_id'] == 1) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 2) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 3) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 4) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 5) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 6) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			if ($data['borrower_info']['occuption_id'] == 7) {
				$data['occuptionDetails'] = $this->Borrowerprocessmodel->occuptionDetails($table = 'p2p_borrower_salaried_details');
			}
			$data['proposal'] = $this->Borrowerprocessmodel->get_currentopen_proposal();
			//$data['occuption'] = $this->Borrowerprocessmodel->occuptionDetails();
			$add_date = new DateTime($data['proposal']['date_of_added']);

			$today = new DateTime(date('Y-m-d'));
			$difference = $add_date->diff($today);

			$time_left = 30 - $difference->d;
			$data['proposal']['time_left'] = $time_left;
			$data['pageTitle'] = "List My Proposal";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/process', $data);
			$this->load->view('list-my-proposal', $data);
			$this->load->view('template-borrower/footer', $data);

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}

	public function takeliveproposal()
	{
		if ($this->session->userdata('borrower_state') == TRUE) {
			$result = $this->Borrowerprocessmodel->takeliveproposal();
			$dataSteps = array(
				'step_8' => 1,
			);
			$this->Borrowerprocessmodel->updateSteps($dataSteps);
			if ($result) {
				$msg = "Congratulations! Your Loan Application is live now";
				$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
				redirect(base_url() . 'borrower/live-listing');
			} else {
				$msg = "Some error was occurred, please try again";
				$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
				redirect(base_url() . 'borrower/live-listing');
			}

		} else {
			redirect(base_url() . 'login/borrower');
		}
	}
	///
	///

	public function check_borrower_registration_payment()
	{
		$result = $this->Borrowerprocessmodel->check_borrower_payment_registration();

		if ($result) {
			return true;
		} else {
			redirect(base_url() . 'borrower/payment');
		}
	}

	public function uriSegmant()
	{
		return $this->uri->segment(1) . '/' . $this->uri->segment(2);
	}


	public function checking_steps()
	{
		$current_step = $this->Borrowerprocessmodel->steps();
		if ($this->session->userdata('all_steps_complete') == 1) {
			redirect(base_url() . 'borrower/dashboard');
		}
		if ($current_step != $this->uriSegmant()) {
			redirect(base_url() . $current_step);
		}
	}
}

?>

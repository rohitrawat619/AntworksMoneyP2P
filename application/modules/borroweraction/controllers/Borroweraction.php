<?php
class Borroweraction extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Borroweractionmodel', 'borrower/Borrowermodelbackend'));
		$this->load->library('form_validation');
    }

    public function payment_response()
    {

    }

    public function takeliveproposal()
    {
        if($this->session->userdata('borrower_state') == TRUE)
        {
           $result = $this->Borroweractionmodel->takeliveproposal();
           if($result)
           {
               $msg = "Congratulations! Your Loan Application is live now";
               $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
               redirect(base_url() . 'borrower/list_my_proposal');
           }
           else{
               $msg = "Some error was occurred, please try again";
               $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
               redirect(base_url() . 'borrower/list_my_proposal');
           }

        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function accept_bid_borrower()
    {
        if($this->session->userdata('borrower_state') == TRUE)
        {

            $result = $this->Borroweractionmodel->accept_bid_borrower();
            if($result)
            {
               $msg = "Thank you for accepting the Bid";
               $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
               redirect(base_url().'borrower/pending_signature');
            }
            else{
                $msg = "You have already accepted this Bid";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url().'borrower/live_listing');
            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function accept_borrower_signature()
    {
        if($this->session->userdata('borrower_state') == TRUE)
        {
            $result = $this->Borroweractionmodel->accept_borrower_signature();
            if($result)
            {
               $msg = "You have successfully signed";
               $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
               redirect(base_url().'borrower/loan_agreement_copies');
            }
            else{
                $msg = "You have already accepted this Bid";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url().'borrower/pending_signature');
            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function add_docs_borrower()
    {
        if ($this->session->userdata('borrower_state') == TRUE) {
            if ($_FILES) {
                $this->load->model(array('borroweraction/Borrowerkycmodel', 'p2padmin/Documents'));
                $config['upload_path'] = "./assets/borrower-documents";
                $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                $config['encrypt_name'] = TRUE;
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);

                if($this->upload->do_upload("pan_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'pan',
                        'docs_no' => $this->input->post('pan'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("kyc_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => $this->input->post('document_type'),
                        'docs_no' => $this->input->post('doc_no'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }

                if (isset($_FILES['doc_file'])) {
                    $total = count($_FILES['doc_file']['name']);

                    if ($total > 0) {
                        $i = 0;
                        foreach ($_FILES['doc_file']['name'] as $key => $image) {
                            $_FILES['images[]']['name'] = $_FILES['doc_file']['name'][$key];
                            $_FILES['images[]']['type'] = $_FILES['doc_file']['type'][$key];
                            $_FILES['images[]']['tmp_name'] = $_FILES['doc_file']['tmp_name'][$key];
                            $_FILES['images[]']['error'] = $_FILES['doc_file']['error'][$key];
                            $_FILES['images[]']['size'] = $_FILES['doc_file']['size'][$key];

                            $this->upload->initialize($config);
                            $this->load->library('upload', $config);

                            if (!$this->upload->do_upload('images[]')) {
                                $error = array('error' => $this->upload->display_errors());
                                print_r($error);
                                exit;
                                //$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$error));
                                //redirect(base_url().'management/add');
                            } else {
                                $data = array('upload_data' => $this->upload->data());
                                $uploads['docs_type'] = $_POST['doc_name'][$i];
                                $uploads['docs_name'] = $data['upload_data']['file_name'];
                                $uploads['borrower_id'] = $this->session->userdata('borrower_id');
                                $status = $this->Documents->add_docs_borrower($uploads);
                            }
                            $i++;
                        }
                    }
                }
                //$status = $this->P2pmodel->add_docs_borrower($uploads);
                if ($status) {
                    $msg = "Your documents are uploaded successfully.";
                    $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                    redirect(base_url() . 'borrower/kyc_updation');
                } else {
                    $msg = "Something went wrong!";
                    $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                    redirect(base_url() . 'borrower/kyc_updation');
                }
            } else {
                $msg = "Please Select a File! We accept .doc, .dox, .jpg, .png, .pdf file formats only";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'borrower/kyc_updation');
            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function add_docs_borrower_new()
    {

        if ($this->session->userdata('borrower_state') == TRUE) {
            if ($_FILES) {
                $this->load->model(array('borroweraction/Borrowerkycmodel', 'p2padmin/Documents'));
                $config['upload_path'] = "./assets/borrower-documents";
                $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                $config['encrypt_name'] = TRUE;
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['overwrite'] = TRUE;
                $this->load->library('upload', $config);

                if($this->upload->do_upload("pan_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'pan',
                        'docs_no' => $this->input->post('doc_no_pan'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("aadhar_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'Aadhar',
                        'docs_no' => $this->input->post('doc_no_aadhar'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("voterid_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'Voter Id',
                        'docs_no' => $this->input->post('doc_no_voterid'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("ration_card")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'Ration Card',
                        'docs_no' => $this->input->post('doc_no_rashancard'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("passport")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'Passport',
                        'docs_no' => $this->input->post('doc_no_passport'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
                if($this->upload->do_upload("other")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => 'Other',
                        'docs_no' => $this->input->post('doc_no_other'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }

                $msg = "Your documents are uploaded successfully.";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url() . 'borrower/kyc_updation');

            } else {
                $msg = "Please Select a File! We accept .doc, .dox, .jpg, .png, .pdf file formats only";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'borrower/kyc_updation');
            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function getLoanaggrement()
    {
        if($this->session->userdata('borrower_state') == TRUE)
        {
            $data['results'] = $this->Borroweractionmodel->loanaggrement();
            $data['table'] = "";
            $data['html'] = "";
            $data['portal_name'] = 'www.antworksp2p.com';
            $data['today'] = date("d-m-Y");
            $data['current_time_stamp'] = $date = date('d/m/Y H:i:s', time());
            if($data['results'])
            {
              echo $this->load->view('loan-aggrement-borrower', $data, true);
            }
            else{

            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }

    }

    public function sendotpSignatuereaccept()
    {
        $this->load->database();
        if(!empty($_POST['bid_registration_id'])){
        	    $this->load->model('Smssetting');
                $arr=array();
                $number = $this->session->userdata('mobile');
                $otp = rand(100000,999999);

                $this->db->select('*');
                $this->db->from('p2p_borrower_otp_signature');
                $this->db->where('mobile', $number);
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->where('is_verified', '0');
                $this->db->where('date_added >= now() - INTERVAL 10 MINUTE');
                $query = $this->db->get();
//                echo $this->db->last_query(); exit;
                if($this->db->affected_rows()>0)
                {
                    $result = count($query->result_array());
                    if($result>3)
                    {
                        echo 2; exit;
                    }
                    else{
                        $arr["mobile"]=$number;
                        $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                        $arr["otp"]=$otp;
                        $query = $this->db-> insert('p2p_borrower_otp_signature',$arr);
                    }

                }
                else{
                    $arr["mobile"]=$number;
                    $arr["bid_registration_id"]=$this->input->post('bid_registration_id');
                    $arr["otp"]=$otp;
                    $query = $this->db-> insert('p2p_borrower_otp_signature',$arr);
                }



                $msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
				$msg = "Hi User Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
                $message = rawurlencode($msg);
                $smsSetting = $this->Smssetting->smssetting();
                // Prepare data for POST request
                $data = array('username' => $smsSetting['username'], 'hash' => $smsSetting['hash_api'], 'numbers' => $number, "sender" => $smsSetting['sender'], "message" => $message);

                // Send the POST request with cURL
                $ch = curl_init('https://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                echo $response; exit;
                // Create session for verifying number


                echo 1; exit;

        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }

    public function verify_signature()
    {
        if($this->session->userdata('borrower_state') == TRUE) {
            if (!empty($_POST['bid_registration_id']) && !empty($_POST['otp'])) {
                $this->load->database();
                $number = $this->session->userdata('mobile');
                $otp = $_POST['otp'];
                $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
                $this->db->from('p2p_borrower_otp_signature');
                $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                $this->db->where('mobile', $number);
                $this->db->order_by('id', 'desc');
                $this->db->limit(1);
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
                    $result = $query->row();
                    if ($otp == $result->otp) {
                        if ($result->MINUTE <= 10) {
                            $result = $this->Borroweractionmodel->accept_borrower_signature();
                            if($result)
                            {
                                $data['response'] = "verify";
                            }
                            else{
                                $data['response'] = "Already verified";
                            }

                            $this->db->where('otp', $otp);
                            $this->db->where('mobile', $number);
                            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                            $this->db->set('is_verified', 1);
                                $this->db->update('p2p_borrower_otp_signature');
                        } else {
                            $data['response'] = "Expired";
                        }
                    } else {
                        $data['response'] = "Not";
                    }

                } else {
                    $data['response'] = "Not";
                }
                echo json_encode($data);
                exit;

            } else {
                echo "OOPS! You do not have Direct Access. Please Login";
                exit;
            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }
    }

    public function getLoanaggrementcopy()
    {
        if($this->session->userdata('borrower_state') == TRUE)
        {
            $data['results'] = $this->Borroweractionmodel->loanaggrement();
            $data['table'] = "";
            $data['html'] = "";
            $data['portal_name'] = 'www.antworksp2p.com';
            $data['today'] = date("l-m-Y");
            $data['current_time_stamp'] = $date = date('d/m/Y H:i:s', time());
            if($data['results'])
            {
              echo $this->load->view('loan-aggrement-borrower-copies', $data, true);
            }
            else{

            }
        }
        else{
            redirect(base_url() . 'login/borrower');
        }

    }

    public function requestnamechange()
    {
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
         $this->load->model('borrowerprocess/Borrowerprocessmodel');
         $api_record = $this->Borroweractionmodel->getPrevoiusresponseapi($api_name = 'pan');
         $record = json_decode($api_record['response'], true);
         $name = str_replace('  ', ' ',$record['result']['name']);
         if($name == strtoupper(str_replace('  ', ' ', $this->input->post('name'))))
         {

             $dataSteps = array(
                 'step_3'=>1,
                 'modified_date'=>date('Y-m-d H:i:s'),
             );
             $this->Borrowerprocessmodel->updateSteps($dataSteps);

             $insert_request = array(
                 'borrower_id'=>$this->session->userdata('borrower_id'),
                 'type'=>'name',
                 'request_data'=>$this->input->post('name'),
                 'status'=>1,
             );

             $this->Borroweractionmodel->updateName();

             $this->Borroweractionmodel->insertRequest($insert_request);

             redirect(base_url().'borrowerprocess/kyc-updation');
         }
         else{

             $dataSteps = array(
                 'step_3'=>3,
                 'modified_date'=>date('Y-m-d H:i:s'),
             );
             $this->Borrowerprocessmodel->updateSteps($dataSteps);
             redirect(base_url().'borrowerprocess/kyc-updation');

         }

        }
        else{

        }
    }

    public function subscribedEmail()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
        $errmsg = $this->form_validation->error_array();
        if ($this->form_validation->run() == TRUE) {
            $result = $this->Borroweractionmodel->subscribedEmail();
            if ($result) {
                redirect(base_url() . 'thank-you/subscribed');
            } else {
                redirect(base_url());
            }
        }
        else{
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
            redirect(base_url());
        }

    }

	public function changeaddress()
	{
		if ( $this->session->userdata('borrower_state') == TRUE )
		{

			$result = $this->Borrowermodelbackend->updateAddress();
			if($result)
			{
				$msg="Your Address Change Request is submitted successfully. We shall update you shortly";
				$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
				redirect(base_url().'borrower/borrowerrequest/change-address');
			}
			else{
				$msg="OOPS! Something went wrong please check you credential and try again";
				$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
				redirect(base_url().'borrower/borrowerrequest/change-address');
			}
		}
		else
		{
			redirect(base_url().'login/borrower');
		}
	}

	public function addNewproposal()
	{
		if ( $this->session->userdata('borrower_state') == TRUE )
		{
		$this->form_validation->set_rules('loan_amount_borrower', 'Loan amount', 'trim|required');
		$this->form_validation->set_rules('tenor_borrower', 'Tenor', 'trim|required');
		$this->form_validation->set_rules('borrower_interest_rate', 'Interest rate', 'trim|required');
		$this->form_validation->set_rules('p2p_product_id', 'Loan purpose', 'trim|required');
		$this->form_validation->set_rules('borrower_loan_desc', 'Loan description', 'trim|required');
		$this->form_validation->set_rules('term_and_condition', 'Term and condition', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$result = $this->Borroweractionmodel->addNewproposal();
				if($result){
					$msg="Thank you for adding a new Loan Application";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'borrower/live-listing');
				}
				else{
					$errmsg = "OOPS! Something went wrong please check you credential and try again";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
					redirect(base_url().'borrower/live-listing');
				}
			}
			else{
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
				redirect(base_url().'borrower/live-listing');
			 }
			}
		else
		{
			redirect(base_url().'login/borrower');
		}
	}

	public function createLoanledger($loan_disbursement_id)
	{
		if ( $this->session->userdata('borrower_state') == TRUE ){
			$data['lenderLedger'] = $this->Borroweractionmodel->createLoanledger($loan_disbursement_id);
			$ledger = $this->load->view('loan-ledger/loan_ledger', $data, true);
			echo $ledger;
			exit;
		}
		else
		{
			redirect(base_url().'login/borrower');
		}
	}

	public function loanRestructuring()
	{
		if ( $this->session->userdata('borrower_state') == TRUE )
		{

			if(!empty($_POST['loan_id']) && !empty($_POST['extension_time']))
			{

				$loan_restructuring = array('loan_id' => $this->input->post('loan_id'), 'extension_time' => $this->input->post('extension_time'));
				$this->db->insert('p2p_loan_restructuring', $loan_restructuring);
				if($this->db->affected_rows()>0)
				{
					$response = array(
						'status' => 1,
						'message' => "Your request for loan Restructuring added successfully. You shall be updated once Lender accepts your request",
					);
				}
				else{
					$response = array(
						'status' => 0,
						'message' => "Your request for Loan Restructuring is not accepted by lender",
					);
				}
			}
			else{
				$response = array(
					'status' => 0,
					'message' => "Your request for Loan Restructuring is not accepted by lender",
				);
			}
		}
		else{
			$response = array(
				'status' => 0,
				'message' => "Your session had expired. Please Re-Login",
			);
		}
     echo json_encode($response); exit;
	}

	public function actionEkyc()
	{
		if ( $this->session->userdata('borrower_state') == TRUE )
		{
			$this->form_validation->set_rules('aadhaar_number', 'Aadhaar Number', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$this->db->get_where('p2p_borrower_ekyc', array('borrower_id' => $this->session->userdata('borrower_id')));
				if($this->db->affected_rows()>0){
					$msg="Your eKYC is already done.";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'borrower/borrowerrequest/e_kyc');
				}
				$borrower_data = json_encode(array(
					"headers" => array(
						"client_code" => "ANTW3476",
						"sub_client_code" => "ANTW3476",
						"channel_code" => "WEB",
						"channel_verison" => "1",
						"stan" => uniqid(),
						"client_ip" => "",
						"transmission_datetime" => (string)strtotime(date('Y-m-d h:i:s')),
						"operation_mode" => "SELF",
						"run_mode" => "TEST",
						"actor_type" => "TEST",
						"user_handle_type" => "EMAIL",
						"user_handle_value" => $this->session->userdata('email'),
						"location" => "NA",
						"function_code" => "VERIFY_AADHAAR",
						"function_sub_code" => "DATA",
					),
					"request" => array(
						"aadhaar_details" =>
							array(
								"aadhaar_number" => $this->input->post('aadhaar_number'),
							),
						"consent" => "",
						"consent_message" => ""
					),
				));
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://prod.veri5digital.com/service/api/1.0/verifyUserIdDoc",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $borrower_data,
					CURLOPT_HTTPHEADER => array(
						"content-type: application/json"
					),
				));
				$response = curl_exec($curl);
				$err = curl_error($curl);
				curl_close($curl);
				$responce_array = array(
					'borrower_id' => $this->session->userdata('borrower_id'),
					'aadhar_no' => $this->input->post('aadhaar_number'),
					'response' => $response,
				);
				$this->db->insert('p2p_borrower_ekyc', $responce_array);
				if($this->db->affected_rows()>0)
				{
					$msg="eKYC done successfully";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'borrower/borrowerrequest/e_kyc');
				}
				else{
					$msg="OOPS! Something went wrong please check you credential and try again";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'borrower/borrowerrequest/e_kyc');
				}
			}
			else{
				$errmsg = validation_errors();
				$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
				redirect(base_url().'borrower/borrowerrequest/e_kyc');
			}

		}
		else
		{
			redirect(base_url().'login/borrower');
		}

	}
}
?>

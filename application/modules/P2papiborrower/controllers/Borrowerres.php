<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Borrowerres extends REST_Controller
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Borrowermodel', 'Borroweraddmodel'));
		$this->load->database();
	}

	public function registration_post()
		{
			$headers = $this->input->request_headers();
		  if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			  if ($decodedToken != false)
				 {
					$_POST = json_decode(file_get_contents('php://input'), true);
					$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
					 $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
					 $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                     $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
					 $this->form_validation->set_rules('imei_no', 'IMEI No', 'required');
					 $this->form_validation->set_rules('mobile_token', 'Mobile Token', 'required');
					 $this->form_validation->set_rules('latitude', 'Latitude', 'required');
					 $this->form_validation->set_rules('longitude', 'Longitude', 'required');
					 $this->form_validation->set_rules('term_and_condition', 'Term and condition', 'required');

				  if ($this->form_validation->run() == TRUE)
					 {

						$_POST['andriod_app'] = TRUE;
						$borrower_response = $this->Borroweraddmodel->add_borrower();
					 if ($borrower_response)
						{
							$msg = array(
									  "status" => 1,
									  "msg" => "Borrower Registration Successful",
									 );
							$this->set_response($msg, REST_Controller::HTTP_OK);
							return;
						}
						else
						  {
							$msg = array(
									   "status" => 0,
									   "msg" => "Something went wrong",
									  );
							$this->set_response($msg, REST_Controller::HTTP_OK);
							return;
						  }
					}
					 else
					  {
						$errmsg = array("error_msg" => validation_errors());
						$this->set_response($errmsg, REST_Controller::HTTP_OK);
						return;
					  }

				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		}

	 public function addProposal_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				  {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						if ($this->input->post('p2p_product_id') == 2)
						{
                            $this->form_validation->set_rules('p2p_product_id', 'Product ID', 'trim|required');
                            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required');
                            $this->form_validation->set_rules('invoice_value', 'Invoice Value', 'trim|required');
                            $this->form_validation->set_rules('mode_of_purchase', 'Mode of purchase', 'trim|required');
                            $this->form_validation->set_rules('loan_amount', 'Loan Aamount', 'trim|required');
                            $this->form_validation->set_rules('tenor_months', 'Tenor Months', 'trim|required');
                            if ($this->form_validation->run() == TRUE)
                            {
                                $response = $this->Borroweraddmodel->add_consumer_loan_details($borrowerId);

                                if ($response)
                                {
                                    $msg = array(
                                        "status" => 1,
                                        "proposal_id"=>$response,
                                        "msg" => "Loan Proposal Listed Successfully",
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
                                else
                                {
                                    $msg = array(
                                        "status" => 0,
                                        "msg" => "Something went wrong",
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
							}
                            else
                            {
                                $errmsg = array("error_msg" => validation_errors());
                                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                                return;
                            }
						}
						else{
                            $this->form_validation->set_rules('p2p_product_id', 'Product ID', 'trim|required');
                            $this->form_validation->set_rules('loan_amount', 'Loan Aamount', 'trim|required');
                            $this->form_validation->set_rules('tenor_months', 'Tenor Months', 'trim|required');
                            $this->form_validation->set_rules('loan_description', 'Purpose of Loan', 'trim|required');

                            if ($this->form_validation->run() == TRUE)
                            {

                                $response = $this->Borroweraddmodel->add_loan_details($borrowerId);

                                if ($response)
                                {
                                    $msg = array(
                                        "status" => 1,
                                        "proposal_id"=>$response,
                                        "msg" => "Loan Proposal Listed Successfully.",
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
                                else
                                {
                                    $msg = array(
                                        "status" => 0,
                                        "msg" => "Something went wrong",
                                    );
                                    $this->set_response($msg, REST_Controller::HTTP_OK);
                                    return;
                                }
                            }
                            else
                            {
                                $errmsg = array("error_msg" => validation_errors());
                                $this->set_response($errmsg, REST_Controller::HTTP_OK);
                                return;
                            }
						}

					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function genderUpdate_post()
		{
			$headers = $this->input->request_headers();
		   if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			  if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

				 if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('gender', 'Gender', 'trim|required');


					  if ($this->form_validation->run() == TRUE)
						 {

							$response = $this->Borroweraddmodel->update_gender($borrowerId);

							if ($response)
							 {
								$msg = array(
										  "status" => 1,
										  "msg" => "Gender updated successfully",
										 );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
							else
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							  }

						}
						 else
						  {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						  }
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function dobUpdate_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

					if($borrowerId)
					  {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');


						if ($this->form_validation->run() == TRUE)
						 {

							$response = $this->Borroweraddmodel->update_dob($borrowerId);

							if ($response)
							{
								$msg = array(
											"status" => 1,
											"msg" => "Date of Birth updated successfully",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}
							else
							 {
								$msg = array(
											"status" => 0,
											"msg" => "Something went wrong",
											);
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;

							 }

						}
						else
						 {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function maritalStatusUpdate_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				  {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');


						if ($this->form_validation->run() == TRUE)
						  {

							$response = $this->Borroweraddmodel->update_marital_status($borrowerId);

							if ($response)
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Marital Status updated successfully",
											);
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
							else
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }

						}
						else
						{
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						}
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function updateQualification_post()
		 {
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('highest_qualification', 'Highest Qualification', 'trim|required');


						if ($this->form_validation->run() == TRUE)
						{

							$response = $this->Borroweraddmodel->update_qualification($borrowerId);

							if ($response)
							{
								$msg = array(
										   "status" => 1,
										   "msg" => "Highest Qualification updated successfully",
										  );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}
							else
							{
								$msg = array(
											"status" => 1,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}

						}
						else
						{
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						}
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function occuptionUpdate_post()
		 {
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('occuption_id', 'Occuption', 'trim|required');


						if ($this->form_validation->run() == TRUE)
						{

							$response = $this->Borroweraddmodel->update_occuption($borrowerId);

							if ($response)
							{
								$msg = array(
										   "status" => 1,
										   "msg" => "Occuption Update Successfully",
										  );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}
							else
							 {
								$msg = array(
											 "status" => 1,
											 "msg" => "Something went wrong",
											);
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }

						}
						else
						 {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function companydetailsAdd_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				  {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('company_type', 'Company Type', 'trim|required');
						$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');

						if ($this->form_validation->run() == TRUE)
						 {

							$response = $this->Borroweraddmodel->add_company_details($borrowerId);
							if ($response)
							{
								$msg = array(
											"status" => 1,
											"msg" => "Company Details Register Successfully",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}
							else
							 {
								$msg = array(
											"status" => 0,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }

						}
						else
						 {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function incomeDetails_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('salary_process', 'Salary Process', 'trim|required');
						$this->form_validation->set_rules('net_monthly_income', 'Monthly Income', 'trim|required');


						if ($this->form_validation->run() == TRUE)
						 {

							$response = $this->Borroweraddmodel->add_income_details($borrowerId);

							if ($response)
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Income Details Register Successfully",
											);
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
							else
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}

						}
						else
						{
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						}
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function addAddress_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('r_state', 'State', 'trim|required');
						$this->form_validation->set_rules('r_city', 'City', 'trim|required');
						$this->form_validation->set_rules('residence_type', 'Residence type', 'trim|required');
						$this->form_validation->set_rules('r_address', 'Address', 'trim|required');
						$this->form_validation->set_rules('r_pincode', 'Pincode', 'trim|required');

						if ($this->form_validation->run() == TRUE)
						{

							$response = $this->Borroweraddmodel->add_address_details($borrowerId);

							if ($response)
							 {
								$msg = array(
											"status" => 1,
											"msg" => $response,
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
							else
							 {
								$msg = array(
											"status" => 1,
											"msg" => "Something went wrong",
										   );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
						}
						else
						 {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}

			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

		}

	 public function panUpdate_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {
					$borrowerId = $decodedToken->borrower_id;

					if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						 $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
						if ($this->form_validation->run() == TRUE)
						  {
                              $query = $this->db->select('BL.pan, BS.step_3')
                                  ->from('p2p_borrowers_list AS BL')
                                  ->join('p2p_borrower_steps AS BS', 'BS.borrower_id = BS.id', 'left')
                                  ->where('BL.id', $borrowerId)
                                  ->get();

                              if($this->db->affected_rows()>0)
                              {
                              	$result = (array)$query->row();
                                if(!empty($result['pan']))
								{
                                  if($result['step_3'] == 1)
								  {
                                      $msg = array(
                                          "status" => 1,
                                          "msg" => "Your PAN No is already approved",
                                      );
                                      $this->set_response($msg, REST_Controller::HTTP_OK);
                                      return;
								  }
								  else{
                                      $msg = array(
                                          "status" => 1,
                                          "msg" => "You have already update your PAN NO with this PAN- ".$result['pan']."",
                                      );
                                      $this->set_response($msg, REST_Controller::HTTP_OK);
                                      return;
								  }
								}
								else{
                                    $borrower_pan_json = json_encode(array('pan' => $this->input->post('pan')));
                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => "https://api.whatsloan.com/v1/ekyc/panAuth",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 30,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_POSTFIELDS => $borrower_pan_json,
                                        CURLOPT_HTTPHEADER => array(
                                            "cache-control: no-cache",
                                            "content-type: application/json",
                                            "token: ".WHATAPP_TOKEN.""
                                        ),
                                    ));

                                    $response = curl_exec($curl);
                                    $err = curl_error($curl);

                                    curl_close($curl);

                                    if ($err)
                                    {
                                        $msg = array(
                                            "status" => 0,
                                            "msg" => "Something went wrong",
                                        );
                                        $this->set_response($msg, REST_Controller::HTTP_OK);
                                    }
                                    else
                                    {
                                        $res = json_decode($response, true);
                                    }
                                    if ($res['status-code'] == 101)
                                    {
                                        $this->load->model('borrowerprocess/Borrowerprocessmodel');
                                        $dataSteps = array(
                                            'step_3' => 1,
                                            'modified_date' => date('Y-m-d H:i:s'),
                                        );

                                        $this->Borrowerprocessmodel->updateSteps($dataSteps);
                                        $api_response = array(
                                            'borrower_id' => $borrowerId,
                                            'api_name' => 'pan',
                                            'response' => $response,
                                        );
                                        $this->Borrowerprocessmodel->saveApiResponse($api_response);
                                        $this->Borroweraddmodel->update_pan($borrowerId);
                                        $msg = array(
                                            "status" => 1,
                                            "msg" => "Pan Update successfully",
                                        );
                                        $this->set_response($msg, REST_Controller::HTTP_OK);
                                        return;
                                    }
                                    else{
                                        $this->Borroweraddmodel->update_pan($borrowerId);
                                        $dataSteps = array(
                                            'step_3' => 3,
                                            'modified_date' => date('Y-m-d H:i:s'),
                                        );

                                        $this->Borrowerprocessmodel->updateSteps($dataSteps);
                                        $msg = array(
                                            "status" => 0,
                                            "msg" => "Invalid Pan",
                                        );
                                        $this->set_response($msg, REST_Controller::HTTP_OK);
                                        return;
                                    }
								}
                              }
                              else{
							  }

						}
						else
						 {

							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						}
					}
				}

			}

			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		}

	 public function updateKyc_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {
					$borrowerId = $decodedToken->borrower_id;
					if ($borrowerId)
					 {
						if (isset($_FILES['pan_file']) || isset($_FILES['kyc_file']) || isset($_FILES['selfiImage']))
						{
							//echo "<pre>";
//							echo json_encode($_FILES); exit;
//							print_r($_FILES); exit;
							$this->load->model('Borroweraddmodel');
							$config['upload_path'] = "./assets/borrower-documents";
							$config['allowed_types'] = 'jpg|png|jpeg|pdf';
							$config['encrypt_name'] = TRUE;
							$config['max_width'] = '0';
							$config['max_height'] = '0';
							$config['overwrite'] = TRUE;
							$this->load->library('upload', $config);
							if (isset($_FILES['pan_file']))
							 {
								if ($this->upload->do_upload("pan_file"))
								 {
									$data = $this->upload->data();
									$file_info = array(
											'borrower_id' => $borrowerId,
											'docs_type' => 'pan',
											'docs_name' => $data['file_name'],
											'date_added' => date('Y-m-d H:i:s'),
										   );
									$this->Borroweraddmodel->add_kyc($file_info);
								}
								else
								{
									$msg = array("status" => 0,
												"document_type" => "PAN",
												"msg" => $this->upload->display_errors()
											   );
									$this->set_response($msg, REST_Controller::HTTP_OK);
									return;
								}
							}
							if (isset($_FILES['kyc_file']))
							 {
								if ($this->upload->do_upload("kyc_file"))
									{
										$data = $this->upload->data();
										$file_info = array(
											'borrower_id' => $borrowerId,
											'docs_type' => 'address_proof',
											'docs_name' => $data['file_name'],
											'date_added' => date('Y-m-d H:i:s'),
										);
										$this->Borroweraddmodel->add_kyc($file_info);
									}
								else
									{
										$msg = array("status" => 0,
											"document_type" => "KYC",
											"msg" => $this->upload->display_errors()
										);
										$this->set_response($msg, REST_Controller::HTTP_OK);
										return;
									}
							}
							if (isset($_FILES['selfiImage']))
							 {
								if ($this->upload->do_upload("selfiImage"))
								 {
									$data = $this->upload->data();
									$file_info = array(
										'borrower_id' => $borrowerId,
										'docs_type' => 'selfiImage',
										'docs_name' => $data['file_name'],
										'date_added' => date('Y-m-d H:i:s'),
									);
									$this->Borroweraddmodel->add_kyc($file_info);
								}
								else
								{
									$msg = array("status" => 0,
										"document_type" => "Selfi",
										"msg" => $this->upload->display_errors()
									);
									$this->set_response($msg, REST_Controller::HTTP_OK);
									return;
								}
							}

							$msg = array("status" => 1, "msg" => "File Upload successfully");
							$this->set_response($msg, REST_Controller::HTTP_OK);
							return;
						}
						 else
						 {
							$msg = array("status" => 0, "msg" => $this->upload->display_errors());
							$this->set_response($msg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}
			}

			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		}

	 public function addBank_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;
					if ($borrowerId)
					 {
						$this->load->model(array('borrowerprocess/Borrowerprocessmodel'));
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
						$this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
						$this->form_validation->set_rules('caccount_no', 'Conform account no', 'trim|required|matches[account_no]');
						$this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'trim|required');
						if ($this->form_validation->run() == TRUE)
						 {
						 	$borrower_name = $this->db->select('name')->get_where('p2p_borrowers_list', array('id', $borrowerId))->row()->name;
							$data = json_encode(
								 array(
									 "fund_account" => array(
										 "account_type" => 'bank_account',
										 "bank_account" => array(
											 "name" => $borrower_name,
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
							if ($err)
							 {
								$msg = array(
										 "status" => 0,
										 "msg" => "Somethign went wrong please try again"
										);
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							 }
							else
							 {
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
										 'borrower_id' => $borrowerId,
										 'bank_name' => $this->input->post('bank_name'),
										 'account_number' => $this->input->post('account_no'),
										 'ifsc_code' => $this->input->post('ifsc_code'),
										 'is_verified' => 0,
									 );
									 $this->Borroweraddmodel->add_bankdetail($bank_data);
									 $msg = array(
										 "status" => 1,
										 "msg" => "Bank Account added successfully"
									 );
									 $this->set_response($msg, REST_Controller::HTTP_OK);
									 return;
								 }
								else
								 {
									$msg = array(
										"status" => 0,
										"msg" => "Incorrect information, please check your details"
									);
									$this->set_response($msg, REST_Controller::HTTP_OK);
									return;
								 }
							}
						}
						else
						{
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						}
					}
				}
			}
			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		}

	 public function coApplicant_post()
		{
			$headers = $this->input->request_headers();
			if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			 {
				$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				if ($decodedToken != false)
				 {

					$borrowerId = $decodedToken->borrower_id;

				  if ($borrowerId)
					 {
						$_POST = json_decode(file_get_contents('php://input'), true);
						$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required');
						$this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
						$this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
						$this->form_validation->set_rules('relation', 'Relation', 'trim|required');
						$this->form_validation->set_rules('pan', 'Pan', 'trim|required');

						if ($this->form_validation->run() == TRUE)
						 {

							$response = $this->Borroweraddmodel->add_coApplicant($borrowerId);

						  if ($response)
							{
								$msg = array(
										"status" => 1,
										"msg" => "Co-Applicant Register Successfully",
									  );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}
						  else
							{
								$msg = array(
									   "status" => 1,
									   "msg" => "Something went wrong",
									 );
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							}

						}
						 else
						  {
							$errmsg = array("error_msg" => validation_errors());
							$this->set_response($errmsg, REST_Controller::HTTP_OK);
							return;
						 }
					}
				}

			}

			$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		}

	 public function bankStatement_post()
		  {
			 $headers = $this->input->request_headers();
			 if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
			  {
				 $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
				 if ($decodedToken != false)
				  {
					 $borrowerId = $decodedToken->borrower_id;

					 if($borrowerId)
					   {
						// $this->form_validation->set_rules('password', 'Password', 'trim|required');
							 $config['upload_path'] = "./assets/borrower-documents";
							 $config['allowed_types'] = 'pdf';
							 $config['encrypt_name'] = TRUE;
							 $config['max_width'] = '0';
							 $config['max_height'] = '0';
							 $config['overwrite'] = TRUE;
							 $this->load->library('upload', $config);

							if ($this->upload->do_upload("bank_statement"))
								{

									$data = $this->upload->data();
									$borrower_file_info = array(
									 'borrower_id' => $borrowerId,
									 'docs_type' => 'bank_statement',
									 'docs_name' => $data['file_name'],
									 'bank_statement_password' => $this->input->post('password')?$this->input->post('password'):'',
									 'date_added' => date('Y-m-d H:i:s'),
									 );
									$this->Borroweraddmodel->insert_statement($borrower_file_info);

									$msg = array("status" => 1, "msg" => "File Upload successfully");
									$this->set_response($msg, REST_Controller::HTTP_OK);
									return;
								 }

							  else
							   {
								$msg = array("status" => 0, "msg" => $this->upload->display_errors());
								$this->set_response($msg, REST_Controller::HTTP_OK);
								return;
							   }
					   }
					}
				}
			 $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
		 }

	 public function documentUpload_post()
      {
         $headers = $this->input->request_headers();
         if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) 
          {
             $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
             if ($decodedToken != false) 
              {
                 $borrowerId = $decodedToken->borrower_id;
                
                 if($borrowerId)
                   {

                       $config['upload_path'] = "./assets/borrower-documents";
                           $config['allowed_types'] = 'jpg|png|jpeg|pdf';
                           $config['encrypt_name'] = TRUE;
                            $config['max_width'] = '0';
                            $config['max_height'] = '0';
                            $config['overwrite'] = TRUE;
                            $this->load->library('upload', $config);
                     
                        if ($this->upload->do_upload("document"))
                            {
                               $data = $this->upload->data();
                               $borrower_file = array(
                                      'borrower_id' => $borrowerId,
                                      'docs_type' => $this->input->post('document_type')?$this->input->post('document_type'):'',
                                      'docs_name' => $data['file_name'],
                                      'date_added' => date('Y-m-d H:i:s'),
                                     );
                                $this->Borroweraddmodel->upload_document($borrower_file);

                                $msg = array("status" => 1, "msg" => "File Upload successfully");
                                $this->set_response($msg, REST_Controller::HTTP_OK);
                                return;
                             }

                          else
                           {
                            $msg = array("status" => 0, "msg" => $this->upload->display_errors());
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                           }  
                   } 
                }
            }

         $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
     }

    public function getOccuptionfields_post()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                //
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId) {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('occupation', 'Occuption ID', 'required');
                    if ($this->form_validation->run() == TRUE) {
                        $this->load->model('Commonapimodel');
                        $result = $this->Commonapimodel->getOccuptionfields();
                        if($result){
                            $msg = array("msg" =>"found", "occupation_field_list"=>$result);
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else{
                            $errmsg = array("error_msg" => "Not Found");
                            $this->set_response($errmsg, REST_Controller::HTTP_OK);
                            return;
                        }

                    } else {
                        $errmsg = array("error_msg" => validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    //This method is using for to save occupation details exclude Salaried
    public function occupationAdd_post()
	{
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {

                $borrowerId = $decodedToken->borrower_id;

                if ($borrowerId)
                {
                    $_POST = json_decode(file_get_contents('php://input'), true);
                    $this->form_validation->set_rules('occuption_id', 'Occupation ID', 'trim|required');
                    if($this->input->post('occuption_id') == 2)
					{
                        $this->form_validation->set_rules('company_type', 'Select Industry Type', 'trim|required');
                        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
                        $this->form_validation->set_rules('total_experience', 'Total Experience', 'trim|required');
                        $this->form_validation->set_rules('turnover_last_year', 'Turnover last year', 'trim|required');
                        $this->form_validation->set_rules('turnover_last2_year', 'Turnover Last 2 Year', 'trim|required');
                        $this->form_validation->set_rules('net_monthly_income', 'Net Worth (in INR)', 'trim|required');
                        $this->form_validation->set_rules('ever_defaulted', 'Ever defaulted on loan/card', 'trim|required');

					}
                    if($this->input->post('occuption_id') == 3)
                    {
                        $this->form_validation->set_rules('company_type', 'Select Professional Type', 'trim|required');
                        $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
                        $this->form_validation->set_rules('total_experience', 'Total Experience', 'trim|required');
                        $this->form_validation->set_rules('turnover_last_year', 'Turnover last year', 'trim|required');
                        $this->form_validation->set_rules('turnover_last2_year', 'Turnover Last 2 Year', 'trim|required');
                        $this->form_validation->set_rules('net_monthly_income', 'Net Worth (in INR)', 'trim|required');
                        $this->form_validation->set_rules('ever_defaulted', 'Ever defaulted on loan/card', 'trim|required');

                    }
                    if($this->input->post('occuption_id') == 4)
                    {
                        $this->form_validation->set_rules('source_of_income', 'Source of Income', 'trim|required');
                        $this->form_validation->set_rules('net_monthly_income', 'Monthly Income', 'trim|required');
                        if($this->input->post('source_of_income') == 'Other')
						{
                          $this->form_validation->set_rules('source_of_income_other', 'Source of Income other', 'trim|required');
						}

                    }
                    if($this->input->post('occuption_id') == 5)
                    {
                        $this->form_validation->set_rules('source_of_income', 'Source of Income', 'trim|required');
                        $this->form_validation->set_rules('net_monthly_income', 'Monthly Income', 'trim|required');
                        if($this->input->post('source_of_income') == 'Other')
                        {
                            $this->form_validation->set_rules('source_of_income_other', 'Source of Income other', 'trim|required');
                        }

                    }
                    if($this->input->post('occuption_id') == 6)
                    {
                        $this->form_validation->set_rules('source_of_income', 'Source of Income', 'trim|required');
                        $this->form_validation->set_rules('net_monthly_income', 'Monthly Income', 'trim|required');
                        if($this->input->post('source_of_income') == 'Other')
                        {
                            $this->form_validation->set_rules('source_of_income_other', 'Source of Income other', 'trim|required');
                        }

                    }
                    if ($this->form_validation->run() == TRUE)
                    {

                        $response = $this->Borroweraddmodel->addOccupation($borrowerId);

                        if ($response)
                        {
                            $msg = array(
                                "status" => 1,
                                "msg" => "Occuption Update Successfully",
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }
                        else
                        {
                            $msg = array(
                                "status" => 1,
                                "msg" => "Something went wrong",
                            );
                            $this->set_response($msg, REST_Controller::HTTP_OK);
                            return;
                        }

                    }
                    else
                    {
                        $errmsg = array("error_msg" => validation_errors());
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }

        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	}
}?>

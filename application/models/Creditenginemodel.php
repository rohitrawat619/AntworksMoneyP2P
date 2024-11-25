<?php
class Creditenginemodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $lead_id
     */
    public function Engine($borrower_id)
    {
        
        $this->load->database();
        error_reporting(0);
        $this->db->select('BL.id, BL.highest_qualification, BL.occuption_id, TIMESTAMPDIFF(YEAR, BL.dob, CURDATE()) AS age,
                           ADDR.r_city,
                           ADDR.r_pincode,
                           ADDR.present_residence,
                          ');
        $this->db->from('p2p_borrowers_list AS BL');
        $this->db->join('p2p_borrower_address_details AS ADDR', 'ON ADDR.borrower_id = BL.id', 'left');
        $this->db->where('BL.id', $borrower_id);
        $this->db->order_by('BL.id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $borrower_infos = $query->result_array();

        }
//        var_dump($borrower_info); exit;
        $i = 0;

        foreach ($borrower_infos AS $borrower_info){
            $data['rating-ratio'] = array();
            $borrower_occuption_details = $this->getOccuptiondetails($borrower_info['id'], $borrower_info['occuption_id']);
            if($borrower_occuption_details['net_monthly_income']){

            }
            else{
                $borrower_occuption_details['net_monthly_income'] = 25000;
            }
            @$monthly_income = $borrower_occuption_details['net_monthly_income'] - (int)$borrower_occuption_details['current_emis'];

            @$anually_income = $monthly_income * 12;

            $borrower_banking_details = $this->getBankresponse($borrower_info['id'], $anually_income);
//            echo "<pre>";
//            echo $borrower_info['id']."<br>";
//            print_r($borrower_banking_details); exit;

            $this->db->select('*');
            $this->db->from('p2p_borrower_experian_response');
            $this->db->where('borrower_id',$borrower_info['id']);
            $this->db->order_by('id', 'desc');
            $query = $this->db->get();

            if($this->db->affected_rows()>0)
            {
            $result = (array)$query->row();
				
				
			//dated: 2024-jan-31	$file_content = file_get_contents(FCPATH.'/'.$result['experian_response_file']);
			/********start*dated:2024-jan-31***************/
				$str = $result['experian_response_file'];
				$pattern = "/public_html/i";
				$patternStatus = preg_match($pattern, $str);

				if($patternStatus){
					$newPath = $result['experian_response_file'];
				}else{
					
					$newPath = FCPATH.'/'.$result['experian_response_file'];
				}
			$file_content = file_get_contents($newPath);
			/**********end *****************/
			
            if($result['flag'] == 1)
			{
				$xmL1 = str_replace('<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header/><SOAP-ENV:Body><ns2:processResponse xmlns:ns2="urn:cbv2"><ns2:out>', '', $file_content);
				$experian_response = str_replace('</ns2:out></ns2:processResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>', '', $xmL1);
			}
            else{
				$removesoap_tag = substr($file_content, strpos($file_content, "<processReturn>") +15);
				$experian_response = substr($removesoap_tag,0, strpos($removesoap_tag,"</processResponse>") -16);
			}
            if (simplexml_load_string($experian_response)) {
                $xml_input = simplexml_load_string($experian_response);
                $json_input = json_encode($xml_input);
//                echo $json_input; exit;
                $report = json_decode($json_input, true);
                $status_loan = '0, 00, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 79, 81, 85, 86, 87, 88, 90, 91, 93, 97';
                $status_loan = explode(',', $status_loan);
                $active_loan = '11, 21, 22, 23, 24, 25, 71, 78, 80, 82, 83, 84';
                $active_loan = explode(',', $active_loan);
                $close_loan = '12, 13, 14, 15, 16, 17';
                $close_loan = explode(',', $close_loan);
                $experian_score = $report['SCORE']['BureauScore'];
                if (!empty($experian_score)) {
                    $messqge = $report['UserMessage']['UserMessageText'];
                    $message_code = explode(' ', $messqge);

                    // no record found
                    $no_record_found = "SYS100004";
                    if (in_array($no_record_found, $message_code)) {
						$data['rating-ratio'] = array(
							'borrower_id' => $borrower_info['id'],
							'experian_response' => $report['UserMessage']['UserMessageText'],
						);
						$this->db->insert('ant_borrower_rating', $data['rating-ratio']);
					}
                    else{
                        if($experian_score > 300) {
//                            echo $borrower_info['id'].'<br>';
                            if (@is_array($report['CAIS_Account']['CAIS_Account_DETAILS']['0'])) {
                                $cais_account_total = count($report['CAIS_Account']['CAIS_Account_DETAILS']);
                            } else {
                                $cais_account_total = 1;
                                $report['CAIS_Account']['CAIS_Account_DETAILS'][] = $report['CAIS_Account']['CAIS_Account_DETAILS'];
                            }

                            //Sum of Currentbalance Active Loan status
                            $sum_of_currentbalance = 0;

                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $active_loan)) {
                                    $sum_of_currentbalance += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                }
                            }
                            //End Sum of Currentbalance Active Loan status//

                            //Sum of Adjusted Current Credit

                            $sum_of_adjusted_current_credit = 0;
                            //$adjusted_credit_limit = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {

                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                        $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                        if ($credit_limit_amount) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            } else {
                                                $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                            }
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            }
                                        }

                                        $sum_of_adjusted_current_credit += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                    } else {

                                        $sum_of_adjusted_current_credit += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                    }
                                }

                            }

                            //Sum of Adjusted Sanction Credit
                            $adjusted_sanction_credit = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    @$credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                    if ($credit_limit_amount) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                            $adjusted_sanction_credit += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                        } else {
                                            $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                            $adjusted_sanction_credit += $get_maxofcurrent_highest_credit;
                                        }
                                    } else {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                            $adjusted_sanction_credit += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                        }
                                    }
                                }
                            }

                            //Sum Of Current balance of revolving
                            $sum_of_current_balance_of_revolving = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                        $sum_of_current_balance_of_revolving += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                    }
                                }
                            }

                            ////Sum of Adjusted sanction credit of revolving
                            $adjust_sanctioned_credit_of_revolving = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    @$credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                    if ($credit_limit_amount) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                            $adjust_sanctioned_credit_of_revolving += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                        }
                                    } else {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                $adjust_sanctioned_credit_of_revolving += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            }
                                        }
                                    }
                                }
                            }

                            //Sum Of current Balance of Term
                            $sum_of_current_balance_term = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $active_loan)) {
                                    $loantype = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'];
                                    if ($loantype != '10') {
                                        $sum_of_current_balance_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                    }
                                }
                            }

                            //Sum Of Adjusted Sanction Credit of Term
                            $sum_of_sanction_limit_term = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $active_loan)) {
                                    $loantype = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'];
                                    if ($loantype != '10') {
                                        $sum_of_sanction_limit_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                    }
                                }
                            }

                            ////Sum of current balance of short term
                            $sum_of_current_balance_short_term = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $active_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Repayment_Tenure']) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Repayment_Tenure'] <= 24) {
                                            $sum_of_current_balance_short_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        }
                                    } else {
                                        $loan_type_short_type = $this->getShorttenor_value();

                                        if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $loan_type_short_type)) {
                                            $sum_of_current_balance_short_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        }
                                    }

                                }
                            }


                            // Sum of  Adjusted Current Credit for revolving
                            $sum_of_adjusted_current_credit_for_revolving = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                        $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                        if ($credit_limit_amount) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                $sum_of_adjusted_current_credit_for_revolving += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            } else {
                                                $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                $sum_of_adjusted_current_credit_for_revolving += $get_maxofcurrent_highest_credit;
                                            }
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                $sum_of_adjusted_current_credit_for_revolving += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            }
                                        }
                                    }
                                }
                            }

                            //Sum Of adjusted Current Credit For Term
                            $sum_of_adjusted_current_credit_for_term = 0;
                            $sum_of_adjusted_current_credit_for_term = $sum_of_adjusted_current_credit - $sum_of_adjusted_current_credit_for_revolving;

                            //sum Of sanction credit for all close term loans
                            $sum_of_sanction_credit_for_all_closed_term_loan = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $close_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] != 10) {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount']))
                                            $sum_of_sanction_credit_for_all_closed_term_loan += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                    }

                                }
                            }

                            ///Sum of Adjusted Current Credit For Short Term
                            $sum_of_adjusted_current_credit_for_short_term = 0;
                            $short_term_tenor = $this->getShorttenor_value();
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'])) {
                                        $loan_tenor = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                        if ($loan_tenor <= 24) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                                $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                                if ($credit_limit_amount) {
                                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    } else {
                                                        $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                        $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                        $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                        $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                    }
                                                } else {
                                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                }

                                                $sum_of_adjusted_current_credit_for_short_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                            } else {

                                                $sum_of_adjusted_current_credit_for_short_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                            }
                                        }

                                    } else {
                                        if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $short_term_tenor)) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                                $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                                if ($credit_limit_amount) {
                                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    } else {
                                                        $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                        $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                        $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                        $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                    }
                                                } else {
                                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                }

                                                $sum_of_adjusted_current_credit_for_short_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                            } else {

                                                $sum_of_adjusted_current_credit_for_short_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                            }
                                        }
                                    }
                                }

                            }

                            ///Sum of Adjusted Current Credit For Medium Term
                            $sum_of_adjusted_current_credit_for_medium_term = 0;
                            $medium_term_tenor = $this->getMediumtenor_value();
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'])) {
                                        $loan_tenor = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                        if ($loan_tenor > 24 && $loan_tenor < 60) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                                $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                                if ($credit_limit_amount) {
                                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    } else {
                                                        $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                        $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                        $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                        $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                    }
                                                } else {
                                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                }

                                                $sum_of_adjusted_current_credit_for_medium_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                            } else {

                                                $sum_of_adjusted_current_credit_for_medium_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                            }
                                        }
                                    } else {
                                        if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $medium_term_tenor)) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                                $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                                if ($credit_limit_amount) {
                                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    } else {
                                                        $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                        $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                        $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                        $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                    }
                                                } else {
                                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                }

                                                $sum_of_adjusted_current_credit_for_medium_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                            } else {

                                                $sum_of_adjusted_current_credit_for_medium_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                            }
                                        }
                                    }
                                }

                            }

                            ///Sum of Adjusted Current Credit For Long Term
                            $sum_of_adjusted_current_credit_for_long_term = 0;
                            $long_term_tenor = $this->getLongtenor_value();
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'])) {
                                    $loan_tenor = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                    if ($loan_tenor > 60) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                            $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                            if ($credit_limit_amount) {
                                                if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                } else {
                                                    $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                    $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                }
                                            } else {
                                                if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                }
                                            }

                                            $sum_of_adjusted_current_credit_for_long_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                        } else {

                                            $sum_of_adjusted_current_credit_for_long_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        }
                                    }
                                } else {
                                    if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {

                                        if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $long_term_tenor)) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                                $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                                if ($credit_limit_amount) {
                                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    } else {
                                                        $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                        $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                        $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                        $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                    }
                                                } else {
                                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                        $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    }
                                                }

                                                $sum_of_adjusted_current_credit_for_long_term += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                            } else {

                                                $sum_of_adjusted_current_credit_for_long_term += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                            }
                                        }
                                    }
                                }

                            }

                            ///Sum of Adjusted Current Credit For Secured

                            $sum_of_adjusted_current_credit_for_secured = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    $secured_value = $this->getSecured_value();

                                    if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $secured_value)) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                            $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                            if ($credit_limit_amount) {
                                                if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                } else {
                                                    $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                    $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                }
                                            } else {
                                                if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                }
                                            }

                                            $sum_of_adjusted_current_credit_for_secured += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                        } else {

                                            $sum_of_adjusted_current_credit_for_secured += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        }
                                    }
                                }

                            }

                            ///Sum of Adjusted Current Credit For Unsecured Term
                            $sum_of_adjusted_current_credit_for_unsecured = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_credit_limit = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    $unsecuredvalues = $this->getUnsecured_value();
                                    if (in_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'], $unsecuredvalues)) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {

                                            $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                            if ($credit_limit_amount) {
                                                if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                } else {
                                                    $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                    $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                    $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                    $adjusted_credit_limit = $get_maxofcurrent_highest_credit;
                                                }
                                            } else {
                                                if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                    $adjusted_credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                }
                                            }

                                            $sum_of_adjusted_current_credit_for_unsecured += max($adjusted_credit_limit, (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance']);
                                        } else {

                                            $sum_of_adjusted_current_credit_for_unsecured += (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        }
                                    }
                                }

                            }


                            //Sum Of Shadow EMI For Only Term Loan
                            $sum_of_term_loan_emi = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_sanction_credit = 0;
                                $numerator = 0;
                                $denominator = 0;
                                $shadow_tenor = 0;
                                $records_shadow_instrest = 0;

                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] != 10) {
                                        @$credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                        if ($credit_limit_amount) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                $adjusted_sanction_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            } else {
                                                $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                $adjusted_sanction_credit = $get_maxofcurrent_highest_credit;
                                            }
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                $adjusted_sanction_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            }
                                        }

                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'])) {
                                            $tenor = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                            if ((int)$tenor > 0) {
                                                $shadow_tenor = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                            } else {
                                                if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'])) {
                                                    $shadow_tenor = $this->getTenor($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
                                                } else {
                                                    $shadow_tenor = $this->getTenor('0');
                                                }
                                            }
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'])) {
                                                $shadow_tenor = $this->getTenor($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
                                            } else {
                                                $shadow_tenor = $this->getTenor('0');
                                            }
                                        }

                                        $records_shadow_instrest = $this->getShadowinterest($experian_score);


                                        $shadow_interest_rate = (int)$records_shadow_instrest['shadow_interest_collection'][$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']];
                                        if ($shadow_interest_rate) {
                                            $shadow_interest_rate = $shadow_interest_rate;
                                        } else {
                                            $shadow_interest_rate = $records_shadow_instrest['shadow_interest_collection'][0];
                                        }


                                        $numerator = $adjusted_sanction_credit * ($shadow_interest_rate / 1200) * pow((1 + ($shadow_interest_rate / 1200)), $shadow_tenor);
                                        $denominator = pow((1 + ($shadow_interest_rate / 1200)), $shadow_tenor) - 1;
                                        $sum_of_term_loan_emi += $numerator / $denominator;
                                    }
                                }
                            }

                            //Sum Of Shadow EMI For All Loans
                            $sum_of_emi = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $adjusted_sanction_credit = 0;
                                $numerator = 0;
                                $denominator = 0;
                                $shadow_tenor = 0;
                                $records_shadow_instrest = 0;

                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    @$credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                    if ($credit_limit_amount) {
                                        if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                            $adjusted_sanction_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                        } else {
                                            $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                            $adjusted_sanction_credit = $get_maxofcurrent_highest_credit;
                                        }
                                    } else {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                            $adjusted_sanction_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                        }
                                    }

                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'])) {
                                        $tenor = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                        if ((int)$tenor > 0) {
                                            $shadow_tenor = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Terms_Duration'];
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'])) {
                                                $shadow_tenor = $this->getTenor($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
                                            } else {
                                                $shadow_tenor = $this->getTenor('0');
                                            }
                                        }
                                    } else {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'])) {
                                            $shadow_tenor = $this->getTenor($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
                                        } else {
                                            $shadow_tenor = $this->getTenor('0');
                                        }
                                    }

                                    $records_shadow_instrest = $this->getShadowinterest($experian_score);


                                    $shadow_interest_rate = $records_shadow_instrest['shadow_interest_collection'][$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']];
                                    if ($shadow_interest_rate) {
                                        $shadow_interest_rate = $shadow_interest_rate;
                                    } else {
                                        $shadow_interest_rate = $records_shadow_instrest['shadow_interest_collection'][0];
                                    }


                                    $numerator = $adjusted_sanction_credit * ($shadow_interest_rate / 1200) * pow((1 + ($shadow_interest_rate / 1200)), $shadow_tenor);
                                    $denominator = pow((1 + ($shadow_interest_rate / 1200)), $shadow_tenor) - 1;
                                    $sum_of_emi += $numerator / $denominator;

                                }
                            }


                            // Sum Of overdue Amount for all Active Loans
                            $sum_of_overdue_amount = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Amount_Past_Due'])) {
                                        $sum_of_overdue_amount += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Amount_Past_Due'];
                                    }
                                }

                            }

                            //Adjusted Current Balance of Revolving-(Revolving And Overdue is 0)
                            $sum_of_adjusted_current_credit_for_revolving_overdue_0 = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10 && $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Amount_Past_Due'] == 0) {
                                        $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] ? $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'] : 0;
                                        if ($credit_limit_amount) {
                                            if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == 10) {
                                                $sum_of_adjusted_current_credit_for_revolving_overdue_0 += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                            } else {
                                                $highest_credit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                                $credit_limit = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                                $get_maxofcurrent_highest_credit = max($highest_credit, $credit_limit);

                                                $sum_of_adjusted_current_credit_for_revolving_overdue_0 += $get_maxofcurrent_highest_credit;
                                            }
                                        } else {
                                            if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'])) {
                                                $sum_of_adjusted_current_credit_for_revolving_overdue_0 += $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Highest_Credit_or_Original_Loan_Amount'];
                                            }
                                        }
                                    }
                                }
                            }
                            $sum_of_adjusted_current_credit_for_revolving_overdue_0 = $sum_of_adjusted_current_credit_for_revolving - $sum_of_adjusted_current_credit_for_revolving_overdue_0;

                            //Limit Breach
                            $limit_bre = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {

                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {

                                    if ($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'] == '10') {
                                        $current_balance = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'];
                                        $credit_limit_amount = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Credit_Limit_Amount'];
                                        if ($current_balance > $credit_limit_amount) {

                                            $limit_bre += 1;
                                        }

                                    }
                                }

                            }

                            // Total No Of Active Account
                            $total_no_of_active_account = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {

                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {

                                    $total_no_of_active_account += 1;
                                }

                            }
                            //Total Variety of loans Active
                            $total_variety_of_loans_active = 0;
                            $variety_of_loans_active = array();
                            for ($x = 0; $x < $cais_account_total; $x++) {

                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    $variety_of_loans_active[] = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'];
                                }

                            }
                            $total_variety_of_loans_active = count(array_unique($variety_of_loans_active));

                            // Total Variety of loans All
                            $total_variety_of_loans_all = 0;
                            $variety_of_loans_all = array();
                            for ($x = 0; $x < $cais_account_total; $x++) {

                                $variety_of_loans_all[] = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'];
                            }

                            $total_variety_of_loans_all = count(array_unique($variety_of_loans_all));

                            //History of credit(oldest credit account)
                            $opendate = array();

                            for ($x = 0; $x < $cais_account_total; $x++) {

                                $loantype = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type'];
                                $open_date = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Open_Date'];
                                $ex = date('Y-m-d', strtotime($open_date));
                                $opendate[] = $ex;
                            }

                            $oldest_open_date = min($opendate);

                            $created_date = strtotime($result['created_date']);
                            $created_date = date('Y-m-d', $created_date);
                            $date1 = new DateTime($oldest_open_date);
                            $date2 = new DateTime($created_date);
                            $interval = $date1->diff($date2);

                            $history_of_credit_oldest_credit_account = $interval->days / 365;

                            // No Of credit enquiry last 3 Months
                            $no_of_credit_enquiry_last_3_months = $report['CAPS']['CAPS_Summary']['CAPSLast90Days'];

                            //No of loans Availed to credit enquiry in last 6 months
                            $avail_loan = 0;
                            $enquiry_credit = 0;
                            $no_of_credit_enquiry_last_6_months = $report['CAPS']['CAPS_Summary']['CAPSLast180Days'];
                            $countcaps_application = count($report['CAPS']['CAPS_Application_Details']);
                            if ($no_of_credit_enquiry_last_6_months > 0) {
                                for ($x = 0; $x <= $countcaps_application; $x++) {

                                    $ex = date('Y-m-d', strtotime($report['CAPS']['CAPS_Application_Details'][$x]['Date_of_Request']));
                                    $statrt = date('Y-m-d');
                                    $end = date('Y-m-d', strtotime('-6 months'));

                                    if ($ex < $statrt && $ex > $end) {

                                        $enquiry_credit += 1;
                                    }
                                }
                                $avail_loan = ($enquiry_credit / $no_of_credit_enquiry_last_6_months);
                            } else {
                                $avail_loan = 0;
                            }

                            //Number of instances of delay in past 6 months
                            $number_of_instances_delay_in_past_6_monhts = 0;
                            $created_date = strtotime($result['created_date']);
                            $created_date = date('Y-m-d', $created_date);
                            $date = new DateTime($created_date);
                            $year_current = $date->format('Y');
                            $year_current = $date->format('Y');
                            $date->modify('-6 month');
                            $year_last_6_month = $date->format('Y');
                            $years_arr = array('0' => $year_current, '1' => $year_last_6_month);
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $acount_history = count($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History']);
                                for ($y = 0; $y < 6; $y++) {
                                    @$overdue_year = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Year'];
                                    if (in_array($overdue_year, $years_arr)) {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due']) &&
                                            $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'] > 0) {
                                            $number_of_instances_delay_in_past_6_monhts += 1;
                                        }
                                    }
                                }

                            }

                            //Number of instances of delay in pas 12 months
                            $number_of_instances_delay_in_past_12_monhts = 0;
                            $created_date = strtotime($result['created_date']);
                            $created_date = date('Y-m-d', $created_date);
                            $date = new DateTime($created_date);
                            $year_current = $date->format('Y');
                            $date->modify('-1 year');
                            $year_last_12_month = $date->format('Y');
                            $years_arr = array();
                            $years_arr = array('0' => $year_current, '1' => $year_last_12_month);

                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $acount_history = count($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History']);
                                for ($y = 0; $y < 12; $y++) {
                                    @$overdue_year = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Year'];
                                    if (in_array($overdue_year, $years_arr)) {

                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due']) &&
                                            $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'] > 0) {
                                            $number_of_instances_delay_in_past_12_monhts += 1;
                                        }
                                    }
                                }

                            }
                            //Number of instances of delay in pas 36 months
                            $number_of_instances_delay_in_past_36_monhts = 0;
                            $created_date = strtotime($result['created_date']);
                            $created_date = date('Y-m-d', $created_date);
                            $date = new DateTime($created_date);
                            $year_current = $date->format('Y');
                            $date->modify('-1 year');
                            $first_year = $date->format('Y');
                            $date->modify('-1 year');
                            $second_year = $date->format('Y');
                            $date->modify('-1 year');
                            $year_third = $date->format('Y');
                            $years_arr = array();
                            $years_arr = array('0' => $year_current, '1' => $first_year, '2' => $second_year, '3' => $year_third);

                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $acount_history = count($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History']);
                                for ($y = 0; $y < 36; $y++) {
                                    @$overdue_year = $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Year'];
                                    if (in_array($overdue_year, $years_arr)) {
                                        if (!empty($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due']) &&
                                            $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'] > 0) {
                                            $number_of_instances_delay_in_past_36_monhts += 1;
                                        }
                                    }
                                }

                            }
                            //Past instances of settlement/ write--off
                            $past_instances_of_settlement_write_off = 0;
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loanstatus = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'];
                                if (in_array($loanstatus, $status_loan)) {
                                    $past_instances_of_settlement_write_off += 1;
                                }
                            }

                            //Over due date's
                            $over_due_dates = array();
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loan_type = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {

                                    $acount_history = count($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History']);
                                    for ($y = 0; $y < 1; $y++) {
                                        $past_over_due = (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'];
                                        if ($past_over_due) {
											if(is_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']))
											{
												$loan_type = $this->loanType($value = 0);
											}
											else{
												$loan_type = $this->loanType($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
											}
                                            $over_due_dates[$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Number']][] = array(
                                                'Account_Number' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Number'],
                                                'bank_name' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Subscriber_Name'],
                                                'loan_type' => $loan_type['description'],
                                                'Year' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Year'],
                                                'Month' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Month'],
                                                'Days_Past_Due' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'],
                                            );
                                        } else {
                                            $over_due_dates[$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Number']][] = array(
                                                'Account_Number' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Number'],
                                                'bank_name' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Subscriber_Name'],
                                                'loan_type' => $loan_type['description'],
                                                'Year' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Year'],
                                                'Month' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Month'],
                                                'Days_Past_Due' => (int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['CAIS_Account_History'][$y]['Days_Past_Due'],
                                            );
                                        }
                                    }
                                }
                            }
                            //Ongoing Loan List
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loan_type = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $active_loan)) {
                                    if(is_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']))
									{
										$loan_type = $this->loanType($value = 0);
									}
                                    else{
										$loan_type = $this->loanType($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
									}

                                    $ongoing_loan_list[] = array(
                                        'bank_name' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Subscriber_Name'],
                                        'loan_type' => $loan_type['description'],
                                        'outstanding_balance' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'],
                                    );
                                }
                            }

                            //Close Loan List
                            for ($x = 0; $x < $cais_account_total; $x++) {
                                $loan_type = 0;
                                if (in_array((int)$report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Status'], $close_loan)) {
									if(is_array($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']))
									{
										$loan_type = $this->loanType($value = 0);
									}
									else{
										$loan_type = $this->loanType($report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Account_Type']);
									}
                                    $close_loan_list[] = array(
                                        'bank_name' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Subscriber_Name'],
                                        'loan_type' => $loan_type['description'],
                                        'outstanding_balance' => $report['CAIS_Account']['CAIS_Account_DETAILS'][$x]['Current_Balance'],
                                    );
                                }
                            }


                            $data['rating-ratio'] = array(
                                'overall_leveraging_ratio' => $this->checkNAN(round($sum_of_currentbalance / $anually_income, 2)),
                                'leverage_ratio_maximum_available_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit / $anually_income, 2)),
                                'limit_utilization_revolving_credit' => $this->checkNAN(round($sum_of_current_balance_of_revolving / $adjust_sanctioned_credit_of_revolving, 2) * 100),
                                'outstanding_to_limit_term_credit' => $this->checkNAN(round($sum_of_current_balance_term / $sum_of_sanction_limit_term, 2) * 100),
                                'outstanding_to_limit_term_credit_including_past_facilities' => $this->checkNAN(round($sum_of_current_balance_term / ($sum_of_sanction_limit_term + $sum_of_sanction_credit_for_all_closed_term_loan), 2) * 100),
                                'short_term_leveraging' => $this->checkNAN(round($sum_of_current_balance_short_term / $anually_income, 2) * 100),
                                'revolving_credit_line_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_revolving / $sum_of_adjusted_current_credit, 2) * 100),
//                                'term_credit_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_term / $sum_of_adjusted_current_credit, 2) * 100),
//                                'available_revolving_line_to_total_credit' => $this->checkNAN(round(($adjust_sanctioned_credit_of_revolving - $sum_of_current_balance_of_revolving) / $sum_of_adjusted_current_credit, 2) * 100),
                                'short_term_credit_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_short_term / $sum_of_adjusted_current_credit, 2) * 100),
//                                'medium_term_credit_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_medium_term / $sum_of_adjusted_current_credit, 2) * 100),
//                                'long_term_credit_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_long_term / $sum_of_adjusted_current_credit, 2) * 100),
                                'secured_facilities_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_secured / $sum_of_adjusted_current_credit, 2) * 100),
//                                'unsecured_facilities_to_total_credit' => $this->checkNAN(round($sum_of_adjusted_current_credit_for_unsecured / $sum_of_adjusted_current_credit, 2) * 100),
                                'fixed_obligation_to_income' => $this->checkNAN(round($sum_of_term_loan_emi / $monthly_income, 4) * 100),
                                'no_of_active_accounts' => $this->checkNAN(round($total_no_of_active_account, 2)),
                                'variety_of_loans_active' => $this->checkNAN(round($total_variety_of_loans_active, 2)),
//                                'variety_of_loans_including_closed' => $this->checkNAN(round($total_variety_of_loans_all, 2)),
                                'no_of_credit_enquiry_in_last_3_months' => $this->checkNAN(round($no_of_credit_enquiry_last_3_months, 2)),
                                'no_of_loans_availed_to_credit_enquiry_in_last_12_months' => $this->checkNAN(round($avail_loan, 2)),
                                'history_of_credit_oldest_credit_account' => $this->checkNAN(round($history_of_credit_oldest_credit_account, 2)),
                                'limit_breach' => $this->checkNAN(round($limit_bre, 2)),
                                'overdue_to_obligation' => $this->checkNAN(round($sum_of_overdue_amount / (($sum_of_adjusted_current_credit_for_revolving_overdue_0 * 0.05) + $sum_of_emi), 2) * 100),
                                'overdue_to_monthly_income' => $this->checkNAN(round($sum_of_overdue_amount / $monthly_income, 2) * 100),
                                'number_of_instances_of_delay_in_past_6_months' => $this->checkNAN(round($number_of_instances_delay_in_past_6_monhts, 2)),
                                'number_of_instances_of_delay_in_past_12_months' => $this->checkNAN(round($number_of_instances_delay_in_past_12_monhts, 2)),
                                'number_of_instances_of_delay_in_past_36_months' => $this->checkNAN(round($number_of_instances_delay_in_past_36_monhts, 2)),
                                //                    'past_instances_of_settlement_write_off' => (float)round($past_instances_of_settlement_write_off, 2),
                                'occupation' => $borrower_info['occuption_id'],
                                'age' => $borrower_info['age'],
                                'highest_qualification' => $borrower_info['highest_qualification'],
                                //                    'ongoing_loan_list' => $ongoing_loan_list,
                                //                    'close_loan_list' => $close_loan_list,
                                //                    'over_due_dates' => $over_due_dates,
                            );

                            if ($borrower_banking_details) {
                                $data['rating-ratio'] = array_merge($data['rating-ratio'], $borrower_banking_details);
                            }

                            $this->db->select("id, rating_key, maximum_weightage");
                            $this->db->from("p2p_rating_model");
                            $this->db->where("status", 1);
                            $query = $this->db->get();
                            if ($this->db->affected_rows() > 0) {
                                $parameter_keys = $query->result_array();

                                $value = 0;
                                $i = 0;
                                foreach ($parameter_keys AS $key => $rating) {

                                    $paramenter_value = $data['rating-ratio'][$rating['rating_key']];
                                    $this->db->select('value');
                                    $this->db->from('p2p_rating_parameter_values');
                                    $this->db->where('min <=', "$paramenter_value");
                                    $this->db->where('max >=', "$paramenter_value");
                                    $this->db->where('credit_engine_key', $rating['id']);
                                    $query = $this->db->get();
//                                    echo "<pre>";
//                                    echo $this->db->last_query();
                                    $checking_value = 0;
                                    if ($this->db->affected_rows() > 0) {

                                        if ($rating['maximum_weightage'] == 5) {
                                            $value += $query->row()->value;
                                            $checking_value += $query->row()->value;
                                        }
                                        if ($rating['maximum_weightage'] == 10) {
                                            $value += 2 * $query->row()->value;
                                            $checking_value += 2 * $query->row()->value;
                                        }
                                        if ($rating['maximum_weightage'] == 15) {
                                            $value += 3 * $query->row()->value;
                                            $checking_value += 3 * $query->row()->value;
                                        }
                                        if ($rating['maximum_weightage'] == 20) {
                                            $value += 4 * $query->row()->value;
                                            $checking_value += 4 * $query->row()->value;
                                        }

                                        if($checking_value > $rating['maximum_weightage'])
                                        {
                                            echo $rating['rating_key']."---".$rating['maximum_weightage'] ."------------". $checking_value."<br>";
                                        }


                                    }

                                }
                                //echo $value;
                                $antworksp2p_rating = $value / 25;

                                if($antworksp2p_rating >0 && $antworksp2p_rating < 10){
                                    if($antworksp2p_rating>=9 && $antworksp2p_rating<=10)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>12,
                                            'prefered_interest_max'=>18,
                                        );
                                    }
                                    if($antworksp2p_rating>=8 && $antworksp2p_rating<=8.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>12,
                                            'prefered_interest_max'=>24,
                                        );
                                    }
                                    if($antworksp2p_rating>=7 && $antworksp2p_rating<=7.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>15,
                                            'prefered_interest_max'=>27,
                                        );
                                    }
                                    if($antworksp2p_rating>=6 && $antworksp2p_rating<=6.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>18,
                                            'prefered_interest_max'=>30,
                                        );
                                    }
                                    if($antworksp2p_rating>=5 && $antworksp2p_rating<=5.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>21,
                                            'prefered_interest_max'=>33,
                                        );
                                    }
                                    if($antworksp2p_rating>=4 && $antworksp2p_rating<=4.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>24,
                                            'prefered_interest_max'=>33,
                                        );
                                    }
                                    if($antworksp2p_rating>=3 && $antworksp2p_rating<=3.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>27,
                                            'prefered_interest_max'=>36,
                                        );
                                    }
                                    if($antworksp2p_rating>=1 && $antworksp2p_rating<=2.99)
                                    {
                                        $prefered_interest_range = array(
                                            'prefered_interest_min'=>30,
                                            'prefered_interest_max'=>36,
                                        );
                                    }
                                    $proposal_id = $this->get_currentopen_proposal($borrower_info['id']);
                                    $this->db->where('proposal_id', $proposal_id);
                                    $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
                                    $this->db->update('p2p_proposal_details', $prefered_interest_range);
                                }

                                $rating_res = array(
                                    'experian_response' => $report['UserMessage']['UserMessageText'],
                                    'experian_score' => $experian_score,
                                    'antworksp2p_rating' => $antworksp2p_rating,
                                );

                                if ($rating_res) {
                                    $data['rating-ratio'] = array_merge($data['rating-ratio'], $rating_res);
                                }
                            }
							$borrower_id = array(
								'borrower_id' => $borrower_info['id'],
							);
                            $this->db->get_where('ant_borrower_rating', array('borrower_id' => $borrower_info['id']));
                            if($this->db->affected_rows() > 0)
							{
								$data['rating-ratio'] = array_merge($data['rating-ratio'], $borrower_id);
								$this->db->where('borrower_id', $borrower_info['id']);
								$this->db->update('ant_borrower_rating', $data['rating-ratio']);
								return true;
							}
                            else{
								$data['rating-ratio'] = array_merge($data['rating-ratio'], $borrower_id);
								$this->db->insert('ant_borrower_rating', $data['rating-ratio']);
								return true;
							}

                        }
                        else{
							$data['rating-ratio'] = array(
								'borrower_id' => $borrower_info['id'],
								'experian_response' => $report['UserMessage']['UserMessageText'],
								'experian_score' => $experian_score,
							);
							$this->db->insert('ant_borrower_rating', $data['rating-ratio']);
						}
                    }
                }
                else{
					$data['rating-ratio'] = array(
						'borrower_id'=>$borrower_info['id'],
						'experian_response'=>$report['UserMessage']['UserMessageText']?$report['UserMessage']['UserMessageText']:$report['Header']['MessageText'],
					);
					$this->db->insert('ant_borrower_rating', $data['rating-ratio']);
                }
              }
            else{
				$borrower_res = array(
					'borrower_id'=>$borrower_info['id'],
					'experian_response'=>'Error While simplexml_load_string',
				);
				$this->db->insert('ant_borrower_rating', $borrower_res);
                }
            }
            $i++; }
        return true;
    }

    public function checkNAN($numeric)
    {
        if(is_nan($numeric))
        {
            return 0;
        }
        if(is_infinite($numeric))
        {
           return 0;
        }
        if(empty($numeric))
        {
            return 0;
        }
        else{
            return $numeric;
        }

    }

    public function getOccuptiondetails($borrower_id, $occuption_id)
    {
		$query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrower_id));
		if($this->db->affected_rows()>0)
		{
			return (array)$query->row();
		}
		else{
			return  false;
		}

        switch ($occuption_id){
            case 1:
                $this->db->select('*');
                $this->db->from('p2p_borrower_salaried_details');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
                break;
            case 2:
                $this->db->select('*');
                $this->db->from('p2p_borrower_self_business_details');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
                break;
            case 3:
                $this->db->select('*');
                $this->db->from('p2p_borrower_self_professional_details');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
                break;
            case 4:
                $this->db->select('*');
                $this->db->from('p2p_borrower_retired_details');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
            break;
            case 5:
                $this->db->select('*');
                $this->db->from('p2p_borrower_student_details');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
            break;
            case 6:
                $this->db->select('*');
                $this->db->from('p2p_borrower_homemaker ');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
            break;
            case 7:
                $this->db->select('*');
                $this->db->from('p2p_borrower_others');
                $this->db->where('borrower_id', $borrower_id);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    return $borrower_occ_details = (array)$query->row();
                }
             break;
            default:
                return false;
             break;
        }
    }

    public function getBankresponse($borrower_id, $anually_income)
    {
        $sql = "SELECT * FROM p2p_borrowers_docs_table WHERE borrower_id = '".$borrower_id."' AND (docs_type = 'bank_statement' OR docs_type = 'Online_bank_statement') ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
//            echo $result['whatsloan_response']; exit;
            $response = json_decode($result['whatsloan_response'], true);

            if($response['success'] == 1)
            {
                $arr_banking_response = array();
                 $transactionDataObjects = $response['result']['transactionDataObjects'];
                 $cheque_key = "Check Bounces";
                 $arr_key = array(
                     '0'=>'Check Bounces',
                     '1'=>'Credits',
                     '2'=>'Cash Withdrawals at Bank',
                     '3'=>'ATM Withdrawals',
                     '4'=>'Debits',
                     '5'=>'Cash Deposits at Bank',
                 );
                foreach ($arr_key AS $key => $response_key)
                {
                    $banking_response_value[$response_key] = $this->check_Values_whats($response_key, $transactionDataObjects);
                }

                $date = DateTime::createFromFormat('d/m/Y', $response['result']['metaData']['lastTransactionSeen']);
                $lastTransactionSeen =  $date->format('Y-m-d');
                $date = DateTime::createFromFormat('d/m/Y', $response['result']['metaData']['duration']['fromDate']);
                $fromDate =  $date->format('Y-m-d');
                $date1 = new DateTime($lastTransactionSeen);
                $date2 = new DateTime($fromDate);
                $diff = $date1->diff($date2);
                $date_difference = $diff->days;

                $expenseToIncomeRatio = 100 - (float) filter_var( $response['result']['categoryDetails']['expenseIncomeRatio']['expenseToIncomeRatio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                $credit_summation_to_income = ((((filter_var( $banking_response_value['Credits'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION )
                                                  - filter_var( $banking_response_value['Cash Deposits at Bank'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ))
                                                  /2)
                                                  *365)
                                                  /($date_difference))
                                                  /$anually_income;
                $digital_banking = (filter_var( $banking_response_value['Cash Withdrawals at Bank'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ) + filter_var( $banking_response_value['ATM Withdrawals'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION ))/filter_var( $banking_response_value['Debits'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
                 return $arr_banking_response = array(
                       'credit_summation_to_annual_income'=>$this->checkNAN($credit_summation_to_income*100),
                       'digital_banking'=>$this->checkNAN($digital_banking*100),
                       'savings_as_percentage_of_annual_income'=>$this->checkNAN($expenseToIncomeRatio),
                       'cheque_bouncing'=>$this->checkNAN($banking_response_value['Check Bounces']),
                   );
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function check_Values_whats($check, $transactionDataObjects)
    {
        foreach($transactionDataObjects AS $key=>$transactionData)
        {
            if($transactionData['txnListType'] == $check)
            {
                return $transactionData['totalAmt'];
            }
        }
    }

    public function getRecord($lead_id)
    {

        $this->db->select('*');
        $this->db->from('credit_score_query');
        $this->db->where('id', $lead_id);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }

    }

    public function getShorttenor_value()
    {
        $this->db->select('value');
        $this->db->from('ce_account_type');
        $this->db->where('tenor <= ', '24');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $short_loan_desc = $query->result_array();
            foreach ($short_loan_desc AS $short_value)
            {
                $value[] =  $short_value['value'];
            }
           return $value;
        }
        else{
            return false;
        }
    }

    public function getMediumtenor_value()
    {
        $this->db->select('value');
        $this->db->from('ce_account_type');
        $this->db->where('tenor > ', '24');
        $this->db->where('tenor < ', '60');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $short_loan_desc = $query->result_array();
            foreach ($short_loan_desc AS $short_value)
            {
                $value[] =  $short_value['value'];
            }
           return $value;
        }
        else{
            return false;
        }
    }

    public function getLongtenor_value()
    {
        $this->db->select('value');
        $this->db->from('ce_account_type');
        $this->db->where('tenor >= ', '60');
        $query = $this->db->get();

        if($this->db->affected_rows()>0)
        {
            $short_loan_desc = $query->result_array();
            foreach ($short_loan_desc AS $short_value)
            {
                $value[] =  $short_value['value'];
            }
            return $value;
        }
        else{
            return false;
        }
    }

    public function getSecured_value()
    {
        $this->db->select('value');
        $this->db->from('ce_account_type');
        $this->db->where('is_secured', '1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $short_loan_desc = $query->result_array();
            foreach ($short_loan_desc AS $short_value)
            {
                $value[] =  $short_value['value'];
            }
            return $value;
        }
        else{
            return false;
        }
    }

    public function getUnsecured_value()
    {
        $this->db->select('value');
        $this->db->from('ce_account_type');
        $this->db->where('is_secured', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $short_loan_desc = $query->result_array();
            foreach ($short_loan_desc AS $short_value)
            {
                $value[] =  $short_value['value'];
            }
            return $value;
        }
        else{
            return false;
        }
    }

    public function getTenor($value)
    {
        $this->db->select('tenor');
        $this->db->from('ce_account_type');
        $this->db->where('value', $value);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result =  (array)$query->row();

            return $result['tenor'];
        }
        else{
            return false;
        }
    }

    public function getShadowinterest($experian_score)
    {
        $sql = "SELECT * FROM ce_shadow_interest WHERE '$experian_score' BETWEEN `min_credit_score` AND `max_credit_score`;";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            $result =  (array)$query->row();
           return $res = array(
                'min_credit_score'=>$result['min_credit_score'],
                'max_credit_score'=>$result['max_credit_score'],
                'shadow_interest_collection'=>json_decode($result['shadow_interest_collection'], true),
            );
        }
        else{
            return false;
        }
    }

    public function loanType($value)
    {
        $this->db->select('*');
        $this->db->from('ce_account_type');
        $this->db->where('value', $value);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function get_currentopen_proposal()
    {
        $this->db->select('proposal_id');
        $this->db->from('p2p_proposal_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row()->proposal_id;
        }
        else{
            return false;
        }

    }
}
?>

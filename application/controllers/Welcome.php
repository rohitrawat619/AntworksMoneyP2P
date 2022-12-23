<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    private $table = 'p2p_rating_model';

	public function __construct()
    {
        parent::__construct();

        $this->load->database(); exit;

    }



    public function borrowerrating($proposal_id)
    {
        error_reporting(0);
        $this->db->select('*, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('id', 801);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $borrower_info = (array)$query->row();
        }
        else{
            return false;
        }
        $this->db->select('experian_response');
        $this->db->from('p2p_borrower_experian_response');
        $this->db->where('borrower_id',801);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
        }
        else{
            return false;
        }
        $monthly_income = 215300;
        $anual_income = ($monthly_income * 12);

        $data = htmlspecialchars_decode($result['experian_response']);
        $data1 = str_replace('<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header/><SOAP-ENV:Body><ns2:processResponse xmlns:ns2="urn:cbv2"><ns2:out>', '', $data);
        $data2 = str_replace('</ns2:out></ns2:processResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>', '', $data1);
        $returningData = simplexml_load_string($data2);
        $json_string = json_encode($returningData);
        $result_array = json_decode($json_string, TRUE);
        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
        $loan = $count - 1;
        $all_credit_amountsum = 0;
        $revolving_amountsumall = 0;
        $loanamount = 0;
        $score = $result_array['SCORE']['BureauScore'];

        /*     */
        $count = count($result_array['CAIS_Account']['CAIS_Account_DETAILS']);
        $loan = $count - 1;
        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $loanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
            }
        }

        $expanse = ($loanamount/$anual_income);
/////
        $overall_leveraging_ratio = round($expanse, 2);

        if($overall_leveraging_ratio>0 && $overall_leveraging_ratio<1)
        {
            $system_score = 5;
        }
        if($overall_leveraging_ratio>1 && $overall_leveraging_ratio<2)
        {
            $system_score = 4;
        }
        if($overall_leveraging_ratio>2 && $overall_leveraging_ratio<3)
        {
            $system_score = 2;
        }
        if($overall_leveraging_ratio>3 && $overall_leveraging_ratio<4)
        {
            $system_score = 1;
        }
        if($overall_leveraging_ratio>4)
        {
            $system_score = 0;
        }
        $result = $this->get_value_of_weightage(1);

        $overall_leveraging_ratio_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$overall_leveraging_ratio,
            'system_score'=>$system_score*2,
        );
        /*     */
        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($loantype != '10') {
                    $all_credit_amountsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                } else {


                    $credit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    $credit_limit = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                    if ($credit_limit) {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                    } else {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                    }

                    $credit_limit_amount > $credit_amount ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount;
                    $revolving_amountsumall += $revolving_amount;


                }
            }

        }
        //value of L15
        $adjusted_balance = ($all_credit_amountsum + $revolving_amountsumall);
        $expanse = ($adjusted_balance/$anual_income);
/////
        $leveraging_ratio_max_available_credit = round($expanse, 2);


        if($leveraging_ratio_max_available_credit>0 && $leveraging_ratio_max_available_credit<1)
        {
            $system_score = 5;
        }
        if($leveraging_ratio_max_available_credit>1 && $leveraging_ratio_max_available_credit<2)
        {
            $system_score = 4;
        }
        if($leveraging_ratio_max_available_credit>2 && $leveraging_ratio_max_available_credit<3)
        {
            $system_score = 2;
        }
        if($leveraging_ratio_max_available_credit>3 && $leveraging_ratio_max_available_credit<4)
        {
            $system_score = 1;
        }
        if($leveraging_ratio_max_available_credit>4)
        {
            $system_score = 0;
        }
        $result = $this->get_value_of_weightage(2);
        $leveraging_ratio_max_available_credit_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$leveraging_ratio_max_available_credit,
            'system_score'=>$system_score*2,
        );
        /*     */
        $creditamount = 0;
        $creditloanamount = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($loantype == '10') {
                    $creditamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    $credit_limit = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                    if ($credit_limit) {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                    } else {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                    }


                    $creditloanamount += $credit_limit_amount;
                }

            }
        }
        $revolving = (($creditamount / $creditloanamount) * 100);
/////
        $limit_utilization = round($revolving, 2);
        if($limit_utilization>0 && $limit_utilization<10)
        {
            $system_score = 4;
        }
        if($limit_utilization>10 && $limit_utilization<25)
        {
            $system_score = 5;
        }
        if($limit_utilization>25 && $limit_utilization<50)
        {
            $system_score = 3;
        }
        if($limit_utilization>50 && $limit_utilization<75)
        {
            $system_score = 2;
        }
        if($limit_utilization>75 && $limit_utilization<90)
        {
            $system_score = 1;
        }
        if($limit_utilization>90)
        {
            $system_score = 0;
        }
        $result = $this->get_value_of_weightage(3);

        $limit_utilization_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$limit_utilization,
            'system_score'=>$system_score,
        );

        /*     */
        $termamount = 0;
        $termloanamount = 0;
        for ($i = 0; $i <= $loan; $i++) {

            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($loantype != '10') {
                    $termamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    $termloanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                }

            }
        }

        $outstanding = (($termamount / $termloanamount) * 100);

////
        $outstanding_to_limit_Term_credit =  round($outstanding, 2);

        if($outstanding_to_limit_Term_credit>0 && $outstanding_to_limit_Term_credit<40)
        {
            $system_score = 5;
        }
        if($outstanding_to_limit_Term_credit>40 && $outstanding_to_limit_Term_credit<80)
        {
            $system_score = 4;
        }
        if($outstanding_to_limit_Term_credit>80 && $outstanding_to_limit_Term_credit<90)
        {
            $system_score = 2;
        }
        if($outstanding_to_limit_Term_credit>90)
        {
            $system_score = 2;
        }

        $result = $this->get_value_of_weightage(4);

        $outstanding_to_limit_Term_credit_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$outstanding_to_limit_Term_credit,
            'system_score'=>$system_score*2);

        /*     */
        $termamountall = 0;
        $alltermloanamount = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
            if ($loantype != '10') {
                $termamountall += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];

                $alltermloanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
            }

        }

        $outstandingall = (($termamountall / $alltermloanamount) * 100);

/////////
        $outstanding_to_limit_including_past_facilities = round($outstandingall, 2);
        if($outstanding_to_limit_including_past_facilities>0 && $outstanding_to_limit_including_past_facilities<40)
        {
            $system_score = 5;
        }
        if($outstanding_to_limit_including_past_facilities>40 && $outstanding_to_limit_including_past_facilities<80)
        {
            $system_score = 4;
        }
        if($outstanding_to_limit_including_past_facilities>80 && $outstanding_to_limit_including_past_facilities<90)
        {
            $system_score = 2;
        }
        if($outstanding_to_limit_including_past_facilities>90)
        {
            $system_score = 2;
        }

        $result = $this->get_value_of_weightage(5);

        $outstanding_to_limit_including_past_facilities_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$outstanding_to_limit_including_past_facilities,
            'system_score'=>$system_score,);

        /*     */
        $loanamount = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
            if ($loantype == '10') {
                $loanamount += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
            }

        }
        $expanse = ($loanamount / $monthly_income);
        $short_term_leveraging = round($expanse, 2);
        if($short_term_leveraging>0 && $short_term_leveraging<1)
        {
            $system_score = 5;
        }
        if($short_term_leveraging>1 && $short_term_leveraging<2)
        {
            $system_score = 4;
        }
        if($short_term_leveraging>2 && $short_term_leveraging<3)
        {
            $system_score = 2;
        }
        if($short_term_leveraging>3 && $short_term_leveraging<4)
        {
            $system_score = 1;
        }
        if($short_term_leveraging>4)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(7);

        $short_term_leveraging_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$short_term_leveraging,
            'system_score'=>$system_score*5,
        );
        /*     */
        //Credit MIX 1
        $termamountallsum = 0;
        $credit_amountsum = 0;
        $revolving_amountsum = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
            if ($loantype != '10') {
                $termamountallsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
            } else {

                $credit_amountsum += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                $credit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                $credit_limit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']:0;

                if ($credit_limit) {
                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                } else {
                    $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']:0;
                }

                $credit_limit_amount > $credit_amount ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount;
                $revolving_amountsum += $revolving_amount;


            }

        }

        $termcredit = $termamountallsum + $credit_amountsum;
        $creditmix = (($revolving_amountsum / $termcredit) * 100);

////
        $credit_m_1_revolving = round($creditmix, 2);
        if($credit_m_1_revolving>0 && $credit_m_1_revolving<10)
        {
            $system_score = 1;
        }
        if($credit_m_1_revolving>10 && $credit_m_1_revolving<25)
        {
            $system_score = 2;
        }
        if($credit_m_1_revolving>25 && $credit_m_1_revolving<50)
        {
            $system_score = 5;
        }
        if($credit_m_1_revolving>50 && $credit_m_1_revolving<75)
        {
            $system_score = 3;
        }
        if($credit_m_1_revolving>75 && $credit_m_1_revolving>100)
        {
            $system_score = 1;
        }

        $result = $this->get_value_of_weightage(8);

        $credit_m_1_revolving_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$credit_m_1_revolving,
            'system_score'=>$system_score,
        );
        /*     */


        /////////////////Credit Mix 2
        $termamountallsum_tenor = 0;
        $revolving_amountsum_tenor = 0;

        for ($i = 0; $i <= $loan; $i++) {

            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($loantype != '10') {

                    $termamountallsum_tenor += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                }
                $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                if ($repayment_tenor != 0 && !is_array($repayment_tenor)) {
                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                } else {
                    $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                    switch ($loantype) {
                        case "0":
                            $repayment_tenor = '0';
                            break;
                        case "1":
                            $repayment_tenor = '84';
                            break;
                        case "2":
                            $repayment_tenor = '240';
                            break;
                        case "3":
                            $repayment_tenor = '180';
                            break;
                        case "4":
                            $repayment_tenor = '240';
                            break;
                        case "5":
                            $repayment_tenor = '48';
                            break;
                        case "06":
                            $repayment_tenor = '24';
                            break;
                        case "07":
                            $repayment_tenor = '60';
                            break;
                        case "08":
                            $repayment_tenor = '84';
                            break;
                        case "09":
                            $repayment_tenor = '60';
                            break;

                        case "10":
                            $repayment_tenor = '1';
                            break;
                        case "11":
                            $repayment_tenor = '84';
                            break;
                        case "12":
                            $repayment_tenor = '12';
                            break;
                        case "13":
                            $repayment_tenor = '60';
                            break;
                        case "14":
                            $repayment_tenor = '12';
                            break;
                        case "15":
                            $repayment_tenor = '36';
                            break;
                        case "16":
                            $repayment_tenor = '1';
                            break;
                        case "17":
                            $repayment_tenor = '60';
                            break;
                        case "18":
                            $repayment_tenor = '1';
                            break;
                        case "19":
                            $repayment_tenor = '1';
                            break;
                        case "20":
                            $repayment_tenor = '1';
                            break;
                        case "31":
                            $repayment_tenor = '1';
                            break;
                        case "32":
                            $repayment_tenor = '60';
                            break;

                        case "33":
                            $repayment_tenor = '60';
                            break;
                        case "34":
                            $repayment_tenor = '60';
                            break;
                        case "35":
                            $repayment_tenor = '1';
                            break;
                        case "43":
                            $repayment_tenor = '36';
                            break;
                        case "51":
                            $repayment_tenor = '36';
                            break;
                        case "52":
                            $repayment_tenor = '36';
                            break;
                        case "53":
                            $repayment_tenor = '36';
                            break;
                        case "54":
                            $repayment_tenor = '36';
                            break;
                        case "55":
                            $repayment_tenor = '36';
                            break;
                        case "56":
                            $repayment_tenor = '36';
                            break;
                        case "57":
                            $repayment_tenor = '36';
                            break;
                        case "58":
                            $repayment_tenor = '36';
                            break;
                        case "59":
                            $repayment_tenor = '3';
                            break;
                        case "60":
                            $repayment_tenor = '60';
                            break;
                        case "36":
                            $repayment_tenor = '6';
                            break;
                        case "37":
                            $repayment_tenor = '12';
                            break;
                        case "38":
                            $repayment_tenor = '12';
                            break;
                        case "39":
                            $repayment_tenor = '60';
                            break;
                        case "61":
                            $repayment_tenor = '36';
                            break;

                    }
                }
                if ($repayment_tenor <= 24) {
                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    $credit_limit = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                    if ($credit_limit) {
                        $credit_limit_amount = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                    } else {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                    }
                    if ($loantype == '10') {
                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                    } else {
                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    }

                    $revolving_amountsum_tenor += $revolving_amount;

                }

            }
        }
        $shortterm_credit = $termamountallsum_tenor + $revolving_amountsum_tenor;
        $shortcreditmix2 = (($revolving_amountsum_tenor / $shortterm_credit) * 100);

/////
        $short_term_credit_to_total_credit = round($shortcreditmix2, 2);
        if($short_term_credit_to_total_credit>0 && $short_term_credit_to_total_credit<25)
        {
            $system_score = 1;
        }
        if($short_term_credit_to_total_credit>25 && $short_term_credit_to_total_credit<50)
        {
            $system_score = 5;
        }
        if($short_term_credit_to_total_credit>50 && $short_term_credit_to_total_credit<75)
        {
            $system_score = 2;
        }
        if($short_term_credit_to_total_credit>75 && $short_term_credit_to_total_credit<100)
        {
            $system_score = 1;
        }

        $result = $this->get_value_of_weightage(11);

        $short_term_credit_to_total_credit_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$short_term_credit_to_total_credit,
            'system_score'=>$system_score,
        );
        /*     */

        ////////////////Credit Mix 3

        $revolvingsecure = 0;
        for ($i = 0; $i <= $loan; $i++) {

            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                switch ($loantype) {
                    case "0":
                        $accounttype = 'secured';
                        break;
                    case "1":
                        $accounttype = 'secured';
                        break;
                    case "2":
                        $accounttype = 'secured';
                        break;
                    case "3":
                        $accounttype = 'secured';
                        break;
                    case "4":
                        $accounttype = 'secured';
                        break;
                    case "5":
                        $accounttype = 'unsecured';
                        break;
                    case "06":
                        $accounttype = 'secured';
                        break;
                    case "07":
                        $accounttype = 'unsecured';
                        break;
                    case "08":
                        $accounttype = 'unsecured';
                        break;
                    case "09":
                        $accounttype = 'unsecured';
                        break;

                    case "10":
                        $accounttype = 'unsecured';
                        break;
                    case "11":
                        $accounttype = 'secured';
                        break;
                    case "12":
                        $accounttype = 'secured';
                        break;
                    case "13":
                        $accounttype = 'secured';
                        break;
                    case "14":
                        $accounttype = 'secured';
                        break;
                    case "15":
                        $accounttype = 'secured';
                        break;
                    case "16":
                        $accounttype = 'unsecured';
                        break;
                    case "17":
                        $accounttype = 'secured';
                        break;
                    case "18":
                        $accounttype = 'unsecured';
                        break;
                    case "19":
                        $accounttype = 'unsecured';
                        break;
                    case "20":
                        $accounttype = 'unsecured';
                        break;
                    case "31":
                        $accounttype = 'secured';
                        break;
                    case "32":
                        $accounttype = 'secured';
                        break;

                    case "33":
                        $accounttype = 'secured';
                        break;
                    case "34":
                        $accounttype = 'secured';
                        break;
                    case "35":
                        $accounttype = 'unsecured';
                        break;
                    case "43":
                        $accounttype = 'unsecured';
                        break;
                    case "51":
                        $accounttype = 'unsecured';
                        break;
                    case "52":
                        $accounttype = 'secured';
                        break;
                    case "53":
                        $accounttype = 'secured';
                        break;
                    case "54":
                        $accounttype = 'secured';
                        break;
                    case "55":
                        $accounttype = 'secured';
                        break;
                    case "56":
                        $accounttype = 'secured';
                        break;
                    case "57":
                        $accounttype = 'secured';
                        break;
                    case "58":
                        $accounttype = 'secured';
                        break;
                    case "59":
                        $accounttype = 'secured';
                        break;
                    case "60":
                        $accounttype = 'unsecured';
                        break;
                    case "36":
                        $accounttype = 'unsecured';
                        break;
                    case "37":
                        $accounttype = 'unsecured';
                        break;
                    case "38":
                        $accounttype = 'unsecured';
                        break;
                    case "39":
                        $accounttype = 'unsecured';
                        break;
                    case "61":
                        $accounttype = 'unsecured';
                        break;


                }


                if ($accounttype == 'secured') {

                    $credit_amount_ternor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];


                    $credit_limit = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];

                    if ($credit_limit) {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount'];
                    } else {
                        $credit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];
                    }
                    if ($loantype == '10') {
                        $credit_limit_amount > $credit_amount_ternor ? $revolving_amount = $credit_limit_amount : $revolving_amount = $credit_amount_ternor;
                    } else {
                        $revolving_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                    }

                    $revolvingsecure += $revolving_amount;

                }

            }
        }

        $secure_credit = (($revolvingsecure / $adjusted_balance) * 100);

//////
        $secured_facilities_to_cotal_credit =  round($secure_credit, 2);
        if($secured_facilities_to_cotal_credit>0 && $secured_facilities_to_cotal_credit<25)
        {
            $system_score = 1;
        }
        if($secured_facilities_to_cotal_credit>25 && $secured_facilities_to_cotal_credit<50)
        {
            $system_score = 5;
        }
        if($secured_facilities_to_cotal_credit>50 && $secured_facilities_to_cotal_credit<75)
        {
            $system_score = 2;
        }
        if($secured_facilities_to_cotal_credit>75 && $secured_facilities_to_cotal_credit<100)
        {
            $system_score = 1;
        }

        $result = $this->get_value_of_weightage(14);

        $secured_facilities_to_cotal_credit_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$secured_facilities_to_cotal_credit,
            'system_score'=>$system_score,
        );
        /*     */
        $sum_emi_all = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            $repayment_tenor_data = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                $repayment_tenor_data = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($repayment_tenor_data != 0 && !is_array($repayment_tenor_data)) {
                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                    switch ($loantype) {
                        case "1":

                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "2":

                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '9';
                                break;
                            }
                            break;
                        case "3":

                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '11';
                                break;
                            }
                            break;
                        case "4":

                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '9';
                                break;
                            }
                            break;
                        case "5":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;
                        case "06":

                            if ($score <= 500) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "07":

                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '13.50';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;
                        case "08":

                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "09":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;

                        case "10":

                            $interest = '10';

                        case "11":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }

                            break;
                        case "12":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "13":

                            if ($score <= 500) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '11';
                                break;
                            }
                            break;
                        case "14":

                            if ($score <= 500) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '1';
                                break;
                            }
                            break;
                        case "15":


                            $interest = '10';

                            break;
                        case "16":

                            $interest = '18';
                            break;
                        case "17":

                            if ($score <= 500) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "18":

                            $interest = '36';
                            break;
                        case "19":

                            $interest = '36';
                            break;
                        case "20":

                            $interest = '36';
                            break;
                        case "31":

                            $interest = '1';
                            break;
                        case "32":

                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;

                        case "33":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "34":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "35":

                            $interest = '18';
                            break;
                        case "43":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "51":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "52":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "53":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "54":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "55":

                            $interest = '1';
                            break;
                        case "56":

                            $interest = '0.75';
                            break;
                        case "57":

                            $interest = '0.50';
                            break;
                        case "58":

                            $interest = '0.75';
                            break;
                        case "59":

                            $interest = '10';
                            break;
                        case "60":

                            $interest = '10';
                            break;
                        case "36":

                            $interest = '12';
                            break;
                        case "37":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "38":

                            $interest = '11';
                            break;
                        case "39":

                            $interest = '11';
                            break;
                        case "61":

                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;

                    }
                    $repayment_tenor = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Repayment_Tenure'];
                } else {

                    switch ($loantype) {
                        case "0":
                            $repayment_tenor = '0';
                            break;
                        case "1":
                            $repayment_tenor = '84';
                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "2":
                            $repayment_tenor = '240';
                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '9';
                                break;
                            }
                            break;
                        case "3":
                            $repayment_tenor = '180';
                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '11';
                                break;
                            }
                            break;
                        case "4":
                            $repayment_tenor = '240';
                            if ($score <= 500) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '9';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '9';
                                break;
                            }
                            break;
                        case "5":
                            $repayment_tenor = '48';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;
                        case "06":
                            $repayment_tenor = '24';
                            if ($score <= 500) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "07":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '13.50';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;
                        case "08":
                            $repayment_tenor = '84';
                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "09":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;

                        case "10":
                            $repayment_tenor = '1';
                            $interest = '10';

                        case "11":
                            $repayment_tenor = '84';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }

                            break;
                        case "12":
                            $repayment_tenor = '12';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "13":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '11';
                                break;
                            }
                            break;
                        case "14":
                            $repayment_tenor = '12';
                            if ($score <= 500) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '2';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '1';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '1';
                                break;
                            }
                            break;
                        case "15":
                            $repayment_tenor = '36';

                            $interest = '10';

                            break;
                        case "16":
                            $repayment_tenor = '1';
                            $interest = '18';
                            break;
                        case "17":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '13';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '11';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '10';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '10';
                                break;
                            }
                            break;
                        case "18":
                            $repayment_tenor = '1';
                            $interest = '36';
                            break;
                        case "19":
                            $repayment_tenor = '1';
                            $interest = '36';
                            break;
                        case "20":
                            $repayment_tenor = '1';
                            $interest = '36';
                            break;
                        case "31":
                            $repayment_tenor = '1';
                            $interest = '1';
                            break;
                        case "32":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '12';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '12';
                                break;
                            }
                            break;

                        case "33":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "34":
                            $repayment_tenor = '60';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "35":
                            $repayment_tenor = '1';
                            $interest = '18';
                            break;
                        case "43":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "51":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "52":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "53":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "54":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "55":
                            $repayment_tenor = '36';
                            $interest = '1';
                            break;
                        case "56":
                            $repayment_tenor = '36';
                            $interest = '0.75';
                            break;
                        case "57":
                            $repayment_tenor = '36';
                            $interest = '0.50';
                            break;
                        case "58":
                            $repayment_tenor = '36';
                            $interest = '0.75';
                            break;
                        case "59":
                            $repayment_tenor = '3';
                            $interest = '10';
                            break;
                        case "60":
                            $repayment_tenor = '60';
                            $interest = '10';
                            break;
                        case "36":
                            $repayment_tenor = '6';
                            $interest = '12';
                            break;
                        case "37":
                            $repayment_tenor = '12';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;
                        case "38":
                            $repayment_tenor = '12';
                            $interest = '11';
                            break;
                        case "39":
                            $repayment_tenor = '60';
                            $interest = '11';
                            break;
                        case "61":
                            $repayment_tenor = '36';
                            if ($score <= 500) {
                                $interest = '20';
                                break;
                            }
                            if ($score > 500 && $score <= 600) {
                                $interest = '19';
                                break;
                            }
                            if ($score > 600 && $score <= 650) {
                                $interest = '18';
                                break;
                            }
                            if ($score > 650 && $score <= 700) {
                                $interest = '17';
                                break;
                            }
                            if ($score > 700 && $score <= 750) {
                                $interest = '16';
                                break;
                            }
                            if ($score > 750 && $score <= 800) {
                                $interest = '15';
                                break;
                            }
                            if ($score > 800 && $score <= 850) {
                                $interest = '14';
                                break;
                            }
                            if ($score > 850) {
                                $interest = '13';
                                break;
                            }
                            break;

                    }
                }
                if ($loantype != '10') {
                    $loanamount_highcredit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount'];

                    $t1 = (($loanamount_highcredit * ($interest / (1200))) * (pow((1 + ($interest / (1200))), $repayment_tenor)));
                    $t2 = ((pow((1 + ($interest / (12 * 100))), ($repayment_tenor))) - 1);


                    $shadow_emi = round(($t1 / $t2), 0);

                    $sum_emi_all += $shadow_emi;
                }


            }
        }

        $fix_ob = (($sum_emi_all / $monthly_income) * 100);
///////

        $fixed_obligation_to_income = round($fix_ob, 2);
        if($fixed_obligation_to_income>0 && $fixed_obligation_to_income<25)
        {
            $system_score = 5;
        }
        if($fixed_obligation_to_income>25 && $fixed_obligation_to_income<40)
        {
            $system_score = 4;
        }
        if($fixed_obligation_to_income>40 && $fixed_obligation_to_income<60)
        {
            $system_score = 2;
        }
        if($fixed_obligation_to_income>60 && $fixed_obligation_to_income<75)
        {
            $system_score = 1;
        }
        if($fixed_obligation_to_income>75 && $fixed_obligation_to_income<90)
        {
            $system_score = 1;
        }
        if($fixed_obligation_to_income>90)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(16);

        $fixed_obligation_to_income_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$fixed_obligation_to_income,
            'system_score'=>$system_score*3,
        );
        /*     */

///////
        $no_of_active_account = $result_array['CAIS_Account']['CAIS_Summary']['Credit_Account']['CreditAccountActive'];
        if($no_of_active_account>0 && $no_of_active_account<2)
        {
            $system_score = 4;
        }
        if($no_of_active_account>2 && $no_of_active_account<4)
        {
            $system_score = 5;
        }
        if($no_of_active_account>4 && $no_of_active_account<6)
        {
            $system_score = 3;
        }
        if($no_of_active_account>6 && $no_of_active_account<10)
        {
            $system_score = 1;
        }
        if($no_of_active_account>10)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(17);

        $no_of_active_account_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$no_of_active_account,
            'system_score'=>$system_score,
        );
        /*     */


        $all_ali = array();
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {
                $all_ali[$i] = $loantype;
            }
        }

////////
        $variety_of_loans_Active = count(array_unique($all_ali));
        if($variety_of_loans_Active>0 && $variety_of_loans_Active<2)
        {
            $system_score = 3;
        }
        if($variety_of_loans_Active>2 && $variety_of_loans_Active<5)
        {
            $system_score = 5;
        }
        if($variety_of_loans_Active>5 && $variety_of_loans_Active<8)
        {
            $system_score = 1;
        }
        if($variety_of_loans_Active>8)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(18);

        $variety_of_loans_Active_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$variety_of_loans_Active,
            'system_score'=>$system_score,
        );
        /*     */


        $all_ali2 = array();
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

            $all_ali2[$i] = $loantype;
        }

///////
        $variety_of_loans_including_closed = count(array_unique($all_ali2));
        if($variety_of_loans_including_closed>0 && $variety_of_loans_including_closed<2)
        {
            $system_score = 3;
        }
        if($variety_of_loans_including_closed>2 && $variety_of_loans_including_closed<5)
        {
            $system_score = 5;
        }
        if($variety_of_loans_including_closed>5 && $variety_of_loans_including_closed<8)
        {
            $system_score = 1;
        }
        if($variety_of_loans_including_closed>8)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(19);

        $variety_of_loans_including_closed_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$variety_of_loans_including_closed,
            'system_score'=>$system_score,
        );
        /*     */
////////
        $no_of_credit_enquiry = $result_array['CAPS']['CAPS_Summary']['CAPSLast90Days'];
        if($no_of_credit_enquiry>0 && $no_of_credit_enquiry<1)
        {
            $system_score = 5;
        }
        if($no_of_credit_enquiry>1 && $no_of_credit_enquiry<2)
        {
            $system_score = 4;
        }
        if($no_of_credit_enquiry>2 && $no_of_credit_enquiry<3)
        {
            $system_score = 2;
        }
        if($no_of_credit_enquiry>3 && $no_of_credit_enquiry<6)
        {
            $system_score = 1;
        }
        if($no_of_credit_enquiry>6)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(20);

        $no_of_credit_enquiry_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$no_of_credit_enquiry,
            'system_score'=>$system_score,
        );
        /*     */


        $countcredit = count($result_array['CAPS']['CAPS_Application_Details']);
        $enquiry_credit = 0;
        for ($i = 0; $i < $countcredit; $i++) {

            $loandate = $result_array['CAPS']['CAPS_Application_Details'][$i]['Date_of_Request'];
            $ex = date('Y-m-d', strtotime($loandate));


            $statrt = date('Y-m-d');

            $end = date('Y-m-d', strtotime('-1 years'));

            if ($ex < $statrt && $ex > $end) {

                $enquiry_credit += 1;
            }
        }
////////
        $no_of_loans_availed_last_12_months = ($enquiry_credit / 4);

        if($no_of_loans_availed_last_12_months>0 && $no_of_loans_availed_last_12_months<1)
        {
            $system_score = 5;
        }
        if($no_of_loans_availed_last_12_months>1 && $no_of_loans_availed_last_12_months<1.5)
        {
            $system_score = 4;
        }
        if($no_of_loans_availed_last_12_months>1.5)
        {
            $system_score = 1;
        }

        $result = $this->get_value_of_weightage(21);

        $no_of_loans_availed_last_12_months_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$no_of_loans_availed_last_12_months,
            'system_score'=>$system_score,
        );
        /*     */

        $opendate = array();
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
            $open_date = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Open_Date'];
            $ex = date('Y-m-d', strtotime($open_date));
            $opendate[$i] = $ex;
        }

        usort($opendate, function ($a, $b) {
            $dateTimestamp1 = strtotime($a);
            $dateTimestamp2 = strtotime($b);

            return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
        });
        $givendate = strtotime("2018-06-30");
        $mindate = strtotime($opendate[0]);
        $datediff = ($givendate - $mindate);
        $finaldate = round($datediff / (60 * 60 * 24));
        $history = ($finaldate / 365);

////////
        $history_of_credit = round($history, 2);
        if($history_of_credit>1 && $history_of_credit<3)
        {
            $system_score = 1;
        }
        if($history_of_credit>3 && $history_of_credit<5)
        {
            $system_score = 3;
        }
        if($history_of_credit>5)
        {
            $system_score = 5;
        }

        $result = $this->get_value_of_weightage(22);

        $history_of_credit_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$history_of_credit,
            'system_score'=>$system_score,
        );
        /*     */

        $opendate = array();
        $limit_bre = 0;
        $current_balance = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];
                if ($loantype == '10') {
                    $current_balance = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];

                    $credit_limit_amount1 = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']:0;

                    if ($credit_limit_amount1) {
                        $hcredit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']:0;
                    } else {
                        $hcredit_limit_amount = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']:0;
                    }


                    if ($current_balance > $hcredit_limit_amount) {

                        $limit_bre += 1;
                    }

                }
            }

        }
/////////
        $limit_breach = $limit_bre;
        if($limit_breach == 0)
        {
            $system_score = 5;
        }
        if($limit_breach>0 && $limit_breach<2)
        {
            $system_score = 2;
        }
        if($limit_breach>2)
        {
            $system_score = 1;
        }

        $result = $this->get_value_of_weightage(23);

        $limit_breach_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$limit_breach,
            'system_score'=>$system_score,
        );
        /*     */

        $opendate = array();
        $overdueall = 0;
        $revolvingall = 0;
        $revolving_amountsum2 = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

            $current_balance += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
            $overdue = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

            if ($overdue) {

                $overdueall += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];
            }
            if ($loantype == '10') {

                $credit_amount_credit = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
                $credit_limit2 = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']:0;

                if ($credit_limit2) {
                    $credit_limit_amount2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Credit_Limit_Amount']:0;
                } else {
                    $credit_limit_amount2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']?$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Highest_Credit_or_Original_Loan_Amount']:0;
                }

                $credit_limit_amount2 > $credit_amount_credit ? $revolving_amount2 = $credit_limit_amount2 : $revolving_amount2 = $credit_amount_credit;
                $revolving_amountsum2 += $revolving_amount2;
                $overdue2 = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

                if ($overdue2 == 0 || is_array($overdue2)) {

                    $credit_limit_amount2 > $credit_amount_credit ? $revolving_amount2 = $credit_limit_amount2 : $revolving_amount2 = $credit_amount_credit;
                    $revolvingall += $revolving_amount2;
                }

            }


        }
        $obligation = ($revolving_amountsum2 - $revolvingall);
        $p16 = ($obligation * (5 / 100));
        $xy = (($overdueall / ($p16 + $sum_emi_all)) * 100);

///////////
        $overdue_to_obl = round($xy, 0);
        if($overdue_to_obl == 0)
        {
            $system_score = 5;
        }
        if($overdue_to_obl>0 && $overdue_to_obl<25)
        {
            $system_score = 2;
        }
        if($overdue_to_obl>25 && $overdue_to_obl < 50)
        {
            $system_score = 1;
        }
        if($overdue_to_obl>50 && $overdue_to_obl < 75)
        {
            $system_score = 1;
        }
        if($overdue_to_obl>75 && $overdue_to_obl < 100)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(24);

        $overdue_to_obl_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$overdue_to_obl,
            'system_score'=>$system_score*4,
        );
        /*     */
        $opendate = array();
        $overdueall2 = 0;
        $current_balance = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $loantype = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Type'];

            $current_balance += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Current_Balance'];
            $overdue = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];

            if ($overdue) {

                $overdueall2 += $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Amount_Past_Due'];
            }


        }

///////////
        $monthly_income_overdue = round(($overdueall2 / $monthly_income) * 100, 2);
        if($monthly_income_overdue == 0)
        {
            $system_score = 5;
        }
        if($monthly_income_overdue>0 && $monthly_income_overdue<25)
        {
            $system_score = 2;
        }
        if($monthly_income_overdue>25 && $monthly_income_overdue < 50)
        {
            $system_score = 1;
        }
        if($monthly_income_overdue>50 && $monthly_income_overdue < 75)
        {
            $system_score = 1;
        }
        if($monthly_income_overdue>75 && $monthly_income_overdue < 100)
        {
            $system_score = 0;
        }

        $result = $this->get_value_of_weightage(25);

        $monthly_income_overdue_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$monthly_income_overdue,
            'system_score'=>$system_score*2,
        );
        /*     */
        $opendate = array();
        $alloverdue = 0;
        $alloverdue2 = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

            for ($j = 0; $j < $acount_history; $j++) {
                $current_year = date("Y");
                $previous_year = date("Y", strtotime("-1 year"));


                $overdue_year = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                $overdue_month = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                if ($overdue_year == $current_year && $overdue_month <= '06') {
                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                    if ($overduedates != '0' && !is_array($overduedates)) {
                        $alloverdue += 1;
                    }
                }
                if ($overdue_year == $previous_year && $overdue_month == '12') {
                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                    if ($overduedates != '0' && !is_array($overduedates)) {
                        $alloverdue2 += 1;
                    }
                }
            }
        }
//////////

        $delay_in_past_6_months = $delay6 = ($alloverdue + $alloverdue2);
        if($delay_in_past_6_months == 0)
        {
            $system_score = 5;
        }
        if($delay_in_past_6_months>0)
        {
            $system_score = 1;
        }


        $result = $this->get_value_of_weightage(27);

        $delay_in_past_6_months_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$delay_in_past_6_months,
            'system_score'=>$system_score*2,
        );
        /*     */
        $opendate = array();
        $alloverdue11 = 0;
        $alloverdue12 = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

            for ($j = 0; $j < $acount_history; $j++) {
                $current_year = date("Y");
                $previous_year = date("Y", strtotime("-1 year"));


                $overdue_year = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                $overdue_month = @$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                if ($overdue_year == $current_year && $overdue_month <= '06') {
                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                    if ($overduedates != '0' && !is_array($overduedates)) {

                        $alloverdue11 += 1;
                    }
                }
                if ($overdue_year == $previous_year && $overdue_month >= '06') {

                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                    if ($overduedates != '0' && !is_array($overduedates)) {


                        $alloverdue12 += 1;
                    }
                }

            }


        }
///////////

        $delay_in_past_12_months = ($alloverdue11 + $alloverdue12);
        if($delay_in_past_12_months == 0)
        {
            $system_score = 5;
        }
        if($delay_in_past_12_months>0)
        {
            $system_score = 1;
        }


        $result = $this->get_value_of_weightage(28);

        $delay_in_past_12_months_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$delay_in_past_12_months,
            'system_score'=>$system_score,
        );
        /*     */
        $opendate = array();
        $alloverdue13 = 0;
        $alloverdue23 = 0;
        $alloverdue23 = 0;
        $alloverdue33 = 0;
        for ($i = 0; $i < $loan; $i++) {
            $acount_history = count($result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History']);

            for ($j = 0; $j < $acount_history; $j++) {
                $current_year = date("Y");
                $previous_year = date("Y", strtotime("-1 year"));


                $overdue_year = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Year'];
                $overdue_month = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Month'];
                if ($overdue_year == $current_year && $overdue_month <= '06') {
                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];
                    if ($overduedates != '0' && !is_array($overduedates)) {

                        $alloverdue13 += 1;
                    }
                }
                if ($overdue_year == $previous_year && $overdue_month >= '01') {

                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                    if ($overduedates != '0' && !is_array($overduedates)) {


                        $alloverdue23 += 1;
                    }
                }
                $pre_previous = date("Y", strtotime("-2 year"));
                if ($overdue_year == $pre_previous && $overdue_month >= '06') {

                    $overduedates = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][$j]['Days_Past_Due'];

                    if ($overduedates != '0' && !is_array($overduedates)) {


                        $alloverdue33 += 1;
                    }
                }

            }


        }
/////////
        $delay_in_past_36_months = ($alloverdue13 + $alloverdue23 + $alloverdue33);
        if($delay_in_past_36_months == 0)
        {
            $system_score = 5;
        }
        if($delay_in_past_36_months>0)
        {
            $system_score = 1;
        }


        $result = $this->get_value_of_weightage(29);

        $delay_in_past_36_months_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$delay_in_past_36_months,
            'system_score'=>$system_score,
        );
        /*     */
        $settlement = 0;
        for ($i = 0; $i <= $loan; $i++) {
            $status_loan  = '00, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 79, 81, 85, 86, 87, 88, 90, 91, 93, 97';
            $status_loan = explode(',', $status_loan);
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if (in_array($loanstatus,$status_loan))
            {
                $settlement += 1;
            }
            else{
                $settlement = 0;
            }
        }

        $write_off = $settlement;
        if($write_off == 0)
        {
            $system_score = 5;
        }
        if($write_off>0)
        {
            $system_score = 1;
        }


        $result = $this->get_value_of_weightage(30);

        $write_off_arr = array(
            'id'=>$result['id'],
            'rating_name'=>$result['rating_name'],
            'preferred_value'=>$result['preferred_value'],
            'maximum_weightage'=>$result['maximum_weightage'],
            'calculation_type'=>$result['calculation_type'],
            'user_result'=>$write_off,
            'system_score'=>$system_score,
        );
        /*     */
        //////////////Over Due Date's

        for ($i = 0; $i <= $loan; $i++) {
            $loanstatus = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Status'];
            if ($loanstatus == '11' || $loanstatus == '21' || $loanstatus == '22' || $loanstatus == '23' || $loanstatus == '24' || $loanstatus == '25' || $loanstatus == '71' || $loanstatus == '78' || $loanstatus == '80' || $loanstatus == '82' || $loanstatus == '83' || $loanstatus == '84') {

                $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];
                if ($days) {

                    $subscription_no['bank'][] = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name'].'('.$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Number'].')';
                    $days = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];
                    if (is_array($days)) {

                    } else {
                        $subscription_no[$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Subscriber_Name'].'('.$result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['Account_Number'].')'] = $result_array['CAIS_Account']['CAIS_Account_DETAILS'][$i]['CAIS_Account_History'][0]['Days_Past_Due'];

                    }


                }
            }

        }
//////////
        $subscription_no;

        $result_experian['civil_report'] = array(
            'Overall_Leveraging_Ratio'=>$overall_leveraging_ratio_arr,
            'Leverage_Ratio'=>$leveraging_ratio_max_available_credit_arr,
            'Limit_Utilization'=>$limit_utilization_arr,
            'Outstanding_to_Limit_Term_Credit'=>$outstanding_to_limit_Term_credit_arr,
            'Outstanding_to_Limit_PC'=>$outstanding_to_limit_including_past_facilities_arr,
            'Short_term_Leveraging'=>$short_term_leveraging_arr,
            'Revolving_Credit_line_to_Total_Credit'=>$credit_m_1_revolving_arr,
//            'Term_Credit_to_Total_Credit'=>$credit_m_1_term_credit_arr,
//            'Available_Revolving_line_to_Total_Credit'=>$credit_m_1_term_available_revolving_arr,
            'Short_Term_Credit_to_Total_Credit'=>$short_term_credit_to_total_credit_arr,
//            'Medium_Term_Credit_to_Total_Credit'=>$medium_term_credit_to_total_credit_arr,
//            'Long_Term_Credit_to_Total_Credit'=>$long_term_credit_to_total_credit_arr,
            'Secured_Facilities_to_Total_Credit'=>$secured_facilities_to_cotal_credit_arr,
//            'Unsecured_Facilities_to_Total_Credit'=>$unsecured_facilities_to_total_credit_arr,
            'Fixed_Obligation_to_Income'=>$fixed_obligation_to_income_arr,
            'No_of_Active_Account'=>$no_of_active_account_arr,
            'Variety_of_Loans_Active'=>$variety_of_loans_Active_arr,
//            'Variety_of_Loans_including_Closed'=>$variety_of_loans_including_closed_arr,
            'No_of_Credit_Enquiry_In_last_3_Months'=>$no_of_credit_enquiry_arr,
            'No_of_Loans_Availed_to_Credit_Enquiry_in_last_12_months'=>$no_of_loans_availed_last_12_months_arr,
            'History_of_credit_oldest_credit_account'=>$history_of_credit_arr,
            'Limit_Breach'=>$limit_breach_arr,
            'Overdue_to_Obligation'=>$overdue_to_obl_arr,
            'Overdue_to_Monthly_Income'=>$monthly_income_overdue_arr,
            'Number_of_instances_of_delay_in_past_6_months'=>$delay_in_past_6_months_arr,
            'Number_of_instances_of_delay_in_past_12_months'=>$delay_in_past_12_months_arr,
            'Number_of_instances_of_delay_in_past_36_months'=>$delay_in_past_36_months_arr,
        );

        $result_experian_sum = array(
            'Overall_Leveraging_Ratio'=>$overall_leveraging_ratio_arr['system_score']?$overall_leveraging_ratio_arr['system_score']:'',
            'Leverage_Ratio'=>$leveraging_ratio_max_available_credit_arr['system_score']?$leveraging_ratio_max_available_credit_arr['system_score']:'',
            'Limit_Utilization'=>$limit_utilization_arr['system_score']?$limit_utilization_arr['system_score']:'',
            'Outstanding_to_Limit_Term_Credit'=>$outstanding_to_limit_Term_credit_arr['system_score']?$outstanding_to_limit_Term_credit_arr['system_score']:'',
            'Outstanding_to_Limit_PC'=>$outstanding_to_limit_including_past_facilities_arr['system_score']?$outstanding_to_limit_including_past_facilities_arr['system_score']:'',
            'Short_term_Leveraging'=>$short_term_leveraging_arr['system_score']?$short_term_leveraging_arr['system_score']:'',
            'Revolving_Credit_line_to_Total_Credit'=>$credit_m_1_revolving_arr['system_score']?$credit_m_1_revolving_arr['system_score']:'',
//            'Term_Credit_to_Total_Credit'=>$credit_m_1_term_credit_arr,
//            'Available_Revolving_line_to_Total_Credit'=>$credit_m_1_term_available_revolving_arr,
            'Short_Term_Credit_to_Total_Credit'=>$short_term_credit_to_total_credit_arr['system_score']?$short_term_credit_to_total_credit_arr['system_score']:'',
//            'Medium_Term_Credit_to_Total_Credit'=>$medium_term_credit_to_total_credit_arr,
//            'Long_Term_Credit_to_Total_Credit'=>$long_term_credit_to_total_credit_arr,
            'Secured_Facilities_to_Total_Credit'=>$secured_facilities_to_cotal_credit_arr['system_score']?$secured_facilities_to_cotal_credit_arr['system_score']:'',
//            'Unsecured_Facilities_to_Total_Credit'=>$unsecured_facilities_to_total_credit_arr,
            'Fixed_Obligation_to_Income'=>$fixed_obligation_to_income_arr['system_score']?$fixed_obligation_to_income_arr['system_score']:'',
            'No_of_Active_Account'=>$no_of_active_account_arr['system_score']?$no_of_active_account_arr['system_score']:'',
            'Variety_of_Loans_Active'=>$variety_of_loans_Active_arr['system_score']?$variety_of_loans_Active_arr['system_score']:'',
//            'Variety_of_Loans_including_Closed'=>$variety_of_loans_including_closed_arr,
            'No_of_Credit_Enquiry_In_last_3_Months'=>$no_of_credit_enquiry_arr['system_score']?$no_of_credit_enquiry_arr['system_score']:'',
            'No_of_Loans_Availed_to_Credit_Enquiry_in_last_12_months'=>$no_of_loans_availed_last_12_months_arr['system_score']?$no_of_loans_availed_last_12_months_arr['system_score']:'',
            'History_of_credit_oldest_credit_account'=>$history_of_credit_arr['system_score']?$history_of_credit_arr['system_score']:'',
            'Limit_Breach'=>$limit_breach_arr['system_score']?$limit_breach_arr['system_score']:'',
            'Overdue_to_Obligation'=>$overdue_to_obl_arr['system_score']?$overdue_to_obl_arr['system_score']:'',
            'Overdue_to_Monthly_Income'=>$monthly_income_overdue_arr['system_score']?$monthly_income_overdue_arr['system_score']:'',
            'Number_of_instances_of_delay_in_past_6_months'=>$delay_in_past_6_months_arr['system_score']?$delay_in_past_6_months_arr['system_score']:'',
            'Number_of_instances_of_delay_in_past_12_months'=>$delay_in_past_12_months_arr['system_score']?$delay_in_past_12_months_arr['system_score']:'',
            'Number_of_instances_of_delay_in_past_36_months'=>$delay_in_past_36_months_arr['system_score']?$delay_in_past_36_months_arr['system_score']:'',
        );

        echo "<pre>";
        print_r($result_experian_sum); exit;

        if($borrower_info['age']>=35 && $borrower_info['age']<=40)
        {
            $result_experian_sum['age'] = 10;
        }
        if(($borrower_info['age']>=30 && $borrower_info['age']<35) || ($borrower_info['age']>40 && $borrower_info['age']<=45))
        {
            $result_experian_sum['age'] = 9;
        }
        if(($borrower_info['age']>=25 && $borrower_info['age']<30) || ($borrower_info['age']>45 && $borrower_info['age']<=50))
        {
            $result_experian_sum['age'] = 8;
        }
        if(($borrower_info['age']>=20 && $borrower_info['age']<25) || ($borrower_info['age']>50 && $borrower_info['age']<=55))
        {
            $result_experian_sum['age'] = 7;
        }
        if(($borrower_info['age']>=18 && $borrower_info['age']<20) || ($borrower_info['age']>55 && $borrower_info['age']<=58))
        {
            $result_experian_sum['age'] = 4;
        }
        if($borrower_info['age']>=58 && $borrower_info['age']<65)
        {
            $result_experian_sum['age'] = 3;
        }
        if($borrower_info['age']>65){
            $result_experian_sum['age'] = 0;
        }
        else{
            $result_experian_sum['age'] = 0;
        }

        if($borrower_info['highest_qualification'] == 1)
        {
            $result_experian_sum['education'] = 0;
        }
        if($borrower_info['highest_qualification'] == 2)
        {
            $result_experian_sum['education'] = 5;
        }
        if($borrower_info['highest_qualification'] == 3)
        {
            $result_experian_sum['education'] = 8;
        }
        if($borrower_info['highest_qualification'] == 4)
        {
            $result_experian_sum['education'] = 10;
        }
        if($borrower_info['highest_qualification'] == 5)
        {
            $result_experian_sum['education'] = 0;
        }
        else{
            $result_experian_sum['education'] = 0;
        }

        if($borrower_info['occuption_id'] == 1){
            $result_experian_sum['occupation'] = 15;
        }
        if($borrower_info['occuption_id'] == 2){
            $result_experian_sum['occupation'] = 18;
        }
        if($borrower_info['occuption_id'] == 3){
            $result_experian_sum['occupation'] = 20;
        }

        if($borrower_info['occuption_id'] == 4){
            $result_experian_sum['occupation'] = 8;
        }
        else{
            $result_experian_sum['occupation'] = 0;
        }

        $result_experian_sum['cheque_bouncing'] = 5;
        $result_experian_sum['credit_summation_to_annual_income'] = 5;
        $result_experian_sum['digital_banking'] = 5;
        $result_experian_sum['savings_as_percentage'] = 5;
        $result_experian_sum['present_residence'] = 5;
        $result_experian_sum['city_of_residence'] = 5;
        $result_experian_sum['institute_of_study'] = 5;

        $result_experian_sum['experience'] = 5;
        $result_experian_sum['experian_score'] = $result_array['SCORE']['BureauScore'];
        //Save
        $experian_credit_score = $result_experian_sum['experian_score'];
        unset($result_experian_sum['experian_score']);
        $sum_all = array_sum($result_experian_sum);
        $total = ($sum_all)/26;
        $return_user_rating = array(
            'total_rating'=>round($total),
            'experian_rating'=>$experian_credit_score,
        );

        //Interest Range//

        if($total>=9 && $total<=10)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>12,
                'prefered_interest_max'=>17,
            );
        }
        if($total>=8 && $total<=8.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>13,
                'prefered_interest_max'=>18,
            );
        }

        if($total>=7 && $total<=7.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>14,
                'prefered_interest_max'=>19,
            );
        }

        if($total>=6 && $total<=6.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>15,
                'prefered_interest_max'=>20,
            );
        }

        if($total>=5 && $total<=5.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>16,
                'prefered_interest_max'=>21,
            );
        }
        if($total>=4 && $total<=4.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>17,
                'prefered_interest_max'=>22,
            );
        }
        if($total>=3 && $total<=3.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>18,
                'prefered_interest_max'=>23,
            );
        }

        if($total>=1 && $total<=2.99)
        {
            $prefered_interest_range = array(
                'prefered_interest_min'=>19,
                'prefered_interest_max'=>24,
            );
        }


        $this->db->select('id');
        $this->db->from('ant_borrower_rating');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result_experian_sum['experian_score'] = $experian_credit_score;
            $result_experian_sum['modified_date'] = date('Y-m-d H:i:s');
            $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->update('ant_borrower_rating', $result_experian_sum);

            //Update Prefered interest range

            $this->db->where('proposal_id', $proposal_id);
            $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->update('p2p_proposal_details', $prefered_interest_range);
        }
        else{
            $result_experian_sum['experian_score'] = $experian_credit_score?$experian_credit_score:'';
            $result_experian_sum['borrower_id'] = $this->session->userdata('borrower_id');
            $result_experian_sum['created_date'] = date('Y-m-d H:i:s');
            $this->db->insert('ant_borrower_rating', $result_experian_sum);

            //Update Prefered interest range

            $this->db->where('proposal_id', $proposal_id);
            $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->update('p2p_proposal_details', $prefered_interest_range);
        }

        return $return_user_rating;
    }

    public function get_value_of_weightage($id)
    {
        $this->db->select('id, rating_name, preferred_value, maximum_weightage, calculation_type');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

}

<?php
class Experian extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $lead_id
     */
    public function Engine()
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

//        $this->db->where('BL.id', 284);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
echo "<pre>";
            $borrower_infos = $query->result_array();
            foreach ($borrower_infos AS $borrower_info) {
                $experian_info = array();
                $this->db->select('experian_response');
                $this->db->from('p2p_borrower_experian_response');
                $this->db->where('borrower_id', $borrower_info['id']);
                $this->db->order_by('id', 'desc');
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
                    $result = (array)$query->row();


                    $experian_response = htmlspecialchars_decode($result['experian_response']);
                    $xmL1 = str_replace('<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header/><SOAP-ENV:Body><ns2:processResponse xmlns:ns2="urn:cbv2"><ns2:out>', '', $experian_response);
                    $xmL2 = str_replace('</ns2:out></ns2:processResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>', '', $xmL1);

                    if (simplexml_load_string($xmL2)) {
                        $xml_input = simplexml_load_string($xmL2);
                        $json_input = json_encode($xml_input);
                        $report = json_decode($json_input, true);
//                        echo "<pre>";
//                        print_r($report); exit;
                        $experian_score = $report['SCORE']['BureauScore']?$report['SCORE']['BureauScore']:0;
                        if($experian_score){
                            $this->db->select('id');
                            $this->db->from('ant_borrower_rating');
                            $this->db->where('borrower_id', $borrower_info['id']);
                            $this->db->order_by('id', 'desc');
                            $query = $this->db->get();
                            if ($this->db->affected_rows() > 0) {
                                $experian_info = array(
                                    'experian_score' => $experian_score,
                                    'experian_response' => $report['UserMessage']['UserMessageText'],
                                );
                                $this->db->where('borrower_id', $borrower_info['id']);
                                $this->db->update('ant_borrower_rating', $experian_info);


                            } else {
                                $data['rating-ratio'] = array(
                                    'borrower_id' => $borrower_info['id'],
                                    'experian_response' => $report['UserMessage']['UserMessageText'],
                                    'experian_score' => $experian_score,
                                );
                                $this->db->insert('ant_borrower_rating', $data['rating-ratio']);
                            }
                        }
                        else{
                            $this->db->select('id');
                            $this->db->from('ant_borrower_rating');
                            $this->db->where('borrower_id', $borrower_info['id']);
                            $this->db->order_by('id', 'desc');
                            $query = $this->db->get();
                            if ($this->db->affected_rows() > 0) {
                                $experian_info = array(
                                    'experian_score' => 0,
                                    'experian_response' => $report['UserMessage']['UserMessageText']?$report['UserMessage']['UserMessageText']:'',
                                );
                                $this->db->where('borrower_id', $borrower_info['id']);
                                $this->db->update('ant_borrower_rating', $experian_info);

                            } else {
                                $experian_info = array(
                                    'experian_score' => 0,
                                    'borrower_id' => $borrower_info['id'],
                                    'experian_response' => $report['UserMessage']['UserMessageText']?$report['UserMessage']['UserMessageText']:'',
                                );
                                $this->db->insert('ant_borrower_rating', $experian_info);
                            }
                        }
                    }

                }
            }
        }
exit;
    }

    public function getOccuptiondetails($borrower_id, $occuption_id)
    {


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
        $sql = "SELECT * FROM p2p_borrowers_docs_table WHERE borrower_id = ".$borrower_id." AND (docs_type = 'bank_statement' OR docs_type = 'Online_bank_statement') ORDER BY id DESC LIMIT 0,1";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();

            $response = json_decode($result['whatsloan_response'], true);

            if($response['success'] == 1)
            {
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
                function check_Values($check, $transactionDataObjects)
                {
                    foreach($transactionDataObjects AS $key=>$transactionData)
                    {
                        if($transactionData['txnListType'] == $check)
                        {
                            return $transactionData['count'];
                        }
                    }
                }

                foreach ($arr_key AS $key => $response_key)
                {

                    $banking_response_value[$response_key] = check_Values($response_key, $transactionDataObjects);
                }

                $date = DateTime::createFromFormat('d/m/Y', $response['result']['metaData']['lastTransactionSeen']);
                $lastTransactionSeen =  $date->format('Y-m-d');
                $date = DateTime::createFromFormat('d/m/Y', $response['result']['metaData']['duration']['fromDate']);
                $fromDate =  $date->format('Y-m-d');
                $date1 = new DateTime($lastTransactionSeen);
                $date2 = new DateTime($fromDate);
                $diff = $date1->diff($date2);
                $date_difference = $diff->m;

                $expenseToIncomeRatio = (float) filter_var( $response['result']['categoryDetails']['expenseIncomeRatio']['expenseToIncomeRatio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

                $credit_summation_to_income = ((($banking_response_value['Credits']-$banking_response_value['Cash Deposits at Bank'])/2)*365)/($date_difference/$anually_income);
                $digital_banking = ($banking_response_value['Cash Withdrawals at Bank'] + $banking_response_value['ATM Withdrawals'])/$banking_response_value['Debits'];
                $savings_as_percentage_of_annual_income = 100 - (int)$response['result']['categoryDetails']['expenseIncomeRatio']['expenseToIncomeRatio'];

                return $arr_banking_response = array(
                    'credit_summation_to_annual_income'=>$credit_summation_to_income,
                    'digital_banking'=>$digital_banking,
                    'savings_as_percentage_of_annual_income'=>$expenseToIncomeRatio,
                    'cheque_bouncing'=>$banking_response_value['Check Bounces'],
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
}
?>
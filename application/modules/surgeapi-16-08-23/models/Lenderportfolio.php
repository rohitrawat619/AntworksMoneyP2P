<?php
class Lenderportfolio extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('bidding/Biddingmodel', 'Smsmodule'));
    }

    public function successfullbids($lenderId)
    {
        $this->db->select('PBPD.*, PD.PLRN, PBL.name AS borrower_name, 
                    LAS.borrower_acceptance,
                    LAS.admin_signature,					
					LAS.admin_signature_date,
					LAS.borrower_signature,
					LAS.borrower_signature_date,
					LAS.credit_ops_manager_signature,
					LAS.credit_ops_manager_signature_date,
					LAS.credit_ops_signature,
					LAS.credit_ops_signature_date,
					LAS.lender_signature,
					LAS.lender_signature_date');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_borrowers_list AS PBL', 'PBL.id = PBPD.borrowers_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
        $this->db->where('PBPD.lenders_id',$lenderId);
        $this->db->where('LAS.borrower_acceptance',1);
        $this->db->where('LAS.borrower_signature',1);
        $this->db->order_by('PBPD.proposal_id','DESC');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function unsuccessfullbids($lenderId)
    {
        $this->db->select('PBPD.*, PD.PLRN, PBL.name AS borrower_name,
                    LAS.borrower_acceptance,
                    LAS.admin_signature,					
					LAS.admin_signature_date,
					LAS.borrower_signature,
					LAS.borrower_signature_date,
					LAS.credit_ops_manager_signature,
					LAS.credit_ops_manager_signature_date,
					LAS.credit_ops_signature,
					LAS.credit_ops_signature_date,
					LAS.lender_signature,
					LAS.lender_signature_date');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_borrowers_list AS PBL', 'PBL.id = PBPD.borrowers_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
        $this->db->where('PBPD.lenders_id',$lenderId);
        $this->db->where('LAS.borrower_acceptance',3);
        $this->db->order_by('PBPD.proposal_id','DESC');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function lender_ledgerinfo($lenderId)
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_statement_entry');
        $this->db->where('lender_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function total_amount_invested($lenderId)
    {
        $this->db->select('SUM(bid_loan_amount) AS total_invested');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function total_principal_outstanding($lenderId)
    {
        $this->db->select('SUM(emi_principal) AS total_principal_outstanding');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('lender_id', $lenderId);
        $query = $this->db->get();
        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function total_principal_recieved($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('proposal_status', '5');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_principal) AS total_principal_recieved');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('status', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_principal_recieved[$bid_detail['bid_registration_id']] = $result['total_principal_recieved'];

                }
                else{

                }
            }
            return $total_principal_recieved;
        }
        else{
            return false;
        }
    }

    public function total_principal_delayed($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('proposal_status', '5');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_principal) AS total_principal_delayed');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('is_overdue', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_principal_delayed[$bid_detail['bid_registration_id']] = $result['total_principal_delayed'];

                }
                else{

                }
            }
            return $total_principal_delayed;
        }
        else{
            return false;
        }
    }

    public function total_interest_recieved($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('proposal_status', '5');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_interest) AS total_interest_recieved');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('status', '1');
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_interest_recieved[$bid_detail['bid_registration_id']] = $result['total_interest_recieved'];

                }
                else{

                }
            }
            return $total_interest_recieved;
        }
        else{
            return false;
        }
    }

    public function total_other_payment_recieved($lenderId)
    {
        $this->db->select('SUM(emi_principal) AS total_principal_outstanding');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('lender_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
        }
        else{
          return false;
        }
    }

    public function total_no_of_loans($lenderId)
    {
        $this->db->select('COUNT(bid_registration_id) AS total_no_of_loans');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('proposal_status', '5');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function total_no_of_closed_loans($lenderId)
    {
        $this->db->select('COUNT(bid_registration_id) AS total_no_of_closed_loans');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('proposal_status', '6');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function past_due_30_89days($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_amount) AS past_due_30_89days');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('emi_sql_date > ', 'DATE(NOW() + INTERVAL 30 DAY)');
                $this->db->where('emi_sql_date < ', 'DATE(NOW() + INTERVAL 89 DAY)');

                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $past_due_30_89days[$bid_detail['bid_registration_id']] = $result['past_due_30_89days'];

                }
                else{

                }
            }
            return $past_due_30_89days;
        }
        else{
            return false;
        }
    }

    public function past_due_90_180days($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_amount) AS past_due_90_180days');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('emi_sql_date > ', 'DATE(NOW() + INTERVAL 90 DAY)');
                $this->db->where('emi_sql_date < ', 'DATE(NOW() + INTERVAL 180 DAY)');
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $past_due_90_180days[$bid_detail['bid_registration_id']] = $result['past_due_90_180days'];

                }
                else{

                }
            }
            return $past_due_90_180days;
        }
        else{
            return false;
        }
    }

    public function past_due_plus_180days($lenderId)
    {
        $this->db->select('bid_registration_id');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $bid_details = $query->result_array();
            foreach ($bid_details AS $bid_detail)
            {
                $this->db->select('SUM(emi_amount) AS past_due_plus_180days');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('loan_id', $bid_detail['bid_registration_id']);
                $this->db->where('emi_sql_date > ', 'DATE(NOW() + INTERVAL 180 DAY)');
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $past_due_plus_180days[$bid_detail['bid_registration_id']] = $result['past_due_plus_180days'];

                }
                else{

                }
            }
            return $past_due_plus_180days;
        }
        else{
            return false;
        }
    }

    //Tenor = 6 months
    public function gradeA($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeAamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months', '6');

        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }

    }

    //Tenor 6> && 9<= months
    public function gradeB($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeBamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '6');
        $this->db->where('ppd.tenor_months <= ', '9');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor 9> && 12<= months
    public function gradeC($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeCamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '9');
        $this->db->where('ppd.tenor_months <= ', '12');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor 12> && 18<= months
    public function gradeD($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeDamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '12');
        $this->db->where('ppd.tenor_months <= ', '18');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor 18> && 24<= months
    public function gradeE($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeEamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '18');
        $this->db->where('ppd.tenor_months <= ', '24');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor 24> && 30<= months
    public function gradeF($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeFamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '24');
        $this->db->where('ppd.tenor_months <= ', '30');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor 30> months
    public function gradeG($lenderId)
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeGamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $lenderId);
        $this->db->where('ppd.tenor_months > ', '30');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function remainningAmount($lenderId)
    {
        $this->db->select('account_balance');
        $this->db->from('p2p_lender_main_balance');
        $this->db->where('lender_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function totalInvestment($lenderId)
    {
        $this->db->select('SUM(bid_loan_amount) AS totalinloan_amount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $result =  (array)$query->row();

            $remainningAmount = $this->remainningAmount();

            return $remainningAmount = $remainningAmount['account_balance']+$result['totalinloan_amount'];

        }
        else{
            $remainningAmount = $this->remainningAmount();
            return $remainningAmount['account_balance'];
        }
    }

    public function termResult($lenderId)
    {
        $totalInvestment = $this->totalInvestment();
        $gradeA = $this->gradeA($lenderId);
        $gradeB = $this->gradeB($lenderId);
        $gradeC = $this->gradeC($lenderId);
        $gradeD = $this->gradeD($lenderId);
        $gradeE = $this->gradeE($lenderId);
        $gradeF = $this->gradeF($lenderId);
        $gradeG = $this->gradeG($lenderId);
        $gradeR = $this->remainningAmount($lenderId);

        $gradeA = $gradeA?($gradeA['gradeAamount']*100)/$totalInvestment:0;
        $gradeB = $gradeB?($gradeB['gradeBamount']*100)/$totalInvestment:0;
        $gradeC = $gradeC?($gradeC['gradeCamount']*100)/$totalInvestment:0;
        $gradeD = $gradeD?($gradeD['gradeDamount']*100)/$totalInvestment:0;
        $gradeE = $gradeE?($gradeE['gradeEamount']*100)/$totalInvestment:0;
        $gradeF = $gradeF?($gradeF['gradeFamount']*100)/$totalInvestment:0;
        $gradeG = $gradeG?($gradeG['gradeGamount']*100)/$totalInvestment:0;
        $gradeR = $gradeR?($gradeR['account_balance']*100)/$totalInvestment:0;

        $termResult = array(
            'gradeA'=>$gradeA,
            'gradeB'=>$gradeB,
            'gradeC'=>$gradeC,
            'gradeD'=>$gradeD,
            'gradeE'=>$gradeE,
            'gradeF'=>$gradeF,
            'gradeG'=>$gradeG,
            'gradeR'=>$gradeR,
        );

        return $termResult;
    }

    public function accrued_Interest($lenderId)
    {
        $this->db->select('SUM(emi_interest) AS accrued_Interest');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('lender_id', $lenderId);
        $query = $this->db->get();
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function loan_summary($lenderId)
    {
        $this->db->select('BPD.bid_registration_id, BPD.loan_no,
                           BI.name, PD.tenor_months
                          ');
        $this->db->from('p2p_bidding_proposal_details AS BPD');
        $this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = BPD.borrowers_id');
        $this->db->join('p2p_proposal_details AS PD', 'ON PD.proposal_id = BPD.proposal_id');
        $this->db->where('lenders_id', $lenderId);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $results =  $query->result_array();
            foreach ($results AS $result)
            {
                $this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('status', '0');
                $this->db->where('loan_id', $result['bid_registration_id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $principalAmount = (array)$query->row();
                    $principalamount = $principalAmount['principalAmount'];


                }
                $number_of_emi_serviced = $this->number_of_emi_serviced($result['bid_registration_id']);
                $emi_amount = $this->Each_EMI_Amount($result['bid_registration_id']);
                $next_repay = $this->Next_Repay($result['bid_registration_id']);

                $loan_summary[] = array(
                    'bid_registration_id'=>$result['bid_registration_id'],
                    'borrower_name'=>$result['name'],
                    'loan_no'=>$result['loan_no'],
                    'tenor_months'=>$result['tenor_months'],
                    'principal_outstanding'=>$principalamount,
                    'number_of_emi_serviced'=>$number_of_emi_serviced,
                    'emi_amount'=>$emi_amount,
                    'next_repay'=>$next_repay,
                );
            }
            return $loan_summary;
        }
        else{
            return false;
        }
    }

    public function number_of_emi_serviced($bid_registration_id)
    {
        $this->db->select('COUNT(id) AS number_of_emi_serviced');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('loan_id', $bid_registration_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
            return $result['number_of_emi_serviced'];
        }
        else{
            return false;
        }
    }

    public function Each_EMI_Amount($bid_registration_id)
    {
        $this->db->select('emi_amount');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('loan_id', $bid_registration_id);
        $this->db->limit('1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
            return $result['emi_amount'];
        }
        else{
            return false;
        }
    }

    public function Next_Repay($bid_registration_id)
    {
        $this->db->select('emi_date');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('loan_id', $bid_registration_id);
        $this->db->where('status', '0');
        $this->db->order_by('id', 'asc');
        $this->db->limit('1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
            return $result['emi_date'];
        }
        else{
            return false;
        }
    }

}
?>
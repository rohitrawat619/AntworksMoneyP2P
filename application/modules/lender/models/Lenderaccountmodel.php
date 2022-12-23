<?php

class Lenderaccountmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function total_aggregateamount()
    {
       $this->db->select('SUM(amount) AS pay_in');
       $this->db->from('p2p_lender_pay_in');
       $this->db->where('lender_id', $this->session->userdata('user_id'));
       $query = $this->db->get();
       if($this->db->affected_rows()>0)
       {
       	$pay_in = $query->row()->pay_in;
       	$query = $this->db->select("SUM(amount) AS pay_out")->get_where('p2p_lender_pay_out', array('lender_id' => $this->session->userdata('user_id')));
		 if($this->db->affected_rows()>0)
		   {
			   $pay_out = $query->row()->pay_out;
			   return $pay_in - $pay_out;

		   }
		   else{
			   return $pay_in;
		   }
       }
       else{
           return false;
       }
    }
    //2
    public function total_principal_outstanding()
    {
        $this->db->select('SUM(emi_principal) AS total_principal_outstanding');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('status', array(0));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row()->total_principal_outstanding;
        }
        else{
            return false;
        }
    }

    public function avg_loan_amount()
    {
        $this->db->select('AVG(approved_loan_amount) AS avg_loan_amount');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('loan_status', array(0,1));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row()->avg_loan_amount;
        }
        else{
            return false;
        }
    }

    public function total_no_of_loans()
    {
        $this->db->select('COUNT(id) AS total_no_of_loans');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
		//$this->db->where_in('loan_status', array(0,1));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {

            return $query->row()->total_no_of_loans;
        }
        else{
            return false;
        }
    }

    public function total_loan_repayment_date_not_due()
    {
        $this->db->select('id');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->where('loan_status', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {

            $results = $query->result_array();
            $total_loan_repayment_date_not_due = 0;
            foreach ($results AS $result){
				$where = "(emi_date >= CURDATE() - INTERVAL 30 DAY AND emi_date < CURDATE() - INTERVAL 0 DAY)";
                $this->db->select('*');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $this->db->where('status', '0');
                $this->db->where($where);
                $query = $this->db->get();
                if($this->db->affected_rows()>0){
                    $total_loan_repayment_date_not_due += 1;
                }
            }
            return $total_loan_repayment_date_not_due;
        }
        else{
            return false;
        }
    }

    public function total_interest_recieved()
    {
        $this->db->select('id');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->where_in('loan_status', array(0,1));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $results = $query->result_array();
            $total_interest_recieved = 0;
            foreach ($results AS $result)
            {
                $this->db->select('SUM(emi_interest) AS total_interest_recieved');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $this->db->where('status', '1');
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $amount = $query->row()->total_interest_recieved;
                    $total_interest_recieved += $amount;

                }
            }
//            echo "<pre>";
//            print_r($total_interest_recieved); exit;
            return $total_interest_recieved;
        }
        else{
            return false;
        }
    }

    public function roi()
    {
//		$roi = $this->db->select("SUM(emi_interest)/SUM(emi_principal) AS roi")
//				 ->get_where('p2p_borrower_emi_details', array('status'=> 1, 'lender_id'=>$this->session->userdata('user_id')))->row()->roi;
//    	return round($roi*12, 2);

        $total_loan_amount = $this->db->select("SUM(approved_loan_amount) total_loan_amount")->get_where('p2p_disburse_loan_details', array('lender_id' => $this->session->userdata('user_id')))->row()->total_loan_amount;
        $query = $this->db->select('dld.approved_loan_amount, dpd.interest_rate')
			->join('p2p_bidding_proposal_details AS dpd', 'ON dpd.bid_registration_id = dld.bid_registration_id')
			->get_where('p2p_disburse_loan_details AS dld', array('dld.lender_id' => $this->session->userdata('user_id')));
        if($this->db->affected_rows()>0)
		{
          $results = $query->result_array();
			$loan_amount_ir = 0;
          foreach ($results AS $result){
           $loan_amount_ir += $result['approved_loan_amount'] * $result['interest_rate'];
		  }
		}
        return round($loan_amount_ir/$total_loan_amount, 2);


        $this->db->select('id, approved_loan_amount');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('loan_status', array(0,1));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {

            $results = $query->result_array();
            $close_laon_amount = 0;
            $total_close_loan_emi = 0;
            foreach ($results AS $result){

                $close_laon_amount += $result['approved_loan_amount'];

                $this->db->select('SUM(emi_interest) AS total_emi_interest');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $this->db->where('status', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0){
                    $result = $query->row();
                    $total_close_loan_emi += $result->total_emi_interest;
                }
            }
            return $roi = round($total_close_loan_emi/$close_laon_amount, 2);
        }
        else{
            return false;
        }
    }

    public function account_main_balance()
    {
		return $this->db->select("account_balance")
				 ->get_where('p2p_lender_main_balance', array('lender_id'=>$this->session->userdata('user_id')))->row()->account_balance;


    }



    public function processing_fee_charges(){
      return false;
    }

    public function amount_withdrawal()
    {
      return false;
    }

    public function past_due_0_30days()
    {
    	$where = "(emi_date >= CURDATE() - INTERVAL 30 DAY AND emi_date < CURDATE() - INTERVAL 0 DAY)";
		$this->db->select('count(id) AS past_due_0_30days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where('status', 0);
		$query = $this->db->get();

		if($this->db->affected_rows()>0)
		{
			return $past_due_0_30days = $query->row()->past_due_0_30days;

		}
		else{
			return false;
		}
    }

    public function past_due_30_60days()
    {
		$where = "(emi_date >= CURDATE() - INTERVAL 60 DAY AND emi_date < CURDATE() - INTERVAL 31 DAY)";
		$this->db->select('count(id) AS past_due_30_60days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where('status', 0);
		$query = $this->db->get();

		if($this->db->affected_rows()>0)
		{
			return $past_due_30_60days = $query->row()->past_due_30_60days;

		}
		else{
			return false;
		}
    }

    public function past_due_60_90days()
    {
		$where = "(emi_date >= CURDATE() - INTERVAL 90 DAY AND emi_date < CURDATE() - INTERVAL 61 DAY)";
		$this->db->select('count(id) AS past_due_60_90days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where($where);
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where('status', 0);
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return $past_due_60_90days = $query->row()->past_due_60_90days;

		}
		else{
			return false;
		}
    }

    public function past_due_plus_90days()
    {
		$this->db->select('count(id) AS past_due_plus_90days');
		$this->db->from('p2p_borrower_emi_details');
		$this->db->where('emi_date < CURDATE() - INTERVAL 91 DAY');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where('status', 0);
		$query = $this->db->get();

		if($this->db->affected_rows()>0)
		{
			return $past_due_plus_90days = $query->row()->past_due_plus_90days;

		}
		else{
			return false;
		}
    }

    public function amountAvilabletoPayout()
	{
		$query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
           $main_balance = $query->row()->account_balance;
           $query = $this->db->select_sum('lock_amount')
						     ->get_where('p2p_lender_lock_amount',
							   array('lender_id'=>$this->session->userdata('user_id'),
									  'is_release'=>0
							    ));
           if($this->db->affected_rows()>0)
		   {
              $locked_amount = $query->row()->lock_amount;
              $avilable_amount = $main_balance - $locked_amount;
              if($avilable_amount>0)
			  {
                return $avilable_amount;
			  }
              else{
                return 0;
			  }

		   }
           else{
             return $main_balance;
		   }
		}
		else{
			return 0;
		}
	}

    public function total_principal_recieved()
    {
		$this->db->select('id');
		$this->db->from('p2p_disburse_loan_details');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('loan_status', array(0,1));
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			$results = $query->result_array();
            foreach ($results AS $result)
            {
                $this->db->select('SUM(emi_principal) AS total_principal_recieved');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $this->db->where('status', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_principal_recieved[$result['id']] = $result['total_principal_recieved'];

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

    public function total_principal_delayed()
    {
		$this->db->select('id');
		$this->db->from('p2p_disburse_loan_details');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('loan_status', array(0,1));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $results = $query->result_array();
            foreach ($results AS $result)
            {
                $this->db->select('SUM(emi_principal) AS total_principal_delayed');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $this->db->where('is_overdue', 1);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_principal_delayed[$result['id']] = $result['total_principal_delayed'];

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

    public function total_other_payment_recieved()
    {
		$this->db->select('id');
		$this->db->from('p2p_disburse_loan_details');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where_in('loan_status', array(0,1));
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			$results = $query->result_array();
            foreach ($results AS $result)
            {
                $this->db->select('SUM(emi_principal) AS total_principal_outstanding');
                $this->db->from('p2p_borrower_emi_details');
                $this->db->where('disburse_loan_id', $result['id']);
                $query = $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    $result = (array)$query->row();
                    $total_principal_outstanding[$result['id']] = $result['total_principal_outstanding'];

                }
                else{

                }
            }
            return $total_principal_outstanding;
        }
        else{
            return false;
        }
    }

    public function total_no_of_closed_loans()
    {
        $this->db->select('COUNT(id) AS total_no_of_closed_loans');
        $this->db->from('p2p_disburse_loan_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->where('loan_status', '1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    //Tenor < = 6 months
	public function gradeA()
	{
		$this->db->select('SUM(bpd.bid_loan_amount) AS gradeAamount');
		$this->db->from('p2p_bidding_proposal_details AS bpd');
		$this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
		$this->db->where('lenders_id', $this->session->userdata('user_id'));
		$this->db->where('bpd.accepted_tenor <=', '6');
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
    public function gradeB()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeBamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '6');
        $this->db->where('bpd.accepted_tenor <= ', '9');
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
    public function gradeC()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeCamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '9');
        $this->db->where('bpd.accepted_tenor <= ', '12');
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
    public function gradeD()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeDamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '12');
        $this->db->where('bpd.accepted_tenor <= ', '18');
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
    public function gradeE()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeEamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '18');
        $this->db->where('bpd.accepted_tenor <= ', '24');
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
    public function gradeF()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeFamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '24');
        $this->db->where('bpd.accepted_tenor <= ', '30');
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
    public function gradeG()
    {
        $this->db->select('SUM(bpd.bid_loan_amount) AS gradeGamount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->join('p2p_proposal_details AS ppd', 'ON ppd.proposal_id = bpd.proposal_id' ,'left');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
        $this->db->where('bpd.accepted_tenor > ', '30');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function remainningAmount()
    {
        $this->db->select('account_balance');
        $this->db->from('p2p_lender_main_balance');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function totalInvestment()
    {
        $this->db->select('SUM(bid_loan_amount) AS totalinloan_amount');
        $this->db->from('p2p_bidding_proposal_details AS bpd');
        $this->db->where('lenders_id', $this->session->userdata('user_id'));
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

    public function termResult()
    {
        $totalInvestment = $this->totalInvestment();
        $gradeA = $this->gradeA();
        $gradeB = $this->gradeB();
        $gradeC = $this->gradeC();
        $gradeD = $this->gradeD();
        $gradeE = $this->gradeE();
        $gradeF = $this->gradeF();
        $gradeG = $this->gradeG();
        $gradeR = $this->remainningAmount();

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

    public function accrued_Interest()
    {
        $this->db->select('SUM(emi_interest) AS accrued_Interest');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
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

	public function loan_summary()
	{
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name, BI.borrower_id as b_borrower_id, DLD.date_created AS disbursement_date,
                           DLD.id AS loan_disbursement_id,
                           DLD.approved_loan_amount AS approved_loan_amount
                          ');
		$this->db->from('p2p_disburse_loan_details AS DLD');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON DLD.bid_registration_id = BPD.bid_registration_id');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = DLD.borrower_id');
		$this->db->where('DLD.lender_id', $this->session->userdata('user_id'));
		$this->db->order_by('DLD.date_created', 'desc');
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			$results =  $query->result_array();
			foreach ($results AS $result)
			{
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if($this->db->affected_rows()>0)
				{
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}

				$this->db->select('SUM(emi_payment_amount) AS emi_payment_amount');
				$this->db->from('p2p_emi_payment_details');
				$this->db->where('is_verified', '1');
				$this->db->where('loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if($this->db->affected_rows()>0)
				{
					$emi_payment_amount = (array)$query->row();
					$emi_payment_amount = $emi_payment_amount['emi_payment_amount'];


				}

				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$next_repay = $this->Next_Repay($result['loan_disbursement_id']);

				$loan_summary[] = array(
					'loan_disbursement_id'=>$result['loan_disbursement_id'],
					'bid_registration_id'=>$result['bid_registration_id'],
					'borrower_name'=>$result['name'],
					'b_borrower_id'=>$result['b_borrower_id'],
					'loan_no'=>$result['loan_no'],
					'tenor_months'=>$result['accepted_tenor'],
					'loan_amount'=>$result['approved_loan_amount'],
					'total_amount_repaid'=>$emi_payment_amount,
					'principal_outstanding'=>$principalamount,
					'number_of_emi_serviced'=>$number_of_emi_serviced,
					'emi_amount'=>$emi_amount,
					'next_repay'=>$next_repay,
					'disbursement_date'=>date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		}
		else{
			return false;
		}
	}

    public function number_of_emi_serviced($loan_disbursement_id)
    {
        $this->db->select('COUNT(id) AS number_of_emi_serviced');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('disburse_loan_id', $loan_disbursement_id);
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

    public function Each_EMI_Amount($loan_disbursement_id)
    {
        $this->db->select('emi_amount');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('disburse_loan_id', $loan_disbursement_id);
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

    public function Next_Repay($loan_disbursement_id)
    {
        $this->db->select('emi_date');
        $this->db->from('p2p_borrower_emi_details');
        $this->db->where('disburse_loan_id', $loan_disbursement_id);
        $this->db->where('status', '0');
        $this->db->order_by('id', 'asc');
        $this->db->limit('1');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $result = (array)$query->row();
            return date('d-M-Y', strtotime($result['emi_date']));
        }
        else{
            return false;
        }
    }

	public function createLoanledger($loan_disbursement_id)
	{
		error_reporting(E_ALL);
		$loanLedger = array();
		$balance = 0;
		$query = $this->db->select('dld.date_created, dld.id AS disburse_loan_id, bpd.loan_no, dld.bid_registration_id, dld.approved_loan_amount, dld.loan_processing_charges, dld.loan_tieup_fee, dld.disburse_amount, dld.reference')
			->join('p2p_bidding_proposal_details bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
			->get_where('p2p_disburse_loan_details AS dld', array('dld.id'=>$loan_disbursement_id));
		if($this->db->affected_rows()>0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$loanLedger['loan_no'] = $result['loan_no'];
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "Loan Disbursement",
					'reference' => $result['reference'],
					'debit' => "",
					'credit' => $result['approved_loan_amount'],
					'balance' => $result['approved_loan_amount'],
					'narration' => "",
				);
				$query = $this->db->select('bed.id AS emi_id, SUBDATE(bed.emi_date,1) AS due_date, bed.emi_date,  bed.emi_amount, bed.emi_interest, bed.emi_principal, bed.emi_balance, bed.status, 
				                            eps.emi_payment_date,
				                            eps.referece')
					->join('p2p_emi_payment_details eps', 'ON eps.emi_id = bed.id', 'left')
					->get_where('p2p_borrower_emi_details as bed',
						array('bed.disburse_loan_id' => $result['disburse_loan_id'], 'bed.emi_date <=' => date('Y-m-d'))
					);
				if ($this->db->affected_rows() > 0) {
					$emi_details = $query->result_array();
					$balance = $result['approved_loan_amount'];
					foreach ($emi_details AS $emi_detail) {
						if ($emi_detail['status'] == 1) {

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['due_date'])),
								'particular' => "being interest charged",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_interest'],
								'balance' => $balance += $emi_detail['emi_interest'],
								'narration' => "",
							);

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Interest paid",
								'reference' => "",
								'debit' => $emi_detail['emi_interest'],
								'credit' => "",
								'balance' => $balance -= $emi_detail['emi_interest'],
								'narration' => "",
							);

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Loan repayment",
								'reference' => "",
								'debit' => $emi_detail['emi_principal'],
								'credit' => "",
								'balance' => $balance -= $emi_detail['emi_principal'],
								'narration' => "",
							);


						} else {

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['due_date'])),
								'particular' => "being interest charged",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_interest'],
								'balance' => $balance += $emi_detail['emi_interest'],
								'narration' => "",
							);
						}


					}
				}
			}

			return $loanLedger;
		}
	}

//	public function lenderInvestment()
//	{
//		$investmentaccount = array();
//		$this->db->select('account_balance')
//			->get_where('p2p_lender_main_balance', array('lender_id' => $this->session->userdata('user_id')));
//		if ($this->db->affected_rows() > 0) {
//            //Money brought in (payin)
//			$query = $this->db->select('amount, transaction_id, created_date')
//							  ->get_where('p2p_lender_pay_in', array('lender_id' => $this->session->userdata('user_id')));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title'=>'Money brought in (payin)',
//						'amount'=>$result['amount'],
//						'remark'=>$result['transaction_id'],
//						'date_added'=>$result['created_date'],
//						'operator' => '+',
//					);
//				}
//
//			}
//			//Payouts
//			$query = $this->db->select('amount, transaction_id, created_date')
//				->get_where('p2p_lender_pay_out', array('lender_id' => $this->session->userdata('user_id')));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title'=>'Payouts',
//						'amount'=>$result['amount'],
//						'remark'=>$result['transaction_id'],
//						'date_added'=>$result['created_date'],
//						'operator' => '-',
//					);
//				}
//
//			}
//            //Loan given
//			$query = $this->db->select('dld.approved_loan_amount, dld.bid_registration_id, dld.date_created, bpd.loan_no')
//				->join('p2p_bidding_proposal_details AS bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id', 'left')
//				->get_where('p2p_disburse_loan_details AS dld', array('dld.lender_id' => $this->session->userdata('user_id')));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title'=>'Loan given',
//						'amount'=>$result['approved_loan_amount'],
//						'remark'=>$result['loan_no'],
//						'date_added'=>$result['date_created'],
//						'operator' => '-',
//					);
//				}
//
//			}
//            //repayment received
//			$query = $this->db->select('ded.emi_amount, epd.emi_payment_amount, epd.emi_payment_date, epd.referece')
//								->join('p2p_emi_payment_details as epd', 'ON epd.emi_id = ded.id', 'left')
//								->get_where('p2p_borrower_emi_details ded', array('lender_id' => $this->session->userdata('user_id'), 'epd.id IS NOT NULL' => null));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title'=>'repayment received',
//						'amount'=>$result['emi_payment_amount'],
//						'remark' =>$result['referece'],
//						'date_added'=>$result['emi_payment_date'],
//						'operator' => '+',
//					);
//				}
//
//			}
//			//Reinvestment done
//			$query = $this->db->select('amount, created_date')
//				->get_where('p2p_lender_reinvestment', array('lender_id' => $this->session->userdata('user_id')));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title' => 'Reinvestment done',
//						'amount' => $result['amount'],
//						'remark' => '',
//						'date_added' => $result['created_date'],
//						'operator' => '-',
//					);
//				}
//
//			}
//
//			//Lender assistance fees charged
//
//			$query = $this->db->select('amount, created_date')
//				->get_where('p2p_lender_fees_charged', array('lender_id' => $this->session->userdata('user_id')));
//			if ($this->db->affected_rows() > 0) {
//				$results = $query->result_array();
//				foreach ($results AS $result)
//				{
//					$investmentaccount[] = array(
//						'title'=>'Lender assistance fees charged',
//						'amount'=>$result['amount'],
//						'remark' => '',
//						'date_added'=>$result['created_date'],
//						'operator' => '-',
//					);
//				}
//
//			}
//
//			usort($investmentaccount, function($a, $b) {
//				$ad = new DateTime($a['date_added']);
//				$bd = new DateTime($b['date_added']);
//
//				if ($ad == $bd) {
//					return 0;
//				}
//
//				return $ad < $bd ? -1 : 1;
//			});
////			$finalinvestmentAccount = array();
////			foreach ($investmentaccount AS $key => $invest)
////			{
////				$finalinvestmentAccount[] = array();
////			}
//          return $investmentaccount;
//		} else {
//            return false;
//		}
//	}

	public function compareInvest($investmentaccount)
	{
		if (strtotime($investmentaccount['date_added']) < strtotime($investmentaccount['date_added']))
			return 1;
		else if (strtotime($investmentaccount['date_added']) > strtotime($investmentaccount['date_added']))
			return -1;
		else
			return 0;
	}

	public function getLenderledger()
	{
		$query = $this->db->order_by('created_date', 'asc')->get_where('p2p_lender_statement_entry', array('lender_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
           return false;
		}
	}

	public function lenderInvestment()
	{
		$this->db->select('*');
		$this->db->from('p2p_lender_statement_entry');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function searchlenderInvestment()
	{
		$arr_date = explode('-', $this->input->post('filter_by_date'));
		$start_date = date('Y-m-d H:i:s', strtotime($arr_date[0]));
		$end_date = date('Y-m-d 23:59:59', strtotime($arr_date[1]));
		$this->db->select('*');
		$this->db->from('p2p_lender_statement_entry');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$this->db->where('created_date >= ', $start_date);
		$this->db->where('created_date <= ', $end_date);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function getPreviouspayoutrequest()
	{
		$query = $this->db->get_where('p2p_lender_requests', array('lender_id' => $this->session->userdata('user_id'), 'type' => 'pay_out'));
		if($this->db->affected_rows()>0)
		{
           return $query->result_array();
		}
		else{
           return  false;
		}
	}

	public function gradeResult()
	{
		$query = $this->db->select_sum('bid_loan_amount')->join('ant_borrower_rating br', 'on br.borrower_id = bpd.borrowers_id', 'left')->group_by('bpd.lenders_id')->get_where('p2p_bidding_proposal_details bpd', array('br.antworksp2p_rating >=' => 0, 'br.antworksp2p_rating <=' => 2.5, 'bpd.lenders_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
			$gratdeA = $query->row()->bid_loan_amount;
		}
		else{
			$gratdeA = 0;
		}

		$query = $this->db->select_sum('bid_loan_amount')->join('ant_borrower_rating br', 'on br.borrower_id = bpd.borrowers_id', 'left')->group_by('bpd.lenders_id')->get_where('p2p_bidding_proposal_details bpd', array('br.antworksp2p_rating >' => 2.5, 'br.antworksp2p_rating <' => 5, 'bpd.lenders_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
			$gratdeB = $query->row()->bid_loan_amount;
		}
		else{
			$gratdeB = 0;
		}
		$query = $this->db->select_sum('bid_loan_amount')->join('ant_borrower_rating br', 'on br.borrower_id = bpd.borrowers_id', 'left')->group_by('bpd.lenders_id')->get_where('p2p_bidding_proposal_details bpd', array('br.antworksp2p_rating >' => 5, 'br.antworksp2p_rating <=' => 7.5, 'bpd.lenders_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
			$gratdeC = $query->row()->bid_loan_amount;
		}
		else{
			$gratdeC = 0;
		}
		$query = $this->db->select_sum('bid_loan_amount')->join('ant_borrower_rating br', 'on br.borrower_id = bpd.borrowers_id', 'left')->group_by('bpd.lenders_id')->get_where('p2p_bidding_proposal_details bpd', array('br.antworksp2p_rating >' => 7.5, 'br.antworksp2p_rating <=' => 10, 'bpd.lenders_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
			$gratdeD = $query->row()->bid_loan_amount;
		}
		else{
			$gratdeD = 0;
		}
		return $gradeResult = array(
			'gradeA' => round(($gratdeA*100)/$this->totalInvestment(), 2),
			'gradeB' => round(($gratdeB*100)/$this->totalInvestment(), 2),
			'gradeC' => round(($gratdeC*100)/$this->totalInvestment(), 2),
			'gradeD' => round(($gratdeD*100)/$this->totalInvestment(), 2),
		);

	}


}
?>

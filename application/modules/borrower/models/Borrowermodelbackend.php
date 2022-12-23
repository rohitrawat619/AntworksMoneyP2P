<?php
class Borrowermodelbackend extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_borrower_payment_registration()
    {
      $this->db->select('*');
      $this->db->from('p2p_borrower_registration_payment');
      $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
      $query = $this->db->get();
      if($this->db->affected_rows()>0)
      {
           return true;
      }
      else{
           return false;
      }

    }

    public function get_currentopen_proposal()
    {
        $this->db->select('*');
        $this->db->from('p2p_proposal_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
          return $query->row();
        }
        else{
             return false;
        }
    }

    public function borrower_bidding_info()
    {
        $this->db->select('PBPD.*, PD.PLRN, PLL.name AS lender_name, LAS.borrower_acceptance,
                    LAS.admin_signature,					
					LAS.admin_signature_date,
					LAS.borrower_signature,
					LAS.borrower_signature_date,
					LAS.credit_ops_manager_signature,
					LAS.credit_ops_manager_signature_date,
					LAS.credit_ops_signature,
					LAS.credit_ops_signature_date,
					LAS.lender_signature,
					LAS.lender_signature_date
					');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_lender_list AS PLL', 'PLL.user_id = PBPD.lenders_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
        $this->db->where('PBPD.borrowers_id',$this->session->userdata('borrower_id'));
        $this->db->order_by('PBPD.proposal_id','DESC');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }

    public function get_currentactivate_proposal()
    {
    	$this->load->model('Requestmodel');
		$proposal_days = $this->Requestmodel->proposal_days();
        $this->db->select('PD.*, '.$proposal_days.'-TIMESTAMPDIFF(DAY, DATE(PD.date_added), CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status !=', '3');
        $this->db->order_by('PD.proposal_id', 'desc');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function open_proposal_info()
    {
        $this->db->select('PD.*, TIMESTAMPDIFF(DAY, PD.date_added, CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('(bidding_status = 1 OR bidding_status = 4)');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function get_all_proposal()
    {
        $this->db->select('PD.*, TIMESTAMPDIFF(DAY, PD.date_added, CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function closed_proposal_info()
    {
        $this->db->select('PD.*, TIMESTAMPDIFF(DAY, PD.date_added, CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '3');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function successfull_proposal_info()
    {
        $this->db->select('PD.*, TIMESTAMPDIFF(DAY, PD.date_added, CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '2');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function partially_proposal_info()
    {
        $this->db->select('PD.*, TIMESTAMPDIFF(DAY, PD.date_added, CURDATE()) AS RemainingDays, PSN.proposal_status_name');
        $this->db->from('p2p_proposal_details AS PD');
        $this->db->join('p2p_proposal_status_name AS PSN', 'PSN.proposal_status_id = PD.bidding_status');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '4');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function borrower_pendingsignature_loan()
    {
        $this->db->select('PBPD.*, PD.PLRN, PLL.name AS lender_name');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_lender_list AS PLL', 'PLL.user_id = PBPD.lenders_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
        $this->db->where('PBPD.borrowers_id',$this->session->userdata('borrower_id'));
        $this->db->where('LAS.borrower_signature','0');
        $this->db->where('LAS.borrower_acceptance','1');
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

    public function kycDoctype()
    {
        $this->db->select('docs_type, docs_name');
        $this->db->from('p2p_borrowers_docs_table');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('docs_type !=', 'online_bank_statement');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getAdddress()
    {
        $query = $this->db->select('bad.r_address, bad.r_address1, bad.r_city, bad.r_pincode, se.state')
		              ->from("p2p_borrower_address_details as bad")
		              ->join("p2p_state_experien as se", 'on se.code = bad.r_state', 'left')
		              ->where("borrower_id", $this->session->userdata('borrower_id'))
		              ->get();
        return (array)$query->row();
    }

    public function loan_agreement_copies()
    {
        $this->db->select('PBPD.*, PD.PLRN, PLL.name AS lender_name');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_lender_list AS PLL', 'PLL.user_id = PBPD.lenders_id', 'left');
        $this->db->join('p2p_loan_aggrement_signature AS LAS', 'LAS.bid_registration_id = PBPD.bid_registration_id', 'left');
        $this->db->where('PBPD.borrowers_id',$this->session->userdata('borrower_id'));
        $this->db->where('LAS.borrower_signature','1');
        $this->db->where('LAS.borrower_acceptance','1');
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

    public function loanaggrement($bid_registration_id)
    {
        $sql = "SELECT
					BL.name AS BORROWERNAME,
					BL.email AS BORROWEREMAIL,
					BL.mobile AS BORROWERMOBILE,
					BL.dob AS BORROWERDOB,
					BL.pan AS BORROWERR_pan,
					BAD.r_address AS BORROWERR_Address,
					BAD.r_address1 AS BORROWERR_Address1,
					BAD.r_city AS BORROWERR_City,
					BAD.r_state AS BORROWERR_State,
					BAD.r_pincode AS BORROWERR_Pincode,										
					BDT.aadhaar AS BORROWERR_aadhaar,
                    BDT.father_name AS BORROWERFATHERNAME,
                    
					LL.user_id AS user_id_lender,
					LL.name AS LENDER_fNAME,
					LL.dob AS LENDER_dob,
					LL.pan AS LENDER_PAN,
					LL.lender_id AS LENDER_ID,
					LL.email AS LENDER_email,
					LL.mobile AS LENDER_mobile,
					
					LA.state AS LENDER_state_code,
					LA.city AS LENDER_city,
					LA.address1 AS LENDER_address,
					LA.address2 AS LENDER_address1,					

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,					
					PD.tenor_months AS TENORMONTHS,
					BPD.bid_loan_amount AS APPROVERD_LOAN_AMOUNT,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id
					FROM p2p_bidding_proposal_details BPD
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id					
					
					LEFT JOIN p2p_lender_list AS LL
					ON LL.user_id = BPD.lenders_id
					LEFT JOIN p2p_lender_address AS LA
					ON LA.lender_id = BPD.lenders_id
					WHERE BPD.bid_registration_id=".$bid_registration_id." AND BPD.borrowers_id = ".$this->session->userdata('borrower_id')."
			";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
           return $query->result_array();
        }
        else{
           return false;
        }
    }

    ////////////////////////////////////////////////////
    ///
    public function liveProposal()
    {
              $this->db->where('bidding_status', 1);
              $this->db->or_where('bidding_status', 4);
       return $this->db->count_all_results('p2p_proposal_details');
    }

    public function liveLender()
    {
              $this->db->where('status', 1);
       return $this->db->count_all_results('p2p_lender_list');
    }

    public function totalBidrecieved()
    {
              //$this->db->where('proposal_status', 2);
       return $this->db->count_all_results('p2p_bidding_proposal_details');
    }

    public function totalBidfailed()
    {
              $this->db->where('proposal_status', 3);
       return $this->db->count_all_results('p2p_bidding_proposal_details');
    }

    public function currentproposelBids()
    {
        $this->db->select('proposal_id');
        $this->db->from('p2p_proposal_details');
        $this->db->where_in('bidding_status', array('1','4'));
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
//        echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $res = (array)$query->row();
            $this->db->where('proposal_id', $res['proposal_id']);
            return $this->db->count_all_results('p2p_bidding_proposal_details');
        }
        else{
            return false;
        }
    }

    public function totalAvgintrestrate()
    {
        $this->db->select_avg('interest_rate');
        $query = $this->db->get('p2p_bidding_proposal_details');
        if($this->db->affected_rows()>0)
        {
          return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function avrageInterstrate()
    {
        $this->db->where('borrowers_id', $this->session->userdata('borrower_id'));
        $this->db->select_avg('interest_rate');
        $query = $this->db->get('p2p_bidding_proposal_details');
        if($this->db->affected_rows()>0)
        {
          return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function updateAddress()
    {
        $array_address['borrower_id'] = $this->session->userdata('borrower_id');
        $array_address['address_data'] = json_encode(array(
            'r_address'=>$this->input->post('address1'),
            'r_address1'=>$this->input->post('address2'),
            'r_city'=>$this->input->post('city'),
            'r_state'=>$this->input->post('state_code'),
            'r_pincode'=>$this->input->post('pincode'),
        ));
        $array_address['created_date'] = date('Y-m-d H:i:s');

        $this->db->insert('p2p_request_change_address', $array_address);
        if($this->db->affected_rows()>0)
        {
          return true;
        }
        else{
            return false;
        }
    }

    public function previousRequestChengeaddress()
    {
        $query = $this->db->get_where('p2p_request_change_address', array('borrower_id' => $this->session->userdata('borrower_id')));
        return $query->result_array();
    }

    public function borrowerDoc()
    {
        $this->db->select('*');
        $this->db->from('p2p_borrowers_docs_table');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }

    }

    public function closedBorrowerloan()
    {
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name,
                           LL.name AS lender_name,
                           DLD.date_created AS disbursement_date,
                           DLD.id AS loan_disbursement_id
                          ');
		$this->db->from('p2p_disburse_loan_details AS DLD');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON DLD.bid_registration_id = BPD.bid_registration_id');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = DLD.borrower_id');
		$this->db->join('p2p_lender_list AS LL', 'ON LL.user_id = DLD.lender_id');
		$this->db->order_by('DLD.date_created', 'desc');
		$this->db->where('DLD.borrower_id', $this->session->userdata('borrower_id'));
		$this->db->where('loan_status', 1);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}
				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$loan_summary[] = array(
					'loan_disbursement_id' => $result['loan_disbursement_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_name' => $result['name'],
					'lender_name' => $result['lender_name'],
					'loan_no' => $result['loan_no'],
					'tenor_months' => $result['accepted_tenor'],
					'principal_outstanding' => $principalamount,
					'number_of_emi_serviced' => $number_of_emi_serviced,
					'emi_amount' => $emi_amount,
					'disbursement_date' => date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		} else {
			return false;
		}
    }

	public function getOngoingloan()
	{
		$this->db->select('BPD.bid_registration_id, BPD.loan_no, BPD.interest_rate,
                           BPD.accepted_tenor,
                           BI.name,
                           LL.name AS lender_name,
                           DLD.date_created AS disbursement_date,
                           DLD.id AS loan_disbursement_id
                          ');
		$this->db->from('p2p_disburse_loan_details AS DLD');
		$this->db->join('p2p_bidding_proposal_details AS BPD', 'ON DLD.bid_registration_id = BPD.bid_registration_id');
		$this->db->join('p2p_borrowers_list AS BI', 'ON BI.id = DLD.borrower_id');
		$this->db->join('p2p_lender_list AS LL', 'ON LL.user_id = DLD.lender_id');
		$this->db->order_by('DLD.date_created', 'desc');
		$this->db->where('DLD.borrower_id', $this->session->userdata('borrower_id'));
		$this->db->where('loan_status !=', 1);
		$query = $this->db->get();
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$this->db->select('SUM(emi_principal) AS principalAmount, emi_amount');
				$this->db->from('p2p_borrower_emi_details');
				$this->db->where('status', '0');
				$this->db->where('disburse_loan_id', $result['loan_disbursement_id']);
				$query = $this->db->get();
				if ($this->db->affected_rows() > 0) {
					$principalAmount = (array)$query->row();
					$principalamount = $principalAmount['principalAmount'];


				}
				$number_of_emi_serviced = $this->number_of_emi_serviced($result['loan_disbursement_id']);
				$emi_amount = $this->Each_EMI_Amount($result['loan_disbursement_id']);
				$next_repay = $this->Next_Repay($result['loan_disbursement_id']);

				$loan_summary[] = array(
					'loan_disbursement_id' => $result['loan_disbursement_id'],
					'bid_registration_id' => $result['bid_registration_id'],
					'borrower_name' => $result['name'],
					'lender_name' => $result['lender_name'],
					'loan_no' => $result['loan_no'],
					'tenor_months' => $result['accepted_tenor'],
					'principal_outstanding' => $principalamount,
					'number_of_emi_serviced' => $number_of_emi_serviced,
					'emi_amount' => $emi_amount,
					'next_repay' => $next_repay,
					'disbursement_date' => date('d-M-y', strtotime($result['disbursement_date'])),
				);
			}
			return $loan_summary;
		} else {
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
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result['number_of_emi_serviced'];
		} else {
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
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $result['emi_amount'];
		} else {
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
		if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return date('d-M-Y', strtotime($result['emi_date']));
		} else {
			return false;
		}
	}

    public function check_p2p_process()
    {
        $this->db->select('step_1, step_2, step_3, step_5, step_6, step_7, step_8');
        $this->db->from('p2p_borrower_steps');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{

        }
    }

    public function totalProposallikes($proposal_id)
	{
		$this->db->where('proposal_id', $proposal_id);
		return $total_likes = $this->db->count_all_results('p2p_proposal_shortlist_details');

	}

	public function totalProposalviews($proposal_id)
	{
		$this->db->where('proposal_id', $proposal_id);
		return $total_likes = $this->db->count_all_results('p2p_proposal_total_views');

	}

	public function getEmipayment()
	{

		$query = $this->db->select('bed.id as emi_id, bed.disburse_loan_id, bed.emi_date, bed.emi_amount, TIMESTAMPDIFF(DAY, bed.emi_date,CURDATE()) AS due_days , bed.status, bed.is_overdue')
			          ->join('p2p_bidding_proposal_details as pd', 'on pd.bid_registration_id = bed.loan_id', 'left')
			          ->join('p2p_disburse_loan_details as dld', 'on dld.id = bed.disburse_loan_id', 'left')
			          ->order_by('emi_date', 'asc')
			          ->limit(1)
			          ->get_where('p2p_borrower_emi_details as bed', array('bed.borrower_id' => $this->session->userdata('borrower_id'), 'status !='=>1, 'emi_date <= ' => date('Y-m-d')));
		//echo "<pre>"; echo $this->db->last_query(); exit;
		if($this->db->affected_rows()>1)
		{

          $results = $query->result_array();
		  $emi_amount_to_pay = 0;
          foreach ($results AS $result){
             $emi_ids[] = $result['emi_id'];
             $emi_amount_to_pay += $result['emi_amount'];
		  }
          $emi_ids = implode(',', $emi_ids);

			return $emi_details = array(
				'emi_id'=>$emi_ids,
				'disburse_loan_id'=>$result['disburse_loan_id'],
				'paid_to_emi_amount'=>$emi_amount_to_pay,
			);
		}
		if($this->db->affected_rows()>0)
		{
           $result = (array)$query->row();
           return $emi_details = array(
										'emi_id'=>$result['emi_id'],
										'disburse_loan_id'=>$result['disburse_loan_id'],
										'paid_to_emi_amount'=>$result['emi_amount'],
								   	  );
		}
		else{
          return false;
		}
	}

	public function getEmipayment__OLD()
	{

		$query = $this->db->select('bed.id as emi_id, bed.disburse_loan_id, bed.emi_date, bed.emi_amount, TIMESTAMPDIFF(DAY, bed.emi_date,CURDATE()) AS due_days , bed.status, bed.is_overdue')
			->join('p2p_bidding_proposal_details as pd', 'on pd.bid_registration_id = bed.loan_id', 'left')
			->join('p2p_disburse_loan_details as dld', 'on dld.id = bed.disburse_loan_id', 'left')
			->order_by('emi_date', 'asc')
			->get_where('p2p_borrower_emi_details as bed', array('bed.borrower_id' => $this->session->userdata('borrower_id'), 'status !='=>1, 'emi_date <= ' => date('Y-m-d')));
		//echo "<pre>"; echo $this->db->last_query(); exit;
		if($this->db->affected_rows()>1)
		{

			$results = $query->result_array();
			$emi_amount_to_pay = 0;
			foreach ($results AS $result){
				$emi_ids[] = $result['emi_id'];
				$emi_amount_to_pay += $result['emi_amount'];
			}
			$emi_ids = implode(',', $emi_ids);

			return $emi_details = array(
				'emi_id'=>$emi_ids,
				'disburse_loan_id'=>$result['disburse_loan_id'],
				'paid_to_emi_amount'=>$emi_amount_to_pay,
			);
		}
		if($this->db->affected_rows()>0)
		{
			$result = (array)$query->row();
			return $emi_details = array(
				'emi_id'=>$result['emi_id'],
				'disburse_loan_id'=>$result['disburse_loan_id'],
				'paid_to_emi_amount'=>$result['emi_amount'],
			);
		}
		else{
			return false;
		}
	}

	public function getForeclosurepayment()
	{

		$query = $this->db->select('id as emi_id, disburse_loan_id, emi_date, emi_amount, TIMESTAMPDIFF(DAY, emi_date,CURDATE()) AS due_days , status, is_overdue')
			          ->order_by('emi_date', 'asc')
			          ->get_where('p2p_borrower_emi_details', array('borrower_id' => $this->session->userdata('borrower_id'), 'status !='=>1));
		if($this->db->affected_rows()>0)
		{
          $results = $query->result_array();
		  $foreclosure_amount = 0;
          foreach ($results AS $result){
             $emi_ids[] = $result['emi_id'];
			  $foreclosure_amount += $result['emi_amount'];
		  }
          $emi_ids = implode(',', $emi_ids);

			return $foreclosure_details = array(
				'emi_id'=>$emi_ids,
				'disburse_loan_id'=>$result['disburse_loan_id'],
				'foreclosure_amount'=>$foreclosure_amount,
			);
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
			->get_where('p2p_disburse_loan_details AS dld', array('dld.id' => $loan_disbursement_id));
		if ($this->db->affected_rows() > 0) {
			$results = $query->result_array();
			foreach ($results AS $result) {
				$loanLedger['loan_no'] = $result['loan_no'];
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "Loan Disbursement",
					'reference' => $result['reference'],
					'debit' => $result['approved_loan_amount'],
					'credit' => "",
					'balance' => $result['approved_loan_amount'],
					'narration' => "",
				);
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "being Antworks Processing fee charged",
					'reference' => $result['reference'],
					'debit' => $result['loan_processing_charges'],
					'credit' => "",
					'balance' => $result['approved_loan_amount'] + $result['loan_processing_charges'],
					'narration' => "",
				);
				$loanLedger[] = array(
					'date' => date('d-M-Y', strtotime($result['date_created'])),
					'particular' => "being Processing fee recovered",
					'reference' => $result['reference'],
					'debit' => "",
					'credit' => $result['loan_processing_charges'],
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
								'debit' => $emi_detail['emi_interest'],
								'credit' => "",
								'balance' => $balance += $emi_detail['emi_interest'],
								'narration' => "",
							);
							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Interest paid",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_interest'],
								'balance' => $balance -= $emi_detail['emi_interest'],
								'narration' => "",
							);
							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['emi_payment_date'])),
								'particular' => "Loan repayment",
								'reference' => "",
								'debit' => "",
								'credit' => $emi_detail['emi_principal'],
								'balance' => $balance -= $emi_detail['emi_principal'],
								'narration' => "",
							);
						} else {

							$loanLedger[] = array(
								'date' => date('d-M-Y', strtotime($emi_detail['due_date'])),
								'particular' => "being interest charged",
								'reference' => "",
								'debit' => $emi_detail['emi_interest'],
								'credit' => "",
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

	public function loanRestructuring()
	{
		$query = $this->db->select('dld.id as loan_id, bpd.loan_no, ll.name, dld.approved_loan_amount as loan_amount, bed.emi_date, plr.status')
				      ->join('p2p_loan_restructuring plr', 'on plr.loan_id = dld.id', 'left')
				      ->join('p2p_lender_list ll', 'on ll.user_id = dld.lender_id', 'left')
				      ->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id', 'left')
				      ->join('p2p_borrower_emi_details bed', 'on bed.disburse_loan_id = dld.id', 'left')
			          ->where_in('bpd.p2p_sub_product_id', array('3', '6'))
			          //->where('bed.emi_date < CURDATE()')
				      ->get_where('p2p_disburse_loan_details dld', array(
				      	'dld.borrower_id'=>$this->session->userdata('borrower_id'),
						 'dld.loan_status' => 0,
					  ));
		//echo "<pre>"; echo $this->db->last_query(); exit;
		if($this->db->affected_rows()>0)
		{
            return $query->result_array();
		}
		else{
            return false;
		}
	}

    public function get_bank_details()
    {
        $query = $this->db->get_where('p2p_borrower_bank_details', array('borrower_id' => $this->session->userdata('borrower_id')));
        if($this->db->affected_rows() > 0)
        {
           return $query->row_array();
        }
        else{
            return false;
        }
    }
}
?>

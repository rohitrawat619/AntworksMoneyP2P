<?php

class Lendermodelbackend extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function state_list() {

        $this->db->select('*');
        $this->db->from('p2p_state_master');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function get_occuption()
    {
        $this->db->select('*');
        $this->db->from('p2p_occupation_details_table');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function get_lender_info()
    {
        $this->db->select('PLL.lender_id, PLL.lender_escrow_account_number, 
                           PLL.name, PLL.mobile, PLL.email, PLL.dob, PLL.pan, 
                           SE.state, PLA.city, PLA.address1, PLA.address2,PLA.pincode,
                           PLDT.max_loan_preference, PLDT.max_interest_rate, PLDT.max_tenor, PLDT.investments,
                           PLAI.bank_name,PLAI.branch_name,PLAI.account_number,PLAI.ifsc_code,PLAI.account_type
                           ');
        $this->db->from('p2p_lender_list AS PLL');
        $this->db->join('p2p_lender_address AS PLA', 'PLL.user_id = PLA.lender_id', 'left');
        $this->db->join('p2p_lender_details_table AS PLDT', 'PLL.user_id = PLDT.lender_id', 'left');
        $this->db->join('p2p_lender_account_info AS PLAI', 'PLL.user_id = PLAI.lender_id', 'left');
        $this->db->join('p2p_state_experien AS SE', 'SE.code = PLA.state', 'left');
        $this->db->where('PLL.user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();

        if($this->db->affected_rows()>0)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }

    public function get_lender_bank_details()
	{
		$query = $this->db->select('bank_name, branch_name, account_number, ifsc_code, account_type')
			     ->get_where('p2p_lender_account_info', array('lender_id'=>$this->session->userdata('user_id')));
		if($this->db->affected_rows()>0)
		{
          return (array)$query->row();
		}
		else{
			return false;
		}

	}

    public function lenderProfilepic($lenderId)
    {
        $query = $this->db->select('docs_name')->order_by('id', 'desc')->limit('1')->get_where('p2p_lender_docs_table', array('docs_type'=>'selfiImage', 'lender_id'=>$lenderId));
        if($this->db->affected_rows()>0)
        {
          return $query->row()->docs_name;
        }
        else{
            return false;
        }
    }

    public function update_lender_profile()
    {
        $lender_profile_info = array(
            'name'=>$this->input->post('name'),
            'dob'=>$this->input->post('dob'),
            'gender'=>$this->input->post('gender'),
        );
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_list', $lender_profile_info);

        $lender_address_info = array(
            'state'=>$this->input->post('state'),
            'city'=>$this->input->post('city'),
            'address1'=>$this->input->post('address1'),
            'address2'=>$this->input->post('address2'),
        );
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_address', $lender_address_info);

        $this->db->select('id');
        $this->db->from('p2p_lender_account_info');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $lender_bank_info = array(
                'bank_name'=>$this->input->post('bank_name'),
                'branch_name'=>$this->input->post('branch_name'),
                'account_number'=>$this->input->post('account_number'),
                'ifsc_code'=>$this->input->post('ifsc_code'),
            );
            $this->db->where('lender_id', $this->session->userdata('user_id'));
            $this->db->update('p2p_lender_account_info', $lender_bank_info);
        }
        else
        {
            $lender_bank_info = array(
                'lender_id'=>$this->session->userdata('user_id'),
                'bank_name'=>$this->input->post('bank_name'),
                'branch_name'=>$this->input->post('branch_name'),
                'account_number'=>$this->input->post('account_number'),
                'ifsc_code'=>$this->input->post('ifsc_code'),
            );
            $this->db->insert('p2p_lender_account_info', $lender_bank_info);
        }




        $lender_loan_info = array(
            'father_name'=>$this->input->post('father_name'),
            'investments'=>$this->input->post('investments'),
            'min_loan_preference'=>$this->input->post('min_loan_preference'),
            'max_loan_preference'=>$this->input->post('max_loan_preference'),
            'min_interest_rate'=>$this->input->post('min_interest_rate'),
            'max_interest_rate'=>$this->input->post('max_interest_rate'),
            'min_tenor'=>$this->input->post('min_tenor'),
            'max_tenor'=>$this->input->post('max_tenor'),
            'description'=>$this->input->post('description'),
        );
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_details_table', $lender_loan_info);

        return true;
    }

    public function check_lender_exist_or_not()
    {
        $this->db->select('user_id');
        $this->db->from('p2p_lender_list');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_lender_payment_registration()
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_registration_payment');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }

    }

    public function pendingbid()
    {
        $this->db->select('PBPD.*, PD.PLRN, PBL.name AS borrower_name');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->join('p2p_proposal_details AS PD', 'PD.proposal_id = PBPD.proposal_id', 'left');
        $this->db->join('p2p_borrowers_list AS PBL', 'PBL.id = PBPD.borrowers_id', 'left');
        $this->db->where('PBPD.lenders_id',$this->session->userdata('user_id'));
        $this->db->where('PBPD.proposal_status', 1);
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

    public function successfullbids()
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
        $this->db->where('PBPD.lenders_id',$this->session->userdata('user_id'));
        $this->db->where('LAS.borrower_acceptance',1);
        $this->db->where('LAS.borrower_signature',1);
        $this->db->where('LAS.lender_signature','0');
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

    public function acceptedbids()
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
        $this->db->where('PBPD.lenders_id',$this->session->userdata('user_id'));
        $this->db->where('LAS.borrower_acceptance',1);
        $this->db->where('LAS.borrower_signature',1);
        $this->db->where('LAS.lender_signature',1);
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

    public function unsuccessfullbids()
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
        $this->db->where('PBPD.lenders_id',$this->session->userdata('user_id'));
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

    public function liveBorrower()
    {
        $this->db->where('status', 1);
        return $this->db->count_all_results('p2p_borrowers_list');
    }

    public function totalLivebids()
    {
		$this->db->where('proposal_status', 0);
		$this->db->where('lenders_id', $this->session->userdata('user_id'));
		return $this->db->count_all_results('p2p_bidding_proposal_details');
    }

	public function loanRestructuring()
	{
		$query = $this->db->select('dld.id as loan_id, bpd.loan_no, bl.name, dld.approved_loan_amount as loan_amount, bed.emi_date, plr.status, plr.extension_time')
			->join('p2p_loan_restructuring plr', 'on plr.loan_id = dld.id', 'right')
			->join('p2p_borrowers_list bl', 'on bl.id = dld.borrower_id', 'left')
			->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id', 'left')
			->join('p2p_borrower_emi_details bed', 'on bed.disburse_loan_id = dld.id', 'left')
			//->where_in('bpd.p2p_sub_product_id', array('3', '6'))
			//->where('bed.emi_date < CURDATE()')
			->get_where('p2p_disburse_loan_details dld', array(
				'dld.lender_id'=>$this->session->userdata('user_id'),
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

	public function notification()
	{
		$query = $this->db->limit(10)->get_where('p2p_lender_notification', array('lender_id' => $this->session->userdata('user_id')));
		if($this->db->affected_rows() > 0)
		{
           return $query->result_array();
		}
		else{

		}
	}

}
?>

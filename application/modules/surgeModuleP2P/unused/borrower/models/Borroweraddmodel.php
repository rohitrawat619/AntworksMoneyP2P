<?php
class Borroweraddmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function add_borrower()
	{
		$borrower_id = $this->create_borrower_id();
		$borrower_escrow_account = $this->createEscrowaccount();
		$borrower_array = array(
			'borrower_id'=>$borrower_id,
//           'borrower_escrow_account'=>$borrower_escrow_account,
			'name'=>strtoupper($this->input->post('name')),
			'dob'=>$this->input->post('dob'),
			'gender'=>$this->input->post('gender'),
			'email'=>$this->input->post('email'),
			'mobile'=>$this->input->post('mobile'),
			'pan'=>strtoupper($this->input->post('pan')),
			'password'=>$this->input->post('password'),
			'verify_code'=>hash('SHA512', $this->input->post('email')),
			'verify_hash'=>hash('SHA512', ($this->input->post('password').'_'.$this->input->post('email'))),
			'highest_qualification'=>$this->input->post('highest_qualification'),
			'occuption_id'=>$this->input->post('occupation'),
			'status' => 1,
			'created_date'=>date("Y-m-d H:i:s"),
		);
		$this->db->insert('p2p_borrowers_list', $borrower_array);
		if($this->db->affected_rows()>0)
		{

			$last_insert_borrower_id = $this->db->insert_id();
			$this->insert_loan_details($last_insert_borrower_id);
			$this->insert_address($last_insert_borrower_id);
			$occuption_details = array(
				'borrower_id'=>$last_insert_borrower_id,
				'company_type'=>$this->input->post('company_type')?$this->input->post('company_type'):'',
				'company_name'=>$this->input->post('company_name')?$this->input->post('company_name'):'',
				'total_experience'=>$this->input->post('total_experience')?$this->input->post('total_experience'):'',
				'turnover_last_year'=>$this->input->post('turnover_last_year')?$this->input->post('turnover_last_year'):'',
				'turnover_last2_year'=>$this->input->post('turnover_last2_year')?$this->input->post('turnover_last2_year'):'',
				'net_monthly_income'=>$this->input->post('net_monthly_income')?$this->input->post('net_monthly_income'):'',
				'current_emis'=>$this->input->post('current_emis')?$this->input->post('current_emis'):'',
			);
			$this->db->insert('p2p_borrower_occuption_details', $occuption_details);
            $borrower_steps_array = array(
            	'borrower_id' => $last_insert_borrower_id,
            	'step_1' => 1,
            	'step_2' => 1,
			);
			$this->db->insert('p2p_borrower_steps', $borrower_steps_array);

			return true;
		}
		else{
			return false;
		}
	}

	public function insert_loan_details($borrower_id)
	{
		$plnr = $this->create_plnr_no();
		$tenor = '';
		if($this->input->post('loan_amount_borrower') > 10000)
		{
			$tenor = $this->input->post('tenor_borrower');
		}
		else{
			$tenor = 1;
		}
		$loan_details = array(
			'borrower_id'=>$borrower_id,
			'p2p_product_id'=>$this->input->post('p2p_product_id'),
			'loan_amount'=>$this->input->post('loan_amount_borrower'),
			'tenor_months'=>$tenor,
			'min_interest_rate'=>$this->input->post('borrower_interest_rate'),
			'PLRN'=>$plnr,
			'loan_description'=>$this->input->post('borrower_loan_desc'),
			'created_date'=>date("Y-m-d H:i:s"),
		);
		$this->db->insert('p2p_proposal_details', $loan_details);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else{
			return false;
		}
	}

	public function insert_address($borrower_id)
	{
		$borrower_residential_address = array(
			'borrower_id'=> $borrower_id,
			'r_address'=> $this->input->post('address1'),
			'r_address1'=> $this->input->post('address2') ? $this->input->post('address2'):'',
			'r_city'=>$this->input->post('city'),
			'r_state'=>$this->input->post('state_code'),
			'r_pincode'=>$this->input->post('pincode'),
			'present_residence'=>$this->input->post('present_residence'),
		);
		$this->db->insert('p2p_borrower_address_details', $borrower_residential_address);
	}

	public function create_borrower_id()
	{
		$this->db->select("id");
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('p2p_borrowers_list');
		$row = (array)$query->row();
		if($this->db->affected_rows()>0)
		{
			$borrwer_last_register_id = $row['id'];
			$bid = 10000000 + $borrwer_last_register_id + 1;
			return $borrower_id  = "BR".$bid;

		}
		else
		{
			return $borrower_id = "BR10000001";
		}
	}

	public function createEscrowaccount()
	{
		$this->db->select("borrower_escrow_account");
		$this->db->order_by('id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('p2p_borrowers_list');
		$row = (array)$query->row();
		if($this->db->affected_rows()>0)
		{
			$bea = $row['borrower_escrow_account'];
			$bea++;
			return $borrower_escrow_account = $bea;
		}
		else
		{
			return $borrower_escrow_account = "VANTB00000000001";
		}
	}

	public function create_plnr_no()
	{
		$this->db->select("proposal_id");
		$this->db->order_by('proposal_id', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('p2p_proposal_details');
		$row = (array)$query->row();
		if($this->db->affected_rows()>0)
		{
			$plrn_initial_value = 10000000;
			$plrn_next_velue = $plrn_initial_value + $row['proposal_id']+1;
			return $plrn = "PL".$plrn_next_velue;

		}
		else
		{
			return $PLRN = "PL10000001";
		}
	}
}

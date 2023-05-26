<?php
class Requestmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_state()
    {
        $this->db->select('state, code');
        $this->db->from('p2p_state_experien');
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

    public function get_occuption()
    {
        $this->db->select('*');
        $this->db->from('p2p_occupation_details_table');
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

    public function get_present_residence_type()
    {
        $this->db->select('*');
        $this->db->from('p2p_present_residence_type');
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

    public function highest_qualification()
    {
        $this->db->select('*');
        $this->db->from('p2p_qualification');
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

    public function get_occupation_name($id) {

        $this->db->select('name');
        $this->db->from('p2p_occupation_details_table');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row()->name;
        }
        else
        {
            return false;
        }
    }

    public function count_total_bids($uid) {

        $this->db->select('sum(loan_amount) as total_bids');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('lenders_id',$uid);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row()->total_bids;
        }
        else
        {
            return false;
        }
    }

    public function city_list_statcode() {

        $this->db->select('*');
        $this->db->from('p2p_city_master');
        $this->db->where('state_code',$this->input->post('state_code'));
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

    public function get_Banklist()
    {
        $this->db->select('*');
        $this->db->from('p2p_whats_banks');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function getLoantype()
    {
       $loan_types = $this->db->get_where('p2p_loan_type', array('status'=>1))->result_array();
       $option_value_cash_loan = (array)$this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'cash_loan', 'status'=>'1'))->row();
       $option_value_consumer_loan = (array)$this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'consumer_loan', 'status'=>'1'))->row();
       $arr_cash = json_decode($option_value_cash_loan['option_value'], true);
       $arr_consumer = json_decode($option_value_consumer_loan['option_value'], true);
       $loan_types[0] = array_merge($loan_types[0], $arr_cash);
       $loan_types[1] = array_merge($loan_types[1], $arr_consumer);
       return ($loan_types);
    }

    public function getRazorpayRegistrationkeys()
    {
        return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_registration_api_keys', 'status'=>1))->row()->option_value;
    }

    public function getRazorpayFundingkeys()
    {
        return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_funding_api_keys', 'status'=>1))->row()->option_value;
    }

    public function getRazorpayRepaymentkeys()
    {
        return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_repayment_api_keys', 'status'=>1))->row()->option_value;
    }

    public function lastLogintime($emailId)
    {
        return $this->db->select('login_date')->order_by('id', 'desc')->limit(1,1)->get_where('p2p_login_activity', array('user_login'=>$emailId))->row()->login_date;
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

    public function bankaccountDetailsfunding()
    {
       return array(
            'minimum_amount_to_add_in_escrow'=>'5000',
            'maximum_amount_to_add_in_escrow'=>'100000',
            'bank_name'=>'IDBI Bank',
            'account_number'=>'0004102000040062',
            'ifsc_code'=>'IBKL0000004',
            'company_name'=>'ANTWORKS P2P FINANCING PVT LTD',
        );
    }

	public function proposal_days()
	{
		return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name' => 'open_proposal_days'))->row()->option_value;
	}

	public function getLoantypeweb()
	{
		return $loan_types = $this->db->order_by('p2p_product_id', 'desc')->get_where('p2p_loan_type', array('status' => 1, 'p2p_product_id !='=>1))->result_array();
	}

	public function getLenderclub()
	{
		return $lender_clubs = $this->db->get_where('p2p_lender_club', array('status' => 1))->result_array();
	}

	public function preferences($lender_id)
	{
		$query = $this->db->order_by('id', 'desc')->get_where('lender_loan_preferences', array('lender_id' => $lender_id));
		if($this->db->affected_rows()>0)
		{
			return $res = (array)$query->row();
		}
		else{
			return false;
		}
	}
}
?>

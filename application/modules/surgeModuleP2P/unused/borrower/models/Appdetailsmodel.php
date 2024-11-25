<?php
class Appdetailsmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
		$this->db2 = $this->load->database('money', TRUE);
    }

    public function borrowerAppdetails($b_borrower_id)
	{
		$this->db->select('abd.id')
			->join('p2p_app_borrower_details as abd', 'on abd.borrower_id = bl.id')
			->get_where('p2p_borrowers_list as bl', array('bl.borrower_id' => $b_borrower_id, 'abd.id !=' => NULL));
		if($this->db->affected_rows()>0)
		{
           return true;
		}
		else{
            return false;
		}
	}

	public function getContactdetails($b_borrower_id)
	{
		$query = $this->db->select('mobile')->get_where('p2p_borrowers_list', array('borrower_id'=> $b_borrower_id));
		if($this->db->affected_rows()>0)
		{
           $mobile = $query->row()->mobile;
           $query = $this->db2->select('user_id')->get_where('user_info', array('mobile' => $mobile));
           if($this->db2->affected_rows()>0)
		   {
             $user_id = $query->row()->user_id;
             $query = $this->db2->get_where('fc_contact', array('user_id'=>$user_id));
             if($this->db2->affected_rows()>0)
		     {
               return $query->result_array();
			 }
             else{
				 $query = $this->db2->get_where('fc_contact_2021_05_10', array('user_id'=>$user_id));
				 if($this->db2->affected_rows()>0)
				 {
				   return $query->result_array();
				 }
				 else{
					 return false;
				 }
			 }
		   }
           else{
             return false;
		   }
		}
		else{
          return false;
		}

	}

	public function countTotaluser()
	{
		return $this->db2->select('COUNT(user_id) as total_users')->get_where('user_info', array('api_token !=' => ''))->row()->total_users;
	}

	public function getusers($pageLimit, $setLimit)
	{

		$query = $this->db2->order_by('user_id', 'desc')->limit($pageLimit, $setLimit)->get_where('user_info', array('api_token !=' => ''));
		if($this->db2->affected_rows()>0)
		{
           return $query->result_array();
		}
		else{
            return false;
		}
	}

	public function getDetails($user_id)
	{
		$query = $this->db2->get_where('fc_contact', array('user_id' => $user_id));
		if($this->db2->affected_rows()>0)
		{
           return $query -> result_array();
		}
		else{
           return false;
		}
	}


}?>

<?php
class Membershipplanmodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('money', true);
	}

	public function checkMembershipplan()
	{
		$query = $this->db2->where('email', $this->session->userdata('email'))->or_where('mobile', $this->session->userdata('mobile'))->order_by('id', 'desc')->limit(1)->get_where('p2p_res_borrower_payment');
		if($this->db2->affected_rows()>0)
		{
          $result = (array)$query->row();
          $this->db->get_where('p2p_borrower_registration_payment', array('razorpay_payment_id' => $result['payment_id']));
          if($this->db->affected_rows()>0)
		  {
			  $this->db->get_where('p2p_borrower_steps', array('borrower_id' => $this->session->userdata('borrower_id')));
			  if($this->db->affected_rows()>0)
			  {
				  $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
				  $this->db->set('step_2', 1);
				  $this->db->update('p2p_borrower_steps');
				  if($this->db->affected_rows()>0)
				  {
					  return true;
				  }
				  else{
					  return false;
				  }
			  }
			  else{
				  $arr_rec = array(
					  'borrower_id' => $this->session->userdata('borrower_id'),
					  'step_1' => 1,
					  'step_2' => 1,
				  );
				  $this->db->insert('p2p_borrower_steps', $arr_rec);
				  if($this->db->affected_rows()>0)
				  {
					  return true;
				  }
				  else{
					  return false;
				  }
			  }
		  }
          else{
			  $payment_details = array(
				  'borrower_id' => $this->session->userdata('borrower_id'),
				  'razorpay_payment_id' => $result['payment_id'],
				  'channel' => 'membership',
				  'created_date' => $result['created_date'],
			  );
			  $this->db->insert('p2p_borrower_registration_payment', $payment_details);
			  if($this->db->affected_rows()>0)
			  {
				  $this->db->get_where('p2p_borrower_steps', array('borrower_id' => $this->session->userdata('borrower_id')));
				  if($this->db->affected_rows()>0)
				  {
					  $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
					  $this->db->set('step_2', 1);
					  $this->db->update('p2p_borrower_steps');
					  if($this->db->affected_rows()>0)
					  {
						  return true;
					  }
					  else{
						  return false;
					  }
				  }
				  else{
					  $arr_rec = array(
						  'borrower_id' => $this->session->userdata('borrower_id'),
						  'step_1' => 1,
						  'step_2' => 1,
					  );
					  $this->db->insert('p2p_borrower_steps', $arr_rec);
					  if($this->db->affected_rows()>0)
					  {
						  return true;
					  }
					  else{
						  return false;
					  }
				  }

			  }
		  }

		}
		else{
           return false;
		}
	}
}
?>

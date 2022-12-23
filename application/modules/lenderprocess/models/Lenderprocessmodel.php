<?php
class Lenderprocessmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getLendersteps()
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_steps');
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

    public function lender_info()
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_list');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();

        }
        else{
            return false;
        }
    }

    public function update_escrow()
    {

          $escrow_ac = $this->create_escrow_id();
          if($escrow_ac){
              $this->db->set('lender_escrow_account_number', $escrow_ac);
              $this->db->where('user_id',$this->session->userdata('user_id'));
              $this->db->update('p2p_lender_list');
              if($this->db->affected_rows()>0)
              {
                  $this->db->set('step_5', 1);
                  $this->db->where('lender_id', $this->session->userdata('user_id'));
                  $this->db->update('p2p_lender_steps');
                  return true;
              }
              else{
                  return false;
              }
          }
          else{
              return false;
          }

    }

    public function create_escrow_id()
    {
        $this->db->select("lender_escrow_account_number");
        $this->db->order_by('user_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_lender_list');
        $row = (array)$query->row();
        if($this->db->affected_rows()>0)
        {
            $escrow = $row['lender_escrow_account_number'];
            if($escrow)
            {
                return false;
            }
            else{
                return $escrow_id = "VCFTNMUM00000001";
            }

        }
        else
        {
            return $escrow_id = "VCFTNMUM00000001";
        }
    }

    public function updateSteps($dataSteps)
    {
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->update('p2p_lender_steps', $dataSteps);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function saveApiResponse($api_response)
    {
        $this->db->insert('p2p_lender_api_response', $api_response);
        if($this->db->affected_rows()>0)
        {
            return true;

        }
        else{
            return false;
        }
    }

    public function getpanApiresponse($api_name)
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_api_response');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->where('api_name', $api_name);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function insertRequest($insert_request)
    {
        $this->db->insert('p2p_lender_requests', $insert_request);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
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

    public function getBankdetails()
    {
        $this->db->select('*');
        $this->db->from('p2p_lender_account_info');
        $this->db->where('lender_id', $this->session->userdata('user_id'));
        $this->db->where('is_verified', 1);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

	public function steps()
	{
		$this->db->select('step_1, step_2, step_3, step_4, step_5');
		$this->db->from('p2p_lender_steps');
		$this->db->where('lender_id', $this->session->userdata('user_id'));
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			$results = (array)$query->row();
			$is_all_steps_complete = true;
			foreach ($results AS $key=>$result){
				if($results[$key] == 0)
				{
					$is_all_steps_complete = false;
					$action_url = $this->db->get_where('p2p_lender_steps_action', array('step'=>$key))->row()->action_url;
					return 'lenderprocess/'.$action_url;
				}
			}
			if($is_all_steps_complete === true)
			{

			   $this->session->set_userdata(array('all_steps_complete'=>1));
			   return true;
			}


		}
		else{
			return false;
		}

	}

}
?>

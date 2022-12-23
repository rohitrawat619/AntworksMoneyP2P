<?php
class Borrowerprocessmodel extends CI_Model{

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

    public function getBorrowersteps()
    {
        $this->db->select('*');
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

    public function borrower_info()
    {
        $this->db->select('BL.*, BAD.r_address, BAD.r_address1, BAD.r_city, BAD.r_state, BAD.r_pincode');
        $this->db->from('p2p_borrowers_list AS BL');
        $this->db->join('p2p_borrower_address_details AS BAD', 'ON BAD.borrower_id = BL.id', 'left');
        $this->db->where('BL.id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();

        }
        else{
            return false;
        }
    }

    public function get_escrow_account()
    {
        $this->db->select('borrower_escrow_account');
        $this->db->from('p2p_borrowers_list');
        $this->db->where('id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
           return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function addEscroe_response($response)
    {
        $this->db->insert('p2p_escrow_response', $response);
        if($this->db->affected_rows()>0)
        {
            return true;

        }
        else{
            return false;
        }
    }

    public function addExperian_response($response)
    {
        $this->db->insert('p2p_borrower_experian_response', $response);
        if($this->db->affected_rows()>0)
        {
            return true;

        }
        else{
            return false;
        }
    }

    public function checkWregister()
    {
        $this->db->select('*');
        $this->db->from('p2p_whatsloan_info');
        $this->db->where('loginName', $this->session->userdata('email'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{

            return false;
        }
    }

    public function wRegistration()
    {
        $this->db->select('id, password');
        $this->db->from('p2p_whatsloan_info');
        $this->db->where('loginName', $this->session->userdata('email'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
           return (array)$query->row();
        }
        else{

          $pass = $this->generateStrongPassword();

          $arr_what = array(
              'loginName'=> $this->session->userdata('email'),
              'password'=> $pass,
          );
          $this->db->insert('p2p_whatsloan_info',$arr_what);
          if($this->db->affected_rows()>0)
          {
              $this->db->select('id, password');
              $this->db->from('p2p_whatsloan_info');
              $this->db->where('loginName', $this->session->userdata('email'));
              $query = $this->db->get();
              return (array)$query->row();
          }
          else{
              $this->wRegistration();
          }
        }
    }

    public function generateStrongPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%^&*()';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function is_registerW($id)
    {
        $this->db->set('is_register', 1);
        $this->db->where('id', $id);
        $this->db->where('loginName', $this->session->userdata('email'));
        $this->db->update('p2p_whatsloan_info');
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }

    }

    public function wLogin()
    {
        $this->db->select('id, password');
        $this->db->from('p2p_whatsloan_info');
        $this->db->where('loginName', $this->session->userdata('email'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{

            return false;
        }
    }

    public function updateBankaccountno($bankresponse)
    {
        $this->db->select('id');
        $this->db->from('p2p_borrower_bank_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return false;
            /*$this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->update('p2p_borrower_bank_details',$bankresponse);
            return true;*/
        }
        else{
            $this->db->insert('p2p_borrower_bank_details', $bankresponse);
            return true;
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
        $this->db->from('p2p_borrower_bank_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
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

    public function saveAnalysisaccount($accId, $response)
    {
       $this->db->set('accId', $accId);
       $this->db->set('analysis_json', $response);
       $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
       $this->db->update('p2p_borrower_bank_details');
       if($this->db->affected_rows()>0)
       {
           return true;
       }
       else{
           return false;
       }
    }

    public function insert_kyc_statement($borrower_file_info)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file_info);
        if($this->db->affected_rows()>0)
        {
            return $this->db->insert_id();


        }
        else{
            return false;
        }
    }

    public function updateStatementresponse($data)
    {
        $this->db->set('whatsloan_response', $data['whatsloan_response']);
        $this->db->where('id', $data['doc_id']);
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->update('p2p_borrowers_docs_table');
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function updateSteps($dataSteps)
    {
      $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
      $this->db->update('p2p_borrower_steps', $dataSteps);
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function borrower_info_details()
    {
      $this->db->select("BL.name AS Borrower_name,
                         BL.email,
                         BL.mobile,
                         BL.dob,
                         TIMESTAMPDIFF(YEAR, BL.dob, CURDATE()) AS age,
                         BL.highest_qualification,
                         BL.gender,
                         BL.occuption_id,
                         BL.marital_status,
                         BL.pan,
                         BAD.r_address, 
                         BAD.r_address1, 
                         BAD.r_city, 
                         BAD.r_city, 
                         BAD.r_pincode,
                         SM.state_name,
                         ODT.name AS occuption_name,
                         PQ.qualification,
                         BANK.bank_name,
                         BANK.account_number,
                         BANK.ifsc_code,
                         BANK.is_verified,                        
                         
       ");
       $this->db->from('p2p_borrowers_list AS BL');
       $this->db->join('p2p_borrower_address_details AS BAD', 'ON BAD.borrower_id = BL.id', 'left');
       $this->db->join('p2p_state_master AS SM', 'ON SM.state_code = BAD.r_state', 'left');
       $this->db->join('p2p_occupation_details_table AS ODT', 'ON ODT.id = BL.occuption_id', 'left');
       $this->db->join('p2p_qualification AS PQ', 'ON PQ.id = BL.highest_qualification', 'left');
       $this->db->join('p2p_borrower_bank_details AS BANK', 'ON BANK.borrower_id = BL.id', 'left');
       $this->db->where('BL.id', $this->session->userdata('borrower_id'));
       $query = $this->db->get();
       if($this->db->affected_rows()>0)
       {
         return (array)$query->row();
       }
       else{
          return false;
       }
    }

    public function kycDoctype()
    {
        $this->db->select('docs_type');
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

    public function get_currentopen_proposal()
    {
        $this->db->select('*, date(date_added) AS date_of_added');
        $this->db->from('p2p_proposal_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('bidding_status', '0');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function takeliveproposal()
    {
        $this->db->select('proposal_id');
        $this->db->from('p2p_proposal_details');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->where('proposal_id', $this->input->post('proposal_id'));
        $this->db->where('bidding_status', '0');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if($this->db->affected_rows()>0)
        {
            $this->db->set('bidding_status', 1);
            $this->db->set('date_added', date('Y-m-d H:i:s'));
            $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
            $this->db->where('proposal_id', $this->input->post('proposal_id'));
            $this->db->update('p2p_proposal_details');
            if($this->db->affected_rows()>0)
            {
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

    public function occuptionDetails($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function saveApiResponse($api_response)
    {
        $this->db->insert('p2p_borrower_api_response', $api_response);
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
        $this->db->from('p2p_borrower_api_response');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
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

    public function getRating()
    {
        $this->db->select('experian_score, antworksp2p_rating');
        $this->db->from('ant_borrower_rating');
        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
//        echo "<pre>";
//         echo $this->db->last_query(); exit;
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
		$this->db->select('*');
		$this->db->from('p2p_borrower_steps');
		$this->db->where('borrower_id', $this->session->userdata('borrower_id'));
		$query = $this->db->get();
		if($this->db->affected_rows()>0)
		{
			$results = (array)$query->row();
			unset($results['modified_date']);
			unset($results['created_date']);
			$is_all_steps_complete = true;
			foreach ($results AS $key=>$result){
			    if($key == 'step_3' && $results[$key] == 3)
				{
					$is_all_steps_complete = false;
					$key = 'step_3_3';
					$action_url = $this->db->get_where('p2p_borrower_steps_action_url', array('step'=>$key))->row()->action_url;
					return 'borrowerprocess/'.$action_url;
				}
			    if($key == 'step_6' && $results[$key] == 1)
				{
					$is_all_steps_complete = false;
					$key = 'step_6_1';
					$action_url = $this->db->get_where('p2p_borrower_steps_action_url', array('step'=>$key))->row()->action_url;
					return 'borrowerprocess/'.$action_url;
				}
                if($results[$key] == 0)
			    {
					$is_all_steps_complete = false;
					$action_url = $this->db->get_where('p2p_borrower_steps_action_url', array('step'=>$key))->row()->action_url;
					return 'borrowerprocess/'.$action_url;
			    }
			}
			if($is_all_steps_complete)
			{
                $step_complete = array('all_steps_complete' => 1);
				$this->session->set_userdata($step_complete);
				return 'borrower/dashboard';
			}


		}
		else{
			return false;
		}

	}
}
?>

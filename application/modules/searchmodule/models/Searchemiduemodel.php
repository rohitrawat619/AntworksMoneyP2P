<?php
class Searchemiduemodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function search()
    {
        $where = "";
        if($this->input->post('start_date'))
         {
           $post_date = explode('+', $this->input->post('start_date'));
           $date = explode('-', $post_date[0]);
           $start_date = $date[0];
           $end_date = $date[1];
           // Date Format
           $start_date = (date("Y-m-d", strtotime($start_date))).' 00:00:00';
           $end_date = (date("Y-m-d", strtotime($end_date))).' 23:59:59';

           $where = "EMI.emi_sql_date > '$start_date' AND EMI.emi_sql_date < '$end_date'";        
        }
      
        
        $this->db->select('BS.id AS borrower_id,
                           BS.borrower_id AS b_borrower_id,
                           BS.name,
                           BS.email,
                           BS.mobile,
                           BN.bid_registration_id,
                           BN.bid_loan_amount,
                           BN.loan_no, 
                           BA.r_city,
						   LN.name AS lname,
                           AC.account_number');
        $this->db->from('p2p_disburse_loan_details AS DLT');
        $this->db->join('p2p_bidding_proposal_details AS BN', 'ON DLT.bid_registration_id = BN.bid_registration_id', 'left');
        $this->db->join('p2p_borrowers_list AS BS', 'ON BN.borrowers_id = BS.id', 'left');
        $this->db->join('p2p_borrower_address_details AS BA', 'ON BA.borrower_id = BN.borrowers_id', 'left');
		$this->db->join('p2p_lender_list AS LN', 'ON LN.user_id = BN.lenders_id', 'left');
        $this->db->join('p2p_borrower_bank_details AS AC', 'ON AC.borrower_id = BN.borrowers_id', 'left'); 
        $this->db->join('p2p_borrower_emi_details AS EMI', 'ON EMI.loan_id = BN.bid_registration_id', 'left');         
        $this->db->where('EMI.status',0); 
        $this->db->where($where);
      
        $query = $this->db->get();  
       if($this->db->affected_rows()>0)
         {
             $emi_detil = array();
             $results =  $query->result_array();
             foreach ($results as $result) 
              {
              $emi_detils = $this->db->select('id,emi_date,emi_amount,status')->order_by('id', 'asc')->limit(1)->get_where('p2p_borrower_emi_details', array('loan_id'=>$result['bid_registration_id'], 'status' => "0"))->row();   
              if($this->db->affected_rows()>0)
              {
                $emi_detil = $emi_detils;
              }
              else{
                $emi_detil = array();
                 }
               $loan_details[] = array(
                'borrower_id' => $result['borrower_id'],
                'b_borrower_id' => $result['b_borrower_id'],
                'bid_registration_id' => $result['bid_registration_id'],
				'lname' => $result['lname'],
                'name' => $result['name'],			
                'email' => $result['email'],
                'mobile' => $result['mobile'],
                'loan_no' => $result['loan_no'],
                'bid_loan_amount' => $result['bid_loan_amount'],
                'r_city' => $result['r_city'],
                'account_number' => $result['account_number'],
                'emi_detil'=>$emi_detil,
                 ); 
             }
              

        return $loan_details;
      }
        else{
              return false;
            }
    }





    public function searchlist()
    {
        $where = "";
        if($this->input->post('start_date'))
         {
           $post_date = explode('+', $this->input->post('start_date'));
           $date = explode('-', $post_date[0]);
           $start_date = $date[0];
           $end_date = $date[1];
           // Date Format
           $start_date = (date("Y-m-d", strtotime($start_date))).' 00:00:00';
           $end_date = (date("Y-m-d", strtotime($end_date))).' 23:59:59';

           $where = "EMI.emi_sql_date > '$start_date' AND EMI.emi_sql_date < '$end_date'";        
        }
      
        
        $this->db->select('BS.id AS borrower_id,
                           BS.borrower_id AS b_borrower_id,
                           BS.name,
                           BS.email,
                           BS.mobile,
                           BN.bid_registration_id,
                           BN.bid_loan_amount,
                           BN.loan_no, 
                           BA.r_city,			   
						   LN.name AS lname,
                           AC.account_number');
        $this->db->from('p2p_disburse_loan_details AS DLT');
        $this->db->join('p2p_bidding_proposal_details AS BN', 'ON DLT.bid_registration_id = BN.bid_registration_id', 'left');
        $this->db->join('p2p_borrowers_list AS BS', 'ON BN.borrowers_id = BS.id', 'left');
		$this->db->join('p2p_lender_list AS LN', 'ON LN.user_id = BN.lenders_id', 'left');
        $this->db->join('p2p_borrower_address_details AS BA', 'ON BA.borrower_id = BN.borrowers_id', 'left');
		
        $this->db->join('p2p_borrower_bank_details AS AC', 'ON AC.borrower_id = BN.borrowers_id', 'left'); 
        $this->db->join('p2p_borrower_emi_details AS EMI', 'ON EMI.loan_id = BN.bid_registration_id', 'left');         
     
        $this->db->where($where);
      
        $query = $this->db->get();  
       if($this->db->affected_rows()>0)
         {
             $emi_detil = array();
             $results =  $query->result_array();
             foreach ($results as $result) 
              {
              $emi_detils = $this->db->select('id,emi_date,emi_amount,status')->order_by('id', 'asc')->limit(1)->get_where('p2p_borrower_emi_details', array('loan_id'=>$result['bid_registration_id'], 'status' => "0"))->row();   
              if($this->db->affected_rows()>0)
              {
                $emi_detil = $emi_detils;
              }
              else{
                $emi_detil = array();
                 }
               $loan_details[] = array(
                'borrower_id' => $result['borrower_id'],
                'b_borrower_id' => $result['b_borrower_id'],
				'lname' => $result['lname'],
                'name' => $result['name'],
				
                'email' => $result['email'],
                'mobile' => $result['mobile'],
                'loan_no' => $result['loan_no'],
                'bid_loan_amount' => $result['bid_loan_amount'],
                'r_city' => $result['r_city'],
                'account_number' => $result['account_number'],
                'emi_detil'=>$emi_detil,
                 ); 
             }
              

        return $loan_details;
      }
        else{
              return false;
            }
    }
}
?>
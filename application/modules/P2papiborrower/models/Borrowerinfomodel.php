<?php
class Borrowerinfomodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_personalDetails($borrowerId)
    {
  
        $this->db->select('BL.name ,BL.email ,BL.mobile, BL.gender,BL.dob, BS.step_1 AS email_verified_or_not');
        $this->db->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->db->where('BL.id', $borrowerId);
        $this->db->from('p2p_borrowers_list AS BL');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else
        {
            return false;
        }
    }

    public function get_residentalDetails($borrowerId)
    {
  
       $sql ="SELECT  UI.r_address, UI.r_address1,UI.r_city,UI.r_pincode,UI.present_residence , UR.state AS r_state 
              FROM p2p_borrower_address_details AS UI
              LEFT JOIN p2p_state_experien UR 
               ON  UR.id= UI.r_state WHERE UI.borrower_id = $borrowerId";

     $query = $this->db->query($sql);
       
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else
        {
            return false;
        }
    }

    public function get_OccupationDetails($borrowerId)
    {
  
         $sql ="SELECT  UR.name AS occuption_type ,UI.company_type, UI.company_name,UI.total_experience,
                          UI.current_emis,UI.salary_process ,UI.net_monthly_income ,UI.turnover_last_year  

               FROM p2p_borrower_occuption_details AS UI
               LEFT JOIN p2p_occupation_details_table UR 
               ON  UR.id= UI.occuption_type WHERE UI.borrower_id = $borrowerId";

     $query = $this->db->query($sql);
       
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else
        {
            return false;
        }
    }

    public function get_accountDetails($borrowerId)
    {
  
        $this->db->select('bank_name ,account_number, ifsc_code, account_type');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_borrower_bank_details');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else
        {
            return false;
        }
    }
}
?>

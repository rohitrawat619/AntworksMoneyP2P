<?php
class Mishmodel extends CI_Model{
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

           $where = "BS.created_date > '$start_date' AND BS.created_date < '$end_date'";        
        }
      //echo $where;exit;
        
        $this->db->select('BS.id,
                           BS.created_date,
                           BS.borrower_id ,
                           BS.name,
                           BS.email,
                           BS.mobile,
                           QUL.qualification,
                           OCU.name AS occupation,
                           BS.gender,
                           BS.dob,
                           BN.bid_registration_id, 
                           DLD.approved_loan_amount, 
                           DLD.loan_processing_charges, 
                           DLD.bid_registration_id,
                           EMI.emi_interest,
                           BN.accepted_tenor,
                           EMI.emi_amount,
                           BN.loan_no,
                           BNK.bank_name,
                           BNK.account_number,
                           BNK.ifsc_code,
                           ADR.r_city,
                          RATI.overall_leveraging_ratio, 
                          RATI.leverage_ratio_maximum_available_credit,
                          RATI.limit_utilization_revolving_credit,
                          RATI.outstanding_to_limit_term_credit,
                          RATI.outstanding_to_limit_term_credit_including_past_facilities,
                          RATI.short_term_leveraging,
                          RATI.secured_facilities_to_total_credit,
                          RATI.short_term_credit_to_total_credit,
                          RATI.fixed_obligation_to_income,
                          RATI.no_of_active_accounts,
                          RATI.variety_of_loans_active,
                          RATI.no_of_credit_enquiry_in_last_3_months,
                          RATI.no_of_loans_availed_to_credit_enquiry_in_last_12_months,
                          RATI.history_of_credit_oldest_credit_account,
                          RATI.limit_breach,
                          RATI.overdue_to_obligation,
                          RATI.overdue_to_monthly_income,
                          RATI.number_of_instances_of_delay_in_past_6_months,
                          RATI.number_of_instances_of_delay_in_past_12_months,
                          RATI.number_of_instances_of_delay_in_past_36_months,
                          RATI.cheque_bouncing,
                          RATI.credit_summation_to_annual_income,
                          RATI.digital_banking,
                          RATI.savings_as_percentage_of_annual_income,
                          RATI.present_residence,
                          RATI.city_of_residence,
                          RATI.highest_qualification,
                          RATI.age,
                          RATI.occupation,
                          RATI.experience,
                          ');
        $this->db->from('p2p_borrowers_list AS BS');
        $this->db->join('p2p_bidding_proposal_details AS BN', 'ON BS.id = BN.borrowers_id', 'left');
        $this->db->join('p2p_disburse_loan_details AS DLD', 'ON BN.bid_registration_id = DLD.bid_registration_id', 'left');
         $this->db->join('p2p_borrower_emi_details AS EMI', 'ON BS.id = EMI.borrower_id', 'left');   
         $this->db->join('p2p_borrower_bank_details AS BNK', 'ON BS.id = BNK.borrower_id', 'left');  
         $this->db->join('p2p_borrower_address_details AS ADR', 'ON BS.id = ADR.borrower_id', 'left');  
         $this->db->join('ant_borrower_rating AS RATI', 'ON BS.id = RATI.borrower_id', 'left'); 
         $this->db->join('p2p_occupation_details_table AS OCU', 'ON BS.occuption_id = OCU.id', 'left'); 
         $this->db->join('p2p_qualification AS QUL', 'ON BS.highest_qualification = QUL.id', 'left'); 
        $this->db->where($where);
      
        $query = $this->db->get();  
       if($this->db->affected_rows()>0)
         {
             return  $query->result_array();
       
    
          }
        else{
              return false;
            }
    }





}
?>
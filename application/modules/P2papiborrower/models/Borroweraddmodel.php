<?php
class Borroweraddmodel extends CI_Model{
   public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Borrowermodel', 'P2papi/Commonapimodel'));
    }
 
   public function add_borrower()
     {
        $borrower_id = $this->Borrowermodel->create_borrower_id();
        //$borrower_escrow_account = $this->Borrowermodel->createEscrowaccount();

        $borrower_array = array(
                              'borrower_id'=>$borrower_id,
//                              'borrower_escrow_account'=>$borrower_escrow_account,
                              'name'=>$this->input->post('name'),
                              'email'=>$this->input->post('email'),
                              'mobile'=>$this->input->post('mobile'),
                              'pan'=>$this->input->post('pan'),
                              'password'=>$this->input->post('password'),
                              'verify_code'=>hash('SHA512', $this->input->post('email')),
                              'verify_hash'=>hash('SHA512', ($this->input->post('password').'_'.$this->input->post('email'))),
                              'created_date'=>date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_borrowers_list', $borrower_array);
            if($this->db->affected_rows()>0)
             {
                 $last_insert_borrower_id = $this->db->insert_id();
                 $this->updateBorrowerappdetails($last_insert_borrower_id);
                 $this->Commonapimodel->Send_verification_email_code($last_insert_borrower_id, $source = 'APP');
                 return true;
             }
            else
              {
                return false;
              }
      
    }

   public function updateBorrowerappdetails($borrowerId)
    {
        $this->db->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
        if($this->db->affected_rows()>0)
        {
            $app_details = array(
                'imei_no'=>$this->input->post('imei_no'),
                'mobile_token'=>$this->input->post('mobile_token'),
                'latitude'=>$this->input->post('latitude'),
                'longitude'=>$this->input->post('longitude'),
                'created_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_app_borrower_details', $app_details);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            $app_details = array(
                'borrower_id'=>$borrowerId,
                'imei_no'=>$this->input->post('imei_no'),
                'mobile_token'=>$this->input->post('mobile_token'),
                'latitude'=>$this->input->post('latitude'),
                'longitude'=>$this->input->post('longitude'),
                'created_date'=>date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_app_borrower_details', $app_details);
            if($this->db->affected_rows()>0)
            {
                return true;
            }
            else{
                return false;
            }
        }

    }

   public function add_loan_details($borrowerId)
      {
            $plnr = $this->Borrowermodel->create_plnr_no();
            
        
        $loan_details = array(
                              'borrower_id'=>$borrowerId,
                              'p2p_product_id'=>$this->input->post('p2p_product_id'),
                              'loan_amount'=>$this->input->post('loan_amount'),
                              'tenor_months'=>$this->input->post('tenor_months'),
                              'prefered_interest_max'=>36,
                              'loan_description'=>$this->input->post('loan_description'),
                              'PLRN'=>$plnr,
                              'created_date'=>date("Y-m-d H:i:s"),
                            );
        $this->db->insert('p2p_proposal_details', $loan_details);
        
        if($this->db->affected_rows()>0)
             {
                return $this->db->insert_id();
             }
        
            else
              {
                return false;
              }
       }

   public function add_consumer_loan_details($borrowerId)
      {
        $plnr = $this->Borrowermodel->create_plnr_no();
        $loan_details = array(
                              'borrower_id'=>$borrowerId,
                              'p2p_product_id'=>$this->input->post('p2p_product_id'),
                              'loan_amount'=>$this->input->post('loan_amount'),
                              'tenor_months'=>$this->input->post('tenor_months'),
                              'prefered_interest_max'=>18,
                              'PLRN'=>$plnr,
                              'created_date'=>date("Y-m-d H:i:s"),
                            );
        $this->db->insert('p2p_proposal_details', $loan_details);
         $proposal_id =  $this->db->insert_id();

        if($this->db->affected_rows()>0)
             {
                 $proposal_id = $this->db->insert_id();
                 $product_info = array(
                     'proposal_id'=>$proposal_id,
                     'product_name'=>$this->input->post('product_name'),
                     'invoice_value'=>$this->input->post('invoice_value'),
                     'mode_of_purchase'=>$this->input->post('mode_of_purchase'),
                 );
                 $this->db->insert('p2p_consumer_loan_details', $product_info);
                 return $proposal_id;
             }

            else
              {
                return false;
              }
       }

   public function update_gender($borrowerId)
        {
      

     $data = array(
                   'gender'=>$this->input->post('gender'),
                   'modified_date'=>date("Y-m-d H:i:s"),
                   );

            $this->db->where('id', $borrowerId);
            $this->db->update('p2p_borrowers_list', $data);

             if($this->db->affected_rows()>0)
                 {
                   return true;
                 }
            else
                {
                   return false;
                }
       }

   public function update_dob($borrowerId)
        {
      

       $data = array(
                     'dob'=>$this->input->post('dob'),
                     'modified_date'=>date("Y-m-d H:i:s"),
                     );

          $this->db->where('id', $borrowerId);
          $this->db->update('p2p_borrowers_list', $data);
          if($this->db->affected_rows()>0)
              {
                return true;
              }
           else
           {
             return false;
           }
       }

   public function update_marital_status($borrowerId)
        {
      

               $data = array(
                             'marital_status'=>$this->input->post('marital_status'),
                             'modified_date'=>date("Y-m-d H:i:s"),
                             );

                  $this->db->where('id', $borrowerId);
                  $this->db->update('p2p_borrowers_list', $data);
                 
                  if($this->db->affected_rows()>0)
                      {
                        return true;
                      }
                  else
                    {
                      return false;
                    }
       }

   public function update_qualification($borrowerId)
      {
      

           $data = array(
                         'highest_qualification'=>$this->input->post('highest_qualification'),
                         'modified_date'=>date("Y-m-d H:i:s"),
                         );

              $this->db->where('id', $borrowerId);
              $this->db->update('p2p_borrowers_list', $data);
             
              if($this->db->affected_rows()>0)
                  {
                    return true;
                  }
                else
                {
                  return false;
                }
       }

   public function update_occuption($borrowerId)
           {
      

       $data = array(
                     'occuption_id'=>$this->input->post('occuption_id'),
                     'modified_date'=>date("Y-m-d H:i:s"),
                     );

          $this->db->where('id', $borrowerId);
          $this->db->update('p2p_borrowers_list', $data);
          
          if($this->db->affected_rows()>0)
              {
                return true;
              }
            else
             {
                return false;
             }
       }

   //This method is using for to save occupation details exclude Salaried
   public function addOccupation($borrowerId)
   {
      $_POST['occuption_type'] = $this->input->post('occuption_id');
      unset($_POST['occuption_id']);
      $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id'=>$borrowerId));
      if($this->db->affected_rows()>0)
      {

        $this->db->where('borrower_id', $borrowerId);
        $this->db->update('p2p_borrower_occuption_details', $_POST);
          if($this->db->affected_rows()>0)
          {
              return true;
          }
          else{
              return false;
          }
      }
      else{
          $_POST['borrower_id'] = $borrowerId;
          $this->db->insert('p2p_borrower_occuption_details', $_POST);
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else{
            return false;
          }
      }
   }

   public function add_company_details($borrowerId)
        {
          $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id'=>$borrowerId));
          if($this->db->affected_rows()>0)
          {
              $company_details = array(
                  'company_type'=>$this->input->post('company_type'),
                  'company_name'=>$this->input->post('company_name'),
                  'created_date'=>date("Y-m-d H:i:s"),
              );
              $this->db->where('borrower_id', $borrowerId);
              $this->db->update('p2p_borrower_occuption_details', $company_details);

              if($this->db->affected_rows()>0)
              {
                  return true;
              }
              else
              {
                  return false;
              }
          }
          else{
              $company_details = array(
                  'borrower_id'=>$borrowerId,
                  'company_type'=>$this->input->post('company_type'),
                  'company_name'=>$this->input->post('company_name'),
                  'created_date'=>date("Y-m-d H:i:s"),
              );
              $this->db->insert('p2p_borrower_occuption_details', $company_details);

              if($this->db->affected_rows()>0)
              {
                  return true;
              }
              else
              {
                  return false;
              }
          }

       }

   public function add_income_details($borrowerId)
        {
         $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id'=>$borrowerId));
          if($this->db->affected_rows()>0) {

              $company_details = array(
                  'salary_process' => $this->input->post('salary_process'),
                  'net_monthly_income' => $this->input->post('net_monthly_income'),
              );
              $this->db->where('borrower_id',$borrowerId);
              $this->db->update('p2p_borrower_occuption_details', $company_details);

              if ($this->db->affected_rows() > 0) {
                  return true;
              } else {
                  return false;
              }
          }
          else{
              $company_details = array(
                  'borrower_id' => $borrowerId,
                  'salary_process' => $this->input->post('salary_process'),
                  'net_monthly_income' => $this->input->post('net_monthly_income'),
                  'created_date' => date("Y-m-d H:i:s"),
              );
              $this->db->insert('p2p_borrower_occuption_details', $company_details);

              if ($this->db->affected_rows() > 0) {
                  return true;
              } else {
                  return false;
              }
          }
       }

   public function add_address_details($borrowerId)
        {
            $this->db->select('borrower_id')->get_where('p2p_borrower_address_details', array('borrower_id'=>$borrowerId));
            if($this->db->affected_rows()>0)
            {
              return 'Already exist you can request to change address';
            }
            else{
                $address_details = array(
                    'borrower_id'=>$borrowerId,
                    'r_state'=>$this->input->post('r_state'),
                    'r_city'=>$this->input->post('r_city'),
                    'residence_type'=>$this->input->post('residence_type'),
                    'r_address'=>$this->input->post('r_address'),
                    'r_pincode'=>$this->input->post('r_pincode'),
                    'date_added'=>date("Y-m-d H:i:s"),
                );
                $this->db->insert('p2p_borrower_address_details', $address_details);

                if($this->db->affected_rows()>0)
                {
                    return 'Address add successfully';
                }
                else
                {
                    return false;
                }
            }

        

       }

   public function update_pan($borrowerId)
   {
            
      $data = array(
                 
                 'pan'=>$this->input->post('pan'),
                 'modified_date'=>date("Y-m-d H:i:s"),
                 );

      $this->db->where('id', $borrowerId);
      $this->db->update('p2p_borrowers_list', $data);
      
      if($this->db->affected_rows()>0)
           {
             return true;
           }
     
        else{
             return false;
            }
     }

   public function add_kyc($file_info)
        {
            
        $this->db->insert('p2p_borrowers_docs_table', $file_info);
           
           if($this->db->affected_rows()>0)
               {
                  return $this->db->insert_id();
               }
                 else
                 {
                  return false;
                 }
      }
   
   public function add_bankdetail($bank_data)
        {
            
           $this->db->select('id')->get_where('p2p_borrower_bank_details', array('borrower_id'=>$bank_data['borrower_id']));
           if($this->db->affected_rows()>0)
           {
             return 'Already exist you can not change account without request!!';
           }
           else{
               $this->db->insert('p2p_borrower_bank_details', $bank_data);

               if($this->db->affected_rows()>0)
               {
                   return $this->db->insert_id();
               }
               else
               {
                   return false;
               }
           }

         }

   public function add_coApplicant($borrowerId)
        {
        $loan_details = array(
                              'borrower_id'=>$borrowerId,
                              'full_name'=>$this->input->post('full_name'),
                              'dob'=>$this->input->post('dob'),
                              'mobile'=>$this->input->post('mobile'),
                              'relation'=>$this->input->post('relation'),
                              'pan'=>$this->input->post('pan'),
                            );
        $this->db->insert('p2p_borrowers_co_applicant', $loan_details);
        
        if($this->db->affected_rows()>0)
             {
                 return true;
             }
        
            else
              {
                  return false;
              }
       }
        
   public function insert_statement($borrower_file_info)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file_info);
        if($this->db->affected_rows()>0)
        {
            return $this->db->insert_id();


        }
        else
        {
            return false;
        }
    }

   public function get_myloan($borrowerId)
    {
        $this->db->select('emi_amount ,emi_date ,emi_principal,emi_balance');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_borrower_emi_details');
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
     
   public function get_myloanDetails($borrowerId)
    {
        $this->db->select('loan_no ,bid_loan_amount ,tenure');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_bidding_proposal_details');
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

   public function get_loanStatement($borrowerId)
    {
        $sql ="SELECT UI.name, UD.borrower_signature_date, UR.loan_amount,UR.tenor_months,UR.max_interest_rate 
               FROM p2p_borrowers_list AS UI
               LEFT JOIN p2p_proposal_details UR 
               ON UR.borrower_id = UI.id 
               LEFT JOIN p2p_loan_aggrement_signature UD 
               ON  UD.bid_registration_id= UI.id WHERE UI.id = $borrowerId";

     $query = $this->db->query($sql);
       
        if($this->db->affected_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
 
   public function get_loanStatementDetails($borrowerId)
    {
       $sql ="SELECT UI.loan_amount, UR.emi_date, UR.emi_amount,UR.emi_interest,UR.emi_principal,UR.emi_balance  
               FROM p2p_proposal_details AS UI
               LEFT JOIN p2p_borrower_emi_details UR 
               ON  UR.borrower_id= UI.borrower_id WHERE UI.borrower_id = $borrowerId";

     $query = $this->db->query($sql);
       
        if($this->db->affected_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

   /*public function verifyOtpMoblie()
    {
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_otp_password_table');
        $this->db->where('mobile', $this->input->post('mobile')); 
        $this->db->where('status', '0');       
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
      
        if ($this->db->affected_rows() > 0)
        {
            $result = $query->row();
            if($this->input->post('otp') == $result->otp)
            {
                if ($result->MINUTE <= 10) 
                {
                    $data['response'] = "verify";
                    $this->db->where('otp', $this->input->post('otp'));
                    $this->db->where('mobile', $this->input->post('mobile'));
                    $this->db->set('status', 1);
                    $this->db->update('p2p_otp_password_table');
                    return true;
                } 
                else {
                      return 2;
                     }
            }
               else {
                      return 3;
                    }
        }
              else {
                    return false;
                   }
    }*/

//   public function changeMobile($borrowerId)
//    {
//        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
//        $this->db->from('p2p_otp_password_table');
//        $this->db->where('status', '1');
//        $this->db->order_by('id', 'desc');
//        $this->db->limit(1);
//        $query = $this->db->get();
//
//        if ($this->db->affected_rows() > 0)
//         {
//            $result = $query->row();
//           if($this->input->post('otp') == $result->otp)
//             {
//                if ($result->MINUTE <= 10)
//                 {
//                    $data = array(
//                         'mobile'=>$this->input->post('mobile'),
//                         'created_date'=>date("Y-m-d H:i:s"),
//                         );
//                      $this->db->where('id', $borrowerId);
//                      $this->db->where('dob', $this->input->post('dob'));
//                      $this->db->update('p2p_borrowers_list', $data);
//
//
//                    if($this->db->affected_rows()>0)
//                         {
//                               return true;
//                         }
//                     else
//                        {
//                          return false;
//                        }
//                 }
//
//              }
//
//          }
//
//    }
    
   public function get_personalDetails($borrowerId)
    {
  
        $this->db->select('name ,email ,mobile,gender,dob');
        $this->db->where('id', $borrowerId);
        $this->db->from('p2p_borrowers_list');
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
            return $query->result();
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
            return $query->result();
        }
        else
        {
            return false;
        }
    }

   public function get_accountDetails($borrowerId)
    {
  
        $this->db->select('bank_name ,branch_name ,account_number,ifsc_code,account_type');
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

   public function upload_document($borrower_file)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file);
        if($this->db->affected_rows()>0)
        {
            return $this->db->insert_id();


        }
        else
        {
            return false;
        }
    }
}
?>

<?php
class Lenderactivitymodel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('bidding/Biddingmodel', 'Smsmodule'));
    }

    public function accept_bid($lenderId)
    {
        $query = $this->db->get_where('p2p_proposal_details', array('proposal_id' => $this->input->post('proposal_id')));
        if($this->db->affected_rows()>0)
        {

            $proposal_info = $query->row();
            $this->db->select('bid_registration_id');
            $this->db->from('p2p_bidding_proposal_details');
            $this->db->where('proposal_id',$this->input->post('proposal_id'));
            $this->db->where('borrowers_id',$proposal_info->borrower_id);
            $this->db->where('lenders_id',$lenderId);
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
            	$bid_registration_id = $query->row()->bid_registration_id;
                return array(
                    'bid_registration_id'=>$bid_registration_id,
                    'msg'=>'You already BID this proposal!!'
                );
            }
            else{
                $loan_no = $this->Biddingmodel->create_loan_no();
                $amountoffered = $this->input->post('loan_amount');
                $loan_amount_percentage = ($amountoffered/$proposal_info->loan_amount)*100;
                $proposal_submit_array = array(
                    'loan_no'=>$loan_no,
                    'proposal_id'=>$this->input->post('proposal_id'),
                    'borrowers_id'=>$proposal_info->borrower_id,
                    'lenders_id'=>$lenderId,
                    'bid_loan_amount'=>$this->input->post('loan_amount'),
                    'loan_amount'=>$loan_amount_percentage,
                    'accepted_tenor'=>$this->input->post('tenor'),
                    'interest_rate'=>'36',//$this->input->post('interest_rate'),
                    'proposal_added_date'=>date("Y-m-d H:i:s"),
                );

                $query = $this->db->insert('p2p_bidding_proposal_details',$proposal_submit_array);

                if($this->db->affected_rows()>0)
                {
                    $bid_registration_id = $this->db->insert_id();
                    $query = $this->db->select('id, lender_signature')->get_where('p2p_loan_aggrement_signature', array('bid_registration_id', $bid_registration_id));
                    if($this->db->affected_rows()>0)
                    {
                      $result_signature = (array)$query->row();
                      if($result_signature['lender_signature'] == 0)
                      {
                          $this->db->where('bid_registration_id', $bid_registration_id);
                          $this->db->set('lender_signature', 1);
                          $this->db->set('lender_signature_date', date('Y-m-d H:i:s'));
                          $this->db->update('p2p_loan_aggrement_signature');
                      }

                    }
                    else{
                       $arr_signature = array(
                           'bid_registration_id'=>$bid_registration_id,
                           'lender_signature'=>1,
                           'lender_signature_date'=>date('Y-m-d H:i:s'),
                       );
                       $this->db->insert('p2p_loan_aggrement_signature', $arr_signature);
                    }
                    ////Change Status of proposal
                    if($this->input->post('loan_amount') == $proposal_info->loan_amount)
                    {
                        $this->db->set('bidding_status', 2);
                        $this->db->where('proposal_id', $this->input->post('proposal_id'));
                        $this->db->update('p2p_proposal_details');
                    }
                    else{
                        //For Checking total bid amount loan
                        $total_bid_amount = $this->Biddingmodel->Total_bid_amount($this->input->post('proposal_id'));
                        if($total_bid_amount['Totalbidamount'] == $proposal_info->loan_amount)
                        {
                            $this->db->set('bidding_status', 2);
                            $this->db->where('proposal_id', $this->input->post('proposal_id'));
                            $this->db->update('p2p_proposal_details');

                        }
                        else{
                            $this->db->set('bidding_status', 4);
                            $this->db->where('proposal_id', $this->input->post('proposal_id'));
                            $this->db->update('p2p_proposal_details ');
                        }
                    }
                    ////////////
                    #Update Lock Amount of Lender
                      $lock_amount_array = array(
                          'lender_id'=>$lenderId,
                          'bid_registration_id'=>$bid_registration_id,
                          'lock_amount'=>$this->input->post('loan_amount'),
                      );
                      $this->db->insert('p2p_lender_lock_amount', $lock_amount_array);
                    #
                    #Insert Processing Fee
                    $processing_fee_l = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'loan_processing_fee_lender', 'status'=>'1'))->row();
                    if($processing_fee_l){
                        $processing_fee_arr = array(
                            'bid_registration_id'=>$bid_registration_id,
                            'lender_id'=>$lenderId,
                            'processing_fee'=>$processing_fee_l->option_value,
                            'status'=>'0',
                        );
                        $this->db->insert('p2p_lender_processing_fee', $processing_fee_arr);
                    }

//                    $borrower_info = $this->Biddingmodel->borrowers_info($proposal_info->borrower_id);
//                    if($borrower_info->gender == '1')
//                    {
//                        $title = "Mr.";
//                    }
//                    else
//                    {
//                        $title = "Ms.";
//                    }
//                    $this->Smsmodule->Approved_Bid_borrower($title, $borrower_info->name, $amountoffered, $borrower_info->mobile);
//
//                    //Lender Notification
//                    $lender_info = $this->lenderInfo();
//                    if($lender_info->gender == 1)
//                    {
//                        $title = "Mr.";
//                    }
//                    else
//                    {
//                        $title = "Ms.";
//                    }
//                    $data['bid_list'] = $this->getTotalloanamountLenderinmarket();
//                    $data['total_loan_amount_lender'] = array_sum(array_column($data['bid_list'],'TOTALAMOUNT'));
//                    $balance_amount = 1000000 - $data['total_loan_amount_lender'];
//                    $this->Smsmodule->Lender_Approved_Bid($title, $lender_info['name'], $amountoffered, $lender_info['mobile'], $this->input->post('interest_rate'), $balance_amount);
                    return array(
                    'bid_registration_id'=>$bid_registration_id,
                    'msg'=>'Bid accept successfully'
                    );
                }
                else
                {
                    return array(
                    'bid_registration_id'=>'',
                    'msg'=>'something went wrong please try again'
                    );
                }
            }
        }
        else{
            return array(
                'bid_registration_id'=>'',
                'msg'=>'Proposal not found'
            );
        }
    }

    public function lenderScreenlist()
    {
       $scrs = $this->db->get('p2p_lender_app_screen')->result_array();
       if($scrs)
       {
           foreach ($scrs AS $scr){
              $res[] = array(
                  'id'=>$scr['id'],
                  'icon_name'=>$scr['icon_name'],
                  'icon_url'=>base_url().'assets/api-img/'.$scr['icon_url'],
              );
           }
           return $res;
       }
       else{
          return false;
       }

    }

    public function currentLoandetails($lenderId)
    {
        $sql = "SELECT
					BL.borrower_id AS BORROWER_REGISTRATIONID,
					BL.name AS BORROWERNAME,
					BL.email AS BORROWEREMAIL,
					BL.mobile AS BORROWERMOBILE,
					BL.dob AS BORROWERDOB,
					BL.pan AS BORROWERR_pan,
					BAD.r_address AS BORROWERR_Address,
					BAD.r_address1 AS BORROWERR_Address1,
					BAD.r_city AS BORROWERR_City,
					SE.state AS BORROWERR_State,
					BAD.r_pincode AS BORROWERR_Pincode,
                    
					LL.name AS LENDER_fNAME,
					LL.dob AS LENDER_dob,
					LL.pan AS LENDER_PAN,
					LL.lender_id AS LENDER_ID,
					LL.email AS LENDER_email,
					LL.mobile AS LENDER_mobile,
					
					LA.state AS LENDER_state_code,
					LA.city AS LENDER_city,
					LA.address1 AS LENDER_address,
					LA.address2 AS LENDER_address1,					

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,					
					PD.tenor_months AS TENORMONTHS,
					BPD.bid_loan_amount AS APPROVERD_LOAN_AMOUNT,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id
					FROM p2p_bidding_proposal_details BPD
					
					LEFT JOIN p2p_proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					
					LEFT JOIN p2p_borrowers_list AS BL
					ON BL.id = BPD.borrowers_id
					
					LEFT JOIN p2p_borrower_address_details AS BAD
					ON BAD.borrower_id = BPD.borrowers_id
					
					LEFT JOIN p2p_state_experien  AS SE
					ON SE.code = BAD.r_state
					
					LEFT JOIN p2p_borrowers_details_table AS BDT
					ON BAD.borrower_id = BPD.borrowers_id					
					
					LEFT JOIN p2p_lender_list AS LL
					ON LL.user_id = BPD.lenders_id
					
					LEFT JOIN p2p_lender_address AS LA
					ON LA.lender_id = BPD.lenders_id
					
					WHERE BPD.lenders_id=".$lenderId."
					ORDER BY BPD.bid_registration_id DESC
			";
        $query = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function lenderInfo($lenderId)
    {
        $query = $this->db->select('mobile, name')->get_where('p2p_lender_list', array('user_id'=>$lenderId));
        return (array)$query->row();
    }

    public function verify_signature($lenderId, $bid_registration_id, $otp)
    {
        $lenderInfo = $this->lenderInfo($lenderId);
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_lender_otp_signature');
        $this->db->where('bid_registration_id', $bid_registration_id);
        $this->db->where('mobile', $lenderInfo['mobile']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0){
            $result = $query->row();
            if ($otp == $result->otp) {
                if ($result->MINUTE <= 10) {
                        $this->db->select('*');
                        $this->db->from('p2p_loan_aggrement_signature');
                        $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                        $this->db->where('lender_signature', '0');
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0)
                        {
                            $result = $query->row();
                            $this->db->set('lender_signature', 1);
                            $this->db->set('lender_signature_date', date('Y-m-d H:i:s'));
                            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                            $this->db->update('p2p_loan_aggrement_signature');

                            //update OTP Status
                            $this->db->where('otp', $otp);
                            $this->db->where('mobile', $lenderInfo['mobile']);
                            $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
                            $this->db->set('is_verified', '1');
                            $this->db->update('p2p_lender_otp_signature');

                            return 'Thanks for signature this Loan Agreement';
                        }
                        else{
                            return 'You already signature this loan agreement';
                        }

                } else {
                    return 'Sorry Your OTP is expired please try again';
                }
            } else {
                return 'your OTP is not verified please enter correct OTP';
            }
        }
        else{
            return false;
        }
    }

    public function lender_ledgerinfo($lenderId)
    {
		if(!empty($_POST['start_date']) && !empty($_POST['end_date']))
		{
			$this->db->select('*');
			$this->db->from('p2p_lender_statement_entry');
			$this->db->where('created_date >=', $this->input->post('start_date'));
			$this->db->where('created_date <=', $this->input->post('end_date'));
		}
    	else{
			$this->db->select('*');
			$this->db->from('p2p_lender_statement_entry');
			$this->db->where('lender_id', $lenderId);
		}

        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function lenderBankdetails($lenderId)
    {
        $query = $this->db->select('PLAI.bank_name,PLAI.branch_name,PLAI.account_number,PLAI.ifsc_code,PLAI.account_type')->get_where('p2p_lender_account_info AS PLAI', array('PLAI.lender_id'=>$lenderId));
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function addmoneytoEscrowoffline($lenderId)
    {
      $this->db->select('id')->get_where('lender_offline_payment_details', array('transactionId'=>$this->input->post('transactionId')));
      if($this->db->affected_rows()>0)
      {
         return 'Sorry Transaction ID Already Exist';
      }
      else{
          $offline_paymant = array(
              'lender_id'=>$lenderId,
              'transactionId'=>$this->input->post('transactionId'),
              'transaction_type'=>$this->input->post('transaction_type'),
              'amount'=>$this->input->post('amount'),
          );
          $this->db->insert('lender_offline_payment_details', $offline_paymant);
          if($this->db->affected_rows()>0)
          {
              return 'Added successfully please wait for approvement';
          }
          else{
              return 'Something went wrong please try again';
          }
      }
    }

    public function getaccountBalance($lenderId)
    {
        $query = $this->db->select('account_balance')->get_where('p2p_lender_main_balance', array('lender_id'=>$lenderId));
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function getLockamount($lenderId)
    {
        $query = $this->db->select('lock_amount')->get_where('p2p_lender_lock_amount', array('lender_id'=>$lenderId));
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

    public function loanConformation()
    {
      return "Loan Confirmed successfully";
    }

    public function getpeocessingFee($lenderId)
    {
      $query = $this->db->select('processing_fee')
          ->get_where('p2p_lender_processing_fee', array('p2p_lender_processing_fee', 'bid_registration_id'=>$this->input->post('bid_registration_id'), 'lender_id'=>$lenderId));
      if($this->db->affected_rows()>0)
      {
          $current_processing_fee = $query->row()->processing_fee;
          $query = $this->db->select('SUM(processing_fee) AS total_processing_fee')
              ->get_where('p2p_lender_processing_fee', array('lender_id'=>$lenderId, 'status'=>'0'));
          $unpaid_fee = $query->row()->total_processing_fee;
          return array(
                     'msg'=>'Found',
                     'current_processing_fee'=> $current_processing_fee,
                     'unpaid_total_fee'=>$unpaid_fee,
                 );
      }
      else{
          return array(
              'msg'=>'No record found',
              'current_processing_fee'=> '',
              'unpaid_total_fee'=>'',
          );
      }
    }

    public function getpeocessingFeeall($lenderId)
    {
        $query = $this->db->select("LPF.created_date, LPF.processing_fee, BL.borrower_id AS b_borrower_id, BL.name, BPD.bid_loan_amount, 
                                    IF(LPF.status = 1, 'Paid', 'Unpaid') AS status")
            ->join('p2p_bidding_proposal_details AS BPD', 'ON BPD.bid_registration_id = LPF.bid_registration_id', 'left')
            ->join('p2p_borrowers_list AS BL', 'ON BL.id = BPD.borrowers_id', 'left')
            ->from('p2p_lender_processing_fee AS LPF')
            ->where('lender_id', $lenderId)
            ->get();
        if($this->db->affected_rows()>0)
        {
           return $results = $query->result_array();
            foreach ($results AS $result){
                $professing_fee_list[] = array(
                    'created_date'=>$result['created_date'],
                    'processing_fee'=>$result['processing_fee'],
                    'b_borrower_id'=>$result['b_borrower_id'],
                    'name'=>$result['name'],
                    'bid_loan_amount'=>$result['bid_loan_amount'],
                    'status'=>$result['status'],
                );
            }
           // $professing_fee_list['unpaid_total_processing_fee'] = $unpaid_fee;

            return $professing_fee_list;

        }
        else{
           return $professing_fee_list['msg'] = "Not Found";;
        }
    }

    public function unpaidProcessingfee($lenderId)
    {
        $query = $this->db->select('SUM(processing_fee) AS total_processing_fee')
            ->get_where('p2p_lender_processing_fee', array('lender_id'=>$lenderId, 'status'=>'0'));
        return $unpaid_fee = $query->row()->total_processing_fee;
    }
}
?>

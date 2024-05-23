<?php
class disbursementModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		//$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
      //$this->cldb = $this->load->database('credit-line', TRUE);
	  $this->cldb = $this->load->database('', TRUE); // antworks_p2pdevelopment
	  $this->partner_id = $this->session->userdata('partner_id');
    }


    
    public function getCountDisburseListStatus($disburseRequest, $status)
{
    $this->cldb->select('COUNT(*) as count');
    $this->cldb->from('p2p_loan_list as a');
    $this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id = b.id', 'LEFT');
		if($this->partner_id!=0){$this->cldb->where('b.vendor_id',$this->partner_id);}
    
    if (!empty($status)) {
        $this->cldb->where_in("a.status", $status);
    } else {
        
        $this->cldb->where("a.status IS NULL");
    }

    return $this->cldb->count_all_results();
}

 public function getInvestmentAmount() {
    $total_amount = 0;

    if ($this->partner_id != 0) {
        $this->cldb->select("id");
        $this->cldb->where("Vendor_ID", $this->partner_id);
        $query = $this->cldb->get('invest_scheme_details');
        $scheme_ids = $query->row_array();

        if (!empty($scheme_ids)) {
            //$scheme_ids = array_column($scheme_ids, 'id');
			//print_r($scheme_ids); die();
            $this->cldb->select_sum('amount', 'total_amount');
            $this->cldb->where('redemption_status', 0);
            $this->cldb->where_in("scheme_id", $scheme_ids);
            $query = $this->cldb->get('p2p_lender_investment');
            $result = $query->row();
            
            if (!empty($result) && isset($result->total_amount)) {
                $total_amount = $result->total_amount;
            }
        }
    } else {
        $this->cldb->select_sum('amount', 'total_amount');
        $this->cldb->where('redemption_status', 0);
        $query = $this->cldb->get('p2p_lender_investment');
        $result = $query->row();
        
        if (!empty($result) && isset($result->total_amount)) {
            $total_amount = $result->total_amount;
        }
    }

    return $total_amount;
}



 public function getDisbursedAmount() {
    $this->cldb->select_sum('a.disburse_amount', 'total_amount');
    $this->cldb->where('a.status', 4);
    
    if ($this->partner_id != 0) {
		$this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id = b.id', 'RIGHT');
        $this->cldb->where('b.Vendor_ID', $this->partner_id);
    }
    
    $query = $this->cldb->get('p2p_loan_list as a');
    $result = $query->row();

    if (!empty($result) && isset($result->total_amount)) {
        return $result->total_amount;
    } else {
        return 0; 
    }
}





    public function getDisburseRequestList($limit, $start, $disburseRequest,$status)
{
    $this->cldb->select('*, a.status, a.id');
    $this->cldb->from('p2p_loan_list as a');
    $this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id = b.id', 'LEFT');
    $this->cldb->where_in("a.disbursement_request", $disburseRequest);
	if($this->partner_id!=0){$this->cldb->where('b.vendor_id',$this->partner_id);}
    // Check if the values array is not empty
    if (!empty($status)) {
        $this->cldb->where_in("a.status", $status);
    } else {
        
        $this->cldb->where("a.status IS NULL");
    }

    $query = $this->cldb->limit($limit, $start);

    return $res = $query->get()->result_array();
}
    

    public function update_disburse_status($loanStatus, $ids,$amount,$roi) {
        $disburseData = array(
            "status" => $loanStatus,
            
        );
        if($loanStatus==3){// 3:status is for  generated bank files 
        $idsArray = explode(",", urldecode($ids));

					// Remove single quotes from each element in the array
					$idsArray = array_map('trim', $idsArray);

					// You may want to remove empty values if any
					$ids = array_filter($idsArray);
                }
        else if($loanStatus==1){
            $disburseData['approved_loan_amount']=$amount;
            $disburseData['approved_interest']=$roi;
            $disburseData['disburse_amount']=$amount;
        }
        else if($loanStatus==4){
			
			$data=$this->getPartnerIdViaLoanId($ids);
			$loan_amount=$data['approved_loan_amount'];
			
			// get data via using FIFO
			$this->cldb->select('*');
			$this->cldb->from('lendsocial_lender_loan_priority_allocation_queue');
			$this->cldb->where("partner_id", $data['partner_id']);
			$this->cldb->where("remaining_amount >", 0);
			$this->cldb->where("status",1 );
			$this->cldb->order_by('id', 'ASC'); // Order by id in ascending order
			$query = $this->cldb->get()->result_array();
			
			
			$loan_given=0;
			foreach($query as $queue){
				$available_balance+=$queue['remaining_amount'];
			}
			if($available_balance>=$loan_amount){
			
			foreach($query as $queue){
				
				$lender_remaining_amount=$queue['remaining_amount'];
				
				
				if($loan_given < $loan_amount){}
					if ($lender_remaining_amount >= $loan_amount) {
						
						 $lenderLastBalance=$this->lenderLastBalance($queue['partner_id'],$queue['lender_id']);
						 $lenderBalance=$lenderLastBalance- $loan_amount;
						 
							$lenderData = array(
								'partner_id' => $queue['partner_id'],
								'lender_id' => $queue['lender_id'],
								'transaction_type' => 'disbursedAmount',
								'loan_no' => $data['loan_no'],
								'title' => 'disbursed to the borrower',
								'refrence' => $queue['invest_id'],
								'reference_type' => 'investment_no',
								'debit' => $loan_amount,
								'credit' => "",
								'amount' => $loan_amount,
								'balance' => $lenderBalance,
								'created_date' => date('Y-m-d H:i:s'), 
								'created_id' => "",
								'source' => 'lendsocialWebApp'
							);

							$this->cldb->insert('lendsocial_lender_statement', $lenderData);
						
							
							
							
							$remaining_amount=$lender_remaining_amount- $loan_amount;
							
							$lendsocial_lender_loan_priority_allocation_queue_data=array(
								'remaining_amount'=>$remaining_amount
							);
							
							$this->cldb->where('id',$queue['id']);
							$this->cldb->update('lendsocial_lender_loan_priority_allocation_queue', $lendsocial_lender_loan_priority_allocation_queue_data); 
							
							
							
							
							
							$borrowerLastBalance=$this->borrowerLastBalance($queue['partner_id'],$data['borrower_id']);
							$borrower_refrence.="'{$queue['invest_id']}'";
							$borrower_investment_taken.="{$queue['invest_id']}";
							$borrowerInsertData=array();
							//refrence,investment_no,
							$borrowerBalance=$borrowerLastBalance+$data['approved_loan_amount'];
							
							$borrowerData = array(
								'partner_id' => $queue['partner_id'],
								'borrower_id' => $data['borrower_id'],
								'transaction_type' => 'loanBorrow',
								'loan_no' => $data['loan_no'],
								'investment_no'=>$borrower_investment_taken,
								'title' => 'loan_received_by_the_lender',
								'reference' => $borrower_refrence,
								'reference_type' => 'investment_no',
								'debit' => '',
								'credit' => $data['approved_loan_amount'],
								'amount' => $data['approved_loan_amount'],
								'balance' => $borrowerBalance,
								'created_date' => date('Y-m-d H:i:s'), 
								'created_id' => '',
								'source' => 'lendsocialWebApp'
							);
							$this->cldb->insert('lendsocial_borrower_statement', $borrowerData); 
							
							
							$loan_given += $loan_amount;
							
					}else{
						//$borrowerInsertData[]=$queue;
						$borrower_refrence.="'{$queue['invest_id']}',";
						$borrower_investment_taken.="{$queue['invest_id']},";
						$loan_amount=$loan_amount-$lender_remaining_amount;
						
				$lendsocial_lender_loan_priority_allocation_queue_data = array(
                    'remaining_amount' => 0
                );
				
						$this->cldb->where('id', $queue['id']);
                $this->cldb->update('lendsocial_lender_loan_priority_allocation_queue', $lendsocial_lender_loan_priority_allocation_queue_data);
				
				
				
				$lenderLastBalance=$this->lenderLastBalance($queue['partner_id'],$queue['lender_id']);
						 $lenderBalance=$lenderLastBalance - $lender_remaining_amount;
						 
							$lenderData = array(
								'partner_id' => $queue['partner_id'],
								'lender_id' => $queue['lender_id'],
								'transaction_type' => 'disbursedAmount',
								'loan_no' => $data['loan_no'],
								'title' => 'disbursed to the borrower',
								'refrence' => $queue['invest_id'],
								'reference_type' => 'investment_no',
								'debit' => $lender_remaining_amount,
								'credit' => "",
								'amount' => $lender_remaining_amount,
								'balance' => $lenderBalance,
								'created_date' => date('Y-m-d H:i:s'), 
								'created_id' => "",
								'source' => 'lendsocialWebApp'
							);

							$this->cldb->insert('lendsocial_lender_statement', $lenderData);
						

						
						
						
					
				$loan_given += $loan_amount;
				}
			}
			
		}else {
            return 0;
        }
			
			
            $disburseData['disbursement_date']=date('Y-m-d h:i:s');
            $disburseData['loan_status']=1;
        }
        $this->cldb->where_in("id", $ids);
        $query = $this->cldb->update("p2p_loan_list", $disburseData);
    
    //    echo $this->cldb->last_query(); die();
       if ($query) {
            return 1;
        } else {
            return 0;
        }
    }
	
	public function lenderLastBalance($partner_id,$lender_id){
		
		// lender last balance starts
				
					$this->cldb->select('balance');
				$this->cldb->from('lendsocial_lender_statement');
				$this->cldb->where('lender_id', $lender_id);
				$this->cldb->where('partner_id', $partner_id);
				$this->cldb->order_by('id', 'DESC');
				$this->cldb->limit(1);
				
				$result = $this->cldb->get();
				
				if ($result->num_rows() > 0) {
					$result = $result->row_array();
					return isset($result['balance']) ? (float)$result['balance'] : 0; // Convert to float
				} else {
					return 0; // Return 0 if no record found
				}
				
				//lender last balance ends 
				
	}
	
	
	public function borrowerLastBalance($partner_id,$borrower_id){
		
		// lender last balance starts
				
					$this->cldb->select('balance');
				$this->cldb->from('lendsocial_borrower_statement');
				$this->cldb->where('borrower_id', $borrower_id);
				$this->cldb->where('partner_id', $partner_id);
				$this->cldb->order_by('id', 'DESC');
				$this->cldb->limit(1);
				
				$result = $this->cldb->get();
				
				if ($result->num_rows() > 0) {
					$result = $result->row_array();
					return isset($result['balance']) ? (float)$result['balance'] : 0; // Convert to float
				} else {
					return 0; // Return 0 if no record found
				}
				
				//lender last balance ends 
				
	}
	
	
	public function getPartnerIdViaLoanId($ids){
		
		// Find the borrower_id by using loan id
        $this->cldb->select('borrower_id,approved_loan_amount,loan_no');
        $this->cldb->from('p2p_loan_list');
        $query = $this->cldb->where("id", $ids)->limit(1)->get()->row_array();
        $borrower_id = $query['borrower_id'];
		
        // Find the partner id by using borrower_id
        $this->cldb->select('vendor_id');
        $this->cldb->from('p2p_borrowers_list');
        $queue = $this->cldb->where("id", $borrower_id)->limit(1)->get()->row_array();
        $partner_id = $queue['vendor_id'];
		
			
	return array('partner_id'=>$partner_id,'borrower_id'=>$borrower_id,'approved_loan_amount'=>$query['approved_loan_amount'],'loan_no'=>$query['loan_no']);
	}


    public function generate_bank_file_excel($ids)
				{
					$idsArray = explode(",", urldecode($ids));

					// Remove single quotes from each element in the array
					$idsArray = array_map('trim', $idsArray);

					// You may want to remove empty values if any
					$idsArray = array_filter($idsArray);
					
					$this->cldb->select('
					a.approved_loan_amount, 
			CONCAT("`","'.ANTWORKS_BANK_AC.'")  as Debited_Account_No,
			 c.ifsc_code as IFSC_CODE,
			 CONCAT("`",c.account_no) as Benificiary_AC_No,
			 b.name as Benificiary_Name,
			 "" as Sender_nd_Receiver_Information,
					"Antworks P2P" as Sender_Name
			
			 '
			 );
					
					$this->cldb->from('p2p_loan_list as a');
					$this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id =b.id', 'LEFT');
					$this->cldb->join('p2p_borrower_bank_res AS c', 'c.borrower_id = b.id', 'LEFT');
							// $this->cldb->join('invest_scheme_details as d', 'a.scheme_id =d.id', 'LEFT');
							// $this->cldb->join('invest_vendors1 as e', 'b.vendor_id =e.VID', 'LEFT');
					
					 $this->cldb->where_in('a.id',$idsArray);
					// $this->cldb->GROUP_BY("a.reinvestment_id");
					// $this->cldb->ORDER_BY('a.reinvestment_id', 'desc');
					$res = $this->cldb->get();

					return $res; // $result = $res->result_array();
				}


}
?>

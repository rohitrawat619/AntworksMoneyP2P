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
        $data = array(
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
            $data['approved_loan_amount']=$amount;
            $data['approved_interest']=$roi;
            $data['disburse_amount']=$amount;
        }
        else if($loanStatus==4){
            $data['disbursement_date']=date('Y-m-d h:i:s');
            $data['loan_status']=1;
        }
        $this->cldb->where_in("id", $ids);
        $query = $this->cldb->update("p2p_loan_list", $data);
    
    //    echo $this->cldb->last_query(); die();
        if ($query) {
            return 1;
        } else {
            return 0;
        }
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

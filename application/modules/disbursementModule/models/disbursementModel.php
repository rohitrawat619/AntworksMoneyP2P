<?php
class disbursementModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
      
    }


    
    public function getCountDisburseListStatus($disburseRequest, $status)
{
    $this->cldb->select('COUNT(*) as count');
    $this->cldb->from('p2p_loan_list as a');
    $this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id = b.id', 'LEFT');

    
    if (!empty($status)) {
        $this->cldb->where_in("a.status", $status);
    } else {
        
        $this->cldb->where("a.status IS NULL");
    }

    return $this->cldb->count_all_results();
}




    public function getDisburseRequestList($limit, $start, $disburseRequest,$status)
{
    $this->cldb->select('*, a.status, a.id');
    $this->cldb->from('p2p_loan_list as a');
    $this->cldb->join('p2p_borrowers_list as b', 'a.borrower_id = b.id', 'LEFT');
    $this->cldb->where_in("a.disbursement_request", $disburseRequest);
    // Check if the values array is not empty
    if (!empty($status)) {
        $this->cldb->where_in("a.status", $status);
    } else {
        
        $this->cldb->where("a.status IS NULL");
    }

    $query = $this->cldb->limit($limit, $start);

    return $res = $query->get()->result_array();
}
    

    public function update_disburse_status($loanStatus, $ids) {
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
			"'.ANTWORKS_BANK_AC.'" as Debited_Account_No,
			 c.ifsc_code as IFSC_CODE,
			 c.account_no as Benificiary_AC_No,
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

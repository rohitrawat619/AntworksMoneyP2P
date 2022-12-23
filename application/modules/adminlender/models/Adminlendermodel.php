<?php
class Adminlendermodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_count_lenders()
    {
        return $this->db->count_all('p2p_lender_list');
    }

    public function getlenders($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get('p2p_lender_list');
        return $query->result_array();
    }

    public function getlender($user_id)
    {
        $this->db->select('PLL.lender_id, PLL.lender_escrow_account_number, 
                           PLL.name, PLL.mobile, PLL.email, PLL.dob, PLL.pan, 
                           PLA.state, PLA.city, PLA.address1, PLA.address2,PLDT.father_name');
        $this->db->from('p2p_lender_list AS PLL');
        $this->db->join('p2p_lender_address AS PLA', 'PLL.user_id = PLA.lender_id', 'left');
        $this->db->join('p2p_lender_details_table AS PLDT', 'PLL.user_id = PLDT.lender_id', 'left');
        $this->db->where('PLL.user_id', $user_id);
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->row_array();
        }
        else{
            return false;
        }
    }

    public function overallLendedmoney($lender_id)
    {
        $sql = "SELECT SUM(bid_loan_amount) as total_amount_invested FROM `p2p_bidding_proposal_details` WHERE proposal_status IN(2,5,6) AND lenders_id = ".$lender_id."";
        $query  = $this->db->query($sql);
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }
}
?>
<?php
class Borrower_social_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->cldb = $this->load->database('credit-line', TRUE);
    }

    public function get_borrower_details_credit_line_social_profile($mobile)
    {
        $query = $this->cldb->select('SL.borrower_id,
		SL.mobile,
		SL.loan_amount,
		SL.loan_purpose,
		SL.tenure,
		SL.roi,
		bl.name as borrower_name')
		->join('p2p_borrowers_list bl', 'bl.id = SL.borrower_id', 'left')
		->get_where('p2p_borrower_social_loan SL', array('SL.mobile' => $mobile));
        if ($this->cldb->affected_rows() > 0) {
            $result = $query->row_array();
            return array(
                'status' => 1,
                'borrower_id' => $result['borrower_id'],
                'borrower_name' => $result['borrower_name'],
                'mobile' => $result['mobile'],
                'loan_amount' => $result['loan_amount'],
                'loan_purpose' => $result['loan_purpose'],
                'tenure' => $result['tenure'].' Months',
                'roi' => $result['roi'],

            );
        } else {
            return array('status' => 0, 'msg' => 'Sorry No data found');
        }
    }

}
?>

<?php 

class Managementmodel extends CI_Model{	
	
    private $u_primary_key='u_id';

	public function __construct(){

        $db22 = $this->load->database('second', TRUE);
	}
	
	public function profile() {
		
		$rid = $this->session->userdata('user_id');
		$this->db2->select('*');
		$this->db2->from('user_info');
		$this->db2->where('user_id',$rid);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function register_user() {
		
		//print_r($_POST);exit;
		$arr = $_POST;
		unset($arr['password']);
		$pwd =md5($_REQUEST['password']);
		$arr['password'] = $pwd;
		$arr['profilepic'] = $_FILES['profilepic']['name'];
		$arr['date_added']=date("Y-m-d H:i:s");
		$arr['date_modified']=date("Y-m-d H:i:s");
		
		$query = $this->db2-> insert('user_info',$arr);
		if($this->db2->affected_rows()>0)
		{
			$this->Emailmodel->register_lender_mail($_POST['email'],$_POST['role']);
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Add";
			$arry['activity_table'] ="user_info";
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2-> insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function user_list() {
		
		$this->db2->select('*');
		$this->db2->from('user_info');
		$this->db2->limit('100');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function recents() {
		
		$this->db2->select('*');
		$this->db2->from('user_info');
		$this->db2->where('status',1);
		$this->db2->limit(4);
		$query = $this->db2->get();
		$res = $query->result_array();
		return $res;
		
	}
	
	public function delete_user($rid) {
		
		$this->db2->where('user_id',$rid);
		$query = $this->db2->delete('user_info');
		if($this->db2->affected_rows()>0)
		{
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Delete";
			$arry['activity_table'] ="user_info";
			$arry['activity_for'] 	=$rid;
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2->insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function edit_user($eid) {
		
		$this->db2->select('*');
		$this->db2->from('user_info');
		$this->db2->where('user_id=',$eid);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function update_user($uid) {
		
		$arr = $_POST;
		unset($arr['password']);
		if($_REQUEST['password'])
		{
			$pwd =md5($_REQUEST['password']);
			$arr['password'] = $pwd;
		}
		if($_FILES['profilepic']['name'])
		{
			$arr['profilepic'] = $_FILES['profilepic']['name'];
		}
		$arr['date_modified']=date("Y-m-d H:i:s");
		
		$this->db2->where('user_id', $uid);
		$this->db2->update('user_info',$arr);
		
		if($this->db2->affected_rows()>0)
		{
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Update";
			$arry['activity_table'] ="user_info";
			$arry['activity_for'] 	=$uid;
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2->insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function rolelist() {
		
		$this->db2->select('*');
		$this->db2->from('user_role');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function activerolelist() {
		
		$this->db2->select('*');
		$this->db2->from('user_role');
		$this->db2->where('status', 1);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function rolebyid($roleid) {
		
		$this->db2->select('role');
		$this->db2->from('user_role');
		$this->db2->where('role_id',$roleid);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->row()->role;
		}
		else
		{
			return false;
		}
	}
	
	public function countusers() {
		
		$this->db2->select('count(user_id) as total_users');
		$this->db2->from('user_info');
		//$this->db2->group_by('role');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->row()->total_users;
		}
		else
		{
			return 0;
		}
	}
	
	public function countusersbyrole($role) {
		
		$this->db2->select('count(user_id) as total_users');
		$this->db2->from('user_info');
		$this->db2->where('role',$role);
		//$this->db2->group_by('role');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->row()->total_users;
		}
		else
		{
			return 0;
		}
	}
	
	public function add_role() {
		
		$arr = $_POST;
		
		$query = $this->db2-> insert('user_role',$arr);
		if($this->db2->affected_rows()>0)
		{
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Add";
			$arry['activity_table'] ="user_role";
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2-> insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function countroles() {
		
		$this->db2->select('count(role_id) as total_roles');
		$this->db2->from('user_role');
		//$this->db2->group_by('role');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->row()->total_roles;
		}
		else
		{
			return 0;
		}
	}
	
	public function delete_role($rid) {
		
		$this->db2->where('role_id',$rid);
		$query = $this->db2->delete('user_role');
		if($this->db2->affected_rows()>0)
		{
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Delete";
			$arry['activity_table'] ="user_role";
			$arry['activity_for'] 	=$rid;
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2->insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function edit_role($eid) {
		
		$this->db2->select('*');
		$this->db2->from('user_role');
		$this->db2->where('role_id=',$eid);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			 return $query->result_array();
		}
		else
		{
			return false;
		}
	}
	
	public function update_role($uid) {
		
		$arr = $_POST;
		
		$this->db2->where('role_id', $uid);
		$this->db2->update('user_role',$arr);
		
		if($this->db2->affected_rows()>0)
		{
			$arry=array();
			$arry['user_id'] 		=$this->session->userdata('user_id');
			$arry['activity'] 		="Update";
			$arry['activity_table'] ="user_role";
			$arry['activity_for'] 	=$uid;
			$arry['datecreated'] 	=date("Y-m-d H:i:s");
			$query = $this->db2->insert('history',$arry);
			return true;
		}
		else
		{
			return false;
		}
	}

	////////////////////////////////////////////////
	/////////////////////////////////////////

	public function borrower_list($pageLimit, $setLimit)
	{

		$sql = "SELECT * FROM borrowers_details_table   ORDER BY id DESC LIMIT
               " . $pageLimit . " , " . $setLimit;
		$query = $this->db2->query($sql);

		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}

	}

	public function countborrowers() {

		$this->db2->select('count(id) as total_users');
		$this->db2->from('borrowers_details_table');
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			return $query->row()->total_users;
		}
		else
		{
			return false;
		}
	}

    public function activebiddata()
{
	$sql = "SELECT BPD.bid_registration_id,UI.first_name as lender,BPD.borrowers_id ,BPD.lenders_id,BDT.first_name as borrower,PD.loan_amount as amount, BPD.loan_amount as percentamount,BPD.interest_rate from bidding_proposal_details as BPD LEFT JOIN borrowers_details_table as BDT ON BPD.borrowers_id = BDT.borrower_id LEFT JOIN proposal_details as PD on PD.borrower_id = BPD.borrowers_id LEFT JOIN user_info as UI ON UI.user_id= BPD.lenders_id where proposal_status='1' ORDER BY bid_registration_id DESC ";
	$query = $this->db2->query($sql);
	if($this->db2->affected_rows()>0)
	{
		return $query->result_array();
	}
	else{
		return false;
	}
}

	public function approvedb2iddata()
	{
		$sql = "SELECT  BDT.first_name,PD.loan_amount,BDT.borrower_id,PD.proposal_id
FROM    borrowers_details_table  AS BDT LEFT JOIN proposal_details AS PD ON BDT.borrower_id = PD.borrower_id
WHERE   BDT.`borrower_id` IN (SELECT BPD.borrowers_id  FROM approved_bidding_details AS ABD LEFT JOIN bidding_proposal_details AS BPD ON ABD.bid_registration_id=BPD.bid_registration_id)
ORDER BY PD.proposal_id DESC
";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

    public function borrowerdetail($b_id,$p_id)
{

	  $sql = "SELECT BPD.bid_registration_id,UI.first_name as lender,BPD.borrowers_id ,BPD.lenders_id,BDT.first_name as borrower,ABD.approved_loan_amount,PD.loan_amount as amount, BPD.loan_amount as percentamount,BPD.interest_rate,PD.tenor_months,ABD.bid_approved_date from bidding_proposal_details as BPD LEFT JOIN approved_bidding_details as ABD ON ABD.bid_registration_id = BPD.bid_registration_id LEFT JOIN borrowers_details_table as BDT ON BPD.borrowers_id = BDT.borrower_id LEFT JOIN proposal_details as PD on PD.borrower_id = BPD.borrowers_id LEFT JOIN user_info as UI ON UI.user_id= BPD.lenders_id where BPD.borrowers_id='".$b_id."' and BPD.proposal_id='".$p_id."' ORDER BY BPD.borrowers_id DESC ";

	$query = $this->db2->query($sql);
	if($this->db2->affected_rows()>0)

	{

		return $query->result_array();
	}
	else
	{
		return false;
	}

}

	public function closedb2iddata()
	{
		$sql = "SELECT BPD.bid_registration_id,UI.first_name as lender,BPD.borrowers_id ,BPD.lenders_id,BDT.first_name as borrower,PD.loan_amount as amount, BPD.loan_amount as percentamount,BPD.interest_rate from bidding_proposal_details as BPD LEFT JOIN borrowers_details_table as BDT ON BPD.borrowers_id = BDT.borrower_id LEFT JOIN proposal_details as PD on PD.borrower_id = BPD.borrowers_id LEFT JOIN user_info as UI ON UI.user_id= BPD.lenders_id where proposal_status='4' ORDER BY bid_registration_id DESC";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function lenders_list($pageLimit, $setLimit)
	{

		$sql = "SELECT * FROM user_info WHERE role='3' ORDER BY user_id DESC LIMIT
               " . $pageLimit . " , " . $setLimit;
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else{
			return false;
		}

	}

	public function countlenders() {

		$this->db2->select('count(id) as total_users');
		$this->db2->from('user_info');
		$this->db2->where('role',3);
		$query = $this->db2->get();
		if($this->db2->affected_rows()>0)
		{
			return $query->row()->total_users;
		}
		else
		{
			return false;
		}
	}

    public function total_countborrower()
{
	 $sql = "SELECT COUNT(id) as totalCount FROM  borrowers_details_table ";

	$query = $this->db2->query($sql);

	if($this->db2->affected_rows()>0)
	{
		return $query->row();
	}
	else
	{
		return false;
	}
}

	public function total_count()
	{

		$sql = "SELECT COUNT(user_id) as totalCount FROM  user_info WHERE role='3'";



		$query = $this->db2->query($sql);

		if($this->db2->affected_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function approved()
	{
		 $sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					BPD.proposal_id AS PROPOSALID,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL ORDER BY BPD.bid_registration_id DESC
			";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function approved_bidding_view($proposal_id)
	{
		$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE BPD.proposal_id='$proposal_id' AND ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL
			";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function repayment_proposal()
	{
		$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					BPD.proposal_id AS PROPOSALID,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NOT NULL ORDER BY BPD.bid_registration_id DESC
			";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	public function repayment_proposal_view($proposal_id)
	{
		 $sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					BPD.proposal_id AS PROPOSALID,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE BPD.proposal_id='$proposal_id' AND ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NOT NULL ORDER BY BPD.bid_registration_id DESC
			";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}

	public function show_emi_borrower($id)
	{
//		$this->db2->select('*');
//		$this->db2->from('borrower_emi_details');
//		$this->db2->where('loan_id',$id);
		 $sql = "SELECT
                BED.*,
                PD.tenor_months
		        FROM
		        borrower_emi_details AS BED
		        LEFT JOIN bidding_proposal_details AS BPD
		        ON BPD.bid_registration_id = BED.loan_id
		        LEFT JOIN proposal_details AS PD
		        ON PD.proposal_id = BPD.proposal_id
		        WHERE BED.loan_id = $id
		       ";
		$query = $this->db2->query($sql);
		if($this->db2->affected_rows()>0)
		{
          return $query->result();
		}
		else{
			return false;
		}

	}
}
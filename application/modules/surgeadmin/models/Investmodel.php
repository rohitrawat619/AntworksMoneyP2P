<?php

class Investmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
	}


	public function allpartners_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_vendors');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}


	public function allschemes_get()
	{
		$this->cldb->select('ISD.*, IV.Company_Name');
		$this->cldb->from('invest_scheme_details AS ISD');
		$this->cldb->join('invest_vendors as IV', 'IV.VID = ISD.Vendor_ID', 'INNER');

		$res = $this->cldb->get();

		return $result = $res->result_array();

	}
	

	public function schemelogs_get($id)
	{
		$this->cldb->select('ISD.*, IV.Company_Name');
		$this->cldb->from('invest_scheme_detail_logs AS ISD');
		$this->cldb->join('invest_vendors as IV', 'IV.VID = ISD.Vendor_ID', 'INNER');
		$this->cldb->where('scheme_details_id', $id);
		$this->cldb->order_by('id', 'DESC');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}

	public function allrepersent_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_repessentative ');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}


	public function allrepersent_gets()

	{

		$query = $this->cldb->select('IR.*, IV.Company_Name')->join('invest_vendors as IV', 'IV.VID = IR.vender', 'left')->get_where('invest_repessentative as IR');

		if ($this->cldb->affected_rows() > 0) {
			return $result = $query->result_array();
		} else {
			return false;
		}
	}

	public function redemption_gets()
                                                                                 
{
		$this->cldb->select('PLR.created_date, PLR.reinvestment_id, PLR.lender_id, PLL.name, PLL.mobile, PLR.amount, PLR.basic_rate, PLR.pre_mat_rate, PLR.source, PLR.total_current_value, PLR.total_no_of_days, PLR.redemption_date, PLR.investment_No, PLR.redemption_status');
		$this->cldb->from('p2p_lender_reinvestment AS PLR');
	    $this->cldb->join('p2p_lender_list AS PLL', 'PLL.lender_id = PLR.lender_id', 'INNER');
	    $this->cldb->where_in('redemption_status' , 1);
		$res = $this->cldb->get();

		
		return $result = $res->result_array();  
	}

	
	public function disbursment_gets()
                                                                                 
   { 
		$this->cldb->select('PLR.created_date, PLR.reinvestment_id, PLR.lender_id, PLL.name, PLL.mobile, PLR.amount, PLR.basic_rate, PLR.pre_mat_rate, PLR.source, PLR.total_current_value, PLR.total_no_of_days, PLR.redemption_date, PLR.investment_No, PLR.redemption_status');
		$this->cldb->from('p2p_lender_reinvestment AS PLR');
	    $this->cldb->join('p2p_lender_list AS PLL', 'PLL.lender_id = PLR.lender_id', 'INNER');
	    $this->cldb->where_in('redemption_status' , 2);
		$res = $this->cldb->get();

		
		return $result = $res->result_array();  
	}


	public function disburse_gets()

                                                                                 
{
		$this->cldb->select('PLR.created_date, PLR.reinvestment_id, PLR.lender_id, PLL.name, PLL.mobile, PLR.amount, PLR.basic_rate, PLR.pre_mat_rate, PLR.source, PLR.total_current_value, PLR.total_no_of_days, PLR.redemption_date, PLR.investment_No, PLR.redemption_status');
		$this->cldb->from('p2p_lender_reinvestment AS PLR');
	    $this->cldb->join('p2p_lender_list AS PLL', 'PLL.lender_id = PLR.lender_id', 'INNER');
	    $this->cldb->where_in('redemption_status' , 4);
		$res = $this->cldb->get();

		
		return $result = $res->result_array();  
	}

	
	public function dipending_gets()
                                                                                 
{
		$this->cldb->select('PLR.created_date, PLR.reinvestment_id, PLR.lender_id, PLL.name, PLL.mobile, PLR.amount, PLR.basic_rate, PLR.pre_mat_rate, PLR.source, PLR.total_current_value, PLR.total_no_of_days, PLR.redemption_date, PLR.investment_No, PLR.redemption_status');
		$this->cldb->from('p2p_lender_reinvestment AS PLR');
	    $this->cldb->join('p2p_lender_list AS PLL', 'PLL.lender_id = PLR.lender_id', 'INNER');
	    $this->cldb->where_in('redemption_status' , 5);
		$res = $this->cldb->get();

		
		return $result = $res->result_array();  
	}


	public function investment_gets()
                                                                                 
{
		$this->cldb->select('PLR.created_date, PLR.lender_id, PLL.name, PLL.mobile, PLR.amount, PLR.basic_rate, PLR.pre_mat_rate, PLR.source, PLR.total_current_value, PLR.total_no_of_days, PLR.redemption_date, PLR.pre_mat_rate, PLR.investment_No, PLR.redemption_status');
		$this->cldb->from('p2p_lender_reinvestment AS PLR');
	    $this->cldb->join('p2p_lender_list AS PLL', 'PLL.lender_id = PLR.lender_id', 'INNER');
	    $this->cldb->where_in('redemption_status' , array(0, 1, 2, 4, 5));
		$res = $this->cldb->get();

		
		return $result = $res->result_array();  
	}


	public function updateRedemptionStatus($reinvestment_id) {                                         
      
        $this->cldb->where_in('reinvestment_id', $reinvestment_id);
        $this->cldb->update('p2p_lender_reinvestment', array('redemption_status' => '2'));
       
        $query = $this->cldb->get('p2p_lender_reinvestment');
        return $query->result_array();
    }



	public function redemptionapproved($id, $status)
	
     {
			$data['redemption_status'] = $status;
			$this->cldb->where('reinvestment_id', $id);
			return $this->cldb->update('p2p_lender_reinvestment', $data);
		}

		public function disburseapproved($id, $status)
	
     {
			$data['redemption_status'] = $status;
			$this->cldb->where('reinvestment_id', $id);
			return $this->cldb->update('p2p_lender_reinvestment', $data);
		}

	/*	public function pendingapproved($id, $status)
		{

			$data['redemption_status'] = $status;
			$this->cldb->where('reinvestment_id', $id);
			return $this->cldb->update('p2p_lender_reinvestment', $data);
		} */
	

		public function decline($id, $status)
	
		{
			   $data['redemption_status'] = $status;
			   $this->cldb->where('reinvestment_id', $id);
			   return $this->cldb->update('p2p_lender_reinvestment', $data);
		   }


	public function allhikes_get()
	{
$query = $this->cldb->select('IHL.*, ISD.Scheme_Name')->join('invest_scheme_details as ISD', 'ISD.ID = IHL.scheme_id', 'inner')->get_where('invest_hike_logs as IHL');
if ($this->cldb->affected_rows() > 0) {
	return $result = $query->result_array();
} else {
	return false;
}
   }

	public function scheme_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_scheme_details');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}


	public function vend_addcheme_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_vendors');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}

	public function scheme_vend_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_vendors');

		$res = $this->cldb->get();

		return $result = $res->result_array();
	}

	public function edituser($VID)

	{
		$query = $this->cldb->select('*')->from('invest_vendors')->where('VID', $VID)->get();
		if ($this->cldb->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}


	public function updateschemes($id)
	{
		$query = $this->cldb->select('*')->from('invest_scheme_details')->where('id', $id)->get();
		if ($this->cldb->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}



	public function update_user($data)
	{
		$this->cldb->where('VID', $this->input->post('VID'));
		return $this->cldb->update('invest_vendors', $data);
	}

public function edithikelog($id)
{

$query = $this->cldb->select('*')->from('invest_hike_logs')->where('id', $id)->get();
if ($this->cldb->affected_rows() > 0) {
	return (array)$query->row();
} else {
	return false;
}
   }

public function update_hikelog($data)
{

$this->cldb->where('id', $this->input->post('id'));
$this->cldb->update('invest_hike_logs', $data);

}


	public function editrepersents($rid)

	{
		$query = $this->cldb->select('*')->from('invest_repessentative')->where('rid', $rid)->get();
		if ($this->cldb->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}


	public function update_repersent($data)
	{
		$this->cldb->where('rid', $this->input->post('rid'));
		$this->cldb->update('invest_repessentative', $data);
	}


	public function update_scheme($data)
	{

		$this->invest_scheme_detail_logs($this->input->post('id'));

		$this->cldb->where('id', $this->input->post('id'));
		return $this->cldb->update('invest_scheme_details', $data);
	}

	public function statusupdate($id, $status)
	{
		$data['status'] = $status;
		$this->cldb->where('id', $id);
		return $this->cldb->update('invest_scheme_details', $data);
	}


	function invest_scheme_detail_logs($id){

		$schemeLogs = $this->updateschemes($id);
		$data = array(
			'Scheme_Name' => $schemeLogs['Scheme_Name'],
			'Vendor_ID' => $schemeLogs['Vendor_ID'],
			'Min_Inv_Amount' => $schemeLogs['Min_Inv_Amount'],
			'Max_Inv_Amount' => $schemeLogs['Max_Inv_Amount'],
			'Aggregate_Amount' => $schemeLogs['Aggregate_Amount'],
			'Lockin' => $schemeLogs['Lockin'],
			'Lockin_Period' => $schemeLogs['Lockin_Period'],
			'Cooling_Period' => $schemeLogs['Cooling_Period'],
			'Interest_Rate' => $schemeLogs['Interest_Rate'],
			'hike_rate' => $schemeLogs['hike_rate'],
			'Pre_Mat_Rate' => $schemeLogs['Pre_Mat_Rate'],
			'Withrawl_Anytime' => $schemeLogs['Withrawl_Anytime'],
			'Auto_Redeem' => $schemeLogs['Auto_Redeem'],
			'Interest_Type' => $schemeLogs['Interest_Type'],
			'scheme_details_id' => $schemeLogs['id'],
			'scheme_created_date' => $schemeLogs['created_date'],
			'created_date' => date("Y-m-d h:i:s"),

		);
		
		$this->cldb->insert('invest_scheme_detail_logs', $data);
	}

	public function insert_scheme()
	{
		$data = array(
			'Scheme_Name' => $this->input->post('Scheme_Name'),
			'Vendor_ID' => $this->input->post('vendor'),
			'Min_Inv_Amount' => $this->input->post('Min_Inv_Amount'),
			'Max_Inv_Amount' => $this->input->post('Max_Inv_Amount'),
			'Aggregate_Amount' => $this->input->post('Aggregate_Amount'),
			'Lockin' => $this->input->post('Lockin'),
			'Lockin_Period' => $this->input->post('Lockin_Period'),
			'Cooling_Period' => $this->input->post('Cooling_Period'),
			'Interest_Rate' => $this->input->post('Interest_Rate'),
			'Hike_Rate' => $this->input->post('Hike_Rate'),
			'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
			'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
			'Auto_Redeem' => $this->input->post('Auto_Redeem'),
			'Interest_Type' => $this->input->post('Interest_Type')
		);

		$this->cldb->insert('invest_scheme_details', $data);
		return true;
	}

	function isSchemeNameExists($scheme_Name)
{
    $this->cldb->where('scheme_Name',$scheme_Name);
    $query = $this->cldb->get('invest_scheme_details');
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}

	public function insert_repersentive()
	{
		$data = array(
			'RepName' => $this->input->post('RepName'),
			'vender' => $this->input->post('vender'),
			'RepDesignation' => $this->input->post('RepDesignation'),
			'Repphone' => $this->input->post('Repphone'),
			'Repemail' => $this->input->post('Repemail'),
			'password' => md5($this->input->post('password'))
		);
		$this->cldb->insert('invest_repessentative', $data);
		return true;
	}

	public function insert_partner()
	{
		$data = array(
			'Company_Name' => $this->input->post('Company_Name'),
			'Address' => $this->input->post('Address'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email')
		);
		$this->cldb->insert('invest_vendors', $data);

		return true;
	}
}

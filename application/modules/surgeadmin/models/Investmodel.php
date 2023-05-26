<?php

class Investmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
	}


	public function allvendors_get()
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
		$this->cldb->where('id', $this->input->post('id'));
		return $this->cldb->update('invest_scheme_details', $data);
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
			'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
			'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
			'Auto_Redeem' => $this->input->post('Auto_Redeem'),
			'Interest_Type' => $this->input->post('Interest_Type')
		);

		$this->cldb->insert('invest_scheme_details', $data);
		return true;
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

	public function insert_vendor()
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

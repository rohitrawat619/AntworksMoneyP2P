<?php

class Kyc_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		//$this->db_money = $this->load->database('db_money', true);
	}
	public function product_list()
	{
		$query = $this->db->get('kyc_products');
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function product_kyc_rule($productId)
	{
		$query = $this->db->select('KYCP.product_name,PKR.*')->join('kyc_products as KYCP', 'KYCP.id = PKR.product_id')->get_where('product_kyc_rule as PKR', array('product_id' => $productId));
		
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	 public function add_update_rule()
    {
		
		$postData = $this->input->post();
		
		for($i=0; $i<3; $i++){
			$update_arr = array(
			   'pan_kyc' => $postData['pan_kyc_'.$postData['id'][$i]] ?? '',
			   'aadhar_KYC' => $postData['aadhar_KYC_'.$postData['id'][$i]] ?? '',
			   'aadhar_KYC' => $postData['aadhar_KYC_'.$postData['id'][$i]] ?? '',
			   'aadhar_OKYC' => $postData['aadhar_OKYC_'.$postData['id'][$i]] ?? '',
			   'bank_account_kyc' => $postData['bank_account_kyc_'.$postData['id'][$i]] ?? '',
			   'liveliness_kyc' => $postData['liveliness_kyc_'.$postData['id'][$i]] ?? '',
			   'cross_matching_rule' => $postData['cross_matching_rule_'.$postData['id'][$i]] ?? '',
			  );
                $this->db->where('id', $postData['id'][$i]);
				$this->db->where('product_id', $postData['product_id']);		
			    $this->db->update('product_kyc_rule', $update_arr);
			   //echo $this->db->last_query();exit;
		} 
        return array(
            'status' => 1,
            'msg' => 'Rule Update successfully'
        );
    }
	public function client_list()
	{
		$query = $this->db->get('kyc_api_client_secret');
		if ($this->db->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}
	public function get_kyc_client_details($id)
	{
		$query = $this->db->get_where('kyc_api_client_secret', array('id' => $id));
		
		if ($this->db->affected_rows() > 0) {
			return (array)$query->row();
		} else {
			return false;
		}
	}
}

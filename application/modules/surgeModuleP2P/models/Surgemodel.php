<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surgemodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	//	$this->db_money_money = $this->load->database('db_money', true);
	//  $this->cldb = $this->load->database('credit-line', TRUE);
	//  $this->cldb = $this->load->database('credit-line', TRUE);
	$this->cldb = $this->load->database('', TRUE); // antworks_p2pdevelopment
	//	$this->load->model('Common_model');
		$this->load->model('LendSocialCommunicationModel');
			// Get the database name
		$this->partner_id = $this->session->userdata('partner_id');
	}
		
		
					public function getOccupationList()
			{
			$limit = 1000; $start = 0;
			$this->cldb->select('*');
			$this->cldb->from('p2p_occupation_details_table');
			
			$this->cldb->limit($limit, $start);
			$res = $this->cldb->get();

			return $result = $res->result_array();
			}
			
			public function getProfessionList()
			{
			$limit = 1000; $start = 0;
			$this->cldb->select('*');
			$this->cldb->from('trans_profession');
			$this->cldb->where('status',1);
			$this->cldb->limit($limit, $start);
			$res = $this->cldb->get();

			return $result = $res->result_array();
			}
		
							public function getInvestmentNoOfInvestor($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('lender_id');
		$this->cldb->from('p2p_lender_investment');
		$this->cldb->GROUP_BY('lender_id');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
		$this->cldb->where_in('scheme_id',$scheme_ids);
		return $this->cldb->count_all_results();
	}
	
		// start 

	public function getSystemGeneratedLenderId($partner_id){ // Dated: 2024-sept-24
		$this->cldb->select('*');
		$this->cldb->from('partners_theme');
		// add the conditions
		 $this->cldb->where('partner_id',$partner_id);

		$query = $this->cldb->get()->row_array();
		return $query['system_generated_id'];
	}

	public function getLenderSchemeData($partner_id){ // Dated: 2024-sept-24
		$this->cldb->select('*');
		$this->cldb->from('invest_scheme_details');
		// add the conditions
		$this->cldb->where('Vendor_ID',$partner_id);
		$query = $this->cldb->get()->row_array();
		return $query;
	}


	// end 
	
						public function getOutstandingInvestmentNoInvestor($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('lender_id');
		$this->cldb->from('p2p_lender_investment');
		$this->cldb->GROUP_BY('lender_id');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status!=',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
		return $this->cldb->count_all_results();
	}
		
				public function getRedeemedInNoOfInvestor($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('lender_id');
		$this->cldb->from('p2p_lender_investment');
		$this->cldb->GROUP_BY('lender_id');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
		return $this->cldb->count_all_results();
	}
		
				public function getInvestmentAmount($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('sum(amount) AS amount');
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return '&#x20B9;'.round($res[0]['amount'],2); //$this->cldb->count_all_results();
	}
		
		
	
				public function getlInvestmentOutstandingAmount($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('sum(amount) AS amount'); 
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status!=',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return '&#x20B9;'.number_format($res[0]['amount']); //$this->cldb->count_all_results();
	}
	
		public function getInterestOutstanding($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('ROUND(SUM(total_interest),2) AS total_interest');
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status!=',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return '&#x20B9;'.number_format($res[0]['total_interest']); //$this->cldb->count_all_results();
	}
	
						public function getRedemptionAmount($type) // today  
	{  $scheme_ids = $this->getlSchemeIdsByPartnerId();
				$this->cldb->select('sum(amount) AS amount');
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return '&#x20B9;'.number_format($res[0]['amount']); //$this->cldb->count_all_results();
	}
	
	

	
	
						public function getInterestPaidOnRedeemedInvestment($type) // today  
	{ $scheme_ids = $this->getlSchemeIdsByPartnerId();
				$this->cldb->select('ROUND(SUM(total_interest),2) AS total_interest');
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where('redemption_status',4);
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return '&#x20B9;'.($res[0]['total_interest']+0); //$this->cldb->count_all_results();
	}
	
	

			public function getlAverageROI($type) // today  
	{	$scheme_ids = $this->getlSchemeIdsByPartnerId();
		$this->cldb->select('SUM(basic_rate) AS brsum, COUNT(basic_rate) AS bscount, (SUM(basic_rate)/COUNT(basic_rate)) as average_roi'); 
		$this->cldb->from('p2p_lender_investment');
		if($type=="today"){
		$this->cldb->where('Date(created_date)',date("Y-m-d"));
		}		
			$this->cldb->where_in('scheme_id',$scheme_ids);
			$res = $this->cldb->get()->result_array();
		 return round($res[0]['average_roi'],2); //$this->cldb->count_all_results();
	}
	
	
			public function getlSchemeIdsByPartnerId() // today  
	{
		$this->cldb->select('a.id as scheme_id'); 
		$this->cldb->from('invest_scheme_details a'); /// invest_scheme_details
		
		if($this->input->post('scheme_id')!=""){
			$this->cldb->where('id',$this->input->post('scheme_id'));
		}
		
		if($this->input->post('partner_id')!="allPartners"){
		if($this->input->post('partner_id')!=""){
					$this->cldb->where('Vendor_ID',$this->input->post('partner_id'));
		}else if($this->partner_id!="0"){
		$this->cldb->where('Vendor_ID',$this->partner_id);
				}
				
		}
			$res = $this->cldb->get()->result_array();
						
								$ids = [];
			foreach ($res as $item) {
				$ids[] = $item['scheme_id'];
			}

			$comma_separated_ids = $ids; // implode(',', $ids);
			//echo $comma_separated_ids; // Output: 10,11,17,18,19
			if($comma_separated_ids==""){
				$comma_separated_ids = "11111123456789,234567";
			}else if(empty($comma_separated_ids)){
				$comma_separated_ids = "5454454554";
			}
		 return  $comma_separated_ids; 
	}
	
	
	
		public function getDashboardDataCount($table,$where,$groupBy)
	{
		$this->cldb->select('id');
		$this->cldb->from($table);
		if($where!=""){
		$this->cldb->where($where);
		}		
			if($groupBy!=""){
			$this->cldb->GROUP_BY("$groupBy");
				}
		//$abcd = $this->cldb->count_all_results();
		 return $this->cldb->count_all_results(); //$abcd.$this->cldb->last_query();
	}

	

		public function getPartnersList($limit, $start,$where)
	{
		$this->cldb->select('b.disbursment_method, b.partner_type, invest_vendors.*, b.font_family, b.color, b.background_color, b.logo_path, b.borrower_product_name, b.lender_product_name,
		b.borrower_logo_path, b.lender_logo_path,
		c.borrower_platform_registration_fee,
		c.borrower_partner_registration_fee,
		c.borrower_processing_fee_rupee,
		c.borrower_processing_fee_percent,
		c.type_of_Lender_platform_fee,
		c.lender_platform_fee_percentage,
		c.lender_platform_fee_rupee,
		c.lender_partner_registration_fee,
		c.lender_processing_fee_rupee,
		c.lender_processing_fee_percent,
		c.lender_pg_charges_bearer
		');
		$this->cldb->from('invest_vendors');
		$this->cldb->join('partners_theme as b', 'invest_vendors.VID=b.partner_id', 'LEFT');
		$this->cldb->join('master_fee_structure as c', 'invest_vendors.VID=c.partner_id', 'LEFT');
		$this->cldb->limit($limit, $start);
			if($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12){
		$this->cldb->where("invest_vendors.VID", $this->partner_id);
		}

		if($where!=""){
		$this->cldb->where($where);
		}else{
			//echo "test";
		}
		$res = $this->cldb->get();
			//echo $this->cldb->last_query(); die();
		return $result = $res->result_array();
	}
	public function getCountPartnersList($where)
	{
		$this->cldb->select('id');
		$this->cldb->from('invest_vendors');
		if($where!=""){
		$this->cldb->where($where);
		}
		return $this->cldb->count_all_results();
	}
	
		public function add_partner(){
		
			$arr_partners = array(
				'status' => 1,
				'company_name' => $this->input->post('Company_Name'),
				'address' => $this->input->post('Address'),
				'phone' => $this->input->post('Phone'),
				'email' => $this->input->post('Email'),
				'key' => $this->input->post('key'),
			//	'level' => $this->input->post('level'),
			//	'ignore_limits' => $this->input->post('ignore_limits'),
			//	'is_private_key' => $this->input->post('is_private_key'),
			//	'ip_addresses' => $this->input->post('ip_addresses'),
			);
    // Check if any required field is empty
  if (empty($arr_partners['company_name']) || empty($arr_partners['phone'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['insert_id'] = "";
    return $resp;
}
    
						$emailCount = $this->cldb->from('invest_vendors')->where('email', $arr_partners['email'])->count_all_results();
					$mobileCount = $this->cldb->from('invest_vendors')->where('phone', $arr_partners['phone'])->count_all_results();
						 $resp['status'] = 0;
					if($emailCount>0){
						$resp['msg'] = "Email ID Already Exist";
					}else if($mobileCount>0){
							$resp['msg'] = "Mobile Number Already Exist";
					}else{
						
			  $insertResult = $this->cldb->insert('invest_vendors', $arr_partners);
			  if($insertResult){
				    $insert_id = $this->cldb->insert_id();
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner Added Successfully: Insert ID:".$insert_id;
				  $resp['insert_id'] = $insert_id;
				//  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner Insertion Failed";
				  $resp['insert_id'] = "";
				 // return $resp;
			  }
					}
					return $resp;
	}
	
	
			public function add_master_fee_structure($partner_id){
				
			//	print_r($this->input->post());
			$arr_mst_fee_struc = array(
				'status' => 1,
				'borrower_platform_registration_fee' => $this->input->post('borrower_platform_registration_fee'),
				'borrower_processing_fee_rupee' => $this->input->post('borrower_processing_fee_rupee'),
				'borrower_processing_fee_percent' => $this->input->post('borrower_processing_fee_percent'),
				'lender_partner_registration_fee' => $this->input->post('lender_partner_registration_fee'),
				'lender_processing_fee_rupee' => $this->input->post('lender_processing_fee_rupee'),
				'lender_processing_fee_percent' => $this->input->post('lender_processing_fee_percent'),
				'type_of_Lender_platform_fee' => $this->input->post('type_of_Lender_platform_fee'),
				'lender_platform_fee_percentage' => $this->input->post('lender_platform_fee_percentage'),
				'lender_platform_fee_rupee' => $this->input->post('lender_platform_fee_rupee'),
				'lender_pg_charges_bearer' => $this->input->post('lender_pg_charges_bearer'),
				'data_entry_time' => date("Y-m-d H:i:s"),
				'data_entry_id' => $this->session->userdata('user_id'),
				'partner_id' => $partner_id,
			);


    
							
			  $insertResult = $this->cldb->insert('master_fee_structure', $arr_mst_fee_struc);
								
			  if($insertResult){
				    
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner Fee Structure Add Successfully: Update ID:".$partner_id;
				  $resp['partner_id'] = $partner_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner Fee Structure Addition Failed";
				  $resp['partner_id'] = "";
				  return $resp;
			  }
	}
			public function add_theme($partner_id,$logo_path,$lender_logo_path,$borrower_logo_path){
		
			$arr_partners_theme = array(
				'status' => 1,
				'partner_id' => $partner_id,
				'color' => $this->input->post('color'),
				'name' => $this->input->post('Company_Name'),
				'background_color' => $this->input->post('background_color'),
				'logo_path' => $logo_path,
				'borrower_logo_path' => $borrower_logo_path,
				'lender_logo_path' => $lender_logo_path,
				'font_family' => $this->input->post('font_family'),
				'created_date' => date("Y-m-d H:i:s"),
				'created_user_id' => $this->session->userdata('user_id'),
			//'borrower_product_name' => $this->input->post('borrower_product_name'),
				//'lender_product_name' => $this->input->post('lender_product_name'),
			//	'partner_type' => $this->input->post('partner_type'),
			);
    // Check if any required field is empty
  if (empty($partner_id) || empty($arr_partners_theme['name'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['insert_id'] = "";
    return $resp;
}
						if($this->input->post('disbursment_method')!=""){
						$arr_partners_theme['disbursment_method'] = $this->input->post('disbursment_method');
						}
						if($this->input->post('partner_type')!=""){
						$arr_partners_theme['partner_type'] = $this->input->post('partner_type');
						}
						
						if($this->input->post('borrower_product_name')!=""){
						$arr_partners_theme['borrower_product_name'] = $this->input->post('borrower_product_name');
						}
						if($this->input->post('lender_product_name')!=""){
				$arr_partners_theme['lender_product_name'] = $this->input->post('lender_product_name');
						}
		
			  $insertResult = $this->cldb->insert('partners_theme', $arr_partners_theme);
			  if($insertResult){
				    $insert_id = $this->cldb->insert_id();
					
					
					if($arr_partners_theme['partner_type']=='lender'){ // Added On 2024-Sept-20
						$this->cldb->where('theme_id',$insert_id); // theme_id
						$this->cldb->update('partners_theme',array("system_generated_id"=>base64_encode($arr_partners_theme['partner_id']),'partner_type'=>$arr_partners_theme['partner_type']));
						}
					
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner Added Successfully"; // Insert ID:".$insert_id;
				  $resp['insert_id'] = $insert_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner Insertion Failed";
				  $resp['insert_id'] = "";
				  return $resp;
			  }
	}
	
			public function update_partner(){
				
				print_r($this->input->post());
			$arr_partners = array(
				'status' => 1,
				'company_name' => $this->input->post('Company_Name'),
				'address' => $this->input->post('Address'),
				'phone' => $this->input->post('Phone'),
				'email' => $this->input->post('Email'),
				'key' => $this->input->post('key'),
				'level' => $this->input->post('level'),
				'ignore_limits' => $this->input->post('ignore_limits'),
				'is_private_key' => $this->input->post('is_private_key'),
				'ip_addresses' => $this->input->post('ip_addresses'),
			);
			$partner_id = $this->input->post('VID');
    // Check if any required field is empty
  if (empty($arr_partners['company_name']) || empty($arr_partners['phone'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['partner_id'] = "";
    return $resp;
}
    
							$this->cldb->where('VID',$partner_id);	
			  $insertResult = $this->cldb->update('invest_vendors', $arr_partners);
								
			  if($insertResult){
				    
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner Updated Successfully: Update ID:".$partner_id;
				  $resp['partner_id'] = $partner_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner Updation Failed";
				  $resp['partner_id'] = "";
				  return $resp;
			  }
	}
	
	
			public function update_master_fee_structure(){
				
				print_r($this->input->post());
			$arr_mst_fee_struc = array(
				'status' => 1,
				'borrower_platform_registration_fee' => $this->input->post('borrower_platform_registration_fee'),
				'borrower_processing_fee_rupee' => $this->input->post('borrower_processing_fee_rupee'),
				'borrower_processing_fee_percent' => $this->input->post('borrower_processing_fee_percent'),
				'lender_partner_registration_fee' => $this->input->post('lender_partner_registration_fee'),
				'lender_processing_fee_rupee' => $this->input->post('lender_processing_fee_rupee'),
				'lender_processing_fee_percent' => $this->input->post('lender_processing_fee_percent'),
				'type_of_Lender_platform_fee' => $this->input->post('type_of_Lender_platform_fee'),
				'lender_platform_fee_percentage' => $this->input->post('lender_platform_fee_percentage'),
				'lender_platform_fee_rupee' => $this->input->post('lender_platform_fee_rupee'),
				'lender_pg_charges_bearer' => $this->input->post('lender_pg_charges_bearer'),
				'borrower_partner_registration_fee' => $this->input->post('borrower_partner_registration_fee'),
				'data_update_time' => date("Y-m-d H:i:s"),
				'data_update_id' => $this->session->userdata('user_id'),
			);
			
			foreach ($arr_mst_fee_struc as $key => $value) {
    // Check if the input value is not empty
    if (!empty($value)) {
        $updateData[$key] = $value; // Add to the update data array
    }
		}
			$partner_id = $this->input->post('VID');

    
							$this->cldb->where('partner_id',$partner_id);	
			  $insertResult = $this->cldb->update('master_fee_structure', $updateData);
								
			  if($insertResult){
				    
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner Fee Structure Updated Successfully: Update ID:".$partner_id;
				  $resp['partner_id'] = $partner_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner Fee Structure Updation Failed";
				  $resp['partner_id'] = "";
				  return $resp;
			  }
	}
			//public function update_theme($partner_id,$logo_path){
			public function update_theme($partner_id,$logo_path,$lender_logo_path,$borrower_logo_path){
			
			$arr_partners_theme = array(
				'status' => 1,
				'partner_id' => $partner_id,
				'color' => $this->input->post('color'),
				'name' => $this->input->post('Company_Name'),
				'background_color' => $this->input->post('background_color'),
				
				'font_family' => $this->input->post('font_family'),
				'created_date' => date("Y-m-d H:i:s"),
				'created_user_id' => $this->session->userdata('user_id'),
				
			//	'partner_type' => $this->input->post('partner_type'),
			);
				if($logo_path!="<"){
					$arr_partners_theme['logo_path'] = $logo_path;
				}
				
				if($lender_logo_path!="<"){
					$arr_partners_theme['lender_logo_path'] = $lender_logo_path;
				}
				
				if($borrower_logo_path!="<"){
					$arr_partners_theme['borrower_logo_path'] = $borrower_logo_path;
				}
				
				
						// Check if any required field is empty
					  if ($partner_id=="" || empty($arr_partners_theme['name'])) {
						$resp['status'] = 2;
						$resp['msg'] = "Some fields are empty";
						$resp['partner_id'] = "";
					$resp['OtherData'] = $arr_partners_theme;
						return $resp;
					}
					
						if($this->input->post('partner_type')!=""){
						$arr_partners_theme['partner_type'] = $this->input->post('partner_type');
						}
						if($this->input->post('disbursment_method')!=""){
						$arr_partners_theme['disbursment_method'] = $this->input->post('disbursment_method');
						}
						
						if($this->input->post('borrower_product_name')!=""){
						$arr_partners_theme['borrower_product_name'] = $this->input->post('borrower_product_name');
						}
						if($this->input->post('lender_product_name')!=""){
				$arr_partners_theme['lender_product_name'] = $this->input->post('lender_product_name');
						}
								$this->cldb->where('partner_id',$partner_id);	
			  $insertResult = $this->cldb->update('partners_theme', $arr_partners_theme);
			  if($insertResult){
				    
				  $resp['status'] = 1;
				  $resp['msg'] = "Partner  Updated Successfully";
				  $resp['partner_id'] = $partner_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Partner  Updation Failed";
				  $resp['partner_id'] = "";
				  return $resp;
			  }
	}
	
	
			public function getUserList($limit, $start,$where,$whereIn)
	{
		$this->cldb->select('p2p_admin_list.*, b.role_name, c.Company_Name as partner_name');
		$this->cldb->from('p2p_admin_list');
		$this->cldb->join('p2p_admin_role as b', 'p2p_admin_list.role_id=b.id', 'LEFT');
		$this->cldb->join('invest_vendors c', 'p2p_admin_list.partner_id=c.VID', 'LEFT');
		
		if($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12){
		$this->cldb->where("p2p_admin_list.partner_id", $this->partner_id);
		}

		if($where!=""){
		$this->cldb->where($where);
		}
	if (!empty($whereIn)) {
        foreach ($whereIn as $column => $values) {
            $this->cldb->where_in($column, $values);
        }
	           }

		$this->cldb->limit($limit, $start);
		$res = $this->cldb->get();
				// echo $this->cldb->last_query(); die();
		return $result = $res->result_array();
	}
	public function getCountUserList($where,$whereIn)
	{
		$this->cldb->select('id');
		$this->cldb->from('p2p_admin_list');
		if($where!=""){
		$this->cldb->where($where);
		}
		
		if (!empty($whereIn)) {
        foreach ($whereIn as $column => $values) {
            $this->cldb->where_in($column, $values);
        }
		}
		return $this->cldb->count_all_results();
	}
	
				public function update_user(){ // mail done
		
	$postParameters = array(
    'role_id',
    'fname',
    'lname',
    'email',
    'mobile',
    'password',
    'status',
    'partner_id'
);

$arr_user = array('status' => 1);

foreach ($postParameters as $param) {
    $arr_user[$param] = $this->input->post($param);
}

			$user_id = $this->input->post('admin_id');
			
    // Check if any required field is empty
  if (empty($arr_user['fname']) || empty($arr_user['lname'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['user_id'] = "";
    return $resp;
}								if($arr_user['password']==""){
										unset($arr_user['password']);
										}else{
											
									$arr_user['password'] = hash('sha512', $arr_user['password']);
										}
    
							$this->cldb->where('admin_id',$user_id);	
			  $insertResult = $this->cldb->update('p2p_admin_list', $arr_user);
								
			  if($insertResult){
				    
					
					/***********start of mail send*************/
							$product_type_id = "LendSocialDashboard"; $instance_id = "UserCreation"; //"Welcome Mail";
							$input_data['module_name'] = "user_creation";
							$insert_id = $this->cldb->insert_id();
							$input_data['user_id'] = !empty($user_id) ? $user_id : $insert_id;
						    $input_data['user_email'] = $arr_user['email'];
							$input_data['password'] = $this->input->post('password');
							$respa = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
							/****************end of mail send*******************/
							
				  $resp['status'] = 1;
				  $resp['msg'] = "User Updated Successfully: Update ID:".$user_id;
				  $resp['user_id'] = $user_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "User Updation Failed";
				  $resp['user_id'] = "";
				  return $resp;
			  }
	}
	
					public function add_user(){ // mail done
		
	$postParameters = array(
    'role_id',
    'fname',
    'lname',
    'email',
    'mobile',
    'password',
    'status',
    'partner_id'
);

$arr_user = array('status' => 1);

foreach ($postParameters as $param) {
    $arr_user[$param] = $this->input->post($param);
}

			$user_id = $this->input->post('admin_id');
			
    // Check if any required field is empty
  if (empty($arr_user['fname']) || empty($arr_user['lname'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['user_id'] = "";
    return $resp;
}								if($arr_user['password']==""){
										unset($arr_user['password']);
										}else{
											
									$arr_user['password'] = hash('sha512', $arr_user['password']);
										}
										
					$emailCount = $this->cldb->from('p2p_admin_list')->where('email', $arr_user['email'])->count_all_results();
					$mobileCount = $this->cldb->from('p2p_admin_list')->where('mobile', $arr_user['mobile'])->count_all_results();
						 $resp['status'] = 0;
					if($emailCount>0){
						$resp['msg'] = "Email ID Already Exist";
					}else if($mobileCount>0){
							$resp['msg'] = "Mobile Number Already Exist";
					}else{
    
							$this->cldb->where('admin_id',$user_id);	
							$insertResult = $this->cldb->insert('p2p_admin_list', $arr_user);
			  
								
			  if($insertResult){
				     $insert_id = $this->cldb->insert_id();
					 
					 /***********start of mail send*************/
							$product_type_id = "LendSocialDashboard"; $instance_id = "UserCreation"; //"Welcome Mail";
							$input_data['module_name'] = "user_creation";
							//$insert_id = $this->cldb->insert_id();
							$input_data['user_id'] = !empty($user_id) ? $user_id : $insert_id;
						    $input_data['user_email'] = $arr_user['email'];
							$input_data['password'] = $this->input->post('password');
							$respa = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
							/****************end of mail send*******************/
						//	return($respa);// die();
							
				  $resp['status'] = 1;
				  $resp['msg'] = "User Added Successfully"; //: Update ID:".$insert_id;
				  $resp['user_id'] = $insert_id;
						
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "User Creation Failed";
				  $resp['user_id'] = "";
				
			  }
					
					}
					 return $resp;
	}
	
	public function getAdminRoleList($where, $whereIn)
	{
		$this->cldb->select('*');
		$this->cldb->from('p2p_admin_role');
$this->cldb->limit($limit, $start);
$this->cldb->where('status',1);

		if(($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12)){
			$whereIn = array('id'=>array(11,12));
		}else{
				$whereIn = array('id'=>array(11,12));
				}

if($where!=""){
		$this->cldb->where($where);
		}
	if (!empty($whereIn)) {
        foreach ($whereIn as $column => $values) {
            $this->cldb->where_in($column, $values);
        }
	           }
		$res = $this->cldb->get();

		return $result = $res->result_array();
	}
	
	public function getLenderList($limit, $start)
	{
		$this->cldb->select('p2p_lender_list.*, a.Company_Name as partner_name');
		$this->cldb->from('p2p_lender_list');
		$this->cldb->join('invest_vendors a', 'p2p_lender_list.vendor_id=a.VID', 'left');
		$this->cldb->limit($limit, $start);
		$this->cldb->order_by("created_date", "desc");

				if(($this->partner_id!="") and ($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12)){
		$this->cldb->where("a.VID",$this->partner_id);
		}
		
		$res = $this->cldb->get();

		return $result = $res->result_array();
	}
	public function getCountLenderList()
	{
		$this->cldb->select('id');
		$this->cldb->from('p2p_lender_list');
		return $this->cldb->count_all_results();
	}
	
	
	public function getSchemeList($limit, $start,$where)
	{
		$this->cldb->select('invest_scheme_details.*, b.Company_name as partners_name');
		$this->cldb->from('invest_scheme_details');
		$this->cldb->join('invest_vendors as b', 'invest_scheme_details.Vendor_ID =b.VID', 'left');
		if($where!=""){
		$this->cldb->where($where);
		}
			

			if(($this->partner_id!="") and ($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12)){
		$this->cldb->where("b.VID",$this->partner_id);
		}

$this->cldb->limit($limit, $start);
		$res = $this->cldb->get();

		return $result = $res->result_array();
	}
	
	
	
	
	public function getCountSchemeList()
	{
		$this->cldb->select('id');
		$this->cldb->from('invest_scheme_details');
		return $this->cldb->count_all_results();
	}
	
	
	
					public function update_scheme(){ // mail done
		
	$arr_scheme = array(
    'Vendor_ID' => $this->input->post('Vendor_ID'),
    'scheme_descripiton' => $this->input->post('scheme_descripiton'),
	
	 'lender_management_fee_percentage' => $this->input->post('lender_management_fee_percentage'),
    'lender_management_fee_rupee' => $this->input->post('lender_management_fee_rupee'),
    'type_of_lender_management_fee' => $this->input->post('type_of_lender_management_fee'),
	
	 'step_up_value' => $this->input->post('step_up_value'),
    'diversification_factor_value' => $this->input->post('diversification_factor_value'),
    'minimum_loan_amount' => $this->input->post('minimum_loan_amount'),
	
    'borrower_classifier' => implode(",",$this->input->post('borrower_classifier')), // $this->input->post('borrower_classifier'),//
	'occuption_id' => $this->input->post('occuption_id'),
	
    'Scheme_Name' => $this->input->post('Scheme_Name'),
    'Min_Inv_Amount' => $this->input->post('Min_Inv_Amount'),
    'Max_Inv_Amount' => $this->input->post('Max_Inv_Amount'),
    'Aggregate_Amount' => $this->input->post('Aggregate_Amount'),
    'Lockin' => $this->input->post('Lockin'),
    'Cooling_Period' => $this->input->post('Cooling_Period'),
    'Interest_Rate' => $this->input->post('Interest_Rate'),
    'hike_rate' => $this->input->post('hike_rate'),
    'Interest_Type' => $this->input->post('Interest_Type'),
    'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
    'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
    'Lockin_Period' => $this->input->post('Lockin_Period'),
    'Tenure' => $this->input->post('Tenure'),
    'Auto_Redeem' => $this->input->post('Auto_Redeem'),
    'status' => $this->input->post('status'),
    'payout_type' => $this->input->post('payout_type'),
    'created_date' => date("Y-m-d H:i:s"),
			);

			$scheme_id = $this->input->post('id');
			
    // Check if any required field is empty
  if (empty($arr_scheme['Vendor_ID']) || $scheme_id=="") {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['scheme_id'] = $scheme_id;
    return $resp;
}								
    // scheme_details_id
							$this->cldb->where('id',$scheme_id);	
			  $insertResult = $this->cldb->update('invest_scheme_details', $arr_scheme);
								
			  if($insertResult){
				 			
													/***********start of mail send*************/
							$product_type_id = "LendSocialDashboard"; $instance_id = "Scheme Edit"; 
							$input_data['module_name'] = "scheme";
						//	$insert_id = $this->cldb->insert_id();
							$input_data['scheme_id'] = $scheme_id;
							$input_data['user_id'] = $this->session->userdata('user_id');
							
							$respa = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
							/****************end of mail send*******************/
						//	echo json_encode($respa); die();
				   $arr_scheme['scheme_details_id'] = $scheme_id;
				  $insertResult = $this->cldb->insert('invest_scheme_detail_logs', $arr_scheme);			
				  $resp['status'] = 1;
				  $resp['msg'] = "Scheme Updated Successfully: Update ID:".$scheme_id; //. "{$respa}";
				  $resp['scheme_id'] = $scheme_id;
				  $resp['mail_sent_status'] = $respa;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Scheme Updation Failed";
				  $resp['scheme_id'] = $scheme_id;
				   $resp['mail_sent_status'] = $respa;
				  return $resp;
			  }
	}
	
					public function add_scheme(){ // mail done
		
		$arr_scheme = array(
    'Vendor_ID' => $this->input->post('Vendor_ID'),
	 'scheme_descripiton' => $this->input->post('scheme_descripiton'),
	 
    'lender_management_fee_percentage' => $this->input->post('lender_management_fee_percentage'),
    'lender_management_fee_rupee' => $this->input->post('lender_management_fee_rupee'),
    'type_of_lender_management_fee' => $this->input->post('type_of_lender_management_fee'),
	
	 'step_up_value' => $this->input->post('step_up_value'),
    'diversification_factor_value' => $this->input->post('diversification_factor_value'),
    'minimum_loan_amount' => $this->input->post('minimum_loan_amount'),
	
	'borrower_classifier' => implode(",",$this->input->post('borrower_classifier')), // $this->input->post('borrower_classifier'),//
	'occuption_id' => $this->input->post('occuption_id'),
	
    'Scheme_Name' => $this->input->post('Scheme_Name'),
    'Min_Inv_Amount' => $this->input->post('Min_Inv_Amount'),
    'Max_Inv_Amount' => $this->input->post('Max_Inv_Amount'),
    'Aggregate_Amount' => $this->input->post('Aggregate_Amount'),
    'Lockin' => $this->input->post('Lockin'),
    'Cooling_Period' => $this->input->post('Cooling_Period'),
    'Interest_Rate' => $this->input->post('Interest_Rate'),
    'hike_rate' => $this->input->post('hike_rate'),
    'Interest_Type' => $this->input->post('Interest_Type'),
    'Withrawl_Anytime' => $this->input->post('Withrawl_Anytime'),
    'Pre_Mat_Rate' => $this->input->post('Pre_Mat_Rate'),
    'Lockin_Period' => $this->input->post('Lockin_Period'),
    'Tenure' => $this->input->post('Tenure'),
    'Auto_Redeem' => $this->input->post('Auto_Redeem'),
    'status' => $this->input->post('status'),
    'payout_type' => $this->input->post('payout_type'),
    'created_date' => date("Y-m-d H:i:s"),
);

			$scheme_id = $this->input->post('id');
			
    // Check if any required field is empty
  if (empty($arr_scheme['Vendor_ID']) || empty($arr_scheme['Scheme_Name'])) {
    $resp['status'] = 2;
    $resp['msg'] = "Some fields are empty";
    $resp['scheme_id'] = "";
    return $resp;
}								
								
			  $insertResult = $this->cldb->insert('invest_scheme_details', $arr_scheme);
			  
								
			  if($insertResult){
				     $insert_id = $this->cldb->insert_id();
					 
					 
					 	/***********start of mail send*************/
							$product_type_id = "LendSocialDashboard"; $instance_id = "Scheme Edit"; 
							$input_data['module_name'] = "scheme";
							//$insert_id = $this->cldb->insert_id();
							$input_data['scheme_id'] = !empty($scheme_id) ? $scheme_id : $insert_id;
							$input_data['user_id'] = $this->session->userdata('user_id');
							
							$respa = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
							/****************end of mail send*******************/
							
				  $resp['status'] = 1;
				  $resp['msg'] = "Scheme Added Successfully: Update ID:".$insert_id;//."{$respa}";
				  $resp['scheme_id'] = $insert_id;
				   $resp['mail_sent_status'] = $respa;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Scheme Addition Failed";
				  $resp['scheme_id'] = "";
				   $resp['mail_sent_status'] = $respa;
				  return $resp;
			  }
	}
	
		public function getRedemptionList($limit, $start,$status,$vender_id)
	{
		$this->cldb->select('a.*, a.redemption_status,
  (CASE
            WHEN a.redemption_status = 4 THEN "Redeemed"
            WHEN a.redemption_status = 2 THEN "Under Process"
            WHEN a.redemption_status = 5 THEN "Generate Bank File Pending"
            WHEN a.redemption_status = 1 THEN "Approval Pending"
            ELSE "Unknown Status" END)
         AS redemption_status_name,
,
 b.name as lender_name, b.mobile as lender_mobile, c.account_no as lender_account_number, d.Scheme_Name as scheme_name, e.Company_Name as partner_name, e.Address as address');
		$this->cldb->from('p2p_lender_investment as a');
		$this->cldb->join('p2p_lender_list as b', 'a.lender_id =b.lender_id', 'LEFT');
		$this->cldb->join('p2p_borrower_bank_res AS c', 'c.lender_id = b.user_id', 'LEFT');
				$this->cldb->join('invest_scheme_details as d', 'a.scheme_id =d.id', 'LEFT');
				$this->cldb->join('invest_vendors as e', 'b.vendor_id =e.VID', 'LEFT');
		 $this->cldb->where_in('a.redemption_status' , $status);
				if(($this->partner_id!="") and ($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12)){
		$this->cldb->where("b.vendor_id",$this->partner_id);
		}

		// dated: 2023-dec-07 $this->cldb->where('b.vendor_id',$vender_id);
	//	$this->cldb->limit($limit, $start);
		$this->cldb->GROUP_BY("a.reinvestment_id");
		$this->cldb->ORDER_BY('a.reinvestment_id', 'desc');
		$res = $this->cldb->get();
		
		return $result = $res->result_array();
	}
	
		public function getRedemptionListV2($limit, $start,$status,$vender_id)
	{		
		// $this->cldb->select('f.*, f.id as lendsocial_lender_payout_schedule_table_id, a.*, a.id as p2p_lender_investment_table_id, a.redemption_status,
		$this->cldb->select('f.id as lendsocial_lender_payout_schedule_table_id, f.*, a.*, a.redemption_status,
       (CASE
            WHEN f.redemption_status = 4 THEN "Redeemed"
            WHEN f.redemption_status = 2 THEN "Under Process"
            WHEN f.redemption_status = 5 THEN "Generate Bank File Pending"
            WHEN f.redemption_status = 1 THEN "Approval Pending"
			WHEN f.redemption_status = 0 THEN "Approval Pending V2"
            ELSE "Unknown Status" 
		END)
         AS redemption_status_name, f.api_response, b.name as lender_name, b.mobile as lender_mobile, c.account_no as lender_account_number, d.Scheme_Name as scheme_name, e.Company_Name as partner_name, e.Address as address');
		$this->cldb->from('p2p_lender_investment as a');
		$this->cldb->join('p2p_lender_list as b', 'a.lender_id =b.lender_id', 'LEFT');
		$this->cldb->join('p2p_borrower_bank_res AS c', 'c.lender_id = b.user_id', 'LEFT');
				$this->cldb->join('invest_scheme_details as d', 'a.scheme_id =d.id', 'LEFT');
				$this->cldb->join('invest_vendors as e', 'b.vendor_id =e.VID', 'LEFT');
				$this->cldb->join('lendsocial_lender_payout_schedule as f', 'f.investment_No =a.investment_No', '');
				
		 $this->cldb->where('f.payout_date<=' , date("Y-m-d"));
		 if($status==0){
		 $this->cldb->where('f.payout_status' , 0);
		 }
      //   $this->cldb->where_not_in('f.redemption_status', array(5, 2, 4));
         $this->cldb->where_in('f.redemption_status', $status);


				if(($this->partner_id!="") and ($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12)){
		$this->cldb->where("b.vendor_id",$this->partner_id);
		}
		$this->cldb->where('f.investment_no IS NOT NULL', NULL);
		//$this->cldb->limit(1);
		// dated: 2023-dec-07 $this->cldb->where('b.vendor_id',$vender_id);
	//	$this->cldb->limit($limit, $start);
	 //	$this->cldb->GROUP_BY("a.reinvestment_id");
		$this->cldb->ORDER_BY('a.reinvestment_id', 'desc');
		$res = $this->cldb->get();

		return $result = $res->result_array();
	}
	
			public function generate_bank_file_excel_v2($ids)
				{
					$idsArray = explode(",", urldecode($ids));

					// Remove single quotes from each element in the array
					$idsArray = array_map('trim', $idsArray);

					// You may want to remove empty values if any
					$idsArray = array_filter($idsArray);
					
					$this->cldb->select('
					f.payout_type, f.payment_type, f.payout_amount, 
			 CONCAT("`","'.ANTWORKS_BANK_AC.'") as Debited_Account_No,
			 c.ifsc_code as IFSC_CODE,
			  CONCAT("`",c.account_no) as Benificiary_AC_No,
			 b.name as Benificiary_Name,
			 "" as Sender_nd_Receiver_Information,
					"Antworks P2P" as Sender_Name
			
			 '
			 );
					
					$this->cldb->from('p2p_lender_investment as a');
					$this->cldb->join('p2p_lender_list as b', 'a.lender_id =b.lender_id', 'LEFT');
					$this->cldb->join('p2p_borrower_bank_res AS c', 'c.lender_id = b.user_id', 'LEFT');
							$this->cldb->join('invest_scheme_details as d', 'a.scheme_id =d.id', 'LEFT');
							$this->cldb->join('invest_vendors as e', 'b.vendor_id =e.VID', 'LEFT');
							$this->cldb->join('lendsocial_lender_payout_schedule as f', 'f.investment_No =a.investment_No', 'LEFT');
					
					 $this->cldb->where_in('f.id',$idsArray);
					$this->cldb->GROUP_BY("f.id");
					//$this->cldb->ORDER_BY('a.reinvestment_id', 'desc');
					$res = $this->cldb->get();

					return $res; // $result = $res->result_array();
				}
				
				
					public function update_investment_status_v2($status,$ids,$remarks,$payment_type,$investment_no,$api_response,$batch_id){
		$current_time = date('Y-m-d H:i:s');
		$dataRslt = array(
		"status"=>0,
		"msg"=>"Missing Paramter"
		);
	//	echo $ids."--".$status."--<br>";
			$data_entry_id = $this->session->userdata('user_id');
			if($status!="" && $ids!=""){ // && $payment_type!=""
				
				
				$idsArray = explode(",", urldecode($ids));

				// Remove single quotes from each element in the array
				$idsArray = array_map('trim', $idsArray);

				// You may want to remove empty values if any
				$idsArray = array_filter($idsArray);

				
			
			switch($status){
				case "5": // 5->"Generate Bank File pending"; 
				$arrayData['batch_id'] = $batch_id;
				$arrayData['redemption_status'] = $status;
				$arrayData['approved_by'] = $data_entry_id;
				$arrayData['approved_by_data_entry_time'] = $current_time;
				break;
				
				case "2":  // 2->"processing pending";  
				$arrayData['api_response'] = $api_response;
				$arrayData['batch_id'] = $batch_id;
				$arrayData['redemption_status'] = $status;
				$arrayData['generated_bank_file_by'] = $data_entry_id;
				$arrayData['generated_bank_file_by_data_entry_time'] = $current_time;
				break;
				
				case "4": // 4->"redeemed" 
				$arrayData['api_response'] = $api_response;
				$arrayData['batch_id'] = $batch_id;
				$arrayData['redemption_status'] = $status;
				$arrayData['processed_by'] = $data_entry_id;
				$arrayData['processed_by_remarks'] = $remarks;
				$arrayData['processed_by_data_entry_time'] = $current_time;
				break;

			}
					$this->cldb->where_in('id', $idsArray);
					if($status==4){
						$arrayData['payout_status'] = 1;
					}
					$this->cldb->update('lendsocial_lender_payout_schedule',$arrayData); // lendsocial_lender_payout_schedule
					
					if($payment_type=="InterestAndPrinciple"){
						
						$this->cldb->where_in('investment_No', $investment_no);
						$this->cldb->update('p2p_lender_investment',$arrayData); // p2p_lender_investment
					}
			
				
				
					if ($this->cldb->affected_rows() > 0) {
				$dataRslt = array(
		"status"=>1,
		"msg"=>"Investment Status Updated Successfully"//.$this->cldb->last_query()
		);
			}else{
				$dataRslt = array(
		"status"=>0,
		"msg"=>"Error While Processing"//.$this->cldb-last_query()
		);
			}
			
			}
		
	//	$dataRslt['lastquery'] = $this->cldb->last_query();
		$dataRslt['data'] = $ids;
		return json_encode($dataRslt);
	}
	
	public function getCountRedemptionListStatus($status,$vender_id)
	{
		$this->cldb->select('a.id');
		$this->cldb->from('p2p_lender_investment as a');
		$this->cldb->join('p2p_lender_list as b', 'a.lender_id =b.lender_id', 'LEFT');
		 $this->cldb->where_in('a.redemption_status' , $status);
		  $this->cldb->where('b.vendor_id',$vender_id);
		return $this->cldb->count_all_results();
	}
	
	public function getCountRedemptionListStatusV2($status,$vender_id)
	{
		$this->cldb->select('a.id');
		$this->cldb->from('p2p_lender_investment as a');
		$this->cldb->join('p2p_lender_list as b', 'a.lender_id =b.lender_id', 'LEFT');
		$this->cldb->join('lendsocial_lender_payout_schedule as f', 'f.investment_No =a.investment_No', 'LEFT');
		 $this->cldb->where_in('f.redemption_status' , $status);
		  $this->cldb->where('b.vendor_id',$vender_id);
		return $this->cldb->count_all_results();
	}
	
	
	public function update_investment_status($status,$ids,$remarks){
		$current_time = date('Y-m-d H:i:s');
		$dataRslt = array(
		"status"=>0,
		"msg"=>"Missing Paramter"
		);
			$data_entry_id = $this->session->userdata('user_id');
			if($status!="" && $ids!=""){
				
				
				$idsArray = explode(",", urldecode($ids));

				// Remove single quotes from each element in the array
				$idsArray = array_map('trim', $idsArray);

				// You may want to remove empty values if any
				$idsArray = array_filter($idsArray);

				$this->cldb->where_in('reinvestment_id', $idsArray);
			
			switch($status){
				case "5": // 5->"Generate Bank File pending"; 
				$this->cldb->set('redemption_status', $status);
				$this->cldb->set('approved_by', $data_entry_id);
				$this->cldb->set('approved_by_data_entry_time', $current_time);
				break;
				
				case "2":  // 2->"processing pending";  
				$this->cldb->set('redemption_status', $status);
				$this->cldb->set('generated_bank_file_by', $data_entry_id);
				$this->cldb->set('generated_bank_file_by_data_entry_time', $current_time);
				break;
				
				case "4": // 4->"redeemed" 
				$this->cldb->set('redemption_status', $status);
				$this->cldb->set('processed_by', $data_entry_id);
				$this->cldb->set('processed_by_remarks', $remarks);
				$this->cldb->set('processed_by_data_entry_time', $current_time);
				break;

			}
			
			
				$this->cldb->update('p2p_lender_investment');
				
					if ($this->cldb->affected_rows() > 0) {
				$dataRslt = array(
		"status"=>1,
		"msg"=>"Investment Status Updated Successfully"
		);
			}else{
				$dataRslt = array(
		"status"=>0,
		"msg"=>"Error While Processing"
		);
			}
			
			}
		
	//	$dataRslt['lastquery'] = $this->cldb->last_query();
		$dataRslt['data'] = $ids;
		return json_encode($dataRslt);
	}
	
	
		public function getTicketList($limit, $start)
	{
		$this->cldb->select('tickets.*, b.fname as partner_name_first, b.lname as partner_name_last');
		$this->cldb->from('tickets');
		$this->cldb->join("p2p_admin_list b", "tickets.user_id=b.admin_id", "LEFT");
$this->cldb->limit($limit, $start);
		
			if($this->session->userdata('role_id')==11 OR  $this->session->userdata('role_id') ==12){
		$this->cldb->where("user_id", $this->session->userdata('user_id'));
		}
		$res = $this->cldb->get();
		return $result = $res->result_array();
	}
	
	
	public function getSingleTicket($ticket_id)
	{
		$this->cldb->select('*');
		$this->cldb->from('tickets');
		$this->cldb->where('ticket_id', $ticket_id);
		$res = $this->cldb->get();

		return $result = $res->result_array();
	}
	
	public function getCountTicketList()
	{
		$this->cldb->select('id');
		$this->cldb->from('tickets');
		return $this->cldb->count_all_results();
	}
	

	public function insert_raise_ticket(){
		
		$title = $this->input->post('title');
    $description = $this->input->post('description');
     $status = $this->input->post('status');
    $priority = $this->input->post('priority');

    // Check if any required field is empty
    if ($title=="" || $description=="" || $priority=="") {
        $resp['status'] = 2;
        $resp['msg'] = "Some fields are empty";
		return $resp;
      
    }

    // Proceed to insert data into the database
    $arr_ticket = array(
        'title' => $title,
        'description' => $description,
        'status' => $status,
        'priority' => $priority,
		'user_id' => $this->session->userdata('user_id'),
			);

		
			  $insertResult = $this->cldb->insert('tickets', $arr_ticket);
			  if($insertResult){
				    $insert_id = $this->cldb->insert_id();
				  $resp['status'] = 1;
				  $resp['msg'] = "Ticket Raised Successfully. Ticket ID: #".$insert_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Ticket Raised Failed";
				  return $resp;
			  }
	}
	
	public function comment_ticket(){
		
		$ticket_id = $this->input->post('ticket_id');
    $comment_text = $this->input->post('comment_text');
	 $user_id = $this->session->userdata('user_id'); //$this->input->post('user_id');
	 $status = $this->input->post('status');
  
    // Check if any required field is empty
    if ($ticket_id=="" || $comment_text=="") {
        $resp['status'] = 2;
		$resp['ticket_id'] = $ticket_id;
        $resp['msg'] = "Some fields are empty";
		return $resp;
      
    }

    // Proceed to insert data into the database
    $arr_ticket = array(
        'ticket_id' => $ticket_id,
        'user_id' => $user_id,
        'comment_text' => $comment_text,
			);

		
			  $insertResult = $this->cldb->insert('ticket_comments', $arr_ticket);
			  if($insertResult){
				  
					/*******start of lead update status********/
			$this->cldb->set('status', $status);
			$this->cldb->where('ticket_id',$ticket_id);
			$this->cldb->update('tickets');
			//	echo $this->cldb->last_query(); die();
						/***************end of lead update status*************/
						
				    $insert_id = $this->cldb->insert_id();
				  $resp['status'] = 1;
				  $resp['msg'] = "Replied";
				  $resp['ticket_id'] = $ticket_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Error, while Replying";
				   $resp['ticket_id'] = $ticket_id;
				  return $resp;
			  }
	}
	
		public function getTicketCommentList($ticket_id)
	{
$this->cldb->select('b.comment_id, b.user_id, b.comment_text, CASE WHEN b.user_id = "' .$this->session->userdata('user_id'). '" THEN "right" ELSE "left" END as msg_type', false);
		$this->cldb->from('tickets as a');
		$this->cldb->join('ticket_comments as b ', 'a.ticket_id=b.ticket_id', 'JOIN');
		$this->cldb->where('b.ticket_id', $ticket_id);
		$res = $this->cldb->get();
		//  echo $this->cldb->last_query();
		return $result = $res->result_array();
	}
	
	
	public function getNoOfBorrower($partner_id){
		 $count=0;
        if (!empty($partner_id)) {
        $this->db->where('vendor_id', $partner_id);
		}
        $this->db->from('p2p_borrowers_list');
        $count = $this->db->count_all_results();
		return $count;
		//echo "<pre>";print_r($count);die();
		
	}
	
	public function getBorrowerAmount($partner_id) {
    
    $sum = 0;

   
    
        
        $this->db->select_sum('approved_loan_amount');
        $this->db->from('p2p_loan_list');
        
 
        $query = $this->db->get();
        $result = $query->row();


        if ($result) {
            $sum = $result->approved_loan_amount;
        }
	//echo "<pre>";print_r($count);die();
    return $sum;
}

	
	
	public function getLenderDetailsByLenderId($lender_id){ // LR100020
		
		$this->cldb->select('a.lender_id, a.name, a.email, a.mobile as contact, "customer" as type, b.bank_name, "bank_account" as account_type, b.ifsc_code as ifsc, b.account_number');
		$this->cldb->from('p2p_lender_list a');
		$this->cldb->join('p2p_borrower_bank_details b', 'a.user_id = b.lender_id');
		$this->cldb->where('a.lender_id', $lender_id);

		$query = $this->cldb->get();
		$result = $query->row_array(); // Use result_array() for fetching the result as an associative array
		return $result;

	}
	
public function getMasterRazorpayPayoutContactByLenderId($lender_id) {
    $this->cldb->select('a.*');
    $this->cldb->from('master_razorpay_payout_contact a');
    $this->cldb->where('a.lender_id', $lender_id);

    $query = $this->cldb->get();
    $result = $query->row_array(); // Fetch a single row as an associative array

    // Return true if the result is not empty, false otherwise
			
    return $result;
}

	
	public function add_razorpayx_create_contact($arr_data){
		
	//	'user_id' => $this->session->userdata('user_id'),

		
			  $insertResult = $this->cldb->insert('master_razorpay_payout_contact ', $arr_data);
			  if($insertResult){
				    $insert_id = $this->cldb->insert_id();
				  $resp['status'] = 1;
				  $resp['msg'] = "Razorpay Payout Contact Created: #".$insert_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Razorpay Payout Contact Creation Failed";
				  return $resp;
			  }
	}
	
	
	public function add_razorPayxPerform_razorpay_payout($arr_data){
		
		  $insertResult = $this->cldb->insert('trans_razorpay_payouts ', $arr_data);
			  if($insertResult){
				    $insert_id = $this->cldb->insert_id();
				  $resp['status'] = 1;
				  $resp['msg'] = "Razorpay Payout Payment Insertion In DB Successfully: #".$insert_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Razorpay Payout Payment Insertion In Failed";
				  return $resp;
			  }
	}
	

}

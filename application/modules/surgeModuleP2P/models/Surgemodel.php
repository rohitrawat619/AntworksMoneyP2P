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

			$comma_separated_ids = implode(',', $ids);
			//echo $comma_separated_ids; // Output: 10,11,17,18,19
			if($comma_separated_ids==""){
				$comma_separated_ids = "11111123456789,234567";
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
	
				public function update_user(){
		
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
							$input_data['scheme_id'] = $scheme_id;
							$input_data['user_id'] = $this->session->userdata('user_id');
							$input_data['mobileLender'] =  "9213855703";
							$input_data['mobileBorrower'] =  "9213855703";
							$input_data['partner_id'] = "1";  
							
							$input_data['user_email'] = $arr_user['email'];
							$input_data['password'] = $this->input->post('password');
							$resp = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
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
	
					public function add_user(){
		
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
	
	
	
					public function update_scheme(){
		
	$arr_scheme = array(
    'Vendor_ID' => $this->input->post('Vendor_ID'),
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
				  $arr_scheme['scheme_details_id'] = $scheme_id;
							 $insertResult = $this->cldb->insert('invest_scheme_detail_logs', $arr_scheme);
							 
							 
							 
							 
							/***********start of mail send*************/
							$product_type_id = "LendSocialDashboard"; $instance_id = "Scheme Edit"; //"Welcome Mail";
							$input_data['scheme_id'] = $scheme_id;
							$input_data['user_id'] = $this->session->userdata('user_id');
							$input_data['mobileLender'] =  "9213855703";
							$input_data['mobileBorrower'] =  "9213855703";
							$input_data['partner_id'] = "1";  
							$resp = $this->LendSocialCommunicationModel->sendEmail($product_type_id, $instance_id,$input_data);
							/****************end of mail send*******************/
							
							
				  $resp['status'] = 1;
				  $resp['msg'] = "Scheme Updated Successfully: Update ID:";
				  $resp['scheme_id'] = $scheme_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Scheme Updation Failed";
				  $resp['scheme_id'] = $scheme_id;
				  return $resp;
			  }
	}
	
					public function add_scheme(){
		
		$arr_scheme = array(
    'Vendor_ID' => $this->input->post('Vendor_ID'),
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
				  $resp['status'] = 1;
				  $resp['msg'] = "Scheme Added Successfully: Update ID:".$insert_id;
				  $resp['scheme_id'] = $insert_id;
				  return $resp;
			  }else{
				    $resp['status'] = 0;
				  $resp['msg'] = "Scheme Addition Failed";
				  $resp['scheme_id'] = "";
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
	
	
			public function generate_bank_file_excel($ids)
				{
					$idsArray = explode(",", urldecode($ids));

					// Remove single quotes from each element in the array
					$idsArray = array_map('trim', $idsArray);

					// You may want to remove empty values if any
					$idsArray = array_filter($idsArray);
					
					$this->cldb->select('
					a.amount, 
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
					
					 $this->cldb->where_in('a.reinvestment_id',$idsArray);
					$this->cldb->GROUP_BY("a.reinvestment_id");
					$this->cldb->ORDER_BY('a.reinvestment_id', 'desc');
					$res = $this->cldb->get();

					return $res; // $result = $res->result_array();
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

		/*
	public function get_count_premiumplanuserlist()
	{
		$this->db_money_money->select('id');
		$this->db_money_money->from('ant_all_leads');
		$this->db_money_money->where('assigned_to', $this->session->userdata('user_id'));
		$this->db_money_money->where('product_type', 10);
		return $this->db_money_money->count_all_results();
	}

	public function premiumplanuserlist($limit, $start)
	{

		$this->db_money_money->select('*');
		$this->db_money_money->from('ant_all_leads');
		$this->db_money_money->where('assigned_to', $this->session->userdata('user_id'));
		$this->db_money_money->limit($limit, $start);
		$this->db_money_money->order_by("id", "desc");
		$this->db_money_money->where('product_type', 10);
		$query = $this->db_money_money->get();
		if ($this->db_money_money->affected_rows() > 0) {
			return $result = $query->result_array();
		} else {
			return false;
		}

	}

	function getcompany($str)
	{
		$this->db_money_money->select("concat(company_name, '_', company_category) as id, company_name as text");
		$this->db_money_money->like('company_name', $str);
		$query = $this->db_money_money->get('ant_crm_company_list');
		if ($this->db_money_money->affected_rows() > 0) {
			$result = $query->result();
		} else {
			$result[] = (object)array(
				'id' => '99999',
				'text' => 'Others',
			);
		}
		return $result;
	}

	function fetch_state()
	{
		$this->db_money_money->order_by("state_name", "ASC");
		$query = $this->db_money_money->get("state_master");
		return $query->result();
	}


	public function userdetailList($id)
	{
		$this->db_money_money->select('all.*,sou.name');
		$this->db_money_money->from('ant_all_leads as all');
		$this->db_money_money->join('ant_source as sou', 'sou.id =all.source_of_lead ', 'left');
		$this->db_money_money->where('all.id', $id);
		$this->db_money_money->where('all.product_type', 10);
		$query = $this->db_money_money->get();
		if ($this->db_money_money->affected_rows() > 0) {
			return $result = $query->row_array();
		} else {
			return false;
		}
	}


	public function getPreviouscomment($lead_id)
	{

		$this->db_money_money->select('comment,created_date');
		$this->db_money_money->from('history_ant_all_leads');
		$this->db_money_money->where('lead_id', $lead_id);
		$this->db_money_money->limit(4);
		$this->db_money_money->order_by('id', 'desc');
		$query = $this->db_money_money->get();

		if ($this->db_money_money->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}
	
    public function getPaymentDetails($lead_id)
	{

		$this->db_money_money->select('*');
		$this->db_money_money->from('p2p_res_borrower_payment');
		$this->db_money_money->where('lead_id', $lead_id);
		$this->db_money_money->limit(25);
		$this->db_money_money->order_by('id', 'desc');
		$query = $this->db_money_money->get();

		if ($this->db_money_money->affected_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}

public function getLeadData($id){ // 
	/*******************
					$query = $this->db_money_money->select('*')->get_where('ant_all_leads',array('id' => $id, 'assigned_to'=> $this->session->userdata('user_id')));
			$resp['status'] = count($query->result());
			$resp['data'] = $this->db_money_money->last_query();//$query->result();
		return $resp;


			  /*********************
}
	public function userdetailUpdate($id)
	{
		$company_name = '';
		$company_category_code = '';
		if ($this->input->post('reminder_date') == '') {

		} else {
			$reminder_date = date('Y-m-d H:i:s', strtotime($this->input->post('reminder_date')));
		}
        if ($this->input->post('company_name') != '')
		{
			$company = explode('_', $this->input->post('company_name'));
			$company_name = $company[0];
			$company_category_code = $company[1];
		}

		$arr_update = array(
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'email' => $this->input->post('email'),
			'alternatemobile' => $this->input->post('alternatemobile'),
			'loan_amount' => $this->input->post('loan_amount'),
			'state' => $this->input->post('state'),
			'city' => $this->input->post('city'),
			'address1' => $this->input->post('address1'),
			'pin' => $this->input->post('pin'),
			'dob' => $this->input->post('dob'),
			'residence_type' => $this->input->post('residence_type'),
			'year_in_curr_residence' => $this->input->post('year_in_curr_residence') ?? '',
			'is_parmanent_address' => $this->input->post('is_parmanent_address') ?? '',
			'pan' => $this->input->post('pan'),
			'cibil_score' => $this->input->post('cibil_score'),
			'occupation' => $this->input->post('occupation'),
			'new_to_cibil' => $this->input->post('new_to_cibil'),
			'company_type' => $this->input->post('company_type'),
			'company_name' => $company_name,
			'campany_category' => $company_category_code,
			'itr_form_16_status' => $this->input->post('itr_form_16_status'),
			'mode_of_salary' => $this->input->post('mode_of_salary'),
			'working_since' => $this->input->post('working_since'),
			'designation' => $this->input->post('designation'),
			'salary_account' => $this->input->post('salary_account'),
			'profession_type' => $this->input->post('profession_type'),
			'experiance' => $this->input->post('experiance'),
			'last2yearitramount' => $this->input->post('last2yearitramount'),
			'turnover1' => $this->input->post('turnover1'),
			'turnover2' => $this->input->post('turnover2'),
			'office_ownership' => $this->input->post('office_ownership'),
			'audit_done' => $this->input->post('audit_done'),
			'officeaddress' => $this->input->post('officeaddress'),
			'industry_type' => $this->input->post('industry_type'),
			'persuing' => $this->input->post('persuing'),
			'educational_institute_name' => $this->input->post('educational_institute_name'),
			'income' => $this->input->post('income'),
			'outstanding_loan_details' => $this->input->post('outstanding_loan_details'),
			'brief_outstanding_loan_details' => $this->input->post('brief_outstanding_loan_details'),
			'reminder_date' => $reminder_date,
			'status' => $this->input->post('status'),
			 'last_update_lead_time' => date('Y-m-d H:i:s'),
		);
		if($this->input->post('status')=='2'){
			$arr_update['hot_lead_status'] = $this->input->post('hot_lead_status');
		}
		$this->db_money_money->where('id', $this->input->post('id'));
		$this->db_money_money->update('ant_all_leads', $arr_update);

		$this->db_money_money->where('id', $this->input->post('id'));
		$this->db_money_money->set('lead_counter', 'lead_counter + 1', false);
		$this->db_money_money->update('ant_all_leads');

		if ($this->input->post('status') == 3 || $this->input->post('status') == 7) {
			$this->db_money_money->where('id', $this->input->post('id'));
			$this->db_money_money->set('assigned_to', '0');
			//$this->db_money_money->set('last_update_lead_time', date('Y-m-d H:i:s'));
			$this->db_money_money->update('ant_all_leads');
		}

			/*******************
					$query = $this->db_money_money->select('lead_counter,created_date,last_update_lead_time')->limit(1)->get_where('ant_all_leads',array('id' => $this->input->post('id')));
$result = $query->row_array();
$lead_counter_value = $result['lead_counter'];
$lead_created_date = $result['created_date'];
$last_update_lead_time = $result['last_update_lead_time'];

			  /*********************

		///make history
		$arr_history = array(
			'lead_id' => $this->input->post('id'),
			'assigned_to' => $this->session->userdata('user_id'),
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'email' => $this->input->post('email'),
			'loan_amount' => $this->input->post('loan_amount'),
			'product_type' => $this->input->post('product_type'),
			'comment' => $this->input->post('comment'),
			'status' => $this->input->post('status'),
			'reminder_date' => $this->input->post('reminder_date'),
			'lead_open_time' => $this->input->post('lead_open_time'),
			'lead_counter' => $lead_counter_value,
			'lead_created_date' => $lead_created_date,
			'leadUpdateType' => 'normal PP',
			'last_update_lead_time' => $last_update_lead_time,
		);
		$this->db_money_money->insert('history_ant_all_leads', $arr_history);


		$company_category_list = array(
			'CAT A',
			'CAT B',
			'CAT C',
			'CAT GOVT',
			'CATGA',
			'CATGB',
			'CATGC',
			'GOVT',
			'SCATA',
			'Super A',

		);
		if (in_array($company_category_code, $company_category_list))
		{
			//Insert here for personal loan
			$this->db_money_money->get_where('ant_all_leads', array('mobile' => $this->input->post('mobile'), 'product_type' => '27'));
			if ($this->db_money_money->affected_rows() <= 0)
			{
				$arr_personal_loan = array(
					'fname' => $this->input->post('fname') ?? '',
					'lname' => $this->input->post('lname') ?? '',
					'email' => $this->input->post('email') ?? '',
					'mobile' => $this->input->post('mobile') ?? '',
					'alternatemobile' => $this->input->post('alternatemobile') ?? '',
					'loan_amount' => $this->input->post('loan_amount') ?? '',
					'state' => $this->input->post('state') ?? '',
					'city' => $this->input->post('city') ?? '',
					'address1' => $this->input->post('address1') ?? '',
					'pin' => $this->input->post('pin') ?? '',
					'dob' => $this->input->post('dob') ?? '',
					'residence_type' => $this->input->post('residence_type') ?? '',
					'year_in_curr_residence' => $this->input->post('year_in_curr_residence') ?? '',
					'is_parmanent_address' => $this->input->post('is_parmanent_address') ?? '',
					'pan' => $this->input->post('pan') ?? '',
					'cibil_score' => $this->input->post('cibil_score') ?? '',
					'occupation' => $this->input->post('occupation') ?? '',
					'product_type' => '27',
					'new_to_cibil' => $this->input->post('new_to_cibil') ?? '',
					'company_type' => $this->input->post('company_type') ?? '',
					'company_name' => $company_name,
					'campany_category' => $company_category_code,
					'itr_form_16_status' => $this->input->post('itr_form_16_status') ?? '',
					'mode_of_salary' => $this->input->post('mode_of_salary') ?? '',
					'working_since' => $this->input->post('working_since') ?? '',
					'designation' => $this->input->post('designation') ?? '',
					'salary_account' => $this->input->post('salary_account') ?? '',
					'profession_type' => $this->input->post('profession_type') ?? '',
					'experiance' => $this->input->post('experiance') ?? '',
					'last2yearitramount' => $this->input->post('last2yearitramount') ?? '',
					'turnover1' => $this->input->post('turnover1') ?? '',
					'turnover2' => $this->input->post('turnover2') ?? '',
					'office_ownership' => $this->input->post('office_ownership') ?? '',
					'audit_done' => $this->input->post('audit_done') ?? '',
					'officeaddress' => $this->input->post('officeaddress') ?? '',
					'industry_type' => $this->input->post('industry_type') ?? '',
					'persuing' => $this->input->post('persuing') ?? '',
					'educational_institute_name' => $this->input->post('educational_institute_name') ?? '',
					'income' => $this->input->post('income') ?? '',
					'outstanding_loan_details' => $this->input->post('outstanding_loan_details') ?? '',
					'brief_outstanding_loan_details' => $this->input->post('brief_outstanding_loan_details') ?? '',
					'source_of_lead' => 21,
				);
				$this->db_money_money->insert('ant_all_leads', $arr_personal_loan);
			}
		}
		
	if ($this->input->post('cibil_score') > 649)
		{
			//Insert here for personal loan
			$this->db_money->get_where('ant_all_leads', array('mobile' => $this->input->post('mobile'), 'product_type' => '27'));
			if ($this->db_money->affected_rows() <= 0)
			{
				$arr_cibil_personal_loan = array(
					'fname' => $this->input->post('fname') ?? '',
					'email' => $this->input->post('email') ?? '',
					'mobile' => $this->input->post('mobile') ?? '',
					'dob' => $this->input->post('dob') ?? '',
					'pan' => $this->input->post('pan') ?? '',
					'product_type' => '27',
					'cibil_score' => $this->input->post('cibil_score'),
					'company_type' => $this->input->post('company_type') ?? '',
					'company_name' => $company_name,
					'campany_category' => $company_category_code,
					'source_of_lead' => 23,
				);
				$this->db_money->insert('ant_all_leads', $arr_cibil_personal_loan);
				//echo $this->db_money->last_query();exit;
			}
		}





		return array(
			'status' => 1,
            'file_experian' => $file_experian,
			'msg' => 'User update successfully',
		);

	
	}


	public function hotLeadUserDetailUpdate($id)
	{		// print_r($this->input->post()); die();
		
		$arr_update = array(
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'email' => $this->input->post('email'),
			'alternatemobile' => $this->input->post('alternatemobile'),
			'loan_amount' => $this->input->post('loan_amount'),
			'state' => $this->input->post('state'),
			'city' => $this->input->post('city'),
			'address1' => $this->input->post('address1'),
			'pin' => $this->input->post('pin'),
			'dob' => $this->input->post('dob'),
			'residence_type' => $this->input->post('residence_type'),
			'year_in_curr_residence' => $this->input->post('year_in_curr_residence') ?? '',
			'is_parmanent_address' => $this->input->post('is_parmanent_address') ?? '',
			'pan' => $this->input->post('pan'),
			'cibil_score' => $this->input->post('cibil_score'),
			'occupation' => $this->input->post('occupation'),
			'new_to_cibil' => $this->input->post('new_to_cibil'),
			'company_type' => $this->input->post('company_type'),
			'company_name' => $this->input->post('company_name'),
			'itr_form_16_status' => $this->input->post('itr_form_16_status'),
			'mode_of_salary' => $this->input->post('mode_of_salary'),
			'working_since' => $this->input->post('working_since'),
			'designation' => $this->input->post('designation'),
			'salary_account' => $this->input->post('salary_account'),
			'profession_type' => $this->input->post('profession_type'),
			'experiance' => $this->input->post('experiance'),
			'last2yearitramount' => $this->input->post('last2yearitramount'),
			'turnover1' => $this->input->post('turnover1'),
			'turnover2' => $this->input->post('turnover2'),
			'office_ownership' => $this->input->post('office_ownership'),
			'audit_done' => $this->input->post('audit_done'),
			'officeaddress' => $this->input->post('officeaddress'),
			'industry_type' => $this->input->post('industry_type'),
			'persuing' => $this->input->post('persuing'),
			'educational_institute_name' => $this->input->post('educational_institute_name'),
			'income' => $this->input->post('income'),
			'outstanding_loan_details' => $this->input->post('outstanding_loan_details'),
			'brief_outstanding_loan_details' => $this->input->post('brief_outstanding_loan_details'),
			'comment' => $this->input->post('comment'),
			 'last_update_lead_time' => date('Y-m-d H:i:s'),
			'hot_lead_status' =>$this->input->post('hot_lead_status'),
		);
		if($this->input->post('hot_lead_status')==15){
			$arr_update['status'] = $this->input->post('hot_lead_status');
		}
		$this->db_money_money->where('id', $this->input->post('id'));
		$this->db_money_money->update('ant_all_leads', $arr_update);

		$this->db_money_money->where('id', $this->input->post('id'));
		$this->db_money_money->set('hot_lead_counter', 'hot_lead_counter + 1', false);
		$this->db_money_money->update('ant_all_leads');

				/*******************
					$query = $this->db_money_money->select('lead_counter,created_date,last_update_lead_time')->limit(1)->get_where('ant_all_leads',array('id' => $this->input->post('id')));
$result = $query->row_array();
$lead_counter_value = $result['lead_counter'];
$lead_created_date = $result['created_date'];
$last_update_lead_time = $result['last_update_lead_time'];

			  /*********************


		///make history
		$arr_history = array(
			'lead_id' => $this->input->post('id'),
			'assigned_to' => $this->session->userdata('user_id'),
			'fname' => $this->input->post('fname'),
			'lname' => $this->input->post('lname'),
			'email' => $this->input->post('email'),
			'loan_amount' => $this->input->post('loan_amount'),
			'product_type' => $this->input->post('product_type'),
			'comment' => $this->input->post('comment'),
			'lead_open_time' => $this->input->post('lead_open_time'),
			'lead_counter' => $lead_counter_value,
			'lead_created_date' => $lead_created_date,
			'leadUpdateType' => 'hotlead PP',
			'last_update_lead_time' => $last_update_lead_time,
		);
		if($this->input->post('hot_lead_status')==15){
			$arr_history['status'] = $this->input->post('hot_lead_status');
		}
		$this->db_money_money->insert('history_ant_all_leads', $arr_history);

		return array(
			'status' => 1,
			'msg' => 'User update successfully',
		);

	
	}
	
	
	
	public function getNextuser()
	{
		
		
		
		$lead_data = array();
		$where = "product_type = 10";
		$where_pnp_ = "last_update_lead_time <= '" . date('Y-m-d H:i:s', strtotime('-30 minutes')) . "'";
		$where_pnp_day_ = "last_update_lead_time <= '" . date('Y-m-d H:i:s', strtotime('-1 day')) . "'";
		$query = $this->db_money_money->select('id')->limit(1)->get_where('ant_all_leads',
			array(
				'assigned_to' => $this->session->userdata('user_id'),
				'status' => 6,
				'product_type' => 10,
				'reminder_date <= ' => date('Y-m-d H:i:s'),
			)
		);


		if ($this->db_money_money->affected_rows() > 0) {
			$result = $query->row_array();
			//$this->db_money_money->where('id', $result['id']);
		//	$this->db_money_money->set('lead_counter', 'lead_counter + 1', false);
		//	$this->db_money_money->update('ant_all_leads');
			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "a",
				'type' => 'Normal'
			);
		}

				#Already Assigned Dated: 2023-10-31
		$query = $this->db_money_money->select('id, assigned_to')
		//	->where("(assigned_to='" . $this->session->userdata('user_id') . "' AND status = 7) OR (assigned_to='" . $this->session->userdata('user_id') . "' AND status = 3)")
			->where("assigned_to='" . $this->session->userdata('user_id') . "' AND status = 3")
		//->order_by('id', 'desc')
			->limit(1)->get_where('ant_all_leads', array('product_type' => 10));

		if ($this->db_money_money->affected_rows() > 0) {
			$result = $query->row_array();
			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "bb",
				'type' => 'Normal'
			);

		}

		#Fresh
		$query = $this->db_money_money->select('id, assigned_to')
			->where('char_length(mobile)', '10')
			->where("(lead_counter <= 1) and ((assigned_to='" . $this->session->userdata('user_id') . "' AND status = 0) OR (assigned_to = 0 AND status = 0))")
			//->order_by('id', 'desc')
			->limit(1)->get_where('ant_all_leads', array('product_type' => 10));

		if ($this->db_money_money->affected_rows() > 0) {
			$result = $query->row_array();
			if ($result['assigned_to'] == 0) {
				$this->db_money_money->where('id', $result['id']);
				$this->db_money_money->where('assigned_to', 0);
				$this->db_money_money->set('assigned_to', $this->session->userdata('user_id'));
				$this->db_money_money->update('ant_all_leads');
				//Lead Update
			}

			/*$this->db_money_money->where('id', $result['id']);
			$this->db_money_money->set('lead_counter', 'lead_counter + 1', false);
			$this->db_money_money->update('ant_all_leads'); /

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "b",
				'type' => 'Normal'
			);

		}

		#POOL
		$this->load->model('Poolleadmodel');
		$team = 'PL';
		$response = $this->Poolleadmodel->lead($team);
		if ($response['status'] == '1') {
			$response['id'] = base64_encode($response['id']);
			return $response;
		}
		#end Pooll

		#PNP
		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_)
			//->order_by('RAND()')
			//->order_by('lead_counter', 'asc')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '3',
					'DATE(created_date)' => date('Y-m-d'),
					'lead_counter <= ' => 4,
					'CHAR_LENGTH(mobile)' => 10,
					'assigned_to' => 0
				));
		
		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');
			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "c",
				'type' => 'Normal'
			);
		}


		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_)
			//  ->order_by('RAND()')
			//->order_by('lead_counter', 'asc')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '3',
					'DATE(created_date)' => date('Y-m-d', strtotime('- 1 day')),
					'lead_counter <= ' => 8,
					'CHAR_LENGTH(mobile)' => 10,
					'assigned_to' => 0
				));

		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();
			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "d",
				'type' => 'Normal'
			);
		}

		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_)
			//->order_by('id', 'desc')
			//->order_by('RAND()')
			//->order_by('lead_counter', 'asc')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '3',
					'DATE(created_date)' => date('Y-m-d', strtotime('- 2 day')),
					'lead_counter <= ' => 12,
					'CHAR_LENGTH(mobile)' => 10,
					'assigned_to' => 0
				));

		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "e",
				'type' => 'Normal'
			);
		}

		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_)
			//->order_by('RAND()')
			//->order_by('lead_counter', 'asc')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => 3,
					'DATE(created_date)' => date('Y-m-d', strtotime('- 3 day')),
					'lead_counter <= ' => 16,
					'CHAR_LENGTH(mobile)' => 10,
					'assigned_to' => 0
				));

		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');
			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "f",
				'type' => 'Normal'
			);
		}

		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_)
			//->order_by('RAND()')
			//->order_by('lead_counter', 'asc')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '3',
					'DATE(created_date) <= ' => date('Y-m-d', strtotime('- 4 day')),
					'lead_counter <= ' => 20,
					'CHAR_LENGTH(mobile)' => 10,
				    'assigned_to' => 0
				));

		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "g",
				'type' => 'Normal'
			);
		}

		#POOL Normal
		$response = $this->Poolleadmodel->lead_normal($team);
		if ($response['status'] == '1') {
			$response['id'] = base64_encode($response['id']);
			return $response;
		}
		#end Pooll

		#PNP Order by asc counter
		
		$query = $this->db_money->select('id')
			->where($where)
			->where($where_pnp_day_)
			//->order_by("id", "asc")
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '3',
					'CHAR_LENGTH(mobile)' => 10,
				//	'date(created_date) >=' => '2020-01-01',
					'assigned_to' => 0
				));

		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "h",
				'type' => 'Normal'
			);
		}    

		$query = $this->db_money->select('id')
			->where($where)
		//	->order_by('RAND()')
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => '7',
					'lead_counter <= ' => 6,
					'CHAR_LENGTH(mobile)' => 10,
					'assigned_to' => 0,
					'date(created_date) >=' => '2021-01-01',
					'date(created_date) <=' => '2021-08-01',
				));
//        echo "<pre>"; echo $this->db_money->last_query(); exit;
		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();

			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');
			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "i",
				'type' => 'Normal'
			);
		}


//        // NI
		$query = $this->db_money->select('id')
			->where($where)
			//->order_by('RAND()')
			//->order_by("id", "desc")
			->limit(1)->get_where('ant_all_leads',
				array(
					'status' => 7,
					'CHAR_LENGTH(mobile)' => 10,
					'lead_counter <= ' => 2, // 8 changed to 2 dated: 24-july-2023
					'assigned_to' => 0,
					'date(created_date) >=' => '2020-06-01',
				//	'date(created_date) <=' => '2020-12-31',
				));
		if ($this->db_money->affected_rows() > 0) {
			$result = $query->row_array();


			$this->db_money->where('id', $result['id']);
			$this->db_money->where('assigned_to', 0);
			$this->db_money->set('assigned_to', $this->session->userdata('user_id'));
			$this->db_money->update('ant_all_leads');

			return $lead_data = array(
				'id' => base64_encode($result['id']),
				'block'=> "j",
				'type' => 'Normal'
			);
		}

		return false;
	}

	public function searchPayment()
	{

		$this->db_money_money->select('*');
		$this->db_money_money->from('p2p_res_borrower_payment');
		$this->db_money_money->where('email', $this->input->post('searchpayment'));
		$this->db_money_money->or_where('mobile', $this->input->post('searchpayment'));
		$query = $this->db_money_money->get();
		if ($this->db_money_money->affected_rows() > 0) {
			return (array)$query->row();
			// return true;
		} else {
			return false;
		}
	}

	public function update_batch()
	{
		#batch update
		if ($this->input->post('reminder_date') && $this->input->post('status') == 6) {
			$reminder_date = date('Y-m-d H:i:s', strtotime($this->input->post('reminder_date')));

			$arr_update = array(
				'assigned_to' => $this->session->userdata('user_id'),
				'reminder_date' => $reminder_date,
				'status' => $this->input->post('status'),
			);
			$this->db_money_money->where('id', $this->input->post('lead_id'));
			$this->db_money_money->update('ant_all_leads', $arr_update);

		} else {
			$reminder_date = '';
		}
		$arr_update = array(
			'name' => $this->input->post('fname'),
			'email' => $this->input->post('email'),
			'reminder' => $reminder_date,
			'status' => $this->input->post('status'),
		);
		$this->db_money_money->where('id', $this->input->post('id'));
		$this->db_money_money->update($this->input->post('batch_no'), $arr_update);
		#end

		///make history
		$arr_history = array(
			'lead_id' => $this->input->post('id'),
			'mobile' => $this->input->post('mobile') ?? '',
			'comment' => $this->input->post('comment'),
			'status' => $this->input->post('status'),
		);
		$this->db_money_money->insert($this->input->post('batch_no') . '_history', $arr_history);

		///make history
		if ($this->input->post('lead_id')) {


			$arr_history = array(
				'lead_id' => $this->input->post('lead_id'),
				'mobile' => $this->input->post('mobile') ?? '',
				'comment' => $this->input->post('comment'),
				'status' => $this->input->post('status'),
			);
			$this->db_money_money->insert('history_ant_all_leads', $arr_history);
		}

		return array(
			'status' => 1,
			'msg' => 'User update successfully',
		);
	}

	public function searchbylead()
	{
		$where = "";

		if ($this->input->post('id')) {
			$where = "(id = '" . $this->input->post('id') . "')";
		}
		if ($this->input->post('mobile')) {
			$where = "(mobile = '" . $this->input->post('mobile') . "')";
		}
		if ($this->input->post('email')) {
			$where = "(email = '" . $this->input->post('email') . "')";
		}
		//echo $where;exit;
		$this->db_money->select('*');
		$this->db_money->from('ant_all_leads');
		$this->db_money->where($where);
		$query = $this->db_money->get();

		if ($this->db_money->affected_rows() > 0) {
			return $result = $query->result_array();
		} else {
			return false;
		}
	}
	
	public function hotLeadList()
	{
		$this->db_money_money->select('a.*');
		$this->db_money_money->from('ant_all_leads  a');
	    $this->db_money_money->where('a.product_type', 10);
		$this->db_money_money->where('a.status !=', 15);
		$this->db_money_money->where('a.status', 2);
		$this->db_money_money->where('a.hot_lead_status !=', 15);
		$this->db_money_money->where('a.hot_lead_status !=', 0);
		$this->db_money_money->where('a.hot_lead_status !=', '');
		$this->db_money_money->where('a.status !=', 15);
		$this->db_money_money->order_by("last_update_lead_time", "asc");
		$query = $this->db_money_money->get();
	//	return $this->db_money_money->last_query();
		if ($this->db_money_money->affected_rows() > 0) {

			return $result = $query->result_array();
		} else {
			return false;
		}
	}   */

}

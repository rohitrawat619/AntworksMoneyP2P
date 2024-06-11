<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LendSocialmodel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	//	$this->db_money_money = $this->load->database('db_money', true);
	//  $this->cldb = $this->load->database('credit-line', TRUE);
	$this->cldb = $this->load->database('', TRUE);
	//$this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
	//	$this->load->model('Common_model');
			// Get the database name
		//	$this->apiBaseUrlLender = "https://www.antworksp2p.com/surgeapi/investapi/"; dated: 2024-feb-19
			$this->apiBaseUrlLender = "https://www.antworksp2p.com/surgeapi/Investapip2p/"; // dated: 2024-feb-19
			$this->apiBaseUrlKycApi = "https://antworksp2p.com/kycapi/";
			
			
			$this->authorization = 'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==';
			$this->oath_token = "oath_token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjAyMDU1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiOTIxMzg1NTcwMyIsImRldmljZV9pZCI6IiIsImFwcF92ZXJzaW9uIjpudWxsLCJnZW5lcmF0ZWRfdGltZXN0YW1wIjoiMjAyNC0wMi0yMCAxNjowODozNSIsImlwX2FkZHJlc3MiOiI1NC44Ni41MC4xMzkifQ.6o3tDNV52ntG-C26VXjsnCnVk24F9rslkoIRz7cDwiM";
			
		
	}
	
					public function get_master_fee_structure_by_partnerId($partner_id,$userType) //'borrowerRegistrationFee','lenderRegistrationFee'
	{		
		if($userType=="borrowerBullet"){
			$this->cldb->select('a.borrower_partner_registration_fee as partner_registration_fee_charges, a.*');
		}else if($userType=="lender"){
			$this->cldb->select('a.type_of_Lender_platform_fee, a.lender_platform_fee_rupee, a.lender_platform_fee_percentage, a.lender_partner_registration_fee as partner_registration_fee_charges, a.lender_processing_fee_rupee, a.lender_processing_fee_percent, a.lender_pg_charges_bearer');
		}
		
		$this->cldb->from('master_fee_structure a');
		$this->cldb->where(array("a.status"=>1)); // 1:visible; 0:hide  
		$this->cldb->where(array("a.partner_id"=>$partner_id)); // 1:visible; 0:hide  
		$res = $this->cldb->get();

		 $result = $res->result_array();
		// return $this->cldb->last_query();
			return $result;
	}
	
	public function saveRegistrationFee(){
		
				$arr["transactionType"] = $this->input->post('transactionType');
				$arr["user_type"] = $this->input->post('user_type');
				$arr["user_id"] = $this->input->post('user_id');
				$arr["mobile"] = $this->input->post('mobile');
				$arr["amount"] = $this->input->post('amount');
				$arr["razorpay_order_id"] = $this->input->post('razorpay_order_id');
				$arr["razorpay_payment_id"] = $this->input->post('razorpay_payment_id');
				$arr["razorpay_signature"] = $this->input->post('razorpay_signature');
				$arr["ant_txn_id"] = $this->input->post('ant_txn_id');
				$arr["partner_id"] = $this->input->post('partner_id');

				$arr["data_entry_id"] = $this->session->userdata('user_id');
				$arr["data_entry_time"] = date("Y-m-d H:i:s");
				$arr["status"] = 1;
					
                    $query = $this->db->insert('trans_fee_structure', $arr);
						//return $arr;
	
						if ($query) {
							return "Insertion successful.";
						} else {
							return "Insertion failed.";
						}
	}
	
	public function saveInvestmentOtherFee($investment_no){ // 2024-june-06 will call this function everytime lender invest the payment
		
				$arr["transactionType"] = "lenderCharges";
				$arr["user_type"] = "lender";
				$arr["user_id"] = $this->input->post('lender_id');
				$arr["mobile"] = $this->input->post('mobile');
				$arr["amount"] = $this->input->post('amount');
				$arr["razorpay_order_id"] = $this->input->post('razorpay_order_id');
				$arr["razorpay_payment_id"] = $this->input->post('razorpay_payment_id');
				$arr["razorpay_signature"] = $this->input->post('razorpay_signature');
				$arr["ant_txn_id"] = $this->input->post('ant_txn_id');
				$arr["partner_id"] = $this->input->post('partner_id');
				$arr["lender_processing_fee"] = $this->input->post('lender_processing_fee');
				$arr["lender_platform_fee"] = $this->input->post('lender_platform_fee');
				$arr["master_fee_structure_json"] = $this->input->post('master_fee_structure_json');

				$arr["data_entry_id"] = $this->session->userdata('user_id');
				$arr["data_entry_time"] = date("Y-m-d H:i:s");
				$arr["status"] = 1;
				$arr["investment_no"] = $investment_no;
					
                    $query = $this->db->insert('trans_fee_structure', $arr);
						//return $arr;
	
						if ($query) {
							return "Insertion successful.";
						} else {
							return "Insertion failed.";
						}
	}
	
				public function get_registration_fee_status($userType,$userId,$transactionType) //'borrowerRegistrationFee','lenderRegistrationFee'
	{
		$this->cldb->select('trans_fee_structure.*');
		$this->cldb->from('trans_fee_structure'); 
		
		$this->cldb->where(array("trans_fee_structure.transactionType"=>$transactionType));
		$this->cldb->where(array("trans_fee_structure.user_type"=>$userType));
		 $this->cldb->where(array("trans_fee_structure.status"=>1));
				$this->cldb->where(array("trans_fee_structure.user_id"=>$userId));
				$this->cldb->where(array("trans_fee_structure.razorpay_payment_id!="=>""));

		  
		$res = $this->cldb->get();

		 $result = $res->result_array();
		// return $this->cldb->last_query();
			return $result;
	}
		
					public function updateUserLenderId($id,$mobile,$lender_id,$partners_id,$oldNew){

					$arr_user_detail = array(
					'status'=> 1,
					'id' => $id,
					'mobile' => $mobile,

					'userType' => $oldNew
					);	



						foreach ($arr_user_detail as $key => $value) {
						if (empty($value)) {
						$resp['status'] = 2;
						$resp['msg'] = "Field '$key' is empty";
						$resp['mobile'] = "";
						return $resp;
						}
						}								if($lender_id!=""){
					$arr_user_detail['lender_id'] = $lender_id;
					}

					if($partners_id!=""){
					$arr_user_detail['partners_id'] = $partners_id;
					}


					$this->cldb->where('id',$arr_user_detail['id']);	
					$this->cldb->where('mobile',$arr_user_detail['mobile']);
					$this->cldb->where('lender_id',""); //one
					$insertResult = $this->cldb->update('master_user', $arr_user_detail);

					if($insertResult){

					$resp['status'] = 1;
					$resp['msg'] = "Lender ID Updated Successful".$this->cldb->last_query();
					$resp['mobile'] = $arr_user_detail['mobile'];
					return $resp;
					}else{
					$resp['status'] = 0;
					$resp['msg'] = "Lender ID  Updation Failed".$this->cldb->last_query();
					$resp['mobile'] =  $arr_user_detail['mobile'];
					return $resp;
					}
					}
	
	
						/*******************starting of borrower ID update**************/
						public function updateUserBorrowerId($id,$mobile,$borrower_id,$partners_id,$oldNew,$get_user_details){
						$get_user_details = json_encode($get_user_details);
						$borrowerDetails = json_decode($get_user_details,true);
						$arr_user_detail = array(
						'status'=> 1,
						'id' => $id,
						'mobile' => $mobile,

						'userType' => $oldNew
						);	



						foreach ($arr_user_detail as $key => $value) {
						if (empty($value)) {
						$resp['status'] = 2;
						$resp['msg'] = "Field '$key' is empty";
						$resp['mobile'] = "";
						return $resp;
						}
						}								if($borrower_id!=""){
						$arr_user_detail['borrower_id'] = $borrower_id;
						}

						if($partners_id!=""){
						$arr_user_detail['partners_id'] = $partners_id;
						}

						$arr_user_detail['name'] =	$borrowerDetails['name'];
						$arr_user_detail['email_id'] =	$borrowerDetails['email_id'];
						$arr_user_detail['highest_qualification'] =	$borrowerDetails['highest_qualification'];
						$arr_user_detail['pan_card'] =	$borrowerDetails['pan_card'];

						$arr_user_detail['aadhaar_status'] =	$borrowerDetails['aadhaar_status'];
						$arr_user_detail['pan_status'] =	$borrowerDetails['pan_status'];
						$arr_user_detail['account_status'] =	$borrowerDetails['account_status'];

						$this->cldb->where('id',$arr_user_detail['id']);	
						$this->cldb->where('mobile',$arr_user_detail['mobile']);
						//$this->cldb->where('borrower_id',"");
						$insertResult = $this->cldb->update('master_user', $arr_user_detail);

						if($insertResult){

						$resp['status'] = 1;
						$resp['msg'] = "Borrower ID Updated Successful".$this->cldb->last_query();
						$resp['mobile'] = $arr_user_detail['mobile'];
						return $resp;
						}else{
						$resp['status'] = 0;
						$resp['msg'] = "Borrower ID  Updation Failed".$this->cldb->last_query();
						$resp['mobile'] =  $arr_user_detail['mobile'];
						return $resp;
						}
						}
						/******************ending of borrower ID update*********************/
		
		
							/***********************************************/
							public function updateUserDetail(){
							//	echo"<pre>";	print_r($this->input->post()); die();
							$formName = $this->input->post('form');
							$arr_user_detail = "";
							if($formName=="personalDetail"){
							$arr_user_detail = array(
							'status' => 1,
							'id' => $this->input->post('id'),
							'mobile' => $this->input->post('mobile'),
							'name' => $this->input->post('name'),
							'date_of_birth' => $this->input->post('date_of_birth'),
							'gender' => $this->input->post(gender),
							'email_id' => $this->input->post('email_id'),
							'pan_card' => $this->input->post('pan_card'),
							'aadhaar' => $this->input->post('aadhaar'),

							);	

							$arr_user_detail['r_address'] = $this->input->post('r_address');
							$stateData = explode(",",$this->input->post('r_state'));
							$arr_user_detail['r_state'] = $stateData[0]; //$this->input->post('r_state');
							$arr_user_detail['r_city'] = $this->input->post('r_city');
							$arr_user_detail['r_pincode'] = $this->input->post('r_pincode');

							$arr_user_detail['r_state_code'] = $stateData[1]; //$this->input->post('r_state_code');


							$arr_user_detail['highest_qualification'] = $this->input->post('highest_qualification');


							$arr_user_detail['occuption_id'] = 1; // static occupation id will be one because 2024-feb-13 $this->input->post('occuption_id');
							$arr_user_detail['company_type'] = $this->input->post('company_type');


							$arr_user_detail['company_name'] = $this->input->post('company_name');
							// $arr_user_detail['company_code'] = $this->input->post('company_code');
							$arr_user_detail['company_code'] = ($this->input->post('company_code')==""? 0: $this->input->post('company_code'));
							$arr_user_detail['salary_process'] = $this->input->post('salary_process');
							$arr_user_detail['net_monthly_income'] = $this->input->post('net_monthly_income');


							}else if($formName=="accountDetail"){
							$arr_user_detail = array(
							'id' => $this->input->post('id'),
							'mobile' => $this->input->post('mobile'),
							'account_number' => $this->input->post('account_number'),
							'ifsc_code' => $this->input->post('ifsc_code'),
							//'bank_name' => $this->input->post('bank_name'),
							);	
							}


									foreach ($arr_user_detail as $key => $value) {
									if (empty($value)) {
									$resp['status'] = 2;
									$resp['msg'] = "Field '$key' is empty";
									$resp['mobile'] = "";
									return $resp;
									}
									}

							$this->cldb->where('id',$arr_user_detail['id']);	
							$this->cldb->where('mobile',$arr_user_detail['mobile']);	
							$insertResult = $this->cldb->update('master_user', $arr_user_detail);
							//	echo $this->cldb->last_query(); die();
							if($insertResult){

							$resp['status'] = 1;
							$resp['msg'] = "User Updated Successful In".$formName;
							$resp['mobile'] = $this->input->post('mobile');
							return $resp;
							}else{
							$resp['status'] = 0;
							$resp['msg'] = "User  Updation Failed";
							$resp['mobile'] =  $this->input->post('mobile');
							return $resp;
							}
							}

	

		public function getUserDetail($mobile)
	{
		$this->cldb->select('master_user.*, a.Company_Name as partner_name');
		$this->cldb->from('master_user');
		$this->cldb->join('invest_vendors a',"master_user.partners_id = a.VID", "LEFT");
		$this->cldb->where(array("master_user.mobile"=>$mobile));
		$res = $this->cldb->get();

		 $result = $res->result_array();
			return $result[0];
	}
	
		public function get_company_list($searchTerm)
	{
		$this->db->select('id,company_name');
		$this->db->from('p2p_list_company');
		$this->db->like('company_name', $searchTerm); 
		$this->db->limit(40);	
		$query = $this->db->get();

		return $query->result();  
	}


	
	
	public function get_state()
    {
        $this->db->select('state, code');
        $this->db->from('p2p_state_experien');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	
	public function highest_qualification()
    {
        $this->db->select('*');
        $this->db->from('p2p_qualification');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	
			public function getPartnersTheme($partner_id)
				{
		
		
		$this->cldb->select('partners_theme.*');
		$this->cldb->from('partners_theme');
		//$this->cldb->join('invest_vendorssss1 a',"master_user.partners_id = a.VID", "LEFT");
		
			$this->cldb->where(array("partners_theme.partner_id"=>$partner_id));
		$res = $this->cldb->get();

		 $result = $res->result_array();

			return $result[0];
			}



/******************starting of allInOneKycSubmitOtp here*************/
		public function allInOneKycSubmitOtp($mobile,$fullname,$email,$pan,$aadhar,$account_no,$bank_name,$ifsc_code,$otp,$transactionId,$codeVerifier,$fwdp,$kyc_unique_id){  
							
		
$curl = curl_init();


$postData = json_encode(array(
    'kyc_unique_id' => $kyc_unique_id,
	'mobile' => $mobile,
	'fullname' => $fullname,
    'user_type' => 'lender',
    'source' => 'Surge',
	 "product"=> "Lend Social",
    'otp' => $otp,
    'transactionId' => $transactionId,
    'codeVerifier' => $codeVerifier,
    'fwdp' => $fwdp,
    'validateXml' => true
				));


curl_setopt_array($curl, array(
  CURLOPT_URL => $this->apiBaseUrlKycApi.'all_in_one_kyc_submit_otp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,


		CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=e8duebnem634m2db5fj7vfh3ul0kqlbr',
	'Authorization:NTk0MDcxOmJhMjUzZTM4ZmM0NDBkMjQ4Yjk1NWRmOGYzMzZmNzRl'
  ),
			));

			$response = curl_exec($curl);

			
			$response = curl_exec($curl);

			if ($response === false) {
				echo 'Curl error: ' . curl_error($curl);
				echo 'Curl error number: ' . curl_errno($curl);
			}

			curl_close($curl);

			return $response;

				}
	/**************ending of allInOneKycSubmitOtp here**************/



/******************starting of allInOneKyc here*************/
		public function allInOneKyc($mobile,$fullname,$email,$pan,$aadhar,$account_no,$bank_name,$ifsc_code,$company_type,$company_name,$company_code,$user_type,$dob,$gender,$highest_qualification,$r_pincode,$net_monthly_income,$r_city,$r_state,$vendor_id){  
						
		
			$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $this->apiBaseUrlKycApi.'all_in_one_kyc',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
					"mobile": "'.$mobile.'",
					"fullname": "'.$fullname.'",
					"email": "'.$email.'",
					"pan": "'.$pan.'", 
					"aadhar":"'.$aadhar.'",
					"account_no": "'.$account_no.'",
					"caccount_no": "'.$account_no.'",
					"bank_name": "'.$bank_name.'",
					"ifsc_code": "'.$ifsc_code.'",
					"dob": "'.$dob.'",
					 "gender":  "'.$gender.'",
					  "occuption_id": "1",
					  "company_type": "'.$company_type.'",
					"company_name": "'.$company_name.'",
					"company_code": "'.$company_code.'",
					 "highest_qualification":  "'.$highest_qualification.'",
					"r_pincode": "'.$r_pincode.'",
					"net_monthly_income": "'.$net_monthly_income.'",
					"r_city": "'.$r_city.'",
					"r_state": "'.$r_state.'",
					"user_type": "'.$user_type.'",
					"vendor_id": "'.$vendor_id.'",
					"source": "LendSocialWebApp",
					"product": "Lend Social"
					}',


			  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=e8duebnem634m2db5fj7vfh3ul0kqlbr',
	'Authorization:NTk0MDcxOmJhMjUzZTM4ZmM0NDBkMjQ4Yjk1NWRmOGYzMzZmNzRl'
  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
				
				
				
				
	/**************ending of allInOneKyc here**************/


/******************starting of Bank KYC here*************/
		public function userBankKYC($account_no,$caccount_no,$fullname,$ifsc_code,$lender_id,$phone){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
		//2023-dec-20	  CURLOPT_URL =>  'https://webhook.site/b0d5ff61-d3a7-40a6-bee0-4ffdcc7e1412/surgeapi/investapi/user_bank_detail',
			  CURLOPT_URL => $this->apiBaseUrlLender.'user_bank_detail',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				     "account_no": "'.$account_no.'",
					"caccount_no": "'.$caccount_no.'",
					"fullname": "'.$fullname.'",
					"ifsc_code": "'.$ifsc_code.'",
					"lender_id": "'.$lender_id.'",
					"phone": "'.$phone.'",	
				   "source":"surge"
						} ',



			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of Bank KYC here**************/


/******************starting of PAN KYC / User Personal Detail here*************/
		public function saveUserPersonalDetailApi($DOB,$email,$fullname,$gender,$PAN,$phone,$vendor_id){   // vender_id =partner_id
					$postData = '{
				     "device_id":"SurgeWebAppID",
						"app_version":"2",
						"DOB": "'.$DOB.'", 
						"email": "'.$email.'",
						"fullname": "'.$fullname.'",
						"gender": "'.$gender.'",
						"PAN": "'.$PAN.'",
						"phone": "'.$phone.'",
						"vendor_id": "'.$vendor_id.'",
				 "source":"LendSocialWebApp"
						}';				
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'user_personal_detail',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,

						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));
				
			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of generateOrder here**************/


/******************starting of generateOrder here*************/
		public function generateOrder($amount,$mobile){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://antworksmoney.com/apiserver/antapp/generateOrder',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			  "amount":"'.$amount.'",
			  "channel":"PG",
              "mobile":"'.$mobile.'", 
              "service":"social-lending",
				 "source":"surge"
						} ',
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of generateOrder here**************/
	


/******************starting of socialAfterPayment here*************/
		public function socialAfterPayment($ant_txn_id,$mobile,$amount,$razorpay_order_id,$razorpay_payment_id,$razorpay_signature){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://antworksmoney.com/apiserver/social/social_after_payment',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "ant_txn_id": "'.$ant_txn_id.'",
				"mobile": "'.$mobile.'",
				"amount":"'.$amount.'",
				"payment_method": "PG",
				"service":"social-lending",
				"razorpay_order_id": "'.$razorpay_order_id.'",
				"razorpay_payment_id": "'.$razorpay_payment_id.'",
				"razorpay_signature": "'.$razorpay_signature.'",
				"source":"surge"
				}',
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);
		  // Check for cURL errors
    if ($response === false) {
        $error_message = curl_error($curl);
        $error_code = curl_errno($curl);

        // Handle the error as needed
        return "cURL Error $error_code: $error_message";
    }
			curl_close($curl);
			return $response;

				}
	/**************ending of socialAfterPayment here**************/

/******************starting of lenderInvestment here*************/
		public function lenderInvestment($mobile,$lender_id,$amount,$scheme_id,$ant_txn_id){  
						
			$postData =  json_encode(array(
				 "phone"=>$mobile,
				 "lender_id"=>$lender_id,
				 "amount"=>$amount,
				 "scheme_id"=>$scheme_id,
                 "ant_txn_id"=>$ant_txn_id,
				 "source" => "Surge",
				 "product"=> "Lend Social",
			));							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'lender_investment',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,
						
						

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/**************ending of lenderInvestment here**************/



/******************starting of sendRedemptionRequest here************Done*/
		public function sendRedemptionRequest($mobile,$investment_no){  
							
		
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'redemption_status',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "investment_no":"'.$investment_no.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl); /*
				$response = '{
    "status": 0,
    "mes": "Redemption in Process"
}';  */
			return $response;

				}
	/**************ending of sendRedemptionRequest here**************/


/******************starting of getRedeemRequestPreview here************Done*/
		public function getRedeemRequestPreview($mobile,$investment_no){  
							

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'redemption_request',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "investment_no":"'.$investment_no.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
	/***************************/

		public function getAllSchemes($mobile,$partner_id){  
							

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'all_schemes',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "vendor_id":"'.$partner_id.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}


		public function getInvestmentList($mobile,$lender_id){
						
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'lender_investment_details',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
				 "phone":"'.$mobile.'",
				 "lender_id":"'.$lender_id.'",
				 "source":"surge"
						}',

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

				}
		
		public function getKycStatus($mobile,$vendor_id){
					$postData =  json_encode(array("phone"=>$mobile, "vendor_id"=>$vendor_id));		
						
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $this->apiBaseUrlLender.'kyc_status',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>$postData,

			  CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
				$this->oath_token,
				'Cookie: p2p_2018_2019_session=hbo2sb7l00q1113m4pe76sutmpeb6kkq'
			  ),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			return $response;

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

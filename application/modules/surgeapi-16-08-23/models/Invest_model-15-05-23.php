<?php
class Invest_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
		//$this->db2 = $this->load->database('invest', TRUE);
		$this->cldb = $this->load->database('credit-line', TRUE);
    }
	public function get_all_scheme()
    {
        $this->cldb->select('*');
        $this->cldb->from('invest_scheme_details');
        $query = $this->cldb->get();
        if($this->cldb->affected_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
	public function get_kyc_status($mobile)
    {
        $query = $this->cldb->get_where('p2p_lender_list', array('mobile' => $mobile));
		//echo $this->cldb->last_query();exit;
        if ($this->cldb->affected_rows() > 0) {
            $steps = $query->row_array();

			if ($steps['pan_kyc'] == 1 && $steps['account_kyc'] == 0) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 1,
					'msg' => 'Basic KYC Done'
				);
			}
			if ($steps['pan_kyc'] == 1 && $steps['account_kyc'] == 1) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 2,
					'msg' => 'Fully kyc Done'
				);
			}
			 if ($steps['pan_kyc'] == 0 && $steps['account_kyc'] == 0) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 0,
					'msg' => 'KYC Not Done'
				);
			} 
        }else{
			return $current_step = array(
                'lender_id' => '',
                'step' => 0,
                'msg' => 'User Not found'
            );
		}
    }
	public function basic_pan_kyc() {
    $postData = $this->input->post();
            $URL = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/pan_api"; 
            $name_match_method= "exact";
            $anchor = "Investent";
    
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'pan' => $postData['PAN'],
            'name' => $postData['fullname'],
            'mode' => $name_match_method,
            'anchor'=> $anchor,
            'mobile'=> $postData['phone'],
        )),
        CURLOPT_HTTPHEADER => array(
             'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);

curl_close($curl);

        return $response;
}

public function basic_bank_kyc($details) {

       $URL = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/addBank"; 
    
            $anchor = "Investent";
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'mobile' => $details['phone'],
            'name' => $details['fullname'],
            'account_no' => $details['account_no'],
            'caccount_no' => $details['caccount_no'],
            'ifsc_code' => $details['ifsc_code'],
            'anchor'=> $details['anchor'],
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);

curl_close($curl);

        return $response;
}
   public function basic_pan_kyc1() {
	   
		    $postData = $this->input->post();
			$query = $this->cldb->get_where('borrower_pan_api_details', array('pan' => $postData['PAN'], 'name' => $postData['fullname']));
			//echo $this->cldb->last_query();exit;
			if ($this->cldb->affected_rows() > 0)
				{
					$response = $query->row_array();
					//$arr_response = json_decode($response['response'], true);
					
					return $response['response'];
				}
            
			$curl = curl_init();

           curl_setopt_array($curl, array(
            CURLOPT_URL => PAN_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                'client_ref_num' => uniqid(),
                'pan' => $postData['PAN'],
                'name' => $postData['fullname'],
                'name_match_method' => 'exact',
            )),
            CURLOPT_HTTPHEADER => array(
                'authorization: ' . base64_encode(Client_Id_PAN . ':' . Client_Secret_PAN),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
		curl_close($curl);
		$arr_response = json_decode($response, true);
         $this->cldb->insert('borrower_pan_api_details', array(
            'mobile' => $postData['phone'],
            'pan' => $postData['PAN'],
            'status' => $arr_response['result']['status'],
            'name' => $arr_response['result']['name'],
            'name_match' => $arr_response['result']['name_match'],
            'result_code' => $arr_response['result_code'],
            'response' => $response,
        )); 
		 $this->cldb->get_where('master_kyc', array(
            'mobile' => $postData['phone'],
            'kyc_step' => 'Pan'
        ));
        if ($this->cldb->affected_rows() <= 0) {
            $this->cldb->insert('master_kyc', array(
                'mobile' => $postData['phone'],
                'name' => strtoupper($postData['fullname']),
                'kyc_step' => 'Pan'
            ));
        }

        return $response;
        
			 //pr($postData);exit;
			/* $URL = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/pan_api"; 
			$name_match_method= "exact";
			$anchor = "Investent";
		
			$curl = curl_init();
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => $URL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode(array(
			    'mobile'=> $postData['phone'],
				'pan' => $postData['PAN'],
				'name' => $postData['fullname'],
				'mode' => 'exact',
			)),
			CURLOPT_HTTPHEADER => array(
				 'Content-Type: application/json'
			),
		));
		$response = curl_exec($curl);
         
	     curl_close($curl);

			return $response;  */
	}
	public function updateBank1()
     {
		 $lender_name = $this->cldb->select('name')->get_where('p2p_lender_list', array('lender_id' => $this->input->post('lender_id')))->row()->name;
		 $data = json_encode(
			 array(
				 "fund_account" => array(
					 "account_type" => 'bank_account',
					 "bank_account" => array(
						 "name" => $lender_name,
						 "ifsc" => $this->input->post('ifsc_code'),
						 "account_number" => $this->input->post('account_no'),
					 ),
				 ),
				 "amount" => "100",
				 "currency" => "INR",
				 "notes" => array(
					 "random_key_1" => "",
					 "random_key_2" => "",
				 ),
			 )
		 );
		 
		 $curl = curl_init();
		 curl_setopt_array($curl, array(
			 CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations",
			 CURLOPT_RETURNTRANSFER => true,
			 CURLOPT_ENCODING => "",
			 CURLOPT_MAXREDIRS => 10,
			 CURLOPT_TIMEOUT => 30,
			 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			 CURLOPT_CUSTOMREQUEST => "POST",
			 CURLOPT_POSTFIELDS => $data,
			 CURLOPT_HTTPHEADER => array(
				 "cache-control: no-cache",
				 "content-type: application/json",
				 "authorization: Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v",
			 ),
		 ));
		 echo $response = curl_exec($curl);exit;
		 $err = curl_error($curl);
		 curl_close($curl);
		 if ($err) {
			 $msg = array(
				 "status" => 0,
				 "msg" => "Somethign went wrong please try again"
			 );
			 
			 return $msg;
		 } else {
			 $res = json_decode($response, true);
			 $bank_res = array(
				 'lender_id' => $this->input->post('lender_id'),
				 'fav_id' => $res['id'] ? $res['id'] : '',
				 'razorpay_response_bank_ac' => $response,
			 );
			 $this->cldb->insert('p2p_lender_bank_res', $bank_res);
			 if($res['id'])
			 {
				 $bank_data = array(
					 'lender_id'=>$lenderId,
					 'bank_name'=>$this->input->post('bank_name'),
					 'account_number'=>$this->input->post('account_no'),
					 'ifsc_code'=>$this->input->post('ifsc_code'),
					 'is_verified'=>0,
				 );
				 $this->cldb->insert('p2p_lender_account_info', $bankdetails);
				 //Update Lender KYC step
				 $this->cldb->where('lender_id', $lenderId);
				 $this->cldb->set('account_kyc', 1);
				 $this->cldb->update('p2p_lender_list');
				 $msg = array(
					 "status" => 1,
					 "msg" => "Bank Account added successfully"
				 );
				 //$this->set_response($msg, REST_Controller::HTTP_OK);
				 return $msg;
			 }
			 else{
				 $msg = array(
					 "status" => 0,
					 "msg" => "Incorrect information, please check your details"
				 );
				 //$this->set_response($msg, REST_Controller::HTTP_OK);
				 return $msg;
			 }
		 }
         
    }
	/* public function addaccount($bankdetails)
    {
        $this->db->insert('p2p_lender_account_info', $bankdetails);
        if($this->db->affected_rows()>0)
        {
            $this->db->set('step_4', 1);
            $this->db->where('lender_id', $this->session->userdata('user_id'));
            $this->db->update('p2p_lender_steps');

           return true;
        }
        else{
           return false;
        }
    } */
  public function basic_bank_kyc33($details) {
	  //pr($details);exit;

       $URL = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/addBank"; 
    
        $anchor = "Investent";
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'mobile' => $details['phone'],
            'name' => $details['fullname'],
            'account_no' => $details['account_no'],
            'caccount_no' => $details['caccount_no'],
            'ifsc_code' => $details['ifsc_code'],
            'anchor'=> $details['anchor'],
        )),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);

curl_close($curl);

        return $response;
}	

}
?>

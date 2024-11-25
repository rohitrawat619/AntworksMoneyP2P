<?php 
class credit_line_model extends CI_Model{

public function __construct(){
    $this->apiBaseUrl= "https://antworksp2p.com/credit-line/"; //"https://antworksmoney.com/credit-line/p2papiborrower/";
    $this->authorization="Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==";
    $this->oath_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjA3MTk1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiNjM5NTEzMDc4NyIsImRldmljZV9pZCI6IlVsTlNNUzR5TURFd01UTXVNREF4IiwiYXBwX3ZlcnNpb24iOm51bGwsImdlbmVyYXRlZF90aW1lc3RhbXAiOiIyMDIzLTEyLTI5IDE0OjU0OjEwIiwiaXBfYWRkcmVzcyI6IjEyMi4xNzYuNTMuMTkyIn0.BZF3795oRwh3_Uhti4LVIrlvRX3hGZmYY5Qayd00JPw";
	$this->load->helper('seprateValues');

}


  public function get_borrower_occupation_and_profession_details($borrower_id){ // 2024-Oct-8
        $this->db->select('*');
        $query = $this->db->get_where('p2p_borrowers_list',array('id'=>$borrower_id))->row_array();
        $arr = array(
          'occuption_id' => $query['occuption_id'],
          'profession_id' => $query['profession_id'],
		  'status'=>1
       //   'borrower_id' => $query['id']
        );
        return $arr;
      }

/***************start of get borrower detail 2024-may-31********************/
			function getAntBorrowerRatinDetails($borrower_id){
				 $query = $this->db->get_where('ant_borrower_rating', array('borrower_id' => $borrower_id));
        return $query->row_array(); // Return user details as an associative array
			}
				/**********************end of get borrower detail********************/

public function registration_credit_line_1($postData){
		//  echo "<pre>";	print_r($postData); die();
    $curl = curl_init();
    $payload = json_encode(array(
    "dob" => $postData['date_of_birth'],
    "email" =>  $postData['email_id'], //"irshad@antworksmoney.com",
    "gender" =>  $postData['gender'], //"Male",
    "highest_qualification" => $postData['highest_qualification'], //"Graduate",
    "mobile" => $postData['mobile'], //"9015439079",
    "name" => $postData['name'], //"IRSHAD AHMED",
    "pan" => $postData['pan_card'], //"CTCPA6759F",
    "aadhar" => $postData['aadhaar'], //"345747477612",
    "r_address" => $postData['r_address'], //"Haryana",
    "r_city" => $postData['r_city'], //"Faridabad",
    "r_pincode" => $postData['r_pincode'], //"201204",
    "latitude" => $postData['latitude'], //"28.395250",
    "longitude" => $postData['longitude'], //"77.284859",
    "r_state" => $postData['r_state'], //"Haryana",
    "r_state_code" => $postData['r_state_code'], //"00"
));
			//	echo "<pre>";	print_r($payload); die();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerres/registration_credit_line_1',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$payload,
    CURLOPT_HTTPHEADER => array(
        'Authorization:'.$this->oath_token.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    }
	
	
public function registration_credit_line_2($postDat){
  
    $curl = curl_init();
   $data = array(
    "borrower_id" => $postData['borrower_id'], //"3548",
    "occuption_id" => $postData['occuption_id'], //"Salaried",
    "company_type" => $postData['company_type'], //"Private Limited Company",
    "company_name" => $postData['company_name'], //"Antworks Pvt Ltd",
    "company_code" => $postData['company_code'], //"CATGA",
    "salary_process" => $postData['salary_process'], //"A/C",
    "net_monthly_income" => $postData['net_monthly_income'], //"50000"
);
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerres/registration_credit_line_2',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$payload,
    CURLOPT_HTTPHEADER => array(
        'Authorization:'.$this->oath_token.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    }

public function update_borrower_details($postData){
  
    $curl = curl_init();
   $payload = json_encode(array(
    "vendor_id" => $postData['partner_id'], //"3548",
    "borrower_id" => $postData['borrower_id'], //"CATGB",
    "mobile" => $postData['mobile'], //"Antworks",
	));
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerres/update_borrower_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$payload,
    CURLOPT_HTTPHEADER => array(
        'Authorization:'.$this->oath_token.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    }


public function update_borrower_detailsaaaa($postDat){
  
    $curl = curl_init();
   $payload = array(
    "borrower_id" => $postData['borrower_id'], //"3548",
    "company_code" => $postData['borrower_id'], //"CATGB",
    "company_name" => $postData['borrower_id'], //"Antworks",
    "company_type" => $postData['borrower_id'], //"Private Limited Company",
    "dob" => $postData['borrower_id'], //"1994-02-15",
    "email" => $postData['borrower_id'], //"irshad@antworksmoney.com",
    "gender" => $postData['borrower_id'], //"Male",
    "highest_qualification" => $postData['borrower_id'], //"Graduate",
    "ip_address" => $postData['borrower_id'], //"10.0.2.15",
    "latitude" => $postData['borrower_id'], //"37.4220936",
    "longitude" => $postData['borrower_id'], //"-122.083922",
    "mobile" => $postData['borrower_id'], //"9015439079",
    "name" => $postData['borrower_id'], //"IRSHAD AHMED",
    "net_monthly_income" => $postData['borrower_id'], //"50000",
    "occuption_id" => $postData['borrower_id'], //"Salaried",
    "pan" => $postData['borrower_id'], //"CTCPA6759F",
    "r_address" => $postData['borrower_id'], //"e 1361",
    "r_city" => $postData['borrower_id'], //"FARIDABAD",
    "r_pincode" => $postData['borrower_id'], //"121001",
    "r_state" => $postData['borrower_id'], //"HARYANA",
    "r_state_code" => $postData['borrower_id'], //"true"
);
	
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerres/update_borrower_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$payload,
    CURLOPT_HTTPHEADER => array(
        'Authorization:'.$this->oath_token.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    }
	

// Credit-line Api Starts
public function viewLoanaggrement($borrower_id){
  
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerloan/viewLoanaggrement',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "borrower_id":"'.$borrower_id.'",
        "bid_registration_id":"4545"
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization:'.$this->oath_token.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    }
    
        public function get_borrower_details($mob){
    
    
          $curl = curl_init();
    
          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiBaseUrl.'borrowerres/get_borrower_details',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
              "mobile": "'.$mob.'"
          }',
            CURLOPT_HTTPHEADER => array(
              'Authorization: '.$this->authorization.'',
              'Content-Type: application/json',
              'Auth-Token: '.$this->oath_token.''
            ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    
        }
		
		
		public function get_video_kyc_status($borrower_id) {
    $this->db->where('borrower_id', $borrower_id);
    $this->db->select('step_8');
    $this->db->from('p2p_borrower_steps_credit_line');
    $query = $this->db->get()->row_array();
    
    return $query;
}


	public function skip_video_kyc_status($borrower_id) {
    $data = array(
        'step_8' => 1 
    );
    $this->db->where('borrower_id', $borrower_id);
    $this->db->update('p2p_borrower_steps_credit_line', $data);
    
    return; 
}



    
        public function loan_eligiblity_status($borrower_id,$partner_id){
    
              $curl = curl_init();
    
      curl_setopt_array($curl, array(
        CURLOPT_URL => $this->apiBaseUrl.'borrowerres/loan_eligibility_status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "borrower_id":"'.$borrower_id.'",
		  "partner_id":"'.$partner_id.'"
      }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: '.$this->authorization.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
      ));
    
      $response = curl_exec($curl);
    
      curl_close($curl);
     //echo $response;
    
    $response=(array)json_decode($response);
    return $response;
        }
    
        public function credit_line_saction_details($borrower_id,$loan_id){
          
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerres/credit_line_sanction_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "borrower_id": "'.$borrower_id.'",
        "loan_id":"'.$loan_id.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$this->authorization.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
      
        }


       public function create_customer($user_details) {
            return $this->create_customer_api($user_details);
       
    }
    
    public function create_customer_api($result) {
      $curl = curl_init();
  
      // Prepare the POST fields as an associative array
      $post_fields = [
          'name' => $result['name'],
          'email' => $result['email'],
          'contact' => $result['mobile'],
          'notes_key_1' => $result['name'].'_customer_created',
          'notes_key_2' => $result['email'].'_customer_created',
          'borrower_id' => $result['borrower_id'],
          'expire_time' => API_EXPIRE_TIME
      ];
      // pr($post_fields);
      
      // Convert the POST fields to a query string
      $query_string = http_build_query($post_fields);
  
      // Encode the query string in Base64
      $encoded_query_string = encrypt_string($query_string);
      // echo $encoded_query_string;die();
  
      curl_setopt_array($curl, array(
          CURLOPT_URL => base_url('/e_nach/nach_controller/create_customer'),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $encoded_query_string,
          CURLOPT_HTTPHEADER => array(
              'Content-Type: application/x-www-form-urlencoded',
              'Cookie: p2p_2018_2019_session=j3gi4bk3e8jm52ckplhk0b2r7ic5okp0'
          ),
      ));
  
      $response = curl_exec($curl);
  
      if (curl_errno($curl)) {
          $error_msg = curl_error($curl);
      }
  
      curl_close($curl);
  
      if (isset($error_msg)) {
          return ['status' => 0, 'msg' => $error_msg];
      }
  // echo $response;die();
      // Decode the response if needed
      $response = json_decode($response, true);
      return $response;
  }



    public function create_order($user_details) {
          $create_order_api = $this->create_order_api($user_details);
          return $create_order_api;
  }
  
  public function create_order_api($result) {
      // Initialize cURL
      $curl = curl_init();
  
      // Prepare the POST data
      $postData = http_build_query([
          'borrower_id' => $result['borrower_id'],
          'notes_key_1' => $result['name'].'_order_created',
          'notes_key_2' => $result['borrower_id'].'_order_created',
          'auth_type' => $this->input->post('payment_type'),
          'token_notes_key_1' => $result['bank_details']->account_number.'_order_created',
          'token_notes_key_2' => $result['bank_details']->ifsc_code.'_order_created',
          'beneficiary_name' => $result['bank_details']->bank_registered_name,
          'account_number' => $result['bank_details']->account_number,
          'ifsc_code' => $result['bank_details']->ifsc_code,
          'account_type' => $result['bank_details']->account_type,
          'expire_time' => API_EXPIRE_TIME
      ]);
      // return $postData;
      // Convert the POST fields to a query string
      // $query_string = http_build_query($postData);
  
      // Encode the query string in Base64
      $encoded_query_string = encrypt_string($postData);
  
      // Set cURL options
      curl_setopt_array($curl, array(
          CURLOPT_URL => base_url('e_nach/nach_controller/create_order'), // Corrected URL concatenation
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $encoded_query_string,
          CURLOPT_HTTPHEADER => array(
              'Content-Type: application/x-www-form-urlencoded'
          ),
      ));
  
      // Execute cURL request and get the response
      $response = curl_exec($curl);
  
      // Close cURL session
      curl_close($curl);
      // echo $response;
      // Decode JSON response
      $response = (array)json_decode($response, true);
  
      // Return the response
      return $response;
  }
    
        public function credit_line_sendOtpsignature($borrower_id,$loan_id){
    
          $curl = curl_init();
    
          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiBaseUrl.'borrowerloan/credit_line_sendOtpsignature',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "borrower_id":"'.$borrower_id.'",
              "loan_id":"'.$loan_id.'"
          }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.$this->authorization.'',
            'Content-Type: application/json',
            'Auth-Token: '.$this->oath_token.''
          ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          // echo $response;
          
    $response=(array)json_decode($response);
    return $response;
          
        }
        public function credit_line_verifyOtpsignature($borrower_id,$loan_id,$otp){
          
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerloan/credit_line_verifyOtpsignature',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "borrower_id":"'.$borrower_id.'",
        "loan_id":"'.$loan_id.'",
        "otp":"'.$otp.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$this->authorization.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
   // echo $response;
    
    
    $response=(array)json_decode($response);
    return $response;
      
        }
        public function loan_details($borrower_id){
          
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerloan/loan_details',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "borrower_id":"'.$borrower_id.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$this->authorization.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
      
        }
        public function disbursement_request($borrower_id,$loan_id,$partner_id){
            
          $curl = curl_init();
    
          curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiBaseUrl.'borrowerres/disbursement_request',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
            "borrower_id":"'.$borrower_id.'",
			"partner_id":"'.$partner_id.'",
              "loan_id":"'.$loan_id.'"
          }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: '.$this->authorization.'',
            'Content-Type: application/json',
            'Auth-Token: '.$this->oath_token.''
          ),
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          
     echo $response;
    
    $response=(array)json_decode($response);
    //return $response;
    
        }
    
        public function loan_after_payment(){
            
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => $this->apiBaseUrl.'borrowerloan/loan_after_payment',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{"ant_txn_id":"ANT230428000136","mobile":"8006034041","payment_method":"PG","razorpay_order_id":"order_LjC27kJJv4YItM","razorpay_payment_id":"pay_LjC2GQDjRZu06P","razorpay_signature":"af7077a22498dbfc14b6ca9ed0d51cb758850948e543c5d51d5642beb2e1b0bb"}
    
    ',
    CURLOPT_HTTPHEADER => array(
        'Authorization: '.$this->authorization.'',
        'Content-Type: application/json',
        'Auth-Token: '.$this->oath_token.''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    
    $response=(array)json_decode($response);
    return $response;
    
        }
    
        // Credit-line Api Ends
		
		 public function get_loan_plans($where){
          
          if($this->input->post('selectedId')){
            $where['id']=$this->input->post('selectedId');
          }
          else{
            $this->db->select('system_generated_id');
            $query = $this->db->get_where('partners_theme',array('partner_id'=>$where['partner_id']))->row_array();
            $arr = getSeprateValues($query['system_generated_id']);
           
            $where=array(
              'isd.Vendor_ID'=>$arr['partner_id'],
              'plp.partner_id'=>$arr['partner_id'],
              'isd.occuption_id'=> $where['occuption_id'],
              'isd.borrower_classifier' => $where['profession_id'],
              'plp.status'=>1
            );
          }
			
          $this->db->select('plp.id as partner_plan_id, plp.amount,plp.tenor,plp.interest'); // Select the columns you need
          $this->db->from('partner_loan_plan as plp');
          $this->db->join('invest_scheme_details as isd', 'isd.id = plp.scheme_id', 'left'); 
          $this->db->where($where); 
          $query = $this->db->get();

 //   echo $this->db->last_query(); die();
          if($this->input->post('selectedId')){
            if ($query->num_rows() > 0) {
              return $query->row();
          } else {
              return false;// return the values what you want
          }
          }
          else{
          if ($query->num_rows() > 0) {
             
            return $query->result_array();

        } else {
            return false;// return the values what you want 
        }

        }
      }
	  
	          public function updateLoanDetails($loanDetail) {
				  $loanDetail_arr = $loanDetail[0];
				 // echo"<pre>"; print_r($loanDetail); 
				  
          $loanDetails = array(
              'approved_loan_amount' => $loanDetail_arr['amount'],
              'approved_interest' => $loanDetail_arr['interest'],
              'approved_tenor_days' => $loanDetail_arr['tenor'],
			  'approved_tenor'=>0
          );
      
          $where = array(
              'borrower_id' => $loanDetail['borrower_id'],
              'loan_no' => $loanDetail['loan_no'],
              'id' => $loanDetail['id'],
              //'disbursement_request!=' => 1,
          );
      
          $this->db->where($where);
      
          $this->db->update('p2p_loan_list', $loanDetails);
			//echo $this->db->last_query(); die();
            return 1;
          
      }

}
?>
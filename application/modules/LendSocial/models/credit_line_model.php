<?php 
class credit_line_model extends CI_Model{

public function __construct(){
    $this->apiBaseUrl= "https://antworksp2p.com/credit-line/"; //"https://antworksmoney.com/credit-line/p2papiborrower/";
    $this->authorization="Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==";
    $this->oath_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjA3MTk1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiNjM5NTEzMDc4NyIsImRldmljZV9pZCI6IlVsTlNNUzR5TURFd01UTXVNREF4IiwiYXBwX3ZlcnNpb24iOm51bGwsImdlbmVyYXRlZF90aW1lc3RhbXAiOiIyMDIzLTEyLTI5IDE0OjU0OjEwIiwiaXBfYWRkcmVzcyI6IjEyMi4xNzYuNTMuMTkyIn0.BZF3795oRwh3_Uhti4LVIrlvRX3hGZmYY5Qayd00JPw";

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
         
          $query=$this->db->get_where('partner_loan_plan',$where);
         
          if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        } 
      }
	  
	          public function updateLoanDetails($loanDetail) {
				  $loanDetail_arr = $loanDetail[0];
				//  echo"<pre>"; print_r($loanDetail); die();
				  
          $loanDetails = array(
              'approved_loan_amount' => $loanDetail_arr['amount'],
              'approved_interest' => $loanDetail_arr['interest'],
              'approved_tenor_days' => $loanDetail_arr['tenor'],
			  'approved_tenor'=>0
          );
      
          $where = array(
              'borrower_id' => $loanDetail['borrower_id'],
              'loan_no' => $loanDetail['loan_no'],
          );
      
          $this->db->where($where);
      
          $this->db->update('p2p_loan_list', $loanDetails);

            return 1;
          
      }

}
?>
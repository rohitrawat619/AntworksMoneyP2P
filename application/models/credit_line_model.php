<?php 
class credit_line_model extends CI_Model{

public function __construct(){
    $this->apiBaseUrl="https://antworksmoney.com/credit-line/p2papiborrower/";
    $this->authorization="Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==";
    $this->oath_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjA3MTk1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiNjM5NTEzMDc4NyIsImRldmljZV9pZCI6IlVsTlNNUzR5TURFd01UTXVNREF4IiwiYXBwX3ZlcnNpb24iOm51bGwsImdlbmVyYXRlZF90aW1lc3RhbXAiOiIyMDIzLTEyLTI5IDE0OjU0OjEwIiwiaXBfYWRkcmVzcyI6IjEyMi4xNzYuNTMuMTkyIn0.BZF3795oRwh3_Uhti4LVIrlvRX3hGZmYY5Qayd00JPw";

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
    
        public function loan_eligiblity_status($borrower_id){
    
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
        public function disbursement_request($borrower_id,$loan_id){
            
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

}
?>
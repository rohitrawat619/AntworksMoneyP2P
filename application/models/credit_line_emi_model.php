<?php 
class credit_line_emi_model extends CI_Model{

public function __construct(){
    $this->apiBaseUrl="https://antworksmoney.com/credit-line/p2papiborrower/";
    $this->authorization="Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==";
    $this->oath_token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMjA3MTk1Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiNjM5NTEzMDc4NyIsImRldmljZV9pZCI6IlVsTlNNUzR5TURFd01UTXVNREF4IiwiYXBwX3ZlcnNpb24iOm51bGwsImdlbmVyYXRlZF90aW1lc3RhbXAiOiIyMDIzLTEyLTI5IDE0OjU0OjEwIiwiaXBfYWRkcmVzcyI6IjEyMi4xNzYuNTMuMTkyIn0.BZF3795oRwh3_Uhti4LVIrlvRX3hGZmYY5Qayd00JPw";

}


public function add_loan_proposal($data){
	// return $data['borrower_id'];	

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/addLoanProposal',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		"borrower_id":"'.$data['borrower_id'].'",
		"p2p_product_id":"4",
		"loan_amount":"'.$data['loan_amount'].'",
		"tenor_months":"'.$data['loan_tenor'].'",
		"loan_description":"'.$data['loan_description'].'"
	
	}',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));
	
	$response = curl_exec($curl);
	
	curl_close($curl);
	// echo $response;
	$response=(array)json_decode($response);
return $response;

	}



    public function view_loan_agreement(){
		
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/viewLoanAgreement',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "bid_registration_id":"3"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Cookie: p2p_2018_2019_session=vseplhib3viuphvnqe1lkhcdbq885cut'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        // echo $response;
        
        $response=(array)json_decode($response);
        return $response;
        
            }



            public function my_loan_statement(){
		
                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/myloanStatement',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "loan_no": "LN10000000003"
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                echo $response;
                
                    }
                
                
                    public function emi_payment(){
                        
                $curl = curl_init();
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'localhost/antworksp2p.com/p2papiborrower/borrowerres/emiPayment',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                "emi_id": "231",
                "bid_registration_id": "3"
                   
                }',
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: p2p_2018_2019_session=7525va6694fhut3t0old51s165ehptnj'
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);
                echo $response;
                
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
                                


}
?>
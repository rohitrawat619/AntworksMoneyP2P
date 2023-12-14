<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_line extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        
    }

public function info(){
    $data=array();
    $mobile=6395130787;
    $_SESSION['mobile']=$mobile;
    
    $get_user_details=$this->get_borrower_details($mobile);
    $_SESSION['borrower_id']=$get_user_details['borrower_id'];
    
    foreach ($get_user_details['loan_details'] as $loan_details) {
      $_SESSION['loan_id']=$loan_details->id;
    }
    
    // echo "<pre>";print_r($get_user_details);die();
    
    $data['get_borrower_details']=$get_user_details;
    $this->load->view('credit_line_templates/header',$data);
    $this->load->view('credit_line_templates/nav',$data);
    $this->load->view('credit_line/credit_line',$data);
    $this->load->view('credit_line_templates/footer',$data); 
    // die();


}

public function waiting(){
  
  $data=array();

  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/waiting');
  $this->load->view('credit_line_templates/footer',$data); 
}

public function waiting_ajax(){

  $loan_eligiblity_status=$this->loan_eligiblity_status($_SESSION['borrower_id']);
  $_SESSION['loan_id']=$loan_eligiblity_status['loan_id'];
  // echo "hello";die();
  echo json_encode($loan_eligiblity_status); die();

  
}
public function success(){

  $data=array();

  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/success');
  $this->load->view('credit_line_templates/footer',$data);
}

public function e_sign(){
  

  $data=array();
  
  $credit_line_sanction_details=$this->credit_line_saction_details($_SESSION['borrower_id'],$_SESSION['loan_id']);

  $view_loan_agreement=$this->viewLoanaggrement($_SESSION['borrower_id']);
  // echo "<pre>";print_r($view_loan_agreement);die();
  $data['view_loan_agreement']=$view_loan_agreement;
  $data['credit_line_sanction_details']=$credit_line_sanction_details;
  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/e_sign',$data);
  $this->load->view('credit_line_templates/footer',$data);
}
public function e_sign_send_otp_ajax(){

  $response=$this->credit_line_sendOtpsignature($_SESSION['borrower_id'],$_SESSION['loan_id']);

  echo json_encode($response);die();
}
public function e_sign_verify_otp_ajax(){

  $otp=$this->input->post('otp');
  $response=$this->credit_line_verifyOtpsignature($_SESSION['borrower_id'],$_SESSION['loan_id'],$otp);

  echo json_encode($response);die();
}
public function otp(){

  $data=array();
  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/otp',$data);
  $this->load->view('credit_line_templates/footer',$data);

}

public function e_sign_success(){
  
  $data=array();
  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/e_sign_success');
  $this->load->view('credit_line_templates/footer',$data);
}

public function dashboard(){

  $data=array();
  
  $loan_details=$this->loan_details($_SESSION['borrower_id']);
  // echo "<pre>";print_r($loan_details);die();

  
  $data['loan_details']=$loan_details;
  $this->load->view('credit_line_templates/header',$data);
  $this->load->view('credit_line_templates/nav');
  $this->load->view('credit_line/dashboard',$data);
  $this->load->view('credit_line_templates/footer',$data);
}

public function disburse(){
  // $_SESSION['borrower_id'];
  // $_SESSION['loan_id']=192;

  $disburse=$this->disbursement_request($_SESSION['borrower_id'],$_SESSION['loan_id']);
  // $response=array('borrower_id'=>$_SESSION['borrower_id'],'loan_id'=>$_SESSION['loan_id']);
  echo json_encode($disburse);die();


  
}

// Credit-line Api Starts
public function viewLoanaggrement($borrower_id){
  
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerloan/viewLoanaggrement',
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
    'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJib3Jyb3dlcl9pZCI6IjIxODEifQ.S9C3AyV9nNvrKc7R4CpvUFcIrp46fg7On5HmoCYgOIk',
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=0hbknto9ttpu4svedvkdv9ukf0c7ta91'
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
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/get_borrower_details',
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
    'Authorization: Basic Q3JlZGl0X0xpbmU6Q3JlZGl0X0xpbmVfMiEyMg==',
    'Content-Type: application/json',
    'Auth-Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjJfMjAyMi0xMS0xNyAxNDo1Njo1MCI.8zv9KTWIztsVkvTywkQFz7LOMuI4VXUcoX6Or7UtcDM',
    'Cookie: p2p_2018_2019_session=20ashq487iibsab9rq37diquh5smk1md'
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
    CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/loan_eligibility_status',
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
      'Authorization: Basic Q3JlZGl0X0xpbmU6Q3JlZGl0X0xpbmVfMiEyMg==',
      'Content-Type: application/json',
      'Auth-Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjJfMjAyMi0xMS0xNyAxNDo1Njo1MCI.8zv9KTWIztsVkvTywkQFz7LOMuI4VXUcoX6Or7UtcDM'
      
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
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/credit_line_sanction_details',
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
    'Content-Type: application/json',
    'Auth-Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjJfMjAyMi0xMS0xNyAxNDo1Njo1MCI.8zv9KTWIztsVkvTywkQFz7LOMuI4VXUcoX6Or7UtcDM',
    'Authorization: Basic Q3JlZGl0X0xpbmU6Q3JlZGl0X0xpbmVfMiEyMg==',
    'Cookie: p2p_2018_2019_session=v9gs1boi05h4f82gps386cfl82mv9nc0'
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
        CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerloan/credit_line_sendOtpsignature',
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
          'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJiZWZvcmVfbG9naW4iOnRydWV9.sMIgmo8-VbbrSthg9oI2vCrY5DMk7aEWODDnKYQUg-w',
          'Content-Type: application/json',
          'Cookie: p2p_2018_2019_session=595nenkm5m1mossfglkloeos5dr5dq7m'
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
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerloan/credit_line_verifyOtpsignature',
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
    'Authorization: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJiZWZvcmVfbG9naW4iOnRydWV9.sMIgmo8-VbbrSthg9oI2vCrY5DMk7aEWODDnKYQUg-w',
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=4fnevn6ltq4nviafq5s4jrg3s7uabnme'
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
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerloan/loan_details',
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
    'Content-Type: application/json',
    'Cookie: p2p_2018_2019_session=4fnevn6ltq4nviafq5s4jrg3s7uabnme'
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
        CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/disbursement_request',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "borrower_id":"3103",
          "loan_id":"196"
      }',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
          'oath_token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMTM2MTMwIiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiODAwNjAzNDA0MSIsImRldmljZV9pZCI6IlpHVmpNRFkxTVRBM1l6SmtOVGRoTXc9PSIsImFwcF92ZXJzaW9uIjpudWxsLCJnZW5lcmF0ZWRfdGltZXN0YW1wIjoiMjAyMy0xMi0wNSAxNDoyNTo0MCIsImlwX2FkZHJlc3MiOiIxMjIuMTc2LjcwLjMxIn0.TYu9FFExjPsuCQ978RwEmfi9DYLC23xLlXOyjBRUOTc',
          'Content-Type: application/json',
          'Cookie: p2p_2018_2019_session=i6k4b218fkdhnmadm3cb5sgkpji0vcfi'
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
  CURLOPT_URL => 'https://antworksmoney.com/credit-line/p2papiborrower/borrowerloan/loan_after_payment',
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
    'Content-Type: application/json'
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
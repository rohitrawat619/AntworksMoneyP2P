<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;
 


class invest extends RestController

//class invest extends CI_Controller
{

    function index()
{
$this->load->library('Rest',$config);


}
public function __construct()
    { 
     
        parent::__construct();
        //parent::__construct();
        $this->load->model('DetailModel');
        $this->load->library('form_validation');

       
  

    }
//Successfull and Unauthorised response
    // $this->set_response(json_decode($response, true), RestController::HTTP_OK);
	// 	$this->set_response("Unauthorised", RestController::HTTP_UNAUTHORIZED);

    public function login_users() {
        $data = array();
        if ($this->input->post('submit')) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user_data = $this->User_model->check_login($email, $password);
            if ($user_data) {
                $this->session->set_userdata('user_id', $user_data['id']);
                $this->session->set_userdata('user_email', $user_data['email']);
                redirect('dashboard');
            } else {
                $data['error'] = 'Invalid Email or Password';
            }
        }
        $this->load->view('login', $data);
    }

    public function logout_users() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        redirect('invest/login_users');
    }

    public function fetch_post()
    {


       $resultdet = $this->DetailModel->data_t();


        //print_r($resultdet); 
        //$userModel = model(DetailModel::class);
        //$resultDet=$dataa->data_t();
        
        $this->response($resultdet,200);

        //return $resultdet;

    }


   
public function generateApiKey() {
    return (bin2hex(random_bytes(32)));
  }
  

public function vend_reg_post()
    {  
        $star=apache_request_headers();
        $akey = $star['X-API-KEY'];
      

        if($akey=="startest")
        {
            $data = file_get_contents('php://input');
            $rqst = json_decode($data, true);
            // var_dump($rqst);
            // exit;
          
            if(count($rqst)==10)
            {
                $vdetails =   array_splice($rqst, 0, 5);
            }
           
        }
            //vendor details $rqst only representaive details
           
        //     if(count($rqst)==9)
        //    { $vdetails =   array_splice($rqst, 0, 5); } 
        //    if(count($rqst)==5)
        //    { $vdetails = $rqst ; }
        //    if(count($rqst)==4)
        //    { $rqst = $rqst ; }
            if(isset($vdetails))
           {   if(count($vdetails)==5){

            if(!($this->DetailModel->vend_check($vdetails)) && (!($this->DetailModel->rep_check($rqst)))){
            $d=time();
            $d= date("Y-m-d h:i:sa", $d);
            $vdetails += array("date_created" => $d);
            $apiKey = $this->generateApiKey();
            $vdetails += array("key" => $apiKey);

            //Insert vendor details
            $iid =  $this->DetailModel->regvendor($vdetails);
            //check if details added or not 
            $result = $this->db->affected_rows();

            if ($result) {
            
            //$rqst = array("Vendor_ID" => $iid);
            $Repid =  $this->DetailModel->regrepresentative($rqst);
            $star = "Vendor and Representative Added Successfully";
            $iids = array($iid,$Repid,$star);
            $this->response($iids,200);
        } else {
            $star = "Sorry some error occured";
            $this->response($star, 200);
        }
           }
 
      
       
        if(($this->DetailModel->vend_check($vdetails)) && !($this->DetailModel->rep_check($rqst))){

            
            $Res['id'] =  $this->DetailModel->regrepresentative($rqst);

            $Res['msg'] = "Vendor Already Exist! Respresentaive added successfully";
            $this->response($Res, 200);

        }

        if(($this->DetailModel->vend_check($vdetails)) && ($this->DetailModel->rep_check($rqst)))
        {
              $resp = "Vendor and Representatives Already Exist!";
              $this->response($resp,200);
        }

        if(!($this->DetailModel->vend_check($vdetails)) && (($this->DetailModel->rep_check($rqst)))){

            $resp = "This Representative already registered with other Vendor";
              $this->response($resp,200);
        }
        else
         {
            $this->response(404);
        }}}

        if(count($rqst)==6)
        
        {
                 if(!($this->DetailModel->rep_check($rqst)))
                 {   $Res['id'] =  $this->DetailModel->regrepresentative($rqst);

                    $Res['msg'] = "Respresentaive added successfully!";
                    $this->response($Res, 200);   }

                 if(($this->DetailModel->rep_check($rqst)))
                 {  $Res['msg'] = "Respresentaive Already Exist!";
                    $this->response($Res, 200); }

        }
        if(count($rqst)==4)
        
        {
                 if(!($this->DetailModel->vend_check($rqst)))
                 {   
                    $d=time();
                    $d= date("Y-m-d h:i:sa", $d);
                    $rqst += array("date_created" => $d);
                    $apiKey = $this->generateApiKey();
                    $rqst += array("key" => $apiKey);
        
                    //Insert vendor details
                    $iid =  $this->DetailModel->regvendor($rqst);
                    $Res['msg'] = "Respresentaive added successfully!";
                    $this->response($Res, 200);   }

                 if(($this->DetailModel->vend_check($rqst)))
                 {  $Res['msg'] = "Vendor Already Exist!";
                    $this->response($Res, 200); }
        }
        else
        {
           $this->response(404);
       }
  
    }
    
    //raw vendor
    // 1	id Primary	int(11)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
	// 2	Company_Name	varchar(80)	utf8_general_ci		No	None			Change Change	Drop Drop	
	// 3	Email	varchar(80)	utf8_general_ci		No	None			Change Change	Drop Drop	
	// 4	Password	varchar(60)	utf8_general_ci		No	None			Change Change	Drop Drop	
	// 5	user_id	int(11)			No	None			Change Change	Drop Drop	
	// 6	key	varchar(40)	utf8_general_ci		No	None			Change Change	Drop Drop	
	// 7	level	int(2)			No	None			Change Change	Drop Drop	
	// 8	ignore_limits	tinyint(1)			No	0			Change Change	Drop Drop	
	// 9	is_private_key	tinyint(1)			No	0			Change Change	Drop Drop	
	// 10	ip_addresses	text	utf8_general_ci		Yes	NULL			Change Change	Drop Drop	
	// 11	date_created	timestamp			No	current_timestamp()		ON UPDATE CURRENT_TIMESTAMP()	Change

    
// testing json
// {
//     "Company_Name": "Phone Pay",
//     "Address": "atrioonnnn",
//     "Phone": "12345778",
//     "RepName": "repname",
//     "RepDesignation": "Designation",
//     "Repphone": "12356677",
//     "Repemail": "Starrep@test.com",
//     "Vendor_ID": "3" 
//     }
 
 
// function increment_string($string) {
//   // Remove all non-alphanumeric characters from the string
//   $string = preg_replace("/[^a-zA-Z0-9]+/", "", $string);

//   // Convert the string to an array of characters
//   $characters = str_split($string);

//   // Start from the rightmost character and increment it by 1
//   for ($i = count($characters) - 1; $i >= 0; $i--) {
//       // If the character is 9, set it to A and move to the next character
//       if ($characters[$i] == '9') {
//           $characters[$i] = 'A';
//           break;
//       }
//       // If the character is Z, set it to A and move to the next character
//       else if ($characters[$i] == 'Z') {
//           $characters[$i] = 'A';
//       }
//       // If the character is any other alphanumeric character, increment it by 1
//       else {
//           $characters[$i] = chr(ord($characters[$i]) + 1);
//           break;
//       }
//   }

//   // Return the incremented string
//   return implode($characters);
// }
public function total_invest($sname,$uid)
{
    $db2 = $this->load->database('schemesdb', TRUE);
    $db2->select('Investment_Amt');
    $db2->from($sname); 
    $db2->where('User_ID', $uid);
    $query =  $db2->get();
    $result = $query->result_array();

        $total = 0;
 foreach($result as $value)
 {
            $val = implode(" ", $value);
            $total =  $total + $val;
 }

   return $total;

}



function validate_age($DOB) {
    $min_age = 18;
    $date_of_birth = new DateTime($DOB);
    $today = new DateTime();
    $interval = $today->diff($date_of_birth);
    $age = $interval->y;
    return ($age >= $min_age);
  }
  


       function validate_pan($str)
    {
            $pattern = "/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/";
            if (!preg_match($pattern, $str)) {
                return FALSE;
            } else {
                return TRUE;
            }
        }


    public function basi_kyc_post()
    {
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);
        $PAN = $rqst['PAN'];
        $fullname = $rqst['fullname'];
      $result = json_decode($this->DetailModel->basic_pan_kyc($PAN,$fullname),TRUE); 
      $Panmatch = $result['result']["pan"];
      $namematch = $result['result']["name_match_score"];
//   var_dump($namematch);
//   exit;
    if($Panmatch==$PAN && $namematch===100){ 
        $response = "Verified Successfully";
        $this->set_response(json_encode($response, true)); 
    }
  else  {
          $this->set_response("Please Enter correct PAN Card Details");
        }
   
    }


    public function testing2_post()
{
   
   

    $TRY = json_decode(file_get_contents('php://input'), true);
    $sname = $TRY['scheme'];
    $uid=$TRY['iid'];
    $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
//    $res = $this->current_value($sname,$uid);
   echo "<pre>";
   print_r($result0);

    //body data
    // $_POST = json_decode(file_get_contents('php://input'), true);
    // $this->form_validation->set_rules('dcode','dcode','required|regex_match[/^[0-9]+$/]');
    // // $this->form_validation->set_rules('dcode','dcode','required|valid_email');

    // if ($this->form_validation->run() ==TRUE) {
    //     // Validation passed, process the form data
    //     echo "testing";
    // } else {
    //     // Validation failed, display error messages
    //     // $errors = $this->form_validation->error_array();
    //     echo "failed";
    // }


//      $phone = $rqst['phone'];
//    $email = $rqst['email'];
//     $fullname = $rqst['fullname'];
//     $rqst['password'] = md5($rqst['password']);
//     $PAN = $rqst['PAN'];

//         $userd = ['phone' => $phone,
//             'email' => $email,
//             'fullname' => $fullname,
//             'PAN' => $PAN ];  

//  $res = $this->DetailModel->check_user($userd);  
//  var_dump($res);
}

public function pan_unique($PAN)
{
    $query = $this->db->query("SELECT id FROM users1 WHERE PAN = '$PAN'");
        $result = $query->row_array();
        return $result;
}
    public function user_reg_post()
    {
        //apicheck
        $star = apache_request_headers();
        $akey = $star['X-API-KEY'];
        $res = $this->DetailModel->vID_check($akey);
        $Vendor_ID = $res['VID'];
        //body data
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);
       $tname = "users1";
       $fID = $this->DetailModel->latestiddb1($tname);
        
       $id = $fID['UID'];
       $userid = $id + 1;
         $phone = $rqst['phone'];
       $email = $rqst['email'];
        $fullname = $rqst['fullname'];
        $rqst['password'] = md5($rqst['password']);
        $PAN = $rqst['PAN'];
        $DOB = $rqst['DOB'];

      //  $respp = $this->pan_unique($PAN);

        if(($this->pan_unique($PAN))>0) {
            $resp = "Sorry PAN is already registered";
            $this->response($resp,200);
        exit;  }

        //Validating age and PAN No. Pattern
       if(($this->validate_pan($PAN)) && (!$this->validate_age($DOB))) {
        $resp = "You should be above 18 for investing"; 
        $this->response($resp,200);
        exit; }

       elseif((!$this->validate_pan($PAN)) && ($this->validate_age($DOB))) 
        {$resp = "Enter Valid PAN Card Number";
            $this->response($resp,200);
            exit;}
    
       elseif ((!$this->validate_pan($PAN)) && (!$this->validate_age($DOB))) 
         {  $resp = "Please Enter valid Pan and Dob"; 
            $this->response($resp,200);
            exit;
          }  

       else{
            $userd = ['phone' => $phone,
                'email' => $email,
                'fullname' => $fullname]; 
               // 'PAN' => $PAN ];  
            //  $res =  $this->DetailModel->check_user($userd);
            //  var_dump($res);
            //  die();
                       // Check if user already exist
                     if($this->DetailModel->check_user($userd)) 
                     {
                        $resp = "User Already Exist!";
                        $this->response($resp,200); } 
                        else { 
                              //Create date Time Stamp
                          $d = time();
                          $d = date("Y-m-d h:i:sa", $d);
                         $rqst += array("Reg_Date" => $d);
                           $rqst += array("Vendor_ID" => $Vendor_ID);
                         $response = $this->DetailModel->reguser($rqst);
                         $result = $this->db->affected_rows();
                         if ($result>0) {
                            $this->set_response(json_decode($response, true), RestController::HTTP_OK);
                                            } 
                            else {
                            $this->set_response("Some Error Occured Please Try Again!", RestController::HTTP_UNAUTHORIZED);    
                                 }                        
                            }
                           
                        }
        
    }

// testing json
// {
//     "Vendor_ID": "1",
//         "fullname": "Rohit Dalal",
//         "email": "startest11",
//         "password": "raxop",
//         "phone": "1256",
//         "status": "1",
//         "DOB":"24/01/1999"
//         "Account_No":"123457834545",
//         "IFSC":"IFSC1234",
//         "PAN":"CXFPD3663J"
//     }
    public function user_regtest_post()
    {


           //body data
    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('fullname','fullname','required|');
    $this->form_validation->set_rules('email','email','required|valid_email');
    $this->form_validation->set_rules('password','password','required|');
    $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]+$/]');
    $this->form_validation->set_rules('DOB','DOB','required|regex_match[/^[0-9]+$/]');
    $this->form_validation->set_rules('Account_No','Account_No','required|regex_match[/^[0-9]+$/]');
    $this->form_validation->set_rules('IFSC','IFSC','required|');
    $this->form_validation->set_rules('PAN','PAN','required|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
    // $this->form_validation->set_rules('dcode','dcode','required|regex_match[/^[0-9]+$/]');
    // $this->form_validation->set_rules('dcode','dcode','required|valid_email');

    if ($this->form_validation->run() == TRUE) {

         //apicheck
         $star = apache_request_headers();
         $akey = $star['X-API-KEY'];
         $res = $this->DetailModel->vID_check($akey);
         $Vendor_ID = $res['VID'];
         //body data
         $data = file_get_contents('php://input');
         $rqst = json_decode($data, true);
        $tname = "users1";
        $fID = $this->DetailModel->latestiddb1($tname);
         
        $id = $fID['UID'];
        $userid = $id + 1;
          $phone = $rqst['phone'];
        $email = $rqst['email'];
         $fullname = $rqst['fullname'];
         $rqst['password'] = md5($rqst['password']);
         $PAN = $rqst['PAN'];
         $DOB = $rqst['DOB'];
 
       //  $respp = $this->pan_unique($PAN);
 
         if(($this->pan_unique($PAN))>0) {
             $resp = "Sorry PAN is already registered";
             $this->response($resp,200);
         exit;  }
 
         //Validating age and PAN No. Pattern
        if(($this->validate_pan($PAN)) && (!$this->validate_age($DOB))) {
         $resp = "You should be above 18 for investing"; 
         $this->response($resp,200);
         exit; }
 
        elseif((!$this->validate_pan($PAN)) && ($this->validate_age($DOB))) 
         {$resp = "Enter Valid PAN Card Number";
             $this->response($resp,200);
             exit;}
     
        elseif ((!$this->validate_pan($PAN)) && (!$this->validate_age($DOB))) 
          {  $resp = "Please Enter valid Pan and Dob"; 
             $this->response($resp,200);
             exit;
           }  
 
        else{
             $userd = ['phone' => $phone,
                 'email' => $email,
                 'fullname' => $fullname]; 
                // 'PAN' => $PAN ];  
             //  $res =  $this->DetailModel->check_user($userd);
             //  var_dump($res);
             //  die();
                        // Check if user already exist
                      if($this->DetailModel->check_user($userd)) 
                      {
                         $resp = "User Already Exist!";
                         $this->response($resp,200); } 
                         else { 
                               //Create date Time Stamp
                           $d = time();
                           $d = date("Y-m-d h:i:sa", $d);
                          $rqst += array("Reg_Date" => $d);
                            $rqst += array("Vendor_ID" => $Vendor_ID);
                          $response = $this->DetailModel->reguser($rqst);
                          $result = $this->db->affected_rows();
                          if ($result>0) {
                             $this->set_response(json_decode($response, true), RestController::HTTP_OK);
                                             } 
                             else {
                             $this->set_response("Some Error Occured Please Try Again!", RestController::HTTP_UNAUTHORIZED);    
                                  }                        
                             }
                            
                         }
      
    } else {
        $errmsg = array("error_msg" => validation_errors());
        $this->set_response($errmsg, RestController::HTTP_OK);
        return;
    } 
        
    }
//raw
// 1	id Primary	int(11)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
// 	2	Lender_ID	varchar(40)	utf8_unicode_ci		No	None			Change Change	Drop Drop	
// 	3	Vendor_ID	int(11)			No	None			Change Change	Drop Drop	
// 	4	Scheme_ID	int(11)			No	None			Change Change	Drop Drop	
// 	5	fullname	varchar(200)	utf8_unicode_ci		No	None			Change Change	Drop Drop	
// 	7	email	varchar(50)	utf8_unicode_ci		No	None			Change Change	Drop Drop	
// 	8	password	varchar(255)	utf8_unicode_ci		No	None			Change Change	Drop Drop	
// 	9	phone	varchar(20)	utf8_unicode_ci		Yes	NULL			Change Change	Drop Drop	
// 	10	Reg_Date	datetime			No	None			Change Change	Drop Drop	
// 	11	Investment_Date	datetime			No	None			Change Change	Drop Drop	
// 	12	status



    public function test1_scheme_post()
    {
        //Getting details from request
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);

        $Vendor_ID = $rqst['Vendor_ID'];
        $User_ID = $rqst['User_ID'];
        

       //Getting Scheme name from table
        $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
        $result = $query->result_array();
//Processing each table name
foreach ($result as $row) {
    $sname = array($row['Scheme_Name']);
        $this->DetailModel->lenderdetails1_show($sname,$User_ID);
        $results = $this->db->affected_rows();

        if ($results) {
            $this->output->set_content_type('application/json');
            $this->output->set_output(json_encode($result));
        } else {
            $star = "Failed";
            $this->response($star, 200);
        }
    
}

        // foreach ($sname as $res) {
        //     echo $res;
        // }

        // foreach ($sname as $row) {
        //    // echo $row['Scheme_Name'];
        //     $sname += array($row['Scheme_Name']);
        //     return $sname;
        // }
        //$sname = $name['Scheme_Name'];
        
       // $Vendor_ID = $name['Vendor_ID'];
       // echo $Vendor_ID ." ".$sname;
       // $this->Scheme_table($sname);
       // $this->load
      //  echo $sname;
      
        
    }

    // 1	ID Primary	int(20)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
	// 2	User_ID	int(20)			No	None			Change Change	Drop Drop	
	// 3	Investment_ID	varchar(50)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
	// 4	fullname	varchar(200)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
	//
	// 6	Investment_Amt	int(20)			No	None			Change Change	Drop Drop	
	// 7	Investment_type	varchar(5)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
	// 8	Investment_date	datetime			No	None			Change Change	Drop Drop	
	// 9	Redeem_date	datetime			No	None			Change Change	Drop Drop	
	// 10	Status	varchar(15)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
	// 11	PAN	varchar(20)	utf8mb4_general_ci	

// //     testing json
// {
//     "Scheme_ID":"3",
//     "User_ID": "2",
//     "fullname": "Star rax",
//     "Investment_Amt": "10000",
//     "Investment_type": "auto",
//     "status": "1"
// }

public function reguser_scheme_post()
{  
    //Getting details from request
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    $Scheme_ID = $rqst['Scheme_ID'];
    $query = $this->db->query("SELECT Scheme_Name,Vendor_ID FROM scheme_details WHERE SID = '$Scheme_ID'");
    $name = $query->row_array();
    $sname = strtolower($name['Scheme_Name']);
   $Vendor_ID = $name['Vendor_ID'];


  //checking table and creating if don't exist
  $this->load->dbforge();
  $db2 = $this->load->database('schemesdb', TRUE);
  if($db2->table_exists($sname)===false) { 
    //$this->Scheme_table($sname); 
    echo "test";
}


  $fID = $this->DetailModel->latestiddb2($sname);
  $id = $fID['IID'];
        $id = $id + 1;

    $d = time();
    $d = date("d/m/y", $d);
    $rqst += array("Investment_date" => $d);

    $Investment_ID = $id."-" . $Vendor_ID . "-" . $Scheme_ID . "-".date("dmy");
    $rqst += array("Investment_ID" => $Investment_ID);
    $SID = $rqst['Scheme_ID'];
     unset($rqst['Scheme_ID']);
     $rqst += array("SID" => $SID);
     $folio = rand(100000000000,9999999999);
     $rqst += array("Folio" => $folio);
     $rqst += array("Vendor_ID" => $Vendor_ID);

        $iid = $this->DetailModel->regschemeusers($sname,$rqst);
   
        $result = $db2->affected_rows();
    if ($result) {
        $star = "Done";
            $iid = array($iid, $star);
        $this->response($iid , 200);
    } else {
        $star1 = "Failed";
        $iid = array('0', $star1);
        $this->response($iid, 200);  }   //$this->response($resultdet, 200);
   }


//raw scheme details
//    1	VID Primary	int(11)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
// 	2	Vendor_ID	int(11)			No	None			Change Change	Drop Drop	
// 	3	Scheme_Name	varchar(40)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
// 	4	Min_Inv_Amount	int(10)			No	None			Change Change	Drop Drop	
// 	5	Max_Inv_Amount	int(20)			No	None			Change Change	Drop Drop	
// 	6	Aggregate_Amount	int(10)			No	None			Change Change	Drop Drop	
// 	7	Lockin	tinyint(1)			No	None			Change Change	Drop Drop	
// 	8	Interest_Rate	decimal(5,0)			No	None			Change Change	Drop Drop	
// 	9	Interest_Type	varchar(40)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
// 	10	Withrawl_Anytime	tinyint(1)			No	None			Change Change	Drop Drop	
// 	11	Pre_Mat_Rate	decimal(5,0)			No	None			Change Change	Drop Drop	
// 	12	Lockin_Period	int(10)			No	None			Change Change	Drop Drop	
// 	13	Tenure	int(10)			No	None			Change Change	Drop Drop	
// 	14	Auto_Redeem tinyint(1)

// Vendor_ID
// Scheme_Name
// Min_Inv_Amount
// Max_Inv_Amount
// Aggregate_Amount
// Lockin
// Cooling_Period
// Interest_Rate
// Interest_Type
// Withrawl_Anytime
// Pre_Mat_Rate
// Lockin_Period
// Tenure
// Auto_Redeem

// testing json
// {
//        "Scheme_Name": "Astro_op",
//         "Min_Inv_Amount": "100000",
//         "Max_Inv_Amount": "1000000",
//         "Aggregate_Amount": "12300",
//         "Lockin": "0",
//         "Cooling_Period": "10",
//         "Interest_Rate": "10",
//         "Interest_Type": "simple",
//         "Withrawl_Anytime": "1",
//         "Pre_Mat_Rate": "3",
//         "Lockin_Period": "60",
//         "Tenure": "180",
//         "Auto_Redeem": "1"
//     }


   public function Scheme_add_post()
   {  
       //apicheck
    //    $star=apache_request_headers();
    //    $akey = $star['X-API-KEY'];

    //    $res = $this->DetailModel->vID_check($akey);

    //    $Vendor_ID =  $res['VID'];
     
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
        //    var_dump($rqst);
        //    exit;
            
          // Check if scheme already exist
       if(!($this->DetailModel->scheme_check($rqst))){
           //$d=time();
           //$d= date("Y-m-d h:i:sa", $d);
           $rqst += array("Vendor_ID" => $Vendor_ID);
           $schemename = strtoupper($rqst['Scheme_Name']);
           unset($rqst['Scheme_Name']);
           $rqst += array("Scheme_Name" => $schemename);

           //Insert Scheme details details
          $iid = $this->DetailModel->regscheme($rqst);

           //check if details added or not 
           $result = $this->db->affected_rows();

       if ($result) {
        $this->Scheme_table($rqst['Scheme_Name']);
           $star = "Scheme Added Successfully";
           $this->response($iid, 200);
       } else {
           $star = "Sorry some error occured try again";
           $this->response($star, 200);
       }
          }
        
       else
       {
           
           $resp =  "Scheme Already Exist!";
             $this->response($resp, 200);
         
         }
    
           //$this->response($ipad,200);
       }

       public function Scheme_table($sname)
       {
        
           $db2 = $this->load->database('schemesdb', TRUE);
           $this->load->dbforge();
           $createtable = "CREATE TABLE $sname ( " .
           "IID INT(20) NOT NULL AUTO_INCREMENT, " .
           "User_ID INT(20) NOT NULL, " .
           "SID INT(20) NOT NULL, " .
           "Vendor_ID INT(20) NOT NULL, " .
           "Folio VARCHAR(15) NOT NULL, " .
           "Investment_ID VARCHAR(50) NOT NULL, " .
           "Reinvestment tinyint(1) NOT NULL, " .
           "Investment_Amt INT(20) NOT NULL, " .
           "Investment_type VARCHAR(5) NOT NULL, " .
           "Investment_date datetime NOT NULL, " .
           "Redeem_date datetime NOT NULL, " .
           "Status VARCHAR(15) NOT NULL, " .
           "PAN VARCHAR(20) NOT NULL, " .
           "PRIMARY KEY (IID)
           );";

       
                
           $db2->query($createtable);
                
       }

            
    // public function lender_detailshow_post()
    // {
    //      //body data
    // $data = file_get_contents('php://input');
    // $rqst = json_decode($data, true);
    // //$sname = "astro_op";
    // $User_ID = array('User_ID' => '24');
    // $Vendor_ID = $rqst['Vendor_ID'];
    // $db2 = $this->load->database('schemesdb', TRUE);
    // //Getting Scheme name from table
    //  $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
    //  $result = $query->result_array();
    //  $results = array();
    // //  var_dump($result);
    // //  exit;

    //     $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
    //     $result0 += array();
    //         //$result1 = $db2->affected_rows();
    //         $results = array($result0);



    //         if ($result0 > 0) {
    //             $this->output->set_content_type('application/json');
    //             $this->output->set_output(json_encode($result0));
    //         } else {
    //             $star = "Sorry! You Don't have any investments yet!";
    //             $this->response($star, 200);
    //         }
           
    // }

    public function lender_detailshow_post()
    {
         //body data
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    //$sname = "astro_op";
    $User_ID = array('User_ID' => '24');
    $Vendor_ID = $rqst['Vendor_ID'];
    $db2 = $this->load->database('schemesdb', TRUE);
    //Getting Scheme name from table
     $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
     $result = $query->result_array();
     $results = array();
    //  var_dump($result);
    //  exit;

        $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
        $val2 =array();
        foreach($result0 as $val)
        {    
                   // $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
                 // $vale1 = array("Scheme_Name"=>$val['tablename'],"IID"=>$val['IID']);
                 $vale2 = $this->current_value($val['tablename'],$val['IID']);
                // $vale = array_merge($vale1,$vale2);

                $val += array("cvalue"=>$vale2);
             //   $val += array("Interest"=>$vale2);
                $val2[] = $val;
                
                //  $vale['IID'] += $val['IID'];
                //  $vale['Scheme_Name'] += $val['tablename'];

                //  $vale += array("IID" => $val['IID']);

                //  $vale += array("Scheme_Name" => $val['tablename']);
                //  $val2[] = array("CurrentVal" => $value);
               
                //    var_dump($val2);
                //     exit;

        }

            // var_dump($val2);
            //         exit;
        //var_dump($result0);
        //exit;
        //$result0 += array();
            //$result1 = $db2->affected_rows();
            $results = array($result0);

            

            if ($result0 > 0) {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($val2));
            } else {
                $star = "Sorry! You Don't have any investments yet!";
                $this->response($star, 200);
            }
           
    }


    public function vendor_detailshow_post()
    {
         //body data
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    //$sname = "astro_op";
    $User_ID = array('User_ID' => '24');
    $Vendor_ID = $rqst['Vendor_ID'];
    $db2 = $this->load->database('schemesdb', TRUE);
    //Getting Scheme name from table
     $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
     $result = $query->result_array();
     $results = array();
    //  var_dump($result);
    //  exit;

        $result0 = $this->DetailModel->check_valueven($rqst['Vendor_ID'],$result);
        $val2 =array();
        foreach($result0 as $val)
        {    
                   // $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
                 // $vale1 = array("Scheme_Name"=>$val['tablename'],"IID"=>$val['IID']);
                 $vale2 = $this->current_value($val['tablename'],$val['IID']);
                // $vale = array_merge($vale1,$vale2);

                $val += array("cvalue"=>$vale2);
             //   $val += array("Interest"=>$vale2);
                $val2[] = $val;
                
                //  $vale['IID'] += $val['IID'];
                //  $vale['Scheme_Name'] += $val['tablename'];

                //  $vale += array("IID" => $val['IID']);

                //  $vale += array("Scheme_Name" => $val['tablename']);
                //  $val2[] = array("CurrentVal" => $value);
               
                //    var_dump($val2);
                //     exit;

        }

            // var_dump($val2);
            //         exit;
        //var_dump($result0);
        //exit;
        //$result0 += array();
            //$result1 = $db2->affected_rows();
            $results = array($result0);

            

            if ($result0 > 0) {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($val2));
            } else {
                $star = "Sorry! You Don't have any investments yet!";
                $this->response($star, 200);
            }
           
    }


//return all the users under specific vendor
    public function show_all_users_post()
    {
           //Getting details from request
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
   
           $Vendor_ID = $rqst['Vendor_ID'];
          // $User_ID = $rqst['User_ID'];
          //Getting Scheme name from table
           $query = $this->db->query("SELECT * FROM users1 WHERE Vendor_ID = '$Vendor_ID'");
           $result = $query->result_array();
      //Displaying all schemes detail under vendor to lenders
              $results = $this->db->affected_rows();
              if ($results) {
                  $this->output->set_content_type('application/json');
                  $this->output->set_output(json_encode($result));
              } else {
                  $star = "Failed";
                  $this->response($star, 200);
              }
    }

    public function pagination()
{
    // Get the page number and page size from the API request
    $page = $this->input->get('page') ?? 1;
    $page_size = $this->input->get('page_size') ?? 10;

    // Calculate the offset and limit for the query
    $offset = ($page - 1) * $page_size;
    $limit = $page_size;

    // Query the database with the limit and offset
    $this->db->limit($limit, $offset);
    $query = $this->db->get('my_table');

    // Get the total number of results for pagination metadata
    $total_results = $this->db->count_all('my_table');

    // Prepare the API response with pagination metadata
    $response = [
        'page' => $page,
        'page_size' => $page_size,
        'total_results' => $total_results,
        'results' => $query->result_array()
    ];

    // Return the API response
    $this->response($response, RestController::HTTP_OK);
}
    public function all_schemes_post()
    {
           //Getting details from request
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
   
           $Vendor_ID = $rqst['Vendor_ID'];
          // $User_ID = $rqst['User_ID'];
          //Getting Scheme name from table
           $query = $this->db->query("SELECT * FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
           $result = $query->result_array();
      //Displaying all schemes detail under vendor to lenders
              $results = $this->db->affected_rows();
              if ($results) {
                  $this->output->set_content_type('application/json');
                  $this->output->set_output(json_encode($result));
              } else {
                  $star = "Failed";
                  $this->response($star, 200);
              }
    }

    //raw testing
//    {
//         "Interest_Rate": "10",
//         "Investment_Amt": "60",
//         "totaldays": "180"             
//     }

public function testing_post()
{
    
    //body data
  
    //$sname = "astro_op";
    $User_ID = array('User_ID' => '24');
    $Vendor_ID = $rqst['Vendor_ID'];
    $db2 = $this->load->database('schemesdb', TRUE);
    //Getting Scheme name from table  $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
     $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '$Vendor_ID'");
     $result = $query->result_array();
     $results = array();
    //  var_dump($result);
    //  exit;

        $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
        var_dump($result0);
        exit;

          
   

//      $phone = $rqst['phone'];
//    $email = $rqst['email'];
//     $fullname = $rqst['fullname'];
//     $rqst['password'] = md5($rqst['password']);
//     $PAN = $rqst['PAN'];

//         $userd = ['phone' => $phone,
//             'email' => $email,
//             'fullname' => $fullname,
//             'PAN' => $PAN ];  

//  $res = $this->DetailModel->check_user($userd);  
//  var_dump($res);

//     $config = array(
//         'protocol' => 'smtp',
//         'smtp_host' => 'smtp.gmail.com',
//         'smtp_port' => 465,
//         'smtp_user' => 'revantestop@gmail.com',
//         'smtp_pass' => 'revantestop007',
//         'mailtype' => 'html',
//         'charset' => 'utf-8'
//       );
      
//         $this->email->initialize($config);

//         $this->email->from('revantestop@gmail.com', 'Star Test');
//         $this->email->to('starraxtest@gmail.com');
//         $this->email->subject('Testing Email');
//         $this->email->message('Hi, its a testing email');

// if ($this->email->send()) {
//     echo 'Email sent successfully.';
//   } else {
//     echo 'Email sending failed.';
//   }

    // $PAN = "CXFPD6367J";
    // $DOB = "2020/01/22";

  

    // if(($this->validate_pan($PAN)) && (!$this->validate_age($DOB))) {
    //     echo "You should be above 18 for investing";
    // }

    // if((!$this->validate_pan($PAN)) && ($this->validate_age($DOB))) {
    //     echo "Enter Valid PAN Card Number";
    // }
    //     if (!$this->validate_pan($PAN) && (!$this->validate_age($DOB))) {
    //         echo "Please Enter valid Pan and Dob";
    //     }
    //     if ($this->validate_pan($PAN) && ($this->validate_age($DOB))) {
    //         echo "Both are valid";
    //     }

//    $name = "Rohit D";
//        $pan = "CXFPD3663J";

//        $res =$this->DetailModel->basic_pan_kyc($pan,$name);
//         echo $res;
    


   // $data = file_get_contents('php://input');
 //   $rqst = json_decode($data, true);

    //     $sname = "astro_op3";
    //         $uid = "2";

    //   $total =  $this->total_invest($sname, $uid);
    //   echo $total ;
    
    //  $vdetails =   array_splice($rqst, 0, 3);
    //     print_r($vdetails);
    //     print_r($rqst);

    // $db2 = $this->load->database('schemesdb', TRUE);
    // $this->load->dbforge();

    // if (!($db2->table_exists($sname))) {
        // $createtable = "CREATE TABLE $sname ( " .
        //     "ID INT(20) NOT NULL AUTO_INCREMENT, " .
        //     "User_ID INT(20) NOT NULL, " .
        //     "Investment_ID VARCHAR(50) NOT NULL, " .
        //     "fullname VARCHAR(50) NOT NULL, " .
        //     "Investment_Amt INT(20) NOT NULL, " .
        //     "Investment_type VARCHAR(5) NOT NULL, " .
        //     "Investment_date datetime NOT NULL, " .
        //     "Redeem_date datetime NOT NULL, " .
        //     "Status VARCHAR(15) NOT NULL, " .
        //     "PAN VARCHAR(20) NOT NULL, " .
        //     "PRIMARY KEY (ID)
        //     );";

        // $db2->query($createtable);
    // } else {
    //     echo "table already exist";
    // }
    

      //  $this->Scheme_table("starteest111");
     
//     $data = file_get_contents('php://input');
//     $rqst = json_decode($data, true);

//     $Vendor_ID = $rqst['Vendor_ID'];
//     //$User_ID = $rqst['User_ID'];
   


//     $query = $this->db->get_where('scheme_details', array('Vendor_ID' => $Vendor_ID))->row();
//     $result = $query->result_array();
    
// $indexed_array = array_values($result);
//         var_dump($indexed_array);
//         die();
    // for ($i = 0; $i < count($schemes); $i++) {
    //     echo $schemes[$i];
    // }




    //     $sname = "testrax";
    // $this->Scheme_table($sname);
    // $data = file_get_contents('php://input');
    //     $rqst = json_decode($data, true);
    //     $in = $rqst['input'];
    //     $resl = $this->test($in);
    //     echo $resl;
      
     
       
    // $data = file_get_contents('php://input');
    //     $rqst = json_decode($data, true);
        
    //     //$rqst['Password'] = md5($rqst['Password']);

    //     //echo  $rqst['Password'] ;
    //   //  $DOB = $rqst['DOB'];
    //     $PAN = $rqst['PAN'];

    //     $resp = $this->validate_pan($PAN);
    //     var_dump($resp);




        // if ($this->validate_pan($PAN) && $this->validate_age($DOB)) 
        // {
        //     echo "Pan Verified and 18";
        
        // } else 
        // {
        //     echo "Not valid either PAN or age";
        // }
    


}

    public function redeemption_value($datas)
    {
        $select2 = array('Lockin','Cooling_Period','Lockin_Period','Interest_Rate','Pre_Mat_Rate');
        $this->db->select($select2);
        $this->db->from('scheme_details');
        $this->db->where('Scheme_Name', $sname);
        $query = $this->db->get();
        $result1 = $query->result_array();

       $select1 = array('Investment_Amt','Investment_date');

      $db2 = $this->load->database('schemesdb', TRUE);
      $db2->select($select1);
      $db2->from($sname); 
      $db2->where('IID',$uid);
      $query =  $db2->get();
      $result = $query->result_array();
     
      $Lockin = implode (array_column($result1, 'Lockin'));
      $Interest_Rate = implode (array_column($result1, 'Interest_Rate'));
      $Pre_Mat_Rate = implode (array_column($result1, 'Pre_Mat_Rate'));
      $Lockin_Period = implode (array_column($result1, 'Lockin_Period'));
      $Cooling_Period = implode (array_column($result1, 'Cooling_Period'));

      $Investment_Amt = implode (array_column($result, 'Investment_Amt'));
      $Investment_date = implode (array_column($result, 'Investment_date'));
   //   $indexed_result = implode (array_column($result, 'Investment_Amt'));


//Getting investment days
        $redeemdate1 = date('Y-m-d');
        $investdate = new DateTime($Investment_date);
        $redeemdate = new DateTime($redeemdate1);
        $differ=date_diff($investdate,$redeemdate); 
        $totaldays = $differ->format("%a");
        $totaldays = $totaldays - $Cooling_Period;
       

        if($Lockin=1)
        {
           
             $si = $Pre_Mat_Rate*$totaldays/100/365*$Investment_Amt;
                $earning = $si + $Investment_Amt;
                //echo $si."       ";
                echo $earning;
        } 
        
        else {
            $si = $Interest_Rate*$totaldays/100/365*$Investment_Amt;
            $earning = $si + $Investment_Amt;
           // echo $si."       ";
            echo $earning;
        }
    }

    public function current_value($sname,$uid)
    {

      $select2 = array('Lockin','Cooling_Period','Lockin_Period','Interest_Rate','Pre_Mat_Rate');
        $this->db->select($select2);
        $this->db->from('scheme_details');
        $this->db->where('Scheme_Name', $sname);
        $query = $this->db->get();
        $result1 = $query->result_array();

       $select1 = array('Investment_Amt','Investment_date');

      $db2 = $this->load->database('schemesdb', TRUE);
      $db2->select($select1);
      $db2->from($sname); 
      $db2->where('IID',$uid);
      $query =  $db2->get();
      $result = $query->result_array();
     
      $Lockin = $result1['0']['Lockin'];
      $Interest_Rate =  $result1['0']['Interest_Rate'];
      $Pre_Mat_Rate = $result1['0']['Pre_Mat_Rate'];
      $Lockin_Period = $result1['0']['Lockin_Period'];
      $Cooling_Period = $result1['0']['Cooling_Period'];

      $Investment_Amt = $result['0']['Investment_Amt'];
      $Investment_date = $result['0']['Investment_date'];
    //   $indexed_result = $result['0']['indexed_result'];


//Getting investment days
        $redeemdate1 = date('Y-m-d');
        $investdate = new DateTime($Investment_date);
        $redeemdate = new DateTime($redeemdate1);
        $differ=date_diff($investdate,$redeemdate); 
        $totaldays = $differ->format("%a");
        $totaldays = $totaldays - $Cooling_Period;
       
// if($totaldays > 0)
//    {  
        if($Lockin==1)
        {
            if($totaldays >= $Lockin_Period)
           { 
            $si = $Pre_Mat_Rate*$totaldays/100/365*$Investment_Amt;
            $earning = $si + $Investment_Amt;
            //echo $si."       ";
           // echo $earning;
           }
           else{
             $earning = "You are under Lockin Period";
           }
        } 
        
        else {
            if($totaldays > 0)
            { $si = $Interest_Rate*$totaldays/100/365*$Investment_Amt;
            $earning = $si + $Investment_Amt;
           // echo $si."       ";
            //echo $earning;
            }
        else{
            $earning = $Investment_Amt;
            }
        } 
    // }

      
$earnings = array("value"=>$earning,"Interest"=>$Interest_Rate);
        
       return $earnings;

}


public function allvendors_post()
{
   $query = $this->db->query("SELECT VID,Company_Name FROM vendors");
   $result = $query->result_array();
   $result0 = $this->db->affected_rows();
   
   if ($result0 > 0) {
    $this->output->set_content_type('application/json');
    $this->output->set_output(json_encode($result));
} else {
    $star = "Sorry! You Don't have any investments yet!";
    $this->response($star, 200);
}
}

public function update_valuestts_post()
{
    
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    // var_dump($rqst);
    // exit;
    // $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '3'");
    //  $result = $query->result_array();
    $value['id'] = $rqst['Investment_ID'];
    $value['sname'] = $rqst['scheme'];

    if($rqst['updcd'] == 1)
    {  $upd = array('status'=>'2');   }
    if($rqst['updcd'] == 2)
    {  $upd = array('status'=> '3');   }
   
    

   $star = json_encode($this->DetailModel->update_valuestts($value,$upd));
   $this->response($star, 200);

}

public function update_values_post()
{
    $rqst = json_decode(file_get_contents('php://input'), true);
    if($rqst['updcode'] == 1)
    { $upd = array('VID'=>'VID');    }
    if($rqst['updcode'] == 2)
    {  $upd = array('RID'=>'RID');  }
    if($rqst['updcode'] == 3)
    {  $upd = array('SID'=>'SID');   }
    if($rqst['updcode'] == 4)
    {  $upd = array('UID'=>'UID');  }

    // var_dump($rqst);
    // exit;
    // $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE Vendor_ID = '3'");
    //  $result = $query->result_array();
    // $value['id'] = $rqst['Investment_ID'];
    // $value['tname'] = $rqst['detail'];
    //$value['status'] = $rqst['Status'];

  
 //  $star = json_encode($this->DetailModel->update_values($value,$upd));
   $this->response($upd, 200);

}


public function del_values_post()
{
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    
    if($rqst['dcode'] == 1)
     { $upd = array('VID'=>$rqst['value']);   
        $value = array('cd' => '0'); 
        $value += array('tname' => 'vendors'); }
    if($rqst['dcode'] == 2)
     {  $upd = array('RID'=>$rqst['value']); 
        $value = array('cd' => '0');
        $value += array('tname' => 'authorised_users'); }
    if($rqst['dcode'] == 3)
     {  $upd = array('SID'=>$rqst['value']);  
        $value = array('cd' => '1'); 
        $value += array('tname' => 'scheme_details');
        }
    if($rqst['dcode'] == 4)
     {  $value = array('cd' => '0');
        $value += array('tname' => 'users1');
        $upd = array('UID'=>$rqst['value']);  }

    // $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE SID = ".$upd['SID']);
    // $result = $query->result_array();

    // var_dump($rqst);
    // var_dump($upd);
    // exit;
   
    // $value['id'] = $rqst['Investment_ID'];
    // $value['tname'] = $rqst['detail'];
    //$value['status'] = $rqst['Status'];

   
  $star = json_encode($this->DetailModel->del_values($value,$upd));
   $this->response($star, 200);

}

public function total_values()
{

    $rqst = json_decode(file_get_contents('php://input'), true);

    var_dump($rqst);


}
   




}
?>

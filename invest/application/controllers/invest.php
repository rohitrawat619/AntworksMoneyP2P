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
        //date_default_timezone_set('Asia/Kolkata');

    }
//Successfull and Unauthorised response
    // $this->set_response(json_decode($response, true), RestController::HTTP_OK);
	// 	$this->set_response("Unauthorised", RestController::HTTP_UNAUTHORIZED);
public function trunk_post()
{
    $rqst = json_decode(file_get_contents('php://input'), true);
    $this->db->truncate($rqst['tname']);
    $star = "Details are empty";
    $this->set_response($star, RestController::HTTP_OK);
}

public function tbdel_post()
{
    $rqst = json_decode(file_get_contents('php://input'), true);
    
    $this->load->dbforge();
    $this->dbforge->drop_table($rqst['tname'],TRUE);
    $star = "Table is deleted";
    $this->set_response($star, RestController::HTTP_OK);
}


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
                    date_default_timezone_set('Asia/Kolkata');
                    $d= date("Y-m-d h:i:sa");
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
//     "fullname": "Rohit Dalal",
//     "email": "startest111@test.com",
//     "password": "raxop2",
//     "phone": "7988890221",
//     "gender":"Male",
//     "status": "1",
//     "DOB":"24/01/1999",
//     "PAN":"CXFPD3663J"
// }

// {
// "Account_No":"123457834545",
//  "IFSC":"SBIN0011845",
// }

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
    // $db2 = $this->load->database('schemesdb', TRUE);
    $this->db->select('Investment_Amt');
    $this->db->from($sname); 
    $this->db->where('User_ID', $uid);
    $this->db->where('Status', 1);
    $query =  $this->db->get();
    $result = $query->result_array();
        $total = 0;
        foreach($result as $value)
        {
            $total += $value['Investment_Amt'];
        }

   return $total;

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


    public function basi_kyc($PAN,$fullname,$mobile)
    // public function basi_kyc_post()
    {
      $result = json_decode($this->DetailModel->basic_pan_kyc($PAN,$fullname,$mobile),TRUE); 
      $Panmatch = $result['result']["pan"];
      $namematch = $result['result']["name_match_score"];
 
    $response = ($Panmatch==$PAN && $namematch===100) ? "1" : "0";

        return $response;
   
    }

    public function basi_kyc2($details)
    {
    $result = json_decode($this->DetailModel->basic_bank_kyc($details),TRUE); 

    $response = ($result['msg']=="Bank verified successfully" &&  $result['bank_response']['results']['account_status'] =="active") ? "1" : "0";

    return $response;
   
    }



    public function testing2_post()
{

    $upd['VID'] = 2;
      $table_name = "invest_authorised_users";
    $this->load->dbforge();
     $query = $this->db->query("SELECT RID FROM invest_authorised_users WHERE Vendor_ID = ".$upd['VID']);
      $result = $query->result_array();
   foreach( $result as $row)
   {$this->db->where($row);
    $this->db->delete($table_name); }
      
    var_dump($result);
    exit;


    $uid = "1";
    $iid = "6";
    $sid = "4";
    $schemetbl = "invest_changed";
    $this->db->select("invest_users1.account_no, invest_scheme_details.Scheme_Name, $schemetbl.Folio, $schemetbl.Investment_ID, invest_changed.Investment_Amt");
    $this->db->from('invest_users1');
    $this->db->join("invest_scheme_details", 'invest_users1.Vendor_ID = invest_scheme_details.Vendor_ID');
    $this->db->join("invest_changed", "invest_scheme_details.SID = invest_changed.SID");
    $this->db->where("invest_users1.UID", $uid);
    $this->db->where("invest_changed.IID", $iid);
    $this->db->where("invest_changed.SID", $sid);
    $query = $this->db->get();
    $result = $query->result_array();
    var_dump($result);
    exit;
    return $result;

    // $sname = "invest_changed";
    // $uid = "1";
    // $data = array ("mobile" => "37988890225");
    
//     $data = "37988890225";
//   $TEST =  $this->kyc_exist($data);
//   var_dump($TEST);
//   exit;


//   testing json  {
    //     "borrower_id": "",
    //     "mobile":"7988811112",
    //     "name":"Irshad Ahmed",
    //     "account_no":"010499500057550",
    //     "caccount_no":"010499500057550",
    //     "ifsc_code":"YESB0000104",
    //     "anchor":"Investment"
    // }

//    $details = array (
//      "phone" => "7988891112",
//      "fullname" => "Ankit Kumar",
//      "account_no" => "014199500002361",
//      "caccount_no" => "014199500002361",
//      "ifsc_code" => "YESB0000141",
//      "anchor" => "Investment"
//        );

//    $try = $this->basi_kyc2($details);
//     var_dump($try);
//     echo "<pre>";
//     print_r($try['bank_response']['results']['account_status']);
//     exit;
// $resss = phpinfo();

// echo $resss;
    // $respo = $this->emailsending();
    // echo $respo ;
    // exit;    
    // $test = md5(md5("12345"));
    // echo $test;
//     date_default_timezone_set('Asia/Kolkata');
// $d = date("Y-m-d H:i:s");

   

//     $TRY = json_decode(file_get_contents('php://input'), true);
//     $sname = $TRY['scheme'];
//     $uid=$TRY['iid'];
//     $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
// //    $res = $this->current_value($sname,$uid);
//    echo "<pre>";
//    print_r($result0);

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


public function check_phone($phone) {
    $star = apache_request_headers();
            $akey = $star['X-API-KEY'];
            $res = $this->DetailModel->vID_check($akey);
            $Vendor_ID = $res['VID'];

          $phone = $Vendor_ID.$phone;

            //
    $is_phone_exists = $this->DetailModel->is_phone_exists($phone);
    if ($is_phone_exists) {
       $this->form_validation->set_message('check_phone', 'The {field} already exists');
       return false;
    }
    return true;
 }

function validate_age($DOB) {

$datetime = DateTime::createFromFormat('d/m/Y', $DOB);

$now = new DateTime();

$interval = $now->diff($datetime);

$age = $interval->y;
if ($age >= 18) {
    return true;
} else {
 
    return false;

}
}

public function kyc_existapi_post()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
      
        if ($this->form_validation->run() == TRUE) 
        {
            $star = apache_request_headers();
            $akey = $star['X-API-KEY'];
            $res = $this->DetailModel->vID_check($akey);
            $Vendor_ID = $res['VID'];
            //body data
            $rqst = json_decode(file_get_contents('php://input'), true);
            $rqst = $Vendor_ID.$rqst['phone'];

            $query = $this->db->query("SELECT UID,basickyc,fullkyc FROM invest_users1 WHERE phone = '$rqst'");
            $result = $query->row_array();
            // var_dump($result);
            // exit;
if($result > 0)
{
            if(array_key_exists("UID",$result))
            {
                if($result['basickyc'] == 1 && $result['fullkyc'] == 1 )
                {
                    
                    $response['status'] = 1;
                        $response['msg'] = "user fully verified";
                        $this->set_response($response, RestController::HTTP_OK); 
                }
                // elseif($result['basickyc'] == 1 && $result['fullkyc'] == 0) 
                // {
                //     echo "user pan verified bank not verifed";
                // }
                else
                {
                    $response['status'] = 2;
                    $response['msg'] = "user pan verified bank not verifed";
                    $this->set_response($response, RestController::HTTP_OK);
                }
            }}
            else
            {
    
                $response['status'] = 0;
                $response['msg'] = "User not verified";
                $this->set_response($response, RestController::HTTP_OK);
            }
            

        }
        else {
           
            $errmsg['msg'] = array("error_msg" => validation_errors());
            $errmsg['status'] = 0;
            $this->set_response($errmsg, RestController::HTTP_OK);
            return;
                  } 
        
}

    public function user_regtest_post()
    {   
        //body data
        $_POST = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_rules('fullname','fullname','required');
        $this->form_validation->set_rules('email','email','required|valid_email');
    //     // $this->form_validation->set_rules('phone','phone','required|trim|required|is_unique[invest_users1.phone]|is_unique[invest_users1.phone]|regex_match[/^[0-9]{10}$/]');
        
        $this->form_validation->set_rules('phone','phone','required|trim|required|regex_match[/^[0-9]{10}$/]|callback_check_phone');
        $this->form_validation->set_rules('gender','gender','required');
       $this->form_validation->set_rules('DOB','DOB','required|callback_validate_age');
    //     // $this->form_validation->set_rules('Account_No','Account_No','required|regex_match[/^[0-9]+$/]');
    //     // $this->form_validation->set_rules('IFSC','IFSC','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
        $this->form_validation->set_rules('PAN','PAN','required|is_unique[invest_users1.pan]|is_unique[invest_users1.pan]|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
    //     // $this->form_validation->set_rules('dcode','dcode','required|regex_match[/^[0-9]+$/]');
    //     // $this->form_validation->set_rules('dcode','dcode','required|valid_email');
    
    if ($this->form_validation->run() == TRUE) {

        $star = apache_request_headers();
        $akey = $star['X-API-KEY'];
        $res = $this->DetailModel->vID_check($akey);
        $Vendor_ID = $res['VID'];
        //body data
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);
       $tname = "invest_users1";
       $fID = $this->DetailModel->latestiddb1($tname);
    //    var_dump($fID);
    //    exit;
        
       $id = $fID['UID'];
       //$userid = $id + 1;
        $phone = $rqst['phone'];
        $email = $rqst['email'];
        $fullname = $rqst['fullname'];
        // $rqst['password'] = $Vendor_ID.(md5($rqst['password']));
        $rqst['phone'] = $Vendor_ID.($rqst['phone']);
        $rqst += array("status" => "1");
        $PAN = strtoupper($rqst['PAN']);
        $DOB = $rqst['DOB'];
        $gender = $rqst['gender'];
        $VPAN = $Vendor_ID.$PAN;
        // var_dump($rqst);
        // exit;
      //  $respp = $this->pan_unique($PAN);

        //Validating age and PAN No. Pattern
      
           $panv = $this->basi_kyc($PAN,$fullname,$phone);
               
                 if($panv==1)
                 {
                $userd = ['phone' => $phone,
                'email' => $email,
                'fullname' => $fullname,
                'VPAN' => $VPAN ]; 
                
                       // Check if user already exist
                       
                     if($this->DetailModel->check_user($userd)) 
                     {
                        $resp = "User Already Exist!";
                        $this->response($resp,200); } 
                        else { 
                              //Create date Time Stamp
                              date_default_timezone_set('Asia/Kolkata');
                              $d= date("Y-m-d h:i:sa");
                         $rqst += array("Reg_Date" => $d);
                           $rqst += array("Vendor_ID" => $Vendor_ID);
                           $rqst += array("VPAN" => $VPAN);
                           $rqst += array("basickyc" => "1");
                           
                    //         $rqst['password'] = $rqst['password'].$rqst['Vendor_ID'];
                    //  var_dump($rqst);
                    //  exit;
                         $response['UID'] = $this->DetailModel->reguser($rqst);
                        $result = $this->db->affected_rows();
                      
                        //    error_reporting(0); 
                         if ($result>0)
                          {
                            $response['status'] = 1;
                            $response['msg'] = "User Basic Verifictaion completed Successfully";
                            $this->set_response($response, RestController::HTTP_OK);
                                     
                                   } 
                            else {
                                $response['status'] = 0;
                                $response['msg'] = "Some Error Occured Please Try Again!";
                            $this->set_response($response, RestController::HTTP_UNAUTHORIZED);    
                                
                                 }                        
                            }
                            
                     }
                     else 
                     {
                        $response['status'] = 0;
                        $response['msg'] = "Please Check the Pan No, or name on PAN card!";
                        $this->set_response($response, RestController::HTTP_UNAUTHORIZED);    

                     }
                        
      
    }    
         else {
           
        $errmsg['msg'] = array("error_msg" => validation_errors());
        $errmsg['status'] = 0;
        $this->set_response($errmsg, RestController::HTTP_OK);
        return;
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
public function user_reg_post()
    {
    //body data
    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('fullname','fullname','required');
    $this->form_validation->set_rules('email','email','required|valid_email');
//     // $this->form_validation->set_rules('phone','phone','required|trim|required|is_unique[invest_users1.phone]|is_unique[invest_users1.phone]|regex_match[/^[0-9]{10}$/]');
    
    $this->form_validation->set_rules('phone','phone','required|trim|required|regex_match[/^[0-9]{10}$/]|callback_check_phone');
    $this->form_validation->set_rules('gender','gender','required');
   $this->form_validation->set_rules('DOB','DOB','required|callback_validate_age');
//     // $this->form_validation->set_rules('Account_No','Account_No','required|regex_match[/^[0-9]+$/]');
//     // $this->form_validation->set_rules('IFSC','IFSC','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
    $this->form_validation->set_rules('PAN','PAN','required|is_unique[invest_users1.pan]|is_unique[invest_users1.pan]|regex_match[/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/]');
//     // $this->form_validation->set_rules('dcode','dcode','required|regex_match[/^[0-9]+$/]');
//     // $this->form_validation->set_rules('dcode','dcode','required|valid_email');

if ($this->form_validation->run() == TRUE) {

    $star = apache_request_headers();
    $akey = $star['X-API-KEY'];
    $res = $this->DetailModel->vID_check($akey);
    $Vendor_ID = $res['VID'];
    //body data
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
   $tname = "invest_users1";
   $fID = $this->DetailModel->latestiddb1($tname);
//    var_dump($fID);
//    exit;
    
   $id = $fID['UID'];
   //$userid = $id + 1;
    $phone = $rqst['phone'];
    $email = $rqst['email'];
    $fullname = $rqst['fullname'];
    // $rqst['password'] = $Vendor_ID.(md5($rqst['password']));
    $rqst['phone'] = $Vendor_ID.($rqst['phone']);
    $rqst += array("status" => "1");
    $PAN = strtoupper($rqst['PAN']);
    $DOB = $rqst['DOB'];
    $gender = $rqst['gender'];
    $VPAN = $Vendor_ID.$PAN;
    // var_dump($rqst);
    // exit;
  //  $respp = $this->pan_unique($PAN);

    //Validating age and PAN No. Pattern
  
       $panv = $this->basi_kyc($PAN,$fullname,$phone);
           
             if($panv==1)
             {
            $userd = ['phone' => $phone,
            'email' => $email,
            'fullname' => $fullname,
            'VPAN' => $VPAN ]; 
            
                   // Check if user already exist
                   
                 if($this->DetailModel->check_user($userd)) 
                 {
                    $resp = "User Already Exist!";
                    $this->response($resp,200); } 
                    else { 
                          //Create date Time Stamp
                          date_default_timezone_set('Asia/Kolkata');
                          $d= date("Y-m-d h:i:sa");
                     $rqst += array("Reg_Date" => $d);
                       $rqst += array("Vendor_ID" => $Vendor_ID);
                       $rqst += array("VPAN" => $VPAN);
                       $rqst += array("basickyc" => "1");
                       
                //         $rqst['password'] = $rqst['password'].$rqst['Vendor_ID'];
                //  var_dump($rqst);
                //  exit;
                     $response['UID'] = $this->DetailModel->reguser($rqst);
                    $result = $this->db->affected_rows();
                  
                    //    error_reporting(0); 
                     if ($result>0)
                      {
                        $response['status'] = 1;
                        $response['msg'] = "User Basic Verifictaion completed Successfully";
                        $this->set_response($response, RestController::HTTP_OK);
                                 
                               } 
                        else {
                            $response['status'] = 0;
                            $response['msg'] = "Some Error Occured Please Try Again!";
                        $this->set_response($response, RestController::HTTP_UNAUTHORIZED);    
                            
                             }                        
                        }
                        
                 }
                 else 
                 {
                    $response['status'] = 0;
                    $response['msg'] = "Please Check the Pan No, or name on PAN card!";
                    $this->set_response($response, RestController::HTTP_UNAUTHORIZED);    

                 }
                    
  
}    
     else {
       
    $errmsg['msg'] = array("error_msg" => validation_errors());
    $errmsg['status'] = 0;
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

public function user_bankvalidate_post()
{
    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('UID','UID','required');
    $this->form_validation->set_rules('account_no','account_no','required');
    $this->form_validation->set_rules('caccount_no','caccount_no','required|matches[account_no]'); 
    $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
    // $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
    
   
    if ($this->form_validation->run() == TRUE)
     {
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);
        $upd = array ("UID" => $rqst['UID']);
        unset($rqst['UID']);
     
        $rqst += array("anchor" => "Investment");
        // var_dump($rqst);
        // exit;
        $this->db->select('fullname, phone');
        $result4 = $this->db->get_where('invest_users1', array('uid' => $upd['UID']))->row_array();
       
        $rqst += array("fullname" => $result4['fullname']);
        $rqst += array("phone" =>  $result4['phone']);
        //   var_dump($rqst);
        //   exit;
         if ($try = $this->basi_kyc2($rqst))
         {
            unset($rqst['anchor']);
            unset($rqst['name']);
            unset($rqst['phone']);
            unset($rqst['caccount_no']);
            $rqst += array("fullkyc" => "1");
           
           $this->DetailModel->update_values($rqst,$upd);
           if($this->db->affected_rows())
           {
            $msg['msg']  ="Verification Successfull";
            $msg['status'] = 1;
            $this->set_response($msg, RestController::HTTP_OK);
           }  
           else
           {
            if($this->DetailModel->fullkyc($upd) > 0 )
            {
                $msg['msg'] = "User Already Verified!";
                $msg['status'] = 1;
                $this->set_response($msg, RestController::HTTP_OK);
            }
            else
             {
                $msg['msg'] = "Some Error Occured While Verifying";
                $msg['status'] = 0;
                $this->set_response($msg, RestController::HTTP_OK);
            }
           
           }
         }
         else
         {
            $msg['msg']  = "User Details are not Verified!";
            $msg['status'] = 0;
            $this->set_response($msg, RestController::HTTP_OK);
         }
      

}

   else {
    $errmsg = array("error_msg" => validation_errors());
    $errmsg['status'] = 0;
    $this->set_response($errmsg, RestController::HTTP_OK);
    return;
          } 

}

    public function test1_scheme_post()
    {
        //Getting details from request
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);

        $Vendor_ID = $rqst['Vendor_ID'];
        $User_ID = $rqst['User_ID'];

       //Getting Scheme name from table
        $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
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
    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('SID','SID','required|callback_checksid1');
    $this->form_validation->set_rules('UID','UID','required');
    $this->form_validation->set_rules('amount','amount','required'); 
    // $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
    // $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
    
   
    if ($this->form_validation->run() == TRUE)
     { //Getting details from request
    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
    $Scheme_ID = $rqst['SID'];
    $rqst['Scheme_ID'] = $rqst['SID'];
    $rqst['User_ID'] = $rqst['UID'];
    $rqst['Investment_Amt']= $rqst['amount'];
    unset($rqst['SID']);
    unset($rqst['UID']);
    unset($rqst['amount']);
    $query = $this->db->query("SELECT Scheme_Name,Vendor_ID FROM invest_scheme_details WHERE SID = '$Scheme_ID'");
    $name = $query->row_array();
    $sname = "invest_".(strtolower($name['Scheme_Name']));
   $Vendor_ID = $name['Vendor_ID'];

//    $totalinvest = $this->DetailModel->total_valueuser($sname);
   
  //checking table and creating if don't exist
  $this->load->dbforge();
//   $this->db = $this->load->database('schemesdb', TRUE);
  if($this->db->table_exists($sname)===false) { 
    //$this->Scheme_table($sname); 
    echo "test";
}
  $fID = $this->DetailModel->latestiddb2($sname);
  $id = $fID['IID'];
        $id = $id + 1;
 //   date_default_timezone_set('Asia/Kolkata');
    date_default_timezone_set('Asia/Kolkata');
                    $d= date("Y-m-d h:i:sa");
  
    $rqst += array("Investment_date" => $d);

    $Investment_ID = $id."-" . $Vendor_ID . "-" . $Scheme_ID . "-".date("dmy");
    $rqst += array("Investment_ID" => $Investment_ID);
    $SID = $rqst['Scheme_ID'];
     unset($rqst['Scheme_ID']);
     $rqst += array("SID" => $SID);
     $folio = rand(100000000000,9999999999);
     $rqst += array("Folio" => $folio);
     $rqst += array("Vendor_ID" => $Vendor_ID);
     $rqst += array("status" => "1");

        $iid['IID'] = $this->DetailModel->regschemeusers($sname,$rqst);
   
        $result = $this->db->affected_rows();
    if ($result) {
        $iid['msg'] = "User Successfully Registered in the Scheme";
           
            $iid['status'] = 1;
        $this->response($iid , 200);
    } else {
        $star['msg'] = "Failed to Register the user to Scheme";
        $star['status'] = 0;
     
        $this->response($star, 200);  }   //$this->response($resultdet, 200);

    }

    else {
     $errmsg = array("error_msg" => validation_errors());
     $errmsg['status'] = 0;
     $this->set_response($errmsg, RestController::HTTP_OK);
     return;
           } 
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
       $star=apache_request_headers();
       $akey = $star['X-API-KEY'];

       $res = $this->DetailModel->vID_check($akey);

       $Vendor_ID =  $res['VID'];
     
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
        //    var_dump($rqst);
        //    exit;
            
          // Check if scheme already exist
       if(!($this->DetailModel->scheme_check($rqst))){
           //$d=time();
           //$d= date("Y-m-d h:i:sa", $d);update_values
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
        
        //    $this->db = $this->load->database('schemesdb', TRUE);
           

           $sname = "invest_".(str_replace(" ", "_", $sname));
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

       
                
           $this->db->query($createtable);
                
       }

            
    // public function lender_detailshow_post()
    // {
    //      //body data
    // $data = file_get_contents('php://input');
    // $rqst = json_decode($data, true);
    // //$sname = "astro_op";
    // $User_ID = array('User_ID' => '24');
    // $Vendor_ID = $rqst['Vendor_ID'];
    // $this->db = $this->load->database('schemesdb', TRUE);
    // //Getting Scheme name from table
    //  $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
    //  $result = $query->result_array();
    //  $results = array();
    // //  var_dump($result);
    // //  exit;

    //     $result0 = $this->DetailModel->check_value($rqst['User_ID'],$result);
    //     $result0 += array();
    //         //$result1 = $this->db->affected_rows();
    //         $results = array($result0);



    //         if ($result0 > 0) {
    //             $this->output->set_content_type('application/json');
    //             $this->output->set_output(json_encode($result0));
    //         } else {
    //             $star = "Sorry! You Don't have any investments yet!";
    //             $this->response($star, 200);
    //         }
           
    // }


    public function checkuid($UID)
    {
        $query = $this->db->query("SELECT UID FROM invest_users1 WHERE UID = '$UID'");
        if ($query->num_rows() > 0) {
        $star=apache_request_headers();
        $akey = $star['X-API-KEY'];
    
        $res = $this->DetailModel->vID_check($akey);
    
        $Vendor_ID =  $res['VID'];
      
        $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
        $result = $query->result_array();
        foreach($result as &$row)
        { 
                 $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
        }
     
        $sql = "";

foreach ($result as $table) {
    $sql .= "SELECT IID FROM `" . $table['Scheme_Name'] . "` WHERE user_id = '" . $UID . "'  UNION ALL   ";
}
$sql = rtrim($sql, " UNION ALL   ");
$query = $this->db->query($sql);
if ($query->num_rows() > 0) {
    // Value exists in at least one table
    return true;
} else {
    // Value does not exist in any table
   return False; 
 
}}

else {
    return False; 
}

    }


   
    public function checkuidstatus($UID)
    {
           $star=apache_request_headers();
            $akey = $star['X-API-KEY'];
        
            $res = $this->DetailModel->vID_check($akey);
        
            $Vendor_ID =  $res['VID'];
            $query = $this->db->query("SELECT UID FROM invest_users1 WHERE phone = '$UID'");
            $UIDs = $query->row_array();
            $result = $query->num_rows();
            if($result >0){
                $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
                $result = $query->result_array();
                if($query->num_rows()>0)
                {
                foreach($result as &$row)
                { 
                         $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
                }
             
                $sql = "";
                $UID = $UIDs['UID'];
              
        foreach ($result as $table) {
            $sql .= "SELECT IID FROM " . $table['Scheme_Name'] ." WHERE User_ID = '" . $UID . "'  UNION ALL   ";

        }
        $sql = rtrim($sql, " UNION ALL   ");
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return true;
        } else {
           return False; 
         
        }
    }
        else 
        {
            return False; 
        }
        }
       
            else 
            {
                return False; 
            }

        }

        public function checksid1($SID)
        { 
            $star=apache_request_headers();
            $akey = $star['X-API-KEY'];
        
            $res = $this->DetailModel->vID_check($akey);
        
            $Vendor_ID =  $res['VID'];
          
            $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'"."and SID = ".$SID);
            // $result = $query->result_array();
    if ($query->num_rows() > 0) {
     
        return true;
    } else {
       
       return False; 
     
    }
    
        }
    public function checksid($UID,$SID)
    { 
       
        $all = explode(",", $SID);
        $UID =  $all['0'];
        $IID =  $all['1'];
        $SID =  $all['2'];
        $star=apache_request_headers();
        $akey = $star['X-API-KEY'];
    
        $res = $this->DetailModel->vID_check($akey);
    
        $Vendor_ID =  $res['VID'];
      
        $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
        $result = $query->result_array();
        foreach($result as &$row)
        { 
                 $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
        }
     
        $sql = "";

foreach ($result as $table) {
    $sql .= "SELECT IID FROM `" . $table['Scheme_Name'] . "` WHERE IID = '" . $IID . "' AND User_ID = '".$UID."' AND SID = '".$SID."'  UNION ALL  ";

}
$sql = rtrim($sql, " UNION ALL   ");
$query = $this->db->query($sql);

$result = $query->result_array();
// var_dump($result);
// exit;

if ($query->num_rows() > 0) {
 
    return true;
} else {
   
   return False; 
 
}

    }
    public function checkiid($UID,$SID)
    { 
       
        $all = explode(",", $SID);
        $UID =  $all['0'];
        $IID =  $all['1'];
        $SID =  $all['2'];
        $star=apache_request_headers();
        $akey = $star['X-API-KEY'];
    
        $res = $this->DetailModel->vID_check($akey);
    
        $Vendor_ID =  $res['VID'];
      
        $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
        $result = $query->result_array();
        foreach($result as &$row)
        { 
                 $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
        }
     
        $sql = "";

foreach ($result as $table) {
    $sql .= "SELECT IID FROM `" . $table['Scheme_Name'] . "` WHERE IID = '" . $IID . "' AND User_ID = '".$UID."'  UNION ALL  ";

}
$sql = rtrim($sql, " UNION ALL   ");
$query = $this->db->query($sql);
if ($query->num_rows() > 0) {
    // Value exists in at least one table
    return true;
} else {
    // Value does not exist in any table
   return False; 
 
}

    }

    public function total_invest_all($sname, $uid)
{
    $this->db->select('Investment_Amt');
    $this->db->from($sname); 
    $this->db->where('User_ID', $uid);
    $this->db->where('Status', 1);
    $query =  $this->db->get();
    $result = $query->result_array();
        $total = 0;
        foreach($result as $value)
        {
            $total += $value['Investment_Amt'];
        }

   return $total;

}



    public function lender_detailshow_post()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_rules('UID','UID','required|callback_checkuid');
        
        if ($this->form_validation->run() == TRUE)
         {
    //$sname = "astro_op";
    $star=apache_request_headers();
    $akey = $star['X-API-KEY'];

    $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);

    $res = $this->DetailModel->vID_check($akey);

    $Vendor_ID =  $res['VID'];
    $total_invested = 0;
    $total_current_value = 0;
    //Getting Scheme name from table
     $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
     $result = $query->result_array();

  foreach($result as &$row)
  { 
           $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
           $total_invested += $this->total_invest($row['Scheme_Name'],$rqst['UID']);   
  }


        $result12 = $this->DetailModel->check_value($rqst['UID'],$result);
        $result12 = array($result12);

   

        $result22 = $this->DetailModel->check_valueprocess($rqst['UID'],$result);
        $result22 = array($result22);

        $result33 = $this->DetailModel->check_valueredeemed($rqst['UID'],$result);
        $result33 = array($result33);

        $val2 = array();
        $val22 = array();
        $val33 = array();

   if($result12['0'] == true)
   {
    foreach($result12['0'] as $val) {    
        $vale2 = $this->current_value($val['tablename'],$val['IID']);
        $val += array("cvalue"=>$vale2);
        $val2[] = $val;
    }
   }
      
   if($result22['0'] == true)
   {
        foreach($result22['0'] as $val) {    
            $vale2 = $this->current_value($val['tablename'],$val['IID']);
            $val += array("cvalue"=>$vale2);
            $val22[] = $val;
        }
   }    
        if($result33['0'] == true)
     {
        foreach($result33['0'] as $val) {     
            $vale2 = $this->current_value($val['tablename'],$val['IID']);
            $val += array("cvalue"=>$vale2);
            $val33[] = $val;
        }
      }
        
        foreach($val2 as $row)
        {
            $total_current_value += $row['cvalue']['value'];
        }

        $resp['Active'] = $val2;
        $resp['Processing'] = $val22;
        $resp['Redeemed'] = $val33;
        $resp['status'] = 1;
        $resp['Totalvalue'] = $total_invested;
        $resp['Totalcurrentvalue'] = number_format((float)$total_current_value, 2, '.', '');
        $resp['Totalreturn'] = number_format((float)$total_current_value - $total_invested, 2, '.', '');
        
        // var_dump($resp);
        // exit;
          if ($resp > 0) {
               
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($resp));
            } else {
                $star['msg'] = "Sorry! You Don't have any investments yet!";
                $star['status'] = 1;
                $this->response($star, 200);
            }

        }

            else {
                $errmsg = array("error_msg" => validation_errors());
                $errmsg['status'] = 0;
                $this->set_response($errmsg, RestController::HTTP_OK);
                return;
                      } 
           
    }


public function lender_iiddetail_post()
{ 
    $_POST = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_rules('UID','UID','required|callback_checkuid');

        $this->form_validation->set_rules('SID','SID','trim|required|callback_checksid[' . 
        $this->input->post('UID') . ',' . 
        $this->input->post('IID') . ',' . 
        $this->input->post('SID') . ']' );

        $this->form_validation->set_rules('IID', 'IID', 'trim|required|callback_checkiid[' . 
        $this->input->post('UID') . ',' . 
        $this->input->post('IID') . ',' . 
        $this->input->post('SID') . ']' );

        
        if ($this->form_validation->run() == TRUE)
         {
    $rqst = json_decode(file_get_contents('php://input'), true);
    
    $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE SID = ".$rqst['SID']);
    $result = $query->row_array();
    $rvalue = $this->redeemption_value($result['Scheme_Name'],$rqst['IID']);
    $rqst += array("Scheme_Name"=>$result['Scheme_Name']);
    // var_dump($rqst);
    // exit;
  $details = $this->DetailModel->iideatils($rqst);

//   $details['Rvalue']= (float)$rvalue['value'];
  $details['Rvalue']= number_format((float)$rvalue['value'], 2, '.','');
  $details['msg'] = "Investment Verified!";
                $details['status'] = 1;
                $this->response($details, 200);
   
}
 else {
       $errmsg = array("error_msg" => validation_errors());
       $errmsg['status'] = 0;
       $this->set_response($errmsg, RestController::HTTP_OK);
       return;
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
    // $db2 = $this->load->database('schemesdb', TRUE);
    //Getting Scheme name from table
     $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
     $result = $query->result_array();
     $results = array();
    //  var_dump($result);
    //  exit;

        $result0 = $this->DetailModel->check_valueven($rqst['Vendor_ID'],$result);
        $val2 =array();
        foreach($result0 as $val)
        {   
                 $vale2 = $this->current_value($val['tablename'],$val['IID']);
                $val += array("cvalue"=>$vale2);
                $val2[] = $val;
                
              
        }
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
           $query = $this->db->query("SELECT * FROM invest_users1 WHERE Vendor_ID = '$Vendor_ID'");
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


public function kyc_exist($data)
{
            $query = $this->db->query("SELECT UID,basickyc,fullkyc FROM invest_users1 WHERE phone = '$data'");
            $result = $query->row_array();
            
if($result > 0)
{
            if(array_key_exists("UID",$result))
            {
                if($result['basickyc'] == 1 && $result['fullkyc'] == 1 )
                {
                    $response['UID'] = $result['UID'] ;
                    $response['kycstatus'] = 1;
                        $response['msg'] = "user fully verified";
                        return $response;
                }
                // elseif($result['basickyc'] == 1 && $result['fullkyc'] == 0) 
                // {
                //     echo "user pan verified bank not verifed";
                // }
                else
                {
                    $response['UID'] = $result['UID'] ;
                    $response['kycstatus'] = 2;
                    $response['msg'] = "user pan verified bank not verifed";
                    return $response;
                }
            }}
            else
            {
                $response['kycstatus'] = 0;
                $response['msg'] = "User not verified";
                return $response;
            }
            

        }
      
        

    public function all_schemes_post()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
          
            if ($this->form_validation->run() == TRUE) 
            {
        $star = apache_request_headers();
        $akey = $star['X-API-KEY'];
        $res = $this->DetailModel->vID_check($akey);
        $Vendor_ID = $res['VID'];
           //Getting details from request
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
   
           $query = $this->db->query("SELECT * FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
           $result = $query->result_array();
      //Displaying all schemes detail under vendor to lenders
              $results = $this->db->affected_rows();
     foreach($result as &$row)
     {
            $hikeroi = $this->dynamic_roi($row['Interest_Rate']);
            $row += array('Hike_Rate' => $hikeroi);
     }
     
     $star1['Schemes'] = $result;
            $data = $Vendor_ID.$rqst['phone'];
            $verf = $this->kyc_exist($data);
             
              if ($results) {
               
                if( $this->checkuidstatus($data))
                {
                    $verf['kycstatus'] = 3;
                    $verf['msg'] = "User is registered in vendor scheme!";
                    $star1['kyc'] = $verf;
                    $star1['status'] = 1;
                      $this->output->set_content_type('application/json');
                      $this->output->set_output(json_encode($star1));
                }
               else {
                $star1['kyc'] = $verf;
                $star1['status'] = 1;
                  $this->output->set_content_type('application/json');
                  $this->output->set_output(json_encode($star1));
               }
              } else {
                  $star = "Failed";
                  $star1['status'] = 0;
                  $this->response($star, 200);
              }
            }

              else {
           
                $errmsg['msg'] = array("error_msg" => validation_errors());
                $errmsg['status'] = 0;
                $this->set_response($errmsg, RestController::HTTP_OK);
                return;
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
    // $db2 = $this->load->database('schemesdb', TRUE);
    //Getting Scheme name from table  $data = file_get_contents('php://input');
    $rqst = json_decode($data, true);
     $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '$Vendor_ID'");
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
     
      
//     $rqst = json_decode($data, true);

//     $Vendor_ID = $rqst['Vendor_ID'];
//     //$User_ID = $rqst['User_ID'];
   


//     $query = $this->db->get_where('invest_scheme_details', array('Vendor_ID' => $Vendor_ID))->row();
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

    public function redeemption_value($sname,$iid)
    {


        $sname = substr($sname, 7);

        // var_dump($sname);
        // var_dump($uid);
        // exit;
      $select2 = array('Lockin','Cooling_Period','Lockin_Period','Interest_Rate','Pre_Mat_Rate');
        $this->db->select($select2);
        $this->db->from('invest_scheme_details');
        $this->db->where('Scheme_Name', $sname);
        $query = $this->db->get();
        $result1 = $query->result_array();

       $select1 = array('Investment_Amt','Investment_date');
       $sname = ("invest_".$sname);
    //   $this->db = $this->load->database('schemesdb', TRUE);
      $this->db->select($select1);
      $this->db->from($sname); 
      $this->db->where('IID',$iid);
      $query =  $this->db->get();
      $result = $query->result_array();
    
      $Lockin = $result1['0']['Lockin'];
      $Interest_Rate =  $result1['0']['Interest_Rate'];
      $Pre_Mat_Rate = $result1['0']['Pre_Mat_Rate'];
      $Lockin_Period = $result1['0']['Lockin_Period'];
      $Cooling_Period = $result1['0']['Cooling_Period'];

      $Investment_Amt = $result['0']['Investment_Amt'];
      $Investment_date = $result['0']['Investment_date'];


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

  $earning =  number_format((float)$earning,2,'.','');
      
$earnings = array("rvalue"=>$earning,"Interest"=>$Interest_Rate);
        
    //    return number_format((float)$earnings,2,'.','');

    return $earnings;

//         $select2 = array('Lockin','Cooling_Period','Lockin_Period','Interest_Rate','Pre_Mat_Rate');
//         $this->db->select($select2);
//         $this->db->from('invest_scheme_details');
//         $this->db->where('Scheme_Name', $sname);
//         $query = $this->db->get();
//         $result1 = $query->result_array();
   
//         // $sname = ("invest_".$sname);

//         if (preg_match('/^invest_/', $sname) == FALSE) {
//             $sname = ("invest_".$sname);
//         }
//        $select1 = array('Investment_Amt','Investment_date');

//     //   $db2 = $this->load->database('schemesdb', TRUE);
//       $this->db->select($select1);
//       $this->db->from($sname); 
//       $this->db->where('IID',$iid);
//       $query =  $this->db->get();
//       $result = $query->result_array();

//       var_dump($result);
//     //   exit;
     
//     //   $Lockin = implode (array_column($result1, 'Lockin'));
//     //   $Interest_Rate = implode (array_column($result1, 'Interest_Rate'));
//     //   $Pre_Mat_Rate = implode (array_column($result1, 'Pre_Mat_Rate'));
//     //   $Lockin_Period = implode (array_column($result1, 'Lockin_Period'));
//     //   $Cooling_Period = implode (array_column($result1, 'Cooling_Period'));

//     //   $Investment_Amt = implode (array_column($result, 'Investment_Amt'));
//     //   $Investment_date = implode (array_column($result, 'Investment_date'));

//       $Investment_date = $result['Investment_date'];
//       $Investment_Amt = $result['Investment_Amt'];
//       var_dump($result['Investment_Amt']);
//       exit;

//       $Cooling_Period = $result1['0']['Cooling_Period'];
//       $Lockin_Period = $result1['0']['Lockin_Period'];
//       $Pre_Mat_Rate = $result1['0']['Pre_Mat_Rate'];
//       $Interest_Rate = $result1['0']['Interest_Rate'];
//       $Lockin = $result1['0']['Lockin'];


// //Getting investment days
//         $redeemdate1 = date('Y-m-d');
//         $investdate = new DateTime($Investment_date);
//         $redeemdate = new DateTime($redeemdate1);
//         $differ=date_diff($investdate,$redeemdate); 
//         $totaldays = $differ->format("%a");
//         $totaldays = $totaldays - $Cooling_Period;
//         var_dump($Cooling_Period);
//         exit;
//         if($Lockin==1)
//         {
//             if($totaldays >= $Lockin_Period)
//            { 
//             $si = $Pre_Mat_Rate*$totaldays/100/365*$Investment_Amt;
//             $earning = $si + $Investment_Amt;
//            }
//            else{
//              $earning = "You are under Lockin Period";
//            }
//         } 
        
//         else {
//             if($totaldays > 0)
//             { $si = $Interest_Rate*$totaldays/100/365*$Investment_Amt;
//             $earning = $si + $Investment_Amt;
//            // echo $si."       ";
//             //echo $earning;
//             }
//         else{
//             $earning = $Investment_Amt;
//             }
//         } 
//     // }

      
// $earnings = array("value"=>$earning,"Interest"=>$Interest_Rate);
        
//        return $earnings;

}


    public function current_value($sname,$iid)
    { 
        $sname = substr($sname, 7);

        // var_dump($sname);
        // var_dump($uid);
        // exit;
      $select2 = array('Lockin','Cooling_Period','Lockin_Period','Interest_Rate','Pre_Mat_Rate');
        $this->db->select($select2);
        $this->db->from('invest_scheme_details');
        $this->db->where('Scheme_Name', $sname);
        $query = $this->db->get();
        $result1 = $query->result_array();

       $select1 = array('Investment_Amt','Investment_date');
       $sname = ("invest_".$sname);
    //   $this->db = $this->load->database('schemesdb', TRUE);
      $this->db->select($select1);
      $this->db->from($sname); 
      $this->db->where('IID',$iid);
      $query =  $this->db->get();
      $result = $query->result_array();
    
      $Lockin = $result1['0']['Lockin'];
      $Interest_Rate =  $result1['0']['Interest_Rate'];
      $Pre_Mat_Rate = $result1['0']['Pre_Mat_Rate'];
      $Lockin_Period = $result1['0']['Lockin_Period'];
      $Cooling_Period = $result1['0']['Cooling_Period'];

      $Investment_Amt = $result['0']['Investment_Amt'];
      $Investment_date = $result['0']['Investment_date'];


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

  $earning =  number_format((float)$earning,2,'.','');
      
$earnings = array("value"=>$earning,"Interest"=>$Interest_Rate);
        
    //    return number_format((float)$earnings,2,'.','');

    return $earnings;

}


public function allvendors_post()
{
   $query = $this->db->query("SELECT VID,Company_Name FROM invest_vendors");
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
    // $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '3'");
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
    { $upd = array('VID'=>$rqst['VID']); 
        unset($rqst['VID']);}
    if($rqst['updcode'] == 2)
    {  $upd = array('RID'=>$rqst['RID']);  
        unset($rqst['RID']);       }
    if($rqst['updcode'] == 3)
    {  $upd = array('SID'=>$rqst['SID']);     
        $sid = $rqst['SID'];
        $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE SID = '$sid'");
      $result = $query->result_array();
      $old = "invest_".$result['0']['Scheme_Name'];
      $new = "invest_".$rqst['Scheme_Name'];
    //   $db2 = $this->load->database('schemesdb', TRUE);
      $this->db->query("alter table $old rename to $new ;");
      unset($sid);
      unset($old);
      unset($new);
      unset($rqst['SID']); 
    }
    if($rqst['updcode'] == 4)
    {  $upd = array('UID'=>$rqst['UID']); 
        unset($rqst['UID']); }
 
    unset($rqst['updcode']);
    // var_dump($rqst);
    // exit;
    $updated = $this->DetailModel->update_values($rqst,$upd);
    // $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE Vendor_ID = '3'");
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
        $value = array('cd' => '1'); 
        $value += array('tname' => 'invest_vendors'); }
    if($rqst['dcode'] == 2)
     {  $upd = array('RID'=>$rqst['value']); 
        $value = array('cd' => '2');
        $value += array('tname' => 'invest_authorised_users'); }
    if($rqst['dcode'] == 3)
     {  $upd = array('SID'=>$rqst['value']);  
        $value = array('cd' => '3'); 
        $value += array('tname' => 'invest_scheme_details');
        }
    if($rqst['dcode'] == 4)
     {  $value = array('cd' => '4');
        $value += array('tname' => 'invest_users1');
        $upd = array('UID'=>$rqst['value']);  }

    // $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE SID = ".$upd['SID']);
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

// function dynamic_roi($loan_amount,$base_interest_rate) {
//    // Set a base interest rate
// //    $base_interest_rate = 5.0;
   
//    // Determine the loan amount range
//    if ($loan_amount < 10000) {
//        // For loan amounts less than 10,000, apply the base interest rate
//        $interest_rate = $base_interest_rate;
//    } elseif ($loan_amount >= 10000 && $loan_amount < 50000) {
//        // For loan amounts between 10,000 and 50,000, increase the interest rate by 0.5%
//        $interest_rate = $base_interest_rate + 0.5;
//    } elseif ($loan_amount >= 50000 && $loan_amount < 100000) {
//        // For loan amounts between 50,000 and 100,000, increase the interest rate by 1%
//        $interest_rate = $base_interest_rate + 1.0;
//    } else {
//        // For loan amounts over 100,000, increase the interest rate by 1.5%
//        $interest_rate = $base_interest_rate + 1.5;
//    }
   
//    // Return the calculated interest rate
//    return $interest_rate;
// }



function dynamic_roi($base_interest_rate) {
    
 $loan_amount = 1000000;
    // Determine the loan amount range
    if ($loan_amount < 10000) {
        // For loan amounts less than 10,000, apply the base interest rate
        $interest_rate = $base_interest_rate;
    } elseif ($loan_amount >= 10000 && $loan_amount < 50000) {
        // For loan amounts between 10,000 and 50,000, increase the interest rate by 0.5%
        $interest_rate = $base_interest_rate + 0.5;
    } elseif ($loan_amount >= 50000 && $loan_amount < 100000) {
        // For loan amounts between 50,000 and 100,000, increase the interest rate by 1%
        $interest_rate = $base_interest_rate + 1.0;
    } else {
        // For loan amounts over 100,000, increase the interest rate by 1.5%
        $interest_rate = $base_interest_rate + 1.5;
    }
    
    // Return the calculated interest rate
    return $interest_rate;
 }
public function all_vendor_post()
{
    $rqs = json_decode(file_get_contents('php://input'),true);
    if(isset($rqs['VID']))
    {
        $vid = $rqs['VID'] ;
        $query = $this->db->query("SELECT VID,Company_Name, Address, Phone, Email FROM invest_vendors WHERE VID = '$vid';");
         $star = $query->result_array();
         // $star = json_encode($result);
         $this->response($star, 200);  
    }
      else
    {
         $query = $this->db->query("SELECT VID,Company_Name, Address, Phone, Email FROM invest_vendors;");
         $star = $query->result_array();
         // $star = json_encode($result);as
         $this->response($star, 200);  
    }
    
}

public function all_scheme_post()
{
       $rqs = json_decode(file_get_contents('php://input'),true);
    if(isset($rqs['SID']))
    {
        $sid = $rqs['SID'] ;
        $query = $this->db->query("SELECT * from invest_scheme_details WHERE SID = '$sid'");
         $star = $query->result_array();
         // $star = json_encode($result);
         $this->response($star, 200);  
    }
      else
    {
         $query = $this->db->query("SELECT * FROM invest_scheme_details");
         $star = $query->result_array();
         // $star = json_encode($result);
         $this->response($star, 200);  
    }
    
}

function redemptions_post()
{
    $query = $this->db->query("SELECT * FROM invest_scheme_details");
    $result = $query->result_array();
    foreach($result as &$row)
  { 
           $row['Scheme_Name'] = "invest_".(strtolower($row['Scheme_Name']));
  }
    $result33 = $this->DetailModel->check_redeemptions($result);
    $result33 = array($result33);

  foreach( $result33 as &$row) { 
    foreach($row as &$rows)
     {
       $rvalue =  $this->redeemption_value($rows['tablename'],$rows['IID']);

       $rows['rvalue'] = $rvalue ;

       $query = $this->db->query("SELECT Company_Name FROM invest_vendors where VID = ".$rows['Vendor_ID']);
       $result = $query->row_array();
       $rows['Vendor'] =  $result['Company_Name'];
       $rows['op'] = $rows['tablename'];

     } 
    }

    // var_dump($result33);
    // exit;
//    foreach( $result33 as &$row) { foreach($row as &$rows) { unset($rows['tablename']); } }
   $this->response($result33, 200);  
}

public function all_rep_post()
{
        $rqs = json_decode(file_get_contents('php://input'),true);
        if(isset($rqs['VID']))
        {  
        $Vendor_ID = $rqs['VID'];
        }
        if(isset($rqs['RID']))
        {
            $rid = $rqs['RID'] ;
            $query = $this->db->query("SELECT RID,Repphone,RepName,RepDesignation,RepDesignation,Repemail FROM invest_authorised_users WHERE RID = '$rid'");
             $star = $query->result_array();
             // $star = json_encode($result);
             $this->response($star, 200);  
        }
          else
        {
             $query = $this->db->query("SELECT RID,Repphone,RepName,RepDesignation,RepDesignation,Repemail FROM invest_authorised_users where Vendor_ID = $Vendor_ID");
             $star = $query->result_array();
             // $star = json_encode($result);
             $this->response($star, 200);  
        }
    
}

public function upd_scheme_post()
{
    $query = $this->db->query("SELECT * FROM invest_scheme_details");
    $star = $query->result_array();
   // $star = json_encode($result);
    $this->response($star, 200);   
}
public function total_values()
{

    $rqst = json_decode(file_get_contents('php://input'), true);

    var_dump($rqst);


}
// public function emailsending()
// {

// // $this->load->library('email');

// // $this->email->from('revantestop@gamail.com', 'Star');
// // $this->email->to('raxtestop@gmail.com');
// // // $this->email->cc('another@another-example.com');
// // // $this->email->bcc('them@their-example.com');

// // $this->email->subject('Email Test');
// // $this->email->message('Testing the email class.');

// // if($this->email->send())
// // {
// //     $res = "Email Sent Successfully";
// // }

// // else 
// // {
// //     $res = 'Error sending email: ' . $this->email->print_debugger();
// // }
// $this->load->library('email');
// // $config = Array(
// //     'protocol' => 'smtp',
// //     'smtp_host' => 'smtp.falconide.com',
// //     'smtp_port' => 587,
// //     'smtp_user' => 'antworksmoney',
// //     'smtp_pass' => 'a91b34!81a582',
// //     'mailtype' => 'html',
// //     'charset' => 'iso-8859-1'
// // );
// // $this->load->library('email', $config);
// $this->email->set_mailtype("html");
// $this->email->set_newline("\r\n");
// $this->email->from('support@antworksmoney.com','Antworks P2P Financing');
// $this->email->to('revantestop@gmail.com');
// $this->email->subject("testing");
// $this->email->message("Testing Email");
// if (!$this->email->send()) {
// //					$this->db->set('send_to_escrow',1);
// //					$this->db->where('id',$id);
// //					$this->db->update('borrower_emi_details',$id);
// var_dump($this->email->send());
//    $res= $this->email->print_debugger();
//     // $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
//     // redirect(base_url().'management/repayment');
// }
// else {
//     var_dump($this->email->send());
//     $res="Not Sent, Please Try Again!". $this->email->print_debugger();
//     // $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
//     // redirect(base_url().'management/repayment');

// }

// // INSERT INTO `p2p_admin_email_setting` (`id`, `protocol`, `smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `mailtype`, `charset`, `wordwrap`, `status`) VALUES
// // (1, 'smtp', 'smtp.falconide.com', 587, 'antworksmoney', 'a91b34!81a582', 'html', 'iso-8859-1', 'TRUE', 1);

// return $res;

// }
   
public function verify_pay_post()
{
    echo "test";
    exit;
}

public function paymentverify($data)
	{
		//$apiEndpoint = "https://www.antworksp2p.com/invest/index.php/invest/".$data['ap'];
		$apiEndpoint = "https://antworksmoney.com/apiserver/antapp/generateOrder";
		// unset($data['ap']);
		$jsonData = json_encode($data);
		// var_dump($data);
		// exit;

// Initialize a curl session
$curl = curl_init();

// Set the curl options
curl_setopt($curl, CURLOPT_URL, $apiEndpoint);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
'Content-Type: application/x-www-form-urlencoded', // Set the content type as per your API documentation
'Authorization: Basic ' . base64_encode('antApp_2021:Ant_Secure&@165'), // Replace 'username' and 'password' with your own Basic auth credentials
'X-API-KEY: startest' // Replace 'your_api_key' with your own API key
));

// Execute the curl session and get the response
$response = curl_exec($curl);

// Check for errors
if (curl_errno($curl)) {
$error = curl_error($curl);
echo "Curl error: $error";
}

// Close the curl session
curl_close($curl);
return $response;

	}
public function emailsending()
{
    // $this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');

    $confige = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.falconide.com',
        'smtp_port' => 587,
        'smtp_user' => 'antworksmoney',
        'smtp_pass' => 'a91b34!81a582',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap'=> 'TRUE'
    );

    $this->load->library('email', $confige);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			$this->email->from('support@antworksmoney.com', 'Antworks P2P Financing');
			$this->email->to('starraxtestt@gmail.com');
			// $this->email->attach($attched_file);
			$this->email->subject('Repayment Files');
			$this->email->message("Testing email");
			if ($this->email->send()) {
                
var_dump($this->email->send());
$res= $this->email->print_debugger();
echo $res;
				return true;
			} else {
				return false;
			}

            exit;
		
    $this->load->library('email');
    $confige = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.falconide.com',
    'smtp_port' => 587,
    'smtp_user' => 'antworksmoney',
    'smtp_pass' => 'a91b34!81a582',
    'mailtype' => 'html',
    'charset' => 'iso-8859-1'
);
$this->load->library('email',$confige);
$this->email->set_mailtype("html");
$this->email->set_newline("\r\n");
$this->email->from('testing@antworksmoney.com');
$this->email->to('revantestop@gmail.com');
$this->email->subject("testing");
$this->email->message("Testing Email");
if (!$this->email->send()) {
//					
var_dump($this->email->send());
   $res= $this->email->print_debugger();
  
}
else {
    var_dump($this->email->send());
   $res =  $this->email->print_debugger();

}
return $res;

}


public function testing3_post()
{

    echo "testing";

//     $a = "PHP";
// $a = $a + 1;
// echo $a;

//   $max = 50;
//   for($i=1;$i <= $max;$i++)
//   {
//     $input = $i;
//     for ($i = 2; $i <= $input-1; $i++) {  
//       if ($input % $i == 0) {  
//       $value= True;  
//       }  
// }  
// if (isset($value) && $value) {  
//      echo 'The Number '. $input . ' is not prime';  
// }  else {  
//    echo 'The Number '. $input . ' is prime';  
//    }   
// }
  
  
//     $email = "starraxtest@gmail.com";
//     $msg = "hi its a testing";
    
//     $sub = "testing email";
//    $respo = $this->emailsender($email,$msg,$sub);
//    echo $respo;

}
public function emailsender($email,$msg,$subject) {

    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.falconide.com',
        'smtp_port' => 587,
        'smtp_user' => 'antworksmoney',
        'smtp_pass' => 'a91b34!81a582',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1'
    );

    // Set to, from, message, etc.
    $this->load->library('email', $config);
    $this->email->from("support@antworksmoney.com","Antworks Money");
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");
    $this->email->to($email);
    $this->email->subject($subject);
    $this->email->message($msg);

   // var_dump($respp);
    //var_dump($this->email);
    if( ! $this->email->send()){

        var_dump($this->email->send());
        var_dump($this->email->print_debugger());

        $res = " NOt sent";
    }
    else
    {
        //return false;
      $res = "Email Sent Sucessfully";
      var_dump($this->email->print_debugger());
      exit;
    }

   // return $res;
}


private function only_form_validation()
{

    $_POST = json_decode(file_get_contents('php://input'), true);
    $this->form_validation->set_rules('Scheme_ID','Scheme_ID','required');
    $this->form_validation->set_rules('User_ID','User_ID','required');
    $this->form_validation->set_rules('Investment_Amt','Investment_Amt','required'); 
    // $this->form_validation->set_rules('ifsc_code','ifsc_code','required|regex_match[/^[A-Z]{4}0[A-Z0-9]{6}$/]');
    // $this->form_validation->set_rules('phone','phone','required|regex_match[/^[0-9]{10}$/]');
    
   
    if ($this->form_validation->run() == TRUE)
     {
         //Getting details from request }
      }
      else {
        $errmsg = array("error_msg" => validation_errors());
        $errmsg['status'] = 0;
        $this->set_response($errmsg, RestController::HTTP_OK);
        return;
              } 

}

}
?>



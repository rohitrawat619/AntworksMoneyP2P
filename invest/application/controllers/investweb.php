<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
//use chriskacerguis\RestServer\RestController;
 


class investweb extends CI_Controller

//class invest extends CI_Controller
{

    function index()
{
   // $this->load->view('test');
    $this->load->view('header');
$this->load->view('dashboard');
$this->load->view('footer');
      // $this->load->view('page');
//$this->load->library('Rest',$config);
}
public function __construct()
    { 
     
        parent::__construct();
        //parent::__construct();
        $this->load->model('DetailModel');

    }
//Successfull and Unauthorised response
    // $this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);
	// 	$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);

    public function login_users() {
        $data = array();
        if ($this->input->post('submit')) {
            $email = $this->input->post('Email');
            $password = md5($this->input->post('Password'));
            $user_data = $this->DetailModel->check_login($email, $password);
            if ($user_data) {
                $this->session->set_userdata('user_id', $user_data['id']);
                $this->session->set_userdata('user_email', $user_data['email']);
                redirect('dashboard');
            } else {
                $data['error'] = 'Invalid Email or Password';
            }
        }
        $this->load->view('page', $data);
    }
    
    public function form_submit()
    {
        if ($this->input->post() && $this->security->xss_clean($this->input->post()))
        {
            // Validate the CSRF token
            if ($this->security->xss_clean($this->input->post()) && $this->security->csrf_token_check($this->input->post()))
            {
                // Process the form data
                $this->load->model('FormModel');
                $data = array(
                    'field1' => $this->input->post('field1'),
                    'field2' => $this->input->post('field2'),
                    // ...
                );
                $this->FormModel->insert_data($data);
            }
            else
            {
                // Return an error message
                echo "CSRF token is invalid";
            }
        }
        else
        {
            // Return an error message
            echo "Data validation failed";
        }
    }
    
    public function logout_users() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        redirect('invest/login_users');
    }

    public function fetch_get()
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
            //vendor details $rqst only representaive details
            $vdetails =   array_splice($rqst, 0, 4);

           // Check if user already exist

        if(!($this->DetailModel->vend_check($vdetails)) && !($this->DetailModel->rep_check($rqst))){
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
            $iids = array($iid,$Repid);
            $star = "Vendor Added Successfully";
            $this->response($iids,200);
        } else {
            $star = "Sorry some error occured";
            $this->response($star, 200);
        }
           }
 
        }
       
        if(($this->DetailModel->vend_check($vdetails)) && !($this->DetailModel->rep_check($rqst))){

            
            $Repid =  $this->DetailModel->regrepresentative($rqst);

            $resp = "Vendor Already Exist! Respresentaive added successfully";
            $this->response($Repid, 200);

        }

        if(($this->DetailModel->vend_check($vdetails)) && ($this->DetailModel->rep_check($rqst)))
        {
              $resp = "Vendor and Representatives Already Exist!";
              $this->response($resp,200);
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
  


    //$borrower_pan_json = json_encode($arr_borrower);


       function validate_pan($str)
    {
            $pattern = "/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/";
            if (!preg_match($pattern, $str)) {
                return FALSE;
            } else {
                return TRUE;
            }
        }

     
//     //RAW DATA
//(
// [0] => {"pan":
//     [1] => "CXFPD3663J",
//     [2] => "status":
//     [3] => "Active",
//     [4] => "name":
//     [5] => "ROHIT
//     [6] => DALAL",
//     [7] => "name_match_score":
//     [8] => 100},
//     [16] => "http_response_code":
//     [17] => 200,
//     [18] => "request_id":
//     [19] => "a24ebcca-a863-11ed-b599-ee5841a5e673",
//     [20] => "client_ref_num":
//     [21] => "63e4c95b5fe49",
//     [29] => "result_code":
//     [30] => 101}
//     )

    public function basi_kyc_get()
    {
        
      $result = $this->DetailModel->basic_pan_kyc($PAN, $fullname);
      $resppan = (explode(" ",$result));
        $namematch = $resppan['8'];
       $Panmatch = $resppan['1'];

       if(($Panmatch = $pan) && ($namematch = 100));
       {    
        $response = "Verified Successfully";
        $this->set_response(json_decode($response, true), REST_Controller::HTTP_OK);   }
      
        if(($Panmatch = $pan) && ($namematch != 100));
        {  
            $this->set_response("Not Verified", REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    public function user_reg_post()
    {
        //apicheck
        $star = apache_request_headers();
        $akey = $star['X-API-KEY'];

        $res = $this->DetailModel->vID_check($akey);

        $Vendor_ID = $res['id'];

        //body data
        $data = file_get_contents('php://input');
        $rqst = json_decode($data, true);
      
       $tname = "users1";
       $fID = $this->DetailModel->latestiddb1($tname);
        
       $id = $fID['id'];
       $userid = $id + 1;
         $phone = $rqst['phone'];
       $email = $rqst['email'];
        $fullname = $rqst['fullname'];
        $rqst['password'] = md5($rqst['password']);
        $PAN = $rqst['PAN'];
        $DOB = $rqst['DOB'];

        //Validating age and PAN No. Pattern
       if(($this->validate_pan($PAN)) && (!$this->validate_age($DOB))) {
        echo "You should be above 18 for investing";
    }

    if((!$this->validate_pan($PAN)) && ($this->validate_age($DOB))) {
        echo "Enter Valid PAN Card Number";
    }
        if (!$this->validate_pan($PAN) && (!$this->validate_age($DOB))) {
            echo "Please Enter valid Pan and Dob";
        }
        if ($this->validate_pan($PAN) && $this->validate_age($DOB)) {
            $userd = [
                'phone' => $phone,
                'email' => $email,
                'fullname' => $fullname
            ];

            // Check if user already exist
            if ($this->DetailModel->check_user($userd)) {
                $resp = "User Already Exist!";
                $this->response($resp, 200);
            } else {
                //Create date Time Stamp
                $d = time();
                $d = date("Y-m-d h:i:sa", $d);
                $rqst += array("Reg_Date" => $d);
                $rqst += array("Vendor_ID" => $Vendor_ID);
                $iid = $this->DetailModel->reguser($rqst);
                $result = $this->db->affected_rows();
                
                if ($result==null)
                {
                    $star = "Failed";
                    $this->response($star, 200);
                } else {
                    $star = "Done";
                    $this->response($iid, 200);
                    }
                 
                

            }
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
       // $this->SchemeT_Check($sname);
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
    $query = $this->db->query("SELECT Scheme_Name,Vendor_ID FROM scheme_details WHERE ID = '$Scheme_ID'");
    $name = $query->row_array();
    $sname = $name['Scheme_Name'];
  $Vendor_ID = $name['Vendor_ID'];
  $fID = $this->DetailModel->latestiddb2($sname);
  $id = $fID['id'];
        $id = $id + 1;
  
        $db2 = $this->load->database('schemesdb', TRUE);
        $this->load->dbforge();

        if (($db2->table_exists($sname))) { $this->SchemeT_Check($sname); }

    $d = time();
    $d = date("d/m/y", $d);
    $rqst += array("Investment_date" => $d);
        


    $Investment_ID = $id."-" . $Vendor_ID . "-" . $Scheme_ID . "-".date("dmy");
    $rqst += array("Investment_ID" => $Investment_ID);

     unset($rqst['Scheme_ID']);

        $iid = $this->DetailModel->regschemeusers($sname,$rqst);
        // var_dump($iid);
        //     die();
   
            $result = $db2->affected_rows();
    if ($result) {
        $star = "Done1";
        
            $iid = array($iid, $star);
            
        $this->response($iid , 200);
    } else {
        $star1 = "Failed";
        $iid = array('0', $star1);
        $this->response($iid, 200);
    }

    
     //$this->response($resultdet, 200);
    
   }

//raw scheme details
//    1	ID Primary	int(11)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
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



// testing json
// {
//        "Scheme_Name": "Astro_op",
//         "Min_Inv_Amount": "100000",
//         "Max_Inv_Amount": "1000000",
//         "Aggregate_Amount": "12300",
//         "Lockin": "0",
//         "Interest_Rate": "10",
//         "Interest_Type": "simple",
//         "Withrawl_Anytime": "1",
//         "Pre_Mat_Rate": "3",
//         "Lockin_Period": "60",
//         "Tenure": "180",
//         "Cooling_Period": "10",
//         "Auto_Redeem": "1"
//     }


   public function Scheme_add_post()
   {  
       //apicheck
       $star=apache_request_headers();
       $akey = $star['X-API-KEY'];

       $res = $this->DetailModel->vID_check($akey);

       $Vendor_ID =  $res['id'];
     
           $data = file_get_contents('php://input');
           $rqst = json_decode($data, true);
            
          // Check if scheme already exist
       if(!($this->DetailModel->scheme_check($rqst))){
           //$d=time();
           //$d= date("Y-m-d h:i:sa", $d);
           $rqst += array("Vendor_ID" => $Vendor_ID);
           
          
           //Insert Scheme details details
          $iid = $this->DetailModel->regscheme($rqst);

           //check if details added or not 
           $result = $this->db->affected_rows();

       if ($result) {
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

        public function SchemeT_Check($sname)
        {
            $db2 = $this->load->database('schemesdb', TRUE);
            $this->load->dbforge();
             $createtable = "CREATE TABLE $sname ( " .
                    "ID INT(20) NOT NULL AUTO_INCREMENT, " .
                    "User_ID INT(20) NOT NULL, " .
                    "Investment_ID VARCHAR(50) NOT NULL, " .
                    "fullname VARCHAR(200) NOT NULL, " .
                    "Investment_Amt INT(20) NOT NULL, " .
                    "Investment_type VARCHAR(5) NOT NULL, " .
                    "Investment_date timestamp NOT NULL, " .
                    "Redeem_date timestamp NOT NULL, " .
                    "Status VARCHAR(15) NOT NULL, " .
                    "PAN VARCHAR(20) NOT NULL, " .
                    "PRIMARY KEY (ID)" .
                    ");";
        
                 
            $db2->query($createtable);
                 
        }

            
    public function lender_detailshow_get()
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
            $this->DetailModel->lenderdetails1_show($sname, $User_ID);
            $results = $this->db->affected_rows();

            if ($results) {
                $this->output->set_content_type('application/json');
                $this->output->set_output(json_encode($result));
            } else {
                $star = "Failed";
                $this->response($star, 200);
            }
        }    
    }

    public function show_all_users_get()
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
    public function show_all_schemes_get()
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


    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'revantestop@gmail.com',
        'smtp_pass' => 'revantestop007',
        'mailtype' => 'html',
        'charset' => 'utf-8'
      );
      
        $this->email->initialize($config);

        $this->email->from('revantestop@gmail.com', 'Star Test');
        $this->email->to('starraxtest@gmail.com');
        $this->email->subject('Testing Email');
        $this->email->message('Hi, its a testing email');

if ($this->email->send()) {
    echo 'Email sent successfully.';
  } else {
    echo 'Email sending failed.';
  }

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
    //     $createtable = "CREATE TABLE $sname ( " .
    //         "ID INT(20) NOT NULL AUTO_INCREMENT, " .
    //         "User_ID INT(20) NOT NULL, " .
    //         "Investment_ID VARCHAR(50) NOT NULL, " .
    //         "fullname VARCHAR(50) NOT NULL, " .
    //         "Investment_Amt INT(20) NOT NULL, " .
    //         "Investment_type VARCHAR(5) NOT NULL, " .
    //         "Investment_date datetime NOT NULL, " .
    //         "Redeem_date datetime NOT NULL, " .
    //         "Status VARCHAR(15) NOT NULL, " .
    //         "PAN VARCHAR(20) NOT NULL, " .
    //         "PRIMARY KEY (ID)
    //         );";

    //     $db2->query($createtable);
    // } else {
    //     echo "table already exist";
    // }
    

      //  $this->SchemeT_Check("starteest111");
     
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
    // $this->SchemeT_Check($sname);
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
      $db2->where('ID',$uid);
      $query =  $db2->get();
      $result = $query->result_array();
     
      $Lockin = implode (array_column($result1, 'Lockin'));
      $Interest_Rate = implode (array_column($result1, 'Interest_Rate'));
      $Pre_Mat_Rate = implode (array_column($result1, 'Pre_Mat_Rate'));
      $Lockin_Period = implode (array_column($result1, 'Lockin_Period'));
      $Cooling_Period = implode (array_column($result1, 'Cooling_Period'));

      $Investment_Amt = implode (array_column($result, 'Investment_Amt'));
      $Investment_date = implode (array_column($result, 'Investment_date'));
      $indexed_result = implode (array_column($result, 'Investment_Amt'));


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
      $db2->where('ID',$uid);
      $query =  $db2->get();
      $result = $query->result_array();
     
      $Lockin = implode (array_column($result1, 'Lockin'));
      $Interest_Rate = implode (array_column($result1, 'Interest_Rate'));
      $Pre_Mat_Rate = implode (array_column($result1, 'Pre_Mat_Rate'));
      $Lockin_Period = implode (array_column($result1, 'Lockin_Period'));
      $Cooling_Period = implode (array_column($result1, 'Cooling_Period'));

      $Investment_Amt = implode (array_column($result, 'Investment_Amt'));
      $Investment_date = implode (array_column($result, 'Investment_date'));
      $indexed_result = implode (array_column($result, 'Investment_Amt'));


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

    //   return $earning;



}





   
 }




?>

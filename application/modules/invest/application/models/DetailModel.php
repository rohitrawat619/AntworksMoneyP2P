<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class DetailModel extends CI_Model
{

    public function __construct()
    { 
     
        parent::__construct();
        //parent::__construct();
        
        $db2 = $this->load->database('schemesdb', TRUE);
       

    }

    public function check_login($email, $password) {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users1');
        return $query->row_array();
    }


    
    //  function getRecords(){
     
    //      // Load database
    //      $db2 = $this->load->database('schemesdb', TRUE);
    
    //      // Select records from 1st database
    //      $this->db->select('*');
    //      $q = $this->db->get('users');
    //      $result1 = $q->result_array();
    
    //      // Select records from 2nd database
    //      $db2->select('*');
    //      $q = $db2->get('students');
    //      $result2 = $q->result_array();
     
    //      $response = array("response1"=>$result1,"response2"=>$result2);
    //      return $response;
    //  }

  public function data_t()
    {  
        $query=$this->db->get('users1');
        return $query->result();
    }
    public function check_user($userd)
    {
        $this->db->select('*'); 
        $this->db->where($userd);		
		 $query = $this->db->get('users1');
        $result = $query->row_array();
        return $result;
    }
        
    
    public function latestiddb1($tname)
    {
        if($tname="authorised_users"){$id='RID';}
        if($tname="scheme_details"){$id='SID';}
        if($tname="users1"){$id='UID';}
        if($tname="vendors"){$id='VID';}
       
        $this->db->select_max($id);
        $query = $this->db->get($tname);
        $result = $query->row_array();
        return $result;
     }

     public function latestiddb2($tname)
     {
        $db2 = $this->load->database('schemesdb', TRUE);
        $db2->select_max('IID');
         $query = $db2->get($tname);
         $result = $query->row_array();
         return $result;
      }
 

    public function reguser($data)
    {   
        $this->db->insert('users1',$data); 
        return $this->db->insert_id(); 
        
    }
    
    public function reguser_scheme($userd,$uid)
    {
        $this->db->where($uid);	
       $query = $this->db->update('users1',$userd);
       return $query;
        
    }
    public function testdata($uid)
    {  
        $this->db->where($uid);	
        $query=$this->db->get('users1',UID);
        return $query->result();
    }

    public function vID_check($akey)
    {  
        $this->db->select('VID'); 
        $this->db->where('key', $akey);
        $query=$this->db->get('vendors');   
        $result = $query->row_array();
        return $result;
    }

    public function vend_check($userd)
    {
        $this->db->where($userd);		
		 $query = $this->db->get('vendors');	
		return $query->result();
    }
    public function rep_check($userd)
    {
        $this->db->where($userd);		
		 $query = $this->db->get('authorised_users');	
		return $query->result();
    }
    


    public function regvendor($data)
    {   
        $this->db->insert('vendors',$data);  
        return $this->db->insert_id();   
        
    }

    public function regrepresentative($data)
    {   
        $this->db->insert('authorised_users',$data); 
        return $this->db->insert_id();    
    }

    public function scheme_check($schemed)
    {
        $this->db->where($schemed);		
		 $query = $this->db->get('scheme_details');	
		return $query->result();
    }
    
    public function regscheme($data)
    {   
        $this->db->insert('scheme_details',$data); 
        return $this->db->insert_id();  

    }

   public function basic_pan_kyc($pan,$fullname) {

        $URL = "https://svcdemo.digitap.work/validation/kyc/v1/pan_basic"; 
        $Client_Id_PAN= "11199344"; 
        $Client_Secret_PAN = "jFjXGxllHLzs1jlQIcM9leJZL4RRAhCk"; 
        $name_match_method= "fuzzy";

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
        'client_ref_num' => uniqid(),
        'pan' => $pan,
        'name' => $fullname,
        'name_match_method' => $name_match_method,
    )),
    CURLOPT_HTTPHEADER => array(
        'authorization: ' . base64_encode($Client_Id_PAN . ':' . $Client_Secret_PAN),
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);

        return $response;

}

public function regschemeusers($sname,$data)
{   
  $db2 = $this->load->database('schemesdb', TRUE);
  $db2->insert($sname,$data);
  return $db2->insert_id();

}

    public function lenderdetails_show($schemed)
    {
        $fields = array('Interest_Rate','Lockin');
        $this->db->select($fields);
        $this->db->where($schemed);		
        $query = $this->db->get('scheme_details',);	
        return $query->result();
    }

    public function lenderdetails1_show($sname,$User_ID)
    {
        $db2 = $this->load->database('schemesdb', TRUE);
       // $fields = array('Redeem_Date','Lockin','Status');
       // $this->db->select($fields);
        $db2->where($User_ID);		
        $query = $db2->get($sname);	
        return $query->result();
    }

    // function check_value($value,$sname) {
    //     $db2 = $this->load->database('schemesdb', TRUE);
    //     // var_dump($sname);
    //     // exit;
    //     $sql = '';
    //     foreach ($sname as $table) {
    //         $sql .= "SELECT *, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE user_id = '" . $value. "' UNION ALL ";
    //     }
    //     $sql = rtrim($sql, "UNION ALL ");
    //     $query = $db2->query($sql);
    //     if ($query->num_rows() > 0) {
    //         // Value exists in at least one table
    //         $result = $query->result_array();
    //         return $result;
    //     } else {
    //         // Value does not exist in any table
    //        return False; 
    //        //echo "Value does not exist in any table";
    //     }

        function check_value($value,$sname) {
            $db2 = $this->load->database('schemesdb', TRUE);
            // var_dump($sname);
            // exit;
            $sql = '';
            foreach ($sname as $table) {
                $sql .= "SELECT *, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE user_id = '" . $value. "' UNION ALL ";
            }
            $sql = rtrim($sql, "UNION ALL ");
           $sql .= "ORDER BY status ASC"; 
            $query = $db2->query($sql);
            if ($query->num_rows() > 0) {
                // Value exists in at least one table
                $result = $query->result_array();
                return $result;
            } else {
                // Value does not exist in any table
               return False; 
               //echo "Value does not exist in any table";
            }
}

function check_valueven($value,$sname) {
    $db2 = $this->load->database('schemesdb', TRUE);        
    // var_dump($sname);
    // exit;
    $sql = '';
    foreach ($sname as $table) {
        $sql .= "SELECT *, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE Vendor_ID = '" . $value. "' UNION ALL ";
    }
    $sql = rtrim($sql, "UNION ALL ");
   $sql .= "ORDER BY status ASC"; 
    $query = $db2->query($sql);
    if ($query->num_rows() > 0) {
        // Value exists in at least one table
        $result = $query->result_array();
        return $result;
    } else {
        // Value does not exist in any table
       return False; 
       //echo "Value does not exist in any table";
    }
}

function update_valuestts($value,$upd) {
    $db2 = $this->load->database('schemesdb', TRUE);
  //  $update_rows = array('Status' => $value['status']);
    $db2->where('Investment_ID', $value['id'] );
   $query = $db2->update($value['sname'], $upd);

    if ($query) {
        // Value exists in at least one table
       // $result = $query->result_array();
        return $query;
    } else {
        // Value does not exist in any table
       return False; 
       //echo "Value does not exist in any table";
    }
}



function update_values($value,$upd) {
   // $db2 = $this->load->database('schemesdb', TRUE);
  //  $update_rows = array('Status' => $value['status']);
    $this->db->where('Investment_ID', $value['id'] );
   $query = $this->db->update($value['sname'], $upd);

    if ($query) {
        // Value exists in at least one table
       // $result = $query->result_array();
        return $query;
    } else {
        // Value does not exist in any table
       return False; 
       //echo "Value does not exist in any table";
    }
}


public function del_values($value,$upd) {

    // $this->load->dbforge();
    // $db2 = $this->load->database('schemesdb', TRUE);
  
    // $db2 = $this->load->database('schemesdb', TRUE);
   //  $update_rows = array('Status' => $value['status']);
   if($value['cd']==1)
   { 
    $this->load->dbforge();
    $db2 = $this->load->database('schemesdb', TRUE);
 
    $query = $this->db->query("SELECT Scheme_Name FROM scheme_details WHERE SID = ".$upd['SID']);
     $result = $query->result_array();
    //  var_dump($result);
    //  exit;
    // $this->db->where($upd);
    // $query = $this->db->delete($value['tname']);
    $db2->query('DROP TABLE '.$result['0']['Scheme_Name']);
     
   }
   $this->db->where($upd);
   $query = $this->db->delete($value['tname']);

     if ($query) {
         // Value exists in at least one table
        // $result = $query->result_array();
        return $query;
     } else {
         // Value does not exist in any table
       return False; 
        //echo "Value does not exist in any table";
     }
 }

//  public function sendOtp()
//  {	
//      $query = $this->bizhub->get_where('app_user_list', array('mobile' => $this->input->post('mobile')));
//      if ($this->bizhub->affected_rows() > 0) {
//          $result = $query->row_array();
//          $user_id = $result['user_id'];
//      } else {
//          $this->bizhub->insert('app_user_list', array(
//                  'name' => $this->input->post('name'),
//                  'mobile' => $this->input->post('mobile'),
//                  'ip_address' => $this->input->ip_address(),
//              )
//          );
//          $user_id = $this->bizhub->insert_id();
//      }
//      #Add Update App Data
//      $this->bizhub->get_where('app_mobile_user_details', array('user_id' => $user_id));
//      if ($this->bizhub->affected_rows() > 0) {
//          $mobileDetails = array(
//              'imei_no' => $this->input->post('imeiNo') ? $this->input->post('imeiNo') : '',
//              'mobile_token' => $this->input->post('firebaseToken') ? $this->input->post('firebaseToken') : '',
//              'model_no' => $this->input->post('modelNo') ? $this->input->post('modelNo') : '',
//              'latitude' => $this->input->post('latitude') ? $this->input->post('latitude') : '',
//              'longitude' => $this->input->post('longitude') ? $this->input->post('longitude') : '',
//          );

//          $this->bizhub->where('user_id', $user_id);
//          $this->bizhub->update('app_mobile_user_details', $mobileDetails);
//      } else {
//          $mobileDetails = array(
//              'user_id' => $user_id,
//              'mobile' => $this->input->post('mobile'),
//              'imei_no' => $this->input->post('imeiNo') ? $this->input->post('imeiNo') : '',
//              'mobile_token' => $this->input->post('firebaseToken') ? $this->input->post('firebaseToken') : '',
//              'model_no' => $this->input->post('modelNo') ? $this->input->post('modelNo') : '',
//              'latitude' => $this->input->post('latitude') ? $this->input->post('latitude') : '',
//              'longitude' => $this->input->post('longitude') ? $this->input->post('longitude') : '',
//          );
//          $this->bizhub->insert('app_mobile_user_details', $mobileDetails);
//      }


//      $query = $this->bizhub->get_where('app_otp_details', array('mobile' => $this->input->post('mobile'), 'created_at >=' => 'now() - INTERVAL 1 DAY', '1 !=' => 1));
//      if ($this->bizhub->affected_rows() > 0) {
//          $result = count($query->result_array());
//          if ($result > 30) {
//              return $response = array(
//                  'status' => 0,
//                  'msg' => "Dear user you tried multiple times please try after 24 hour's"
//              );
//          }
//      }
//      $setting = $this->Communication->smssetting();
//      $otp = rand(100000, 999999);
//      $arr["mobile"] = $this->input->post('mobile');
//      if ($this->input->post('mobile') == '9999999999')
//      {
//          $arr["otp"] = '999999';
//      }
//      else{
//          $arr["otp"] = $otp;
//      }

//      $name = 'User';
//      $query = $this->bizhub->insert('app_otp_details', $arr);
//      $msg = "OTP for Login Transaction on ANTPAY is " . $otp . " and valid till 2 minutes. Do not share this OTP with anyone for security reasons.";
//      $message = rawurlencode($msg);

//      // Prepare data for POST request
//      $data = array('username' => $setting['username'], 'hash' => $setting['hash_api'], 'numbers' => $this->input->post('mobile'), "sender" => $setting['sender'], "message" => $message);
//      $ch = curl_init('https://api.textlocal.in/send/');
//      curl_setopt($ch, CURLOPT_POST, true);
//      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//      $response = curl_exec($ch);
//      curl_close($ch);
//      #echo $response; exit;
//      $res = json_decode($response, true);
//      if ($res['status'] == 'success') {
//          return $response = array(
//              'status' => 1,
//              'msg' => 'OTP sent successfully',
//              $_POST
//          );

//      } else {
//          return $response = array(
//              'status' => 0,
//              'msg' => 'Something went wrong!!'
//          );
//      }
//  }

 

}


?>
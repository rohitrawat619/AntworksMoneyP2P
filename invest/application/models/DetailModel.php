<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class DetailModel extends CI_Model
{

    public function __construct()
    { 
     
        parent::__construct();
    }

    public function check_login($email, $password) {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('invest_users1');
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
        $query=$this->db->get('invest_users1');
        return $query->result();
    }
    public function check_user($userd)
    {
        $this->db->select('*'); 
        $this->db->where($userd);		
		 $query = $this->db->get('invest_users1');
        $result = $query->row_array();
        return $result;
    }
        
    
    public function latestiddb1($tname)
    {
        if($tname=="invest_authorised_users"){$id='RID';}
        if($tname=="invest_invest_scheme_details"){$id='SID';}
        if($tname=="invest_users1"){$id='UID';}
        if($tname=="invest_vendors"){$id='VID';}
        // return $id;

        $this->db->select_max($id);
        $query = $this->db->get($tname);
        $result = $query->row_array();
        return $result;
     }

     public function latestiddb2($tname)
     {
        $this->db->select_max('IID');
         $query = $this->db->get($tname);
         $result = $query->row_array();
         return $result;
      }
 

    public function reguser($data)
    {   
        $this->db->insert('invest_users1',$data); 
        return $this->db->insert_id(); 
        
    }
    
    public function reguser_scheme($userd,$uid)
    {
        $this->db->where($uid);	
       $query = $this->db->update('invest_users1',$userd);
       return $query;
        
    }
    public function testdata($uid)
    {  
        $this->db->where($uid);	
        $query=$this->db->get('invest_users1',UID);
        return $query->result();
    }

    public function vID_check($akey)
    {  
        $this->db->select('VID'); 
        $this->db->where('key', $akey);
        $query=$this->db->get('invest_vendors');   
        $result = $query->row_array();
        return $result;
    }

    public function vend_check($userd)
    {
        $this->db->where($userd);		
		 $query = $this->db->get('invest_vendors');	
		return $query->result();
    }
    public function rep_check($userd)
    {
        $this->db->where($userd);		
		 $query = $this->db->get('invest_authorised_users');	
		return $query->result();
    }
    
// public function iideatils($idetails)
// {
//     $uid = $idetails['uid'];
// $iid = $idetails['iid'];
// $sid = $idetails['sid'] ;

// $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE SID = '$sid'");
// $result = $query->row_array();

// $schemetbl = "invest_".strtolower($result['Scheme_Name']); // replace with the actual value
// // var_dump($schemetbl);
// // exit;

// $this->db->select('invest_users1.account_no, invest_scheme_details.Scheme_Name, $schemetbl.Folio, $schemetbl.Investment_ID, $schemetbl.Investment_Amt');
// $this->db->from('invest_users1');
// $this->db->join('invest_scheme_details', 'invest_users1.Vendor_ID = invest_scheme_details.Vendor_ID');
// $this->db->join('$schemetbl', 'invest_scheme_details.SID = $schemetbl.SID');
// $this->db->where('invest_users1.UID', $uid);
// $this->db->where('$schemetbl.IID', $iid);
// $this->db->where('$schemetbl.SID', $sid); // replace 'column_name' with the actual column name
// $query = $this->db->get();
// $result = $query->result();
// return $result;
// }
public function iideatils($idetails)
{
    $uid = $idetails['UID'];
    $iid = $idetails['IID'];
    $sid = $idetails['SID'];
    $schemetbl = "invest_".strtolower($idetails['Scheme_Name']);
    
    $this->db->select("invest_users1.account_no, invest_scheme_details.Scheme_Name, $schemetbl.Folio, $schemetbl.Investment_ID, $schemetbl.Investment_Amt");
    $this->db->from('invest_users1');
    $this->db->join('invest_scheme_details', 'invest_users1.Vendor_ID = invest_scheme_details.Vendor_ID');
    $this->db->join($schemetbl, "invest_scheme_details.SID = $schemetbl.SID");
    $this->db->where('invest_users1.UID', $uid);
    $this->db->where("$schemetbl.IID", $iid);
    $this->db->where("$schemetbl.SID", $sid);
    $query = $this->db->get();
    $result = $query->row_array();
    return $result;
}

    public function regvendor($data)
    {   
        $this->db->insert('invest_vendors',$data);  
        return $this->db->insert_id();   
        
    }

    public function regrepresentative($data)
    {   
        $this->db->insert('invest_authorised_users',$data); 
        return $this->db->insert_id();    
    }

    public function scheme_check($schemed)
    {
        $this->db->where($schemed);		
		 $query = $this->db->get('invest_scheme_details');	
		return $query->result();
    }
    
    public function regscheme($data)
    {   
        $this->db->insert('invest_scheme_details',$data); 
        return $this->db->insert_id();  

    }

//    public function basic_pan_kyc($pan,$fullname) {

//         $URL = "https://svcdemo.digitap.work/validation/kyc/v1/pan_basic"; 
//         $Client_Id_PAN= "11199344"; 
//         $Client_Secret_PAN = "jFjXGxllHLzs1jlQIcM9leJZL4RRAhCk"; 
//         $name_match_method= "fuzzy";

//     $curl = curl_init();

// curl_setopt_array($curl, array(
//     CURLOPT_URL => $URL,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => json_encode(array(
//         'client_ref_num' => uniqid(),
//         'pan' => $pan,
//         'name' => $fullname,
//         'name_match_method' => $name_match_method,
//     )),
//     CURLOPT_HTTPHEADER => array(
//         'authorization: ' . base64_encode($Client_Id_PAN . ':' . $Client_Secret_PAN),
//         'Content-Type: application/json'
//     ),
// ));

// $response = curl_exec($curl);

// curl_close($curl);

//         return $response;

// }

// centerlised pan kyc

public function basic_pan_kyc($pan,$fullname,$mobile) {
    // testing json {
    //     "name": "Irshad Ahmed",
    //     "pan":"CTCPA6759F",
    //     "anchor":"Investment",
    //     "method":"fuzzy"
    // }
            $URL = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/pan_api"; 
            $name_match_method= "fuzzy";
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
            'pan' => $pan,
            'name' => $fullname,
            'mode' => $name_match_method,
            'anchor'=> $mobile,
            'mobile'=> $anchor,
        )),
        CURLOPT_HTTPHEADER => array(
             'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);

curl_close($curl);

        return $response;
}

public function fullkyc($upd)
{
    $query = $this->db->query("SELECT * FROM invest_users1 WHERE UID = ".$upd['UID']." AND fullkyc = 1");
     $result = $query->result_array();
     return $result;
}

public function basic_bank_kyc($details) {
//     testing json   {
//     "borrower_id": "",
//     "mobile":"7988811112",
//     "name":"Irshad Ahmed",
//     "account_no":"010499500057550",
//     "caccount_no":"010499500057550",
//     "ifsc_code":"YESB0000104",
//     "anchor":"Investment"
// }

$query = $this->db->query("SELECT response FROM invest_bank_respsone WHERE account_no = '".$details['account_no']."' AND ifsc_code = '".$details['ifsc_code']."' AND name = '".$details['fullname']."' "); 
$result = $query->result_array();
if($query->num_rows() > 0)
{
    return $result['0']['response'];
}

else{
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

$dc = json_decode($response, true);
 

if($dc['status'] == 1)
{
$sql = "INSERT INTO `invest_bank_respsone` (`name`, `account_no`, `ifsc_code`, `response`) VALUES ( '".$details['fullname']."' , '".$details['account_no']."' , '". $details['ifsc_code'] ."' , '".$response."')";
$query = $this->db->query($sql);
}
unset($dc);
        return $response;
}
}

public function is_phone_exists($phone) {
    $query = $this->db->get_where('invest_users1', array('phone' => $phone));
    return ($query->num_rows() > 0);
 }

 public function is_pan_exists($pan) {
    $query = $this->db->get_where('invest_users1', array('vpan' => $pan));
    return ($query->num_rows() > 0);
 }


public function regschemeusers($sname,$data)
{   
  $this->db->insert($sname,$data);
  return $this->db->insert_id();

}

    public function lenderdetails_show($schemed)
    {
        $fields = array('Interest_Rate','Lockin');
        $this->db->select($fields);
        $this->db->where($schemed);		
        $query = $this->db->get('invest_scheme_details',);	
        return $query->result();
    }

    public function lenderdetails1_show($sname,$User_ID)
    {
        $this->db->where($User_ID);		
        $query = $this->db->get($sname);	
        return $query->result();
    }
    
    function check_value($value,$sname) {
            $sql = '';
            foreach ($sname as $table) {
                $sql .= "SELECT IID,SID, Folio, Investment_Amt, Investment_date, Redeem_date, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE user_id = '" . $value. "' AND Status = 1  UNION ALL  ";
            }
            $sql = rtrim($sql, "UNION ALL  ");
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result;
            } else {
               return False; 
            }
}


function check_valueprocess($value,$sname) {
    $sql = '';
    foreach ($sname as $table) {
        $sql .= "SELECT IID,SID,Folio, Investment_Amt, Investment_date, Redeem_date, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE user_id = '" . $value. "' AND Status = 2  UNION ALL  ";
    }
    $sql = rtrim($sql, "UNION ALL  ");
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
        $result = $query->result_array();
        return $result;
    } else {
       return False; 
    }
}



function check_valueredeemed($value,$sname) {
      $sql = '';
    foreach ($sname as $table) {
        $sql .= "SELECT IID,SID, Investment_Amt,Folio, Investment_date, Redeem_date, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE user_id = '" . $value. "' AND Status = 3  UNION ALL  ";
    }
    $sql = rtrim($sql, "UNION ALL  ");
    $query = $this->db->query($sql);
    if ($query->num_rows() > 0) {
       $result = $query->result_array();
        return $result;
    } else {
       return False; 
    }
}

function check_redeemptions($sname) {
    $sql = '';
  foreach ($sname as $table) {
      $sql .= "SELECT IID,SID, Investment_Amt,Folio, Investment_ID ,Investment_date, Redeem_date, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE status = 2 UNION ALL  ";
  }
  $sql = rtrim($sql, "UNION ALL  ");
  $query = $this->db->query($sql);
  if ($query->num_rows() > 0) {
     $result = $query->result_array();
      return $result;
  } else {
     return False; 
  }
}




function check_valueven($value,$sname) {
    // $db2 = $this->load->database('schemesdb', TRUE);        
    // var_dump($sname);
    // exit;
    $sql = '';
    foreach ($sname as $table) {
        $sql .= "SELECT *, '" . $table['Scheme_Name'] . "' as tablename FROM " . $table['Scheme_Name']  . " WHERE Vendor_ID = '" . $value. "' UNION ALL  ";
    }
    $sql = rtrim($sql, "UNION ALL  ");
   $sql .= "ORDER BY status ASC"; 
    $query = $this->db->query($sql);
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
  $this->db->where('Investment_ID', $value['id'] );
   $query = $this->db->update($value['sname'], $upd);

    if ($query) { return $query;
    } else { return False;    }
}


function update_values($value,$upd) {
     $this->db->where($upd );
    if(isset($upd['SID']))
    {
        $tname ="invest_scheme_details";
    }
    if(isset($upd['RID']))
    {
        $tname ="invest_authorised_users";
    }
    if(isset($upd['VID']))
    {
        $tname ="invest_vendors";
    }
    if(isset($upd['UID']))
    {
        $tname ="invest_users1";
    }
    
   
    $query = $this->db->update($tname, $value);

    if ($query) {
          return $query;
    } else {
       return False; 
    }
}


public function del_values($value,$upd) {

    if($value['cd']==1)
    { 
        $this->load->dbforge();
        $query = $this->db->query("SELECT RID FROM invest_authorised_users WHERE Vendor_ID = ".$upd['VID']);
         $result = $query->result_array();
      foreach( $result as $row)
      {$this->db->where($row);
       $this->db->delete($value['tname']); }
    }

   if($value['cd']==3)
   { 
    $this->load->dbforge();
    $query = $this->db->query("SELECT Scheme_Name FROM invest_scheme_details WHERE SID = ".$upd['SID']);
     $result = $query->result_array();
    $this->db->query('DROP TABLE '.$result['0']['Scheme_Name']);  
   }
   if($value['cd']==2||$value['cd']==4)
   {
   $this->db->where($upd);
   $query = $this->db->delete($value['tname']);
   }

   if ( $this->db->affected_rows() > 0) {
   
    return $query;
   $this->response($iids,200);
} else {
    return False; 
   $this->response($star, 200);
}

  
 }




}
?>
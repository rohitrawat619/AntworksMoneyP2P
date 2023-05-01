
<?php

// 1	ID Primary	int(20)			No	None		AUTO_INCREMENT	Change Change	Drop Drop	
// 	2	Vendor_ID	int(20)			No	None			Change Change	Drop Drop	
// 	3	RepName	varchar(120)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
// 	4	RepDesignation	varchar(100)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
// 	5	Repphone	varchar(13)	utf8mb4_general_ci		No	None			Change Change	Drop Drop	
// 	6	Repemail	varchar(200)	utf8mb4_general_ci	

// {
//     "Vendor_Name": "Phone Pay",
//     "Address": "atrioonnnn",
//     "Phone": "12345778",
//     "RepName": "repname",
//     "RepDesignation": "Designation",
//     "Repphone": "12356677",
//     "Repemail": "Starrep@test.com",
//     "Vendor_ID": "3" 

//     }
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
            $vdetails =   array_splice($rqst, 0, 3);
            

           // Check if user already exist

        if(!($this->DetailModel->vend_check($vdetails)) && !($this->DetailModel->rep_check($rqst))){
            $d=time();
            $d= date("Y-m-d h:i:sa", $d);
            $vdetails += array("date_Reg_Date" => $d);
            $apiKey = $this->generateApiKey();
            $vdetails += array("key" => $apiKey);
            //Insert vendor details
            $iid =  $this->DetailModel->regvendor($vdetails);
            //check if details added or not 
            $result = $this->db->affected_rows();

        if ($result) {
            
            $rqst = array("Vendor_ID" => $iid);
            $Repid =  $this->DetailModel->regrepresentative($rqst);
            $star = "Vendor Added Successfully";
            $this->response($iid,$Repid, 200);
        } else {
            $star = "Sorry some error occured";
            $this->response($star, 200);
        }
           }
         
        else
        {
              $resp =  "Vendor Already Exist!";
              $this->response($resp, 200);
          
          }
 
        }
       
        if(($this->DetailModel->vend_check($vdetails)) && !($this->DetailModel->rep_check($rqst))){

            
            $Repid =  $this->DetailModel->regrepresentative($rqst);

            $resp = "Vendor Already Exist! Respresentaive added successfully";
            $this->response($resp,$Repid, 200);

        }

        if(($this->DetailModel->vend_check($vdetails)) && ($this->DetailModel->rep_check($rqst)))
        {
              $resp = "Vendor and Representatives Already Exist!";
              $this->response($resp, 200);
        }
        
 
        else
         {
            $this->response(404);
        }
  
    }
    ?>
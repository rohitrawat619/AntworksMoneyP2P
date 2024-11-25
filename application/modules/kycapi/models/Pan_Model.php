<?php

class Pan_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->p2pdb = $this->load->database('default', true);
	}
	public function pankyc($post){
			//$_POST = json_decode(file_get_contents('php://input'), true);
			
			
			$pan = $post['pan'];
			$name = $post['name'];
			$name_match_method = $post['name_match_method'];
			$mobile = $post['mobile'];
			$user_type = $post['user_type'];
			$user_id = $post['user_id'];
			$source = $post['source'];
			$name_match_method = $post['name_match_method'];
		  
			 

					   
		   $getPanDataDetails = $this->getPanData($pan,$name,$user_id);

		   $data = array(
			'status'=>1,
			'msg' => "Success",
			'dataType' => "db",
			'response' => json_decode($getPanDataDetails['data']['response'],true),
			'name_match' => $getPanDataDetails['data']['name_match'],
			'savedPanData' => $getPanDataDetails,
			  'pandDetailsCurl' =>  null,
			); 
			$responseDataD = $data;//json_decode($getPanDataDetails['data']['response']);
			// $getPanDataDetails['status']=0;
			
		if($getPanDataDetails['status']!=1){
			/************************** starting of curl logic ***************/
			$pandDetailsCurlData =  $this->pandDetailsCurl($pan, $name, $name_match_method);

			  if($pandDetailsCurlData['status']==1){
					$lender_id = "";
					$borrower_id = "";
					if($user_type=="lender"){
							$lender_id = $user_id;
					}else if($user_type=="borrower"){
							$borrower_id = $user_id;
					}
				  $this->savePanApiResponse(array(
					  'borrower_id' => $borrower_id,
					  'lender_id' => $lender_id,
					  'user_type'=> $user_type,
					  'source' => $source,
					  'name_match_method' => $name_match_method,
					  'mobile' => $mobile,
					  'pan' => $pan,
					  'request' => json_encode($post),


					  'status' => isset($pandDetailsCurlData['data']['result']) ? $pandDetailsCurlData['data']['result']['status'] : '',
					  'name' => 			   isset($pandDetailsCurlData['data']['result']) ? $pandDetailsCurlData['data']['result']['name'] : '',
					  'name_match' =>   isset($pandDetailsCurlData['data']['result']) ? $pandDetailsCurlData['data']['result']['name_match'] : '',
					  'result_code' =>   isset($pandDetailsCurlData['data']['result']) ? $pandDetailsCurlData['data']['result_code'] : '',
					  'response' => json_encode($pandDetailsCurlData['data']),
				  ));
				  $data = array(
				  'status'=>1,
				  'msg' => "Success",
				  'dataType' => "live",
				  'response'=> ($pandDetailsCurlData['data']),
				  'name_match' =>     isset($pandDetailsCurlData['data']['result']) ? (int)$pandDetailsCurlData['data']['result']['name_match'] : '0',
				  'savedPandData' => $getPanDataDetails,
				  'pandDetailsCurl' =>  $pandDetailsCurlData,
				  ); 
				  $responseDataD = $data; //$pandDetailsCurlData['data'];
			    }else{
				 $data = array(
					'status'=>0,
						 'msg' => "Error while curl execution",
						 'savedPandData' => $getPanDataDetails,
						 'pandDetailsCurl' =>  $pandDetailsCurlData,
				  );
			    } /************************** ending of curl logic  **********************/
            }
				file_put_contents('logs/'.$source.'_'.date('Y-m-d').'.txt', date('Y-m-d H:i:s').' - '.json_encode($responseDataD)."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
          return $data;
        
    }  




   public function pandDetailsCurl($pan, $name, $name_match_method){
      //  $data = "";
        $err = "";
        $response = "";
      
        if($pan!="" && $name!=""){

                /********starting of curl function**********/
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL =>  'https://svc.digitap.ai/validation/kyc/v1/pan_basic', // PAN_API_URL,
				//	CURLOPT_URL =>  'https://api.digitap.ai/validation/', 
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
                        'name' => $name,
                        'name_match_method' => $name_match_method ?? 'exact',
                    )),
                    CURLOPT_HTTPHEADER => array(
                        'authorization: ' .base64_encode('67508421:KNpUxleIN4dm6ZnEcyBvsHjdgoXZEkIx'), // base64_encode(Client_Id_PAN . ':' . Client_Secret_PAN),
                        'Content-Type: application/json'
                    ),
                ));
        
                
               
    
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                    $arr_response = json_decode($response, true);
                    if ($err) {
                       // echo "cURL Error #:" . $err;
                        $data['status'] = 0;
                       $data['msg'] = htmlspecialchars_decode("cURL Error #:" . $err);
                       $data['data'] = null;
                    }else{

                         
                        $data['status'] = "1";
                        $data['msg'] = "Success";
                        $data['data'] = $arr_response;
                      
                        
                    } 
                        /**************ending of curl function********************/


            
        }else{
            $data['status'] = "0";
            $data['msg'] = "Input parameters are missing";
            $data['data'] = null;
        }
    return $data;

   }
///////////////////////Model Function//////////////////////////
	
		public function savePanApiResponse($arr_pan_api_response_all){
			$this->db->insert('borrower_pan_api_details', $arr_pan_api_response_all);
		}
 

	public function getPanData($pan,$name,$borrower_id){
		
		$query = $this->db->get_where('borrower_pan_api_details', array('pan' => $pan, 'name' => $name, 'name_match'=>1));
		
		$querySql = $this->db->last_query();
		if ($this->db->affected_rows()  > 0) {
			$result = $query->row_array();
			$this->db->get_where('p2p_borrower_steps_credit_line', array('borrower_id' => $borrower_id));
			if ($this->db->affected_rows()  > 0) {
				$this->db->where('borrower_id', $borrower_id);
				$this->db->set('step_1', 1);
				$this->db->update('p2p_borrower_steps_credit_line');
			}else{
				$this->db->insert('p2p_borrower_steps_credit_line', array('borrower_id' => $borrower_id, 'step_1' => 1));
			}
			$data['status'] = "1";
			$data['msg'] = "Success";
			$data['data'] = $result;
			//$data['query'] = $querySql;
			
			
		}else{
			$this->db->get_where('p2p_borrower_steps_credit_line', array('borrower_id' => $borrower_id));
			if ($this->db->affected_rows()  > 0) {
				$this->db->where('borrower_id', $borrower_id);
				$this->db->set('step_1', 2);
				$this->db->update('p2p_borrower_steps_credit_line');
			}else{
				$this->db->insert('p2p_borrower_steps_credit_line', array('borrower_id' => $borrower_id, 'step_1' => 2));
			}
			$data['status'] = "0";
			$data['msg'] = "Failed";
			$data['data'] = null;
			
		}
			return $data;
	}

	

}

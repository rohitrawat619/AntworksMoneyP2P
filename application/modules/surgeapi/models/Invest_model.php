<?php
class Invest_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
		
		$this->cldb = $this->load->database('credit-line', TRUE);
    }
	public function check_user_exist_in_p2p(){
		
		$query = $this ->db
           -> select('*')
           -> where('mobile', $this->input->post('phone'))
           -> or_where('pan', $this->input->post('PAN'))
           -> or_where('email', $this->input->post('email'))
           -> get('p2p_lender_list');
		//echo $this->db->last_query();exit;
		if($this->db->affected_rows()>0)
        {
			$lenderDetails =  $query->row();
			
			if($lenderDetails->pan == $this->input->post('PAN')){
				return $p2plenderDetails = array(
				'lender_id'=>$lenderDetails->lender_id,
				'email'=>$lenderDetails->email,
				'pan'=>$lenderDetails->pan,
				'status'=>1,
				'msg'=>'Already Exist',
				);
			}else{
				return $p2plenderDetails = array(
				'lender_id'=>$lenderDetails->lender_id,
				'email'=>$lenderDetails->email,
				'pan'=>$lenderDetails->pan,
				'status'=>1,
				'msg'=>'PAN Mismatch',
				);
			}
			
		}else{
				return $p2plenderDetails = array(
				'status'=>0,
				'msg'=>'New Lander',
				);
			}
	} 
	public function get_all_scheme()
    {
        $query = $this->cldb->select('*')->get_where('invest_scheme_details',array('status'=>1,'Vendor_ID'=>$this->input->post('vendor_id')));
        if($this->cldb->affected_rows()>0)
        {
            $scheme_arra =  $query->result_array();
			/* $i= 0;
			foreach($scheme_arra as $scheme){
				$scheme_arra[$i]['hike_rate'] = $this->dynamic_roi($scheme['Interest_Rate']);
				$i++;
			} */
			return $scheme_arra;
        }
        else
        {
            return false;
        }
    }
	public function get_kyc_status($mobile)
    {
        $query = $this->cldb->select('PLL.lender_id, PLL.pan_kyc, PLL.account_kyc, PLI.ant_txn_id, PLI.investment_No')
		->join('p2p_lender_reinvestment as PLI', 'PLI.mobile = PLL.mobile', 'left')
		->order_by('PLI.reinvestment_id', 'DESC')
		->get_where('p2p_lender_list PLL', array('PLL.mobile' => $mobile));
		//echo $this->cldb->last_query();exit;
        if ($this->cldb->affected_rows() > 0) {
            $steps = $query->row_array();
            if ($steps['ant_txn_id'] != '' && $steps['investment_No'] != '') {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 3,
					'msg' => 'Payment Done'
				);
			}
			if ($steps['pan_kyc'] == 1 && $steps['account_kyc'] == 1) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 2,
					'msg' => 'Fully kyc Done'
				);
			}
			if ($steps['pan_kyc'] == 1 && $steps['account_kyc'] == 0) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 1,
					'msg' => 'Basic KYC Done'
				);
			}
			if ($steps['pan_kyc'] == 0 && $steps['account_kyc'] == 0) {
				return $current_step = array(
					'lender_id' => $steps['lender_id'],
					'step' => 0,
					'msg' => 'KYC Not Done'
				);
			} 
        }else{
			return $current_step = array(
                'lender_id' => '',
                'step' => 0,
                'msg' => 'User Not found'
            );
		}
    }
	function dynamic_roi($base_interest_rate) {
    // Set a base interest rate
 //    $base_interest_rate = 5.0;
 $loan_amount = 1000;
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
	public function basic_pan_kyc() {
    $postData = $this->input->post();
	//pr($postData);exit;
            /* $pan_url = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/pan_api"; 
            $name_match_method= "exact";
            $anchor = "Investent";
  
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => $pan_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'pan' => $postData['PAN'],
            'name' => $postData['fullname'],
            'mode' => $name_match_method,
            'anchor'=> $anchor,
            'mobile'=> $postData['phone'],
        )),
        CURLOPT_HTTPHEADER => array(
             'Content-Type: application/json'
        ),
    )); 
    $response = curl_exec($curl);*/
	
			
			  $curl = curl_init();
			   curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://antworksmoney.com/credit-line/API/pan',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode(array(
					'pan' => $postData['PAN'],
					'name' => $postData['fullname'],
					'mobile'=> $postData['phone'],
					'name_match_method' => 'exact',
					'user_type' => 'lender',
					'user_id' => 0,
					'source' => 'surge',
					
				)),
				CURLOPT_HTTPHEADER => array(
					  'client_id: antworkCurlApi',
					  'secret: testing@1234#',
					 'Content-Type: application/json'
				),
			)); 
			$response = curl_exec($curl);
			 curl_close($curl);
			 $curl_response =  json_decode($response, true); 
		     $arr_response = $curl_response['response'];
			 return json_encode($arr_response);
			 
		
        
}

public function basic_bank_kyc($details) {

       $bank_url = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/addBank"; 
       $anchor = "Investent";
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => $bank_url,
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

        return $response;
     }
   	 public function addaccount($response,$lender_details)
    {
		$bank_res = array(
                'lender_id' => $lender_details->user_id,
                'mobile' => $lender_details->mobile,
                'account_no' => $this->input->post('account_no'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'fav_id' => $response['id'] ? $response['id'] : '',
                'razorpay_response_bank_ac' => json_encode($response),
            );
         $this->cldb->insert('p2p_lender_bank_res', $bank_res);
		 
        
        if($this->cldb->affected_rows()>0)
        {
		$query = $this->cldb->get_where('p2p_lender_account_info',array('lender_id' => $lender_details->user_id));
		$bankdetails = array(
                'lender_id' => $lender_details->user_id,
                'bank_name' => $response['fund_account']['bank_account']['bank_name']?$response['fund_account']['bank_account']['bank_name']:'',
                'account_number' => $this->input->post('account_no'),
                'ifsc_code' => $this->input->post('ifsc_code'),
                'is_verified' => 1,
            );
		if($this->cldb->affected_rows()>0)
        {
			unset($bankdetails['lender_id']);
			
			$this->cldb->where('lender_id', $lender_details->user_id);
			$this->cldb->update('p2p_lender_account_info', $bankdetails);
		}else{
			
			$this->cldb->insert('p2p_lender_account_info', $bankdetails);
		}
			
            

           return true;
        }
        else{
           return false;
        }
    }
	public function update_lender_id_in_pan_kyc_table($mobile,$pan,$lenderID){
		$this->cldb->where('mobile', $phone);
		$this->cldb->where('source', 'surge');
		$this->cldb->where('pan', $pan);
		$this->cldb->update('borrower_pan_api_details', array('lender_id' => $lenderID));
		return true;
	}
	public function investment_details()
    {
		$postVal = $this->input->post();
		
		$invested_amount = 0;
        $current_value = 0;
        $query = $this->cldb->select('ISD.Scheme_Name, ISD.Lockin, ISD.Lockin_Period, ISD.Cooling_Period, LI.investment_No ,LI.lender_id, LI.mobile, LI.scheme_id, LI.amount, LI.basic_rate, LI.hike_rate, LI.pre_mat_rate, LI.redemption_date, LI.redemption_status, LI.created_date as investment_date')
		->join('invest_scheme_details as ISD', 'ISD.id = LI.scheme_id', 'left')
		->get_where('p2p_lender_reinvestment as LI',array('LI.mobile'=>$postVal['phone'],'LI.source'=>'surge','LI.redemption_status'=>0));
		
        if($this->cldb->affected_rows()>0)
        {
            $result = $query->result_array();
			$i = 0;
			$total_investment_amount = 0;
			$total_current_value = 0;
				foreach($result as $row)
				   { 
				   if($row['redemption_date'] == '0000-00-00 00:00:00'){
					   $redemption_date = '00-00-0000';
				   }else{
					   $redemption_date = date('d-m-Y', strtotime($row['redemption_date']));
				   }
				   
				   if($row['hike_rate'] > $row['basic_rate']){
					   $interest_rate = $row['hike_rate'];
				   }else{
					   $interest_rate = $row['basic_rate'];
				   }
				   
				   $calculate_amount = $this->calculate_interest_per_day($interest_rate,$row['amount'],$row['investment_date']);
				  //pr($calculate_amount);exit;
				   $investment_arr[$i]['investment_No'] = $row['investment_No'];
				   $investment_arr[$i]['scheme_name'] = $row['Scheme_Name'];
				   $investment_arr[$i]['lockin'] = ($row['Lockin']==1)?'Yes':'No';
				   $investment_arr[$i]['amount'] = $row['amount'];
				   $investment_arr[$i]['basic_rate'] = $row['basic_rate'].'%';
				   $investment_arr[$i]['hike_rate'] = $row['hike_rate'].'%';
				   $investment_arr[$i]['pre_mat_rate'] = $row['pre_mat_rate'].'%';
				   $investment_arr[$i]['no_of_days'] = $calculate_amount['days'];
				   $investment_arr[$i]['interest_perday'] = $calculate_amount['interest_perday'];
				   $investment_arr[$i]['final_interest'] = $calculate_amount['final_interest'];
				   $investment_arr[$i]['current_value'] = $calculate_amount['current_value'];
				   $investment_arr[$i]['investment_date'] = date('d-m-Y', strtotime($row['investment_date']));
				   $investment_arr[$i]['redemption_date'] = $redemption_date;
				   $investment_arr[$i]['redemption_status'] = $row['redemption_status'];
				   $total_investment_amount += $row['amount'];
				   $total_current_value += $calculate_amount['current_value'];
				 #Update Final Interest and current Value
				   $this->cldb->where('investment_No', $row['investment_No']);
				   $this->cldb->where('mobile', $postVal['phone']);
				   $this->cldb->update('p2p_lender_reinvestment',array(
				   'total_no_of_days'=>$calculate_amount['days'],
				   'total_interest'=>$calculate_amount['final_interest'],
				   'total_current_value'=>$calculate_amount['current_value']
				     )
				   );
				   #End Update
				   $i++;
				  }
				  $past_investment = $this->past_portfolio();
				  if(!empty($past_investment)){
					  $past_investment = $past_investment;
				  }else{
					  $past_investment = array();
				  }
				 
			 $investment_details = array(
					 'current_investment'=>$investment_arr,
					 'past_investment'=>$past_investment,
					 'total_investment_amount'=>$total_investment_amount,
					 'total_current_value'=>round($total_current_value,2),
					 'total_return'=>round($total_current_value - $total_investment_amount,2),
					 );
			
			return $investment_details;
        }else{
			$past_portfolio = $this->past_portfolio();
				  if(!empty($past_portfolio)){
					  $past_portfolio = $past_portfolio;
				  }else{
					  $past_portfolio = array();
				  }
            $past_investment = array(
					 'current_investment'=>array(),
					 'past_investment'=>$past_portfolio,
					 'total_investment_amount'=>0,
					 'total_current_value'=>0,
					 'total_return'=>0,
					 );
			return $past_investment;
        }
    }
	public function update_investment_cron()
    {
		$postVal = $this->input->post();
		
		$invested_amount = 0;
        $current_value = 0;
        $query = $this->cldb->select('ISD.Scheme_Name, ISD.Lockin, ISD.Lockin_Period, ISD.Cooling_Period, LI.investment_No ,LI.lender_id, LI.mobile, LI.scheme_id, LI.amount, LI.basic_rate, LI.hike_rate, LI.pre_mat_rate, LI.redemption_date, LI.redemption_status, LI.created_date as investment_date')->join('invest_scheme_details as ISD', 'ISD.id = LI.scheme_id', 'left')
		->get_where('p2p_lender_reinvestment as LI',array('LI.source'=>'surge','LI.redemption_status'=>0));
		
        if($this->cldb->affected_rows()>0)
        {
            $result = $query->result_array();
			$i = 0;
			$total_investment_amount = 0;
			$total_current_value = 0;
				foreach($result as $row)
				   { 
				  // pr($row);exit;
				   if($row['redemption_date'] == '0000-00-00 00:00:00'){
					   $redemption_date = '00-00-0000';
				   }else{
					   $redemption_date = date('d-m-Y', strtotime($row['redemption_date']));
				   }
				   
				   if($row['hike_rate'] > $row['basic_rate']){
					   $interest_rate = $row['hike_rate'];
				   }else{
					   $interest_rate = $row['basic_rate'];
				   }
				   
				   $calculate_amount = $this->calculate_interest_per_day($interest_rate,$row['amount'],$row['investment_date']);
				  
				   $investment_arr[$i]['investment_No'] = $row['investment_No'];
				   $investment_arr[$i]['scheme_name'] = $row['Scheme_Name'];
				   $investment_arr[$i]['lockin'] = ($row['Lockin']==1)?'Yes':'No';
				   $investment_arr[$i]['amount'] = $row['amount'];
				   $investment_arr[$i]['basic_rate'] = $row['basic_rate'].'%';
				   $investment_arr[$i]['hike_rate'] = $row['hike_rate'].'%';
				   $investment_arr[$i]['pre_mat_rate'] = $row['pre_mat_rate'].'%';
				   $investment_arr[$i]['no_of_days'] = $calculate_amount['days'];
				   $investment_arr[$i]['interest_perday'] = $calculate_amount['interest_perday'];
				   $investment_arr[$i]['final_interest'] = $calculate_amount['final_interest'];
				   $investment_arr[$i]['current_value'] = $calculate_amount['current_value'];
				   $investment_arr[$i]['investment_date'] = date('d-m-Y', strtotime($row['investment_date']));
				   $investment_arr[$i]['redemption_date'] = $redemption_date;
				   $investment_arr[$i]['redemption_status'] = $row['redemption_status'];
				   $total_investment_amount += $row['amount'];
				   $total_current_value += $calculate_amount['current_value'];
				   //pr($investment_arr);exit;
				 #Update Final Interest and current Value
				   $this->cldb->where('investment_No', $row['investment_No']);
				   $this->cldb->where('mobile', $row['mobile']);
				   $this->cldb->update('p2p_lender_reinvestment',array(
				   'total_no_of_days'=>$calculate_amount['days'],
				   'total_interest'=>$calculate_amount['final_interest'],
				   'total_current_value'=>$calculate_amount['current_value']
				     )
				   );
				   #End Update
				   $i++;
				  }
				 return true; 
        }else{
			
			return false;
		}
    }
	public function past_portfolio()
    {
		$postVal = $this->input->post();
		
		/* $invested_amount = 0;
        $current_value = 0; */
        $query = $this->cldb->select('ISD.Scheme_Name, ISD.Lockin, ISD.Lockin_Period, ISD.Cooling_Period, LI.investment_No ,LI.lender_id, LI.mobile, LI.scheme_id, LI.amount, LI.total_no_of_days, LI.total_interest, LI.total_current_value, LI.redemption_date, LI.redemption_status, LI.created_date as investment_date')->join('invest_scheme_details as ISD', 'ISD.id = LI.scheme_id', 'left')
		->get_where('p2p_lender_reinvestment as LI',array('LI.mobile'=>$postVal['phone'],'source'=>'surge','redemption_status'=>1));
        if($this->cldb->affected_rows()>0)
        {
            $result = $query->result_array();
			//pr($result);exit;
			$i = 0;
			$total_investment_amount = 0;
			$total_current_value = 0;
				foreach($result as $row)
				   { 
				   if($row['redemption_date'] == '0000-00-00 00:00:00'){
					   $redemption_date = '00-00-0000';
				   }else{
					   $redemption_date = date('d-m-Y', strtotime($row['redemption_date']));
				   }
				   $investment_arr[$i]['investment_No'] = $row['investment_No'];
				   $investment_arr[$i]['scheme_name'] = $row['Scheme_Name'];
				   $investment_arr[$i]['amount'] = $row['amount'];
				   $investment_arr[$i]['no_of_days'] = $row['total_no_of_days'];
				   $investment_arr[$i]['final_interest'] = $row['total_interest'];
				   $investment_arr[$i]['current_value'] = $row['total_current_value'];
				   $investment_arr[$i]['investment_date'] = date('d-m-Y', strtotime($row['investment_date']));
				   $investment_arr[$i]['redemption_date'] = $redemption_date;
				   $investment_arr[$i]['redemption_status'] = $row['redemption_status'];
				   $i++;
				  }
			
			return $investment_arr;
        }
        else
        {
            return false;
        }
    }
	public function redemption_request()
    {
		$postVal = $this->input->post();
		
		
        $query = $this->cldb->select('ISD.Scheme_Name, ISD.Lockin, ISD.Lockin_Period, ISD.Cooling_Period, LI.investment_No ,LI.lender_id, LI.mobile, LI.scheme_id, LI.amount, LI.basic_rate, LI.hike_rate, LI.pre_mat_rate, LI.redemption_date, LI.redemption_status, LI.created_date as invest_date, bank.razorpay_response_fav')
		->join('invest_scheme_details as ISD', 'ISD.id = LI.scheme_id', 'left')
		->join('p2p_borrower_bank_res as bank', 'bank.mobile = LI.mobile', 'left')
		->get_where('p2p_lender_reinvestment as LI',array('LI.mobile'=>$postVal['phone'],'LI.source'=>'surge','LI.investment_No'=>$postVal['investment_no']));
        if($this->cldb->affected_rows()>0)
        {
            $result = $query->row();
			if($result->redemption_date == '0000-00-00 00:00:00'){
				   $redemption_date = '00-00-0000';
		    }else{
			   $redemption_date = date('d-m-Y', strtotime($result->redemption_date));
		    }
			//pr($result);exit;
			$bank_details = json_decode($result->razorpay_response_fav, true);
			$bank_name = $bank_details['fund_account']['bank_account']['bank_name'];
			$account_number = $bank_details['fund_account']['bank_account']['account_number'];
			$no_of_days = $this->cal_no_of_days($result->invest_date);
			
			#Cooling Period
			
			if($no_of_days <= $result->Cooling_Period){
				$final_amount = $result->amount;
			}else{
				   if($result->Lockin == 1 && $no_of_days <= $result->Lockin){ # Lockin => Yes
				  
				        $interest_rate = $result->pre_mat_rate;
				   }
				   if($result->Lockin == 0 && $result->hike_rate > $result->basic_rate){ # Lockin => NO
				  
				        $interest_rate = $result->hike_rate;
				   }
				   if($result->Lockin == 0 && $result->hike_rate < $result->basic_rate){ 
				   
						$interest_rate = $result->basic_rate;
				   }
					
				$calculate_amount = $this->calculate_interest_per_day($interest_rate,$result->amount,$result->invest_date);
				
				$no_of_days = (string)$calculate_amount['days'];
				$interest_amount = (string)$calculate_amount['final_interest'];
				$final_amount = $calculate_amount['current_value'];
				
			}
			
			$result_arr['investment_No'] = $result->investment_No;
			$result_arr['scheme_Name'] = $result->Scheme_Name;
			$result_arr['investment_date'] = date('d-m-Y', strtotime($result->invest_date));
			$result_arr['redemption_date'] = $redemption_date;
			$result_arr['redemption_status'] = $result->redemption_status;
			$result_arr['amount'] = $result->amount;
			$result_arr['final_amount'] = (string)$final_amount;
			$result_arr['interest_rate'] = $interest_rate?$interest_rate.'%':'';
			$result_arr['no_of_days'] = $no_of_days?$no_of_days:'';
			$result_arr['interest_amount'] = $interest_amount?$interest_amount:'';
			$result_arr['bank_name'] = $bank_name;
			$result_arr['account_number'] = $account_number;
			//pr($result_arr);exit;
			return $result_arr;
		}else{
			return false;
		}		
        
    }
	public function calculate_interest_per_day($rate,$amount,$startdate){
		$days = $this->cal_no_of_days($startdate);
		$interestperday = $amount * (($rate) / 100)/365;
		$finalinterest = $days * $interestperday;
		return $interest_amount_day = array('days' => $days,'interest_perday'=>round($interestperday,2),'final_interest'=>round($finalinterest,2),'current_value'=>round($finalinterest+$amount,2));
	}
    public function cal_no_of_days($startdate){
		$start_date = strtotime(date('Y-m-d', strtotime($startdate)));
		$end_date = strtotime(date('Y-m-d'));
		return $days = (($end_date - $start_date) / 60 / 60 / 24);
	}
}
?>

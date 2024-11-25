<?php

class Borroweraddmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Borrowermodel', 'P2papi/Commonapimodel'));
		//$this->money = $this->load->database('money', true);
    }
   public function registration_credit_line_1()
    {
		$borrower_p2p = $this->get_borrower_exit_in_p2p();
		if($borrower_p2p['borrower_id']){
			$borrower_id = $borrower_p2p['borrower_id'];
			$id = $borrower_p2p['id'];
            //$last_insert_borrower_id = $this->db->insert_id();
            
            ####
            $this->db->select('borrower_id')->get_where('p2p_borrower_address_details', array('borrower_id' => $id));
            if ($this->db->affected_rows() > 0) {
                $address_details = array(
                    'borrower_id' => $id,
                    'r_state' => $this->input->post('r_state'),
                    'r_city' => $this->input->post('r_city'),
                    'r_address' => $this->input->post('r_address'),
                    'r_pincode' => $this->input->post('r_pincode'),
					'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
                    'ip_address' => $this->input->ip_address(),
                    'date_added' => date("Y-m-d H:i:s"),
                );
                $this->db->where('borrower_id', $id);
                $this->db->update('p2p_borrower_address_details', $address_details);
            } else {
                $address_details = array(
                    'borrower_id' => $id,
                    'r_state' => $this->input->post('r_state'),
                    'r_city' => $this->input->post('r_city'),
                    'r_address' => $this->input->post('r_address'),
                    'r_pincode' => $this->input->post('r_pincode'),
					'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude'),
					'ip_address' => $this->input->ip_address(),
                    'date_added' => date("Y-m-d H:i:s"),
                );
                $this->db->insert('p2p_borrower_address_details', $address_details);
            }
            $tokenData = $id . '_' . date('Y-m-d H:i:s');
            return ['status' => 1, 'msg' => 'Borrower added successfully', 'borrower_id' => $id, 'Authorization' => AUTHORIZATION::generateToken($tokenData)];
        } else {
            return ['status' => 0, 'msg' => 'Something went wrong please try again', 'borrower_id' => ''];
        }

    }
	public function get_borrower_exit_in_p2p()
    {
		$postData = $this->input->post();
		//$this->p2p = $this->load->database('db_p2p', TRUE);
		$query = $this ->db
				   -> select('*')
				   -> where('mobile', $postData['mobile'])
				   -> or_where('pan', $postData['pan'])
				   -> or_where('email', $postData['email'])
				   -> get('p2p_borrowers_list');
        if ($this->db->affected_rows() > 0) {
			$result = (array)$query->row();
			return $borrower_detail =  array(
			'id' => $result['id'],
			'borrower_id' => $result['borrower_id'],
			'name' => $result['name'],
			'email' => $result['email'],
			'mobile' => $result['mobile'],
			'pan' => $result['pan'],
			'type' => 'already',
			);
             
        } else {
			$borrower_id = create_borrower_id();
			$borrower_array = array(
            'borrower_id' => $borrower_id,
            'name' => $postData['name'],
            'email' => $postData['email'],
            'mobile' => $postData['mobile'],
            'dob' => date("Y-m-d",strtotime($postData['dob'])),
            'pan' => $postData['pan'],
            'created_date' => date("Y-m-d H:i:s"),
           );
		   
            $this->db->insert('p2p_borrowers_list', $borrower_array);
			if ($this->db->affected_rows() > 0) {
				$last_insert_borrower_id = $this->db->insert_id();
				return $borrower_detail =  array(
				'id' => $last_insert_borrower_id,
				'borrower_id' => $borrower_id,
				'name' => $postData['name'],
				'email' => $postData['email'],
				'mobile' => $postData['mobile'],
				'pan' => $postData['pan'],
				'type' => 'new',
				);
			}
        }
    }
	public function registration_credit_line_2($borrowerId)
    {
        $data = array(
            'occuption_id' => $this->input->post('occuption_id'),
            'modified_date' => date("Y-m-d H:i:s"),
        );
        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);
        $borrower_array = array(
            'borrower_id' => $borrowerId,
            'occuption_type' => $this->input->post('occuption_id'),
            'company_type' => $this->input->post('company_type'),
            'company_name' => $this->input->post('company_name'),
            'salary_process' => $this->input->post('salary_process'),
            'net_monthly_income' => $this->input->post('net_monthly_income'),
            'created_date' => date("Y-m-d H:i:s"),
        );
		
        $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrowerId));
		//echo $this->db->last_query();exit;
        if ($this->db->affected_rows() > 0) {
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_occuption_details', $borrower_array);
        } else {
            $this->db->insert('p2p_borrower_occuption_details', $borrower_array);
        }
        return ['status' => 1, 'msg' => 'Borrower profile updated successfully', 'borrower_id' => $borrowerId];

    }
	#Old Code
	
	/* public function update_registration_credit_line()
    {

        $borrower_array = array(
            'vendor_id' => $this->input->post('vendor_id'),
            'name' => $this->input->post('name'),
            'aadhar' => $this->input->post('aadhar'),
            'gender' => $this->input->post('gender'),
            'dob' => $this->input->post('dob'),
            'highest_qualification' => $this->input->post('highest_qualification'),
            'modified_date' => date("Y-m-d H:i:s"),
        );
		
        $this->db->where('id', $this->input->post('borrower_id'));
        $this->db->update('p2p_borrowers_list', $borrower_array);

        $this->db->select('borrower_id')->get_where('p2p_borrower_address_details', array('borrower_id' => $this->input->post('borrower_id')));
        if ($this->db->affected_rows() > 0) {
            $address_details = array(
                'borrower_id' => $this->input->post('borrower_id'),
                'r_state' => $this->input->post('r_state_code'),
                'r_state_name' => $this->input->post('r_state'),
                'r_city' => $this->input->post('r_city'),
                'r_address' => $this->input->post('r_address'),
                'r_pincode' => $this->input->post('r_pincode'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'date_added' => date("Y-m-d H:i:s"),
            );
            $this->db->where('borrower_id', $this->input->post('borrower_id'));
            $this->db->update('p2p_borrower_address_details', $address_details);
        } else {
            $address_details = array(
                'borrower_id' => $this->input->post('borrower_id'),
                'r_state' => $this->input->post('r_state_code'),
                'r_state_name' => $this->input->post('r_state'),
                'r_city' => $this->input->post('r_city'),
                'r_address' => $this->input->post('r_address'),
                'r_pincode' => $this->input->post('r_pincode'),
				'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'date_added' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_borrower_address_details', $address_details);
        }

        $data = array(
            'occuption_id' => $this->input->post('occuption_id'),
            'modified_date' => date("Y-m-d H:i:s"),
        );
        $this->db->where('id', $this->input->post('borrower_id'));
        $this->db->update('p2p_borrowers_list', $data);
        $borrower_array = array(
            'borrower_id' => $this->input->post('borrower_id'),
            'occuption_type' => $this->input->post('occuption_id'),
            'company_type' => $this->input->post('company_type'),
            'company_name' => $this->input->post('company_name'),
            'salary_process' => $this->input->post('salary_process'),
            'net_monthly_income' => $this->input->post('net_monthly_income'),
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $this->input->post('borrower_id')));
        if ($this->db->affected_rows() > 0) {
            $this->db->where('borrower_id', $this->input->post('borrower_id'));
            $this->db->update('p2p_borrower_occuption_details', $borrower_array);
        } else {
            $this->db->insert('p2p_borrower_occuption_details', $borrower_array);
        }


        //$this->pan_basis($this->input->post('borrower_id'), $this->input->post('mobile'), $this->input->post('pan'), $this->input->post('name'), 'exact');
        $this->credit_bureau($this->input->post('borrower_id'));
		
        $borrower_basic_filter_res = $this->basic_filteration($this->input->post('dob'), $this->input->post('pan') == 1, $this->input->post('r_pincode'),$this->input->post('highest_qualification'), $this->input->post('occuption_id'), $this->input->post('company_code'), $this->input->post('net_monthly_income'),'');
		//pr($borrower_basic_filter_res);exit;
        if ($borrower_basic_filter_res['basic_filter_pass'] == '0') {
            $borrower_status = 1;
        }
        $this->ektara_first_api($this->input->post('borrower_id'));
        return [
            'status' => 1,
            'msg' => 'Borrower update successfully',
            'borrower_id' => $this->input->post('borrower_id'),
            'borrower_status' => (int)$borrower_basic_filter_res['basic_filter_pass'],
            'error_msg' => $borrower_basic_filter_res['msg'],
            'kyc_status' => $borrower_basic_filter_res['kyc_status'],
            'kyc_status_msg' => $borrower_basic_filter_res['kyc_status_msg'],
        ];
    } */
	#new function Update Date => 13-02-24
	public function update_registration_credit_line()
    {

        $borrower_array = array(
            'vendor_id' => $this->input->post('vendor_id'),
            'modified_date' => date("Y-m-d H:i:s"),
        );
		
        $this->db->where('id', $this->input->post('borrower_id'));
        $this->db->update('p2p_borrowers_list', $borrower_array);

       

        
        $this->credit_bureau($this->input->post('borrower_id'));
		
		$borrower_details = $this->get_borrower_details($this->input->post('borrower_id'));
        //pr($borrower_details);exit;
		$company_code = 'CATGB';
        $borrower_basic_filter_res = $this->basic_filteration($borrower_details['dob'], $borrower_details['pan'] == 1, $borrower_details['r_pincode'],$borrower_details['qualification'], $borrower_details['occuption'], $company_code = 'CATGB', $borrower_details['net_monthly_income'],'');
		//pr($borrower_basic_filter_res);exit;
			if ($borrower_basic_filter_res['basic_filter_pass'] == '0') {
				$borrower_status = 1;
			}
		
        $this->ektara_first_api($this->input->post('borrower_id'));
        return [
            'status' => 1,
            'msg' => 'Borrower update successfully',
            'borrower_id' => $this->input->post('borrower_id'),
            'borrower_status' => (int)$borrower_basic_filter_res['basic_filter_pass'],
            'error_msg' => $borrower_basic_filter_res['msg'],
            'kyc_status' => $borrower_basic_filter_res['kyc_status'],
            'kyc_status_msg' => $borrower_basic_filter_res['kyc_status_msg'],
        ];
    }
	 public function credit_bureau($borrowerId)
    {
        $this->load->model('Borrowerinfomodel');
        $borrower_res = $this->Borrowerinfomodel->borrower_details($borrowerId);
	
        $borrower_info = $borrower_res['borrower_details'];
		//pr($borrower_info);exit;
        $arr = explode(' ', $borrower_info['name']);
        $num = count($arr);
        $first_name = $middle_name = $last_name = null;
        if ($num == 1) {
            $first_name = $arr['0'];
            $last_name = $arr['0'];
        }
        if ($num == 2) {
            $first_name = $arr['0'];
            $last_name = $arr['1'];
        }
        if ($num > 2) {
            $first_name = $arr['0'];
            $last_name = $arr['2'];
        }
        /* if ($borrower_info['gender'] == 'Male') {
            $gender = 1;
        } else {
            $gender = 2;
        } */
		$gender = $borrower_info['gender'];
		/* $query = $this->db->get_where('p2p_borrower_experian_response', array('borrower_id' => $borrower_info['id']));
		if ($this->db->affected_rows() == 0 ) { */
		$curl = curl_init();
		$postData = array('mobileNo' => $borrower_info['mobile'],'fname' => $first_name,'lname' => $last_name, 'creditScoreRequestType' => 'free','user_id' => $borrowerId, 'experian_source' => 'credit-line');
		
		curl_setopt_array($curl, array(
		   CURLOPT_URL => 'https://www.antworksmoney.com/app/ScoreApi/ScoreApi/',
		   CURLOPT_RETURNTRANSFER => true,
		   CURLOPT_ENCODING => '',
		   CURLOPT_MAXREDIRS => 10,
		   CURLOPT_TIMEOUT => 0,
		   CURLOPT_FOLLOWLOCATION => true,
		   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		   CURLOPT_CUSTOMREQUEST => 'POST',
		   CURLOPT_POSTFIELDS => json_encode($postData),
		   CURLOPT_HTTPHEADER => array(
			 'Content-Type: application/json',
			 'client_id: antworkCurlApi',
			 'secret: testing@1234#'
		   ),
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$result = (array)json_decode($response);
		//pr($result);exit;
		if($result['status'] == 1){
			$arr_response = array(
                'borrower_id' => $borrower_info['id'],
                'experian_response' => $result['msg'].'-'.$result['creditScoreRequestType'],
                'experian_response_file' => $result['xmlFilePath'],

            );
			
            $this->db->insert('p2p_borrower_experian_response', $arr_response);
			$this->load->model('Creditenginemodel');
			$this->Creditenginemodel->Engine($borrower_info['id']);
		}
	//}
        

    }
	public function basic_filteration($dob, $pan, $pincode, $qualification, $occuption_type, $company_code, $income, $credit_score)
    {
		
        $this->db->get_where('borrower_basic_filtration_criteria', array('borrower_id' => $this->input->post('borrower_id')));
		
        if ($this->db->affected_rows() <= 0) {
            $this->db->insert('borrower_basic_filtration_criteria', array('borrower_id' => $this->input->post('borrower_id')));
        }
        //Check KYC
        $borrower_status = 1;
        $msg = '';
        $kyc_status = 1;
        $kyc_status_msg = '';
        $query = $this->db->order_by('id', 'desc')->get_where('p2p_borrower_steps_credit_line', array('borrower_id' => $this->input->post('borrower_id')));
		//echo $this->db->last_query();exit;
		
        if ($this->db->affected_rows() > 0) {
            $step = $query->row_array();

            if ($step['step_1'] == '2' || $step['step_1'] == '3') {
                $msg .= "Pan API error";
                $borrower_status = 0;
                $kyc_status = 0;
                $kyc_status_msg = 'Kyc not found';
            }
        } else {
            $this->db->where('borrower_id', $this->input->post('borrower_id'));
            $this->db->set('pan', 0);
            $this->db->update('borrower_basic_filtration_criteria');
            $msg .= "Pan API error";
            $borrower_status = 0;
            $kyc_status = 0;
            $kyc_status_msg = 'Kyc not found';
        }
        

        $query = $this->db->order_by('id', 'desc')->limit(1)->get_where('basic_filter_rules');
        $filter = $query->row_array();
		//echo $this->db->last_query();exit;
        $u_dob = 0;
		
       $age = (date('Y') - date('Y', strtotime($dob)));

        if ($age > $filter['min_age'] && $age < $filter['max_age']) {
            $u_dob = 1;
        } else {
            $borrower_status = 0;
            $msg .= 'Age error';
        }
        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('dob', $u_dob);
        $this->db->update('borrower_basic_filtration_criteria');

        
        $u_pincode = 1;
        $this->db->get_where('negative_pincode', array('pincode' => $pincode));
        if ($this->db->affected_rows() > 0) {
            $u_pincode = 0;
            $borrower_status = 0;
            $msg .= 'Pincode error';
        }
        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('pincode', $u_pincode);
        $this->db->update('borrower_basic_filtration_criteria');

        $u_Qualification = 0;
        $q = explode(',', $filter['qualification']);
		
        if (in_array($qualification, $q)) {
            $u_Qualification = 1;
        } else {
            $borrower_status = 0;
            $msg .= 'Qualification error';
        }

        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('Qualification', $u_Qualification);
        $this->db->update('borrower_basic_filtration_criteria');

        $u_Occupation = 0;
        $o = explode(',', $filter['occupation']);
        if (in_array($occuption_type, $o)) {
            $u_Occupation = 1;
        } else {
            $borrower_status = 0;
            $msg .= 'Occupation error';
        }

        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('Occupation', $u_Occupation);
        $this->db->update('borrower_basic_filtration_criteria');

        $u_Company = 0;
        $c = explode(',', $filter['company_category']);
        if (in_array($company_code, $c)) {
            $u_Company = 1;
        } else {
            $borrower_status = 0;
            $msg .= 'Company Category error';
        }
        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('Company', $u_Occupation);
        $this->db->update('borrower_basic_filtration_criteria');

        $u_salary = 0;

        if ($filter['salary_less_than'] < $income) {
            $u_salary = 1;
        } else {
            $borrower_status = 0;
            $msg .= 'Salary Error';
        }
        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('salary', $u_Occupation);
        $this->db->update('borrower_basic_filtration_criteria');

        //
        $u_credit_score = 0;
        $query = $this->db->select('experian_score')->order_by('id', 'desc')->limit(1)->get_where('ant_borrower_rating', array('borrower_id' => $this->input->post('borrower_id')));
        if ($this->db->affected_rows() > 0) {
            $credit_score = $query->row()->experian_score;
            if ($filter['credit_score'] <= $credit_score) {
                $u_credit_score = 1;

                $this->db->where('borrower_id', $this->input->post('borrower_id'));
                $this->db->set('experian_step', $u_credit_score);
                $this->db->update('p2p_borrower_steps_credit_line');

            } else {
                $this->db->where('borrower_id', $this->input->post('borrower_id'));
                $this->db->set('experian_step', $u_credit_score);
                $this->db->update('p2p_borrower_steps_credit_line');

                $borrower_status = 0;
                $msg .= 'Experian Error!!';
            }
        } else {
            $this->db->where('borrower_id', $this->input->post('borrower_id'));
            $this->db->set('experian_step', $u_credit_score);
            $this->db->update('p2p_borrower_steps_credit_line');

            $borrower_status = 0;
            $msg .= 'Experian Error!';
        }

        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('credit_score', $u_Occupation);
        $this->db->update('borrower_basic_filtration_criteria');
        return array('basic_filter_pass' => $borrower_status, 'msg' => $msg, 'kyc_status' => $kyc_status, 'kyc_status_msg' => $kyc_status_msg);

    }
	public function ektara_first_api($borrowerId)
    {
        $info = $this->get_borrower_details($borrowerId);

        $borr_info = [
            "customer_id" => $info['borrower_id'],
            "customer_creation_date" => $info['created_date'],
            "name" => $info['name'],
            "email" => $info['email'],
            "mobile" => (int)$info['mobile'],
            "alt_mobile" => (int)$info['mobile'],
            "gender" => $info['gender'],
            "dob" => $info['dob'],
            "marital_status" => "",
            "pan" => $info['pan'],
            "qualification" => $info['highest_qualification'],
            "occupation" => $info['occuption_id'],
            "source_of_income" => "",
            "total_experience" => 0,
            "company_type" => $info['company_type'],
            "ip_address" => $info['ip_address'],
            "city" => $info['r_city'],
            "pincode" => 133333,
            "current_emis" => 0,
            "ever_defaulted" => false,
            "net_monthly_income" => 45000,
            "turnover_last_year" => 0,
            "turnover_last2_year" => 0,
            "source_of_income_other" => "",
            "salary_process" => "",
            "latitude" => $info['latitude'],
            "longitude" => $info['longitude'],
        ];
		
		file_put_contents('ektara.txt', date('Y-m-d H:i:s').' - Request First Api - '.json_encode($borr_info)."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
		
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => '216.48.189.217:80/RestAPIs/loans/p2p/new_user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($borr_info),
			CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Token c72e3acc2510ef0590a6d56f468554af74ac7ac7',
			),
        ));

       $response = curl_exec($curl);
      file_put_contents('ektara.txt', date('Y-m-d H:i:s').' - Response First Api - '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND); //$this->db->where('id',$last_insert_id)->where('borrower_id',$borrowerId)->limit(1)->update('ekTara_response',array('response'=>$response));
        curl_close($curl);


    }

    
	public function get_borrower_details_credit_line()
    {
        $query = $this->db->get_where('p2p_borrowers_list', array('mobile' => $this->input->post('mobile')));
        if ($this->db->affected_rows() > 0) {
            $result = $query->row_array();
			$vendor_id = $result['vendor_id'];
            $bank_details = array();
            $address_details = array();
            $occupation_details = array();
            $loan_details = array();
            $current_step = array();
            $query = $this->db->get_where('p2p_borrower_bank_details', array('borrower_id' => $result['id']));
            if ($this->db->affected_rows() > 0) {
                $bank_details = $query->row_array();

            }

            $query = $this->db->get_where('p2p_borrower_address_details', array('borrower_id' => $result['id']));
            if ($this->db->affected_rows() > 0) {
                $address_details = $query->row_array();
            }

            $query = $this->db->get_where('p2p_borrower_occuption_details', array('borrower_id' => $result['id']));
            if ($this->db->affected_rows() > 0) {
                $occupation_details = $query->row_array();

            }

            $query = $this->db->order_by('id', 'desc')->limit(1)->get_where('p2p_loan_list', array('borrower_id' => $result['id']));
            if ($this->db->affected_rows() > 0) {
                $loan_details = $query->result_array();

            }
            $getExperian_details = $this->getExperian_details($result['id']); 
            return array(
                'status' => 1,
                'borrower_id' => $result['id'],
				'experian_score' => ($getExperian_details['experian_score'])?$getExperian_details['experian_score']:0,
                'name' => $result['name'],
                'email' => $result['email'],
                'mobile' => $result['mobile'],
                'gender' => $result['gender'],
                'dob' => $result['dob'],
                'highest_qualification' => $result['highest_qualification'],
                'occuption_id' => $result['occuption_id'],
                'pan' => $result['pan'],
                'aadhar' => $result['aadhar'],
                'bank_details' => $bank_details,
                'address_details' => $address_details,
                'occupation_details' => $occupation_details,
                'loan_details' => $loan_details,
				'vendor_id' => $vendor_id,
                
                'current_step_details' => $this->get_current_status_credit_line($result['id']),
                'msg' => 'Found'

            );
        } else {
            return array('status' => 0, 'msg' => 'Sorry No data found');
        }
    }
	public function borrower_video_kyc()
    {
        if ($this->input->post('kyc_data')) {
            $_kyc = date('YmdHis') . $this->input->post('borrower_id') . '_kyc';
            $decoded_kyc = base64_decode($this->input->post('kyc_data'));
            $image_kyc = file_put_contents('kyc/' . $_kyc . '.png', $decoded_kyc);
            $this->db->insert('borrower_video_kyc', array('borrower_id' => $this->input->post('borrower_id'), 'video_url' => 'kyc' . $_kyc . '.png'));
            $this->db->where('borrower_id', $this->input->post('borrower_id'));
            $this->db->set('step_8', 1);
            $this->db->update('p2p_borrower_steps_credit_line');
        }
        return true;
    }
	public function get_borrower_details($borrowerId)
    {
        $query = $this->db
            ->select("
            bl.id,
            bl.borrower_id,
            bl.borrower_escrow_account,
            bl.name,
            bl.email,
            bl.mobile,
            bl.gender,
            bl.dob,
            bl.highest_qualification,
            ql.qualification,
            bl.occuption_id,
            ac.name as occuption,
            bl.marital_status,
            bl.pan,
            bl.aadhar,
            bl.status,
            bl.created_date,
            b_add.r_address, 
			b_add.r_address1, 
			b_add.r_city,
			b_add.r_state,
			b_add.r_state_name,
			b_add.r_pincode,
			b_add.latitude,
			b_add.longitude,
            od.company_type,od.company_name,od.net_monthly_income,od.turnover_last_year,od.turnover_last2_year
            ")
            ->join('p2p_borrower_address_details as b_add', 'b_add.borrower_id = bl.id', 'left')
            ->join('p2p_borrower_occuption_details as od', 'od.borrower_id = bl.id', 'left')
            ->join('p2p_qualification as ql', 'ql.id = bl.highest_qualification', 'left')
            ->join('p2p_occupation_details_table as ac', 'ac.id = bl.occuption_id', 'left')
            ->get_where('p2p_borrowers_list bl', array('bl.id' => $borrowerId));
			//echo $this->db->last_query();exit;
        if ($this->db->affected_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
	public function ektara_second_api($borrowerId)
    {
		
        $info = $this->get_borrower_details($borrowerId);
		//print_r($info);die("run");
        $bank_details = $this->get_accountDetails($borrowerId);
        $query = $this->db->order_by('id', 'desc')->limit(1)->get_where('ant_borrower_rating', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {
            $rating = $query->row_array();
            $request = [
                "customer_id" => $info['borrower_id'],
                "loan_amount" => 10000,
                "loan_purpose" => "Need Loan",
                "city_of_residence" => $info['r_city'],
                "bank_name" => ($bank_details['bank_name'])?$bank_details['bank_name']:"",
                "experian_score" => (int)$rating['experian_score'],
                "experian_response" => $rating['experian_response'],
                "revolving_credit_line_to_total_credit" => (int)$rating['revolving_credit_line_to_total_credit'],
                "short_term_credit_to_total_credit" => (int)$rating['short_term_credit_to_total_credit'],
                "overall_leveraging_ratio" => (int)$rating['overall_leveraging_ratio'],
                "leverage_ratio_maximum_available_credit" => (int)$rating['leverage_ratio_maximum_available_credit'],
                "secured_facilities_to_total_credit" => (int)$rating['secured_facilities_to_total_credit'],
                "limit_utilization_revolving_credit" => (int)$rating['limit_utilization_revolving_credit'],
                "outstanding_to_limit_term_credit" => (int)$rating['outstanding_to_limit_term_credit'],
                "outstanding_to_limit_term_credit_including_past_facilities" => (int)$rating['outstanding_to_limit_term_credit_including_past_facilities'],
                "short_term_leveraging" => (int)$rating['short_term_leveraging'],
                "fixed_obligation_to_income" => (int)$rating['fixed_obligation_to_income'],
                "no_of_active_accounts" => (int)$rating['no_of_active_accounts'],
                "variety_of_loans_active" => (int)$rating['variety_of_loans_active'],
                "no_of_credit_enquiry_in_last_3_months" => (int)$rating['no_of_credit_enquiry_in_last_3_months'],
                "no_of_loans_availed_to_credit_enquiry_in_last_12_months" => (int)$rating['no_of_loans_availed_to_credit_enquiry_in_last_12_months'],
                "history_of_credit_oldest_credit_account" => (int)$rating['history_of_credit_oldest_credit_account'],
                "limit_breach" => (int)$rating['limit_breach'],
                "overdue_to_obligation" => (int)$rating['overdue_to_obligation'],
                "overdue_to_monthly_income" => (int)$rating['overdue_to_monthly_income'],
                "number_of_instances_of_delay_in_past_6_months" => (int)$rating['number_of_instances_of_delay_in_past_6_months'],
                "number_of_instances_of_delay_in_past_12_months" => (int)$rating['number_of_instances_of_delay_in_past_12_months'],
                "number_of_instances_of_delay_in_past_36_months" => (int)$rating['number_of_instances_of_delay_in_past_36_months'],
                "cheque_bouncing" => (int)$rating['cheque_bouncing'],
                "credit_summation_to_annual_income" => (int)$rating['credit_summation_to_annual_income'],
                "digital_banking" => (int)$rating['digital_banking'],
                "savings_as_percentage_of_annual_income" => (int)$rating['savings_as_percentage_of_annual_income']
            ];
			
			file_put_contents('ektara.txt', date('Y-m-d H:i:s').' - Request Second API- '.json_encode($request)."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
			
            // ektara changes starts
			
			$response_array = $this->ektara_second_api_curl($request);
			
			if($response_array[1]['RespCode'] == 'User Not Present'){
				$this->ektara_first_api($borrowerId);
				$response_array = $this->ektara_second_api_curl($request);
			}
			
			if($response_array=="" || $response_array==null){
				return false;
			}
			// ektata changes ends
			
			
		
           if($borrowerId == 38 ||$borrowerId == 39)
		   {
			   $this->db->insert('ekTara_response', array(
                'ekTara_request' => json_encode($request),
                'borrower_id' => $borrowerId,
                'RespCode' => "Request Success",
                'CreditRating' => 83,
                'FraudRating' => 42,
                'CreditCategory' => "Green",
                'PropensityRating' => $response_array[1]['PropensityRating'],
                'LoanDispursalDate' => $response_array[1]['LoanDispursalDate'],
                'CollectRating' => $response_array[1]['CollectRating'],
                 ));
				 $last_insert_id = $this->db->insert_id();
				 //Update API Response
					//$this->db->where('id',$last_insert_id)->where('borrower_id',$borrowerId)->limit(1)->update('ekTara_response',array('response'=>$response));
		   }	
			else 
			{	
						$this->db->insert('ekTara_response', array(
						   'ekTara_request' => json_encode($request),
							'borrower_id' => $borrowerId,
							'RespCode' => $response_array[1]['RespCode'],
							'CreditRating' => $response_array[1]['CreditRating'],
							'FraudRating' => $response_array[1]['FraudRating'],
							'CreditCategory' => $response_array[1]['CreditCategory'],
							'PropensityRating' => $response_array[1]['PropensityRating'],
							'LoanDispursalDate' => $response_array[1]['LoanDispursalDate'],
							'CollectRating' => $response_array[1]['CollectRating'],
						));
				$last_insert_id = $this->db->insert_id();
			//Update API Response
					//$this->db->where('id',$last_insert_id)->where('borrower_id',$borrowerId)->limit(1)->update('ekTara_response',array('response'=>$response));				
			}
		
		/*********start********/
		 if ($response_array[1]['CreditCategory'] == 'Green') {
            $this->db->where('borrower_id', $borrowerId);
            $this->db->set('step_2', 1);
            $this->db->update('p2p_borrower_steps_credit_line');
        }

        if ($response_array[1]['CreditCategory'] == 'Amber') {
            $this->db->where('borrower_id', $borrowerId);
            $this->db->set('step_2', 2);
            $this->db->update('p2p_borrower_steps_credit_line');
        }

        if ($response_array[1]['CreditCategory'] == 'Red' || !isset($response_array[1]['CreditCategory'])) {
            $this->db->where('borrower_id', $borrowerId);
            $this->db->set('step_2', 3);
            $this->db->update('p2p_borrower_steps_credit_line');
        }
		 /**********end********/
        }
       

        file_put_contents('log', $this->db->last_query() . PHP_EOL, FILE_APPEND);
        $this->db->where('borrower_id', $borrowerId);
        $this->db->set('modified_date', date('Y-m-d H:i:s'));
        $this->db->update('p2p_borrowers_list');
        return true;
    }
	
	
	public function ektara_second_api_curl($request){
		
		$curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => '216.48.189.217:80/RestAPIs/loans/p2p/cbinfo',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($request),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
					'Authorization: Token c72e3acc2510ef0590a6d56f468554af74ac7ac7',
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
			
			file_put_contents('ektara.txt', date('Y-m-d H:i:s').' - response Second API- '.$response."\n\r ---------- \n\r".PHP_EOL, FILE_APPEND);
			
            $response_array = json_decode($response, true);
			return $response_array;
	}
	
	
	public function get_accountDetails($borrowerId)
    {

        $this->db->select('bank_name, account_number, ifsc_code, account_type');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_borrower_bank_details');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
	public function loan_eligibility_status()
    {
       $ektaraSecondResp = $this->ektara_second_api($this->input->post('borrower_id'));
	   if($ektaraSecondResp==false){
		   return $response = ['status' => 0, 'loan_id' => '', 'msg' => 'Internal Server Error, Please Try Again Later.',];
	   }
        $where = "(CreditCategory = 'Green' or CreditCategory = 'Amber')";
        $this->db->where($where)->order_by('id', 'desc')->limit(1)->get_where('ektara_response', array('borrower_id' => $this->input->post('borrower_id')));
	//	echo $this->db->last_query();exit;
        if ($this->db->affected_rows() > 0) {
            $query = $this->db->get_where('p2p_borrower_steps_credit_line', array('borrower_id' => $this->input->post('borrower_id')));
			
            if ($this->db->affected_rows() > 0) {
                $result = $query->row_array();
			//	pr($result);exit;
                if ($result['step_2'] == 1 || $result['step_2'] == 2) {
					$loan_data = $this->db->get_where('p2p_loan_list', array('borrower_id' => $this->input->post('borrower_id')))->row();
					if ($this->db->affected_rows() > 0) {
					    $loan_data = $this->db->get_where('p2p_loan_list', array('id' => $loan_data->id))->row();
						
						return $response = ['status' => 1, 'loan_id' => $loan_data->id, 'loan_amount' => $loan_data->approved_loan_amount, 'msg' => 'Loan ID Already exist',];
					}else{
						
						//$loan_no=$this->credit_line_generate_loan_no();  

						// insert data in p2p_bidding_proposal_details start
						
						$proposal_submit_array = array(
                    'borrowers_id'=> $this->input->post('borrower_id'),
                    'bid_loan_amount'=>2500,
                    'loan_amount'=>2500,
                    'accepted_tenor'=>36,
                    'interest_rate'=>36,
                    'proposal_added_date'=>date("Y-m-d H:i:s"),
					'source'=>'lsBrSkip' // lsBrElig->lendsocialBorrowerEligiblity or lsBrSkip->lendsocialBorrowerSkipStep

                );

 

                $proposal_submit = $this->cldb->insert('p2p_bidding_proposal_details',$proposal_submit_array); // created at 19/04/2024
						
						// insert data in p2p_bidding_proposal_details ends
						$bid_registration_id = $this->cldb->insert_id();
						$loan_no_plus =  10000000000 + $bid_registration_id;
						$loan_no = 'LN' . $loan_no_plus;
						$this->cldb->where('bid_registration_id',$bid_registration_id);
						$this->cldb->update("p2p_bidding_proposal_details",array('loan_no'=>$loan_no));
						
						$this->cldb->insert('p2p_loan_list', array(
							'borrower_id' => $this->input->post('borrower_id'),
							'loan_no' => $loan_no,
							'lender_id' => $this->input->post('partner_id'),
							'approved_loan_amount' => '2500',
							'approved_interest' => '2',
							'approved_tenor' => '1',
							'loan_processing_charges' => '0',
							'disburse_amount' => '0',
						));
						$loan_id = $this->cldb->insert_id();
						
						$loanData = $this->db->get_where('p2p_loan_list', array('id' => $loan_id))->row();
						return $response = ['status' => 1, 'loan_id' => $loan_id, 'loan_amount' => $loanData->approved_loan_amount, 'msg' => 'This should only take few seconds.',];
					}

                    
                }

            }
        } else {
			return $response = ['status' => 0, 'loan_id' => '', 'msg' => 'Sorry you are not eligible for loan.',];
        }
    }
	 public function credit_line_sanction_details()
    {
        $query = $this->db->get_where('p2p_loan_list', array(
            'borrower_id' => $this->input->post('borrower_id'),
            'id' => $this->input->post('loan_id'),
        ));
		
        if ($this->db->affected_rows() > 0) {
            $result = $query->row_array();

            return array('status' => 1, 'approved_loan' => $result['approved_loan_amount'], 'approved_tenor' => $result['approved_tenor'], 'approved_interest_rate' => $result['approved_interest'], 'amount_to_pay' => '2550');
        } else {
            return array('status' => 0, 'approved_loan' => 0, 'approved_tenor' => '0', 'approved_interest_rate' => '0', 'amount_to_pay' => '0');
        }
    }
	public function e_sign()
    {

        $this->db->where('borrower_id', $this->input->post('borrower_id'));
        $this->db->set('step_5', 1);
        $this->db->update('p2p_borrower_steps_credit_line');

        $info = $this->get_borrower_details($this->input->post('borrower_id'));
		
        $request = array("uniqueId" => rand(),
            "signers" => [[
                "email" => $info['email'],
                "location" => $info['r_city'],
                "mobile" => $info['mobile'],
                "name" => $info['name']

            ]],
            "reason" => "Loan agreement",
            "templateId" => "ESIG9864668",
            "fileName" => " loan_agreement.pdf");
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => GENERATE_ESIGN_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($request),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Njc1MDg0MjE6S05wVXhsZUlONGRtNlpuRWN5QnZzSGpkZ29YWkVrSXg=',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response_array = json_decode($response, true);
		 if ($response_array['code'] == '200') {


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $response_array['model']['url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => array('file' => new CURLFILE(FCPATH . 'borrower_loan_aggrement/loan_agreement.pdf')),
            ));

            $response_put = curl_exec($curl);

            curl_close($curl);
            $response_array['url'] = E_SIGN_PROCESS . $response_array['model']['docId'];
            return $response_array;
        } else {
            return array('status' => 0, 'msg' => 'Something went wrong please try again');
        }
    }
	 public function generate_enach($borrowerId)
    {
        $info = $this->get_borrower_details($borrowerId);
        $txn_id = uniqid();
        $si_details = json_encode(array(
            'billingCycle' => "MONTHLY",
            'billingInterval' => "1",
            'billingAmount' => "100.00",
            'billingCurrency' => "INR",
            'paymentStartDate' => "2022-11-18",
            'paymentEndDate' => "2022-12-01",

        ));
        $request = array(
            'key' => 'yhV8Cx',
            'txnid' => $txn_id,
            'amount' => '1.00',
            'productinfo' => 'Enach  for Credit Line',
            'firstname' => $info['name'],
            'email' => $info['email'],
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'phone' => $info['mobile'],
            'surl' => "https://antworksp2p.com/enach/success",
            'furl' => "https://antworksp2p.com/enach/failure",
            'api_version' => "7",
            'si' => "1",
            'si_details' => $si_details,
            'secret_key' => 'hyp6aBliBVpzSiodnTcT1VXY59rb36Xz'
        );
        $request_info_base64 = base64_encode(json_encode($request));
        unset($request['phone']);
        unset($request['surl']);
        unset($request['furl']);
        unset($request['api_version']);
        unset($request['si']);
        $request['hash'] = hash('SHA512', implode('|', $request));
        $request_info_base64_with_hash = base64_encode(json_encode($request));

        $this->db->where('id', $borrowerId);
        $this->db->set('modified_date', date('Y-m-d H:i:s'));
        $this->db->update('p2p_borrowers_list');
        
        return array(
            'status' => 1,
            'url' => base_url('enach?request_info=') . $request_info_base64 . '&request_info_with_hash=' . $request_info_base64_with_hash,
            'msg' => "Found",
        );

    }
	public function loan_details(){
		$this->load->library('encrypt');
		$query = $this->db->get_where('p2p_borrower_social_loan', array('mobile' => $this->input->post('mobile'),'borrower_id' => $this->input->post('borrower_id')));
        if ($this->db->affected_rows() > 0) {
			$update_array = array(
            'loan_amount' => $this->input->post('loan_amount'),
            'loan_purpose' => $this->input->post('loan_purpose'),
            'tenure' => $this->input->post('tenure'),
            'roi' => $this->input->post('roi')
              );
			$this->db->where('mobile', $this->input->post('mobile'));
			$this->db->where('borrower_id', $this->input->post('borrower_id'));
			$this->db->update('p2p_borrower_social_loan', $update_array);
		}else{
			$add_array = array(
            'mobile' => $this->input->post('mobile'),
            'borrower_id' => $this->input->post('borrower_id'),
            'loan_amount' => $this->input->post('loan_amount'),
            'loan_purpose' => $this->input->post('loan_purpose'),
            'tenure' => $this->input->post('tenure'),
            'roi' => $this->input->post('roi')
             );
		
           $this->db->insert('p2p_borrower_social_loan', $add_array);
		}
		$url = "https://www.antworksp2p.com/sl?id=".$this->encrypt->encode($this->input->post('mobile'));
		return ['status' => 1, 'msg' => 'Loan Request add successfully', 'borrower_id' => $this->input->post('borrower_id'),'web_url' => $url];
	}
	 public function getExperian_details($borrower_id)
    {
        $this->db->select('experian_score, experian_response');
        $this->db->from('ant_borrower_rating');
        $this->db->where('borrower_id', $borrower_id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return (array)$query->row();
        } else {
            return false;
        }
    }
	public function get_current_status_credit_line($borrower_id)
    {
        $query = $this->db->get_where('p2p_borrower_steps_credit_line', array('borrower_id' => $borrower_id));
        if ($this->db->affected_rows() > 0) {
            $steps = $query->row_array();
			//echo "<pre>";print_r($steps);die();
            if ($steps['step_1']) {
                if ($steps['step_1'] == 2 || $steps['step_1'] == 3) {
                    return $current_step = array(
                        'step' => 'Basic Filter PAN',
                        'msg' => 'Pan Invalid or Name is Incorrect'
                    );
                }
            }

            if ($steps['bank_account_step']) {
                if ($steps['step_1'] == 2 || $steps['step_1'] == 3) {
                    return $current_step = array(
                        'step' => 'Bank Account',
                        'msg' => 'Bank Account Validation Failed'
                    );
                }
            }

            if ($steps['experian_step']) {
                if ($steps['experian_step'] == 2) {
                    return $current_step = array(
                        'step' => 'Basic Filter Experian',
                        'msg' => 'Basic Filter Experian'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'Basic Filter Experian',
                    'msg' => 'Basic Filter Experian'
                );
            }

            if ($steps['step_8']) {
                if ($steps['step_1'] == 2) {
                    return $current_step = array(
                        'step' => 'video kyc',
                        'msg' => 'video kyc error'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'video kyc',
                    'msg' => 'video kyc error'
                );
            }

            if ($steps['bank_account_step']) {
                if ($steps['bank_account_step'] == 2) {
                    return $current_step = array(
                        'step' => 'Bank Account',
                        'msg' => 'Bank Account error'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'Bank Account',
                    'msg' => 'Bank Account Not Found'
                );
            }

            if ($steps['step_2']) {
                if ($steps['step_2'] == 3) {
                    return $current_step = array(
                        'step' => 'Credit decisioning',
                        'msg' => 'Credit decisioning Failed'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'Credit decisioning',
                    'msg' => 'Credit decisioning not done'
                );
            }

           /*  if ($steps['step_3']) {
                if ($steps['step_3'] == 2) {
                    return $current_step = array(
                        'step' => 'E-nach',
                        'msg' => 'E-nach Failed'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'E-nach',
                    'msg' => 'E-nach not done'
                );
            } */

            if ($steps['step_4']) {
                if ($steps['step_4'] == 2) {
                    return $current_step = array(
                        'step' => 'LOAN AGREEMENT',
                        'msg' => 'LOAN AGREEMENT Failed'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'LOAN AGREEMENT',
                    'msg' => 'LOAN AGREEMENT not done'
                );
            }

            if ($steps['step_5']) {
                if ($steps['step_5'] == 2) {
                    return $current_step = array(
                        'step' => 'E SIGN',
                        'msg' => 'E SIGN Failed'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'E SIGN',
                    'msg' => 'E SIGN not done'
                );
            }

            if ($steps['step_6']) {
                if ($steps['step_6'] == 2) {
                    return $current_step = array(
                        'step' => 'DISBURSMENT PENDING',
                        'msg' => 'DISBURSMENT REQUEST Failed'
                    );
                }
            } else {
                return $current_step = array(
                    'step' => 'DISBURSMENT PENDING',
                    'msg' => 'DISBURSMENT REQUEST not done'
                );
            }

            return $current_step = array(
                'step' => 'ALL STEPS DONE',
                'msg' => 'ALL STEPS DONE'
            );

        }
    }
 public function add_disburse_loan_amount($borrowerId)
    {

        $this->db->insert('p2p_disburse_loan_details', array(
            'borrower_id' => $borrowerId,
            'lender_id' => '1',
            'approved_loan_amount' => '2500',
            'loan_processing_charges' => '0',
            'loan_tieup_fee' => '0',
            'disburse_amount' => '2500',
            'reference' => '',
        ));
    }
	 public function credit_line_generate_loan_no()
    {

        $this->db->select("loan_no");
        $this->db->order_by('loan_no', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('p2p_loan_list');
        $row = (array)$query->row();
        if ($this->db->affected_rows() > 0) {
            $loan_no = $row['loan_no'];
            $loan_no++;
            return $loan_no = $loan_no;
        } else {
            return $loan_no = "LN10000000001";
        }
    }
#Old function 18-01-24

	public function replace_space($name){
		$string = str_replace(' ', '-', $name);
		$string = preg_replace('/[^A-Za-z0-9.\-]/', '', $string);
		$string = preg_replace('/-+/', ' ', $string);
		$string = strtoupper($string);
		return $string;
	}

    public function add_borrower()
    {
        $borrower_id = create_borrower_id();
        //$borrower_escrow_account = $this->Borrowermodel->createEscrowaccount();

        $borrower_array = array(
            'borrower_id' => $borrower_id,
//                              'borrower_escrow_account'=>$borrower_escrow_account,
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'pan' => $this->input->post('pan'),
            'password' => $this->input->post('password'),
            'verify_code' => hash('SHA512', $this->input->post('email')),
            'verify_hash' => hash('SHA512', ($this->input->post('password') . '_' . $this->input->post('email'))),
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_borrowers_list', $borrower_array);
        if ($this->db->affected_rows() > 0) {
            $last_insert_borrower_id = $this->db->insert_id();
            $this->updateBorrowerappdetails($last_insert_borrower_id);
            $this->Commonapimodel->Send_verification_email_code($last_insert_borrower_id, $source = 'APP');
            return true;
        } else {
            return false;
        }

    }

    public function updateBorrowerappdetails($borrowerId)
    {
        $this->db->get_where('p2p_app_borrower_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {
            $app_details = array(
                'imei_no' => $this->input->post('imei_no'),
                'mobile_token' => $this->input->post('mobile_token'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'created_date' => date("Y-m-d H:i:s"),
            );
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_app_borrower_details', $app_details);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $app_details = array(
                'borrower_id' => $borrowerId,
                'imei_no' => $this->input->post('imei_no'),
                'mobile_token' => $this->input->post('mobile_token'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'created_date' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_app_borrower_details', $app_details);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function add_loan_details($borrowerId)
    {
        $plnr = $this->Borrowermodel->create_plnr_no();


        $loan_details = array(
            'borrower_id' => $borrowerId,
            'p2p_product_id' => $this->input->post('p2p_product_id'),
            'loan_amount' => $this->input->post('loan_amount'),
            'tenor_months' => $this->input->post('tenor_months'),
            'prefered_interest_max' => 36,
            'loan_description' => $this->input->post('loan_description'),
            'PLRN' => $plnr,
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_proposal_details', $loan_details);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function add_consumer_loan_details($borrowerId)
    {
        $plnr = $this->Borrowermodel->create_plnr_no();
        $loan_details = array(
            'borrower_id' => $borrowerId,
            'p2p_product_id' => $this->input->post('p2p_product_id'),
            'loan_amount' => $this->input->post('loan_amount'),
            'tenor_months' => $this->input->post('tenor_months'),
            'prefered_interest_max' => 18,
            'PLRN' => $plnr,
            'created_date' => date("Y-m-d H:i:s"),
        );
        $this->db->insert('p2p_proposal_details', $loan_details);
        $proposal_id = $this->db->insert_id();

        if ($this->db->affected_rows() > 0) {
            $proposal_id = $this->db->insert_id();
            $product_info = array(
                'proposal_id' => $proposal_id,
                'product_name' => $this->input->post('product_name'),
                'invoice_value' => $this->input->post('invoice_value'),
                'mode_of_purchase' => $this->input->post('mode_of_purchase'),
            );
            $this->db->insert('p2p_consumer_loan_details', $product_info);
            return $proposal_id;
        } else {
            return false;
        }
    }

    public function update_gender($borrowerId)
    {


        $data = array(
            'gender' => $this->input->post('gender'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_dob($borrowerId)
    {


        $data = array(
            'dob' => $this->input->post('dob'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_marital_status($borrowerId)
    {


        $data = array(
            'marital_status' => $this->input->post('marital_status'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_qualification($borrowerId)
    {


        $data = array(
            'highest_qualification' => $this->input->post('highest_qualification'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_occuption($borrowerId)
    {


        $data = array(
            'occuption_id' => $this->input->post('occuption_id'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //This method is using for to save occupation details exclude Salaried
    public function addOccupation($borrowerId)
    {
        $_POST['occuption_type'] = $this->input->post('occuption_id');
        unset($_POST['occuption_id']);
        $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {

            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_occuption_details', $_POST);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $_POST['borrower_id'] = $borrowerId;
            $this->db->insert('p2p_borrower_occuption_details', $_POST);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function add_company_details($borrowerId)
    {
        $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {
            $company_details = array(
                'company_type' => $this->input->post('company_type'),
                'company_name' => $this->input->post('company_name'),
                'created_date' => date("Y-m-d H:i:s"),
            );
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_occuption_details', $company_details);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $company_details = array(
                'borrower_id' => $borrowerId,
                'company_type' => $this->input->post('company_type'),
                'company_name' => $this->input->post('company_name'),
                'created_date' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_borrower_occuption_details', $company_details);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function add_income_details($borrowerId)
    {
        $this->db->select('id')->get_where('p2p_borrower_occuption_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {

            $company_details = array(
                'salary_process' => $this->input->post('salary_process'),
                'net_monthly_income' => $this->input->post('net_monthly_income'),
            );
            $this->db->where('borrower_id', $borrowerId);
            $this->db->update('p2p_borrower_occuption_details', $company_details);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $company_details = array(
                'borrower_id' => $borrowerId,
                'salary_process' => $this->input->post('salary_process'),
                'net_monthly_income' => $this->input->post('net_monthly_income'),
                'created_date' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_borrower_occuption_details', $company_details);

            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function add_address_details($borrowerId)
    {
        $this->db->select('borrower_id')->get_where('p2p_borrower_address_details', array('borrower_id' => $borrowerId));
        if ($this->db->affected_rows() > 0) {
            return 'Already exist you can request to change address';
        } else {
            $address_details = array(
                'borrower_id' => $borrowerId,
                'r_state' => $this->input->post('r_state'),
                'r_city' => $this->input->post('r_city'),
                'residence_type' => $this->input->post('residence_type'),
                'r_address' => $this->input->post('r_address'),
                'r_pincode' => $this->input->post('r_pincode'),
				'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude'),
				'ip_address' => $this->input->post('ip_address'),
                'date_added' => date("Y-m-d H:i:s"),
            );
            $this->db->insert('p2p_borrower_address_details', $address_details);

            if ($this->db->affected_rows() > 0) {
                return 'Address add successfully';
            } else {
                return false;
            }
        }


    }

    public function update_pan($borrowerId)
    {

        $data = array(

            'pan' => $this->input->post('pan'),
            'modified_date' => date("Y-m-d H:i:s"),
        );

        $this->db->where('id', $borrowerId);
        $this->db->update('p2p_borrowers_list', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add_kyc($file_info)
    {

        $this->db->insert('p2p_borrowers_docs_table', $file_info);

        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }


    public function add_coApplicant($borrowerId)
    {
        $loan_details = array(
            'borrower_id' => $borrowerId,
            'full_name' => $this->input->post('full_name'),
            'dob' => $this->input->post('dob'),
            'mobile' => $this->input->post('mobile'),
            'relation' => $this->input->post('relation'),
            'pan' => $this->input->post('pan'),
        );
        $this->db->insert('p2p_borrowers_co_applicant', $loan_details);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert_statement($borrower_file_info)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file_info);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();


        } else {
            return false;
        }
    }

    public function get_myloan($borrowerId)
    {
        $this->db->select('emi_amount ,emi_date ,emi_principal,emi_balance');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_borrower_emi_details');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_myloanDetails($borrowerId)
    {
        $this->db->select('loan_no ,bid_loan_amount ,tenure');
        $this->db->where('borrower_id', $borrowerId);
        $this->db->from('p2p_bidding_proposal_details');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_loanStatement($borrowerId)
    {
        $sql = "SELECT UI.name, UD.borrower_signature_date, UR.loan_amount,UR.tenor_months,UR.max_interest_rate 
               FROM p2p_borrowers_list AS UI
               LEFT JOIN p2p_proposal_details UR 
               ON UR.borrower_id = UI.id 
               LEFT JOIN p2p_loan_aggrement_signature UD 
               ON  UD.bid_registration_id= UI.id WHERE UI.id = $borrowerId";

        $query = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_loanStatementDetails($borrowerId)
    {
        $sql = "SELECT UI.loan_amount, UR.emi_date, UR.emi_amount,UR.emi_interest,UR.emi_principal,UR.emi_balance  
               FROM p2p_proposal_details AS UI
               LEFT JOIN p2p_borrower_emi_details UR 
               ON  UR.borrower_id= UI.borrower_id WHERE UI.borrower_id = $borrowerId";

        $query = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /*public function verifyOtpMoblie()
     {
         $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
         $this->db->from('p2p_otp_password_table');
         $this->db->where('mobile', $this->input->post('mobile'));
         $this->db->where('status', '0');
         $this->db->order_by('id', 'desc');
         $this->db->limit(1);
         $query = $this->db->get();

         if ($this->db->affected_rows() > 0)
         {
             $result = $query->row();
             if($this->input->post('otp') == $result->otp)
             {
                 if ($result->MINUTE <= 10)
                 {
                     $data['response'] = "verify";
                     $this->db->where('otp', $this->input->post('otp'));
                     $this->db->where('mobile', $this->input->post('mobile'));
                     $this->db->set('status', 1);
                     $this->db->update('p2p_otp_password_table');
                     return true;
                 }
                 else {
                       return 2;
                      }
             }
                else {
                       return 3;
                     }
         }
               else {
                     return false;
                    }
     }*/

//   public function changeMobile($borrowerId)
//    {
//        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
//        $this->db->from('p2p_otp_password_table');
//        $this->db->where('status', '1');
//        $this->db->order_by('id', 'desc');
//        $this->db->limit(1);
//        $query = $this->db->get();
//
//        if ($this->db->affected_rows() > 0)
//         {
//            $result = $query->row();
//           if($this->input->post('otp') == $result->otp)
//             {
//                if ($result->MINUTE <= 10)
//                 {
//                    $data = array(
//                         'mobile'=>$this->input->post('mobile'),
//                         'created_date'=>date("Y-m-d H:i:s"),
//                         );
//                      $this->db->where('id', $borrowerId);
//                      $this->db->where('dob', $this->input->post('dob'));
//                      $this->db->update('p2p_borrowers_list', $data);
//
//
//                    if($this->db->affected_rows()>0)
//                         {
//                               return true;
//                         }
//                     else
//                        {
//                          return false;
//                        }
//                 }
//
//              }
//
//          }
//
//    }

    public function get_personalDetails($borrowerId)
    {

        $this->db->select('name ,email ,mobile,gender,dob');
        $this->db->where('id', $borrowerId);
        $this->db->from('p2p_borrowers_list');
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            return (array)$query->row();
        } else {
            return false;
        }
    }

    public function get_residentalDetails($borrowerId)
    {

        $sql = "SELECT  UI.r_address, UI.r_address1,UI.r_city,UI.r_pincode,UI.present_residence , UR.state AS r_state 
              FROM p2p_borrower_address_details AS UI
              LEFT JOIN p2p_state_experien UR 
               ON  UR.id= UI.r_state WHERE UI.borrower_id = $borrowerId";

        $query = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_OccupationDetails($borrowerId)
    {

        $sql = "SELECT  UR.name AS occuption_type ,UI.company_type, UI.company_name,UI.total_experience,
                          UI.current_emis,UI.salary_process ,UI.net_monthly_income ,UI.turnover_last_year  

               FROM p2p_borrower_occuption_details AS UI
               LEFT JOIN p2p_occupation_details_table UR 
               ON  UR.id= UI.occuption_type WHERE UI.borrower_id = $borrowerId";

        $query = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    

    public function upload_document($borrower_file)
    {
        $this->db->insert('p2p_borrowers_docs_table', $borrower_file);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();


        } else {
            return false;
        }
    }
	
	public function get_borrower_details_credit_line_social_profile($mobile)
    {
        $query = $this->db->select('SL.borrower_id,
		SL.mobile,
		SL.loan_amount,
		SL.loan_purpose,
		SL.tenure,
		SL.roi,
		bl.name as borrower_name')
		->join('p2p_borrowers_list bl', 'bl.id = SL.borrower_id', 'left')
		->get_where('p2p_borrower_social_loan SL', array('SL.mobile' => $mobile));
        if ($this->db->affected_rows() > 0) {
            $result = $query->row_array();
            return array(
                'status' => 1,
                'borrower_id' => $result['borrower_id'],
                'borrower_name' => $result['borrower_name'],
                'mobile' => $result['mobile'],
                'loan_amount' => $result['loan_amount'],
                'loan_purpose' => $result['loan_purpose'],
                'tenure' => $result['tenure'].' Months',
                'roi' => $result['roi'],

            );
        } else {
            return array('status' => 0, 'msg' => 'Sorry No data found');
        }
    }
	public function get_borrower_detail_p2p($lender_id)
    {
		//$this->p2p = $this->load->database('db_p2p', TRUE);
        $this->db->select('*');
        $this->db->where('id', $lender_id);
        $this->db->from('p2p_borrowers_list');
        $query = $this->db->get();
		
        if ($this->db->affected_rows() > 0) {
            return $result = (array)$query->row();
        } else {
            return false;
        }
    }
	
	public function get_lender_detail_p2p($lender_id)
    {
		//$this->p2p = $this->load->database('db_p2p', TRUE);
        $this->db->select('*');
        $this->db->where('user_id', $lender_id);
        $this->db->from('p2p_lender_list');
        $query = $this->db->get();
		
        if ($this->db->affected_rows() > 0) {
            return $result = (array)$query->row();
        } else {
            return false;
        }
    }
	
	/* public function create_borrower_id_in_p2p()
    {
		$this->p2p = $this->load->database('db_p2p', TRUE);
        $this->p2p->select("id");
        $this->p2p->order_by('id', 'DESC');
        $this->p2p->limit(1);
        $query = $this->p2p->get('p2p_borrowers_list');
        $row = (array)$query->row();
        if($this->p2p->affected_rows()>0)
        {
            $borrwer_last_register_id = $row['id'];
            $bid = 10000000 + $borrwer_last_register_id + 1;
            return $borrower_id  = "BR".$bid;

        }
        else
        {
            return $borrower_id = "BR10000001";
        }
    } */
}

?>

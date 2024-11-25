<?php
class Borrower_social_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->cldb = $this->load->database('credit-line', TRUE);
        $this->app = $this->load->database('app', TRUE);
        $this->money = $this->load->database('money', TRUE);
      
    }

    public function get_borrower_details_credit_line_social_profile($mobile)
    { 
        //echo($mobile); exit;
        $query = $this->cldb->select('SL.borrower_id,
		SL.mobile,
		SL.loan_amount,
		SL.loan_purpose,
		SL.tenure,
		SL.roi,
		bl.name as borrower_name')
		->join('p2p_borrowers_list bl', 'bl.id = SL.borrower_id', 'left')
		->get_where('p2p_borrower_social_loan SL', array('SL.mobile' => $mobile));
        if ($this->cldb->affected_rows() > 0) {
            $result = $query->row_array();
            $_SESSION['borrower_id'] = $result['borrower_id'];
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

    public function insert_lender_data($borrower_id, $submit_amount)
    {  
        $query = $this->db->get_where('p2p_lender_list', array('borrower_id' => $borrower_id));
                  // echo json_encode($query->num_rows()); die();
        if ($query->num_rows() > 0) {
     
        return array('status' => 1, 'msg' => 'Borrower ID already registered');
        } else {
        
        $data = array(
            'borrower_id' => $borrower_id,
            'amount' => $submit_amount,
            'created_date' => date('Y-m-d h:i:s')
        ); 
          $this->db->insert('p2p_lender_list', $data);
            // return $this->db->last_query();
         if ($this->db->affected_rows() > 0) {
            return array('status' => 1, 'msg' => 'Record inserted successfully');
        } 
        else {
            return array('status' => 0, 'msg' => 'Failed to insert record');
         }
    }
    
    }

    public function getDetails($borrower_id){
        $query = $this->db->get_where('p2p_lender_list', array('borrower_id' => $borrower_id));
                  // echo json_encode($query->num_rows()); die();
        if ($query->num_rows() > 0) {
           return $query->row_array();
        
        } else {
            return false;
        }
    }

    //Borrowers registration data KYC
    
    public function borrower_detail_update($borrower_id, $name, $dob, $email, $mobile, $pan, $account, $ifsc)
    {
        
        
        $data = array(
            'name' => $this->input->post('name'),
            'dob' => $this->input->post('dob'),
            'email' => $this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'pan' => $this->input->post('pan'),
            'modified_date' => date('Y-m-d h:i:s')
            
        );
        $this->db->where('borrower_id', $borrower_id);
        $this->db->update('p2p_lender_list', $data);

        $query = $this->db->get_where('p2p_lender_account_info', array('lender_id' => $borrower_id))->row_array();
        // echo "<pre>";
        // print_r($query);die();
        // if($query['lender_id'])
        $this->db->insert('p2p_lender_account_info', array(
            'lender_id' => $borrower_id,
            'account_number' => $this->input->post('account'),
            'ifsc_code' => $this->input->post('ifsc'),
            'created_date' => date('Y-m-d h:i:s'))
        );
        if ($this->db->affected_rows() > 0) {
            return array('status' => 1, 'msg' => 'Record updated successfully');
        } else {
            return array('status' => 0, 'msg' => 'Failed to update record');
        }   

    } 
//Pancard validation
    public function basic_pan_kyc() 
    {
        $postData = $this->input->post();
            $pan_url = "https://antworksmoney.com/credit-line/p2papiborrower/borrowerres/pan_api"; 
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
            'pan' => $postData['pan'],
            'name' => $postData['name'],
            'mode' => 'exact',
            //'anchor'=> $postData['Investent'],
            'mobile'=> $postData['mobile'],
            'user_type' => 'lender',
            'user_id' => $postData['borrower_id'],
            'source' => 'social-lending',
        )),
        CURLOPT_HTTPHEADER => array(
             'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // echo "<pre>";
        // print_r($response); exit;
        return $response;
    }     

// Account Verification
    public function account_validation($details)
    {  // echo "<pre>";
        // print_r($details); exit;
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
            'mobile' => $details['mobile'],
            'name' => $details['name'],
            'account_no' => $details['account_no'],
            'caccount_no' => $details['caccount_no'],
            'ifsc_code' => $details['ifsc_code'],
            //'anchor' => $details['Investent'],
            'user_type' => 'lender',
            'user_id' => $details['user_id'],
            'source' => 'social-lending',
            
        )),
        CURLOPT_HTTPHEADER => array(
            'oath_token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoiMTk3MjA3Iiwic291cmNlIjoiQW50UGF5IiwibW9iaWxlIjoiOTk3MTAyNjY5MSIsImRldmljZV9pZCI6Ik1tSTRZalEzWW1FeU5UVmlNamM1TkE9PSIsImFwcF92ZXJzaW9uIjpudWxsLCJnZW5lcmF0ZWRfdGltZXN0YW1wIjoiMjAyMy0wOS0yMSAxNzo1NToxNSJ9.1-vVd6PjPUwHAlLg9YQNrrKsEjYQaEZm4MhMIbBA3ww',
            'Authorization: Basic YW50QXBwXzIwMjM6QW50X1NlY3VyZSZAMSE2NQ==',
            'Accept-Encoding: -----------*',
            'Content-Type: application/json',
            'Cookie: p2p_2018_2019_session=icnrhnu1a3qjmcsf529gn7idmsn1clum'
        ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }


    public function getProfilepicture($mobile)
    {
        $query = $this->app->get_where('app_user_profile_pic', array('mobile' => $mobile));
        // print_r($query);
        // die();
        // echo $query['profile_pic'];
        // die();
        if ($this->db->affected_rows() > 0) {
            $profile_pic = $query->row();
            //print_r($profile_pic);exit;
			if($profile_pic == ""){
			return array(
                'pic' => 'www.antworksp2p.com/assets/img/social_profile/borrower-pic.png'
            );	
			}
			else{
            $profile_pic_data=$profile_pic->profile_pic;
          
            return array(
                'pic' => 'www.antworksmoney.com/apiserver/profile_images/' . $profile_pic_data
            );
        }
		}
		
		
        
    }

    public function get_score($mob){
        $this->money->where('mobile',$mob);
        $get_score = $this->money->get('all_experian_data')->row_array();
        return $get_score;
    }

    public function getRazorpayRegistrationkeys()
    {
        return $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_registration_api_keys', 'status'=>1))->row()->option_value;
    }
}
?>

<?php
class Login extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Loginmodel');
        $this->load->library('form_validation');
    }

    public function index()
    {
		$input = "dheeraj dutta"; //"aaaaa <script>alert();</script>";
			echo sanitize_input_data($input)."<br>";
      echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function borrower()
    {
        redirect(base_url().'login/user-login');
    }

    public function lender()
    {
        redirect(base_url().'login/user-login');
    }

    public function user_old() // dated: 2023-oct-23 not using now
    {
        $data = array();
        if( $this->session->userdata('borrower_state') && $this->session->userdata('login_type') == 'borrower')
    {
        redirect(base_url().'borrower/dashboard');
    }
        if( $this->session->userdata('login_state') && $this->session->userdata('login_type') == 'lender' )
        {
            redirect(base_url().'lender/dashboard');
        }
        $data['login_failed'] = $this->Loginmodel->validity_ip_base_login_failed();
        if ($data['login_failed']) {
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'You have attempted 3 times with invalid credentials. Please try after some time'));
        }
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $data['salt_key'] = $this->Loginmodel->generateSalt();
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('user-login',$data);
        $this->load->view('templates/footer');
    }


    public function user() // dated: 2023-Oct-23
    {
        $data = array();
        if( $this->session->userdata('borrower_state') && $this->session->userdata('login_type') == 'borrower')
    {
        redirect(base_url().'borrower/dashboard');
    }
        if( $this->session->userdata('login_state') && $this->session->userdata('login_type') == 'lender' )
        {
            redirect(base_url().'lender/dashboard');
        }
        $data['login_failed'] = $this->Loginmodel->validity_ip_base_login_failed();
        if ($data['login_failed']) {
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'You have attempted 3 times with invalid credentials. Please try after some time'));
        }
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $data['salt_key'] = $this->Loginmodel->generateSalt();
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('user-login_otp',$data);
        $this->load->view('templates/footer');
    }
						/***********starting of sendotp***************/
    public function sendLoginOtp() // dated: 2023-oct-23
    {
        $this->load->database();
		 $mobile = sanitize_input_data($_POST['mobile']);
		 $ip_address = $_SERVER['REMOTE_ADDR'];
		// echo $mobile;
        if(!empty($_POST['mobile'])){

            $sql = "SELECT mobile FROM p2p_lender_list WHERE mobile = ".$mobile."
                    UNION
                    SELECT mobile FROM p2p_borrowers_list WHERE mobile = ".$mobile."";
            $this->db->query($sql);
			//echo $this->db->last_query();
            if($this->db->affected_rows()==0)
            {
                echo "User Not Found"; exit(); //Already re
            }
            else{



            $arr=array();
            $number = str_replace("'","",sanitize_input_data($_POST['mobile']));
			//echo $number."--";
            $otp = rand(100000,999999);
			//$otp = '876420';
            $this->db->select('*');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->where('date_added >= now() - INTERVAL 10 MINUTE');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = count($query->result_array());
                if($result>10)
                {
                    echo "Exceeded Max OTP Send Limit"; exit;
                }
                else{
                    $arr["mobile"]=$number;
                    $arr["otp"]=$otp;
                    $arr["source"]='sendLoginOtp';
                    $arr["ip_address"]=$ip_address;
                    $query = $this->db-> insert('p2p_otp_details_table',$arr);
                }

            }
            else{
                $arr["mobile"]=$number;
                $arr["otp"]=$otp;
				$arr["source"]='sendLoginOtp2';
				 $arr["ip_address"]=$ip_address;
                $query = $this->db-> insert('p2p_otp_details_table',$arr);
            }



            //$msg = "Your One Time Password (OTP) for Antworks Money Verify Mobile is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS MONEY";
            $msg = "$otp is your Antworks Account verification code - ANTWORKS";
//            $msg = "Hi (Test Name lenght 10) Your OTP for registering to Antworks Money Credit Doctor service is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKSMONEY.COM";
            $message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => SMS_GATEWAY_USERNAME, 'hash' => SMS_GATEWAY_HASH_API, 'numbers' => $number, "sender" => SMS_GATEWAY_SENDER, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
			$resp = json_decode($response,true);
            // Create session for verifying number
			//	print_r($resp['status']); exit;
            echo "OTP Send Successfully"; exit;
            }
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }
				/***********ending of sendotp***********/

	

				


    public function admin_login()
    {
        if ( $this->session->userdata('admin_state'))
        {
			if($this->session->userdata('role') == "admin"){
				redirect(base_url().'p2padmin/dashboard');
			}
            if($this->session->userdata('role') == "superlender"){
            	redirect(base_url().'superlender/dashboard');
			}
			if($this->session->userdata('role') == "recovery"){
				redirect(base_url().'p2precovery/dashboard');
			}
			if($this->session->userdata('role') == "Teamleader"){
				redirect(base_url().'teamleader/dashboard');
			}
			if($this->session->userdata('role') == "agentrecovery"){
				redirect(base_url().'p2precovery/agentrecovery/dashboard');
			}
        }
        else {

            $data = array();
            $data['login_failed'] = $this->Loginmodel->validity_ip_base_login_failed();
            if ($data['login_failed']) {
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'You have attempted 3 times with invalid credentials. Please try after some time'));
            }
            $data['title'] = 'P2P Lending | Quick and Easy P2P Loan Services in India';
            $data['description'] = "The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
            $data['keywords'] = '';
            $data['salt_key'] = $this->Loginmodel->generateSalt();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/nav', $data);
            $this->load->view('templates/collapse-nav', $data);
            $this->load->view('admin-login', $data);
            $this->load->view('templates/footer');
        }
    }

    public function verify_admin_login()
    {	
		$this->session->sess_regenerate(TRUE); // TRUE means to destroy the old session data		
        $this->load->library('user_agent');
        if ($this->security->xss_clean($this->input->post('user'), TRUE) === FALSE)
        {
            redirect(base_url().'login/admin-login');
        }
        if ($this->security->xss_clean($this->input->post('pwd'), TRUE) === FALSE)
        {
            redirect(base_url().'login/admin-login');
        }
        if($this->input->post('pwd') && $this->input->post('hash_value') && $this->input->post('user')){

            $result=$this->Loginmodel->validateAdmin($this->input->post('user'), $this->input->post('pwd'), $this->input->post('hash_value'));
			if(empty($result)){
			$result=$this->Loginmodel->validateSurgeAdmin($this->input->post('user'), $this->input->post('pwd'), $this->input->post('hash_value'));
			}
            if(!empty($result))
            {
                if($result->status==0)
                {
                    $this->Logout_faild_login_admin();
                }
                else if($result->status==1)
                {
                    $newdata = array(
                        'user_id' 	  => $result->admin_id,
                        'username' 	  => $result->email,
                        'user_name'   => $result->fname,
                        'email'  	  => $result->email,
                        'mobile'      => $result->mobile,
                        'role'        => $result->role_name,
                        'role_id'        => $result->role_id,
                        'admin_state' => TRUE,
						'partner_id' => $result->partner_id,
						'admin_access' => $result->admin_access,
						
                        );

                    //Update SESSION IP
                    //$this->Loginmodel->updateSession_ip();

                    if ($this->agent->is_browser())
                    {
                        $agent = $this->agent->browser().' '.$this->agent->version();
                    }
                    elseif ($this->agent->is_robot())
                    {
                        $agent = $this->agent->robot();
                    }
                    elseif ($this->agent->is_mobile())
                    {
                        $agent = $this->agent->mobile();
                    }
                    else
                    {
                        $agent = 'Unidentified User Agent';
                    }
                    $activity_log = array(
                        'user_login'=>$result->email,
                        'login_date'=> date('Y-m-d H:i:s'),
                        'login_ip'=> $this->input->ip_address(),
                        'browser_type'=>$agent
                    );
                    $this->Loginmodel->activity_login_log($activity_log);
                    $this->session->set_userdata($newdata);
                    $this->session->set_flashdata('init-success',1);

//                    $admin_access_json = $this->db->select('admin_access')->get_where('p2p_admin_role', array('id'=>$result->role_id))->row()->admin_access;
//                    $access_actions_list = json_decode($admin_access_json, true);

//                    echo "<pre>";
//                    print_r($access_actions_list);

					if($result->role_id == 1)
					{
						redirect(base_url().'p2padmin/dashboard');
					}
					if($result->role_id == 2)
					{
						redirect(base_url().'documentmanagement/dashboard');
					}
					if($result->role_id == 3)
					{
						redirect(base_url().'p2precovery/dashboard');
					}
					if($result->role_id == 4)
					{
						redirect(base_url().'p2padmin/mis/');
					}
					if($result->role_id == 5)
					{
						redirect(base_url().'superlender/dashboard');
					}
					if($result->role_id == 8)
					{
						redirect(base_url().'teamleader/dashboard');
					}
					if($result->role_id == 9)
					{
						redirect(base_url().'p2precovery/agentrecovery/dashboard');
					}
					
					if($result->role_id == 10)
					{
						redirect(base_url().'surgeModuleP2P/surge/dashboard');
					}
					
					if($result->role_id == 11)
					{
						redirect(base_url().'surgeModuleP2P/surge/dashboard');
					}
					if($result->role_id == 12)
					{
						redirect(base_url().'surgeModuleP2P/surge/dashboard');
					}

                }

            }
            else
            {

                if ($this->agent->is_browser())
                {
                    $agent = $this->agent->browser().' '.$this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                    $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                    $agent = $this->agent->mobile();
                }
                else
                {
                    $agent = 'Unidentified User Agent';
                }

                $activity_log = array(
                    'user_login'=>$this->input->post('user'),
                    'login_attempt_ip'=> $this->input->ip_address(),
                    'browser_type'=>$agent
                );

                $this->Loginmodel->failed_activity_login_log($activity_log);

                $this->Logout_faild_login_admin();
            }
        }
        else{
            if ($this->agent->is_browser())
            {
                $agent = $this->agent->browser().' '.$this->agent->version();
            }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }
            $activity_log = array(
                'user_login'=>$this->input->post('user'),
                'login_attempt_ip'=> $this->input->ip_address(),
                'browser_type'=>$agent
            );
            $this->Loginmodel->failed_activity_login_log($activity_log);

            $this->Logout_faild_login_admin();
        }
    }


 /**
     * For Both Borrower And Lender
     */
    public function verify_user_login_by_otp() // dated: 2023-oct-23
    {
		$this->session->sess_regenerate(TRUE); // TRUE means to destroy the old session data dated: 19-September-2023
        $this->load->library('user_agent');
        if ($this->security->xss_clean($this->input->post('mobile'), TRUE) === FALSE)
        {
            redirect(base_url().'login/login');
        }
        if ($this->security->xss_clean($this->input->post('otp'), TRUE) === FALSE)
        {
            redirect(base_url().'login/login');
        }
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        $this->form_validation->set_rules('otp', 'OTP', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $mobile = $this->db->escape_str($this->input->post('mobile'));
            $otp = $this->db->escape_str($this->input->post('otp'));
            $hash = $this->db->escape_str($this->input->post('hash_value'));
            if(!empty($mobile) && !empty($otp) && !empty($hash) ){
                $result = $this->Loginmodel->validate_by_mobile($mobile, $otp, $hash);
				//echo "hello".$result; die();
				//print_r($result); die();
                if(!empty($result))
                {

                    if($result['status'] === '1')
                    {
                        $this->Loginmodel->updateSession_ip($result['email']);
                        if ($this->agent->is_browser())
                        {
                            $agent = $this->agent->browser().' '.$this->agent->version();
                        }
                        elseif ($this->agent->is_robot())
                        {
                            $agent = $this->agent->robot();
                        }
                        elseif ($this->agent->is_mobile())
                        {
                            $agent = $this->agent->mobile();
                        }
                        else
                        {
                            $agent = 'Unidentified User Agent';
                        }
                        $activity_log = array(
                            'user_login'=>$result['email'],
                            'login_date'=> date('y-m-d H:i:s'),
                            'login_ip'=> $this->input->ip_address(),
                            'browser_type'=>$agent
                        );
                        $this->Loginmodel->activity_login_log($activity_log);
                        $this->session->set_userdata($result);
                        $this->session->set_flashdata('init-success',1);
                        if($result['login_type'] === 'borrower')
                        {
                            redirect(base_url().'borrowerprocess/checking-steps');
                        }
                        else if($result['login_type'] === 'lender'){
                            redirect(base_url().'lenderprocess/checking_steps');
                        }
                        else{
                            ////Logout
                        }

                    }
                    else{
                        //Notification
                        $this->Logout_faild_login();
                    }
                }
                else
                {
                    if ($this->agent->is_browser())
                    {
                        $agent = $this->agent->browser().' '.$this->agent->version();
                    }
                    elseif ($this->agent->is_robot())
                    {
                        $agent = $this->agent->robot();
                    }
                    elseif ($this->agent->is_mobile())
                    {
                        $agent = $this->agent->mobile();
                    }
                    else
                    {
                        $agent = 'Unidentified User Agent';
                    }
                    $activity_log = array(
                        'user_login'=>$this->input->post('user'),
                        'login_attempt_ip'=> $this->input->ip_address(),
                        'browser_type'=>$agent
                    );

                    $this->Loginmodel->failed_activity_login_log($activity_log);

                    $this->load->helper('cookie');
                    $cookie = array(
                        'name'   => 'Array',
                        'value'  => '',
                        'expire' => '0'
                    );
                    delete_cookie($cookie);
                    //$this->Logout_faild_login();
                    $this->session->set_flashdata('notification',array('error'=>1,'message'=>'Incorrect Credentials! Please try again.'));
                    redirect(base_url().'login/user-login');
                }
            }
            else
            {
                if ($this->agent->is_browser())
                {
                    $agent = $this->agent->browser().' '.$this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                    $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                    $agent = $this->agent->mobile();
                }
                else
                {
                    $agent = 'Unidentified User Agent';
                }
                $activity_log = array(
                    'user_login'=>$this->input->post('user'),
                    'login_attempt_ip'=> $this->input->ip_address(),
                    'browser_type'=>$agent
                );
                $this->Loginmodel->failed_activity_login_log($activity_log);
                //$this->Logout_faild_login();
                $this->load->helper('cookie');
                $cookie = array(
                    'name'   => 'Array',
                    'value'  => '',
                    'expire' => '0'
                );
                delete_cookie($cookie);
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>'Please enter valid parameter'));
                redirect(base_url().'login/user-login');
            }
        }
        else{
            if ($this->agent->is_browser())
            {
                $agent = $this->agent->browser().' '.$this->agent->version();
            }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }
            $activity_log = array(
                'user_login'=>$this->input->post('user')?$this->input->post('user'):'',
                'login_attempt_ip'=> $this->input->ip_address(),
                'browser_type'=>$agent
            );
            $this->Loginmodel->failed_activity_login_log($activity_log);
            //$this->Logout_faild_login();
            $this->load->helper('cookie');
            $cookie = array(
                'name'   => 'Array',
                'value'  => '',
                'expire' => '0'
            );
            delete_cookie($cookie);
            $errmsg = $this->form_validation->error_array();
            $this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
            redirect(base_url().'login/user-login');
        }

    }


    /**
     * For Both Borrower And Lender
     */
    public function verify_user_login()
    {
		$this->session->sess_regenerate(TRUE); // TRUE means to destroy the old session data dated: 19-September-2023
        $this->load->library('user_agent');
        if ($this->security->xss_clean($this->input->post('user'), TRUE) === FALSE)
        {
            redirect(base_url().'login');
        }
        if ($this->security->xss_clean($this->input->post('pwd'), TRUE) === FALSE)
        {
            redirect(base_url().'login');
        }
        $this->form_validation->set_rules('user', 'Email ID', 'required|valid_email');
        $this->form_validation->set_rules('pwd', 'Password', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $username = $this->db->escape_str($this->input->post('user'));
            $password = $this->db->escape_str($this->input->post('pwd'));
            $hash = $this->db->escape_str($this->input->post('hash_value'));
            if(!empty($username) && !empty($password) && !empty($hash) ){
                $result = $this->Loginmodel->validate($username, $password, $hash);
                if(!empty($result))
                {

                    if($result['status'] === '1')
                    {
                        $this->Loginmodel->updateSession_ip($result['email']);
                        if ($this->agent->is_browser())
                        {
                            $agent = $this->agent->browser().' '.$this->agent->version();
                        }
                        elseif ($this->agent->is_robot())
                        {
                            $agent = $this->agent->robot();
                        }
                        elseif ($this->agent->is_mobile())
                        {
                            $agent = $this->agent->mobile();
                        }
                        else
                        {
                            $agent = 'Unidentified User Agent';
                        }
                        $activity_log = array(
                            'user_login'=>$result['email'],
                            'login_date'=> date('y-m-d H:i:s'),
                            'login_ip'=> $this->input->ip_address(),
                            'browser_type'=>$agent
                        );
                        $this->Loginmodel->activity_login_log($activity_log);
                        $this->session->set_userdata($result);
                        $this->session->set_flashdata('init-success',1);
                        if($result['login_type'] === 'borrower')
                        {
                            redirect(base_url().'borrowerprocess/checking-steps');
                        }
                        else if($result['login_type'] === 'lender'){
                            redirect(base_url().'lenderprocess/checking_steps');
                        }
                        else{
                            ////Logout
                        }

                    }
                    else{
                        //Notification
                        $this->Logout_faild_login();
                    }
                }
                else
                {
                    if ($this->agent->is_browser())
                    {
                        $agent = $this->agent->browser().' '.$this->agent->version();
                    }
                    elseif ($this->agent->is_robot())
                    {
                        $agent = $this->agent->robot();
                    }
                    elseif ($this->agent->is_mobile())
                    {
                        $agent = $this->agent->mobile();
                    }
                    else
                    {
                        $agent = 'Unidentified User Agent';
                    }
                    $activity_log = array(
                        'user_login'=>$this->input->post('user'),
                        'login_attempt_ip'=> $this->input->ip_address(),
                        'browser_type'=>$agent
                    );

                    $this->Loginmodel->failed_activity_login_log($activity_log);

                    $this->load->helper('cookie');
                    $cookie = array(
                        'name'   => 'Array',
                        'value'  => '',
                        'expire' => '0'
                    );
                    delete_cookie($cookie);
                    //$this->Logout_faild_login();
                    $this->session->set_flashdata('notification',array('error'=>1,'message'=>'Incorrect Credentials! Please try again.'));
                    redirect(base_url().'login/user-login');
                }
            }
            else
            {
                if ($this->agent->is_browser())
                {
                    $agent = $this->agent->browser().' '.$this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                    $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                    $agent = $this->agent->mobile();
                }
                else
                {
                    $agent = 'Unidentified User Agent';
                }
                $activity_log = array(
                    'user_login'=>$this->input->post('user'),
                    'login_attempt_ip'=> $this->input->ip_address(),
                    'browser_type'=>$agent
                );
                $this->Loginmodel->failed_activity_login_log($activity_log);
                //$this->Logout_faild_login();
                $this->load->helper('cookie');
                $cookie = array(
                    'name'   => 'Array',
                    'value'  => '',
                    'expire' => '0'
                );
                delete_cookie($cookie);
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>'Please enter valid parameter'));
                redirect(base_url().'login/user-login');
            }
        }
        else{
            if ($this->agent->is_browser())
            {
                $agent = $this->agent->browser().' '.$this->agent->version();
            }
            elseif ($this->agent->is_robot())
            {
                $agent = $this->agent->robot();
            }
            elseif ($this->agent->is_mobile())
            {
                $agent = $this->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }
            $activity_log = array(
                'user_login'=>$this->input->post('user')?$this->input->post('user'):'',
                'login_attempt_ip'=> $this->input->ip_address(),
                'browser_type'=>$agent
            );
            $this->Loginmodel->failed_activity_login_log($activity_log);
            //$this->Logout_faild_login();
            $this->load->helper('cookie');
            $cookie = array(
                'name'   => 'Array',
                'value'  => '',
                'expire' => '0'
            );
            delete_cookie($cookie);
            $errmsg = $this->form_validation->error_array();
            $this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
            redirect(base_url().'login/user-login');
        }

    }

    /**
     * Request New Password For Lender And Borrower
     */
    public function requestnewpassword()
    {
        if ($this->security->xss_clean($this->input->post('user'), TRUE) === FALSE)
        {
            redirect(base_url().'login/user-login');
        }
        $this->form_validation->set_rules('user', 'Email ID', 'required|valid_email');
        if ($this->form_validation->run() == TRUE){
           $result = $this->Loginmodel->requestnewpassword();
           if($result)
           {
               $this->session->set_flashdata('notification', array('error' => 0, 'message' => 'Link to reset your password is sent to your registered email. Please follow the link to change your password'));
               redirect(base_url().'login/user-login');
           }
           else{
               $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'Your email is delivered successfully'));
               redirect(base_url().'login/user-login');
           }
        }
        else{
            $errmsg = $this->form_validation->error_array();
            $this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
            redirect(base_url().'login/user-login');
        }
    }


    public function Logout_faild_login()
    {

        error_reporting(E_ALL);
        $this->load->helper('cookie');
        $cookie = array(
            'name'   => 'Array',
            'value'  => '',
            'expire' => '0'
        );
        delete_cookie($cookie);
        redirect(base_url().'login/user-login');
    }

    public function Logout_faild_login_admin()
    {

        error_reporting(E_ALL);
        $this->load->helper('cookie');
        $cookie = array(
            'name'   => 'Array',
            'value'  => '',
            'expire' => '0'
        );
        delete_cookie($cookie);
        redirect(base_url().'login/admin-login');
    }

    public function Logout()
    {
        error_reporting(0);
        $this->Loginmodel->update_activity_login_log();
        $this->session->sess_destroy();
        $this->load->helper('cookie');
        $cookie = array(
            'name'   => 'Array',
            'value'  => '',
            'expire' => '0'
        );
        delete_cookie($cookie);
        redirect(base_url().'login/user-login');
    }

    public function Logoutadmin()
    {
        error_reporting(0);
        $this->Loginmodel->update_activity_login_log();
        $this->session->sess_destroy();
        $this->load->helper('cookie');
        $cookie = array(
            'name'   => 'Array',
            'value'  => '',
            'expire' => '0'
        );
        delete_cookie($cookie);
        redirect(base_url().'login/admin-login');
    }

    public function sha()
    {
        $pass = '12345';
        echo hash('sha512', $pass); exit;
    }

    public function change_password()
    {
       $verify_hash = $this->input->get('verify-hash');
       $hash = $this->input->get('hash');
       $token = $this->input->get('token');

       $verify_token = $this->Loginmodel->verify_token_change_password($verify_hash, $hash, $token);
       if($verify_token)
       {
           $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
           $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
           $data['keywords']='';
           $data['salt_key'] = $this->Loginmodel->generateSalt();
           $this->load->view('templates/header',$data);
           $this->load->view('templates/nav',$data);
           $this->load->view('templates/collapse-nav',$data);
           $this->load->view('change-password',$data);
           $this->load->view('templates/footer');
       }
       else{

       }

    }

    public function action_change_password()
    {

        $this->load->library('user_agent');
        if ($this->security->xss_clean($this->input->post('pwd'), TRUE) === FALSE)
        {
            redirect(base_url().'login');
        }
        if ($this->security->xss_clean($this->input->post('cpwd'), TRUE) === FALSE)
        {
            redirect(base_url().'login');
        }
        $this->form_validation->set_rules('pwd', 'Password', 'required');
        $this->form_validation->set_rules('cpwd', 'Confirm Password', 'required|matches[pwd]');
        $this->form_validation->set_rules('verify_hash', 'verify Hash', 'required');
        $this->form_validation->set_rules('hash', 'Hash', 'required');
        $this->form_validation->set_rules('token', 'Token', 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $result = $this->Loginmodel->change_user_password($this->input->post('verify_hash'), $this->input->post('hash'), $this->input->post('token'));
            if($result)
            {
                $msg = "Your Password is successfully updated. Please login with new password";
                $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
                redirect(base_url().'login/user-login');
            }
            else{

                $msg = "OOPS! Something went wrong please check you credential and try again";
                $this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$msg));
                redirect(base_url().'user/change-password/?verify-hash='.$this->input->post('verify_hash').'&hash='.$this->input->post('hash').'&token='.$this->input->post('token').'
            
            ');
            }

        }
        else{
            $this->load->helper('cookie');
            $cookie = array(
                'name'   => 'Array',
                'value'  => '',
                'expire' => '0'
            );
            delete_cookie($cookie);
            $errmsg = $this->form_validation->error_array();
            $this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
            redirect(base_url().'user/change-password/?verify-hash='.$this->input->post('verify_hash').'&hash='.$this->input->post('hash').'&token='.$this->input->post('token').'
            
            ');
        }

    }
}
?>

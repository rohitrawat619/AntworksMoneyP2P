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

    public function user()
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
        redirect(base_url().'login/user-login');
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

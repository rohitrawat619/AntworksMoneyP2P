<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 * 
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

class Auth extends REST_Controller
{
    public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('Login/Loginmodel');
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function token_post()
    {
        $headers = $this->input->request_headers();

        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $_POST = json_decode(file_get_contents('php://input'), true);
                if ($this->security->xss_clean($this->input->post('user'), TRUE) === FALSE)
                {

                }
                if ($this->security->xss_clean($this->input->post('pwd'), TRUE) === FALSE)
                {

                }
                $this->form_validation->set_rules('user', 'Email ID', 'required|valid_email');
                $this->form_validation->set_rules('pwd', 'Password', 'required');
                $this->form_validation->set_rules('salt_key', 'SALT KEY', 'required');

                if ($this->form_validation->run() == TRUE)
                {
                    $username = $this->db->escape_str($this->input->post('user'));
                    $password = $this->db->escape_str($this->input->post('pwd'));
                    $hash = $this->db->escape_str($this->input->post('salt_key'));
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
                                $tokenData = array();
                                $tokenData['borrower_id'] = $result['borrower_id'];
                                $output['token'] = AUTHORIZATION::generateToken($tokenData);
                                $output['user_type']= 'borrower';
                                $this->set_response($output, REST_Controller::HTTP_OK);
                                return;
                            }
                            if($result['login_type'] === 'lender'){
                                $tokenData = array();
                                $tokenData['lender_id'] = $result['user_id'];
                                $output['token'] = AUTHORIZATION::generateToken($tokenData);
                                $output['user_type']= 'lender';
                                $this->set_response($output, REST_Controller::HTTP_OK);
                                return;
                            }
                        }
                        else{
                            $errmsg = array(
                                'status'=>0,
                                "error_msg"=>"Your email not verified please verified your email",
                            );
                            $this->set_response($errmsg, REST_Controller::HTTP_OK);
                            return;
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
                        $errmsg = array(
                            'status'=>0,
                            "error_msg"=>"Please enter valid parameter",
                        );
                        $this->set_response($errmsg, REST_Controller::HTTP_OK);
                        return;
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
                    $errmsg = array(
                        'status'=>0,
                        "error_msg"=>validation_errors(),
                    );
                    $this->set_response($errmsg, REST_Controller::HTTP_OK);
                    return;
                }

            }
        }

        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function getSaltkey_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false) {
                $salt_key = $this->Loginmodel->generateSalt();

                    if($salt_key)
                    {
                        $msg = array(
                            "status"=>1,
                            "salt_key"=>$salt_key,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            "status"=>0,
                            "salt_key"=>0,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function validate()
    {

    }
}

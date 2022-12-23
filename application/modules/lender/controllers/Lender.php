<?php
class Lender extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Lendermodelbackend', 'Requestmodel'));
		if($this->session->userdata('all_steps_complete') != 1)
		{
			redirect(base_url().'lenderprocess/checking-steps/');
		}
		error_reporting(0);
    }

    public function dashboard()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $this->check_lender_registration_payment();
            $data['notifications'] = $this->Lendermodelbackend->notification();
            $this->load->model('borrower/Borrowermodelbackend');
            $data['liveproposal'] = $this->Borrowermodelbackend->liveProposal();
            $data['liveBorrower'] = $this->Lendermodelbackend->liveBorrower();
            $data['totalbidrecieved'] = $this->Borrowermodelbackend->totalBidrecieved();
            $data['totalAvgintrestrate'] = $this->Borrowermodelbackend->totalAvgintrestrate();
            $data['totalLivebids'] = $this->Lendermodelbackend->totalLivebids();
                $data['title'] = "Lender Dashboard";
                $this->load->view('templates-lender/header',$data);
                $this->load->view('templates-lender/nav',$data);
                $this->load->view('dashboard',$data);
                $this->load->view('templates-lender/footer',$data);

        }
        else
        {
            $msg="Login Failed, Something went wrong please check you credential and try again.";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function profile()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $data['profileinfo'] = $this->Lendermodelbackend->get_lender_info();
            $data['last_login_time'] = $this->Requestmodel->lastLogintime($this->session->userdata('email'));
            $data['selfiImage'] = $this->Lendermodelbackend->lenderProfilepic($this->session->userdata('user_id'));
            $data['pageTitle'] = "My Profile";
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('profile',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Something went wrong!";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function update_profile()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $result = $this->Lendermodelbackend->update_lender_profile();
            if($result)
            {
                $msg="Your Profile is updated successfully";
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                redirect(base_url().'lender/profile');
            }
            else{
                $msg="OOPS! Something went wrong please check you credential and try again";
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                redirect(base_url().'lender/profile');
            }
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function check_lender_registration_payment()
    {

        $result = $this->Lendermodelbackend->check_lender_payment_registration();
        if($result)
        {
            return true;
        }
        else{
            redirect(base_url().'lenderprocess/payment');
        }
    }

    public function pendingbid()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $data['pageTitle'] = "Pending for Borrower acceptance";
            $data['pendingbids'] = $this->Lendermodelbackend->pendingbid();
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('pending-bids',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function successfullbids()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $data['pageTitle'] = "Pending for loan agreement";
            $data['successfullbids'] = $this->Lendermodelbackend->successfullbids();
//            echo "<pre>";
//            print_r($data['successfullbids']); exit;
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('successful-bids',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function acceptedbids()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $data['pageTitle'] = "Accepted bids";
            $data['successfullbids'] = $this->Lendermodelbackend->acceptedbids();
//            echo "<pre>";
//            print_r($data['successfullbids']); exit;
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('successful-bids',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function unsuccessfullbids()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
            $data['pageTitle'] = "Unsuccessful bids";
            $data['unsuccessfullbids'] = $this->Lendermodelbackend->unsuccessfullbids();
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('unsuccessful-bids',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function pay_in()
    {
    	if ( $this->session->userdata('login_state') == TRUE )
        {
			$result_keys = $this->Requestmodel->getRazorpayFundingkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$api_key = $keys['razorpay_Testkey']['key'];
				$api_secret = $keys['razorpay_Testkey']['secret_key'];
			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){
				$api_key = $keys['razorpay_razorpay_Livekey']['key'];
				$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
			}
			$data['pageTitle'] = "Pay IN";
			$data['api_key'] = $api_key;

            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('fund-transfer/pay_in',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function pay_out()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
			$this->load->model('Lenderaccountmodel');
			$data['avilable_amount'] = $this->Lenderaccountmodel->amountAvilabletoPayout();
			$data['bank_details'] = $this->Lendermodelbackend->get_lender_bank_details();
            $data['pageTitle'] = "Pay OUT";
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('fund-transfer/pay_out',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }


    public function help_center()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			$data['pageTitle'] = "Help Center !!";
			$this->load->view('templates-lender/header',$data);
			$this->load->view('templates-lender/nav',$data);
			$this->load->view('help_center',$data);
			$this->load->view('templates-lender/footer');
		}
		else
		{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/lender');
		}
	}

	public function help()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required|regex_match[/^[6-9]\d{9}$/]');
		$this->form_validation->set_rules('subject', 'subject', 'trim|required');
		$this->form_validation->set_rules('message', 'message', 'trim|required');
		if ($this->form_validation->run() == TRUE)
		{
		  $help = array(
		   	'lender_id'=>$this->session->userdata('user_id'),
		   	'type'=>'help',
		   	'request_data'=>json_encode($_POST, true),
		   );
           $this->db->insert('p2p_lender_requests', $help);
           if($this->db->affected_rows()>0)
		   {
			   $this->session->set_flashdata('notification',array('error'=>1,'message'=>"Your request accepted"));
			   redirect(base_url().'lender/help-center');
		   }
           else{
			   $errmsg = "Something went wrong";
			   $this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
			   redirect(base_url().'lender/help-center');
		   }
		}
		else{
			$errmsg = validation_errors();
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$errmsg));
			redirect(base_url().'lender/help-center');
		}
	}
}
?>

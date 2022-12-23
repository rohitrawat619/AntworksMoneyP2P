<?php
class Borrowerrequest extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrowermodelbackend');
        if($this->session->userdata('all_steps_complete') != 1)
        {
            $this->checkborrowerSteps();
        }
        $this->load->library('form_validation');

    }

    public function index()
    {
        redirect(base_url().'borrower/dashboard');
    }

    public function change_address()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->load->model('Requestmodel');
            $data['current_address'] = $this->Borrowermodelbackend->getAdddress();
            //$data['previous_request'] = $this->Borrowermodelbackend->previousRequestChengeaddress();
            $data['states'] = $this->Requestmodel->get_state();
            $data['pageTitle'] = "Address Change";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('change-address',$data);
            $this->load->view('template-borrower/footer',$data);
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function kyc_updation()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $data['doc'] = $this->Borrowermodelbackend->borrowerDoc();
            $data['pageTitle'] = "Kyc Updation";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('kyc-updation',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function make_payment()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
        	$this->load->model('Requestmodel');
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$data['api_key'] = $keys['razorpay_Testkey']['key'];
			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){
				$data['api_key'] = $keys['razorpay_razorpay_Livekey']['key'];
			}

            $data['emi_details'] = $this->Borrowermodelbackend->getEmipayment();
			$data['pageTitle'] = "Make Payment";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('make-payment',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function closer_request()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
			$this->load->model('Requestmodel');
			$result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
			$keys = (json_decode($result_keys, true));
			if($keys['razorpay_Testkey']['status'] == 1)
			{
				$data['api_key'] = $keys['razorpay_Testkey']['key'];
			}
			if ($keys['razorpay_razorpay_Livekey']['status'] == 1){
				$data['api_key'] = $keys['razorpay_razorpay_Livekey']['key'];
			}
			$data['foreclosure_details'] = $this->Borrowermodelbackend->getForeclosurepayment();
            $data['pageTitle'] = "Closer Request";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('closer-request',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function e_nach()
    {
        
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->check_borrower_registration_payment();
            $data['pageTitle'] = "E Nach";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            
            $this->load->view('e-nach',$data);
            $this->load->view('template-borrower/footer',$data);
            
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function check_borrower_registration_payment()
    {
        $result = $this->Borrowermodelbackend->check_borrower_payment_registration();
        if($result)
        {
            return true;
        }
        else{
              redirect(base_url().'borrowerprocess/payment');
        }
    }

    public function checkborrowerSteps()
    {
        if ( $this->session->userdata('borrower_state') == TRUE ) {
            $result = $this->Borrowermodelbackend->check_p2p_process();
            if (in_array('0', $result)) {
                redirect(base_url() . 'borrowerprocess/checking-steps');
            } else {
                $data = array(
                    'all_steps_complete'=>1,
                );
                $this->session->set_userdata($data);

            }
        }
    }

    public function loanrestructuring()
	{
		if ( $this->session->userdata('borrower_state') == TRUE )
		{
            $data['loan_list'] = $this->Borrowermodelbackend->loanRestructuring();

			$data['pageTitle'] = "Loan Restructuring";
			$this->load->view('template-borrower/header',$data);
			$this->load->view('template-borrower/nav',$data);
			$this->load->view('loan/loan-restructuring',$data);
			$this->load->view('template-borrower/footer',$data);
		}
		else
		{
			redirect(base_url().'login/borrower');
		}
	}

	public function e_kyc(){
		if ( $this->session->userdata('borrower_state') == TRUE ){
			$data['pageTitle'] = "E Kyc";
			$this->load->view('template-borrower/header', $data);
			$this->load->view('template-borrower/nav', $data);
			$this->load->view('request/e-kyc', $data);
			$this->load->view('template-borrower/footer', $data);
		}
		else
		{
			redirect(base_url().'login/borrower');
		}

	}

    public function change_bank_details()
    {
        if ( $this->session->userdata('borrower_state') == TRUE )
        {

            $this->load->model('Requestmodel');
            $data['bank_details'] = $this->Borrowermodelbackend->get_bank_details();
            $data['pageTitle'] = "Bank Details";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('request/request-change-bank-details',$data);
            $this->load->view('template-borrower/footer',$data);
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function change_pan_no()
    {
        if ( $this->session->userdata('borrower_state') == TRUE )
        {
            $this->load->model('Requestmodel');
            $data['current_address'] = $this->Borrowermodelbackend->getAdddress();
            //$data['previous_request'] = $this->Borrowermodelbackend->previousRequestChengeaddress();
            $data['states'] = $this->Requestmodel->get_state();
            $data['pageTitle'] = "Address Change";
            $this->load->view('template-borrower/header',$data);
            $this->load->view('template-borrower/nav',$data);
            $this->load->view('change-address',$data);
            $this->load->view('template-borrower/footer',$data);
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function action_request_change_bank()
    {
        if ($this->session->userdata('borrower_state') == TRUE) {
            if ($this->input->post('borrower_id') <> $this->session->userdata('borrower_id'))
            {
                $msg = "Something went wrong please try again";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url().'borrower/borrowerrequest/change_bank_details');
            }
            $this->form_validation->set_rules('account_no', 'Account no', 'trim|required');
            $this->form_validation->set_rules('caccount_no', 'Conform account no', 'trim|required|matches[account_no]');
            $this->form_validation->set_rules('ifsc_code', 'Ifsc Code', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                //$sql = "select id from p2p_borrower_bank_res ";
                $data = json_encode(
                    array(
                        "fund_account" => array(
                            "account_type" => 'bank_account',
                            "bank_account" => array(
                                "name" => $this->session->userdata('name'),
                                "ifsc" => $this->input->post('ifsc_code'),
                                "account_number" => $this->input->post('account_no'),
                            ),
                        ),
                        "amount" => "100",
                        "currency" => "INR",
                        "notes" => array(
                            "random_key_1" => "",
                            "random_key_2" => "",
                        ),
                    )
                );
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $data,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json",
                        "authorization: Basic cnpwX2xpdmVfUGVaVElwMXNDcGhvWmQ6dkN5TWVuajhTZlFoNXdlUFJqNThiWG5v",
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    ///alert emil to admin
                } else {
                    $res = json_decode($response, true);
                    $bank_res = array(
                        'borrower_id'=>$this->session->userdata('borrower_id'),
                        'fav_id'=>$res['id']?$res['id']:'',
                        'razorpay_response_bank_ac'=>$response,
                    );
                    $this->db->insert('p2p_borrower_bank_res', $bank_res);
                    if($res['id'])
                    {
                        $bank_data = array(
                            'borrower_id'=>$this->session->userdata('borrower_id'),
//							'bank_name'=>$this->session->userdata('name'),
                            'account_number'=>$this->input->post('account_no'),
                            'ifsc_code'=>$this->input->post('ifsc_code'),
                            'is_verified'=>0,
                        );
                        $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
                        $this->db->update('p2p_borrower_bank_details', $bank_data);
                        $msg = "Bank Details Update Successfully";
                        $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                        redirect(base_url().'borrower/borrowerrequest/change_bank_details');
                    }
                    else{
                        $msg = "Incorrect information, please check your details";
                        $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                        redirect(base_url().'borrower/borrowerrequest/change_bank_details');
                    }
                }
            }
            else{
                $msg = "Incorrect information, please check your details";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url().'borrower/borrowerrequest/change_bank_details');
            }

        } else
        {
            redirect(base_url().'login/borrower');
        }
    }
}
?>

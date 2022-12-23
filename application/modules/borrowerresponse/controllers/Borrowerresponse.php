<?php
class Borrowerresponse extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrowerresponsemodel');
        $this->load->model('p2padmin/Sendemailborrowermodel');
    }

    public function payment_response()
    {

        if ( $this->session->userdata('borrower_state') == TRUE ) {
            $reponse = array(
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
			if ($this->input->post('razorpay_payment_id') && $this->input->post('razorpay_order_id') && $this->input->post('razorpay_signature')) {
				$this->load->model('Requestmodel');
				$result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
				$keys = (json_decode($result_keys, true));
				if ($keys['razorpay_Testkey']['status'] == 1) {
					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
				}
				if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {
					$api_key = $keys['razorpay_razorpay_Livekey']['key'];
					$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
				}
				$hasing_value = $this->input->post('razorpay_order_id') . "|" . $this->input->post('razorpay_payment_id');
				$generated_signature = hash_hmac('SHA256', $hasing_value, $api_secret);
				if ($generated_signature == $this->input->post('razorpay_signature')) {
					$result = $this->Borrowerresponsemodel->insert_transaction_payment();
					if ($result) {
						$borrowerId = $this->session->userdata('borrower_id');
						$email = $this->session->userdata('email');
						$name = $this->session->userdata('name');
						$mobile = $this->session->userdata('mobile');
						$this->Sendemailborrowermodel->registrationPaymentConfirmation($borrowerId,$name,$email,$mobile);
						$reponse['status'] = 1;
					} else {
						$reponse['status'] = 2;
					}
				}
				else{
					$reponse['status'] = 3;
				}

            } else {
                $reponse['status'] = 3;
            }
            echo json_encode($reponse);
            exit;
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function adduser()
    {
        if ( $this->session->userdata('borrower_state') == TRUE ){
           $loginName = $this->input->post('email');
           $email = $this->input->post('email');
           $password = $this->input->post('password');
           $post_data = array(
               'loginName'=>$loginName,
               'email'=>$email,
               'password'=>$password,
           );
           $data = json_encode($post_data);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.whatsloan.com/v1/bank/regUser",
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
                    "token: 92a7eec0-d8d7-4b5e-8060-3554c2afee6c"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
        }
        else{
            redirect(base_url().'login/borrower');
        }
     }

    public function skip_bank_statement()
    {
        $reponse = array(
            'csrfName' => $this->security->get_csrf_token_name(),
            'csrfHash' => $this->security->get_csrf_hash()
        );
      $this->load->database();
      $this->db->where('borrower_id', $this->session->userdata('borrower_id'));
      $this->db->set('step_6', 3);
      $this->db->update('p2p_borrower_steps');
      if($this->db->affected_rows()>0)
      {
        $reponse['status'] = 1;
      }
      else{
          $reponse['status'] = 1;
      }
      echo json_encode($reponse); exit;
    }

    public function emi_payment_response()
	{
		if ( $this->session->userdata('borrower_state') == TRUE ) {
			$reponse = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash()
			);
			if ($this->input->post('razorpay_payment_id')) {
				$result = $this->Borrowerresponsemodel->updateEmiborrower();
				if ($result) {
					$email = $this->session->userdata('email');
					$name = $this->session->userdata('name');
					$mobile = $this->session->userdata('mobile');
					$borrowerId = $this->session->userdata('id');
					$sendEmail= $this->Sendemailborrowermodel->registrationPaymentConfirmation($borrowerId, $name, $email, $mobile);
					$reponse['status'] = 1;
				} else {
					$reponse['status'] = 2;
				}
			} else {
				$reponse['status'] = 3;
			}
		}
		else{
			$reponse['status'] = 3;
		}
		echo json_encode($reponse);
		exit;
	}

    public function foreclosure_payment_response()
	{
		if ( $this->session->userdata('borrower_state') == TRUE ) {
			$reponse = array(
				'csrfName' => $this->security->get_csrf_token_name(),
				'csrfHash' => $this->security->get_csrf_hash()
			);
			if ($this->input->post('razorpay_payment_id')) {

				$result = $this->Borrowerresponsemodel->updateForeclosureborrower();
				if ($result) {
					$reponse['status'] = 1;
				} else {
					$reponse['status'] = 2;
				}
			} else {
				$reponse['status'] = 3;
			}
		}
		else{
			$reponse['status'] = 3;
		}
		echo json_encode($reponse);
		exit;
	}

	public function couponcode()
	{
		if ( $this->session->userdata('borrower_state') == TRUE ) {
			$this->db->get_where('p2p_resgistration_coupon_code', array('coupon_code' => $this->input->post('coupon_code')));
			if($this->db->affected_rows() > 0)
			{
				$this->db->where('coupon_code', $this->input->post('coupon_code'));
				$this->db->set('count_uses', 'count_uses + 1', false);
				$this->db->update('p2p_resgistration_coupon_code');
				if($this->db->affected_rows() > 0)
				{
					$payment_arr = array(
						'borrower_id' => $this->session->userdata('borrower_id'),
						'razorpay_payment_id' => $this->session->userdata('borrower_generated_id'),
						'channel' => 'Coupon Code',
					);
					$this->db->insert('p2p_borrower_registration_payment', $payment_arr);
					if($this->db->affected_rows() > 0)
					{
						$this->db->where('borrower_id', $this->session->userdata('borrower_id'));
						$this->db->set('step_2', 1);
						$this->db->update('p2p_borrower_steps');
						$response = array('status'=> 1, 'msg' => 'Coupon Code is valid');
					}
					else{
						$response = array('status'=> 0, 'msg' => 'OOPS! Something went wrong please check you credential and try again');
					}
				}
				else{
					$response = array('status'=> 0, 'msg' => 'OOPS! Something went wrong please check you credential and try again');
				}
			}
			else{
				$response = array('status'=> 0, 'msg' => 'Sorry Coupon Code is not valid');
			}
		}
		else{
			$response = array('status'=> 0, 'msg' => 'Your session had expired. Please Re-Login');
		}
		echo json_encode($response); exit;
	}
}
?>

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
class Borrowerinfo extends REST_Controller
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->library('form_validation');
		$this->load->helper(array('form', 'url'));
		$this->load->model(array('Borrowermodel', 'Borrowerinfomodel'));
		$this->load->database();
	}

    public function myPersonalDetails_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;
                //echo $borrowerId; exit;
                if($borrowerId)
                {
                    $response = $this->Borrowerinfomodel->get_personalDetails($borrowerId);

                    if($response)
                    {
                        $msg = array(
                            'status'=>1,
                            'MyPersonalDetails'=>$response,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            'status'=>0,
                            'MyPersonalDetails'=>'Not found'
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function myResidentalDetails_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $response = $this->Borrowerinfomodel->get_residentalDetails($borrowerId);

                    if($response)
                    {
                        $msg = array(
                            'status'=>1,
                            'MyResidentalDetails'=>$response,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            'status'=>0,
                            'MyResidentalDetails'=>'Not found'
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                }
            }
        }

        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function myOccupationDetails_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;

                if($borrowerId)
                {
                    $response = $this->Borrowerinfomodel->get_OccupationDetails($borrowerId);

                    if($response)
                    {
                        $msg = array(
                            'status'=>1,
                            'MyOccupationDetails'=>$response,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            'status'=>0,
                            'MyOccupationDetails'=>'Not found'
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function myAccountDetails_get()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
        {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
            if ($decodedToken != false)
            {
                $borrowerId = $decodedToken->borrower_id;
                if($borrowerId)
                {
                    $response = $this->Borrowerinfomodel->get_accountDetails($borrowerId);

                    if($response)
                    {
                        $msg = array(
                            'status'=>1,
                            'MyAccountDetails'=>$response,
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }
                    else{
                        $msg = array(
                            'status'=>0,
                            'MyAccountDetails'=>'Not found'
                        );
                        $this->set_response($msg, REST_Controller::HTTP_OK);
                        return;
                    }

                }
            }
        }
        $this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function paymentRegistration_get()
	{
		$headers = $this->input->request_headers();
		if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization']))
		{
			$decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
			if ($decodedToken != false)
			{
				$borrowerId = $decodedToken->borrower_id;
				if($borrowerId)
				{
					$this->load->model('Membershipplanmodel');
					$data['membership'] = $this->Membershipplanmodel->checkMembershipplan();
					$this->db->select('id')->get_where('p2p_borrower_steps', array('borrower_id'=>$borrowerId, 'step_2'=>1));
					if($this->db->affected_rows()>0)
					{
						$msg = array(
							'status'=>1,
							'msg'=>'Payment Done'
						);
						$this->set_response($msg, REST_Controller::HTTP_OK);
						return;
					}
					else{
						$msg = array(
							'status'=>0,
							'msg'=>'Payment not found'
						);
						$this->set_response($msg, REST_Controller::HTTP_OK);
						return;
					}
				}
			}
		}
		$this->set_response("Unauthorised", REST_Controller::HTTP_UNAUTHORIZED);
	}
}

?>

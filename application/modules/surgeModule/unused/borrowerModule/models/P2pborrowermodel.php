<?php

class P2pborrowermodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		$this->money=$this->load->database('money', true);
        $this->cldb = $this->load->database('new_p2p_sandbox', TRUE);
        
    }

    public function getBorrowersteps($borrower_id)
    {
        $this->cldb->select('*');
        $this->cldb->from('p2p_borrower_steps');
        $this->cldb->where('borrower_id', $borrower_id);
        $query = $this->cldb->get();
//        echo $this->cldb->last_query(); exit;
        if ($this->cldb->affected_rows() > 0) {
            $result = (array)$query->row();
            if ($result['step_1'] != 1) {
                $arr_msg = array(
                    "status" => 1,
                    "msg" => "Email is not verified",
                );
                return $arr_msg;
            }
            if ($result['step_2'] != 1) {
                $arr_msg = array(
                    "status" => 1,
                    "msg" => "Payment is not done.",
                );
                return $arr_msg;
            }
            if ($result['step_3'] != 1) {
                if ($result['step_3'] == 0) {
                    $arr_msg = array(
                        "status" => 1,
                        "msg" => "Kyc not done",
                    );
                    return $arr_msg;
                }
                if ($result['step_3'] == 2) {
                    $arr_msg = array(
                        "status" => 1,
                        "msg" => "Name not verified as per PAN card",
                    );
                    return $arr_msg;
                }
                if ($result['step_3'] == 3) {
                    $arr_msg = array(
                        "status" => 1,
                        "msg" => "User record not found invalid PAN",
                    );
                    return $arr_msg;
                }


            }
            if ($result['step_5'] != 1) {
                $arr_msg = array(
                    "status" => 1,
                    "msg" => "Experian Step is not complete",
                );
                return $arr_msg;
            }
            if ($result['step_6'] != 2) {
                if ($result['step_6'] == 0) {
                    $arr_msg = array(
                        "status" => 1,
                        "msg" => "Bank verify not done",
                    );
                    return $arr_msg;
                }
                if ($result['step_6'] == 1) {
                    $arr_msg = array(
                        "status" => 1,
                        "msg" => "Bank verify done but statement upload not done",
                    );
                    return $arr_msg;
                }

            }
            if ($result['step_7'] != 1) {

                $arr_msg = array(
                    "status" => 1,
                    "msg" => "Profile Confirmation step not done",
                );
                return $arr_msg;

            }
            if ($result['step_8'] != 1) {

                $arr_msg = array(
                    "status" => 1,
                    "msg" => "Last step is not complete",
                );
                return $arr_msg;

            } else {
                $arr_msg = array(
                    "status" => 1,
                    "msg" => "All steps complete",
                );
                return $arr_msg;
            }
        }
    }

    public function getBorrowerallsteps($borrower_id)
    {
        $this->cldb->where('borrower_id', $borrower_id);
        $query = $this->cldb->get_where('p2p_borrower_steps', array('borrower_id' => $borrower_id));
        if ($this->cldb->affected_rows() > 0) {
            return $query->row_array();
        }
    }

    public function get_count_borrowers()
{
    return $this->cldb->count_all('p2p_borrowers_list');

}


    public function getborrowers($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        // echo $this->cldb->last_query();die();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_1($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where_in('BS.step_1', array('2', '3'));
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('bl.id', 'desc');
        $query = $this->cldb->get();
        
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_2($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_2', 3);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_3($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_3', 2);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_4($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_4', 2);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_5($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_1', 2);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_6($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_6', 2);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function getborrowers_Step_7($pageLimit, $setLimit)
    {
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2
                          ');
        $this->cldb->where('BS.step_7', 2);
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->limit($pageLimit, $setLimit);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function action_update_steps()
    {
        if (isset($_POST['submit_pan']))
        {
            $config['upload_path'] = "./assets/borrower-documents";
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("borrower_pan")) {
                $data = $this->upload->data();
                $file_info = array(
                    'borrower_id' => $this->input->post('borrower_id'),
                    'docs_type' => 'pan',
                    'docs_name' => $data['file_name'],
                    'date_added' => date('Y-m-d H:i:s'),
                );
                $this->cldb->insert('p2p_borrowers_docs_table', $file_info);
            }
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_1', 1);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_video_kyc'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_8', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['skip_video_kyc'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_8', 1);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['skip_video_kyc'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_8', 1);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['skip_credit_decisioning'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_2', 1);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_credit_decisioning'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_2', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_e_nach'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_3', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_e_nach'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_3', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['skip_enach'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_3', 1);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_loan_aggrement'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_4', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_e_sign'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_5', null);
            $this->cldb->update('p2p_borrower_steps');
        }

        if (isset($_POST['reinitiate_disbursement_request'])){
            $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
            $this->cldb->set('step_6', null);
            $this->cldb->update('p2p_borrower_steps');
        }
        $log_steps = array(
            'borrower_id' => $this->input->post('borrower_id'),
            'step' => $this->input->post('step'),
            'remarks' => $this->input->post('remarks'),
        );
        $this->cldb->insert('p2p_borrower_action_remarks_steps', $log_steps);

        return array(
            'status' => 1,
            'msg' => 'Step Update Successfully',
        );

    }

    public function get_borrower_details($borrower_id)
    {
        $this->cldb->select(' 
                           BL.id AS borrower_id,
                           BL.borrower_id AS b_borrower_id,
                           BL.name AS Borrowername, 
                           BL.mobile AS borrower_mobile,
                           BL.email AS borrower_email,
                           BL.pan AS pan,
                           BL.dob AS dob,
                           BL.gender AS gender,
                           BL.occuption_id,
                           BL.highest_qualification,
                           BL.status,
                           PBA.r_address,
                           PBA.r_address1,
                           PBA.r_state,
                           PBA.r_state_name,
                           PBA.r_city,
                           PBA.r_pincode,
                           bod.occuption_type,        
                           bod.company_type,        
                           bod.company_name,        
                           bod.net_monthly_income,        
                           bod.salary_process,
                           BANK.bank_name,                       
                           BANK.account_number,                       
                           BANK.ifsc_code,               
                           BANK.is_verified as is_bank_verified,           
                           BANK.bank_registered_name as bank_registered_name,
                           PD.proposal_id,
                           PD.PLRN,
                           PD.loan_amount,
                           PD.p2p_product_id,
                           PD.prefered_interest_min,
                           PD.prefered_interest_max,
                           PD.min_interest_rate,
                           PD.max_interest_rate,
                           PD.tenor_months,
                           PD.loan_description,
                           PD.bidding_mode,
                           PD.bidding_status,
                           PD.bidding_status,
                           PD.date_added
                           ');
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_proposal_details AS PD', 'ON PD.borrower_id = BL.id', 'left');
        $this->cldb->join('p2p_borrower_address_details AS PBA', 'ON PBA.borrower_id = BL.id', 'left');
        $this->cldb->join('p2p_borrower_occuption_details AS bod', 'ON bod.borrower_id = BL.id', 'left');
        $this->cldb->join('p2p_borrower_bank_details AS BANK', 'ON BANK.borrower_id = BL.id', 'left');
        $this->cldb->where('BL.borrower_id', $borrower_id);
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            $borrower_details = $query->row_array();
            return $borrower_details;
        } else {
            return false;
        }
    }

    public function borrower_basic_filter_response($borrower_id)
    {
        $query = $this->cldb->get_where('borrower_basic_filtration_criteria', array('borrower_id' => $borrower_id));
        if ($this->cldb->affected_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function getPanresponse($borrowerId)
    {
        $query = $this->cldb->order_by('id', 'desc')->get_where('borrower_pan_api_details', array('mobile' => $borrowerId));
        if ($this->cldb->affected_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function credit_decision_response($borrowerId)
    {
        $query = $this->cldb->order_by('id', 'desc')->get_where('ektara_response', array('borrower_id' => $borrowerId));
        if ($this->cldb->affected_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function bankaccountresponse($borrowerId)
    {
        $query = $this->cldb->select('bank_account_response AS response')->order_by('id', 'desc')->get_where('p2p_borrower_bank_details', array('mobile' => $borrowerId));
//        pr($this->cldb->last_query());
        if ($this->cldb->affected_rows() > 0) {
            return $query->row()->response;
        } else {
            return false;
        }
    }

    public function bankaccountresponse_v1($borrowerId)
    {
        $query = $this->cldb->select('razorpay_response_bank_ac AS response')->order_by('id', 'desc')->get_where('p2p_borrower_bank_res', array('mobile' => $borrowerId));
        if ($this->cldb->affected_rows() > 0) {
            return $query->row()->response;
        } else {
            return false;
        }
    }

 /*    public function getExperian_details($borrower_id)
    {
        $this->cldb->select('experian_score, experian_response');
        $this->cldb->from('ant_borrower_rating');
        $this->cldb->where('borrower_id', $borrower_id);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            return (array)$query->row();
        } else {
            return false;
        }
    } */
    public function getExperian_details($mobile)
{
    $this->money->select('score as experian_score');
    $this->money->from('all_experian_data');
    $this->money->where('mobile', $mobile);
    $this->money->order_by('id', 'desc');
    $query = $this->money->get();
    // echo $this->money->last_query(); 
    // die(); 

    if ($query->num_rows() > 0) {
        return $query->row_array();
    } else {
        return false;
    }
}

    public function getBankresponse($borrower_id)
    {
        $sql = "SELECT * FROM p2p_borrowers_docs_table WHERE borrower_id = " . $borrower_id . " AND (docs_type = 'bank_statement' OR docs_type = 'Online_bank_statement') ORDER BY id DESC LIMIT 0,1";
        $query = $this->cldb->query($sql);
        if ($this->cldb->affected_rows() > 0) {
            return (array)$query->row();
        } else {
            return false;
        }
    }

    public function borrowerRequest($borrower_id)
    {
        return false;
    }

    public function acceptborrowerRequest()
    {
        $request_deatils = (array)$this->cldb->get_where('p2p_request_change_address', array('id' => $this->input->post('requestId'), 'borrower_id' => $this->input->post('borrowerId')))->row();
        if ($this->cldb->affected_rows() > 0) {
            $details = json_decode($request_deatils['address_data'], true);
            $arr_address = array(
                'r_address' => $details['r_address'],
                'r_address1' => $details['r_address1'] ? $details['r_address1'] : '',
                'r_city' => $details['r_city'],
                'r_state' => $details['r_state'],
                'r_pincode' => $details['r_pincode'],
            );
            $this->cldb->where('borrower_id', $this->input->post('borrowerId'));
            $this->cldb->update('p2p_borrower_address_details', $arr_address);
            if ($this->cldb->affected_rows() > 0) {
                $this->cldb->where('id', $this->input->post('requestId'));
                $this->cldb->set('accepted_or_not', 1);
                $this->cldb->update('p2p_request_change_address');
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function getEkyc($borrowerId)
    {
        $query = $this->cldb->get_where('p2p_borrower_ekyc', array('borrower_id' => $borrowerId));
        if ($this->cldb->affected_rows() > 0) {
            return (array)$query->row();
        } else {
            return false;
        }
    }

    public function update_borrower_pan()
    {
        $isvalid_request = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Borrower Name', 'trim|required');
        $this->form_validation->set_rules('pan', 'Pan Name', 'trim|required|is_unique[p2p_lender_list.pan]');
        $this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $borrower_details = $this->P2pborrowermodel->get_borrower_details($this->input->post('b_borrower_id'));
            $this->cldb->select('pan')->get_where('p2p_borrowers_list', array('id' => $this->input->post('borrower_id'), 'pan' => $this->input->post('pan')));
            if ($this->cldb->affected_rows() > 0) {
                $isvalid_request = true;
            } else {
                $this->form_validation->set_rules('pan', 'Pan Name', 'trim|required|is_unique[p2p_borrowers_list.pan]');
                if ($this->form_validation->run() == TRUE) {
                    $isvalid_request = true;
                } else {
                    return $pan_response = array(
                        'status' => 0,
                        'msg' => validation_errors(),
                    );
                }

            }

            if ($isvalid_request == true) {
                $dob_explode = explode('-', $this->input->post('dob'));
                $year = $dob_explode[0];
                $month = $dob_explode[1];
                $day = $dob_explode[2];
                $dob = $day . '/' . $month . '/' . $year;
                $arr_borrower = array(
                    'headers' => array(
                        "client_code" => "ANTW3476",
                        "sub_client_code" => "ANTW3476",
                        "channel_code" => "WEB",
                        "channel_verison" => "1",
                        "stan" => strtotime(date('Y-m-d H:i:s')) . uniqid(),
                        "client_ip" => "",
                        "transmission_datetime" => (string)strtotime(date('Y-m-d H:i:s')),
                        "operation_mode" => "SELF",
                        "run_mode" => "TEST",
                        "actor_type" => "TEST",
                        "user_handle_type" => "EMAIL",
                        "user_handle_value" => $borrower_details['borrower_email'],
                        "location" => "NA",
                        "function_code" => "VERIFY_PAN",
                        "function_sub_code" => "DATA"
                    ),

                    'request' => array(
                        'pan_details' => array(
                            "pan_number" => $this->input->post('pan'),
                            "name" => $this->input->post('name'),
                            "dob" => $dob,
                            "document" => ""
                        ),
                    )
                );
                $borrower_pan_json = json_encode($arr_borrower);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://prod.veri5digital.com/service/api/1.0/verifyUserIdDoc ",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $borrower_pan_json,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json"),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    return $pan_response = array(
                        'status' => 0,
                        'msg' => "Curl Error contact to developer",
                    );
                } else {
                    $res = json_decode($response, true);
                }

                // update name and dob according pan
                $borrower_update_details = array(
                    'name' => strtoupper($this->input->post('name')),
                    'dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
                );
                $this->cldb->where('id', $this->input->post('borrower_id'));
                $this->cldb->update('p2p_borrowers_list', $borrower_update_details);
                //Save API Response
                $api_response = array(
                    'borrower_id' => $this->input->post('borrower_id'),
                    'api_name' => 'pan',
                    'response' => $response,
                );

                $this->cldb->insert('p2p_borrower_api_response', $api_response);

                if ($res['response_status']['status'] == "SUCCESS" && $res['verification_status'] == "SUCCESS") {
                    $dataSteps = array(
                        'step_3' => 1,
                        'modified_date' => date('Y-m-d H:i:s'),
                    );
                    $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
                    $this->cldb->update('p2p_borrower_steps', $dataSteps);
                    return $pan_response = array(
                        'status' => 1,
                        'msg' => 'Pan Update Successfully',
                    );
                } else {
                    $dataSteps = array(
                        'step_3' => 3,
                        'modified_date' => date('Y-m-d H:i:s'),
                    );
                    $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
                    $this->cldb->update('p2p_borrower_steps', $dataSteps);
                    return $pan_response = array(
                        'status' => 0,
                        'msg' => 'Pan NOT Valid',
                    );
                }
            }
        } else {
            return $pan_response = array(
                'status' => 0,
                'msg' => validation_errors(),
            );
        }
    }

    public function update_borrower_pan_v2()
    {
        $isvalid_request = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Borrower Name', 'trim|required');
        $this->form_validation->set_rules('pan', 'Pan Name', 'trim|required|is_unique[p2p_lender_list.pan]');
        $this->form_validation->set_rules('dob', 'Date of birth', 'trim|required');
        if ($this->form_validation->run() == TRUE) {
            $borrower_details = $this->P2pborrowermodel->get_borrower_details($this->input->post('b_borrower_id'));
            $this->cldb->select('pan')->get_where('p2p_borrowers_list', array('id' => $this->input->post('borrower_id'), 'pan' => $this->input->post('pan')));
            if ($this->cldb->affected_rows() > 0) {
                $isvalid_request = true;
            } else {
                $this->form_validation->set_rules('pan', 'Pan Name', 'trim|required|is_unique[p2p_borrowers_list.pan]');
                if ($this->form_validation->run() == TRUE) {
                    $isvalid_request = true;
                } else {
                    return $pan_response = array(
                        'status' => 0,
                        'msg' => validation_errors(),
                    );
                }

            }

            if ($isvalid_request == true) {

                $borrower_update_details = array(
                    'name' => strtoupper($this->input->post('name')),
                    'pan' => strtoupper($this->input->post('pan')),
                    'dob' => date('Y-m-d', strtotime($this->input->post('dob'))),
                );
                $this->cldb->where('id', $this->input->post('borrower_id'));
                $this->cldb->update('p2p_borrowers_list', $borrower_update_details);
                return $pan_response = array(
                    'status' => 1,
                    'msg' => 'Pan Update Successfully',
                );
            }
        } else {
            return $pan_response = array(
                'status' => 0,
                'msg' => validation_errors(),
            );
        }
    }

    public function verifyBankdetails()
    {
        if ($this->input->post('borrowerId')) {
            $query = $this->cldb->select('is_verified')->get_where('p2p_borrower_bank_details', array('borrower_id' => $this->input->post('borrowerId')));
            if ($this->cldb->affected_rows() > 0) {
                $is_verified = $query->row()->is_verified;
                if ($is_verified == 1) {
                    $response = array(
                        'status' => 0,
                        'msg' => "Already Active",
                    );
                } else {
                    $query = $this->cldb->select('fav_id')->order_by('id', 'desc')->get_where('p2p_borrower_bank_res', array('borrower_id' => $this->input->post('borrowerId')));
                    if ($this->cldb->affected_rows() > 0) {
                        $this->load->model('Requestmodel');
                        $result_keys = $this->Requestmodel->getRazorpayRepaymentkeys();
                        $keys = (json_decode($result_keys, true));
                        if ($keys['razorpay_Testkey']['status'] == 1) {
                            $api_key = $keys['razorpay_Testkey']['key'];
                            $api_secret = $keys['razorpay_Testkey']['secret_key'];

                        }
                        if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

                            $api_key = $keys['razorpay_razorpay_Livekey']['key'];
                            $api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

                        }
                        $fav_id = $query->row()->fav_id;
                        if ($fav_id) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://api.razorpay.com/v1/fund_accounts/validations/" . $fav_id,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "GET",
                                CURLOPT_USERPWD => $api_key . ':' . $api_secret,
                            ));

                            $response = curl_exec($curl);
                            $err = curl_error($curl);

                            curl_close($curl);

                            if ($err) {
                                echo "cURL Error #:" . $err;
                            } else {
                                $res = json_decode($response, true);
                                if ($res['results']['account_status'] == 'active') {
                                    $bank_res_arr = array(
                                        'bank_name' => $res['fund_account']['bank_account']['bank_name'],
                                        'bank_registered_name' => $res['results']['registered_name'],
                                        'is_verified' => '1',
                                    );
                                    $this->cldb->where('borrower_id', $this->input->post('borrowerId'));
                                    $this->cldb->update('p2p_borrower_bank_details', $bank_res_arr);
                                }
                                $this->cldb->where('borrower_id', $this->input->post('borrowerId'));
                                $this->cldb->where('fav_id', $fav_id);
                                $this->cldb->set('razorpay_response_fav', $response);
                                $this->cldb->update('p2p_borrower_bank_res');
                                $response = array(
                                    'status' => 1,
                                    'msg' => "Update successfully",
                                );

                            }
                        } else {
                            $response = array(
                                'status' => 0,
                                'msg' => "Wrong Approach! Please try again or contact system administrator.",
                            );
                        }


                    } else {
                        $response = array(
                            'status' => 0,
                            'msg' => "Wrong Approach! Please try again or contact system administrator.",
                        );
                    }
                }

            } else {
                $response = array(
                    'status' => 0,
                    'msg' => "No record found",
                );
            }
        } else {
            $response = array(
                'status' => 0,
                'msg' => "Validation error! Please check your detail and try again",
            );
        }
        echo json_encode($response);
        exit;
    }

    public function reinitiateExperian()
    {
//    	echo "<pre>";
//    	print_r($_POST); exit;
        $this->load->library('form_validation');
        $borrower_info = $this->P2pborrowermodel->get_borrower_details($this->input->post('b_borrower_id'));
        if ($borrower_info) {

            $arr = explode(' ', str_replace('  ', ' ', $borrower_info['Borrowername']));
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
            $dob = str_replace('-', '', $borrower_info['borrower_dob']);
            $_POST = array_merge($_POST, array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'b_borrower_id' => $borrower_info['b_borrower_id'],
                'dob' => $dob,
                'loan_amount' => $borrower_info['loan_amount'],
                'tenor_months' => $borrower_info['tenor_months'],
                'borrower_pan' => $borrower_info['borrower_pan'],
                'borrower_mobile' => $borrower_info['borrower_mobile'],
                'borrower_email' => $borrower_info['borrower_email'],
                'r_address' => $borrower_info['r_address'],
                'r_address1' => $borrower_info['r_address1'] ? $borrower_info['r_address1'] : '',
                'borrower_city' => $borrower_info['borrower_city'],
                'r_state' => $borrower_info['r_state'],
                'r_pincode' => $borrower_info['r_pincode'],
            ));
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|required');
            $this->form_validation->set_rules('loan_amount', 'Applied loan amount', 'trim|required');
            $this->form_validation->set_rules('tenor_months', 'tenor_months', 'trim|required');
            $this->form_validation->set_rules('borrower_pan', 'borrower_pan', 'trim|required');
            $this->form_validation->set_rules('borrower_mobile', 'borrower_mobile', 'trim|required');
            $this->form_validation->set_rules('borrower_email', 'borrower_email', 'trim|required');
            $this->form_validation->set_rules('r_address', 'r_address', 'trim|required');
            //$this->form_validation->set_rules('r_address1', 'r_address1', 'trim|required');
            $this->form_validation->set_rules('borrower_city', 'borrower_city', 'trim|required');
            $this->form_validation->set_rules('r_state', 'r_state', 'trim|required');
            $this->form_validation->set_rules('r_pincode', 'r_pincode', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
				
			$query = $this->cldb->get_where('p2p_borrower_experian_response', array('mobile' => $borrower_info['borrower_mobile']));

			  if ($this->cldb->affected_rows() == 0) {
			
			    $query = $this->money->get_where('premium_plan_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
				
				if ($this->money->affected_rows() == 0) {
                 
				$query = $this->money->get_where('cc_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
					
				if ($this->money->affected_rows() == 0) {
					
				$query = $this->money->get_where('all_experian_data', array('mobile' => $borrower_info['borrower_mobile']));
					
				if ($this->money->affected_rows() == 0) {
				
                $xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="http://nextgenws.ngwsconnect.experian.com">
   <SOAP-ENV:Header />
   <SOAP-ENV:Body>
      <urn:process>
         <urn:cbv2String><![CDATA[<INProfileRequest>
   <Identification>
      <XMLUser>cpu2ant_prod44</XMLUser>
      <XMLPassword>Antworks@1234</XMLPassword>
   </Identification>
   <Application>
      <FTReferenceNumber></FTReferenceNumber>
      <CustomerReferenceID>' . $borrower_info['borrower_id'] . '</CustomerReferenceID>
      <EnquiryReason>13</EnquiryReason>
      <FinancePurpose>99</FinancePurpose>
      <AmountFinanced>' . $borrower_info['loan_amount'] . '</AmountFinanced>
      <DurationOfAgreement>' . $borrower_info['tenor_months'] . '</DurationOfAgreement>
      <ScoreFlag>1</ScoreFlag>
      <PSVFlag></PSVFlag>
   </Application>
   <Applicant>
      <Surname>' . $last_name . '</Surname>
      <FirstName>' . $first_name . '</FirstName>
      <MiddleName1 />
      <MiddleName2 />
      <GenderCode>2</GenderCode>
      <IncomeTaxPAN>' . $borrower_info['borrower_pan'] . '</IncomeTaxPAN>
      <PAN_Issue_Date />
      <PAN_Expiration_Date />
      <PassportNumber />
      <Passport_Issue_Date />
      <Passport_Expiration_Date />
      <VoterIdentityCard />
      <Voter_ID_Issue_Date />
      <Voter_ID_Expiration_Date />
      <Driver_License_Number />
      <Driver_License_Issue_Date />
      <Driver_License_Expiration_Date />
      <Ration_Card_Number />
      <Ration_Card_Issue_Date />
      <Ration_Card_Expiration_Date />
      <Universal_ID_Number />
      <Universal_ID_Issue_Date />
      <Universal_ID_Expiration_Date />
      <DateOfBirth>' . $dob . '</DateOfBirth>
      <STDPhoneNumber />
      <PhoneNumber>' . $borrower_info['borrower_mobile'] . '</PhoneNumber>
      <Telephone_Extension />
      <Telephone_Type />
      <MobilePhone>' . $borrower_info['borrower_mobile'] . '</MobilePhone>
      <EMailId>' . $borrower_info['borrower_email'] . '</EMailId>
   </Applicant>
   <Details>
      <Income />
      <MaritalStatus />
      <EmployStatus />
      <TimeWithEmploy />
      <NumberOfMajorCreditCardHeld>5</NumberOfMajorCreditCardHeld>
   </Details>
   <Address>
      <FlatNoPlotNoHouseNo>' . $borrower_info['r_address'] . '</FlatNoPlotNoHouseNo>
      <BldgNoSocietyName>' . $borrower_info['r_address1'] . '</BldgNoSocietyName>
      <RoadNoNameAreaLocality></RoadNoNameAreaLocality>
      <City>' . $borrower_info['borrower_city'] . '</City>
      <State>' . $borrower_info['r_state'] . '</State>
      <PinCode>' . $borrower_info['r_pincode'] . '</PinCode>
   </Address>
  
   <AdditionalAddress>
      <FlatNoPlotNoHouseNo />
      <BldgNoSocietyName />
      <RoadNoNameAreaLocality />
      <Landmark />
      <State />
      <PinCode />
   </AdditionalAddress>
</INProfileRequest>
]]></urn:cbv2String>
      </urn:process>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_PORT => "8443",
                    CURLOPT_URL => "https://connect.experian.in:8443/ngwsconnect/ngws",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 60,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $xml,
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: text/xml",
                    ),
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    $year = date("Y");
                    $month = date("m");
                    $filename = FCPATH . "experien/reports/" . $year;
                    $filename2 = FCPATH . "experien/reports/" . $year . "/" . $month;
                    if (file_exists($filename) == true) {
                        if (file_exists($filename2) == false) {
                            mkdir($filename2, 0777);
                        }
                    } else {
                        mkdir($filename, 0777);
                        if (file_exists($filename2) == false) {
                            mkdir($filename2, 0777);
                        }
                    }
                    $report_file_name = "experien/reports/" . $year . "/" . $month . "/report_" . $this->input->post('b_borrower_id') . "_" . date('m-d-Y_H-i-s') . ".xml";
                    $file_experian = FCPATH . $report_file_name;
                    if (file_exists($file_experian)) {
                        $report_file_name = "experien/reports/" . $year . "/" . $month . "/report_" . $this->input->post('b_borrower_id') . "_" . uniqid() . ".xml";
                    }
                    $myfile = fopen($report_file_name, "w");
                    fwrite($myfile, htmlspecialchars_decode($response));
                    fclose($myfile);
                    $arr_response = array(
                        'borrower_id' => $this->input->post('borrower_id'),
                        'borrower_request' => $xml,
                        'experian_response_file' => $report_file_name,

                    );
                    $this->cldb->insert('p2p_borrower_experian_response', $arr_response);
					
					$arr_response_all = array(
								'user_id' =>$this->input->post('borrower_id'),
								'mobile' => $borrower_info['borrower_mobile'],
								'request_data' => $xml,
								'experian_file' => $file_experian,
                                'experian_source' => 'credit line',
								'experian_xml_file' =>$report_file_name,
							);
					$this->money->insert('all_experian_data', $arr_response_all);

                    $dataSteps = array(
                        'step_5' => 1,
                    );
                    $this->cldb->where('borrower_id', $this->input->post('borrower_id'));
                    $this->cldb->update('p2p_borrower_steps', $dataSteps);
                    $this->load->model('Creditenginemodel');
                    $this->Creditenginemodel->Engine($this->input->post('borrower_id'));
                    //
                    $msg = "User Record Update Successfully";
                    $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                    redirect(base_url() . 'creditops/viewborrower/' . $this->input->post('b_borrower_id'));
                }
            }
			}
			}
			}
			}
			else {
                $errmsg = validation_errors();
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
                redirect(base_url() . 'creditops/viewborrower/' . $this->input->post('b_borrower_id'));
            }

        } else {
            $msg = "User Record Not Found. Please verify details and try again";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'creditops/viewborrower/' . $this->input->post('b_borrower_id'));
        }
    }

    public function borrower_search()
    {

        $where = "";
        if ($this->input->post('start_date')) {
            $post_date = explode('+', $this->input->post('start_date'));
            $date = explode('-', $post_date[0]);
            $start_date = $date[0];
            $end_date = $date[1];
            // Date Format
            $start_date = (date("Y-m-d", strtotime($start_date))) . ' 00:00:00';
            $end_date = (date("Y-m-d", strtotime($end_date))) . ' 23:59:59';

            $where = "BL.created_date > '$start_date' AND BL.created_date < '$end_date'";
        }

        if ($this->input->get('borrower_id')) {
            $where .= "BL.borrower_id = '" . $this->input->get('borrower_id') . "'";

        } elseif ($this->input->get('email')) {
            $where .= "BL.email = '" . $this->input->get('email') . "'";
        } elseif ($this->input->get('mobile')) {
            $where .= "BL.mobile = '" . $this->input->get('mobile') . "'";
        } elseif ($this->input->get('name')) {
            $where .= "BL.name = '" . $this->input->get('name') . "'";
        }
        $this->cldb->select('BL.id,
                           BL.borrower_id,
                           BL.name,
                           BL.email,
                           BL.mobile,
                           BL.dob,
                           BL.status,
                           BL.created_date,
                           BS.step_2');
        $this->cldb->from('p2p_borrowers_list AS BL');
        $this->cldb->join('p2p_borrower_steps AS BS', 'ON BS.borrower_id = BL.id', 'left');
        $this->cldb->where($where);
        $this->cldb->order_by('id', 'desc');
        $query = $this->cldb->get();
        return $query->result_array();

    }

    public function add_docs_borrower($uploads)
    {

        $this->cldb->select('*');
        $this->cldb->from('p2p_borrowers_docs_table');
        $this->cldb->where('borrower_id', $uploads['borrower_id']);
        $this->cldb->where('docs_type', $uploads['docs_type']);
        $query = $this->cldb->get();
        if ($this->cldb->affected_rows() > 0) {
            $this->cldb->where('borrower_id', $uploads['borrower_id']);
            $this->cldb->where('docs_type', $uploads['docs_type']);
            $this->cldb->update('p2p_borrowers_docs_table', $uploads);
        } else {
            $this->cldb->insert('p2p_borrowers_docs_table', $uploads);

        }

        return true;

    }

}

?>

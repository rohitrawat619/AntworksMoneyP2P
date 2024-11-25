<?php

class Borroweractivitymodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrowerinfomodel');
    }
    public function verify_signature($borrowerId, $loan_id, $otp)
    {
        $borrowerInfo = $this->Borrowerinfomodel->get_personalDetails($borrowerId);
		
        $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
        $this->db->from('p2p_borrower_otp_signature');
        $this->db->where('loan_id', $loan_id);
        $this->db->where('mobile', $borrowerInfo['mobile']);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
		
        if ($this->db->affected_rows() > 0) {
            $result = $query->row();
            if ($otp == $result->otp) {
                if ($result->MINUTE <= 10) {
					#Loan Aggrement Signature Verified as disscussed with shantanu sir
					// get loan number
					
					$this->db->where("id",$loan_id);
					$this->db->select('loan_no');
					$this->db->from('p2p_loan_list');
					$get_loan_no = $this->db->get()->row_array();
					$loan_no=$get_loan_no['loan_no'];
					
					// get bid_registration_id start
					
					$this->db->where("loan_no",$loan_no);
					$this->db->select('bid_registration_id');
					$this->db->from('p2p_bidding_proposal_details');
					$query = $this->db->get()->row_array();

					
					$get_bid_registration_id = $query['bid_registration_id'];
					// get bid_registration_id end
					
					
					
					
                    $this->db->select('*');
                    $this->db->from('p2p_loan_aggrement_signature');
                    $this->db->where('loan_id', $loan_id);
                    $query = $this->db->get();
					
			
                    if ($this->db->affected_rows() > 0) {
                        $result = $query->row();
                        $this->db->where('loan_id', $loan_id);
                        $this->db->set('borrower_acceptance', 1);
                        $this->db->set('borrower_signature', 1);
                        $this->db->set('borrower_signature_date', date('Y-m-d H:i:s'));
                        $this->db->update('p2p_loan_aggrement_signature');

                        $this->db->where('borrower_id', $borrowerId);
                        $this->db->set('step_4', 1);
                        $this->db->set('step_5', 1);
                        $this->db->update('p2p_borrower_steps_credit_line');

                        //update OTP Status
                        $this->db->where('otp', $otp);
                        $this->db->where('mobile', $borrowerInfo['mobile']);
                        $this->db->where('loan_id', $loan_id);
                        $this->db->set('is_verified', '1');
                        $this->db->update('p2p_borrower_otp_signature');

                        return array(
                            'status' => '1',
                            'msg' => 'Thanks for signature this Loan Agreement.'.rand()
                        );
                    } 
					else{
						$this->db->insert('p2p_loan_aggrement_signature', array(
                            'borrower_id' => $borrowerId,
							'bid_registration_id' => $get_bid_registration_id,
                            'loan_id' => $loan_id,
                            'borrower_acceptance' => 1,
                            'borrower_signature' => 1,
                            'borrower_signature_date' => date('Y-m-d H:i:s'),
                        ));
					}
                } else {
                    return array(
                        'status' => '0',
                        'msg' => 'Sorry Your OTP is expired please try again'
                    );
                }
            } else {
                return array(
                    'status' => '0',
                    'msg' => 'your OTP is not verified please enter correct OTP'
                );
            }
        } else {
            return false;
        }
    }
   #Old Function 23-01-24
    public function get_myloan($borrowerId)
    {

        $this->db->select('PBPD.*');
        $this->db->from('p2p_bidding_proposal_details AS PBPD');
        $this->db->where('PBPD.borrowers_id', $borrowerId);
        $query = $this->db->get();
        if ($this->db->affected_rows() > 0) {
            $results = $query->result_array();
            $loan_list = array();
            foreach ($results as $result) {
                $this->db->select('id, emi_amount ,emi_date ,emi_principal,emi_balance, status');
                $this->db->where('loan_id', $result['bid_registration_id']);
                $this->db->where_in('status', array('0', '1', '2', '3'));
                $this->db->from('p2p_borrower_emi_details');
                $this->db->order_by('id', 'desc');
                $this->db->limit('1');
                $query = $this->db->get();
                if ($this->db->affected_rows() > 0) {
                    //Loan Status open/Closed

                    $loan_status = 'open';
                    if ($result['proposal_status'] == 7) {
                        $loan_status = 'Closed';
                    }
                    if ($result['proposal_status'] == 2) {
                        $loan_status = 'open';
                    }

                    $emai_details = (array)$query->row();
                    $loan_list[] = array(
                        'bid_registration_id' => $result['bid_registration_id'],
                        'loan_no' => $result['loan_no'],
                        'product_type' => 'Personal Loan',
                        'emi_id' => $emai_details['id'],
                        'emi_amount' => $emai_details['emi_amount'],
                        'emi_principal' => $emai_details['emi_principal'],
                        'balance_amount' => $emai_details['emi_balance'],
                        'emi_date' => $emai_details['emi_date'],
                        'loan_status' => $loan_status,

                    );
                }

            }

            if ($loan_list) {
                return $loan_list;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function get_myloanDetails($borrowerId)
    {
        $this->db->select('loan_no ,bid_loan_amount ,accepted_tenor');
        $this->db->from('p2p_bidding_proposal_details');
        $this->db->where('borrowers_id', $borrowerId);
        $this->db->where('bid_registration_id', $this->input->post('bid_registration_id'));
        $query = $this->db->get();
//        echo $this->db->last_query(); exit;
        if ($this->db->affected_rows() > 0) {
            $result = (array)$query->row();
            return $loanDetails = array(
                'loan_no' => $result['loan_no'],
                'bid_loan_amount' => $result['bid_loan_amount'],
                'accepted_tenor' => $result['accepted_tenor'],
                'disburse_amount' => $result['bid_loan_amount'],
            );
        } else {
            return false;
        }
    }

    public function get_loanagreementPdf($borrowerId)
    {
        $query = $this->db->select('agreement_loan_file_name')
            ->get_where('p2p_loan_agreement_pdf', array('bid_registration_id' => $this->input->post('bid_registration_id')));
        if ($this->db->affected_rows() > 0) {
            $result = (array)$query->row();
            return array(
                'status' => 1,
                'msg' => 'Loan Agreement Found',
                'agreement_loan_file_path' => base_url() . 'borrower-loan-aggrement' . $result['agreement_loan_file_name'],
            );
        } else {
            return array(
                'status' => 0,
                'msg' => "Sorry not found",
            );
        }
    }

    public function get_loanStatement($borrowerId)
    {
        $sql = "SELECT
               UI.name, 
               UD.borrower_signature_date, 
               PD.bid_registration_id, 
               PD.loan_no, 
               PD.bid_loan_amount, 
               PD.accepted_tenor,
               PD.interest_rate,
               'Personal Loan' AS 'prodtuc_type'
               FROM p2p_borrowers_list AS UI
               LEFT JOIN p2p_bidding_proposal_details PD 
               ON PD.borrowers_id = UI.id 
               LEFT JOIN p2p_loan_aggrement_signature UD 
               ON  PD.bid_registration_id= UD.bid_registration_id
               WHERE UI.id = $borrowerId AND PD.loan_no = '" . $this->input->post('loan_no') . "'";
        $query = $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $loan_details = (array)$query->row();
            $sql = "SELECT 
                   UR.emi_date, 
                   UR.emi_amount,
                   UR.emi_interest,
                   UR.emi_principal,
                   UR.emi_balance
                   FROM p2p_borrower_emi_details AS UR                  
                   WHERE UR.loan_id = '" . $loan_details['bid_registration_id'] . "'";

            $query = $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $emi_list = $query->result_array();
            }
            return array(
                'status' => 1,
                'MyloanStatement' => $loan_details,
                'emi_list' => $emi_list
            );
        } else {
            return false;
        }
    }

    public function getEmidetailstopay()
    {
        $emi_amount = $this->db->select('emi_amount')->get_where('p2p_borrower_emi_details', array('id' => $this->input->post('emi_id')))->row()->emi_amount;
        $this->db->select('id')->get_where('p2p_borrower_emi_details', array('loan_id' => $this->input->post('bid_registration_id')));
        if ($this->db->affected_rows() > 1) {
            $foreclosure_amount = $this->db->select('SUM(emi_amount) AS foreclosure_amount')->from('p2p_borrower_emi_details')
                ->where('loan_id', $this->input->post('bid_registration_id'))
                ->where('status !=', 1)
                ->get()->row()->foreclosure_amount;
        } else {
            $foreclosure_amount = 0;
        }

        return array(
            'emi_id' => $this->input->post('emi_id'),
            'bid_registration_id' => $this->input->post('bid_registration_id'),
            'emi_amount_to_pay' => $emi_amount,
            'foreclosure_amount' => $foreclosure_amount,
        );

    }

    

    public function checkCurrentproposal($borrowerId)
    {
        $this->db->select('proposal_id')->where('borrower_id', $borrowerId)
            ->where_in('bidding_status', array('0', '1', '2', '4'))
            ->from('p2p_proposal_details')
            ->get();
        if ($this->db->affected_rows() > 0) {
            return array(
                'status' => 0,
                'msg' => 'Dear borrower your proposal already exist!!',
            );
        } else {
            return array(
                'status' => 1,
                'msg' => 'Dear borrower you can add new proposal!!',
            );
        }

    }
}


?>

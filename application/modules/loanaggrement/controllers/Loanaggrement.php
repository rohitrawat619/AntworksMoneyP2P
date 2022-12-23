<?php
class Loanaggrement extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Loanaggrementmodel');
        $this->load->model('p2padmin/Sendemailborrowermodel');
    }

    public function generateLoanaggrement()
    {

        error_reporting(0);
        //$_POST['bid_registration_id'] = 6;
        if(!empty($_POST['bid_registration_id'])){
            $result = $this->Loanaggrementmodel->loanaggrement();
            $loan_amount = $result['APPROVERD_LOAN_AMOUNT'];
            $loan_amount_inword = $this->Loanaggrementmodel->convert_number_to_words($loan_amount);
            $loan_interest_rate = $result['LOAN_Interest_rate'];
            $loan_tenor = $result['TENORMONTHS'];
            $loan_time = $loan_tenor / 12;
            $loan_ir = $loan_interest_rate;

            $numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
            $denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
            $emi = ($numerator / $denominator);
            $table = "";
            $emi_balance = 0;
			$emi_interest = array();
			$emi_principal = array();
			$emi_balance = array();
            if($result['borrower_signature'] == 1)
			{
				$data['borrower_signature_date'] = $result['borrower_signature_date'];
				$data['agreement_date'] = date('d-m-Y',strtotime($result['borrower_signature_date']));
			}
            else{
				$data['borrower_signature_date'] = date('d/m/Y H:i:s', time());
				$data['agreement_date'] = date("d-m-Y");
			}
            if($result['lender_signature'] == 1)
			{
				$data['lender_signature_date'] = $result['lender_signature_date'];
			}
            else{
				$data['lender_signature_date'] = "";
			}
            for ($i = 1; $i <= $loan_tenor; $i++) {

                if ($i == 1) {
                    $emi_sn[$i] = "Month " . $i;
                    $emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
                    $emi_principal[$i] = $emi - $emi_interest[$i];
                    $emi_balance[$i] = $loan_amount - $emi_principal[$i];
                } else if ($i < 37) {
                    $emi_sn[$i] = "Month " . $i;
                    $emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
                    $emi_principal[$i] = $emi - $emi_interest[$i];
                    $emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
                } else if ($i >= 37) {
                    break;
                }
                $emi_date = date('d/F/Y', strtotime($data['agreement_date']. '+'. $i. " months"));
                $table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>" . $emi_date . "</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";

            }

            $data['result'] = $result;
            $data['table'] = $table;
            $data['loan_amount'] = $loan_amount;
            $data['loan_amount_inword'] = $loan_amount_inword;
            $data['emi'] = $emi;
            $data['html'] = "";
            $data['portal_name'] = 'www.antworksp2p.com';
            $data['today'] = date("d-m-Y");
            $data['loan_restructuring'] = $this->Loanaggrementmodel->checkRestructuring($_POST['bid_registration_id']);
            
            /////
            $data['agreement_date_time_stamp'] = $date = date('d/m/Y H:i:s', time());
			$borrowerId = $this->session->userdata('borrower_id');
			$email = $this->session->userdata('email');
			$name = $this->session->userdata('name');
            $this->Sendemailborrowermodel->informationbinddingloan_agreementemail($borrowerId, $name, $email);
            if($data['result'])
            {

                $aggrement_result = $this->load->view('loan-aggrement-borrower', $data, true);
                $arrrement = array(
                    'status'=>1,
                    'agreement'=>$aggrement_result,
                );
            }
            else{
                $arrrement = array(
                    'status'=>2,
                    'agreement'=>'',
                );
            }
        }
        else{
            $arrrement = array(
                'status'=>0,
                'agreement'=>'',
            );
        }
        echo json_encode($arrrement);
    }
}
?>

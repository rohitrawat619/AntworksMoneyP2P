<?php
class Account extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Lendermodelbackend', 'Requestmodel'));
        error_reporting(0);
    }

    public function my_performance()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {

            $data['pageTitle'] = "My Performance";
            $this->load->model('Lenderaccountmodel');
            $data['total_aggregateamount'] = $this->Lenderaccountmodel->total_aggregateamount();
            $data['total_principal_outstanding'] = $this->Lenderaccountmodel->total_principal_outstanding();
            $data['total_no_of_loans'] = $this->Lenderaccountmodel->total_no_of_loans();
            $data['avg_amount_of_loan'] = round($this->Lenderaccountmodel->avg_loan_amount(), 2);
            $data['total_loan_repayment_date_not_due'] = $this->Lenderaccountmodel->total_loan_repayment_date_not_due();
            $data['total_interest_recieved'] = $this->Lenderaccountmodel->total_interest_recieved();
            $data['roi'] = $this->Lenderaccountmodel->roi();
            $data['account_main_balance'] = $this->Lenderaccountmodel->account_main_balance();
            $data['processing_fee_charges'] = $this->Lenderaccountmodel->processing_fee_charges();
            $data['amount_withdrawal'] = $this->Lenderaccountmodel->amount_withdrawal();
            $data['balance'] = (($data['total_aggregateamount']-$data['total_principal_outstanding'])+$data['total_principal_outstanding']+$data['total_interest_recieved'])
                                  -($data['processing_fee_charges']+$data['amount_withdrawal']);

            $data['past_due_0_30days'] = $this->Lenderaccountmodel->past_due_0_30days();
            $data['past_due_30_60days'] = $this->Lenderaccountmodel->past_due_30_60days();
            $data['past_due_60_90days'] = $this->Lenderaccountmodel->past_due_60_90days();
            $data['past_due_plus_90days'] = $this->Lenderaccountmodel->past_due_plus_90days();

            $data['available_cash'] = $this->Lenderaccountmodel->account_main_balance();
            $data['in_funding_notes'] = $data['total_principal_outstanding'];

            $data['accrued_Interest'] = $this->Lenderaccountmodel->accrued_Interest();


            $data['termResult'] = $this->Lenderaccountmodel->termResult();
            $data['gradeResult'] = $this->Lenderaccountmodel->gradeResult();
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('portfolio/my_performance',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function loan_summary()
    {
        if ( $this->session->userdata('login_state') == TRUE )
        {
        	$this->load->model('Lenderaccountmodel');
            $data['pageTitle'] = "Loan Summary";
            $data['loan_summary'] = $this->Lenderaccountmodel->loan_summary();
            $this->load->view('templates-lender/header',$data);
            $this->load->view('templates-lender/nav',$data);
            $this->load->view('portfolio/my_summary',$data);
            $this->load->view('templates-lender/footer');
        }
        else
        {
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/lender');
        }
    }

    public function createLoanledger($loan_disbursement_id)
	{
         if ( $this->session->userdata('login_state') == TRUE )
         {
		   $this->load->model('Lenderaccountmodel');
           $data['lenderLedger'] = $this->Lenderaccountmodel->createLoanledger($loan_disbursement_id);
           $ledger = $this->load->view('portfolio/loan_ledger', $data, true);
           echo $ledger;
           exit;

		 }
		 else
		 {
			 $msg="Your session had expired. Please Re-Login";
			 exit;
		 }
	}

	public function lenderInvestment()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			$this->load->model('Lenderaccountmodel');
			$data['pageTitle'] = "Invest Account";
			$data['lenderInvestments'] = $this->Lenderaccountmodel->lenderInvestment();
			$this->load->view('templates-lender/header',$data);
			$this->load->view('templates-lender/nav',$data);
			$this->load->view('portfolio/investment-account',$data);
			$this->load->view('templates-lender/footer');
		}
		else
		{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/lender');
		}
	}
}
?>

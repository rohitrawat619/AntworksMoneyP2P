<?php
class P2pmis extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('P2pmismodel');
	}

	public function index()
	{
		if( $this->session->userdata('admin_state') == TRUE &&  ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'recovery') ) {
			$data['pageTitle'] = "P2P Mis";
			$data['title'] = "P2P Mis";
			$this->load->view('templates-admin/header', $data);
			if ($this->session->userdata('role') == 'admin') {
				$this->load->view('templates-admin/nav', $data);
			}
			if ($this->session->userdata('role') == 'recovery') {
				$this->load->view('p2precovery/nav', $data);
			}
			$this->load->view('mis/p2pmis', $data);
			$this->load->view('templates-admin/footer', $data);
		}
	}

	public function generateMis()
	{
		if ($this->session->userdata('admin_state') == TRUE && ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'recovery')) {
			error_reporting(0);
			require_once APPPATH . "/third_party/excel/PHPExcel.php";
			$systemStatement = $this->P2pmismodel->referenceSystemstatement();
//			echo "<pre>";
//			print_r($systemStatement); exit;
			$disburseamount = $this->P2pmismodel->totalDisbursementofday();
			$collection = $this->P2pmismodel->totalCollectionofday();
			$lenderRegistration = $this->P2pmismodel->totallender();
			$borrowerRegistration = $this->P2pmismodel->totalborrower();
			$bids = $this->P2pmismodel->totalBids();
			$activeLender = $this->P2pmismodel->activeLender();
			$activeBorrower = $this->P2pmismodel->activeBorrower();
			$notyetDue = $this->P2pmismodel->notyetDue();
			$past_due_0_30days = $this->P2pmismodel->past_due_0_30days();
			$past_due_30_60days = $this->P2pmismodel->past_due_30_60days();
			$past_due_60_90days = $this->P2pmismodel->past_due_60_90days();

			$previous_day = date('Y-m-d', strtotime(' -1 day ')) . ' 06';
			$current_day = date('M d Y') . ' at ' . date('H:i:s');

			$this->excel = new PHPExcel();
			//$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->setTitle('Sheet 1');
			$this->excel->getActiveSheet()->setCellValue('A1', '');
			$this->excel->getActiveSheet()->setCellValue('B1', '');
			$this->excel->getActiveSheet()->setCellValue('C1', 'Table 1');
			$this->excel->getActiveSheet()->setCellValue('D1', $current_day);
			$this->excel->getActiveSheet()->setCellValue('A2', 'Reference: System statement');
			$this->excel->getActiveSheet()->setCellValue('A3', 'Lender');
			$this->excel->getActiveSheet()->setCellValue('B3', 'Cash(a)');
			$this->excel->getActiveSheet()->setCellValue('C3', 'Loan(b)');
			$this->excel->getActiveSheet()->setCellValue('D3', 'Total (a+b)');
			$this->excel->getActiveSheet()->setCellValue('E3', 'Net Investment (d)');
			$this->excel->getActiveSheet()->setCellValue('F3', 'Interest (e )');
			$this->excel->getActiveSheet()->setCellValue('G3', 'Total (e+f)');
			$this->excel->getActiveSheet()->setCellValue('H3', 'Amount Matching (Y or no)');
			$this->excel->getActiveSheet()->setCellValue('I3', 'Difference');
			$this->excel->getActiveSheet()->getStyle("A1:D1")->applyFromArray(array("font" => array("bold" => true)));
			$this->excel->getActiveSheet()->getStyle("A2:A2")->applyFromArray(array("font" => array("bold" => true)));
			$this->excel->getActiveSheet()->getStyle("A3:I3")->applyFromArray(array("font" => array("bold" => true)));
			$str = 'A';
			$i = 4;
			foreach ($systemStatement as $refrence) {
				unset($refrence['user_id']);
				unset($refrence['lender_id']);
				foreach ($refrence as $key => $ref) {
					$this->excel->getActiveSheet()->setCellValue($str++ . $i, $refrence[$key]);

				}
				$i++;
				$str = 'A';
			}

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total X');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, array_sum(array_column($systemStatement, 'cash')));
			$this->excel->getActiveSheet()->setCellValue('C' . $i, array_sum(array_column($systemStatement, 'loan')));
			$this->excel->getActiveSheet()->setCellValue('D' . $i, array_sum(array_column($systemStatement, 'total_cash_loan')));
			$this->excel->getActiveSheet()->setCellValue('E' . $i, array_sum(array_column($systemStatement, 'netInvest')));
			$this->excel->getActiveSheet()->setCellValue('F' . $i, array_sum(array_column($systemStatement, 'interest_e')));
			$this->excel->getActiveSheet()->setCellValue('G' . $i, array_sum(array_column($systemStatement, 'total_netInvest_interest_e')));
			$this->excel->getActiveSheet()->setCellValue('I' . $i, array_sum(array_column($systemStatement, 'difference')));
			$this->excel->getActiveSheet()->getStyle("A" . $i . ":I" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('C' . $i, 'Table 2: ');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $current_day);
			$this->excel->getActiveSheet()->getStyle("C" . $i . ":C" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Reference:');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, 'bank statement');
			$this->excel->getActiveSheet()->getStyle("A" . $i . ":B" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Amount lying in Escrow account (Funding)');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('amount_lying_funding_account'));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Amount lying in Escrow account (Collection)');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('amount_lying_collection_account'));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Amount lying in Razor pay');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('amount_lying_razorpay'));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Y');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('amount_lying_funding_account') + $this->input->post('amount_lying_collection_account') + $this->input->post('amount_lying_razorpay'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Difference (z1)');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, ($this->input->post('amount_lying_funding_account') + $this->input->post('amount_lying_collection_account') + $this->input->post('amount_lying_razorpay')) - array_sum(array_column($systemStatement, 'cash')));
			if (array_sum(array_column($systemStatement, 'cash')) == ($this->input->post('amount_lying_funding_account') + $this->input->post('amount_lying_collection_account') + $this->input->post('amount_lying_razorpay'))) {
				$is_match = 'Y';
			} else {
				$is_match = 'N';
			}
			$this->excel->getActiveSheet()->setCellValue('C' . $i, $is_match);
			$i++;
			$this->excel->getActiveSheet()->setCellValue('C' . $i, 'Table 3');
			$this->excel->getActiveSheet()->getStyle("C" . $i . ":C" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Unappropriated amount');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, '');
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Premium Listing Charges');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('premium_listing_charges'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Razor pay charges - (As on ' . date('Y-m-d h:i:s') . ') - CUMULATIVE');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('razorpay_charges'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Partial payment received - (As on ' . date('Y-m-d h:i:s') . ') - CUMULATIVE ');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('partial_payment_received'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'RTGS received - CUMULATIVE ');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $this->input->post('rtgs_received'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total (z2)');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, ($this->input->post('premium_listing_charges') + $this->input->post('partial_payment_received') + $this->input->post('rtgs_received')) - $this->input->post('razorpay_charges'));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Approval is mandatory*');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, '');
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Difference between z1 and z2');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, (($this->input->post('amount_lying_funding_account') + $this->input->post('amount_lying_collection_account') + $this->input->post('amount_lying_razorpay')) - array_sum(array_column($systemStatement, 'cash'))) - ((($this->input->post('premium_listing_charges') + $this->input->post('partial_payment_received') + $this->input->post('rtgs_received')) - $this->input->post('razorpay_charges'))));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('D' . $i, 'Table 4 - Daily collection and Disbursments');
			$this->excel->getActiveSheet()->getStyle("D" . $i . ":D" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;

			$this->excel->getActiveSheet()->setCellValue('F' . $i, 'Ref Point');
			$this->excel->getActiveSheet()->setCellValue('G' . $i, 'System');
			$this->excel->getActiveSheet()->setCellValue('H' . $i, 'Bank Statement');
			$this->excel->getActiveSheet()->setCellValue('I' . $i, 'Difference (Y or N)');
			$this->excel->getActiveSheet()->getStyle("F" . $i . ":I" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;
			if ($disburseamount == $this->input->post('total_disbursement_during_day')) {
				$is_disburse_match = 'Yes';
			} else {
				$is_disburse_match = 'No';
			}
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Disbursment during the day');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $previous_day . ' to current');
			$this->excel->getActiveSheet()->setCellValue('G' . $i, $disburseamount);
			$this->excel->getActiveSheet()->setCellValue('H' . $i, $this->input->post('total_disbursement_during_day'));
			$this->excel->getActiveSheet()->setCellValue('I' . $i, $is_disburse_match);
			$i++;
			if ($collection == $this->input->post('total_collection_during_day')) {
				$is_collection_match = 'Yes';
			} else {
				$is_collection_match = 'No';
			}
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Collection during the day');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $previous_day . ' to current');
			$this->excel->getActiveSheet()->setCellValue('G' . $i, $collection);
			$this->excel->getActiveSheet()->setCellValue('H' . $i, $this->input->post('total_collection_during_day'));
			$this->excel->getActiveSheet()->setCellValue('I' . $i, $is_collection_match);
			$i++;
			$this->excel->getActiveSheet()->setCellValue('E' . $i, 'Total Collection during the day');
			$i++;
			$this->excel->getActiveSheet()->setCellValue('D' . $i, 'last 24 hours');
			$this->excel->getActiveSheet()->setCellValue('E' . $i, 'last 7 days');
			$this->excel->getActiveSheet()->setCellValue('F' . $i, 'last 30 days');
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Lender Rgistrations');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $lenderRegistration['last24hours']);
			$this->excel->getActiveSheet()->setCellValue('E' . $i, $lenderRegistration['last7days']);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, $lenderRegistration['last30days']);
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Borrower Rgistrations');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $borrowerRegistration['last24hours']);
			$this->excel->getActiveSheet()->setCellValue('E' . $i, $borrowerRegistration['last7days']);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, $borrowerRegistration['last30days']);
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total Bids');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $bids['last24hours']);
			$this->excel->getActiveSheet()->setCellValue('E' . $i, $bids['last7days']);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, $bids['last30days']);
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Active Lender');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $activeLender['last24hours']);
			$this->excel->getActiveSheet()->setCellValue('E' . $i, $activeLender['last7days']);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, $activeLender['last30days']);
			$i++;

			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Active Borrower');
			$this->excel->getActiveSheet()->setCellValue('D' . $i, $activeBorrower['last24hours']);
			$this->excel->getActiveSheet()->setCellValue('E' . $i, $activeBorrower['last7days']);
			$this->excel->getActiveSheet()->setCellValue('F' . $i, $activeBorrower['last30days']);
			$i++;
			$i++;
			$this->excel->getActiveSheet()->setCellValue('C' . $i, 'Table 6');
			$this->excel->getActiveSheet()->getStyle("C" . $i . ":C" . $i . "")->applyFromArray(array("font" => array("bold" => true)));
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Total loan Portfolio');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, '');
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Ageing');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, '');
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, 'Not yet due');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $notyetDue);
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, '0-30');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $past_due_0_30days);
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, '30-60');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $past_due_30_60days);
			$i++;
			$this->excel->getActiveSheet()->setCellValue('A' . $i, '60-90');
			$this->excel->getActiveSheet()->setCellValue('B' . $i, $past_due_60_90days);
			$filename = 'p2p_mis_' . date('Y-m-d h-i-s') . '.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
			header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			$objWriter->save('php://output');
//		$data['pageTitle'] = "Generated P2P Mis";
//		$data['title'] = "Generated P2P Mis";
//		$this->load->view('templates-admin/header',$data);
//		$this->load->view('templates-admin/nav',$data);
//		$this->load->view('mis/generatedp2pmis',$data);
//		$this->load->view('templates-admin/footer',$data);
		}
	}

	public function borrowerstatus()
	{
		if( $this->session->userdata('admin_state') == TRUE &&  ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'recovery') || $this->session->userdata('role') == 'mis') {

			$this->load->model('p2padmin/Loanmanagementmodel');
			$response = $this->Loanmanagementmodel->getGoodBadborrower();

			$this->load->dbutil();
			$this->load->helper('file');
			$this->load->helper('download');
			$delimiter = ",";
			$newline = "\r\n";
			$filename = "Borrowerdetails.csv";
			$data = $this->dbutil->csv_from_result($response, $delimiter, $newline);
			force_download($filename, $data);
			exit;
		}
	}
}
?>

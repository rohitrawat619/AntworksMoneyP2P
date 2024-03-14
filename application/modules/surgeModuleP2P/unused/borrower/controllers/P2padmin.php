<?php

class P2padmin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2padminmodel');
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'admin') {

        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
        error_reporting(0);
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login";
        exit;
    }

    public function dashboard()
    {
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = base_url() . "p2padmin/borrowers";
        $config["total_rows"] = $this->P2padminmodel->get_count_borrowers();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["pagination"] = $this->pagination->create_links();
        $data['list'] = $this->P2padminmodel->getborrowers($config["per_page"], $page);
        $data['pageTitle'] = "Borrower List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header', $data);
        $this->load->view('templates-admin/nav', $data);
        $this->load->view('borrower/borrower-list', $data);
        $this->load->view('templates-admin/footer', $data);
    }

    public function list_for_disbursement()
    {
        $results = array();
        $query = $this->db
            ->select("bl.name, email, mobile, ll.loan_no, ll.id, ll.borrower_id, ll.approved_loan_amount, ll.approved_interest, ll.approved_tenor, ll.loan_processing_charges, ll.loan_tieup_fee,
            ll.disburse_amount, ll.date_created
            ")
            ->join('p2p_borrowers_list as bl', 'on bl.id = ll.borrower_id')
            ->get_where('p2p_loan_list as ll', array('ll.disbursement_request' => 1, 'll.disbursed_flag IS NULL' => null));
			//echo $this->db->last_query();
        if ($this->db->affected_rows() > 0)
        {
            $results = $query->result_array();
        }
        $data['list'] = $results;
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('loan-list',$data);
        $this->load->view('templates-admin/footer',$data);

    }
	

    public function send_to_escrow_for_disbursement()
    {
        $this->load->model('Entryledger');
        $this->load->library('Email');
        require_once APPPATH . "/third_party/excel/PHPExcel.php";
        $this->excel = new PHPExcel();

        $query = $this->db
            ->select("bl.name, email, mobile,
            bank.account_number, bank.ifsc_code,bad.r_city,ll.id,
            ll.loan_no, ll.id, ll.borrower_id, ll.approved_loan_amount, ll.loan_processing_charges, ll.loan_tieup_fee,
            ll.disburse_amount, ll.date_created
            ")
            ->join('p2p_borrowers_list as bl', 'on bl.id = ll.borrower_id')
            ->join('p2p_borrower_bank_details as bank', 'on bank.borrower_id = ll.borrower_id')
            ->join('p2p_borrower_address_details as bad', 'on bad.borrower_id = ll.borrower_id')
            ->get_where('p2p_loan_list as ll', array('ll.disbursement_request' => 1, 'll.disbursed_flag IS NULL' => null));
        if ($this->db->affected_rows() > 0)
        {
            $results = $query->result_array();
            $options = $this->P2padminmodel->getAccount_sendername();
            foreach ($results as $result)
            {
                $results = $query->result_array();
                $query = $this->db->get_where('p2p_borrower_bank_details', array('borrower_id' => $result['borrower_id']));
                if ($this->db->affected_rows() > 0)
                {
                    $this->db->where('id', $result['id']);
                    $this->db->set('disbursed_flag', 1);
                    $this->db->update('p2p_loan_list');
                    $disburse_data[] = array(
                        'amount' => $result['approved_loan_amount'],
                        'debit_account_no' => $options['antworks_idbi_account_no'],
                        'ifsc_code' => $result['ifsc_code'],
                        'benificiary_account_number' => "'" . $result['account_number'],
                        '' => 10,
                        'benificiary_name' => $result['name'],
                        'location' => $result['r_city'],
                        'sender_reciever_info' => $result['loan_no'],
                        'sender_name' => $options['sender_name_to_disburse_file']
                    );
                }
            }


            if ($disburse_data) {
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getStyle("A1:H1")->applyFromArray(array("font" => array("bold" => true)));
                $this->excel->getActiveSheet()->setCellValue('A1', 'Amount');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Debit account no');
                $this->excel->getActiveSheet()->setCellValue('C1', 'IFSC Code');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Benificiary A/c No');
                $this->excel->getActiveSheet()->setCellValue('E1', '');
                $this->excel->getActiveSheet()->setCellValue('F1', 'Benificiary Name');
                $this->excel->getActiveSheet()->setCellValue('G1', 'Location');
                $this->excel->getActiveSheet()->setCellValue('H1', 'Sendar and receiver information');
                $this->excel->getActiveSheet()->setCellValue('I1', 'Sendar Name');
                $this->excel->getActiveSheet()->setTitle('Sheet 1');
                $date_current = 'ant_' . date('YmdHis');
                $this->excel->getActiveSheet()->fromArray($disburse_data, null, 'A2');
                $filename = $date_current . '.xls';
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                //$objWriter->save('just_some_random_name.xls');
                $objWriter->save('document/escrow/' . $filename);

                $result = $this->P2padminmodel->sendDisbursementfiles($filename);

                if ($result) {
//                    $update = $this->P2padminmodel->updateDisburserecords($data);
//                    if($update)
//                    {
//
//                    }


                }

                $this->session->set_flashdata('notification', array('error' => 0, 'message' => 'Send Successfully to IDBI Bank please check your email also'));
                redirect(base_url() . 'p2padmin/list_for_disbursement');
            } else {
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'No record found to send escrow'));
                redirect(base_url() . 'p2padmin/list_for_disbursement');
            }

        } else {
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'No record found to send escrow'));
            redirect(base_url() . 'p2padmin/list_for_disbursement');
        }

    }
    public function disbursement_request_list()
    {
        $results = array();
        $query = $this->db
            ->select("bl.name, email, mobile, 
            ll.loan_no, ll.id, ll.borrower_id, ll.approved_loan_amount, ll.approved_interest, ll.approved_tenor, ll.loan_processing_charges, ll.loan_tieup_fee, ll.disburse_amount, ll.date_created, ll.loan_status")
            ->join('p2p_borrowers_list as bl', 'on bl.id = ll.borrower_id')
            ->get_where('p2p_loan_list as ll', array('ll.disbursement_request' => 1, 'll.disbursed_flag' => 1));
			//echo $this->db->last_query();
        if ($this->db->affected_rows() > 0)
        {
            $results = $query->result_array();
        }
        $data['list'] = $results;
        $data['pageTitle'] = "Active Loan List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('disbursed-request-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }
	 public function loan_disbursed(){
		 $postVal = $this->input->post();
		if (!empty($postVal['loan_no'])) {
			$this->db->where('loan_no', $postVal['loan_no']);
			$this->db->set('loan_status', 1);
			$this->db->set('disburse_amount', $postVal['disburse_amount']);
			$this->db->set('disbursement_date', date('Y-m-d h:i:s'));
			$this->db->update('p2p_loan_list');
			$response['status'] = 1;
			$response['message'] = 'Amount Disbursed Successfully';
			echo json_encode($response);
			exit;
		}else {
			$response['status'] = 0;
			$response['message'] = 'Something wrong!';
			echo json_encode($response);
			exit;
		}	
	 }
    public function send_to_escrow_for_disbursement_old()
    {
        $this->load->model('Entryledger');
        $this->load->library('Email');
        require_once APPPATH . "/third_party/excel/PHPExcel.php";
        $this->excel = new PHPExcel();

        $data = $this->P2padminmodel->send_toescrow_infromation();
        $options = $this->P2padminmodel->getAccount_sendername();
        if ($data) {
            foreach ($data as $record) {
                $disburese_amount = 0;
                $balance = 0;
                $loan_processing_charges = 0;
                $four_percent = 0;
                $four_percent_gst = 0;

                $lender_account = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $record['lenders_id']))->row();
                if ($lender_account->account_balance >= $record['bid_loan_amount']) {
                    if (empty($record['processing_fee']) && $record['processing_fee'] !== '0') {
                        $four_percent = ($record['bid_loan_amount'] * 4) / 100;
                        $four_percent_gst = round($four_percent + ($four_percent * 18) / 100);
                        if ($four_percent_gst > 1000) {
                            $loan_processing_charges = $four_percent_gst;
                        } else {
                            $loan_processing_charges = 1000;
                        }
                    } else {
                        $loan_processing_charges = $record['processing_fee'];
                    }
                    $disburese_amount = $record['bid_loan_amount'] - $loan_processing_charges;
                    $approve_laon_data = array(
                        'bid_registration_id' => $record['bid_registration_id'],
                        'borrower_id' => $record['borrowers_id'],
                        'lender_id' => $record['lenders_id'],
                        'approved_loan_amount' => $record['bid_loan_amount'],
                        'loan_processing_charges' => $loan_processing_charges,
                        'loan_tieup_fee' => 0,
                        'disburse_amount' => $disburese_amount,
                    );
                    $status = $this->P2padminmodel->saveApproveloan_data($approve_laon_data);
                    if ($status === true) {
                        $disburse_data[] = array(
                            'amount' => $disburese_amount,
                            'debit_account_no' => $options['antworks_idbi_account_no'],
                            'ifsc_code' => $record['ifsc_code'],
                            'benificiary_account_number' => "'" . $record['account_number'],
                            '' => 10,
                            'benificiary_name' => $record['borrower_name'],
                            'location' => $record['r_city'],
                            'sender_reciever_info' => 'LoanNo/' . $record['loan_no'] . '/' . $record['lender_escrow_account_number'],
                            'sender_name' => $options['sender_name_to_disburse_file']
                        );
                        //Entry Ledger of lender

                        $balance = $lender_account->account_balance - $record['bid_loan_amount'];
                        $this->db->where('lender_id', $record['lenders_id']);
                        $this->db->set('account_balance', $balance);
                        $this->db->update('p2p_lender_main_balance');

                        $ledger_array = array(
                            'lender_id' => $record['lenders_id'],
                            'type' => 'loan_given',
                            'title' => 'Loan given',
                            'reference_1' => $record['loan_no'],
                            'debit' => $record['bid_loan_amount'],
                            'balance' => $balance,
                        );
                        $this->Entryledger->addlenderstatementEntry($ledger_array);
                    }
                }

            }

            if ($disburse_data) {
                $this->excel->setActiveSheetIndex(0);
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                $this->excel->getActiveSheet()->getStyle("A1:H1")->applyFromArray(array("font" => array("bold" => true)));
                $this->excel->getActiveSheet()->setCellValue('A1', 'Amount');
                $this->excel->getActiveSheet()->setCellValue('B1', 'Debit account no');
                $this->excel->getActiveSheet()->setCellValue('C1', 'IFSC Code');
                $this->excel->getActiveSheet()->setCellValue('D1', 'Benificiary A/c No');
                $this->excel->getActiveSheet()->setCellValue('E1', '');
                $this->excel->getActiveSheet()->setCellValue('F1', 'Benificiary Name');
                $this->excel->getActiveSheet()->setCellValue('G1', 'Location');
                $this->excel->getActiveSheet()->setCellValue('H1', 'Sendar and receiver information');
                $this->excel->getActiveSheet()->setCellValue('I1', 'Sendar Name');
                $this->excel->getActiveSheet()->setTitle('Sheet 1');
                $date_current = 'ant_' . date('YmdHis');
                $this->excel->getActiveSheet()->fromArray($disburse_data, null, 'A2');
                $filename = $date_current . '.xls';
                $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

                //$objWriter->save('just_some_random_name.xls');
                $objWriter->save('document/escrow/' . $filename);

                $result = $this->P2padminmodel->sendDisbursementfiles($filename);

                if ($result) {
//                    $update = $this->P2padminmodel->updateDisburserecords($data);
//                    if($update)
//                    {
//
//                    }


                }

                $this->session->set_flashdata('notification', array('error' => 0, 'message' => 'Send Successfully to IDBI Bank please check your email also'));
                redirect(base_url() . 'p2padmin/p2papplication/approved_application');
            } else {
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'No record found to send escrow'));
                redirect(base_url() . 'p2padmin/p2papplication/approved_application');
            }

        } else {
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'No record found to send escrow'));
            redirect(base_url() . 'p2padmin/p2papplication/approved_application');
        }

    }

    public function TestingSend()
    {
        $this->load->library('Email');
        $this->P2padminmodel->TestingSend();
    }


    /////////////////////////////////////////
    ///
//    public function responseLoanEmi()
//    {
//        require_once APPPATH . "/third_party/excel/PHPExcel.php";
//
//        if (isset($_FILES["responseLoanEmi"]["name"])) {
//
//            $path = $_FILES["responseLoanEmi"]["tmp_name"];
//            $object = PHPExcel_IOFactory::load($path);
//
//            foreach ($object->getWorksheetIterator() as $worksheet) {
//                //print_r($worksheet);
//                $highestRow = $worksheet->getHighestRow();
//                $highestColumn = $worksheet->getHighestColumn();
//                for ($row = 3; $row <= $highestRow; $row++) {
//                    $loan_number = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
//                    $emi_no = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
//                    $lender_account_no = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
//                    $ifsc = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
//                    $lender_debit = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
//                    $lender_credit = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
//                    $amount = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
//                    $lender_escrow_ac = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
//                    $lender_escrow_balance = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
//                    $borrower_escrow_ac = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
//                    $debit = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
//                    $credit = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
//                    $borrower_balance_escrow_ac = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
//                    $date_added = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
//                    $string = PHPExcel_Style_NumberFormat::toFormattedString($date_added, 'Y-m-d H:i:s');
//                    $date_added_escrow = date('Y-m-d H:i:s', strtotime($string));
//                    $exist = $this->Managementmodel->checkresponseLoanEmi_exist($loan_number, $emi_no, $date_added_escrow);
//                    if(!$exist)
//                    {
//                        $data = array(
//                            'loan_number' => $loan_number?$loan_number:'',
//                            'emi_no' => $emi_no?$emi_no:'',
//                            'lender_account_no' => $lender_account_no?$lender_account_no:'',
//                            'ifsc' => $ifsc?$ifsc:'',
//                            'lender_debit' => $lender_debit?$lender_debit:'',
//                            'lender_credit' => $lender_credit?$lender_credit:'',
//                            'amount' => $amount?$amount:'',
//                            'lender_escrow_ac' => $lender_escrow_ac?$lender_escrow_ac:'',
//                            'lender_escrow_balance' => $lender_escrow_balance?$lender_escrow_balance:'',
//                            'borrower_escrow_ac' => $borrower_escrow_ac?$borrower_escrow_ac:'',
//                            'debit' => $debit?$debit:'',
//                            'credit' => $credit?$credit:'',
//                            'borrower_balance_escrow_ac' => $borrower_balance_escrow_ac?$borrower_balance_escrow_ac:'',
//                            'date_added_escrow' => $date_added_escrow?$date_added_escrow:'',
//
//                        );
//                        $status = $this->Managementmodel->model_responseLoanEmi($data);
//                    }
//                }
//            }
//
//
//            if ($status) {
//                $this->session->set_flashdata('notification', array('error' => 0, 'message' => 'File uploaded successfully'));
//                redirect(base_url() . 'dashboard');
//            } else {
//                $this->session->set_flashdata('notification', array('error' => 1, 'message' => 'File not upload contact to admin'));
//                redirect(base_url() . 'dashboard');
//            }
//        }
//    }
//
//    public function uploadRecordsofLoan()
//    {
//    	exit;
//        $this->load->database();
//        if (isset($_POST["submitshreeramfile"])) {
//            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
//            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
//                echo "<pre>";
//                $file = fopen($filename, "r");
//                $firstRow = true;
//                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
//                    if ($firstRow) {
//                        $firstRow = false;
//                    } else {
////                        print_r($importdata); exit;
//
//                        $loan_account_no = $importdata[3];
//                        $emi_date = $importdata[21];
//                        $emi_sql_date = date('Y-m-d', strtotime($importdata[21]));
//                        $disburse_date = date('Y-m-d', strtotime($importdata[1]));
//                        $query = $this->db->select('bid_registration_id, borrowers_id, lenders_id, loan_no, bid_loan_amount, interest_rate, accepted_tenor')->get_where('p2p_bidding_proposal_details', array('loan_no'=>$loan_account_no));
//                        if($this->db->affected_rows()>0)
//                        {
//
//                            $result = (array)$query->row();
//                                $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                $acount_balance = $query->row()->account_balance;
//                                $after_disburse = $acount_balance - ($importdata[13]+$importdata[14]);
//                                $this->db->where('lender_id', $result['lenders_id']);
//                                $this->db->set('account_balance', $after_disburse);
//                                $this->db->update('p2p_lender_main_balance');
//                                $statement = array(
//                                    'lender_id'=>$result['lenders_id'],
//                                    'type'=>'loan_disbursement',
//                                    'title'=>'Loan Disbursement',
//                                    'reference_2'=>$result['loan_no'],
//                                    'debit'=>$importdata[13]+$importdata[14],
//                                    'amount'=>$importdata[13]+$importdata[14],
//                                    'balance'=>$after_disburse,
//                                );
//                                $this->db->insert('p2p_lender_statement_entry', $statement);
//                                $query = $this->db->select('id, loan_id, status')->order_by('id', 'asc')->get_where('p2p_borrower_emi_details', array('loan_id'=>$result['bid_registration_id']));
//
//                                if($this->db->affected_rows()>0){
//
//                                    $emi_results = $query->result_array();
//
//                                    $emi_arr = array(
//                                        'loan_id'=>$result['bid_registration_id'],
//                                        'borrower_id'=>$result['BORROWER_ID'],
//                                        'lender_id '=>$result['user_id_lender'],
//                                        'emi_date'=>$date,
//                                        'emi_amount'=>round($emi),
//                                        'emi_interest'=>round($emi_interest[$i]),
//                                        'emi_principal'=>round($emi_principal[$i]),
//                                        'emi_balance'=>round($emi_balance[$i]),
//                                        'status '=>0,
//                                        'emi_sql_date '=>$date_sql,
//                                    );
//                                    $this->db->insert('p2p_borrower_emi_details',$emi_arr);
//
//                                    if($loan_account_no == 'LN10000000025')
//                                    {
//                                        $emi_num = $importdata[27];
//                                        $emi_ex_num = explode('/', $emi_num);
//                                        $emi_paid_num = $emi_ex_num[0];
//                                        $emi_total = $emi_ex_num[1];
//                                        if($emi_total>1)
//                                        {
//                                           $i = 0;
//                                           for($i = 0; $i< $emi_paid_num; $i++)
//                                           {
//                                              if($emi_results[$i]['status'] == 0)
//                                              {
//                                                  if($importdata[24] == 'DONE')
//                                                  {
//                                                      $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                                      $this->db->set('proposal_status', 1);
//                                                      $this->db->update('p2p_bidding_proposal_details');
//
//                                                      $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                                      $acount_balance = $query->row()->account_balance;
//                                                      $after_emi = $acount_balance + ($importdata[20]);
//
//                                                      $this->db->where('lender_id', $result['lenders_id']);
//                                                      $this->db->set('account_balance', $after_emi);
//                                                      $this->db->update('p2p_lender_main_balance');
//
//                                                      $statement = array(
//                                                          'lender_id'=>$result['lenders_id'],
//                                                          'type'=>'emi_pay',
//                                                          'title'=>'Emi Repayment',
//                                                          'reference_2'=>$result['loan_no'],
//                                                          'credit'=>$importdata[20],
//                                                          'amount'=>$importdata[20],
//                                                          'balance'=>$after_emi,
//                                                      );
//                                                      $this->db->insert('p2p_lender_statement_entry', $statement);
//
//                                                      $this->db->where('id', $emi_results[$i]['id']);
//                                                      $this->db->set('emi_sql_date', $emi_sql_date);
//                                                      $this->db->set('status', 1);
//                                                      $this->db->update('p2p_borrower_emi_details');
//                                                  }
//                                              }
//                                           }
//                                        }
//                                    }
//                                    else{
//                                        if($importdata[24] == 'DONE')
//                                        {
//                                            $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                            $this->db->set('proposal_status', 2);
//                                            $this->db->update('p2p_bidding_proposal_details');
//
//                                            $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                            $acount_balance = $query->row()->account_balance;
//                                            $after_emi = $acount_balance + ($importdata[15]+$importdata[16]);
//
//                                            $this->db->where('lender_id', $result['lenders_id']);
//                                            $this->db->set('account_balance', $after_emi);
//                                            $this->db->update('p2p_lender_main_balance');
//
//                                            $statement = array(
//                                                'lender_id'=>$result['lenders_id'],
//                                                'type'=>'emi_pay',
//                                                'title'=>'Emi Payment',
//                                                'reference_2'=>$result['loan_no'],
//                                                'credit'=>$importdata[15]+$importdata[16],
//                                                'amount'=>$importdata[15]+$importdata[16],
//                                                'balance'=>$after_emi,
//                                            );
//                                            $this->db->insert('p2p_lender_statement_entry', $statement);
//
//                                            $this->db->where('loan_id', $result['bid_registration_id']);
//                                            $this->db->set('emi_sql_date', $emi_sql_date);
//                                            $this->db->set('status', 1);
//                                            $this->db->update('p2p_borrower_emi_details');
//                                        }
//                                        else{
//                                        $this->db->where('loan_id', $result['bid_registration_id']);
//                                        $this->db->set('emi_sql_date', $emi_sql_date);
//                                        $this->db->update('p2p_borrower_emi_details');
//                                    }
//                                    }
//                                }
//                                else{
//
//
//                                    if($importdata[25] == 'DONE')
//                                    {
//
//                                        $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                        $this->db->set('proposal_status', 2);
//                                        $this->db->update('p2p_bidding_proposal_details');
//                                        $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                        $acount_balance = $query->row()->account_balance;
//                                        $after_emi = $acount_balance + ($importdata[15]+$importdata[16]);
//                                        $this->db->where('lender_id', $result['lenders_id']);
//                                        $this->db->set('account_balance', $after_emi);
//                                        $this->db->update('p2p_lender_main_balance');
//                                        $statement = array(
//                                            'lender_id'=>$result['lenders_id'],
//                                            'type'=>'emi_pay',
//                                            'title'=>'Emi Payment',
//                                            'reference_2'=>$result['loan_no'],
//                                            'credit'=>$importdata[15]+$importdata[16],
//                                            'amount'=>$importdata[15]+$importdata[16],
//                                            'balance'=>$after_emi,
//                                        );
//                                        $this->db->insert('p2p_lender_statement_entry', $statement);
//
//
//                                        $numerator = $result['bid_loan_amount'] * pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']);
//                                        $denominator = 100 * 12 * (pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']) - 1) / $result['interest_rate'];
//                                        $emi = ($numerator / $denominator);
//                                        $emi_interest = array();
//                                        $emi_principal = array();
//                                        $emi_balance = array();
//                                        for ($i = 1; $i <= $result['accepted_tenor']; $i++) {
//
//                                            if ($i == 1) {
//                                                $emi_sn[$i] = "Month " . $i;
//                                                $emi_interest[$i] = ($result['bid_loan_amount'] * $result['interest_rate'] / 1200);
//                                                $emi_principal[$i] = $emi - $emi_interest[$i];
//                                                $emi_balance[$i] = $result['bid_loan_amount'] - $emi_principal[$i];
//                                            } else if ($i < 37) {
//                                                $emi_sn[$i] = "Month " . $i;
//                                                $emi_interest[$i] = ($emi_balance[$i - 1] * $result['interest_rate'] / 1200);
//                                                $emi_principal[$i] = $emi - $emi_interest[$i];
//                                                $emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
//                                            } else if ($i >= 37) {
//                                                break;
//                                            }
//                                            $day = date('j');
//                                            if ($day >= 8) {
//
//                                                $date = date('07/F/Y', strtotime('+' . $i . ' month'));
//                                                $date_sql = date('Y-m-07',  strtotime('+' . $i . ' month'));
//                                                //echo "<br>";
//                                            } else {
//                                                if ($i == 1) {
//                                                    $date = date('07/F/Y');
//                                                    $date_sql = date('Y-m-07');
//                                                    //echo "<br>";
//                                                } else {
//
//                                                    $date = date('07/F/Y', strtotime('+' . $i-1 . ' month'));
//                                                    $date_sql = date('Y-m-07',  strtotime('+' . $i-1 . ' month'));
//                                                    //echo "<br>";
//                                                }
//
//                                            }
//                                            if($result['accepted_tenor'] <= 3)
//                                            {
//                                                $date_sql = date('Y-m-d', strtotime('+1 month', strtotime($disburse_date)));
//                                            }
//                                            $emi_num = $importdata[27];
//                                            $emi_ex_num = explode('/', $emi_num);
//                                            $emi_paid_num = $emi_ex_num[0];
//                                            $emi_total = $emi_ex_num[1];
//
//                                            $emi_arr = array(
//                                                'loan_id'=>$result['bid_registration_id'],
//                                                'borrower_id'=>$result['borrowers_id'],
//                                                'lender_id '=>$result['lenders_id'],
//                                                'emi_date'=>$date_sql,
//                                                'emi_amount'=>round($emi),
//                                                'emi_interest'=>round($emi_interest[$i]),
//                                                'emi_principal'=>round($emi_principal[$i]),
//                                                'emi_balance'=>round($emi_balance[$i]),
//                                                'status '=>1,
//                                                'emi_sql_date '=>$date_sql,
//                                            );
//                                            $this->db->insert('p2p_borrower_emi_details',$emi_arr);
//                                        }
//
//                                    }
//                                    else{
//                                        $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                        $this->db->set('proposal_status', 1);
//                                        $this->db->update('p2p_bidding_proposal_details');
//
//                                        $numerator = $result['bid_loan_amount'] * pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']);
//                                        $denominator = 100 * 12 * (pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']) - 1) / $result['interest_rate'];
//                                        $emi = ($numerator / $denominator);
//                                        $emi_interest = array();
//                                        $emi_principal = array();
//                                        $emi_balance = array();
//                                        for ($i = 1; $i <= $result['accepted_tenor']; $i++) {
//
//                                            if ($i == 1) {
//                                                $emi_sn[$i] = "Month " . $i;
//                                                $emi_interest[$i] = ($result['bid_loan_amount'] * $result['interest_rate'] / 1200);
//                                                $emi_principal[$i] = $emi - $emi_interest[$i];
//                                                $emi_balance[$i] = $result['bid_loan_amount'] - $emi_principal[$i];
//                                            } else if ($i < 37) {
//                                                $emi_sn[$i] = "Month " . $i;
//                                                $emi_interest[$i] = ($emi_balance[$i - 1] * $result['interest_rate'] / 1200);
//                                                $emi_principal[$i] = $emi - $emi_interest[$i];
//                                                $emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
//                                            } else if ($i >= 37) {
//                                                break;
//                                            }
//                                            $day = date('j');
//                                            if ($day >= 8) {
//
//                                                $date = date('07/F/Y', strtotime('+' . $i . ' month'));
//                                                $date_sql = date('Y-m-07',  strtotime('+' . $i . ' month'));
//                                                //echo "<br>";
//                                            } else {
//                                                if ($i == 1) {
//                                                    $date = date('07/F/Y');
//                                                    $date_sql = date('Y-m-07');
//                                                    //echo "<br>";
//                                                } else {
//
//                                                    $date = date('07/F/Y', strtotime('+' . $i-1 . ' month'));
//                                                    $date_sql = date('Y-m-07',  strtotime('+' . $i-1 . ' month'));
//                                                    //echo "<br>";
//                                                }
//
//                                            }
//                                            if($result['accepted_tenor'] <= 3)
//                                            {
//                                                $date_sql = date('Y-m-d', strtotime('+1 month', strtotime($disburse_date)));
//                                            }
//                                            $emi_arr = array(
//                                                'loan_id'=>$result['bid_registration_id'],
//                                                'borrower_id'=>$result['borrowers_id'],
//                                                'lender_id '=>$result['lenders_id'],
//                                                'emi_date'=>$date_sql,
//                                                'emi_amount'=>round($emi),
//                                                'emi_interest'=>round($emi_interest[$i]),
//                                                'emi_principal'=>round($emi_principal[$i]),
//                                                'emi_balance'=>round($emi_balance[$i]),
//                                                'status '=>0,
//                                                'emi_sql_date '=>$date_sql,
//                                            );
//                                            $this->db->insert('p2p_borrower_emi_details',$emi_arr);
//                                        }
//                                    }
//                                }
//
//                        }
//                        else{
//                            echo $loan_account_no;
//                            echo "Not FOUND";
//                        }
//
//
//
//                        //print_r($importdata);
//                    }
//                }
//
//                fclose($file);
//                exit;
//            } else {
//                echo $msg = "Something went wrong..";
//                exit;
//            }
//        }
//    }
//
//	public function uploadRecordsofLoanCopy()
//	{
//		$this->load->database();
//		if (isset($_POST["submitshreeramfile"])) {
//			$filename = $_FILES["shreeramResponsefile"]["tmp_name"];
//			if ($_FILES["shreeramResponsefile"]["size"] > 0) {
//				echo "<pre>";
//				$file = fopen($filename, "r");
//				$firstRow = true;
//				while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
//
//					if ($firstRow) {
//						$firstRow = false;
//					} else {
////
//						$disburse_date = date('Y-m-d', strtotime($importdata[1]));
//						$query = $this->db->select('bid_registration_id, borrowers_id, lenders_id, loan_no, bid_loan_amount, interest_rate, accepted_tenor')->get_where('p2p_bidding_proposal_details', array('loan_no'=>$importdata[4]));
//						if($this->db->affected_rows()>0)
//						{
//							$result = (array)$query->row();
//							$this->db->get_where('p2p_borrower_emi_details', array('bid_registration_id', $result['bid_registration_id']));
//                            if($this->db->affected_rows()>0) {
//							}
//                            else{
//
//								$numerator = $result['bid_loan_amount'] * pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']);
//								$denominator = 100 * 12 * (pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']) - 1) / $result['interest_rate'];
//								$emi = ($numerator / $denominator);
//								$emi_interest = array();
//								$emi_principal = array();
//								$emi_balance = array();
//								for ($i = 1; $i <= $result['accepted_tenor']; $i++) {
//
//									if ($i == 1) {
//										$emi_sn[$i] = "Month " . $i;
//										$emi_interest[$i] = ($result['bid_loan_amount'] * $result['interest_rate'] / 1200);
//										$emi_principal[$i] = $emi - $emi_interest[$i];
//										$emi_balance[$i] = $result['bid_loan_amount'] - $emi_principal[$i];
//									} else if ($i < 37) {
//										$emi_sn[$i] = "Month " . $i;
//										$emi_interest[$i] = ($emi_balance[$i - 1] * $result['interest_rate'] / 1200);
//										$emi_principal[$i] = $emi - $emi_interest[$i];
//										$emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
//									} else if ($i >= 37) {
//										break;
//									}
//
//									$date_sql = date('Y-m-d', strtotime('+'.$i.' month', strtotime($disburse_date)));
//
//
//
//
//									$emi_arr = array(
//										'loan_id' => $result['bid_registration_id'],
//										'borrower_id' => $result['borrowers_id'],
//										'lender_id ' => $result['lenders_id'],
//										'emi_date' => $date_sql,
//										'emi_amount' => round($emi),
//										'emi_interest' => round($emi_interest[$i]),
//										'emi_principal' => round($emi_principal[$i]),
//										'emi_balance' => round($emi_balance[$i]),
//										'emi_sql_date ' => $date_sql,
//									);
//									$this->db->insert('p2p_borrower_emi_details', $emi_arr);
//								}
//							}
//						}
//
//					}
//				}
//
////				$this->db->select('bid_registration_id');
////				$this->db->from('p2p_loan_aggrement_signature');
////				$this->db->where_in('bid_registration_id', $bid_ids);
////                $this->db->get();
////				echo "<pre>"; echo $this->db->last_query();
//				fclose($file);
//				exit;
//			} else {
//				echo $msg = "Something went wrong..";
//				exit;
//			}
//		}
//	}
//
//    public function uploadRecordsofLoand()
//    { exit;
//        echo "<pre>";
//        $this->load->database();
//        if (isset($_POST["submitshreeramfile"])) {
//            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
//            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
//                echo "<pre>";
//                $file = fopen($filename, "r");
//                $firstRow = true;
//                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
//                    if ($firstRow) {
//                        $firstRow = false;
//                    } else {
//                        print_r($importdata); exit;
//
//                        $loan_account_no = $importdata[3];
//                        $emi_date = $importdata[21];
//                        $emi_sql_date = date('Y-m-d', strtotime($importdata[21]));
//                        $query = $this->db->select('bid_registration_id, borrowers_id, lenders_id, loan_no')->get_where('p2p_bidding_proposal_details', array('loan_no'=>$loan_account_no));
//                        if($this->db->affected_rows()>0)
//                        {
//
//                            $result = (array)$query->row();
//                            if($importdata[2] != 'BR10002813')
//                            {
//                                $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                $acount_balance = $query->row()->account_balance;
//                                $after_disburse = $acount_balance - ($importdata[13]+$importdata[14]);
//                                $this->db->where('lender_id', $result['lenders_id']);
//                                $this->db->set('account_balance', $after_disburse);
//                                $this->db->update('p2p_lender_main_balance');
//                                $statement = array(
//                                    'lender_id'=>$result['lenders_id'],
//                                    'type'=>'loan_disbursement',
//                                    'title'=>'Loan Disbursement',
//                                    'reference_2'=>$result['loan_no'],
//                                    'debit'=>$importdata[13]+$importdata[14],
//                                    'amount'=>$importdata[13]+$importdata[14],
//                                    'balance'=>$after_disburse,
//                                );
//                                $this->db->insert('p2p_lender_statement_entry', $statement);
//                                $query = $this->db->select('id')->get_where('p2p_borrower_emi_details', array('loan_id'=>$result['bid_registration_id']));
//                                if($this->db->affected_rows()>0){
//                                    $results = $query->result_array();
//                                    print_r($results); exit;
//                                    $emi_num = $importdata[27];
//                                    $emi_ex_num = export('/', $emi_num);
//                                    if($emi_ex_num)
//                                    {
//                                        $emi_paid_num = $emi_ex_num[0];
//                                        $emi_total = $emi_ex_num[0];
//
//                                    }
//                                    else{
//
//                                    }
//
//                                    foreach ($results AS $result){
//
//                                    }
//                                    if($importdata[24] == 'DONE')
//                                    {
//                                        $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                        $this->db->set('proposal_status', 2);
//                                        $this->db->update('p2p_bidding_proposal_details');
//
//                                        $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                        $acount_balance = $query->row()->account_balance;
//                                        $after_emi = $acount_balance + ($importdata[15]+$importdata[16]);
//
//                                        $this->db->where('lender_id', $result['lenders_id']);
//                                        $this->db->set('account_balance', $after_emi);
//                                        $this->db->update('p2p_lender_main_balance');
//
//                                        $statement = array(
//                                            'lender_id'=>$result['lenders_id'],
//                                            'type'=>'emi_pay',
//                                            'title'=>'Emi Payment',
//                                            'reference_2'=>$result['loan_no'],
//                                            'credit'=>$importdata[15]+$importdata[16],
//                                            'amount'=>$importdata[15]+$importdata[16],
//                                            'balance'=>$after_emi,
//                                        );
//                                        $this->db->insert('p2p_lender_statement_entry', $statement);
//
//                                        $this->db->where('loan_id', $result['bid_registration_id']);
//                                        $this->db->set('emi_sql_date', $emi_sql_date);
//                                        $this->db->set('status', 1);
//                                        $this->db->update('p2p_borrower_emi_details');
//                                    }
//                                    else{
//                                        $this->db->where('loan_id', $result['bid_registration_id']);
//                                        $this->db->set('emi_sql_date', $emi_sql_date);
//                                        $this->db->update('p2p_borrower_emi_details');
//                                    }
//                                }
//                                else{
//
//                                    if($importdata[24] == 'DONE')
//                                    {
//                                        $this->db->where('bid_registration_id', $result['bid_registration_id']);
//                                        $this->db->set('proposal_status', 2);
//                                        $this->db->update('p2p_bidding_proposal_details');
//                                        $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                        $acount_balance = $query->row()->account_balance;
//                                        $after_emi = $acount_balance + ($importdata[15]+$importdata[16]);
//                                        $this->db->where('lender_id', $result['lenders_id']);
//                                        $this->db->set('account_balance', $after_emi);
//                                        $this->db->update('p2p_lender_main_balance');
//                                        $statement = array(
//                                            'lender_id'=>$result['lenders_id'],
//                                            'type'=>'emi_pay',
//                                            'title'=>'Emi Payment',
//                                            'reference_2'=>$result['loan_no'],
//                                            'credit'=>$importdata[15]+$importdata[16],
//                                            'amount'=>$importdata[15]+$importdata[16],
//                                            'balance'=>$after_emi,
//                                        );
//                                        $this->db->insert('p2p_lender_statement_entry', $statement);
//
//
//                                        $emai_arr = array(
//                                            'loan_id'=>$result['bid_registration_id'],
//                                            'borrower_id'=>$result['borrowers_id'],
//                                            'lender_id'=>$result['lenders_id'],
//                                            'emi_date'=>$emi_sql_date,
//                                            'emi_amount'=>$importdata[18],
//                                            'emi_interest'=>$importdata[16],
//                                            'emi_principal'=>$importdata[13]+$importdata[14],
//                                            'status'=>1,
//                                            'emi_sql_date'=> $emi_sql_date,
//
//                                        );
//
//                                    }
//                                    else{
//                                        $emai_arr = array(
//                                            'loan_id'=>$result['bid_registration_id'],
//                                            'borrower_id'=>$result['borrowers_id'],
//                                            'lender_id'=>$result['lenders_id'],
//                                            'emi_date'=>$emi_sql_date,
//                                            'emi_amount'=>$importdata[18],
//                                            'emi_interest'=>$importdata[16],
//                                            'emi_principal'=>$importdata[13]+$importdata[14],
//                                            'status'=>0,
//                                            'emi_sql_date'=> $emi_sql_date,
//
//                                        );
//                                    }
//
//                                    $this->db->insert('p2p_borrower_emi_details', $emai_arr);
//                                }
//                            }
//                            else{
//                                $query = $this->db->get_where('p2p_lender_main_balance', array('lender_id'=>$result['lenders_id']));
//                                $acount_balance = $query->row()->account_balance;
//                                $after_disburse = $acount_balance - ($importdata[13]+$importdata[14]);
//                                $this->db->where('lender_id', $result['lenders_id']);
//                                $this->db->set('account_balance', $after_disburse);
//                                $this->db->update('p2p_lender_main_balance');
//                                $statement = array(
//                                    'lender_id'=>$result['lenders_id'],
//                                    'type'=>'loan_disbursement',
//                                    'title'=>'Loan Disbursement',
//                                    'reference_2'=>$result['loan_no'],
//                                    'debit'=>$importdata[13]+$importdata[14],
//                                    'amount'=>$importdata[13]+$importdata[14],
//                                    'balance'=>$after_disburse,
//                                );
//                                $this->db->insert('p2p_lender_statement_entry', $statement);
//                            }
//
//                        }
//                        else{
//                            echo $loan_account_no;
//                            echo "Not FOUND";
//                        }
//
//
//
//                        //print_r($importdata);
//                    } exit;
//                }
//
//                fclose($file);
//                exit;
//            } else {
//                echo $msg = "Something went wrong..";
//                exit;
//            }
//        }
//    }
//
//	public function updateEmirecords()
//	{
//		$disBurseresults = $this->db->select('bid_registration_id, date_created')->order_by('bid_registration_id', 'asc')->get_where('p2p_disburse_loan_details')->result_array();
//		if($this->db->affected_rows()>0)
//		{
//			foreach ($disBurseresults AS $disBurseresult)
//			{
//				$disburse_date = date('Y-m-d', strtotime($disBurseresult['date_created']));
//				$query = $this->db->select('bid_registration_id, borrowers_id, lenders_id, loan_no, bid_loan_amount, interest_rate, accepted_tenor')->get_where('p2p_bidding_proposal_details', array('bid_registration_id'=>$disBurseresult['bid_registration_id']));
//				if($this->db->affected_rows()>0)
//				{
//					$result = (array)$query->row();
//					$query = $this->db->get_where('p2p_borrower_emi_details', array('loan_id'=> $result['bid_registration_id']));
//
//					if($this->db->affected_rows()>0) {
//						$bid_details = $query->row();
//                       if($bid_details->emi_date == '1970-02-01')
//					   {
//						   $date_sql = date('Y-m-d', strtotime('+1 month', strtotime($disburse_date)));
//						   $this->db->where('id', $bid_details->id);
//						   $this->db->set('emi_date', $date_sql);
//						   $this->db->update('p2p_borrower_emi_details');
//					   }
//					}
//					else{
//						$numerator = $result['bid_loan_amount'] * pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']);
//						$denominator = 100 * 12 * (pow((1 + $result['interest_rate'] / (12 * 100)), $result['accepted_tenor']) - 1) / $result['interest_rate'];
//						$emi = ($numerator / $denominator);
//						$emi_interest = array();
//						$emi_principal = array();
//						$emi_balance = array();
//						for ($i = 1; $i <= $result['accepted_tenor']; $i++) {
//
//							if ($i == 1) {
//								$emi_sn[$i] = "Month " . $i;
//								$emi_interest[$i] = ($result['bid_loan_amount'] * $result['interest_rate'] / 1200);
//								$emi_principal[$i] = $emi - $emi_interest[$i];
//								$emi_balance[$i] = $result['bid_loan_amount'] - $emi_principal[$i];
//							} else if ($i < 37) {
//								$emi_sn[$i] = "Month " . $i;
//								$emi_interest[$i] = ($emi_balance[$i - 1] * $result['interest_rate'] / 1200);
//								$emi_principal[$i] = $emi - $emi_interest[$i];
//								$emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
//							} else if ($i >= 37) {
//								break;
//							}
//
//							$date_sql = date('Y-m-d', strtotime('+'.$i.' month', strtotime($disburse_date)));
//							$emi_arr = array(
//								'loan_id' => $result['bid_registration_id'],
//								'borrower_id' => $result['borrowers_id'],
//								'lender_id ' => $result['lenders_id'],
//								'emi_date' => $date_sql,
//								'emi_amount' => round($emi),
//								'emi_interest' => round($emi_interest[$i]),
//								'emi_principal' => round($emi_principal[$i]),
//								'emi_balance' => round($emi_balance[$i]),
//								'emi_sql_date ' => $date_sql,
//							);
//							$this->db->insert('p2p_borrower_emi_details', $emi_arr);
//						}
//					}
//				}
//			}
//
//		}
//	}
//
//	public function updateDisburseid()
//	{
//		$disBurseresults = $this->db->select('id, bid_registration_id, date_created')->order_by('bid_registration_id', 'asc')->get_where('p2p_disburse_loan_details')->result_array();
//		if ($this->db->affected_rows() > 0) {
//
//			foreach ($disBurseresults AS $disBurseresult) {
//				$this->db->where('loan_id', $disBurseresult['bid_registration_id']);
//				$this->db->set('disburse_loan_id', $disBurseresult['id']);
//				$this->db->update('p2p_borrower_emi_details');
//			}
//		}
//	}

    public function uploadEmidetails()
    {
        exit;
        $this->load->database();
        if (isset($_POST["submitshreeramfile"])) {
            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
                echo "<pre>";
                $file = fopen($filename, "r");
                $firstRow = true;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($firstRow) {
//						echo "<pre>";
//						print_r($importdata); exit;
                        $firstRow = false;
                    } else {
//
                        if ($importdata[27] == 'DONE') {
                            $paid_date = date('Y-m-d', strtotime($importdata[24]));
                            $query = $this->db->select('bid_registration_id, borrowers_id, lenders_id, loan_no, bid_loan_amount, interest_rate, accepted_tenor')->get_where('p2p_bidding_proposal_details', array('loan_no' => $importdata[4]));

                            if ($this->db->affected_rows() > 0) {
                                $result = (array)$query->row();

                                $disburse_loan = (array)$this->db->get_where('p2p_disburse_loan_details', array('bid_registration_id' => $result['bid_registration_id']))->row();
//							echo "<pre>"; print_r($disburse_loan); exit;
                                $query = $this->db->get_where('p2p_borrower_emi_details', array('disburse_loan_id' => $disburse_loan['id']));
                                if ($this->db->affected_rows() > 0) {
                                    $emi_id = $query->row()->id;
                                    $this->db->where('disburse_loan_id', $disburse_loan['id']);
                                    $this->db->where('id', $emi_id);
                                    $this->db->set('status', 1);
                                    $this->db->update('p2p_borrower_emi_details');

                                    $this->db->get_where('p2p_emi_payment_details', array('emi_id' => $emi_id));
                                    if ($this->db->affected_rows() <= 0) {
                                        $emi_details_array = array(
                                            'loan_id' => $disburse_loan['id'],
                                            'emi_id' => $emi_id,
                                            'referece' => $importdata[28],
                                            'emi_payment_amount' => (int)$importdata[25],
                                            'emi_payment_date' => $paid_date,
                                            'emi_payment_mode' => '',
                                            'remarks' => $importdata[28],
                                        );
                                        $this->db->insert('p2p_emi_payment_details', $emi_details_array);
                                        $this->db->where('id', $disburse_loan['id']);
                                        $this->db->set('loan_status', '1');
                                        $this->db->update('p2p_disburse_loan_details');
                                    } else {

                                    }
                                }
                            }
                        }

                    }
                }
                fclose($file);
                exit;
            } else {
                echo $msg = "Something went wrong..";
                exit;
            }
        }
    }

    public function updateEscrow()
    {
        exit;
        $results = $this->db->select("dld.approved_loan_amount as amount, dld.lender_id, dld.date_created, bpd.loan_no, '1' as debit")
            ->join('p2p_bidding_proposal_details as bpd', 'ON bpd.bid_registration_id = dld.bid_registration_id')->get_where('p2p_disburse_loan_details as dld')->result_array();

        $results_emi = $this->db->select("bed.emi_amount as amount, epd.referece as loan_no, bed.lender_id, epd.emi_payment_date as date_created,  '1' as repayment")
            ->join('p2p_emi_payment_details as epd', 'ON epd.emi_id = bed.id')
            ->join('p2p_bidding_proposal_details as bpd', 'ON bpd.bid_registration_id = bed.loan_id')
            ->get_where('p2p_borrower_emi_details as bed', array('status' => 1))->result_array();

        $results_pay_in = $this->db->select("lender_id, transaction_id as loan_no, amount, created_date as date_created, '1' as pay_in")->get_where('p2p_lender_pay_in')->result_array();
        $results_pay_out = $this->db->select("lender_id, transaction_id as loan_no, amount, created_date as date_created,  '1' as debit, '1' as pay_out")->get_where('p2p_lender_pay_out')->result_array();

        $main = array_merge($results, $results_emi, $results_pay_in, $results_pay_out);

        usort($main, function ($a, $b) {
            $ad = new DateTime($a['date_created']);
            $bd = new DateTime($b['date_created']);

            if ($ad == $bd) {
                return 0;
            }

            return $ad < $bd ? -1 : 1;
        });


        //echo count($main); exit;
        $i = 0;

        foreach ($main as $records) {
            $ledger_array = array();
            if (@$records['debit'] == 1) {
                $balance = 0;
                $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $records['lender_id']));
                if ($this->db->affected_rows() > 0) {
                    $res = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $records['lender_id']))->row();
                    $balance = $res->account_balance - $records['amount'];
                    $this->db->where('lender_id', $records['lender_id']);
                    $this->db->set('account_balance', $balance);
                    $this->db->update('p2p_lender_main_balance');
                } else {
                    $balance = 0 - $records['amount'];
                    $this->db->set('lender_id', $records['lender_id']);
                    $this->db->set('account_balance', $balance);
                    $this->db->insert('p2p_lender_main_balance');

                }
                if (@$records['debit'] == 1) {
                    $type = 'loan_given';
                    $title = 'Loan given';
                }
                if (@$records['pay_out'] == 1) {
                    $type = 'pay_out';
                    $title = 'Payouts';
                }

                $ledger_array = array(
                    'lender_id' => $records['lender_id'],
                    'type' => $type,
                    'title' => $title,
                    'reference_1' => $records['loan_no'],
                    'debit' => $records['amount'],
                    'balance' => $balance,
                    'created_date' => $records['date_created']
                );
                $this->db->insert('p2p_lender_statement_entry', $ledger_array);
            } else {
                $balance = 0;
                $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $records['lender_id']));
                if ($this->db->affected_rows() > 0) {
                    $res = $this->db->get_where('p2p_lender_main_balance', array('lender_id' => $records['lender_id']))->row();
                    $balance = ($res->account_balance) + ($records['amount']);
                    $this->db->where('lender_id', $records['lender_id']);
                    $this->db->set('account_balance', $balance);
                    $this->db->update('p2p_lender_main_balance');
                } else {
                    $this->db->set('lender_id', $records['lender_id']);
                    $this->db->set('account_balance', $records['amount']);
                    $this->db->insert('p2p_lender_main_balance');
                    $balance = $records['amount'];
                }
                if ($records['repayment'] == 1) {
                    $type = "repayment_received";
                    $title = "Repayment Received";
                }
                if ($records['pay_in'] == 1) {
                    $type = "pay_in";
                    $title = "Money brought in (payin)";
                }
                $ledger_array = array(
                    'lender_id' => $records['lender_id'],
                    'type' => $type,
                    'title' => $title,
                    'reference_1' => $records['loan_no'],
                    'credit' => $records['amount'],
                    'balance' => $balance,
                    'created_date' => $records['date_created']
                );
                $this->db->insert('p2p_lender_statement_entry', $ledger_array);
            }

            echo $i++;
            echo "<br>";

        }
    }

    public function cancelLoan()
    {
        exit;
        if (isset($_POST["submitshreeramfile"])) {
            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
                echo "<pre>";
                $file = fopen($filename, "r");
                $firstRow = true;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($firstRow) {
                        $firstRow = false;
                    } else {
                        $bid_registration_id = $this->db->select('bid_registration_id')->get_where('p2p_bidding_proposal_details', array('loan_no' => $importdata[4]))->row()->bid_registration_id;
                        if ($bid_registration_id) {
                            $this->db->where('bid_registration_id', $bid_registration_id);
                            $this->db->delete('p2p_bidding_proposal_details');

                            $this->db->where('loan_id', $bid_registration_id);
                            $this->db->delete('p2p_borrower_emi_details');

                            $this->db->where('bid_registration_id', $bid_registration_id);
                            $this->db->delete('p2p_disburse_loan_details');

                            $this->db->where('bid_registration_id', $bid_registration_id);
                            $this->db->delete('p2p_loan_aggrement_signature');

                            $this->db->where('bid_registration_id', $bid_registration_id);
                            $this->db->delete('p2p_lender_lock_amount');

                        } else {
                            echo $importdata[4] . 'Not Found';
                        }


                    }
                }
                fclose($file);
                echo "Done";
                exit;
            } else {
                echo $msg = "Something went wrong..";
                exit;
            }
        }
    }

    public function downloadLenders()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Lenderlist.csv";
        $result = $this->db->select('ll.name, ll.mobile, ll.email, ll.dob, ll.status, la.address1, la.address2, la.city, se.state, la.pincode, q.qualification, o.name as qualification')
            ->join('p2p_lender_address la', 'ON la.lender_id = ll.user_id', 'left')
            ->join('p2p_state_experien se', 'ON se.code = la.state', 'left')
            ->join('p2p_qualification q', 'ON q.id = ll.qualification', 'left')
            ->join('p2p_occupation_details_table o', 'ON o.id = ll.qualification', 'left')
            ->get_where('p2p_lender_list as ll');
        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            return false;
        }
    }

    public function updatepaidEmidate()
    {
        exit;
        $loan_paid_date = array();
        if (isset($_POST["submitshreeramfile"])) {
            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
                echo "<pre>";
                $file = fopen($filename, "r");
                $firstRow = true;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($firstRow) {
//						echo "<pre>";
//						print_r($importdata); exit;
                        $firstRow = false;
                    } else {
                        $loan_paid_date[$importdata[4]] = date('Y-m-d H:i:s', strtotime($importdata[24]));
                    }
                }
                fclose($file);
                $results = $this->db->select("bpd.loan_no, epd.emi_payment_date, epd.id")
                    ->join('p2p_disburse_loan_details dld', 'on dld.id = epd.loan_id')
                    ->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id')
                    ->get_where('p2p_emi_payment_details epd', array('epd.emi_payment_mode' => ''))
                    ->result_array();
                $i = 0;
                echo count($results);
                foreach ($results as $result) {
                    if (array_key_exists($result['loan_no'], $loan_paid_date)) {
                        echo $result['loan_no'] . '--' . $loan_paid_date[$result['loan_no']] . '--' . $result['emi_payment_date'];

                        echo "<br>";
//                      $this->db->where('id', $result['id']);
//                      $this->db->set('emi_payment_date', $loan_paid_date[$result['loan_no']]);
//					  $this->db->update('p2p_emi_payment_details');
                    }
                }

                //print_r($results); exit;
                //print_r($loan_paid_date);
                exit;
            } else {
                echo $msg = "Something went wrong..";
                exit;
            }
        }
    }

    public function updateWebhokpaidemidate()
    {
        exit;
        $results = $this->db->select("bpd.loan_no, epd.emi_payment_date, epd.id, remarks")
            ->join('p2p_disburse_loan_details dld', 'on dld.id = epd.loan_id')
            ->join('p2p_bidding_proposal_details bpd', 'on bpd.bid_registration_id = dld.bid_registration_id')
            ->get_where('p2p_emi_payment_details epd', array('epd.emi_payment_mode' => 'Razorpay Webhook'))
            ->result_array();
        foreach ($results as $result) {
            $emi_date_array = explode(',', $result['remarks']);
            $this->db->where('id', $result['id']);
            $this->db->set('emi_payment_date', $emi_date_array[1]);
            $this->db->update('p2p_emi_payment_details');
        }
    }

    public function doenloadEscrowresponse()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Experian_Algo.csv";
        $result = $this->db->select("bl.borrower_id,
		 IF(br.created_date > '2020-05-04 12:34:53', 'bureau', 'AR') AS Experian,
		 br.experian_score, br.antworksp2p_rating, br.overall_leveraging_ratio, 
		br.leverage_ratio_maximum_available_credit, br.limit_utilization_revolving_credit, br.outstanding_to_limit_term_credit, 
		br.outstanding_to_limit_term_credit_including_past_facilities, br.short_term_leveraging, br.revolving_credit_line_to_total_credit, 
		br.short_term_credit_to_total_credit, br.secured_facilities_to_total_credit, br.fixed_obligation_to_income, 
		br.no_of_active_accounts, br.variety_of_loans_active, br.no_of_credit_enquiry_in_last_3_months, 
		br.no_of_loans_availed_to_credit_enquiry_in_last_12_months, br.history_of_credit_oldest_credit_account, 
		br.limit_breach, overdue_to_obligation, br.overdue_to_monthly_income, 
		br.number_of_instances_of_delay_in_past_6_months, br.number_of_instances_of_delay_in_past_12_months, 
		br.number_of_instances_of_delay_in_past_36_months, br.created_date")
            ->join('p2p_borrowers_list bl', 'ON bl.id = br.borrower_id', 'left')
            ->where_in('bl.id', array('20079', '20161', '20156', '20048', '20158'))
            ->order_by('br.id', 'desc')
            ->get_where('ant_borrower_rating br');

        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            return false;
        }
    }

    public function uploadBorrower()
    {
        $this->load->model('Borroweraddmodel');
        $this->load->library('form_validation');
        if (isset($_POST["submitshreeramfile"])) {
            $filename = $_FILES["shreeramResponsefile"]["tmp_name"];
            if ($_FILES["shreeramResponsefile"]["size"] > 0) {
                echo "<pre>";
                $file = fopen($filename, "r");
                $firstRow = true;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($firstRow) {
//						echo "<pre>";
//						print_r($importdata); exit;
                        $firstRow = false;
                    } else {
                        unset($_POST);
                        $dob_arr = explode('/', $importdata[5]);
                        $d = $dob_arr[0];
                        $m = $dob_arr[1];
                        $y = $dob_arr[2];
                        $date_string = $y . '-' . $m . '-' . $d;
                        $dob = date('Y-m-d', strtotime($date_string));
                        $borrower_details = array(
                            'name' => $importdata[0],
                            'dob' => $dob,
                            'gender' => $importdata[6],
                            'highest_qualification' => $importdata[7],
                            'email' => $importdata[2],
                            'mobile' => $importdata[1],
                            'pan' => $importdata[3],
                            'password' => hash('sha512', $importdata[4]),
                            'address1' => $importdata[9],
                            'state_code' => $importdata[11],
                            'city' => $importdata[12],
                            'pincode' => $importdata[13],
                            'present_residence' => $importdata[14],
                            'occupation' => $importdata[15],
                            'company_type' => $importdata[16],
                            'company_name' => $importdata[17],
                            'total_experience' => $importdata[18],
                            'net_monthly_income' => $importdata[20],
                            'current_emis' => $importdata[19],
                            'turnover_last_year' => $importdata[21],
                            'turnover_last2_year' => $importdata[22],
                            'loan_amount_borrower' => $importdata[23],
                            'tenor_borrower' => $importdata[24],
                            'borrower_interest_rate' => $importdata[25],
                            'p2p_product_id' => 3,
                            'borrower_loan_desc' => $importdata[26],
                        );
                        $_POST = $borrower_details;
                        $this->form_validation->set_rules('name', 'First Name', 'trim|required');
                        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
                        $this->form_validation->set_rules('highest_qualification', 'trim|Qualification', 'required');
                        $this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[p2p_borrowers_list.email]|is_unique[p2p_lender_list.email]');
                        $this->form_validation->set_rules('mobile', 'Mobile No', 'required|is_unique[p2p_borrowers_list.mobile]|is_unique[p2p_lender_list.mobile]|regex_match[/^[6-9]\d{9}$/]');
                        $this->form_validation->set_rules('pan', 'Pancard No', 'trim|required|is_unique[p2p_borrowers_list.pan]|is_unique[p2p_lender_list.pan]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]');
                        $this->form_validation->set_rules('password', 'Password', 'required');
                        $this->form_validation->set_rules('address1', 'address1', 'required');
                        $this->form_validation->set_rules('state_code', 'State', 'required');
                        $this->form_validation->set_rules('city', 'City', 'required');
                        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|regex_match[/^[1-9][0-9]{5}$/]');
                        $this->form_validation->set_rules('present_residence', 'Present Residence', 'required');
                        $this->form_validation->set_rules('occupation', 'occupation', 'required');
                        if ($this->input->post('occupation') == 1) {
                            $this->form_validation->set_rules('company_type', 'Company type', 'trim|required');
                            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
                            $this->form_validation->set_rules('total_experience', 'Total Experience', 'trim|required');
                            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 2) {
                            $this->form_validation->set_rules('company_type', 'Industry type', 'trim|required');
                            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
                            $this->form_validation->set_rules('total_experience', 'Total experience', 'trim|required');
                            $this->form_validation->set_rules('turnover_last_year', 'Turnover last year', 'trim|required');
                            $this->form_validation->set_rules('turnover_last2_year', 'Turnover last 2 year', 'trim|required');
                            $this->form_validation->set_rules('net_monthly_income', 'Net Monthly Income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 3) {
                            $this->form_validation->set_rules('company_type', 'Professional type', 'trim|required');
                            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
                            $this->form_validation->set_rules('total_experience', 'Total experiance', 'trim|required');
                            $this->form_validation->set_rules('turnover_last_year', 'Last year turnover', 'trim|required');
                            $this->form_validation->set_rules('turnover_last2_year', 'Last 2 year turnover', 'trim|required');
                            $this->form_validation->set_rules('net_monthly_income', 'Net Monthly Income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 4) {
                            $this->form_validation->set_rules('company_type', 'Company type', 'trim|required');
                            $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
                            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 5) {
                            $this->form_validation->set_rules('company_type', 'Pursuing course', 'trim|required');
                            $this->form_validation->set_rules('company_name', 'institute_name5', 'trim|required');
                            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 6) {
                            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        if ($this->input->post('occupation') == 7) {
                            $this->form_validation->set_rules('net_monthly_income', 'Net monthly income', 'trim|required');
                            $this->form_validation->set_rules('current_emis', 'Current Emis', 'trim|required');
                        }
                        $this->form_validation->set_rules('loan_amount_borrower', 'Loan amount', 'required');
                        $this->form_validation->set_rules('tenor_borrower', 'Tenor', 'required');
                        $this->form_validation->set_rules('borrower_interest_rate', 'Interest rate', 'required');
                        $this->form_validation->set_rules('p2p_product_id', 'Loan purpose', 'required');
                        $this->form_validation->set_rules('borrower_loan_desc', 'Loan description', 'required');
                        if ($this->form_validation->run() == TRUE) {

//							echo "good";
                            $this->Borroweraddmodel->add_borrower();
                        } else {
                            echo $importdata[1];
                            $errmsg = validation_errors();
                            print_r($errmsg);
                            echo '_____________________________________________<br>';
                        }
                    }
                }
                echo "File Upload Successfully";
                exit;
            } else {
                echo $msg = "Something went wrong..";
                exit;
            }
        }
    }


    public function leadclosed()
    {
        $this->money = $this->load->database('money', true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mobile', 'mobile no', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $arr = array(

                'assigned_to' => 7,
            );

            $this->money->where('mobile', $this->input->post('mobile'));
            $this->money->update('ant_all_leads', $arr);

            $this->money->where('mobileNo', $this->input->post('mobile'));
            $this->money->update('credit_score_query', $arr);

            $this->money->where('mobileNo', $this->input->post('mobile'));
            $this->money->update('f_freedom_plan', $arr);

            if ($this->money->affected_rows() > 0) {
                $msg = "Closed Lead Successfully";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url() . 'p2padmin/Dashboard/');
            } else {
                $errmsg = "Something went wrong";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
                redirect(base_url() . 'p2padmin/Dashboard/');
            }
        } else {
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
            redirect(base_url() . 'p2padmin/Dashboard/');
        }

    }

    public function leadcreassign()
    {
        $this->money = $this->load->database('money', true);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('mobile', 'mobile no', 'trim|required');

        if ($this->form_validation->run() == TRUE) {

            $arr = array(

                'assigned_to' => 0,
                'created_date' => date('Y-m-d H:i:s'),
            );

            $this->money->where('mobile', $this->input->post('mobile'));
            $this->money->update('ant_all_leads', $arr);

            $this->money->where('mobileNo', $this->input->post('mobile'));
            $this->money->update('credit_score_query', $arr);

            $this->money->where('mobileNo', $this->input->post('mobile'));
            $this->money->update('f_freedom_plan', $arr);

            if ($this->money->affected_rows() > 0) {
                $msg = "Lead Reassign Successfully";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url() . 'p2padmin/Dashboard/');
            } else {
                $errmsg = "Something went wrong";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
                redirect(base_url() . 'p2padmin/Dashboard/');
            }
        } else {
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
            redirect(base_url() . 'p2padmin/Dashboard/');
        }

    }


}

?>

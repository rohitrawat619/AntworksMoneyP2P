<?php

class Teamleader extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model(array('Requestmodel', 'p2padmin/P2papplicationmodel', 'p2padmin/P2plendermodel', 'bidding/Biddingmodel', 'p2padmin/P2pborrowermodel', 'p2padmin/Appdetailsmodel', 'borrower/Borrowermodelbackend'));
//        echo "<pre>";
//        print_r($_SESSION); exit;
//        if($this->session->userdata('use'))
//        {
//
//        }
//        else{
//
//        }
//         exit;$this->load->model('Borrowermodelbackend');$this->load->model('Borrowermodelbackend');
        if ($this->session->userdata('admin_state') == TRUE) {

        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function dashboard()
    {
        $data['liveproposal'] = $this->Borrowermodelbackend->liveProposal();
        $data['livelender'] = $this->Borrowermodelbackend->liveLender();
        $data['totalbidrecieved'] = $this->Borrowermodelbackend->totalBidrecieved();
        $data['totalAvgintrestrate'] = $this->Borrowermodelbackend->totalAvgintrestrate();
        $data['pageTitle'] = "Dashboard";
        $this->load->view('templates-teamleader/header', $data);
        $this->load->view('templates-teamleader/nav', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('templates-teamleader/footer', $data);
    }

    public function borrowers()
    {
        echo $this->session->userdata('email');
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'Teamleader') {
            $this->load->library("pagination");
            if ($this->session->userdata('email') == 'navin.singh@antworksmoney.com') {
                $config = array();
                $config["base_url"] = base_url() . "teamleader/borrowers";
                $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
                $config["per_page"] = 100;
                $config["uri_segment"] = 3;
                $config['num_links'] = 10;
                $config['full_tag_open'] = "<div class='new-pagination'>";
                $config['full_tag_close'] = "</div>";
                $this->pagination->initialize($config);
                $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
                $data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
                $data["pagination"] = $this->pagination->create_links();
            } else {
                $data['list'] = '';
                $data["pagination"] = $this->pagination->create_links();
            }


            $data['pageTitle'] = "Borrower List";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-teamleader/header', $data);
            $this->load->view('templates-teamleader/nav', $data);
            $this->load->view('borrower/borrower-list', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-teamleader/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function lenders()
    {
        $this->load->library("pagination");
        $config = array();
        $config["base_url"] = base_url() . "teamleader/lenders";
        $config["total_rows"] = $this->P2plendermodel->get_count_lenders();
        $config["per_page"] = 100;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["pagination"] = $this->pagination->create_links();
        $data['list'] = $this->P2plendermodel->getlenders($config["per_page"], $page);
        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-teamleader/header', $data);
        $this->load->view('templates-teamleader/nav', $data);
        $this->load->view('lender/lender-list', $data);
        $this->load->view('templates-teamleader/footer', $data);
    }

    /* public function borrowers()
    {
//        $this->load->library("pagination");
//        $config = array();
//        $config["base_url"] = base_url() . "teamleader/borrowers";
//        $config["total_rows"] = $this->P2pborrowermodel->get_count_borrowers();
//        $config["per_page"] = 100;
//        $config["uri_segment"] = 3;
//		$config['full_tag_open'] = "<div class='new-pagination'>";
//		$config['full_tag_close'] = "</div>";
//        $this->pagination->initialize($config);
//        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
//        $data['list'] = $this->P2pborrowermodel->getborrowers($config["per_page"], $page);
		$data['list'] = '';
        $data['pageTitle'] = "Borrower List";
        $data['title'] = "Admin Dashboard";
       // $data["pagination"] = $this->pagination->create_links();
        $this->load->view('templates-teamleader/header',$data);
        $this->load->view('templates-teamleader/nav',$data);
        $this->load->view('borrower/borrower-list',$data);
        $this->load->view('templates-teamleader/footer',$data);
    } */

    public function borrowers_search()
    {

        if (!empty($_GET)) {
            if ($this->input->get('email') || $this->input->get('borrower_id') || $this->input->get('mobile') || $this->input->get('name')) {

                $data['list'] = $this->P2pborrowermodel->borrower_search();
                $data['pageTitle'] = "Active Loan List";
                $data['title'] = "Admin Dashboard";

                $this->load->view('templates-teamleader/header', $data);
                $this->load->view('templates-teamleader/nav', $data);
                $this->load->view('borrower/borrower-list', $data);
                $this->load->view('templates-teamleader/footer', $data);
            }
        }
    }

    public function viewborrower($borrower_id)
    {
        $data['list'] = $this->P2pborrowermodel->get_borrower_details($borrower_id);
        $data['current_step'] = $this->P2pborrowermodel->getBorrowersteps($data['list']['borrower_id']);
        $data['experian_details'] = $this->P2pborrowermodel->getExperian_details($data['list']['borrower_id']);
        $data['panresponse'] = $this->P2pborrowermodel->getPanresponse($data['list']['borrower_id']);
        $data['bankaccountresponse'] = $this->P2pborrowermodel->bankaccountresponse($data['list']['borrower_id']);
        $data['borrower_requests'] = $this->P2pborrowermodel->borrowerRequest($data['list']['borrower_id']);
        $data['e_kyc'] = $this->P2pborrowermodel->getEkyc($data['list']['borrower_id']);
        $data['pageTitle'] = "Borrower Details";
        $data['title'] = "Admin Dashboard";
//        pr($data); exit;
        $this->load->view('templates-teamleader/header', $data);
        $this->load->view('templates-teamleader/nav', $data);
        $this->load->view('borrower/borrower-details', $data);
        $this->load->view('templates-admin/js/borrowerJS', $data);
        $this->load->view('templates-teamleader/footer', $data);

    }

    public function appdetails($b_borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'Teamleader') {
            //$this->load->model('Appdetailsmodel');
            $data['app_installed'] = $this->Appdetailsmodel->borrowerAppdetails($b_borrower_id);
            $data['contactDetails'] = $this->Appdetailsmodel->getContactdetails($b_borrower_id);
            $data['pageTitle'] = "Contact Details";

            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-teamleader/header', $data);
            $this->load->view('templates-teamleader/nav', $data);
            $this->load->view('borrower/borrower-app-details', $data);
            $this->load->view('templates-teamleader/footer', $data);

        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }


    }

    public function view_experian_response($borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'Teamleader') {
            $this->load->model('P2PCreditenginemodel');
            $data['rating'] = $this->P2PCreditenginemodel->Engine($borrower_id);
            $data['pageTitle'] = "Borrower Details";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-teamleader/header', $data);
            $this->load->view('templates-teamleader/nav', $data);
            $this->load->view('borrower/view_creditreport', $data);
            $this->load->view('templates-teamleader/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function bankstatement_response($borrower_id)
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'Teamleader') {
            $result = $this->P2pborrowermodel->getBankresponse($borrower_id);
            $response = json_decode($result['whatsloan_response'], true);
            $data['result'] = $response['result'];
//        echo "<pre>";
//        print_r($data['result']); exit;
            $data['pageTitle'] = "Borrower Account Response";
            $data['title'] = "Admin Dashboard";
            $this->load->view('templates-teamleader/header', $data);
            $this->load->view('templates-teamleader/nav', $data);
            $this->load->view('borrower/bank_account_analysis', $data);
            $this->load->view('templates-teamleader/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }

    }

    public function add_docs_borrower()
    {
        //$primary_borrower_id = $this->Documents->get_borrower_id($this->input->post('borrower_id'));
        if ($_FILES) {
            $config['upload_path'] = "./assets/borrower-documents";
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if (isset($_FILES['doc_file'])) {
                $total = count($_FILES['doc_file']['name']);

                if ($total > 0) {
                    $i = 0;
                    foreach ($_FILES['doc_file']['name'] as $key => $image) {
                        $_FILES['images[]']['name'] = $_FILES['doc_file']['name'][$key];
                        $_FILES['images[]']['type'] = $_FILES['doc_file']['type'][$key];
                        $_FILES['images[]']['tmp_name'] = $_FILES['doc_file']['tmp_name'][$key];
                        $_FILES['images[]']['error'] = $_FILES['doc_file']['error'][$key];
                        $_FILES['images[]']['size'] = $_FILES['doc_file']['size'][$key];

                        $this->upload->initialize($config);
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('images[]')) {
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                            exit;
                            //$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$error));
                            //redirect(base_url().'management/add');
                        } else {
                            $data = array('upload_data' => $this->upload->data());
                            $uploads['docs_type'] = $_POST['doc_name'][$i];
                            $uploads['docs_name'] = $data['upload_data']['file_name'];
                            $uploads['borrower_id'] = $this->input->post('borrower_id');
                            $uploads['date_added'] = date('Y-m-d h:i:s');
                            $status = $this->P2pborrowermodel->add_docs_borrower($uploads);
                        }
                        $i++;
                    }
                }
            }
            //$status = $this->P2pmodel->add_docs_borrower($uploads);
            if ($status) {
                $msg = "Your documents are uploaded successfully.";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
            } else {
                $msg = "Something went wrong!";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
            }
        } else {
            $msg = "Please Select a File! We accept .doc, .dox, .jpg, .png, .pdf file formats only";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
        }
    }

    public function reinitiateExperian()
    {
        if ($this->session->userdata('admin_state') == TRUE && $this->session->userdata('role') == 'Teamleader') {
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
                    $xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="http://nextgenws.ngwsconnect.experian.com">
   <SOAP-ENV:Header />
   <SOAP-ENV:Body>
      <urn:process>
         <urn:cbv2String><![CDATA[<INProfileRequest>
   <Identification>
     <XMLUser>cpu2ant_prod03</XMLUser>
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
                        $this->db->insert('p2p_borrower_experian_response', $arr_response);

                        $dataSteps = array(
                            'step_5' => 1,
                        );
                        $this->db->where('borrower_id', $this->input->post('borrower_id'));
                        $this->db->update('p2p_borrower_steps', $dataSteps);
                        $this->load->model('Creditenginemodel');
                        $this->Creditenginemodel->Engine($this->input->post('borrower_id'));
                        //
                        $msg = "User Record Update Successfully";
                        $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                        redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
                    }
                } else {
                    $errmsg = validation_errors();
                    $this->session->set_flashdata('notification', array('error' => 1, 'message' => $errmsg));
                    redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
                }

            } else {
                $msg = "User Record Not Found. Please verify details and try again";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'teamleader/viewborrower/' . $this->input->post('b_borrower_id'));
            }
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
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
				'status' => 15,
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
                redirect(base_url() . 'teamleader/Dashboard/');
            } else {
                $errmsg = "Something went wrong";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
                redirect(base_url() . 'teamleader/Dashboard/');
            }
        } else {
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
            redirect(base_url() . 'teamleader/Dashboard/');
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
                redirect(base_url() . 'teamleader/Dashboard/');
            } else {
                $errmsg = "Something went wrong";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
                redirect(base_url() . 'teamleader/Dashboard/');
            }
        } else {
            $errmsg = validation_errors();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $errmsg));
            redirect(base_url() . 'teamleader/Dashboard/');
        }

    }

    public function viewlender($user_id)
    {
        error_reporting(0);
        $data['lender'] = $this->P2plendermodel->getlender($user_id);
        $data['pageTitle'] = "Lender List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-teamleader/nav',$data);
        $this->load->view('lender/edit-lender',$data);
        $this->load->view('templates-admin/footer',$data);
    }

}

?>

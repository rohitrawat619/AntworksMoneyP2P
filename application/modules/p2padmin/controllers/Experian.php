<?php
class Experian extends CI_Controller {

    public function __construct()
    {

        parent::__construct();
        $this->load->model('P2padminmodel');
        $this->load->model('Requestmodel');
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}

		echo "You are restricted to use this section. Please contact system administrator"; exit;
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function initiateExperian()
    {
        $query = $this->db->select('BL.email, BL.mobile, BL.name')
            ->from('p2p_borrowers_list AS BL')
            ->where('BL.id',$this->input->post('borrowerId'))
            ->get();
        if($this->db->affected_rows()>0)
        {

        }

        $borrower_info = $this->Borrowerprocessmodel->borrower_info();
        $proposal_info = $this->Borrowerprocessmodel->get_currentopen_proposal();
        $arr = explode(' ', $borrower_info['name']);
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
        $dob = str_replace('-', '', $borrower_info['dob']);

		$xml = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="http://nextgenws.ngwsconnect.experian.com">
   <SOAP-ENV:Header />
   <SOAP-ENV:Body>
      <urn:process>
         <urn:cbv2String><![CDATA[<INProfileRequest>
   <Identification>
      <XMLUser>cpu2ant_prod01</XMLUser>
      <XMLPassword>20@March20</XMLPassword>
   </Identification>
   <Application>
      <FTReferenceNumber></FTReferenceNumber>
      <CustomerReferenceID>' . $borrower_info['borrower_id'] . '</CustomerReferenceID>
      <EnquiryReason>13</EnquiryReason>
      <FinancePurpose>99</FinancePurpose>
      <AmountFinanced>' . $proposal_info['loan_amount'] . '</AmountFinanced>
      <DurationOfAgreement>' . $proposal_info['tenor_months'] . '</DurationOfAgreement>
      <ScoreFlag>1</ScoreFlag>
      <PSVFlag></PSVFlag>
   </Application>
   <Applicant>
      <Surname>' . $last_name . '</Surname>
      <FirstName>' . $first_name . '</FirstName>
      <MiddleName1 />
      <MiddleName2 />
      <GenderCode>2</GenderCode>
      <IncomeTaxPAN>' . $borrower_info['pan'] . '</IncomeTaxPAN>
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
      <PhoneNumber>' . $borrower_info['mobile'] . '</PhoneNumber>
      <Telephone_Extension />
      <Telephone_Type />
      <MobilePhone>' . $borrower_info['mobile'] . '</MobilePhone>
      <EMailId />
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
      <City>' . $borrower_info['r_city'] . '</City>
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
                "content-type: text/xml"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $arr_response = array(
                'borrower_id' => $this->session->userdata('borrower_id'),
                'experian_response' => $response,
            );

            $this->Borrowerprocessmodel->addExperian_response($arr_response);
            $dataSteps = array(
                'step_5' => 1,
            );
            $this->Borrowerprocessmodel->updateSteps($dataSteps);
            //Credit Engine
            $this->load->model('Creditenginemodel');
            $this->Creditenginemodel->Engine($this->session->userdata('borrower_id'));
            //

            redirect(base_url() . 'borrowerprocess/bank-account-verify');
        }
    }

    public function initiateExperianOldbkp()
    { exit;
        $query = $this->db->select('BL.email, BL.mobile, BL.name')
            ->from('p2p_borrowers_list AS BL')
            ->where('BL.id',$this->input->post('borrowerId'))
            ->get();
        if($this->db->affected_rows()>0)
        {

        }

        $borrower_info = $this->Borrowerprocessmodel->borrower_info();
        $proposal_info = $this->Borrowerprocessmodel->get_currentopen_proposal();
        $arr = explode(' ', $borrower_info['name']);
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
        $dob = str_replace('-', '', $borrower_info['dob']);


        $curl = curl_init();
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:cbv2">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:process>
         <urn:in>
         <INProfileRequest>
         <Identification>
                <XMLUser>cpu2ant_prod01</XMLUser>
		<XMLPassword>Antworks@270</XMLPassword>
          </Identification>
          <Application>
                  <FTReferenceNumber></FTReferenceNumber>
                  <CustomerReferenceID>' . $borrower_info['borrower_id'] . '</CustomerReferenceID>
                  <EnquiryReason>13</EnquiryReason>
                  <FinancePurpose>99</FinancePurpose>
                  <AmountFinanced>' . $proposal_info['loan_amount'] . '</AmountFinanced>
                  <DurationOfAgreement>' . $proposal_info['tenor_months'] . '</DurationOfAgreement>
                  <ScoreFlag>1</ScoreFlag>
                  <PSVFlag></PSVFlag>
          </Application>
         <Applicant>
            <Surname>' . $last_name . '</Surname>
        <FirstName>' . $first_name . '</FirstName>
       <MiddleName1></MiddleName1>
       <MiddleName2></MiddleName2>
       <MiddleName3></MiddleName3>
       <GenderCode>1</GenderCode>
       <IncomeTaxPAN>' . $borrower_info['pan'] . '</IncomeTaxPAN>
       <PANIssueDate></PANIssueDate>
       <PANExpirationDate></PANExpirationDate>
       <PassportNumber></PassportNumber>
       <PassportIssueDate></PassportIssueDate>
       <PassportExpirationDate></PassportExpirationDate>
       <VoterIdentityCard></VoterIdentityCard>
       <VoterIDIssueDate></VoterIDIssueDate>
       <VoterIDExpirationDate></VoterIDExpirationDate>
       <DriverLicenseNumber></DriverLicenseNumber>
       <DriverLicenseIssueDate></DriverLicenseIssueDate>
       <DriverLicenseExpirationDate></DriverLicenseExpirationDate>
       <RationCardNumber></RationCardNumber>
       <RationCardIssueDate></RationCardIssueDate>
       <RationCardExpirationDate></RationCardExpirationDate>
       <UniversalIDNumber></UniversalIDNumber>
       <UniversalIDIssueDate></UniversalIDIssueDate>
       <UniversalIDExpirationDate></UniversalIDExpirationDate>
       <DateOfBirth>' . $dob . '</DateOfBirth>
       <STDPhoneNumber></STDPhoneNumber>
       <PhoneNumber></PhoneNumber>
       <TelephoneExtension></TelephoneExtension>
       <TelephoneType></TelephoneType>
       <MobilePhone>' . $borrower_info['mobile'] . '</MobilePhone>
       <EMailId></EMailId>
    </Applicant>
    <Details>
        <Income></Income>
        <MaritalStatus></MaritalStatus>
        <EmployStatus></EmployStatus>
        <TimeWithEmploy></TimeWithEmploy>
        <NumberOfMajorCreditCardHeld></NumberOfMajorCreditCardHeld>
    </Details>
    <Address>
            <FlatNoPlotNoHouseNo>' . $borrower_info['r_address'] . '</FlatNoPlotNoHouseNo>
            <BldgNoSocietyName>' . $borrower_info['r_address1'] . '  </BldgNoSocietyName>
            <RoadNoNameAreaLocality></RoadNoNameAreaLocality>
            <City>' . $borrower_info['r_city'] . '</City>
            <Landmark></Landmark>
            <State>' . $borrower_info['r_state'] . '</State>
            <PinCode>' . $borrower_info['r_pincode'] . '</PinCode>
         </Address>
          <AdditionalAddressFlag>
                  <Flag>N</Flag>
          </AdditionalAddressFlag>
          <AdditionalAddress>
                  <FlatNoPlotNoHouseNo></FlatNoPlotNoHouseNo>
                  <BldgNoSocietyName></BldgNoSocietyName>
                  <RoadNoNameAreaLocality></RoadNoNameAreaLocality>
                  <City></City>
                  <Landmark></Landmark>
                  <State></State>
                  <PinCode></PinCode>
          </AdditionalAddress>
  </INProfileRequest>         
         </urn:in>
      </urn:process>
   </soapenv:Body>
</soapenv:Envelope>';
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "443",
            CURLOPT_URL => "https://connect.experian.in:443/nextgen-ind-pds-webservices-cbv2/endpoint",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_HTTPHEADER => array(
                "content-type: text/xml"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $arr_response = array(
                'borrower_id' => $this->session->userdata('borrower_id'),
                'experian_response' => $response,
            );

            $this->Borrowerprocessmodel->addExperian_response($arr_response);
            $dataSteps = array(
                'step_5' => 1,
            );
            $this->Borrowerprocessmodel->updateSteps($dataSteps);
            //Credit Engine
            $this->load->model('Creditenginemodel');
            $this->Creditenginemodel->Engine($this->session->userdata('borrower_id'));
            //

            redirect(base_url() . 'borrowerprocess/bank-account-verify');
        }
    }


}
?>

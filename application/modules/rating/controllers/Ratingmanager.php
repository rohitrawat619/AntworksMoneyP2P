<?php
class Ratingmanager extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Ratingmodel'));
        if( $this->session->userdata('admin_state') == TRUE ){

        }
        else{
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/admin-login');
        }
        error_reporting(0);
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }
    ////////////////////////////

    public function experianCreditreport()
    {
        $result = $this->Ratingmodel->experianCreditreport();
        $returningData = simplexml_load_string($result['experian_xml']);
        $json_string = json_encode($returningData);
        $data['result_array'] = json_decode($json_string, TRUE);

        $data['values'] = $result;
        $values['monthly_income'] = '30000';
        $this->load->view('templates-admin/header');
        $this->load->view('templates-admin/nav', $data);
        $this->load->view('templates-admin/header-below', $data);
        $this->load->view('view_creditreport',$data);
        $this->load->view('templates-admin/footer');
    }

    public function borrowerrating($borrower_id)
    {
        error_reporting(0);
        $data['civil_report'] = $this->Ratingmodel->rating_model($borrower_id);

        $data['saved_record'] = $this->Ratingmodel->borrower_record($borrower_id);
        $data['borrower_info'] = $this->Ratingmodel->getBorrower_details($borrower_id);
        $data['pageTitle'] = 'User Rating';
        $this->load->view('templates-admin/header');
        $this->load->view('templates-admin/nav', $data);
        $this->load->view('templates-admin/header-below', $data);
        if($data['saved_record']){
            $this->load->view('user-credit-report-after-edit', $data);
        }
        else {
            $this->load->view('user-credit-report-after-edit', $data);
        }
        $this->load->view('templates-admin/footer');
    }

    public function save_records()
    {
        $values_rating = array(
            'Overall_Leveraging_Ratio'=>$this->input->post('Overall_Leveraging_Ratio'),
            'Leverage_Ratio'=>$this->input->post('Leverage_Ratio'),
            'Limit_Utilization'=>$this->input->post('Limit_Utilization'),
            'Outstanding_to_Limit_Term_Credit'=>$this->input->post('Outstanding_to_Limit_Term_Credit'),
            'Outstanding_to_Limit_PC'=>$this->input->post('Outstanding_to_Limit_PC'),
            'Short_term_Leveraging'=>$this->input->post('Short_term_Leveraging'),
            'Revolving_Credit_line_to_Total_Credit'=>$this->input->post('Revolving_Credit_line_to_Total_Credit'),
            'Term_Credit_to_Total_Credit'=>$this->input->post('Term_Credit_to_Total_Credit')?$this->input->post('Term_Credit_to_Total_Credit'):0,
            'Available_Revolving_line_to_Total_Credit'=>$this->input->post('Available_Revolving_line_to_Total_Credit')?$this->input->post('Available_Revolving_line_to_Total_Credit'):0,
            'Short_Term_Credit_to_Total_Credit'=>$this->input->post('Short_Term_Credit_to_Total_Credit'),
            'Medium_Term_Credit_to_Total_Credit'=>$this->input->post('Medium_Term_Credit_to_Total_Credit')?$this->input->post('Medium_Term_Credit_to_Total_Credit'):0,
            'Long_Term_Credit_to_Total_Credit'=>$this->input->post('Long_Term_Credit_to_Total_Credit')?$this->input->post('Long_Term_Credit_to_Total_Credit'):0,
            'Secured_Facilities_to_Total_Credit'=>$this->input->post('Secured_Facilities_to_Total_Credit'),
            'Unsecured_Facilities_to_Total_Credit'=>$this->input->post('Unsecured_Facilities_to_Total_Credit')?$this->input->post('Unsecured_Facilities_to_Total_Credit'):0,
            'Fixed_Obligation_to_Income'=>$this->input->post('Fixed_Obligation_to_Income'),
            'No_of_Active_Account'=>$this->input->post('No_of_Active_Account'),
            'Variety_of_Loans_Active'=>$this->input->post('Variety_of_Loans_Active'),
            'Variety_of_Loans_including_Closed'=>$this->input->post('Variety_of_Loans_including_Closed'),
            'No_of_Credit_Enquiry_In_last_3_Months'=>$this->input->post('No_of_Credit_Enquiry_In_last_3_Months'),
            'No_of_Loans_Availed_to_Credit_Enquiry_in_last_12_months'=>$this->input->post('No_of_Loans_Availed_to_Credit_Enquiry_in_last_12_months'),
            'History_of_credit_oldest_credit_account'=>$this->input->post('History_of_credit_oldest_credit_account'),
            'Limit_Breach'=>$this->input->post('Limit_Breach'),
            'Overdue_to_Obligation'=>$this->input->post('Overdue_to_Obligation'),
            'Overdue_to_Monthly_Income'=>$this->input->post('Overdue_to_Monthly_Income'),
            'Number_of_instances_of_delay_in_past_6_months'=>$this->input->post('Number_of_instances_of_delay_in_past_6_months'),
            'Number_of_instances_of_delay_in_past_12_months'=>$this->input->post('Number_of_instances_of_delay_in_past_12_months'),
            'Number_of_instances_of_delay_in_past_36_months'=>$this->input->post('Number_of_instances_of_delay_in_past_36_months'),
            'cheque_bouncing'=>$this->input->post('cheque_bouncing'),
            'credit_summation_to_annual_income'=>$this->input->post('credit_summation'),
            'digital_banking'=>$this->input->post('digital_banking'),
            'savings_as_percentage'=>$this->input->post('savings_as_percentage'),
            'present_residence'=>$this->input->post('present_residence'),
            'vehicle_owned'=>$this->input->post('vehicle_owned')?$this->input->post('vehicle_owned'):0,
            'city_of_residence'=>$this->input->post('city_of_residence'),
            'education'=>$this->input->post('education'),
            'institute_of_study'=>$this->input->post('institute_of_study'),
            'age'=>$this->input->post('age'),
            'occupation'=>$this->input->post('occupation'),
            'experience'=>$this->input->post('experience'),
            'modified_date'=>date('Y-m-d H:i:s'),
        );
        $response = $this->Ratingmodel->Save_records($this->input->post('borrower_id'),$values_rating);
        if($response)
        {
            $msg="Borrower Rating Updated successfully";
            $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
            redirect(base_url().'rating/ratingmanager/borrowerrating/'.$this->input->post('borrower_id'));
        }
        else{
            $msg="OOPS! Something went wrong please check you credential and try again";
            $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
            redirect(base_url().'rating/ratingmanager/borrowerrating/'.$this->input->post('borrower_id'));
        }
    }

}
?>

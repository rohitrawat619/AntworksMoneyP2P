<?php
class Missearch extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mishmodel');
    }

    public function index()
    {
        if(!empty($_POST))
        {
            if($this->input->post('start_date'))
            {
                $result = $this->Mishmodel->search();
                if($result)
                {
                    $i = 1;
                    foreach ($result AS $res)
                    {

                         if($res['gender'] == '1') 
                               {
                                   $gender= 'Male';
                                } 
                        else if ($res['gender'] == '2') 
                               {
                                 $gender= 'Female';
                              }
                        else{
                             $gender= 'Other';
                            }
                       $data[] ="<tr>
                                <td>".$i."</td>
                                <td>".$res['created_date']."</td>
                                <td>".$res['borrower_id']."</a></td>
                                <td>".$res['name']."</td>
                                <td>".$res['email']."</td>
                                <td>".$res['mobile']."</td>
                                <td>".$res['qualification']."</td>
                                <td>".$res['occupation']."</td>
                                <td>".$gender."</td>
                                <td>".$res['dob']."</td>
                                <td>".$res['approved_loan_amount']."</td>
                                <td>".$res['loan_processing_charges']."</td>
                                <td>".$res['emi_interest']."</td>
                                <td>".$res['accepted_tenor']."</td>
                                <td>".$res['emi_amount']."</td>
                                <td>".$res['loan_no']."</td>
                                <td>".$res['bank_name']."</td>
                                <td>".$res['account_number']."</td>
                                <td>".$res['ifsc_code']."</td>
                                <td>".$res['r_city']."</td>
                                <td>".$res['overall_leveraging_ratio']."</td>
                                <td>".$res['leverage_ratio_maximum_available_credit']."</td>
                                <td>".$res['limit_utilization_revolving_credit']."</td>
                                <td>".$res['outstanding_to_limit_term_credit']."</td>
                                <td>".$res['outstanding_to_limit_term_credit_including_past_facilities']."</td>
                                <td>".$res['short_term_leveraging']."</td>
                                <td>".$res['secured_facilities_to_total_credit']."</td>
                                <td>".$res['short_term_credit_to_total_credit']."</td>
                                <td>".$res['fixed_obligation_to_income']."</td>
                                <td>".$res['no_of_active_accounts']."</td>
                                <td>".$res['variety_of_loans_active']."</td>
                                <td>".$res['no_of_credit_enquiry_in_last_3_months']."</td>
                                <td>".$res['no_of_loans_availed_to_credit_enquiry_in_last_12_months']."</td>
                                <td>".$res['history_of_credit_oldest_credit_account']."</td>
                                <td>".$res['limit_breach']."</td>
                                <td>".$res['overdue_to_obligation']."</td>
                                <td>".$res['overdue_to_monthly_income']."</td>
                                <td>".$res['number_of_instances_of_delay_in_past_6_months']."</td>
                                <td>".$res['number_of_instances_of_delay_in_past_12_months']."</td>
                                <td>".$res['number_of_instances_of_delay_in_past_36_months']."</td>
                                <td>".$res['cheque_bouncing']."</td>
                                <td>".$res['credit_summation_to_annual_income']."</td>
                                <td>".$res['digital_banking']."</td>
                                <td>".$res['savings_as_percentage_of_annual_income']."</td>
                                <td>".$res['present_residence']."</td>
                                <td>".$res['city_of_residence']."</td>
                                <td>".$res['highest_qualification']."</td>
                                <td>".$res['age']."</td>
                                <td>".$res['experience']."</td>
                           </tr>";
                        $i++; }
                    $result_mis = array(
                        'status'=>1,
                        'msg'=>"Result Found",
                        'search_result'=>$data,
                    );
                 }
                else{
                    $result_mis = array(
                        'status'=>0,
                        'msg'=>"Not Found",
                        'search_result'=>"",
                    );
                }
            }
            echo json_encode($result_mis);
           exit;
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
        }
    }
}
?>
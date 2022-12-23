<?php
class Adminsearchemidue extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Searchemiduemodel');
    }

 public function index()
  {
    error_reporting(0);

    if(!empty($_POST))
      {
      if($this->input->post('start_date'))
       {
         $result = $this->Searchemiduemodel->search();
      
         if($result)
         {
         $i = 1;
         foreach ($result AS $res)
          {
            $data[] = "<tr>
                <td>".$i."</td>
                <td>".$res['b_borrower_id']."</td>
                <td>".$res['loan_no']."</td>
				<td>".$res['lname']."</td>
                <td>".$res['name']."</a></td>
                <td>".$res['email']."</td>
                <td>".$res['mobile']."</td>
                <td>".$res['r_city']."</td>
                <td>".$res['bid_loan_amount']."</td>
                <td>".$res['emi_detil']->emi_date."</td>
                <td>".$res['emi_detil']->emi_amount."</td>                
                <td>
                  <form method='post' action='".base_url()."/p2precovery/p2precovery/sendsms'>
                  <input type='hidden' name='mobile' value=".$res['mobile'].">
                  <input type='hidden' name='loan_no' value=".$res['loan_no'].">
                  <input type='hidden' name='emi_date' value=".$res['emi_detil']->emi_date.">
                  <input type='hidden' name='emi_amount' value=".$res['emi_detil']->emi_amount.">
                  <input type='hidden' name='account_number' value=".$res['account_number'].">
                  <input class='btn btn-info' type='submit' name='submit' value='Send'>
                </td>
                <td><a class='btn btn-success' href='".base_url()."p2precovery/p2precovery/sendemi/".$res['bid_registration_id']."'>Payment</a></td>
              </tr>";
        $i++; }
       
        $result_borrower = array(
            'status'=>1,
            'msg'=>"Result Found",
            'search_result'=>$data,
        );
     }
         else{
                $result_borrower = array(
                    'status'=>0,
                    'msg'=>"Not Found",
                    'search_result'=>"We could not found any Data.",
                );
            }
        }
        echo json_encode($result_borrower);
        exit;
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
        }
    }
}
?>
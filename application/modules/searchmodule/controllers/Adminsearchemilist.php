<?php
class Adminsearchemilist extends CI_Controller{
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
       if($this->input->post('start_date') )
        {
          $result = $this->Searchemiduemodel->searchlist();

      
         if($result)
          {
           $i = 1;
           foreach ($result AS $res)
            {
            	if($res['emi_detil']->status == '0') 
                               {
                                   $emistatus= 'Panding';
                                } 
                        else if ($res['emi_detil']->status == '1') 
                               {
                                 $emistatus= 'Paid';
                              }
                        else{
                             $emistatus= 'EMI Bounce';
                            }
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
		                <td>".$emistatus."</td>
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
	                    'search_result'=>"We could not found any Data",
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
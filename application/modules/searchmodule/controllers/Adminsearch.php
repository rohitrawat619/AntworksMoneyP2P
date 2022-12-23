<?php
class Adminsearch extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Searchmodel');
    }

    public function index()
    {
        if(!empty($_POST))
        { 
            if($this->input->post('start_date') || $this->input->post('name')
                ||  $this->input->post('pan') || $this->input->post('email')
                || $this->input->post('mobile') || $this->input->post('status')
            )
            {
                $result = $this->Searchmodel->search();
                if($result)
                {
                    $i = 1;
                    foreach ($result AS $res)
                    {
                       $data[] = "<tr>
                            <td>".$i."</td>
                            <td>".$res['borrower_id']."</td>
                            <td><a href=". base_url() .$this->input->post('action_uri'). $res['borrower_id'].">".$res['name']."</a></td>
                            <td>".$res['email']."</td>
                            <td>".$res['mobile']."</td>
                            <td>".$res['created_date']."</td>
                            <td>".$res['step_2']."</td>
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
                        'search_result'=>"",
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

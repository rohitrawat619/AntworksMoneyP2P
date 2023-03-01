<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';
use chriskacerguis\RestServer\RestController;
 


class Test2ApiController extends RestController
{

    function index()
{
$this->load->library('Rest',$config);
}
public function __construct()
    { 
     
        parent::__construct($config);
        //parent::__construct();
        $this->load->model('DetailModel');
       
  

    }


    public function form_show() {

        $this->load->view('header');
        $this->load->view("page");
        $this->load->view('footer');
        }

    public function fetch_get()
    {
 


       $resultdet = $this->DetailModel->data_t();


        //print_r($resultdet); 
        //$userModel = model(DetailModel::class);
        //$resultDet=$dataa->data_t();
        $this->response($resultdet,200);

        //return $resultdet;

    }

    public function Datatest_Post()
    {
        $data=[
             'Name' => $this->input->post('Name'),
             'City' => $this->input->post('City'),
             'Number' => $this->input->post('Number')
        ];
 
         $this->DetailModel->dataIns($data);
         //$this->response($data,200);

       $result = $this->db->affected_rows();

       if ($result)
        {
            echo "Done";
        }
       else
       {
        echo "Failed"; 
       }


}
}
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Disbursement extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('disbursementModel'));
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->baseUrl="";
    }



    public function disburse_pending_list(){
        $disburseRequest =1;
        $status = NULL; 
    
        $config = array(
            "base_url" => $this->baseUrl . "disburse_pending_list",
            "total_rows" => $this->disbursementModel->getCountDisburseListStatus($disburseRequest, $status),
            "per_page" => 20,
            "uri_segment" => 4
        );
    
        $this->pagination->initialize($config);
        $page = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
    
        $data["links"] = $this->pagination->create_links();   
        $data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page, $disburseRequest, $status);
    
        // Debugging
        // echo "<pre>";
        // print_r($config);
        // die();
    
        $data['page'] = $page;
        $this->load->view('disbursement_pending_list', $data);
    }
    
    public function update_disburse_status(){
        $ids = $this->input->post('ids');
        $loanStatus = $this->input->post('status');
        $amount = $this->input->post('amount');
        $roi = $this->input->post('roi');
        // echo $ids."!".$loanStatus;die();
        if($loanStatus==3){ // generate_bank_file 
            
            $csv_data = $this->generate_bank_file_excel($ids);
            // echo $csv_data;die();
            $update_disburse_status['query'] =	$this->disbursementModel->update_disburse_status($loanStatus, $ids,$amount,$roi);
        if ($update_disburse_status) {
            $update_disburse_status['status'] = 1;
            $update_disburse_status['message'] = 'Update successful';
        } else {
            $update_disburse_status['status'] = 0;
            $update_disburse_status['message'] = 'Update Failed';
        }
        
        $update_disburse_status['csv_data'] = $csv_data;
        echo json_encode($update_disburse_status);
        die();
                /******ending of generate bank file function use**********/
        }
        
        else{
        $update_disburse_status = $this->disbursementModel->update_disburse_status($loanStatus, $ids,$amount,$roi);
        
        if ($update_disburse_status) {
            echo json_encode(array('status' => 1, 'message' => 'Update successful'));
        } else {
            echo json_encode(array('status' => 0, 'message' => 'Update failed'));
        }
        die();
    }
    }

    public function generate_bank_file_excel($LoanId){
                // $LoanId = 2;
                $respResultSet = $this->disbursementModel->generate_bank_file_excel($LoanId);
           //     print_r($respResultSet); die();
        $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download'); 
       $delimiter = ",";
       $newline = "\r\n";
       
       $projectName = "Bank_file";
       $start_date = "";
       $end_date="";
       //print_r($respResultSet);
       if($respResultSet){
               $filename = $projectName."__product_from-".$start_date." To-".$end_date.".csv";
              //	echo $respResultSet;
           $data = $this->dbutil->csv_from_result($respResultSet, $delimiter, $newline);
       	// force_download($filename, $data);
               return  $data;
           }else{
               return "hello data";
           }
   }


	public function disburse_list_generate_bank_file(){
        $disburseRequest =1;
        $status = 1;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_generate_bank_file";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		// $this->load->view('template-surgeModule/header');
		// $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($data);die();
		$data['page'] = $page;
		$this->load->view('disbursement_generate_bank_file',$data);
		
		// $this->load->view('template-surgeModule/footer');
    }


    public function disburse_list_under_process(){
        $disburseRequest =1;
        $status = 3;
$config["base_url"] =$this->baseUrl . "disburse_list_under_process";
$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
$config["per_page"] = 20;
$config["uri_segment"] = 4;
$this->pagination->initialize($config);
$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

$data["links"] = $this->pagination->create_links();	

// $this->load->view('template-surgeModule/header');
// $this->load->view('template-surgeModule/nav');
$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
$data['page'] = $page;
// echo "<pre>";print_r($data);die();
$this->load->view('disburse_list_under_process',$data);

// $this->load->view('template-surgeModule/footer');    
    }


    public function disburse_list_disbursed(){
        $disburseRequest =1;
        $status = 4;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		// $this->load->view('template-surgeModule/header');
		// $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('disbursement_list',$data);
    }


    public function disburse_pending_rejected_list(){
        $disburseRequest =1;
        $status = 2;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		// $this->load->view('template-surgeModule/header');
		// $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('disburse_pending_rejected_list',$data);
    }

    public function disbursement_under_process_rejected_list(){
        $disburseRequest =1;
        $status = 5;
		$config = array();
		$config["base_url"] = $this->baseUrl . "disburse_list_disbursed";
		$config["total_rows"] = $this->disbursementModel->getCountDisburseListStatus($disburseRequest,$status);
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		// echo $this->uri->segment(4);die();
		$data["links"] = $this->pagination->create_links();	
			
		// $this->load->view('template-surgeModule/header');
		// $this->load->view('template-surgeModule/nav');
		$data['lists'] = $this->disbursementModel->getDisburseRequestList($config["per_page"], $page,$disburseRequest,$status);
        // echo "<pre>";print_r($config);die();
		$data['page'] = $page;
		$this->load->view('disbursement_under-process_rejected_list',$data);
    }




  	
	

}

?>
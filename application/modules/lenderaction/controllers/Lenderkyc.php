<?php
class Lenderkyc extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lenderkycmodel');
        $this->load->library('curl');
    }

    public function index()
    {
      echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function pan_verify()
    {
        error_reporting(0);
        if ( $this->session->userdata('login_state') == TRUE ) {
            $result_lender = $this->Lenderkycmodel->lender_name();
             if($result_lender)
             {
                 //$this->curl->create('https://api.whatsloan.com/v1/ekyc/panAuth');
                 $this->curl->option(CURLOPT_BUFFERSIZE, 10);
                 $this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
                 $post = array('pan'=>$this->input->post('pan'), 'token'=>WHATAPP_TOKEN);
                 $this->curl->post($post);
                 $result_json =  $this->curl->execute();
                 $result = json_decode($result_json);
                 if($result->result->name)
                 {

                     $reaponse_name = str_replace('  ', ' ', $result->result->name);
                     $result_name =  strtoupper($result_lender->name);
                     if($result_name == $reaponse_name)
                     {
                         $this->Lenderkycmodel->updateLender();
                         echo 1; exit;
                     }
                     else{
                         $this->Lenderkycmodel->updateLender();
                         echo 2; exit;
                     }
                 }
                 else{
                     $this->Lenderkycmodel->updateLender();
                     echo 2; exit;
                 }
             }
             else{
                 echo 3; exit;
             }
        }
        else{
            echo 4; exit;
        }

    }

    public function lenderkyc()
    {
        if ( $this->session->userdata('login_state') == TRUE ){
            $config['upload_path']="./assets/lender-documents";
            $config['allowed_types']='jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $config['overwrite']  = TRUE;
            $this->load->library('upload',$config);
            if($this->upload->do_upload("pan_file")) {
                $data = $this->upload->data();
                $file_info = array(
                    'lender_id'=>$this->session->userdata('user_id'),
                    'docs_type' => 'pan',
                    'docs_name' => $data['file_name'],

                );
                $this->Lenderkycmodel->insert_kyc_pan($file_info);
            }

            if($this->upload->do_upload("kyc_file")) {
                $data = $this->upload->data();
                $file_info = array(
                    'lender_id'=>$this->session->userdata('user_id'),
                    'docs_type' => $this->input->post('document_type'),
                    'docs_no' => $this->input->post('doc_no'),
                    'docs_name' => $data['file_name'],

                );
                $this->Lenderkycmodel->insert_kyc_pan($file_info);
            }

            if($this->input->post('optionsPermanent') == 'no')
            {
                if($this->upload->do_upload("secondry_kyc_file")) {
                    $data = $this->upload->data();
                    $file_info = array(
                        'lender_id'=>$this->session->userdata('user_id'),
                        'docs_type' => $this->input->post('secondry_document_type'),
                        'docs_no' => $this->input->post('secondry_doc_no'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Lenderkycmodel->insert_kyc_pan($file_info);
                }
            }
            if($this->upload->display_errors())
            {
                $msg = "OOPS! Something went wrong please check you credential and try again";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url().'lenderprocess/kyc-updation');
            }
            else{
                $this->Lenderkycmodel->updateprocess();
                redirect(base_url().'lenderprocess/bank_account_details');
            }
        }
        else
        {
            redirect(base_url().'login/lender');
        }
    }
}
?>

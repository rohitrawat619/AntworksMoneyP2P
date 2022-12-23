<?php
class Borrowerkyc extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Borrowerkycmodel');
        $this->load->library('curl');
    }

    public function index()
    {
      echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function pan_verify()
    {
        error_reporting(0);
        if ( $this->session->userdata('borrower_state') == TRUE ) {
            $result_borrower = $this->Borrowerkycmodel->borrower_name();
             if($result_borrower)
             {
                 $this->curl->create('https://api.whatsloan.com/v1/ekyc/panAuth');
                 $this->curl->option(CURLOPT_BUFFERSIZE, 10);
                 $this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
                 $post = array('pan'=>$this->input->post('pan'), 'token'=>WHATAPP_TOKEN);
                 $this->curl->post($post);
                 $result_json =  $this->curl->execute();
                 $result = json_decode($result_json);
                 if($result->result->name)
                 {
                     $reaponse_name = str_replace('  ', ' ', $result->result->name);
                     $result_name =  strtoupper($result_borrower->name);
                     if($result_name == $reaponse_name)
                     {
                         $this->Borrowerkycmodel->updateBorrower();
                         echo 1; exit;
                     }
                     else{
                         $this->Borrowerkycmodel->updateBorrower();
                         echo 1; exit;
                     }
                 }
                 else{

                     $this->Borrowerkycmodel->updateBorrower();
                     echo 1; exit;
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

    public function account_check()
    {

    }

    public function pan_verify_ocr()
    {
        if ( $this->session->userdata('borrower_state') == TRUE ){
            $result = $this->Borrowerkycmodel->check_pan_kyc();
            if($result)
            {
                unlink('/home/antworks7/public_html/p2pdevelopment/assets/borrower-documents/'.$result->docs_name);

                $config['upload_path']="./assets/borrower-documents";
                $config['allowed_types']='jpg|png|jpeg|pdf';
                $config['encrypt_name'] = TRUE;
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                $config['overwrite']  = TRUE;
                $this->load->library('upload',$config);
                if($this->upload->do_upload("borrower_pan")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'docs_name'=>$data['file_name'],
                    );
                    $result = $this->Borrowerkycmodel->update_pan_kyc($borrower_file_info);
                    if($result)
                    {

//                        $this->curl->create('https://api.whatsloan.com/v1/ekyc/panOcr/details');
//                        $this->curl->option(CURLOPT_BUFFERSIZE, 10);
//                        $this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
//                        $post = array('file'=>@$data['full_path'], 'token'=>'9290123020b140515cc29bfdb776e3b471af0a43');
//                        $this->curl->post($post);
                        //echo $this->curl->execute(); exit;
                        echo 1;
                    }
                    else{
                        echo "exit";
                    }
                }
                else{
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);exit;
                }
            }
            else{
                $config['upload_path']="./assets/borrower-documents";
                $config['allowed_types']='jpg|png|jpeg';
                $config['encrypt_name'] = TRUE;
                $config['max_width']  = '0';
                $config['max_height']  = '0';
                $config['overwrite']  = TRUE;
                $this->load->library('upload',$config);
                if($this->upload->do_upload("borrower_pan")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id'=>$this->session->userdata('borrower_id'),
                        'docs_name'=>$data['file_name'],
                        'docs_type'=>'pan',
                    );
                    $result = $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                    if($result)
                    {
//                        $this->curl->create('https://api.whatsloan.com/v1/ekyc/panOcr/details');
//                        $this->curl->option(CURLOPT_BUFFERSIZE, 10);
//                        $this->curl->options(array(CURLOPT_BUFFERSIZE => 10));
//                        $post = array('file'=>@$data['full_path'], 'token'=>'9290123020b140515cc29bfdb776e3b471af0a43');
//                        $this->curl->post($post);
                        //echo $this->curl->execute(); exit;
                        echo 1;
                    }
                }

                else{
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);exit;
                }

            }
        }

        else{

        }

    }

    public function borrowerkyc()
    {
        if ( $this->session->userdata('borrower_state') == TRUE ){
            $config['upload_path']="./assets/borrower-documents";
            $config['allowed_types']='jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $config['overwrite']  = TRUE;
            $this->load->library('upload',$config);
            if($this->upload->do_upload("pan_file")) {
                $data = $this->upload->data();
                $borrower_file_info = array(
                    'borrower_id' => $this->session->userdata('borrower_id'),
                    'docs_type' => 'pan',
                    'docs_no' => $this->input->post('pan'),
                    'docs_name' => $data['file_name'],
                );
             $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
            }

            if($this->upload->do_upload("kyc_file")) {
                $data = $this->upload->data();
                $borrower_file_info = array(
                    'borrower_id' => $this->session->userdata('borrower_id'),
                    'docs_type' => $this->input->post('document_type'),
                    'docs_no' => $this->input->post('doc_no'),
                    'docs_name' => $data['file_name'],
                );
                $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
            }

            if($this->input->post('optionsPermanent') == 'no')
            {
                if($this->upload->do_upload("secondry_kyc_file")) {
                    $data = $this->upload->data();
                    $borrower_file_info = array(
                        'borrower_id' => $this->session->userdata('borrower_id'),
                        'docs_type' => $this->input->post('secondry_document_type'),
                        'docs_no' => $this->input->post('secondry_doc_no'),
                        'docs_name' => $data['file_name'],
                    );
                    $this->Borrowerkycmodel->insert_kyc_pan($borrower_file_info);
                }
            }
            if($this->upload->display_errors())
            {
                $msg = "OOPS! Something went wrong please check you credential and try again";
                $this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
                redirect(base_url().'borrowerprocess/kyc-updation');
            }
            else{
                $this->Borrowerkycmodel->updateprocess();
                $this->whatsloan_kyc();
                redirect(base_url().'borrowerprocess/create-escrow-account');
            }
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }

    public function whatsloan_kyc()
    {

        if ( $this->session->userdata('borrower_state') == TRUE ) {
        	return true;
            $results = $this->Borrowerkycmodel->verify_borrower_kyc();
            foreach ($results AS $result) {
                if ($result['docs_type'] == 'pan') {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = 'https://api.whatsloan.com/v1/ekyc/panOcr/details';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }

                }

                if($result['docs_type'] == 'aadhar')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = 'https://api.whatsloan.com/v1/ekyc/panOcr/details';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }

                if($result['docs_type'] == 'voterid')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = 'https://api.whatsloan.com/v1/ekyc/voterOcr';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }

                if($result['docs_type'] == 'passport')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = 'https://api.whatsloan.com/v1/ekyc/passportOcr/details';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }

                if($result['docs_type'] == 'landline')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = '';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }
                if($result['docs_type'] == 'electricity_bill')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = '';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }
                if($result['docs_type'] == 'lpg')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = '';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }
                if($result['docs_type'] == 'png')
                {
                    $filepath = FCPATH . 'assets/borrower-documents/' . $result['docs_name'];
                    $filename = realpath($filepath);
                    $url = '';
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimetype = $finfo->file($filename);
                    $ch = curl_init($url);
                    $request_headers = array(
                        "token: ".WHATAPP_TOKEN.""
                    );
                    $cfile = curl_file_create($filename, $mimetype, basename($filename));
                    $data = array('file' => $cfile);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $r = curl_getinfo($ch);
                    if ($result) {
                        $data = array(
                            'doc_id' => $result['id'],
                            'whatsloan_response' => $response,
                        );
                        $this->Borrowerkycmodel->updateKycresponse($data);
                    }
                }
            }
            return true;
        }
        else
        {
            redirect(base_url().'login/borrower');
        }
    }
}
?>

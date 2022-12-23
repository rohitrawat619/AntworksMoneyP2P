<?php
class Documentverification extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Documents');
        exit;
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function borrower_documents()
    {
        $data['list'] = $this->Documents->borrowerList();
//        echo "<pre>";
//        print_r($data['list']); exit;
        $data['pageTitle'] = "Borrower List";
        $data['title'] = "Admin Dashboard";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/nav',$data);
        $this->load->view('borrower-document/document-list',$data);
        $this->load->view('templates-admin/footer',$data);
    }

    public function viewborrowerdoc($borrower_id)
    {
            $data['list'] = $this->Documents->borrower_details($borrower_id);
//            echo "<pre>";
//            print_r($data['list']); exit;
            $data['doc'] = $this->Documents->borrowerDoc($data['list']['id']);
//            echo "<pre>";
//            print_r($data['doc']); exit;
            $data['pageTitle'] = "Borrower Document";
            $this->load->view('templates-admin/header');
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('borrower-document/borrowerdoc-info', $data);
            $this->load->view('templates-admin/footer');

    }

    public function updatedoc()
    {

            $doc_id = $this->input->post('doc_id');
            $result = $this->Documents->verifyimage($doc_id);
            if($result)
            {
                $status = array(
                    'status'=>1,
                    'response'=>'Document verified successfully',
                );
            }
            else
            {
                $status = array(
                    'status'=>0,
                    'response'=>'Please try again document not verified',
                );
            }

      echo json_encode($status);
      exit;
    }

    public function updatecomment()
    {

            $doc_id = $this->input->post('doc_id');
            $comment = $this->input->post('comment');
            $email = $this->input->post('email');
            $result = $this->Documents->submitcomment($doc_id,$comment,$email);
            if($result)
            {
                $status = array(
                    'status'=>1,
                    'response'=>'Email Send to borrower',
                );
            }
            else
            {
                $status = array(
                    'status'=>0,
                    'response'=>'OOPS! Something went wrong please check you credential and try again',
                );
            }
        echo json_encode($status);
        exit;

    }

    public function add_docs_borrower()
    {
        //$primary_borrower_id = $this->Documents->get_borrower_id($this->input->post('borrower_id'));
        if($_FILES){
            $config['upload_path']="./assets/borrower-documents";
            $config['allowed_types']='jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;
            $config['max_width']  = '0';
            $config['max_height']  = '0';
            $config['overwrite']  = TRUE;
            $this->load->library('upload',$config);
            if(isset($_FILES['doc_file'])) {
                $total = count($_FILES['doc_file']['name']);

                if ($total > 0) {
                    $i = 0;
                    foreach ($_FILES['doc_file']['name'] as $key => $image) {
                        $_FILES['images[]']['name'] = $_FILES['doc_file']['name'][$key];
                        $_FILES['images[]']['type'] = $_FILES['doc_file']['type'][$key];
                        $_FILES['images[]']['tmp_name'] = $_FILES['doc_file']['tmp_name'][$key];
                        $_FILES['images[]']['error'] = $_FILES['doc_file']['error'][$key];
                        $_FILES['images[]']['size'] = $_FILES['doc_file']['size'][$key];

                        $this->upload->initialize($config);
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('images[]')) {
                            $error = array('error' => $this->upload->display_errors());
                            print_r($error);
                            exit;
                            //$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$error));
                            //redirect(base_url().'management/add');
                        } else {
                            $data = array('upload_data' => $this->upload->data());
                            $uploads['docs_type'] = $_POST['doc_name'][$i];
                            $uploads['docs_name'] = $data['upload_data']['file_name'];
                            $uploads['borrower_id'] = $this->input->post('borrower_id');
                            $status = $this->Documents->add_docs_borrower($uploads);
                        }
                        $i++;
                    }
                }
            }
            //$status = $this->P2pmodel->add_docs_borrower($uploads);
            if($status)
            {
                $msg="Your documents are uploaded successfully.";
                $this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
                redirect(base_url().'creditops/viewapplication/'.$this->input->post('application_no'));
            }
            else
            {
                $msg="Something went wrong!";
                $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                redirect(base_url().'creditops/viewapplication/'.$this->input->post('application_no'));
            }
        }
        else
        {
            $msg="Please Select a File! We accept .doc, .dox, .jpg, .png, .pdf file formats only";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'creditops/viewapplication/'.$this->input->post('application_no'));
        }
    }


}
?>

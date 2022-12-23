<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller{

    public function index()
    {
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/common-pages/contact',$data);
        $this->load->view('templates/footer');
    }

    public function contact_us_mail() {

        $key_google = $this->input->post('g-recaptcha-response');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify?secret=6LfUYaIUAAAAAFUQg_NG1Zac4qMOhj0lh9AOnYbR&response=$key_google",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            redirect(base_url('contact'));
        } else {
            $data = json_decode($response, true);
            if ($data['success'] == 1) {
                if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
                    $this->load->model('Emailmodel');
                    $result = $this->Emailmodel->contact_us_mail();
                    if($result)
                    {
                        redirect(base_url().'contact/thankyou');
                    }
                    else{
                        redirect(base_url().'contact');
                    }
                }
                else{
                    echo "OOPS! You do not have Direct Access. Please Login";
                }
            }
        }

    }

    public function thankyou()
    {
        $data['title']='P2P Lending | Quick and Easy P2P Loan Services in India';
        $data['description']="The most trusted P2P Loan services in India enabling low interest loans for bad credit Borrowers and increased earnings for Lenders. Compare and Apply now.";
        $data['keywords']='';
        $this->load->view('templates/header',$data);
        $this->load->view('templates/nav',$data);
        $this->load->view('templates/collapse-nav',$data);
        $this->load->view('frontend/common-pages/contact-thankyou',$data);
        $this->load->view('templates/footer');
    }
}
?>
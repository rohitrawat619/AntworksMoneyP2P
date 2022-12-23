<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Emsigner extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
       // $this->load->model(array('Requestmodel','Emsignermodel'));
        $this->load->library('form_validation');
        $this->load->library('encryption');

    }


   public function index()
     {
         $this->encryption->initialize(
             array(
                 'driver'=>'openssl',
                 'cipher' => 'AES-256',
                 'mode' => 'CBC',
             )
         );
         $uniqueId = uniqid(rand(), TRUE);

         $session_id = $this->encryption->encrypt($uniqueId);

         $data_pdf = file_get_contents('./assets/esignSamplepdf.pdf');
         $pdf_base64_data = base64_encode($data_pdf);



         $reference_no = $uniqueId;
         $data_json = json_encode(array(
                          'Name' =>"Vikas" ,
                          'FileType' =>"PDF",
                          'SignatureType' => 3,
                          'SelectPage' =>"FIRST" ,
                          'SignaturePosition' => "Top-Left",
                          'AuthToken' => "dad165a0-f5a1-4083-8542-5b225713016a",
                          'File' => $pdf_base64_data,
                          'PageNumber' =>2 ,
                          'PreviewRequired' =>true ,
                          'PagelevelCoordinates' => null,
                          'CustomizeCoordinates' => null,
                          'SUrl' => base_url()."emsigner/successUrl",
                          'FUrl' => base_url()."emsigner/Error",
                          'CUrl' => base_url()."emsigner/Cancel",
                          'ReferenceNumber' => $reference_no,
                          'Enableuploadsignature' =>true ,
                          'EnableDrawSignature' =>true ,
                          'EnableeSignaturePad' =>true ,
                          'IsCompressed' =>false ,
                          'IsCosign' =>true ,
                          'EnableViewDocumentLink' =>true ,
                          'Storetodb' =>true ,
                          'IsGSTN' =>true ,
                          'IsGSTN3B' =>true ,

                        ));
         $this->encryption->initialize(
                array(
                        'driver'=>'openssl',
                        'cipher' => 'aes-128',
                        'mode' => 'ctr',
                        'key' => $session_id,
                )
        );
  
       $data['Parameter2'] = $this->encryption->encrypt($data_json);

       // parameter 2
       
        $hash = hash('SHA256', $data_json);
  
		$data['Parameter3'] = $this->encryption->encrypt($hash);

       // parameter 3

	     $pkey_details = openssl_pkey_get_details(openssl_pkey_get_public(file_get_contents("./assets/emsignerCertificate/certificate.cer")));
       	 $public_key = $pkey_details['key'];
	   	 $public_key = str_replace('-----BEGIN PUBLIC KEY-----', '', $public_key);
		 $public_key = str_replace('-----END PUBLIC KEY-----', '', $public_key);

         $this->encryption->initialize(
             array(
                 'driver'=>'openssl',
                 'cipher' => 'aes-128',
                 'mode' => 'ctr',
                 'key' => $public_key,
             )
         );

		 $data['Parameter1'] = $this->encryption->encrypt($session_id);

		 echo $data['Parameter1']; echo "<br>";
		 echo $data['Parameter2']; echo "<br>";
		 echo $data['Parameter3']; echo "<br>";

          $this->load->view('frontend/borrower/emsigner', $data);
     }

     public function successUrl()
     {

     }

     public function Error()
     {

     }

     public function Cancel()
     {

     }

}

?>

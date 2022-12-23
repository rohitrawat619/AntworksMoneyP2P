<?php
class Upiresponse extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$opts = array(
			'http'=>array(
				'method'=>"post",
				'Content-Type' => 'application/xml',
			)
		);

	   $context = stream_context_create($opts);
	   $response = file_get_contents('php://input', 'false', $context);
	   $arr_response = array(
	   	"response" => json_encode($response),
	   );
       $this->db->insert('p2p_upi_response', $arr_response);


	}
}

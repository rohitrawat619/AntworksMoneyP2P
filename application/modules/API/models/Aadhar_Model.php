<?php

class Aadhar_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		//$this->p2pdb = $this->load->database('default', true);
	}

	
		public function saveResponse($response){
			$this->db->insert('aadhar_api_response', $response);
		}
 	

}

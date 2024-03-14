<?php

class Pan_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->p2pdb = $this->load->database('default', true);
	}

	
		public function savePanApiResponse($arr_pan_api_response_all){
			$this->p2pdb->insert('borrower_pan_api_details', $arr_pan_api_response_all);
		}
 

	public function getPanData($pan,$name){
		$query = $this->p2pdb->get_where('borrower_pan_api_details', array('pan' => $pan, 'name' => $name, 'name_match'=>1));
		$querySql = $this->p2pdb->last_query();
		if ($this->p2pdb->affected_rows()  > 0) {
			$result = $query->row_array();
			$data['status'] = "1";
			$data['msg'] = "Success";
			$data['data'] = $result;
			//$data['query'] = $querySql;
			
			
		}else{
			$data['status'] = "0";
			$data['msg'] = "Failed";
			$data['data'] = null;
			
		}
			return $data;
	}

	

}

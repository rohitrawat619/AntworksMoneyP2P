<?php

class Tvsdownload extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}

	public function download()
	{

		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$delimiter = ",";
		$newline = "\r\n";
		$filename = "Tvs.csv";

		$results = $this->db->select("ur.*, cd.Disposition_Code, cd.PTP_Dt, cd.PTP_AMOUNT, cd.PTP_MODE, cd.Next_action, cd.Payment_Mode, cd.Paid_Amount, cd.Paid_Dt, cr.comment_data as antworks_remarks")
			->join('tvs_user_calling_data cd', 'on cd.tvs_id = ur.id', 'left')
			->join('tvs_comment_record cr', 'on cr.tvs_id = ur.id', 'left')
			->group_by('ur.id')
			->get_where('tvs_user_records ur');


		if ($this->db->affected_rows() > 0) {
			$data = $this->dbutil->csv_from_result($results, $delimiter, $newline);
			force_download($filename, $data);
		} else {
			return false;
		}
	}

}

?>

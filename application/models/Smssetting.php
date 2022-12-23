<?php //SMS and Email configuration here
class Smssetting extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function smssetting()
    {
        $this->db->select('*');
        $this->db->from('p2p_admin_sms_setting');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            return (array)$query->row();
        }
        else{
            return false;
        }
    }

	public function emilConfigration()
	{
		$this->load->library('email');
		$this->db->select('protocol, smtp_host, smtp_port, smtp_user, smtp_pass, mailtype, mailtype, charset, wordwrap');
		$this->db->from('p2p_admin_email_setting');
		$this->db->where('status', 1);
		$query= $this->db->get();
		return $email_config = (array)$query->row();
	}
}
?>

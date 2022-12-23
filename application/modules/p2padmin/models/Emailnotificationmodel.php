<?php
class Emailnotificationmodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getNotification($notificationId){
		$query = $this->db->get_where('p2p_email_notification', array('id' => $notificationId));
		if($this->db->affected_rows()>0)
		{
            return (array)$query->row();
		}
		else{
            return false;
		}
	}

	public function getAllnotification($limit, $start)
	{
         $query = $this->db->limit($limit, $start)->order_by('id', 'desc')->get_where('p2p_email_notification');
         if($this->db->affected_rows()>0)
		 {
           return $query->result_array();
		 }
         else{
           return false;
		 }
	}

	public function addNofication()
	{
		if($this->db->affected_rows()>0)
		{

		}
		else{
			return false;
		}
	}

	public function activeDeactivenotification()
	{

	}

	public function countNotification()
	{
		return $this->db->count_all('p2p_email_notification');
	}
}?>

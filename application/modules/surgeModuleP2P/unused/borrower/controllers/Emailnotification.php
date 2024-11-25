<?php

class Emailnotification extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Emailnotificationmodel'));
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}
    }

    public function index()
    {
		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = base_url() . "emailnotification";
		$config["total_rows"] = $this->Emailnotificationmodel->countNotification();
		$config["per_page"] = 100;
		$config["uri_segment"] = 3;
		$config['num_links'] = 10;
		$config['full_tag_open'] = "<div class='new-pagination'>";
		$config['full_tag_close'] ="</div>";

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

		$data["pagination"] = $this->pagination->create_links();
		$data['list'] = $this->Emailnotificationmodel->getAllnotification($config["per_page"], $page);
		$data['pageTitle'] = "Notification List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('notification/notification-list',$data);
		$this->load->view('templates-admin/footer',$data);
    }

    public function edit($id)
	{
		$data['notification'] = $this->Emailnotificationmodel->getNotification($id);
		$data['pageTitle'] = "Edit notification";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('notification/edit-notification',$data);
		$this->load->view('templates-admin/footer',$data);
	}

	public function addNotification()
	{
		$data['pageTitle'] = "Notification List";
		$data['title'] = "Admin Dashboard";
		$this->load->view('templates-admin/header',$data);
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('notification/add-new-notification',$data);
		$this->load->view('templates-admin/footer',$data);
	}

	public function actionaddnotification()
	{
		$notification_array = array(
			'user_type' => $this->input->post('user_type'),
			'communication_type' => $this->input->post('communication_type'),
			'status' => $this->input->post('status'),
			'instance' => $this->input->post('instance'),
			'sms_content' => $this->input->post('sms_content'),
			'notification_content' => $this->input->post('notification_content'),
			'email_content' => $_POST['email_content'],
		);
		$this->db->insert('p2p_email_notification', $notification_array);
		if($this->db->affected_rows()>0)
		{
			$msg = "Notification added successfully";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'p2padmin/emailnotification/addNotification');
		}
		else{
			$msg = "Something went wrong";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'p2padmin/emailnotification/addNotification');
		}
	}

	public function updatenotification()
	{
		$notification_array = array(
			'user_type' => $this->input->post('user_type'),
			'communication_type' => $this->input->post('communication_type'),
			'status' => $this->input->post('status'),
			'instance' => $this->input->post('instance'),
			'sms_content' => $this->input->post('sms_content'),
			'notification_content' => $this->input->post('notification_content'),
			'email_content' => $_POST['email_content'],
		);
		$this->db->where('id', $this->input->post('id'));
		$this->db->update('p2p_email_notification', $notification_array);
		if($this->db->affected_rows()>0)
		{
			$msg = "Update successfully";
			$this->session->set_flashdata('notification', array('error' => 0, 'message' => $msg));
			redirect(base_url() . 'p2padmin/emailnotification/edit/'. $this->input->post('id'));
		}
		else{
			$msg = "We could not find any update. Please check back";
			$this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
			redirect(base_url() . 'p2padmin/emailnotification/edit/'. $this->input->post('id'));
		}
	}
}
?>

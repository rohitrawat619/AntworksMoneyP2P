<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Management extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	}
	
	public function index()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			redirect(base_url().'dashboard/');
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function dashboard()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==16)
			{
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				/*$notificationdetails = $this->Loginmodel->notificationdetails();
				$data['notification'] = $notificationdetails;
				$data['recents'] = $this->Managementmodel->recents();*/
				
				$data['list'] = $this->Managementmodel->user_list();
				
				$data['pageTitle'] = "Users List";
				
				$this->load->view('templates-admin/header',$data);
				$this->load->view('templates-admin/nav',$data);
				$this->load->view('templates-admin/header-below',$data);
				$this->load->view('management-dashboard',$data);
				$this->load->view('templates-admin/footer');
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function profile()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
			$data['userdetails'] = $userdetails[0];
			$editlist = $this->Managementmodel->profile();
			$data['profiledetails'] = $editlist[0];
			
			$data['pageTitle'] = "My Profile";
			
			if($data['profiledetails'])
			{
				$this->load->view('templates-admin/header',$data);
				$this->load->view('templates-admin/nav',$data);
				$this->load->view('templates-admin/header-below',$data);
				$this->load->view('profile',$data);
				$this->load->view('templates-admin/footer');
			}
			else
			{
				$msg="Something went wrong!";
				$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
				redirect(base_url().'management/dashboard/');
			};
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function register_user()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user_info.username]');
				$this->form_validation->set_rules('password', 'Password', 'required');
				$this->form_validation->set_rules('first_name', 'First Name', 'required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'required');
				$this->form_validation->set_rules('email', 'Email ID', 'required|valid_email|is_unique[user_info.email]');
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
				$this->form_validation->set_rules('gender', 'Gender', 'required');
				$this->form_validation->set_rules('state_code', 'State', 'required');
				$this->form_validation->set_rules('city', 'City', 'required');
				$this->form_validation->set_rules('address', 'Address', 'required');
				$this->form_validation->set_rules('role', 'Role', 'required');
				
				if ($this->form_validation->run() == TRUE)
				{
					$config['upload_path'] = './uploads/users/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					//$config['max_size']	= '20000';
					$config['max_width']  = '0';
					$config['max_height']  = '0';
					$config['overwrite']  = TRUE;
					
					if(!empty($_FILES['profilepic']['name']))
					{
						$this->upload->initialize($config);
						$this->load->library('upload', $config);
			
						if (!$this->upload->do_upload('profilepic'))
						{
							$error = array('error' => $this->upload->display_errors());
							//print_r($error);exit;
							$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$error));
							redirect(base_url().'management/add');
						}
						else
						{
							$data = array('upload_data' => $this->upload->data());
						}
					}
					
					$status = $this->Managementmodel->register_user();
					if($status)
					{
						$msg="User Created Successfully";
						$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
						redirect(base_url().'management/dashboard/');
					}
					else
					{
						$msg="Something went wrong!";
						$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
						redirect(base_url().'management/dashboard/');
					}
				}
				else
				{
					$errmsg = $this->form_validation->error_array();
					$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
					redirect(base_url().'management/dashboard/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function delete_user($uid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$status = $this->Managementmodel->delete_user($uid);
				if($status)
				{
					$msg="User Deleted Successfully";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'management/dashboard/');
				}
				else
				{
					$msg="User could not be deleted. Please try again";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/dashboard/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function edit_user($eid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==16)
			{
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				/*$notificationdetails = $this->Loginmodel->notificationdetails();
				$data['notification'] = $notificationdetails;*/
				
				$editlist = $this->Managementmodel->edit_user($eid);
				$data['editlist'] = $editlist[0];
				
				$data['pageTitle'] = "Edit User";
				
				if($data['editlist'])
				{
					$this->load->view('templates-admin/header',$data);
					$this->load->view('templates-admin/nav',$data);
					$this->load->view('templates-admin/header-below',$data);
					$this->load->view('management-edit',$data);
					$this->load->view('templates-admin/footer');
				}
				else
				{
					$msg="Something went wrong!";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/dashboard/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function update_user($uid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==16)
			{
				//$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user_info.username]');
				$this->form_validation->set_rules('first_name', 'First Name', 'required');
				$this->form_validation->set_rules('last_name', 'Last Name', 'required');
				//$this->form_validation->set_rules('email', 'Email', 'required|email|is_unique[user_info.email]');
				$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
				$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
				$this->form_validation->set_rules('state_code', 'State', 'required');
				$this->form_validation->set_rules('city', 'City', 'required');
				$this->form_validation->set_rules('address', 'Address', 'required');
				$this->form_validation->set_rules('role', 'Role', 'required');
				
				if ($this->form_validation->run() == TRUE)
				{
					if($_FILES['profilepic']['name'])
					{
						$config['upload_path'] = './uploads/users/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						//$config['max_size']	= '20000';
						$config['max_width']  = '0';
						$config['max_height']  = '0';
						$config['overwrite']  = TRUE;
						
						if(!empty($_FILES['profilepic']['name']))
						{
							$this->upload->initialize($config);
							$this->load->library('upload', $config);
				
							if (!$this->upload->do_upload('profilepic'))
							{
								$error = array('error' => $this->upload->display_errors());
								print_r($error);exit;
								//$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$error));
								//redirect(base_url().'management/add');
							}
							else
							{
								$data = array('upload_data' => $this->upload->data());
							}
						}
					}
					
					$status = $this->Managementmodel->update_user($uid);
					if($status)
					{
						if($this->session->userdata('role')==1)
						{
							$msg="User Updated Successfully";
							$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
							redirect(base_url().'management/dashboard/');
						}
						else
						{
							$msg="Profile Updated Successfully";
							$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
							redirect(base_url().'management/edit_user/'.$uid);
						}
					}
					else
					{
						$msg="User detail not updated. Please try again.";
						$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
						redirect(base_url().'management/dashboard/');
					}
				}
				else
				{
					$errmsg = $this->form_validation->error_array();
					$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
					redirect(base_url().'management/dashboard/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function add_role()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$this->form_validation->set_rules('role', 'Role', 'required');
				
				if ($this->form_validation->run() == TRUE)
				{
					$status = $this->Managementmodel->add_role();
					if($status)
					{
						$msg="Role Created Successfully";
						$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
						redirect(base_url().'management/dashboard/');
					}
					else
					{
						$msg="Something went wrong!";
						$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
						redirect(base_url().'management/dashboard/');
					}
				}
				else
				{
					$errmsg = $this->form_validation->error_array();
					$this->session->set_flashdata('validation_errors',array('error'=>1,'message'=>$errmsg));
					redirect(base_url().'management/dashboard/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function list_roles()
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				
				$data['rolelist'] = $this->Managementmodel->rolelist();
				
				$data['pageTitle'] = "Roles List";
				
				$this->load->view('templates-admin/header',$data);
				$this->load->view('templates-admin/nav',$data);
				$this->load->view('templates-admin/header-below',$data);
				$this->load->view('roles-list',$data);
				$this->load->view('templates-admin/footer');
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function delete_role($uid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$status = $this->Managementmodel->delete_role($uid);
				if($status)
				{
					$msg="Role Deleted Successfully";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'management/list_roles/');
				}
				else
				{
					$msg="Role not Deleted";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/list_roles/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function edit_role($eid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				
				$editlist = $this->Managementmodel->edit_role($eid);
				$data['editlist'] = $editlist[0];
				
				$data['pageTitle'] = "Edit Role";
				
				if($data['editlist'])
				{
					$this->load->view('templates-admin/header',$data);
					$this->load->view('templates-admin/nav',$data);
					$this->load->view('templates-admin/header-below',$data);
					$this->load->view('role-edit',$data);
					$this->load->view('templates-admin/footer');
				}
				else
				{
					$msg="Something went wrong!";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/list_roles/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}
	
	public function update_role($uid)
	{
		if ( $this->session->userdata('login_state') == TRUE )
		{
			if($this->session->userdata('role')==1)
			{
				$status = $this->Managementmodel->update_role($uid);
				if($status)
				{
					$msg="Role Updated Successfully";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'management/list_roles/');
				}
				else
				{
					$msg="Role not Updated";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/list_roles/');
				}
			}
			else
			{
				redirect(base_url().'dashboard/');
			}
		}
		else
		{
			$msg="Login Failed, Something went wrong please check you credential and try again.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/');
		}
	}

	//////////////////////////////////////////////
	public function borrowerlist()
	{
		$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
		$data['userdetails'] = $userdetails[0];
		if (isset($_GET["page"]))
			$page = (int)$_GET["page"];
		else
			$page = 1;

		$setLimit = 100;
		$pageLimit = ($page * $setLimit) - $setLimit;
		$data['list'] = $this->Managementmodel->borrower_list($pageLimit, $setLimit);
		$data['displayPaginationBelowborrower'] = $this->displayPaginationBelowborrower($setLimit, $page);

		$data['pageTitle'] = "Borrower List";
		$this->load->view('templates-admin/header');
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('templates-admin/header-below',$data);
		$this->load->view('borrowers',$data);
		$this->load->view('templates-admin/footer');
	}

	public function lenderslist()
	{
		$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
		$data['userdetails'] = $userdetails[0];
		if (isset($_GET["page"]))
			$page = (int)$_GET["page"];
		else
			$page = 1;
		$setLimit = 100;
		$pageLimit = ($page * $setLimit) - $setLimit;
		$data['list'] = $this->Managementmodel->lenders_list($pageLimit, $setLimit);
		$data['displayPaginationBelow'] = $this->displayPaginationBelow($setLimit, $page);
		$data['pageTitle'] = "Loan Management";
		$this->load->view('templates-admin/header');
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('templates-admin/header-below',$data);
		$this->load->view('lenders',$data);
		$this->load->view('templates-admin/footer');
	}

	public function activebid()
	{
		$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
		$data['userdetails'] = $userdetails[0];

		$data['list'] = $this->Managementmodel->activebiddata();

		$data['pageTitle'] = "Active Bid";
		$this->load->view('templates-admin/header');
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('templates-admin/header-below',$data);
		$this->load->view('activebid',$data);
		$this->load->view('templates-admin/footer');
	}

	public function closedbid()
	{
		$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
		$data['userdetails'] = $userdetails[0];

		$data['list'] = $this->Managementmodel->closedbiddata();

		$data['pageTitle'] = "Closed Bid";
		$this->load->view('templates-admin/header');
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('templates-admin/header-below',$data);
		$this->load->view('closedbid',$data);
		$this->load->view('templates-admin/footer');
	}

	public function approvedbid()
	{
		$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
		$data['userdetails'] = $userdetails[0];

		$data['list'] = $this->Managementmodel->approvedbiddata();

		$data['pageTitle'] = "Approved Bid";
		$this->load->view('templates-admin/header');
		$this->load->view('templates-admin/nav',$data);
		$this->load->view('templates-admin/header-below',$data);
		$this->load->view('approvedbid',$data);
		$this->load->view('templates-admin/footer');
	}


	public function viweborrowerdetail()
	{

		if ( $this->session->userdata('login_state') == TRUE ) {


			$b_id = $_GET['borrower_id'];
			$p_id = $_GET['proposal_id'];

			$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
			$data['userdetails'] = $userdetails[0];
			$data['list'] = $this->Managementmodel->borrowerdetail($b_id,$p_id);

			$data['pageTitle'] = "Borrower Detail";
			$this->load->view('templates-admin/header');
			$this->load->view('templates-admin/nav', $data);
			$this->load->view('templates-admin/header-below', $data);
			$this->load->view('viweborrowerdetail', $data);
			$this->load->view('templates-admin/footer');
		}
	}

	public function update_borrower()
	{

	}

	public function update_lender()
	{

	}

	public function displayPaginationBelow($per_page, $page)
	{
		$page_url = "?";
		$rec = $this->Managementmodel->total_count();
		$total = $rec->totalCount;
		$adjacents = "10";

		$page = ($page == 0 ? 1 : $page);
		$start = ($page - 1) * $per_page;

		$prev = $page - 1;
		$next = $page + 1;
		$setLastpage = ceil($total / $per_page);
		$lpm1 = $setLastpage - 1;

		$setPaginate = "";
		if ($setLastpage > 1) {
			$setPaginate .= "<ul class='setPaginate'>";
			$setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
			if ($setLastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $setLastpage; $counter++) {
					if ($counter == $page)
						$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
					else
						$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
				}
			} elseif ($setLastpage > 5 + ($adjacents * 2)) {
				if ($page < 1 + ($adjacents * 2)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
					$setPaginate .= "<li class='dot'>...</li>";
					$setPaginate .= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";
				} elseif ($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
					$setPaginate .= "<li><a href='{$page_url}page=1'>1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=2'>2</a></li>";
					$setPaginate .= "<li class='dot'>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
					$setPaginate .= "<li class='dot'>..</li>";
					$setPaginate .= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";
				} else {
					$setPaginate .= "<li><a href='{$page_url}page=1'>1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=2'>2</a></li>";
					$setPaginate .= "<li class='dot'>..</li>";
					for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
				}
			}

			if ($page < $counter - 1) {
				$setPaginate .= "<li><a href='{$page_url}page=$next'>Next</a></li>";
				$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
			} else {
				$setPaginate .= "<li><a class='current_page'>Next</a></li>";
				$setPaginate .= "<li><a class='current_page'>Last</a></li>";
			}

			$setPaginate .= "</ul>\n";
		}


		return $setPaginate;
	}


	public function displayPaginationBelowborrower($per_page, $page)
	{
		$page_url = "?";
		$rec = $this->Managementmodel->total_countborrower();

		$total = $rec->totalCount;
		$adjacents = "10";

		$page = ($page == 0 ? 1 : $page);
		$start = ($page - 1) * $per_page;

		$prev = $page - 1;
		$next = $page + 1;
		$setLastpage = ceil($total / $per_page);
		$lpm1 = $setLastpage - 1;

		$setPaginate = "";
		if ($setLastpage > 1) {
			$setPaginate .= "<ul class='setPaginate'>";
			$setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
			if ($setLastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $setLastpage; $counter++) {
					if ($counter == $page)
						$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
					else
						$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
				}
			} elseif ($setLastpage > 5 + ($adjacents * 2)) {
				if ($page < 1 + ($adjacents * 2)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
					$setPaginate .= "<li class='dot'>...</li>";
					$setPaginate .= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";
				} elseif ($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
					$setPaginate .= "<li><a href='{$page_url}page=1'>1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=2'>2</a></li>";
					$setPaginate .= "<li class='dot'>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
					$setPaginate .= "<li class='dot'>..</li>";
					$setPaginate .= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";
				} else {
					$setPaginate .= "<li><a href='{$page_url}page=1'>1</a></li>";
					$setPaginate .= "<li><a href='{$page_url}page=2'>2</a></li>";
					$setPaginate .= "<li class='dot'>..</li>";
					for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {
						if ($counter == $page)
							$setPaginate .= "<li><a class='current_page'>$counter</a></li>";
						else
							$setPaginate .= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";
					}
				}
			}

			if ($page < $counter - 1) {
				$setPaginate .= "<li><a href='{$page_url}page=$next'>Next</a></li>";
				$setPaginate .= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
			} else {
				$setPaginate .= "<li><a class='current_page'>Next</a></li>";
				$setPaginate .= "<li><a class='current_page'>Last</a></li>";
			}

			$setPaginate .= "</ul>\n";
		}


		return $setPaginate;
	}

	public function disbursement_cases()
	{
		if ( $this->session->userdata('login_state') == TRUE ) {
			if ($this->session->userdata('role') == 16) {
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				$data['list'] = $this->Managementmodel->approved();

				$data['pageTitle'] = "Active Bid";
				$this->load->view('templates-admin/header');
				$this->load->view('templates-admin/nav', $data);
				$this->load->view('templates-admin/header-below', $data);
				$this->load->view('approved', $data);
				$this->load->view('templates-admin/footer');
			}
		}

	}

	public function view_disbursement_cases()
	{ error_reporting(0);
		$proposal_id = $_GET['proposal_id'];
        $data['list'] = $this->Managementmodel->approved_bidding_view($proposal_id);
		if(!empty($proposal_id)) {
			$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE BPD.bid_registration_id='$proposal_id' AND ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL
			";
			$query = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) {
				$res = $query->result_array();

//					echo "<pre>";
//					print_r($res); exit;
				$table = "";
				$today = date("l-m-Y");
				$current_time_stamp = $date = date('d/m/Y H:i:s', time());
				foreach ($res AS $result) {

					if($result['LoanAccountNumber'] == "") {
						$this->db->select("loan_account_number");
						$this->db->order_by('loan_account_number', 'DESC');
						$this->db->limit(1);
						$query = $this->db->get('approved_bidding_details');
						$row = (array)$query->row();

						if ($this->db->affected_rows() > 0) {

							$lan = $row['loan_account_number'];
							$lan++;
							$loan_amount_number = $lan;
						} else {
							$loan_amount_number = "LAN1000001";
						}
						$this->db->set('loan_account_number', $loan_amount_number);
						$this->db->where('bid_approve_id', $result['bid_approve_id']);
						$this->db->update('approved_bidding_details');
					}
					else{
						$loan_amount_number = $result['LoanAccountNumber'];
					}
					$loan_amount = $result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT'] / 100;
					$loan_amount_inword = $this->convert_number_to_words($loan_amount);
					$loan_interest_rate = $result['LOAN_Interest_rate'];
					$loan_tenor = $result['TENORMONTHS'];
					$loan_time = $loan_tenor / 12;
					$loan_ir = $loan_interest_rate;
					$numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
					$denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
					$emi = ($numerator / $denominator);
					$table = "";
					for ($i = 1; $i <= $loan_tenor; $i++) {

						if ($i == 1) {
							$emi_sn[$i] = "Month " . $i;
							$emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
							$emi_principal[$i] = $emi - $emi_interest[$i];
							$emi_balance[$i] = $loan_amount - $emi_principal[$i];
						} else if ($i < 37) {
							$emi_sn[$i] = "Month " . $i;
							$emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
							$emi_principal[$i] = $emi - $emi_interest[$i];
							$emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
						} else if ($i >= 37) {
							break;
						}
						$day = date('j');
						if($day>=8)
						{

							$date = date('07/F/Y', strtotime('+'.$i.' month')); echo "<br>";
						}
						else{
							if($i==1)
							{
								$date = date('07/F/Y'); echo "<br>";
							}
							else{
								$date = date('07/F/Y', strtotime('+'.$i.' month')); echo "<br>";
							}

						}
						$table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>".$date."</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";

					}

					$html = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
<title>P2P Antworks Finance</title>
</head>
<body>
<section>
<div class='container'>
<div class='row'>
  <div class='welcome'>
    <p class='text-right'>LAN: AW ".$loan_amount_number."</p>
    <div class='text-center'>
    <p>Between</p>
    <p>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "</p>
    <p>['The Borrower']</p>
    <p>and</p>
    <p>" . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . "</p>
    <p>['Lender']</p>
    <p>and</p>
    <h2 class='agrmnt-hd'>ANTWORKS P2P FINANCING PRIVATE LIMITED</h2>
    <p>['Antworks']</p>
      </div>
  </div>
</div>
</div>
</section>
<div class='container'>
	<h3 class='agrmnt-hd text-center'>LOAN AGREEMENT</h3>
    <p>THIS AGREEMENT for Loan dated " . $today . "</p>
    <p>BETWEEN</p>

<p>Mr. / Ms. ". $result['BORROWERNAME']." " . $result['BORROWERMIDDLENAME']." " . $result['BORROWERLASTNAME'] . " s/o / w/o " . $result['BORROWERFATHERNAME'] . " Residing at " . $result['BORROWERR_Address'] . " " . $result['BORROWERR_Address1'] . " " . $result['BORROWERR_City'] . " " . $result['BORROWERR_State'] . " " . $result['BORROWERR_Pincode'] . " having PAN  " . $result['BORROWERR_pan'] . ", hereinafter referred to as 'the Borrower' and as more fully described in First Schedule hereunder(which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and heirs) of the First Part</p>

<p>AND</p>

<p>Mr. / Ms. ". $result['LENDER_fNAME']." " . $result['LENDER_middle_name']." " . $result['LENDER_last_name'] . "s/o / w/o " . $result['LENDER_fNAME'] . ". Residing at " . $result['LENDER_address'] . " " . $result['LENDER_address1'] . " " . $result['LENDER_city'] . " " . $result['LENDER_state_code'] . " having PAN  " . $result['LENDER_PAN'] . ", hereinafter referred to as'the Lender' and as more fully described in First Schedule hereunder(which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors, assigns and heirs) of the Second Part</p>

<p>AND</p>

<p>ANTWORKS P2P Financing Private Limited, CIN U65999HR2017PTC071580 having its Registered Office at UL-03, Eros EF3 Mal, Sector-20 A, Mathura Road, Faridabad,121001, Haryana, having PAN AAQCA2578Q, hereinafter referred to as 'Antworks' (which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and assigns) of the Third Part</p>

<p>WHEREAS Antworks runs an online portal <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>  which is a 'Peer to Peer Lending Platform' as defined under Direction 4 (1) (v) of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</p>
<p>AND WHEREAS <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>, subject to the provisions of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017is an open to all platform wherein borrowers and lenders can freely choose each other based on their choice of parameters like profile of counter-party, tenure, rate of interest, repayment mode, quantum of loan etc. thereby creating a competitive atmosphere for the debt market.</p>
<p>AND WHEREAS the Borrower, being in need of money, have registered it in the portal <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> and had raised some request for a loan by filling up of necessary forms with the portal.</p>
<p>AND WHEREAS the Lender, having certain surplus funds was willing to deploy them as debt and accordingly registered himself with <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> as a lender.</p>
<p>AND WHEREAS the Lender and the Borrower coming to know their mutual requirements conducted their respective diligence and finally decided to grant and accept respectively a loan amounting to Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . ".</p>
<p>AND WHEREAS Antworks will act as a facilitator in the entire process of Loan starting from the disbursement and ending with the recovery of the Loan.It is also clearly understood and agreed by both Borrower and Lender that Antworks is a party to this agreement without any obligation or liability to either Lender or Borrower or anyone claiming or acting through them.</p>
<p>NOW THEREFORE, in consideration of the mutual covenants as set forth below, and based on the various representations and warranties of the Parties as herein made the Parties hereby agree to enter into the present Agreement on the terms and conditions as set out herein.</p>
<p><strong>1. Definitions</strong>:</p>
<ol class='definations-list'>
<li><strong>Assistance Fee</strong> shall have the meaning as described in Clause 10 hereunder.</li>
<li><strong>Designated Date</strong> shall mean the date on which the EMI falls due as depicted in 3rd Schedule hereunder.</li>
<li><strong>Designated Loan Disbursement Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Lender would transfer the Principal Loan Amountfor being disbursed to the Borrower at the instance of Antworks.</li>
<li><strong>Designated Loan Repayment Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Borrower shall deposit the EMI amount for being transferred to the Lender at their respective personal account at the instance of Antworks.</li>
<li><strong>EMI</strong> shall meanthe amountto be paid by the Borrower for servicing / repayment of the Loan (ie. principal and interest) as more fully described in Clause 11,hereunder</li>
<li><strong>Escrow Bank</strong> shall be IDBI Bank</li>
<li><strong>Loan Disbursement Date</strong> for the purpose of this Agreement shall mean the date on which the Principal Loan amount, as reduced by the Borrower'sAssistance Fee payable to Antworks, is credited to the Bank Account of the Borrower and which date shall be treated as the date from which Interest will be payable by the Borrower to the Lender.</li>
<li><strong>Loan Transaction</strong> for the purpose of this Agreement shall mean the amountof Loan granted by the Lender to the Borrower.</li>
<li><strong>'Peer to Peer Lending Platform'</strong> shall have the same meaning as defined under Direction 4 (1) (v) of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</li>
<li><strong>Penal Interest</strong> for the purpose of this Agreement shall mean the rate of interest per annum payable by the Borrower for any failure to pay any EMI on due date (.ie. designated date on which it is due for payment) in addition to the rate of interest of the loanfor the period of delay till repayment of the entire overdue EMI amount.</li>
<li><strong>Principal Loan Amount / PLA</strong> for the purpose of this agreement shall mean the amount of the loans granted by the Lender to the Borrower.</li>
<li><strong>RBI Master Directions :</strong>For the purpose of this Agreement RBI Directions shall mean <strong>Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</strong> as amended from time to time.</li>
</ol>
<p><strong>2.	Purpose of Agreement</strong></p>
<p>The purpose of this Agreement is to record in writing the terms and conditions of the Loan Transaction</p>
<p><strong>3.	Loan Granted and Accepted</strong></p>
<p>The Lender, upon getting himself satisfied about the creditworthiness of the Borrower through his own means hereby grants to the Borrower the Loan on the terms and conditions contained herein and the Borrower upon getting himself satisfied about the source of fund of the Lender through his own means hereby accepts the grant of Loan made by the Lender.</p>

<p><strong>4.	Principal Loan Amount</strong></p>
<p>The principal amount of Loan covered under this Agreement is Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "</p>

<p><strong>5.	Purpose of Loan</strong></p>
<p>The Borrower has declared that he is taking the loan for " . $result['Loan_Description'] . ".</p>

<p><strong>6.	Effective Date</strong></p>
<p>This Loan Agreement shall be effective from the date of Signing of this Agreement. However, the interest on the Loan would accrue from the Loan Disbursement Date.</p>

<p><strong>7.	Tenure of the Loan</strong></p>
<p>The tenure of the Loan shall be " . $result['TENORMONTHS'] . " months</p>

<p><strong>8.	Rate of Interest</strong></p>
<p>The Loan shall be subject to an interest @" . $result['LOAN_Interest_rate'] . "% p.a.</p>

<p><strong>9.	Loan Disbursement Mechanism</strong></p>
<ol class='definations-list'>
<li>Upon the matching of the requirement of the Borrower with the Lender, the Lendershall transfer respective amount of the Loan to the Designated Loan Disbursement Escrow Account</li>
<li>Thereupon, Antworks would inform the Trustee to instruct the Escrow Bank for transfer of the Principal Loan Amount,after deducting therefrom the Loan Processing Fees payable to Antworks,to the Borrower from the Designated Loan Disbursement Escrow Account preferably by the immediately succeeding working day after the Lenderhas transferred his loan amount in the Designated Loan Disbursement Escrow Account.</li>
</ol>

<p><strong>10.	Assistance Fee </strong></p>

<p>A. <span class='def-sublist'>Borrower's Assistance Fee:</span></p>
<ol class='definations-list'>
<li>For providing the Peer to Peer Lending Platform and providing incidental services like monitoring the disbursements,Antworksshall be entitled to an Assistance Fees to be known as Borrower's Assistance Fees, atthe rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> payable by the Borrower availing the services.</li>
<li>The Borrower's Assistance Fee (payable by the Borrower)can be recovered by Antworksfrom the Principal Loan Amount before the disbursement. The Borrower shall be liable to repay the Principal Loan Amount to the Lender and interest thereupon.The Borrower conveys to the Trustee his unconditional consent in favour of Antworks to deduct the Borrower's Assistance Fee from the Principal Loan Amount and undertakes not to contest or initiate any legal proceedings for such deduction, under any circumstances.</li>
</ol>
<p>B. <span class='def-sublist'>Lender's Assistance Fee:</span></p>
<ol class='definations-list'>
<li>For providing the Peer to Peer Lending Platform and providing incidental services like monitoring the disbursements and repayments,Antworks shall be entitled to periodical Assistance Fees to be known as Lender's Assistance Fees, at the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> payable by the Lender granting the loan .<br>
The Lender'sAssistance Fee payable by the Lendershall be paid immediately as and when charged by Antworks (in line with the rate and schedule provided in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) by way of online transfer to the Bank account of Antworks.</li>
<li>The Lender's Assistance Fee (payable by the Lender)can be recovered by Antworksfrom the EMIamount from time to time as and when due. The Lender shall be construed to have received the entire EMI against the Loan regardless of the Lender's Assistance Fee collected by Antworks from the EMI. The Lender conveys to the Trustee his unconditional consent in favour of Antworks to deduct the Lender's Assistance Fee from the EMI Amount and undertakes not to contest or initiate any legal proceedings for such deduction, under any circumstances.</li>
</ol>
<p><strong>11.	Payment of Interest and Repayment of Principal Loan Amount by way of EMI</strong></p>
<ol class='definations-numlist'>
<li>The Borrower shall pay the interest along with the principal by way of predetermined monthly installment (EMI) to the Lenderas per an Amortization Schedule, to be shared separately with the Parties herein and shall form an integral part of this Agreement, in the format depicted in the ThirdSchedulehereunder.</li>
<li>The 1st EMI shall be paid by the Borrower to the Lender on the 15th day of the month immediately subsequent to the month in which the loan has been first disbursed by the Lender to the Borrower. The first EMI would be adjusted by the broken period interest; i.e. if the Loan Disbursement Date of the loan is prior to 15th of any calendar month, the first EMI would be incremented by simple interest (at the Rate of Interest as in Clause 8 hereinabove) for number of days till 15th and conversely if the Loan Disbursement Date is after 15th, the first EMI would be reduced by simple interest (at the Rate of Interest as in clause 8 above) for the number of days past 15th. </li>
<li>The Borrower shall pay the Applicable EMI by way of ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism favoring the Designated Loan Repayment Escrow Account</li>
<li>Antworks would inform the Trustee to instruct the Escrow Bank for transfer of EMI amount deposited by the Borrower in Designated Loan Repayment Escrow Account to the Lender preferably by the immediately succeeding working day, after deducting therefrom the Lender' Assistance fee wherever applicable.</li>
<li>The payment of EMI through ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism shall be prefixed (as per an Amortization Schedule depicted inThird Schedule) and will remain unchanged (except the first EMI) throughout the Tenure of Loan availed unless otherwise agreed upon by all the parties to this agreement. </li>
<li>Any amount paid by the Borrower in any account of the Lender other than the Designated Loan Repayment Escrow Account shall not be treated as an EMI for the purpose of this Agreement and such payment shall not be treated as a payment towards the Loan.</li>
</ol>
<p><strong>12.	Payment Assurance</strong></p>
<ol class='definations-list'>
<li>In order to assure the payment of the Lender, the Borrower shall have to furnish Cheques(PDC) as follows:</li>
<ol class='definations-numlist'>
<li>1 PDC for the amountof Loan of the Lender</li>
<li>5 PDCs for 5 EMIs.</li>
</ol>
<li>In addition to above the Borrower shall also furnish Demand Promissory Note ('DPN') as set out in the Fourth Schedule hereunder.</li>
</ol>
<p><strong>13.	Changes in Designated Loan Repayment Escrow Account</strong></p>
<p>During the Tenure of the Agreement Antworks may change the Designated Loan Repayment Escrow Account after serving a written notice of 30 days to the Borrower and the Lender. Upon the expiry of the said period of 30 days the new account shall be treated as the Designated Loan Repayment Escrow Account for the purpose of this agreement and accordingly the Borrower shall make the EMI payment through ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanismto such Designated Loan Repayment Escrow Account.</p>
<p><strong>14.	Delayed Payment of EMI and Penal Interest</strong></p>
<ol class='definations-list'>
<li>The Borrower shall not fail to pay his EMI in any month. However, in the event of unforeseen circumstances, if the borrower fails to pay any EMI in a particular month on the due date (ie. designated date on which it is due for payment) then it shall be treated as a non-payment of EMI (overdue EMI) and shall be subject to the Penal Interest.</li>
<li>Penal Interest referred to above shall be calculated @" . $result['LOAN_Interest_rate'] . "% per annum (in addition to the rate of interest of the loan) for the period of delay till repayment of the entire overdue EMI amount. In case only the preceding EMI is overdue, the Penal Interest would be calculated on the overdue amount. In case more than one EMI is overdue, the Penal Interest would be calculated on the total outstanding loan amount.</li>
<li>The Borrower shall regularize the non-payment of any EMI by paying the overdue EMI amount along with the applicable Penal Interest on or before the immediately succeeding EMI date. </li>
<li>Payment of Penal Interest does not absolve the Borrower from consequences of default and remedies available to the Lender under this Loan Agreement.</li>
<li>Any payment made by the Borrower on a date immediately upon failure of the EMI payment shall be, first adjusted against the Penal Interest, then by the EMI overdue and last by the current EMI.</li>
</ol>
<p><strong>15.	Events of Default:</strong></p>
<p>The following shall constitute Events of Default</p>
<ol class='definations-numlist'>
<li>Any representations or statements or particulars made in the Borrower's registration, proposal, submissions, application or updated information are found to be incorrect;</li>
<li>the Borrower commits any breach of any term set out in this Agreement;</li>
<li>the Borrower fails to repay to the Lender any two consecutive instalments (EMI) of the loan amount on the due dates i.e. designated dates on which they are due for payment; </li>
<li>If any attachment, distress execution or any other such process is initiated against the Borrower; </li>
<li>If the Borrower ceases or threatens to cease to carry on its present income earning activity, business or profession; </li>
<li>If the Borrower makes any compromise or settlement with any of his/ her creditor for any payment of dues to such creditor; </li>
<li>If any action for bankruptcy or insolvency is filed against the Borrower and/ or the Borrower is undergoing Fresh Start process.</li>
</ol>

<p><strong>16.	Curing of Default </strong></p>
<ol class='definations-list'>
<li>The Borrower shall be allowed to cure, wherever practicable, a Default within 15 days of happening of the Event of Default.</li>
<li>The Borrower has procured a specific written waiver and/ or extended time to cure the Event of Default, communicated by the Lender in respect of any Event of Default.</li>
</ol>

<p><strong>17.	Consequences of Default </strong></p>
<p>If the Borrower fails to cure any Event of Default the Lender, in addition to the rights available under normal course of law:</p>
<ol class='definations-list'>
<li>may call upon the Borrower to pay immediately the entire outstanding Principal amount along with the unpaid Interest and Penal Interest (if any, accrued till the date of such payment);</li>
<li>may enforce the DPN and /or ask Antworks to lodge the PDC, at his discretion;</li>
<li>mayinitiate proceedings under Chapter III of the Insolvency and Bankruptcy Code, 2016 and / or such other remedy by virtue of any other security, statute or rule of law, as may be applicable.</li>
</ol>

<p><strong>18.	Role of Antworks</strong></p>
<p>Antworks would perform the following roles against payment of fees for the respective services as disclosed in its website from time to time.</p>
<ol class='definations-list'>
<li>Co-ordination among the parties for sharing of information and communication, as set out in this agreement and as provided in the website of Antworks from time to time.</li>
<li>Antworks may at its option provide other services, as it may deem fit, for the purpose of grant of the loan by the Lender to the Borrower and repayment of the loan by the Borrower to the Lender.All the parties to the transaction provide their consent for Antworks to perform any such roles or to provide any such services as Antworks may deem fit. Borrower and Lender agree to pay fees to Antworks for the services (as availed by them) according to the rates as specified in the website of Antowrksie. <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>Antworks may also provide the services of taking steps towards recovery of debt from the Borrower in case of default including coordinating and initiating proceedings including legal measures against the Borrower. The Lender hereby authorize the Antworks for such acts and deeds as may be necessary. The Lender hereby agree to pay such fees as disclosed in the website of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) for the services, as also pay the fees of any consultant, agent or lawyer engaged by Antworksand reimburse the expenses incurred for the same purpose. The Borrower hereby provides no objection to the Antworks,including any consultant, agent or lawyer engaged by Antowrks, to carry out all such deeds and acts as may be necessary for the purpose of the Loan.</li>
</ol>

<p><strong>19.	Borrower's Undertaking</strong></p>
<p>The Borrower hereby undertakes as follows:</p>
<ol class='definations-list'>
<li>That the Aggregate of the loan taken by the Borrower across all Peer to Peer Lending Platform is not more than INR 10,00,000/-.</li>
<li>That the Borrower has got himself satisfied about the source of fund of the Lender through his own means and acknowledges that Antworks is a facilitator in the entire process and does not stand for any authenticity or guarantee in respect of the Leander or the Loan;</li>
<li>The personal data and all information furnished by him are true and correct at the time of submission.</li>
<li>Any change in his variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>
<li>The Borrower shall, on an annual basis, furnish/ updated information as submitted to the Antowrks website (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>), including Bank statements of all his Bank accounts, information on his income for the immediately preceding financial year, present monthly income, copy of latest Income Tax Return, other Borrowings and payment obligations etc.</li>
<li>The Borrower authorizes Antworks to carry out such Due Diligence on him as it may deem necessary including tracking his activities in the social media or any other forum, accessing information about him as available with any information repository. Antowrks is also authorized to engage any third party for the purpose of collecting/ collating and/ or verification of information on the Borrower.</li>
<li>The Borrower authorizes Antworks to access/ requisition/ download/ obtain from any or all Credit Information Bureaus his personal information/ credit report and score from time to time. Antworksis also authorized to submit the relevant information on the present Loan (including repayment/ servicing track record) to the Credit Information Bureaus and also with any other relevant forum/ information bureau to notify the indebtedness of the Borrower.</li>
<li>The Borrower authorizes Antworks to share information about him with Lender registered in the portal of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) and representatives/ consultants/ lawyers/ agents/ others engagedby Antworks for the purpose of the Loan. The Borrower authorizes Antowrks to share updated information about him from time to time with the present Lender as also prospective Lender who expresses their intention to takeover the loan from the present Lender through assignment (as described in Clause 27). The information shared with Lender/ prospective Lender may include information on the Borrower received/ obtained from third party sources whether or not verified by the Borrower.</li>
<li>The Borrower shall not use the loan for any purpose other than the purpose mentioned in this agreement.</li>
<li>The Borrower shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>
<li>The Borrower shall not use the loan for speculative purpose or for the purpose of trading in the stock market.</li>
<li>The Borrower shall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>
<li>The Borrower undertakes to maintain sufficient balance in his/ her Bank account so that the PDCs as also the DPNs can be honored on presentation by the Lender. </li>
<li>The Borrower also undertakes to maintain adequate balance in his/her bank account to honour ECS/NACH commitments</li>
<li>The Borrower hereby authorizes Antworks to collect the fees and charges as chargeable for tying-up the loan and other services provided by Antworks according to the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> from the Designated Loan Disbursement Escrow Account out of the disbursement amount. For all purposes of this Agreement the principal amount of the loan would be the gross amount including the fees and charges collected by Antworksin addition tothe amount transferred to the Borrower from the Designated Loan Disbursement Escrow Account.</li>
<li>The Borrower hereby authorizes and provides its no objection to Antworks to render any service (including towards Loan Recovery), on its own or through its representatives/ consultant/ agents/ others, as it may desire towards the Loan to the Lender(including their successors/ assigns/ heirs).It is understood and agreed by the Borrower that steps as may be deemed necessary for Recovery of Loan can be taken by the Lender, Antworks, their agents/ consultants/ representatives and/ or any person acting through or under them.</li>
<li>The Borrower shall replace any or all the PDCs and DPNs as per the advice / requirement of Antworks.</li>
<li>The Borrower has perused and agrees to abide by the RBI Master Directions as may be applicable to him for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions. In addition to above the Borrower herein shall be bound to give an undertaking as given in the Fifth Schedule hereunder</li>
<li>The Borrower further undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>
<li>The Borrower agrees to give ECS/NetBanking/NEFT/RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism mandate to his Banker (where his income is credited) for monthly transfer of the EMI amount from his Bank account to the Designated Loan Repayment Escrow Account.</li>
<li>The Borrower undertakes that so long as one or more EMI is due and payable to the Lender under this Agreement, the Borrower would first clear the dues under this Agreement from any amount (being his income or otherwise) received by the Borrower in any of his Bank account or in Cash (which would be deposited immediately in a Bank account) and transferred to the Loan Repayment Escrow Account.</li>
<li>The Borrower agrees to obtain insurance for covering the risks as may be informed by Antworks for the amount of the loan with the Lender as the loss payee and renew the same from time to time and keep it valid.</li>
<li>Shall use the Designated Loan Repayment Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<p><strong>20.	Lender' Undertaking</strong></p>
<p>The Lender hereby confirms and undertakes as follows:</p>
<ol class='definations-list'>
<li>The Lender has got himself satisfied about the creditworthiness of the Borrower through his own means and acknowledges that Antworks is a facilitator in the entire process and does not stand for any authenticity or guarantee in respect of the Borrower or the Loan.</li>
<li>The Lender unconditionally acknowledges that Antworks has no role in the receipt of EMI or the recovery of the Loan and that he shall have to recover the money by his own effort and initiatives, which shall under no circumstances be against the laws of the Country or any of the States. </li>
<li>The personal data furnished by him are true and correct at the time of submission.</li>
<li>Any change in his variable personal data like communication address, shall be intimated to the Borrower and Antworks within 7 days from such change.</li>
<li>The Lender authorizes Antworks to share information about him with Borrowers registered in the portal of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) and representatives/ consultants/ lawyers/ agents/ others engaged by Antworks for the purpose of the Loan.</li>
<li>He has granted the Loan from his own legally generated fund and has not used any fund which does not belong to him or by raising loan from some other person.</li>
<li>His total exposure to all borrower across all Peer to Peer Lending Platform is not more than INR 10,00,000/-.</li>
<li>The total amount of Loan given by him to the Borrower in all Peer to Peer Lending Platform including this Agreement does not exceed INR 50,000/-.</li>
<li>He shall forthwith, within 7 days of receiving full repayment of the loan (either on receipt of all the payments in line with the repayment schedule or through Foreclosure/ Termination as provided in this agreement), issue No Dues Certificate to the Borrower and return all the PDCs and DPN to the Borrower.</li>
<li>He shall not hold Antworks(Antworks P2P Financing Private Limited),its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, senior executives, representatives, consultants, legal and such other advisors responsible for any loss or damage that it might suffer for granting this Loan.He has granted this Loan by entering into this Agreement at his own will.</li>
<li>He shall not utilize the information received in the course of the transaction (including information on the Borrower) for any purpose other than this transaction and shall not share or disclose the information to anyone other than the parties to this transaction.</li>
<li>The Lender hereby authorizes Antworks to collect the fees and charges (Lender's Assistance Fees) from time to time,as due for the loanand other services provided by Antworks, according to the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>, from the Designated Loan Repayment Escrow Account out of the EMI amount. For all purposes of this Agreement the amount of the loan repayment would be the gross amount including the fees and charges collected by Antworksin addition tothe amount transferred to the Lender from the Designated Loan Repayment Escrow Account.</li>
<li>The Lender hereby authorizes and provides their no objection to Antworks to render any service, on its own or through its representatives/ consultants/ agents/ others, as it may desire towards the Loan to the Borrower or to other Lender including their successors/ assigns/ heirs.</li>
<li>The Lender has perused and agrees to abide by the RBI Master Directions as may be applicable to them for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions.</li>
<li>The Lender also undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>
<li>The Lender shall use the Designated Loan Disbursement Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<p><strong>21.	Lender's Special Undertaking</strong></p>
<ol class='definations-list'>
<li>The Lender acknowledges that Antworks,believes in ethical and legal business practices and does not encourage unfair, illegal, immoral, unethical means to enforce recovery of loan and thus each Lender undertakes that he shall not take any unfair, illegal, immoral, unethical means to enforce recovery of the Loan.</li>
<li>In case it is found that despite this undertaking, the Lender has taken any unfair, illegal, immoral, unethical means to enforce recovery of the Loan, then Antworksshall be at liberty to debar him from accessing <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> apart from taking appropriate legal action against the Lender and / or give necessary assistance to the investigating agency.</li>
</ol>

<p><strong>22.	Joint Covenant by the Lender and the Borrower</strong></p>
<p>The Lender and the Borrower covenants and warrant to each other that: </p>
<ol class='definations-numlist'>
<li>He/she has read all the terms and conditions, privacy policy, and other material available at <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> owned by Antworks herein.</li>
<li>They unconditionally agree to abide by the terms and conditions, privacy policy and other binding material contained on the website of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>Antworks is in no manner responsible towards either loss of money or breach of privacy or leakage of any confidential information.</li>
<li>They have not provided any information which is incorrect or materially impairs the decision of Antworksto either register him / her or permits to lend him / her through the website of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>They confirm that all types of communication between them (borrower and lender) will be/have been done online via an online platform provided by Antworksand all money transactions would be done through Bank accounts, the details of which is provided in this Agreement and as informed to and byAntworks.</li>
<li>Pay necessary fees and expenses as Antworks may decide to demand from time to time.</li>
</ol>

<p><strong>23.	Paid Prepayment:</strong></p>
<ol class='definations-list'>
<li>The Borrower can any time after the expiry of 6 months from the date of payment of his 1st EMI, pre-pay and foreclose the Loan.</li>
<li>There will be no foreclosure penalty for such foreclosure. However, the Borrower shall be liable to pay remain bound to pay all interest dues till the date of prepayment and all charges due to Antworks, as the case maybe. Prepayment penalty for foreclosure before 6 months of the due date of 1st EMI would be 5% of the loan amount.</li>
<li>The Borrower shall pay a usage service charge of Rs. 500/- for foreclosure to Antworks.</li>
</ol>

<p><strong>24.	Termination </strong></p>
<p>This Agreement shall stand terminated in the event of -</p>
<ol class='definations-list'>
<li>Complete repayment of Loan, along with interest (till the date of repayment) and other charges (as per the agreement) by the Borrower to the Lender</li>
<li>Foreclosure of Loan by the Borrower</li>
<li>In case no amount under this Agreement for Loan is disbursed by the Lenderwithin a period of " . $result['TENORMONTHS'] . " months from the date of this Agreement.</li>
<li>This Agreement becomes inoperative due to any provisions of the RBI Master Direction, subject to repayment of the borrower amount along with interest by the Borrower</li>
</ol>

<p><strong>25.	Effect of Termination</strong></p>
<ol class='definations-list'>
<li>As and when the Borrower repays of the Loan to all the Lender in accordance with the provisions of this Agreement either full tenure payment or a prepayment by way of Foreclosure, the Lender shall give him No Dues Certificates in the format given in Sixth Schedule along with returning the DPN and all the PDCs held by them hereunder and Antworks shall give him a Clearance Certificate in the format given in Seventh Schedule.</li>
<li>The relationship of the parties shall come to an end as and when such certificates are issued.</li>
<li>It is clearly understood by the parties that once the No Dues Certificate is issued by the Lender, the Borrower shall be absolved from all his duties and liabilities under this Agreement.</li>
</ol>

<p><strong>26.	Indemnification by the Lender and Borrower</strong></p>
<ol class='definations-numlist'>
<li>The Lender hereby represents and warrants that he/ she shall hold Antworks(Antworks P2P Financing Private Limited), its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, executives, representatives, consultants, legal and other advisors harmless and keep them indemnified for all time to come for any act, deeds or things that he might have done in connection with this Agreement and also shall not hold Antworks responsible for any loss or Damage suffered by him.</li>
<li>The Borrower hereby represents and warrants that he/ she shall hold Antworks (Antworks P2P Financing Private Limited), its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, executives, legal and other advisors harmless and keep them indemnified for all time to come for any act, deeds or things that he might have done in connection with this Agreement and shall not hold Antworks responsible for any loss or Damage suffered by him.</li>
</ol>

<p><strong>27.	Assignment</strong></p>
<ol class='definations-list'>
<li>The Borrower shall not assign or transfer any of its rights or obligations under this Agreement. </li>
<li>Subject to the applicable laws and the validity and enforceability of this Loan Agreement not being affected adversely in any manner, the Lender(including Assigned Lender) may at any time transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons by executing a Deed of Assignment or any other valid documents for assignment inter se, without requiring any reference to the Borrower.Any such Person(s) to which the Loan has been transferred / novated in accordance with this Section is referred to as the 'Assigned Lender(s)'.</li>
<li>The Borrower hereby gives his unconditional consent to any number of assignments as referred to above and accordingly all or any of the Lender may at any time transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons without requiring any reference to the Borrower.</li>
<li>The Assigned Lender shall, upon such assignment, as the case may be, acquire the same rights and assume the same obligations as regards the Borrower as it would have acquired and assumed had the Assigned Lender been an original party to this Agreement and shall abide by the terms, conditions and obligations of the Lender as stipulated in this Agreement.</li>
<li>The Assigned Lender would immediately intimate Antworks, Borrower and other Lender about the assignment. Upon such assignment, as the case may be, the Borrower would provide fresh PDC to the Assigned Lender and new DPN for the Loan in return of theprevious PDC and DPN of the previous Lenderassigning or novating or transferring his loan would be returned to the Borrower by him.</li>
<li>Notwithstanding anything contained herein, failure to replace the PDC and the DPN in the case of an assignment within 15 days from the date of receipt of intimation by the Borrower, the then outstanding loan amount shall become immediately payable in favour of the new Lender and the PDC and DPN provided already shall be valid for enforcement. However, the new Lender may at their sole discretion, agree to accept the PDCs and the DPN beyond the aforesaid 15 days and in which case the Loan Agreement shall continue without any further act or deed by any party.</li>
<li>Any assignment, shall not be construed as the creation of a new agreement with new obligations or rights, and the Borrower shall not be obliged to pay any person including the assigning or novating or transferring Lender and / or Assigned Lender any greater amount as a result of any such assignment or novation or transfer, as the case may be,than that which it would have been obliged to pay under this Agreement, if no such assignment or novation had taken place.</li>
</ol>
<p><strong>28.	Supersedes</strong></p>
<p>This Agreement constitutes the entire agreement between the Parties and revokes and supersedes all previous discussions/correspondences and agreements between the Parties, oral or implied.</p>

<p><strong>29.	Partial Validity</strong></p>
<p>If any provision of this Agreement or the application thereof to any circumstance shall be invalid, void or unenforceable to any extent, the remainder of this Agreement and the application of such provisions shall continue to be effective and each such provision of this Agreement shall be valid and enforceable to the fullest extent permitted by law. Notwithstanding anything contained hereinabove, if the Platform or services provided by Antworksbecomes illegal due to any legal imposition or change in law, then in such a situation the Borrower shall be liable to refund the then outstanding amount to the Lender or may enter into a separate loan agreement with the Lender and in neither case Antworks shall be responsible / liable in any manner whatsoever.</p>

<p><strong>30.	Alternative</strong></p>
<p>If any such provision is so held to be invalid, illegal or unenforceable, the Parties undertake to use their best efforts to reach a mutually acceptable alternative to give effect to such provision in a manner which is not invalid, illegal or unenforceable and to the extent feasible accurately represents the intention of the Parties.</p>

<p><strong>31.	Interpretation</strong></p>
<ol class='definations-numlist'>
<li>In these presents, where the context so requires, the singular includes the plural and vice versa; and words importing any gender include any other gender.</li>
<li>Title and headings of sections of these presents are for convenience of reference only and shall not affect the construction of any provision herein;</li>
<li>All Schedules, annexure, plans, memorandum or any other document that is attached hereto and bears the signatures and/or seals of the both the Parties hereto shall be deemed to be part of these presents.</li>
</ol>

<p><strong>32.	Waiver</strong></p>
<p>No failure or neglect of either party hereto in any instance to exercise any right, power or privilege hereunder or under law shall constitute a waiver of any other right, power or privilege or of the same right, power or privilege in any other instance. All waivers by either party hereto must be contained in a written instrument signed by the party to be charged or other person duly authorized by it. </p>

<p><strong>33.	Amendment or Modification</strong></p>
<p>Save as otherwise provided elsewhere in this Agreement, no amendment or modification of this Agreement or any part hereof shall be valid and effective unless it is by an instrument in writing executed by the Parties or their authorized representative and expressly referring to this Agreement.</p>

<p><strong>34.	Governance</strong></p>
<p>This Agreement shall be Governed by the Laws of India.</p>

<p><strong>35.	Mode of Service</strong></p>
<p>Any notice or other communication required or permitted hereunder shall be in writing and shall be addressed and delivered to in the respective address of the Parties herein as mentioned in the nomenclature clause - </p>

<p><strong>36.	Dispute Resolution</strong></p>
<p>Any dispute or claim arising from or in connection with this Agreement or breach, termination or invalidity thereof, shall be finally settled by arbitration in accordance with the Arbitration and Conciliation Act, 1996, as amended and/or enacted from time to time. The arbitration tribunal shall consist of one arbitrator, chosen by the parties in accordance with the said Act. The proceeding will be conducted in English and shall take place in Delhi. The award of the arbitrator shall be final and binding on all the Parties.</p>

<h4>IN WITNESS WHEREOF THE PARTIES HERETO HAVE EXECUTED THIS AGREEMENT FOR LOANON THE DAY MONTH AND YEAR FIRST ABOVE WRITTEN.</h4>
<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<td><span class='esign'>e-SIGN</span> <br> ".$current_time_stamp." <br>Borrower</td>
        <td>".$current_time_stamp." <br>Lender</td>
    </tr>
    <tr>
    	<td>Witness</td>
        <td>Witness</td>
    </tr>
    <tr>
    	<td>".$current_time_stamp." <br>Antworks</td>
        <td></td>
    </tr>
    <tr>
    	<td>Witness</td>
        <td>".$current_time_stamp."</td>
    </tr>
  </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FIRST SCHEDULE</h2>
<p>[Details of the Borrower]</p>
</div>

<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>SI</th>
        <th>Particulars</th>
        <th>Details</th>
    </tr>
    <tr>
    	<td>1.</td>
        <td>Name</td>
        <td>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "</td>
    </tr>
    <tr>
    	<td>2.</td>
        <td>Father's Name</td>
        <td>" . $result['BORROWERFATHERNAME'] . "</td>
    </tr>
    <tr>
    	<td>3.</td>
        <td>PAN</td>
        <td>" . $result['BORROWERR_pan'] . "</td>
    </tr>
    <tr>
    	<td>4.</td>
        <td>Aadhaar</td>
        <td>" . $result['BORROWERR_aadhaar'] . "</td>
    </tr>
    <tr>
    	<td>5.</td>
        <td>Address</td>
        <td>" . $result['BORROWERR_Address'] . " " . $result['BORROWERR_Address1'] . " " . $result['BORROWERR_City'] . " " . $result['BORROWERR_State'] . " " . $result['BORROWERR_Pincode'] . "</td>
    </tr>
    <tr>
    	<td>6.</td>
        <td>E-mail ID</td>
        <td>" . $result['BORROWEREMAIL'] . "</td>
    </tr>
    <tr>
    	<td>7.</td>
        <td>Mobile</td>
        <td>" . $result['BORROWERMOBILE'] . "</td>
    </tr>
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SECOND SCHEDULE</h2>
<p>[Details of the Lender]</p>
</div>

<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>SI</th>
        <th>Particulars</th>
        <th>Details</th>
    </tr>
    <tr>
    	<td>1.</td>
        <td>Name</td>
        <td>" . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . "</td>
    </tr>
    <tr>
    	<td>2.</td>
        <td>Father's Name</td>
        <td>" . $result['LENDER_fNAME'] . "</td>
    </tr>
    <tr>
    	<td>3.</td>
        <td>PAN</td>
        <td>" . $result['LENDER_PAN'] . "</td>
    </tr>
    <tr>
    	<td>4.</td>
        <td>Aadhaar</td>
        <td>" . $result['LENDER_PAN'] . "</td>
    </tr>
    <tr>
    	<td>5.</td>
        <td>Address</td>
        <td>" . $result['LENDER_address'] . " " . $result['LENDER_address1'] . " " . $result['LENDER_city'] . " " . $result['LENDER_state_code'] . "</td>
    </tr>
    <tr>
    	<td>6.</td>
        <td>E-mail ID</td>
        <td>" . $result['LENDER_email'] . "</td>
    </tr>
    <tr>
    	<td>7.</td>
        <td>Mobile</td>
        <td>" . $result['LENDER_mobile'] . "</td>
    </tr>
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>THIRD SCHEDULE</h2>
<p>[Format of the Amortization Schedule]</p>
</div>
<ul class='definations-numbrlist'>
<li>Loan Amount Rs.:" . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "</li>
<li>Loan Tenor " . $result['TENORMONTHS'] . "</li>
<li>Rate of Interest Per Annum " . $result['LOAN_Interest_rate'] . "%</li>
<li>Monthly Instalment (EMI) RS-" . round($emi) . "</li>
</li>
</ul>
<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>Installment Number</th>
        <th>Monthly Instalment Amount</th>
        <th>Monthly Instalment Due Date</th>
        <th>Interest Component</th>
        <th>Principal Component</th>
        <th>Balance Principal Outstanding</th>
    </tr>
    <tr>
    	<th></th>
        <th>(INR)</th>
        <th></th>
        <th>(INR)</th>
        <th>(INR)</th>
        <th>(INR)</th>
    </tr>
   " . $table . "
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FOURTH SCHEDULE</h2>
<p>DEMAND PROMISSORY NOTE</p>
</div>

<p>On demand, I, Mr./Miss/Mrs. " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . " (Hereinafter the 'Borrower') S/o/D/o/W/o, " . $result['LENDER_fNAME'] . "hereby promise to pay to
Mr./Mrs./Miss " . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . " S/o/D/o/W/o, " . $result['BORROWERFATHERNAME'] . ", (referred to as the Lender in the Loan Agreement Dated ".$current_time_stamp." inter-alia between me as Borrower and the Lender) the sum of Rs. " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "(Rupees ".$loan_amount_inword." only) in " . $result['TENORMONTHS'] . " monthly instalments, to be paid every month together with interest at the rate of " . $result['LOAN_Interest_rate'] . "% per annum, from the date of these presents, payable in any part of India for value received.</p>
<p>In the event I default in making payment hereunder in any manner whatsoever, the entire balance then remaining outstanding shall immediately become due and payable.</p>
<div>
<p class='text-left'><strong>Borrower Name & Signature</strong></p>	<p class='text-right'><strong>Date</strong></p>

</div>
<p>.........................</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FIFTH SCHEDULE</h2>
<p><strong>UNDERTAKING</strong></p>
</div>
<p>I, Sri " . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "(PAN: " . $result['BORROWERR_pan'] . "), S/o " . $result['BORROWERFATHERNAME'] . ", residing at do hereby undertake as under:</p>

<ol class='definations-numbrlist'>
	<li>THAT I have taken a Loan of an amount Rs. " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "./- (Rupees ".$loan_amount_inword.") for a tenure of " . $result['TENORMONTHS'] . ".months from Sri " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . ".by virtue of Loan Agreement No. LAN ".$loan_amount_number." dated ".$current_time_stamp."</li>
    <li>THAT in the said Agreement Sri " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . ". has been identified as the Lender and myself as Borrower and <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> as Antworks</li>
    <li>THAT the personal data furnished by me to <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> are true and correct at the time of submission</li>
    <li>THAT any change in my variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>
    <li>THAT I shall not use the loan for any purpose other than the purpose mentioned in this agreement</li>
    <li>THAT I shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>
    <li>THAT I shall not use the loan for investment purpose or for the purpose of trading in the stock market.</li>
    <li>THAT Ishall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>
<li>THAT I have read and understood all the terms and conditions of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>THAT I shall have no objection if the Lender or Antworks takes any legal action against me including lodging of PDCs/DPN, in case I fail to repay the Loan as aforesaid</li>
</ol>
<p class='text-left'><strong>Borrower Name & Signature</strong></p>	<p class='text-right'><strong>Date</strong></p>
<p>.................................</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SIXTH SCHEDULE</h2>
<p>[Format of No Dues Certificate]</p>
</div>
<p>" . $result['BORROWERR_Address'] . "<br/>
" . $result['BORROWERR_Address1'] . "<br/>
" . $result['BORROWERR_City'] . "<br/>
" . $result['BORROWERR_State'] . "<br/>
" . $result['BORROWERR_Pincode'] . "</p>

<p>Dear Sir,</p>

<p>NO DUES CERTIFICATE</p>

<p>This has reference to the Loan of Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . ".for the tenure " . $result['TENORMONTHS'] . "at the rate of interest of " . $result['LOAN_Interest_rate'] . "% taken by you ('Borrower') from me ('Lender') by virtue of a Loan Agreement vide LAN ".$loan_amount_number." dated ".$current_time_stamp." ('the Loan') through <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</p>

<p>I hereby confirm that I have received all sums payable by you to me in connection with the Loan and I have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>
<p>(.....................)</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SEVENTH SCHEDULE</h2>
<p>[Format of Clearance Certificate]</p>
</div>
<p>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "<br/>
" . $result['BORROWERR_Address'] . "<br/>
" . $result['BORROWERR_Address1'] . "<br/>
" . $result['BORROWERR_City'] . "  " . $result['BORROWERR_Pincode'] . "</strong><br/>
" . $result['BORROWERR_State'] . "</p>
<p>Dear Sir,</p>

<p><strong>Clearance Certificate</strong></p>

<p>This has reference to the Loan of Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . " for the tenure " . $result['TENORMONTHS'] . " at the rate of interest of " . $result['LOAN_Interest_rate'] . "% taken by you ('Borrower') from " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . " ('Lender') by virtue of a Loan Agreement vide LAN ".$loan_amount_number." dated ".$current_time_stamp." ('the Loan') through us <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</p>

<p>We hereby confirm that there stands no amount payable by to us by you and we have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>
<p>(..................)</p>



</div>
</body>
</html>
";
					$data['html'] = $html;


					$this->load->view('templates/cssfile', $data);
					$this->load->view('loan-aggrement-borrower', $data);
				}
			}

		}
		else{

		}
	}

	public function convert_number_to_words($number) {
		$no = round($number);
		$point = round($number - $no, 2) * 100;
		$hundred = null;
		$digits_1 = strlen($no);
		$i = 0;
		$str = array();
		$words = array('0' => '', '1' => 'one', '2' => 'two',
			'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			'7' => 'seven', '8' => 'eight', '9' => 'nine',
			'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			'13' => 'thirteen', '14' => 'fourteen',
			'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			'60' => 'sixty', '70' => 'seventy',
			'80' => 'eighty', '90' => 'ninety');
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_1) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += ($divider == 10) ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			} else $str[] = null;
		}
		$str = array_reverse($str);
		$result = implode('', $str);
		$points = ($point) ?
			"." . $words[$point / 10] . " " .
			$words[$point = $point % 10] : '';
		$dd="";
		if($points)
		{
			$dd = $points . " Paise";
		}
		return $result . " " . $dd;
	}

	public function showcase()
	{
		if ($this->session->userdata('login_state') == TRUE) {
			if ($this->session->userdata('role') == 16) {
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				$this->load->view('templates-admin/header', $data);
				$this->load->view('templates-admin/nav', $data);
				$this->load->view('templates-admin/header-below', $data);
				$this->load->view('showcase', $data);
				$this->load->view('templates-admin/footer');
			}

		}
	}

	public function loan_aggrement()
	{
		//error_reporting(0);
		//echo  $today  = date('d/m/Y');
		if(!empty($_POST['proposal_id'])) {
			$proposal_id = $_POST['proposal_id'];
			//error_reporting(0);
			require_once APPPATH . "/third_party/mpdf/vendor/autoload.php";
			$sql = "SELECT
					BDT.first_name AS BORROWERNAME,
					BDT.middle_name AS BORROWERMIDDLENAME,
					BDT.last_name AS BORROWERLASTNAME,
					BDT.father_name AS BORROWERFATHERNAME,
					BDT.email AS BORROWEREMAIL,
					BDT.mobile AS BORROWERMOBILE,
					BDT.dob AS BORROWERDOB,
					BDT.r_address AS BORROWERR_Address,
					BDT.r_address1 AS BORROWERR_Address1,
					BDT.r_city AS BORROWERR_City,
					BDT.r_state AS BORROWERR_State,
					BDT.r_pincode AS BORROWERR_Pincode,
					BDT.pan AS BORROWERR_pan,
					BDT.aadhaar AS BORROWERR_aadhaar,
					BDT.gender AS BORROWERR_gender,

					UI.user_id AS user_id_lender,
					UI.first_name AS LENDER_fNAME,
					UI.middle_name AS LENDER_middle_name,
					UI.last_name AS LENDER_last_name,
					UI.dob AS LENDER_dob,
					UI.state_code AS LENDER_state_code,
					UI.city AS LENDER_city,
					UI.address AS LENDER_address,
					UI.address1 AS LENDER_address1,
					LDT.pan AS LENDER_PAN,
					LDT.lender_id AS LENDER_ID,
					UI.email AS LENDER_email,
					UI.mobile AS LENDER_mobile,

					PD.loan_amount AS LOANAMOUNT,
					PD.loan_description AS Loan_Description,
					PD.PLRN AS PLRN,
					PD.borrower_id AS BORROWER_ID,
					PD.tenor_months AS TENORMONTHS,
					BPD.interest_rate AS LOAN_Interest_rate,
					BPD.lenders_id AS LOAN_lenders_id,
					BPD.bid_registration_id AS bid_registration_id,
					ABD.approved_loan_amount AS APPROVERD_LOAN_AMOUNT,
					ABD.loan_account_number AS LoanAccountNumber,
					ABD.bid_approve_id AS bid_approve_id
					FROM bidding_proposal_details BPD
					LEFT JOIN approved_bidding_details ABD
					ON ABD.bid_registration_id=BPD.bid_registration_id
					LEFT JOIN proposal_details PD
					ON PD.proposal_id=BPD.proposal_id
					LEFT JOIN borrowers_details_table AS BDT
					ON BDT.borrower_id = BPD.borrowers_id
					LEFT JOIN lenders_details_table AS LDT
					ON LDT.user_id = BPD.lenders_id
					LEFT JOIN user_info AS UI
					ON UI.user_id = BPD.lenders_id
					LEFT JOIN borrower_loan_aggrement AS BLA
					ON BLA.bid_registration_id = BPD.bid_registration_id
					WHERE BPD.bid_registration_id='$proposal_id' AND ABD.bid_registration_id IS NOT NULL AND BLA.bid_registration_id IS NULL
			";
			$query = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) {
				$res = $query->result_array();
				$table = "";
				$today = date("l-m-Y");
				$current_time_stamp = $date = date('d/m/Y H:i:s', time());
				foreach ($res AS $result) {
					if($result['LoanAccountNumber'] == "") {
						$this->db->select("loan_account_number");
						$this->db->order_by('loan_account_number', 'DESC');
						$this->db->limit(1);
						$query = $this->db->get('approved_bidding_details');
						$row = (array)$query->row();

						if ($this->db->affected_rows() > 0) {

							$lan = $row['loan_account_number'];
							$lan++;
							$loan_amount_number = $lan;
						} else {
							$loan_amount_number = "LAN1000001";
						}
						$this->db->set('loan_account_number', $loan_amount_number);
						$this->db->where('bid_approve_id', $result['bid_approve_id']);
						$this->db->update('approved_bidding_details');
					}
					else{
						$loan_amount_number = $result['LoanAccountNumber'];
					}
					$loan_amount = $result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT'] / 100;
					$loan_amount_inword = $this->convert_number_to_words($loan_amount);
					$loan_interest_rate = $result['LOAN_Interest_rate'];
					$loan_tenor = $result['TENORMONTHS'];
					$loan_time = $loan_tenor / 12;
					$loan_ir = $loan_interest_rate;
					$numerator = $loan_amount * pow((1 + $loan_ir / (12 * 100)), $loan_time * 12);
					$denominator = 100 * 12 * (pow((1 + $loan_ir / (12 * 100)), $loan_time * 12) - 1) / $loan_ir;
					$emi = ($numerator / $denominator);
					$table = "";
					for ($i = 1; $i <= $loan_tenor; $i++) {

						if ($i == 1) {
							$emi_sn[$i] = "Month " . $i;
							$emi_interest[$i] = ($loan_amount * $loan_interest_rate / 1200);
							$emi_principal[$i] = $emi - $emi_interest[$i];
							$emi_balance[$i] = $loan_amount - $emi_principal[$i];
						} else if ($i < 37) {
							$emi_sn[$i] = "Month " . $i;
							$emi_interest[$i] = ($emi_balance[$i - 1] * $loan_interest_rate / 1200);
							$emi_principal[$i] = $emi - $emi_interest[$i];
							$emi_balance[$i] = $emi_balance[$i - 1] - $emi_principal[$i];
						} else if ($i >= 37) {
							break;
						}
						$day = date('j');
						if($day>=8)
						{

							$date = date('07-F-Y', strtotime('+'.$i.' month'));
						}
						else{
							if($i==1)
							{
								$date = date('07-F-Y');
							}
							else{
								$date = date('07-F-Y', strtotime('+'.$i.' month'));
							}

						}
						$table .= "<tr><td>" . $emi_sn[$i] . "</td>" . "<td>" . round($emi) . "</td>" . "<td>".$date."</td>" . "<td>" . round($emi_interest[$i]) . "</td>" . "<td>" . round($emi_principal[$i]) . "</td>" . "<td>" . round($emi_balance[$i]) . "</td></tr>";
                        $emi_arr = array(
							'loan_id'=>$result['bid_registration_id'],
							'borrower_id'=>$result['BORROWER_ID'],
							'lender_id '=>$result['user_id_lender'],
							'emi_date'=>$date,
							'emi_amount'=>round($emi),
							'emi_interest'=>round($emi_interest[$i]),
							'emi_principal'=>round($emi_principal[$i]),
							'emi_balance'=>round($emi_balance[$i]),
							'status '=>0,
						);
						$this->db->insert('borrower_emi_details',$emi_arr);
					}

					$html = "<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
<title>P2P Antworks Finance</title>
</head>
<body>
<section>
<div class='container'>
<div class='row'>
  <div class='welcome'>
    <p class='text-right'>LAN: AW ".$loan_amount_number."</p>
    <div class='text-center'>
    <p>Between</p>
    <p>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "</p>
    <p>['The Borrower']</p>
    <p>and</p>
    <p>" . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . "</p>
    <p>['Lender']</p>
    <p>and</p>
    <h2 class='agrmnt-hd'>ANTWORKS P2P FINANCING PRIVATE LIMITED</h2>
    <p>['Antworks']</p>
      </div>
  </div>
</div>
</div>
</section>
<div class='container'>
	<h3 class='agrmnt-hd text-center'>LOAN AGREEMENT</h3>
    <p>THIS AGREEMENT for Loan dated " . $today . "</p>
    <p>BETWEEN</p>

<p>Mr. / Ms. ". $result['BORROWERNAME']." " . $result['BORROWERMIDDLENAME']." " . $result['BORROWERLASTNAME'] . " s/o / w/o " . $result['BORROWERFATHERNAME'] . " Residing at " . $result['BORROWERR_Address'] . " " . $result['BORROWERR_Address1'] . " " . $result['BORROWERR_City'] . " " . $result['BORROWERR_State'] . " " . $result['BORROWERR_Pincode'] . " having PAN  " . $result['BORROWERR_pan'] . ", hereinafter referred to as 'the Borrower' and as more fully described in First Schedule hereunder(which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and heirs) of the First Part</p>

<p>AND</p>

<p>Mr. / Ms. ". $result['LENDER_fNAME']." " . $result['LENDER_middle_name']." " . $result['LENDER_last_name'] . "s/o / w/o " . $result['LENDER_fNAME'] . ". Residing at " . $result['LENDER_address'] . " " . $result['LENDER_address1'] . " " . $result['LENDER_city'] . " " . $result['LENDER_state_code'] . " having PAN  " . $result['LENDER_PAN'] . ", hereinafter referred to as'the Lender' and as more fully described in First Schedule hereunder(which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors, assigns and heirs) of the Second Part</p>

<p>AND</p>

<p>ANTWORKS P2P Financing Private Limited, CIN U65999HR2017PTC071580 having its Registered Office at UL-03, Eros EF3 Mal, Sector-20 A, Mathura Road, Faridabad,121001, Haryana, having PAN AAQCA2578Q, hereinafter referred to as 'Antworks' (which expression shall unless it be repugnant to the context or meaning thereof be deemed to mean and include its successors and assigns) of the Third Part</p>

<p>WHEREAS Antworks runs an online portal <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>  which is a 'Peer to Peer Lending Platform' as defined under Direction 4 (1) (v) of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</p>
<p>AND WHEREAS <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>, subject to the provisions of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017is an open to all platform wherein borrowers and lenders can freely choose each other based on their choice of parameters like profile of counter-party, tenure, rate of interest, repayment mode, quantum of loan etc. thereby creating a competitive atmosphere for the debt market.</p>
<p>AND WHEREAS the Borrower, being in need of money, have registered it in the portal <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> and had raised some request for a loan by filling up of necessary forms with the portal.</p>
<p>AND WHEREAS the Lender, having certain surplus funds was willing to deploy them as debt and accordingly registered himself with <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> as a lender.</p>
<p>AND WHEREAS the Lender and the Borrower coming to know their mutual requirements conducted their respective diligence and finally decided to grant and accept respectively a loan amounting to Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . ".</p>
<p>AND WHEREAS Antworks will act as a facilitator in the entire process of Loan starting from the disbursement and ending with the recovery of the Loan.It is also clearly understood and agreed by both Borrower and Lender that Antworks is a party to this agreement without any obligation or liability to either Lender or Borrower or anyone claiming or acting through them.</p>
<p>NOW THEREFORE, in consideration of the mutual covenants as set forth below, and based on the various representations and warranties of the Parties as herein made the Parties hereby agree to enter into the present Agreement on the terms and conditions as set out herein.</p>
<p><strong>1. Definitions</strong>:</p>
<ol class='definations-list'>
<li><strong>Assistance Fee</strong> shall have the meaning as described in Clause 10 hereunder.</li>
<li><strong>Designated Date</strong> shall mean the date on which the EMI falls due as depicted in 3rd Schedule hereunder.</li>
<li><strong>Designated Loan Disbursement Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Lender would transfer the Principal Loan Amountfor being disbursed to the Borrower at the instance of Antworks.</li>
<li><strong>Designated Loan Repayment Escrow Account</strong> shall mean the Escrow Account opened with IDBI Bank by whatever name called where the Borrower shall deposit the EMI amount for being transferred to the Lender at their respective personal account at the instance of Antworks.</li>
<li><strong>EMI</strong> shall meanthe amountto be paid by the Borrower for servicing / repayment of the Loan (ie. principal and interest) as more fully described in Clause 11,hereunder</li>
<li><strong>Escrow Bank</strong> shall be IDBI Bank</li>
<li><strong>Loan Disbursement Date</strong> for the purpose of this Agreement shall mean the date on which the Principal Loan amount, as reduced by the Borrower'sAssistance Fee payable to Antworks, is credited to the Bank Account of the Borrower and which date shall be treated as the date from which Interest will be payable by the Borrower to the Lender.</li>
<li><strong>Loan Transaction</strong> for the purpose of this Agreement shall mean the amountof Loan granted by the Lender to the Borrower.</li>
<li><strong>'Peer to Peer Lending Platform'</strong> shall have the same meaning as defined under Direction 4 (1) (v) of the Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</li>
<li><strong>Penal Interest</strong> for the purpose of this Agreement shall mean the rate of interest per annum payable by the Borrower for any failure to pay any EMI on due date (.ie. designated date on which it is due for payment) in addition to the rate of interest of the loanfor the period of delay till repayment of the entire overdue EMI amount.</li>
<li><strong>Principal Loan Amount / PLA</strong> for the purpose of this agreement shall mean the amount of the loans granted by the Lender to the Borrower.</li>
<li><strong>RBI Master Directions :</strong>For the purpose of this Agreement RBI Directions shall mean <strong>Non Banking Financial Company - Peer to Peer Lending Platform (Reserve Bank) Directions, 2017</strong> as amended from time to time.</li>
</ol>
<p><strong>2.	Purpose of Agreement</strong></p>
<p>The purpose of this Agreement is to record in writing the terms and conditions of the Loan Transaction</p>
<p><strong>3.	Loan Granted and Accepted</strong></p>
<p>The Lender, upon getting himself satisfied about the creditworthiness of the Borrower through his own means hereby grants to the Borrower the Loan on the terms and conditions contained herein and the Borrower upon getting himself satisfied about the source of fund of the Lender through his own means hereby accepts the grant of Loan made by the Lender.</p>

<p><strong>4.	Principal Loan Amount</strong></p>
<p>The principal amount of Loan covered under this Agreement is Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "</p>

<p><strong>5.	Purpose of Loan</strong></p>
<p>The Borrower has declared that he is taking the loan for " . $result['Loan_Description'] . ".</p>

<p><strong>6.	Effective Date</strong></p>
<p>This Loan Agreement shall be effective from the date of Signing of this Agreement. However, the interest on the Loan would accrue from the Loan Disbursement Date.</p>

<p><strong>7.	Tenure of the Loan</strong></p>
<p>The tenure of the Loan shall be " . $result['TENORMONTHS'] . " months</p>

<p><strong>8.	Rate of Interest</strong></p>
<p>The Loan shall be subject to an interest @" . $result['LOAN_Interest_rate'] . "% p.a.</p>

<p><strong>9.	Loan Disbursement Mechanism</strong></p>
<ol class='definations-list'>
<li>Upon the matching of the requirement of the Borrower with the Lender, the Lendershall transfer respective amount of the Loan to the Designated Loan Disbursement Escrow Account</li>
<li>Thereupon, Antworks would inform the Trustee to instruct the Escrow Bank for transfer of the Principal Loan Amount,after deducting therefrom the Loan Processing Fees payable to Antworks,to the Borrower from the Designated Loan Disbursement Escrow Account preferably by the immediately succeeding working day after the Lenderhas transferred his loan amount in the Designated Loan Disbursement Escrow Account.</li>
</ol>

<p><strong>10.	Assistance Fee </strong></p>

<p>A. <span class='def-sublist'>Borrower's Assistance Fee:</span></p>
<ol class='definations-list'>
<li>For providing the Peer to Peer Lending Platform and providing incidental services like monitoring the disbursements,Antworksshall be entitled to an Assistance Fees to be known as Borrower's Assistance Fees, atthe rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> payable by the Borrower availing the services.</li>
<li>The Borrower's Assistance Fee (payable by the Borrower)can be recovered by Antworksfrom the Principal Loan Amount before the disbursement. The Borrower shall be liable to repay the Principal Loan Amount to the Lender and interest thereupon.The Borrower conveys to the Trustee his unconditional consent in favour of Antworks to deduct the Borrower's Assistance Fee from the Principal Loan Amount and undertakes not to contest or initiate any legal proceedings for such deduction, under any circumstances.</li>
</ol>
<p>B. <span class='def-sublist'>Lender's Assistance Fee:</span></p>
<ol class='definations-list'>
<li>For providing the Peer to Peer Lending Platform and providing incidental services like monitoring the disbursements and repayments,Antworks shall be entitled to periodical Assistance Fees to be known as Lender's Assistance Fees, at the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> payable by the Lender granting the loan .<br>
The Lender'sAssistance Fee payable by the Lendershall be paid immediately as and when charged by Antworks (in line with the rate and schedule provided in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) by way of online transfer to the Bank account of Antworks.</li>
<li>The Lender's Assistance Fee (payable by the Lender)can be recovered by Antworksfrom the EMIamount from time to time as and when due. The Lender shall be construed to have received the entire EMI against the Loan regardless of the Lender's Assistance Fee collected by Antworks from the EMI. The Lender conveys to the Trustee his unconditional consent in favour of Antworks to deduct the Lender's Assistance Fee from the EMI Amount and undertakes not to contest or initiate any legal proceedings for such deduction, under any circumstances.</li>
</ol>
<p><strong>11.	Payment of Interest and Repayment of Principal Loan Amount by way of EMI</strong></p>
<ol class='definations-numlist'>
<li>The Borrower shall pay the interest along with the principal by way of predetermined monthly installment (EMI) to the Lenderas per an Amortization Schedule, to be shared separately with the Parties herein and shall form an integral part of this Agreement, in the format depicted in the ThirdSchedulehereunder.</li>
<li>The 1st EMI shall be paid by the Borrower to the Lender on the 15th day of the month immediately subsequent to the month in which the loan has been first disbursed by the Lender to the Borrower. The first EMI would be adjusted by the broken period interest; i.e. if the Loan Disbursement Date of the loan is prior to 15th of any calendar month, the first EMI would be incremented by simple interest (at the Rate of Interest as in Clause 8 hereinabove) for number of days till 15th and conversely if the Loan Disbursement Date is after 15th, the first EMI would be reduced by simple interest (at the Rate of Interest as in clause 8 above) for the number of days past 15th. </li>
<li>The Borrower shall pay the Applicable EMI by way of ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism favoring the Designated Loan Repayment Escrow Account</li>
<li>Antworks would inform the Trustee to instruct the Escrow Bank for transfer of EMI amount deposited by the Borrower in Designated Loan Repayment Escrow Account to the Lender preferably by the immediately succeeding working day, after deducting therefrom the Lender' Assistance fee wherever applicable.</li>
<li>The payment of EMI through ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism shall be prefixed (as per an Amortization Schedule depicted inThird Schedule) and will remain unchanged (except the first EMI) throughout the Tenure of Loan availed unless otherwise agreed upon by all the parties to this agreement. </li>
<li>Any amount paid by the Borrower in any account of the Lender other than the Designated Loan Repayment Escrow Account shall not be treated as an EMI for the purpose of this Agreement and such payment shall not be treated as a payment towards the Loan.</li>
</ol>
<p><strong>12.	Payment Assurance</strong></p>
<ol class='definations-list'>
<li>In order to assure the payment of the Lender, the Borrower shall have to furnish Cheques(PDC) as follows:</li>
<ol class='definations-numlist'>
<li>1 PDC for the amountof Loan of the Lender</li>
<li>5 PDCs for 5 EMIs.</li>
</ol>
<li>In addition to above the Borrower shall also furnish Demand Promissory Note ('DPN') as set out in the Fourth Schedule hereunder.</li>
</ol>
<p><strong>13.	Changes in Designated Loan Repayment Escrow Account</strong></p>
<p>During the Tenure of the Agreement Antworks may change the Designated Loan Repayment Escrow Account after serving a written notice of 30 days to the Borrower and the Lender. Upon the expiry of the said period of 30 days the new account shall be treated as the Designated Loan Repayment Escrow Account for the purpose of this agreement and accordingly the Borrower shall make the EMI payment through ECS/NetBanking/NEFT/ RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanismto such Designated Loan Repayment Escrow Account.</p>
<p><strong>14.	Delayed Payment of EMI and Penal Interest</strong></p>
<ol class='definations-list'>
<li>The Borrower shall not fail to pay his EMI in any month. However, in the event of unforeseen circumstances, if the borrower fails to pay any EMI in a particular month on the due date (ie. designated date on which it is due for payment) then it shall be treated as a non-payment of EMI (overdue EMI) and shall be subject to the Penal Interest.</li>
<li>Penal Interest referred to above shall be calculated @" . $result['LOAN_Interest_rate'] . "% per annum (in addition to the rate of interest of the loan) for the period of delay till repayment of the entire overdue EMI amount. In case only the preceding EMI is overdue, the Penal Interest would be calculated on the overdue amount. In case more than one EMI is overdue, the Penal Interest would be calculated on the total outstanding loan amount.</li>
<li>The Borrower shall regularize the non-payment of any EMI by paying the overdue EMI amount along with the applicable Penal Interest on or before the immediately succeeding EMI date. </li>
<li>Payment of Penal Interest does not absolve the Borrower from consequences of default and remedies available to the Lender under this Loan Agreement.</li>
<li>Any payment made by the Borrower on a date immediately upon failure of the EMI payment shall be, first adjusted against the Penal Interest, then by the EMI overdue and last by the current EMI.</li>
</ol>
<p><strong>15.	Events of Default:</strong></p>
<p>The following shall constitute Events of Default</p>
<ol class='definations-numlist'>
<li>Any representations or statements or particulars made in the Borrower's registration, proposal, submissions, application or updated information are found to be incorrect;</li>
<li>the Borrower commits any breach of any term set out in this Agreement;</li>
<li>the Borrower fails to repay to the Lender any two consecutive instalments (EMI) of the loan amount on the due dates i.e. designated dates on which they are due for payment; </li>
<li>If any attachment, distress execution or any other such process is initiated against the Borrower; </li>
<li>If the Borrower ceases or threatens to cease to carry on its present income earning activity, business or profession; </li>
<li>If the Borrower makes any compromise or settlement with any of his/ her creditor for any payment of dues to such creditor; </li>
<li>If any action for bankruptcy or insolvency is filed against the Borrower and/ or the Borrower is undergoing Fresh Start process.</li>
</ol>

<p><strong>16.	Curing of Default </strong></p>
<ol class='definations-list'>
<li>The Borrower shall be allowed to cure, wherever practicable, a Default within 15 days of happening of the Event of Default.</li>
<li>The Borrower has procured a specific written waiver and/ or extended time to cure the Event of Default, communicated by the Lender in respect of any Event of Default.</li>
</ol>

<p><strong>17.	Consequences of Default </strong></p>
<p>If the Borrower fails to cure any Event of Default the Lender, in addition to the rights available under normal course of law:</p>
<ol class='definations-list'>
<li>may call upon the Borrower to pay immediately the entire outstanding Principal amount along with the unpaid Interest and Penal Interest (if any, accrued till the date of such payment);</li>
<li>may enforce the DPN and /or ask Antworks to lodge the PDC, at his discretion;</li>
<li>mayinitiate proceedings under Chapter III of the Insolvency and Bankruptcy Code, 2016 and / or such other remedy by virtue of any other security, statute or rule of law, as may be applicable.</li>
</ol>

<p><strong>18.	Role of Antworks</strong></p>
<p>Antworks would perform the following roles against payment of fees for the respective services as disclosed in its website from time to time.</p>
<ol class='definations-list'>
<li>Co-ordination among the parties for sharing of information and communication, as set out in this agreement and as provided in the website of Antworks from time to time.</li>
<li>Antworks may at its option provide other services, as it may deem fit, for the purpose of grant of the loan by the Lender to the Borrower and repayment of the loan by the Borrower to the Lender.All the parties to the transaction provide their consent for Antworks to perform any such roles or to provide any such services as Antworks may deem fit. Borrower and Lender agree to pay fees to Antworks for the services (as availed by them) according to the rates as specified in the website of Antowrksie. <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>Antworks may also provide the services of taking steps towards recovery of debt from the Borrower in case of default including coordinating and initiating proceedings including legal measures against the Borrower. The Lender hereby authorize the Antworks for such acts and deeds as may be necessary. The Lender hereby agree to pay such fees as disclosed in the website of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) for the services, as also pay the fees of any consultant, agent or lawyer engaged by Antworksand reimburse the expenses incurred for the same purpose. The Borrower hereby provides no objection to the Antworks,including any consultant, agent or lawyer engaged by Antowrks, to carry out all such deeds and acts as may be necessary for the purpose of the Loan.</li>
</ol>

<p><strong>19.	Borrower's Undertaking</strong></p>
<p>The Borrower hereby undertakes as follows:</p>
<ol class='definations-list'>
<li>That the Aggregate of the loan taken by the Borrower across all Peer to Peer Lending Platform is not more than INR 10,00,000/-.</li>
<li>That the Borrower has got himself satisfied about the source of fund of the Lender through his own means and acknowledges that Antworks is a facilitator in the entire process and does not stand for any authenticity or guarantee in respect of the Leander or the Loan;</li>
<li>The personal data and all information furnished by him are true and correct at the time of submission.</li>
<li>Any change in his variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>
<li>The Borrower shall, on an annual basis, furnish/ updated information as submitted to the Antowrks website (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>), including Bank statements of all his Bank accounts, information on his income for the immediately preceding financial year, present monthly income, copy of latest Income Tax Return, other Borrowings and payment obligations etc.</li>
<li>The Borrower authorizes Antworks to carry out such Due Diligence on him as it may deem necessary including tracking his activities in the social media or any other forum, accessing information about him as available with any information repository. Antowrks is also authorized to engage any third party for the purpose of collecting/ collating and/ or verification of information on the Borrower.</li>
<li>The Borrower authorizes Antworks to access/ requisition/ download/ obtain from any or all Credit Information Bureaus his personal information/ credit report and score from time to time. Antworksis also authorized to submit the relevant information on the present Loan (including repayment/ servicing track record) to the Credit Information Bureaus and also with any other relevant forum/ information bureau to notify the indebtedness of the Borrower.</li>
<li>The Borrower authorizes Antworks to share information about him with Lender registered in the portal of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) and representatives/ consultants/ lawyers/ agents/ others engagedby Antworks for the purpose of the Loan. The Borrower authorizes Antowrks to share updated information about him from time to time with the present Lender as also prospective Lender who expresses their intention to takeover the loan from the present Lender through assignment (as described in Clause 27). The information shared with Lender/ prospective Lender may include information on the Borrower received/ obtained from third party sources whether or not verified by the Borrower.</li>
<li>The Borrower shall not use the loan for any purpose other than the purpose mentioned in this agreement.</li>
<li>The Borrower shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>
<li>The Borrower shall not use the loan for speculative purpose or for the purpose of trading in the stock market.</li>
<li>The Borrower shall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>
<li>The Borrower undertakes to maintain sufficient balance in his/ her Bank account so that the PDCs as also the DPNs can be honored on presentation by the Lender. </li>
<li>The Borrower also undertakes to maintain adequate balance in his/her bank account to honour ECS/NACH commitments</li>
<li>The Borrower hereby authorizes Antworks to collect the fees and charges as chargeable for tying-up the loan and other services provided by Antworks according to the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> from the Designated Loan Disbursement Escrow Account out of the disbursement amount. For all purposes of this Agreement the principal amount of the loan would be the gross amount including the fees and charges collected by Antworksin addition tothe amount transferred to the Borrower from the Designated Loan Disbursement Escrow Account.</li>
<li>The Borrower hereby authorizes and provides its no objection to Antworks to render any service (including towards Loan Recovery), on its own or through its representatives/ consultant/ agents/ others, as it may desire towards the Loan to the Lender(including their successors/ assigns/ heirs).It is understood and agreed by the Borrower that steps as may be deemed necessary for Recovery of Loan can be taken by the Lender, Antworks, their agents/ consultants/ representatives and/ or any person acting through or under them.</li>
<li>The Borrower shall replace any or all the PDCs and DPNs as per the advice / requirement of Antworks.</li>
<li>The Borrower has perused and agrees to abide by the RBI Master Directions as may be applicable to him for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions. In addition to above the Borrower herein shall be bound to give an undertaking as given in the Fifth Schedule hereunder</li>
<li>The Borrower further undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>
<li>The Borrower agrees to give ECS/NetBanking/NEFT/RTGS/IMPS/UPI/NACH or any other similar electronic funds transfer mechanism mandate to his Banker (where his income is credited) for monthly transfer of the EMI amount from his Bank account to the Designated Loan Repayment Escrow Account.</li>
<li>The Borrower undertakes that so long as one or more EMI is due and payable to the Lender under this Agreement, the Borrower would first clear the dues under this Agreement from any amount (being his income or otherwise) received by the Borrower in any of his Bank account or in Cash (which would be deposited immediately in a Bank account) and transferred to the Loan Repayment Escrow Account.</li>
<li>The Borrower agrees to obtain insurance for covering the risks as may be informed by Antworks for the amount of the loan with the Lender as the loss payee and renew the same from time to time and keep it valid.</li>
<li>Shall use the Designated Loan Repayment Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<p><strong>20.	Lender' Undertaking</strong></p>
<p>The Lender hereby confirms and undertakes as follows:</p>
<ol class='definations-list'>
<li>The Lender has got himself satisfied about the creditworthiness of the Borrower through his own means and acknowledges that Antworks is a facilitator in the entire process and does not stand for any authenticity or guarantee in respect of the Borrower or the Loan.</li>
<li>The Lender unconditionally acknowledges that Antworks has no role in the receipt of EMI or the recovery of the Loan and that he shall have to recover the money by his own effort and initiatives, which shall under no circumstances be against the laws of the Country or any of the States. </li>
<li>The personal data furnished by him are true and correct at the time of submission.</li>
<li>Any change in his variable personal data like communication address, shall be intimated to the Borrower and Antworks within 7 days from such change.</li>
<li>The Lender authorizes Antworks to share information about him with Borrowers registered in the portal of Antworks (<a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>) and representatives/ consultants/ lawyers/ agents/ others engaged by Antworks for the purpose of the Loan.</li>
<li>He has granted the Loan from his own legally generated fund and has not used any fund which does not belong to him or by raising loan from some other person.</li>
<li>His total exposure to all borrower across all Peer to Peer Lending Platform is not more than INR 10,00,000/-.</li>
<li>The total amount of Loan given by him to the Borrower in all Peer to Peer Lending Platform including this Agreement does not exceed INR 50,000/-.</li>
<li>He shall forthwith, within 7 days of receiving full repayment of the loan (either on receipt of all the payments in line with the repayment schedule or through Foreclosure/ Termination as provided in this agreement), issue No Dues Certificate to the Borrower and return all the PDCs and DPN to the Borrower.</li>
<li>He shall not hold Antworks(Antworks P2P Financing Private Limited),its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, senior executives, representatives, consultants, legal and such other advisors responsible for any loss or damage that it might suffer for granting this Loan.He has granted this Loan by entering into this Agreement at his own will.</li>
<li>He shall not utilize the information received in the course of the transaction (including information on the Borrower) for any purpose other than this transaction and shall not share or disclose the information to anyone other than the parties to this transaction.</li>
<li>The Lender hereby authorizes Antworks to collect the fees and charges (Lender's Assistance Fees) from time to time,as due for the loanand other services provided by Antworks, according to the rate as specified in the website <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>, from the Designated Loan Repayment Escrow Account out of the EMI amount. For all purposes of this Agreement the amount of the loan repayment would be the gross amount including the fees and charges collected by Antworksin addition tothe amount transferred to the Lender from the Designated Loan Repayment Escrow Account.</li>
<li>The Lender hereby authorizes and provides their no objection to Antworks to render any service, on its own or through its representatives/ consultants/ agents/ others, as it may desire towards the Loan to the Borrower or to other Lender including their successors/ assigns/ heirs.</li>
<li>The Lender has perused and agrees to abide by the RBI Master Directions as may be applicable to them for all time to come and thus shall take necessary steps to comply with the requirement of the RBI Master Directions.</li>
<li>The Lender also undertakes to sign such other documents / NOC as may be required by Antworks for ensuring compliance with the RBI Master Directions or any other business necessity.</li>
<li>The Lender shall use the Designated Loan Disbursement Escrow Account as per the requirement of Antworks and decision of Antworks in this regard shall be final.</li>
</ol>

<p><strong>21.	Lender's Special Undertaking</strong></p>
<ol class='definations-list'>
<li>The Lender acknowledges that Antworks,believes in ethical and legal business practices and does not encourage unfair, illegal, immoral, unethical means to enforce recovery of loan and thus each Lender undertakes that he shall not take any unfair, illegal, immoral, unethical means to enforce recovery of the Loan.</li>
<li>In case it is found that despite this undertaking, the Lender has taken any unfair, illegal, immoral, unethical means to enforce recovery of the Loan, then Antworksshall be at liberty to debar him from accessing <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> apart from taking appropriate legal action against the Lender and / or give necessary assistance to the investigating agency.</li>
</ol>

<p><strong>22.	Joint Covenant by the Lender and the Borrower</strong></p>
<p>The Lender and the Borrower covenants and warrant to each other that: </p>
<ol class='definations-numlist'>
<li>He/she has read all the terms and conditions, privacy policy, and other material available at <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> owned by Antworks herein.</li>
<li>They unconditionally agree to abide by the terms and conditions, privacy policy and other binding material contained on the website of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>Antworks is in no manner responsible towards either loss of money or breach of privacy or leakage of any confidential information.</li>
<li>They have not provided any information which is incorrect or materially impairs the decision of Antworksto either register him / her or permits to lend him / her through the website of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>They confirm that all types of communication between them (borrower and lender) will be/have been done online via an online platform provided by Antworksand all money transactions would be done through Bank accounts, the details of which is provided in this Agreement and as informed to and byAntworks.</li>
<li>Pay necessary fees and expenses as Antworks may decide to demand from time to time.</li>
</ol>

<p><strong>23.	Paid Prepayment:</strong></p>
<ol class='definations-list'>
<li>The Borrower can any time after the expiry of 6 months from the date of payment of his 1st EMI, pre-pay and foreclose the Loan.</li>
<li>There will be no foreclosure penalty for such foreclosure. However, the Borrower shall be liable to pay remain bound to pay all interest dues till the date of prepayment and all charges due to Antworks, as the case maybe. Prepayment penalty for foreclosure before 6 months of the due date of 1st EMI would be 5% of the loan amount.</li>
<li>The Borrower shall pay a usage service charge of Rs. 500/- for foreclosure to Antworks.</li>
</ol>

<p><strong>24.	Termination </strong></p>
<p>This Agreement shall stand terminated in the event of -</p>
<ol class='definations-list'>
<li>Complete repayment of Loan, along with interest (till the date of repayment) and other charges (as per the agreement) by the Borrower to the Lender</li>
<li>Foreclosure of Loan by the Borrower</li>
<li>In case no amount under this Agreement for Loan is disbursed by the Lenderwithin a period of " . $result['TENORMONTHS'] . " months from the date of this Agreement.</li>
<li>This Agreement becomes inoperative due to any provisions of the RBI Master Direction, subject to repayment of the borrower amount along with interest by the Borrower</li>
</ol>

<p><strong>25.	Effect of Termination</strong></p>
<ol class='definations-list'>
<li>As and when the Borrower repays of the Loan to all the Lender in accordance with the provisions of this Agreement either full tenure payment or a prepayment by way of Foreclosure, the Lender shall give him No Dues Certificates in the format given in Sixth Schedule along with returning the DPN and all the PDCs held by them hereunder and Antworks shall give him a Clearance Certificate in the format given in Seventh Schedule.</li>
<li>The relationship of the parties shall come to an end as and when such certificates are issued.</li>
<li>It is clearly understood by the parties that once the No Dues Certificate is issued by the Lender, the Borrower shall be absolved from all his duties and liabilities under this Agreement.</li>
</ol>

<p><strong>26.	Indemnification by the Lender and Borrower</strong></p>
<ol class='definations-numlist'>
<li>The Lender hereby represents and warrants that he/ she shall hold Antworks(Antworks P2P Financing Private Limited), its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, executives, representatives, consultants, legal and other advisors harmless and keep them indemnified for all time to come for any act, deeds or things that he might have done in connection with this Agreement and also shall not hold Antworks responsible for any loss or Damage suffered by him.</li>
<li>The Borrower hereby represents and warrants that he/ she shall hold Antworks (Antworks P2P Financing Private Limited), its associate organizations (including Antworks Capital LLP),its Board of Directors, its Directors, executives, legal and other advisors harmless and keep them indemnified for all time to come for any act, deeds or things that he might have done in connection with this Agreement and shall not hold Antworks responsible for any loss or Damage suffered by him.</li>
</ol>

<p><strong>27.	Assignment</strong></p>
<ol class='definations-list'>
<li>The Borrower shall not assign or transfer any of its rights or obligations under this Agreement. </li>
<li>Subject to the applicable laws and the validity and enforceability of this Loan Agreement not being affected adversely in any manner, the Lender(including Assigned Lender) may at any time transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons by executing a Deed of Assignment or any other valid documents for assignment inter se, without requiring any reference to the Borrower.Any such Person(s) to which the Loan has been transferred / novated in accordance with this Section is referred to as the 'Assigned Lender(s)'.</li>
<li>The Borrower hereby gives his unconditional consent to any number of assignments as referred to above and accordingly all or any of the Lender may at any time transfer all or any part of its rights, benefits and obligations under this Agreement to any one or more persons without requiring any reference to the Borrower.</li>
<li>The Assigned Lender shall, upon such assignment, as the case may be, acquire the same rights and assume the same obligations as regards the Borrower as it would have acquired and assumed had the Assigned Lender been an original party to this Agreement and shall abide by the terms, conditions and obligations of the Lender as stipulated in this Agreement.</li>
<li>The Assigned Lender would immediately intimate Antworks, Borrower and other Lender about the assignment. Upon such assignment, as the case may be, the Borrower would provide fresh PDC to the Assigned Lender and new DPN for the Loan in return of theprevious PDC and DPN of the previous Lenderassigning or novating or transferring his loan would be returned to the Borrower by him.</li>
<li>Notwithstanding anything contained herein, failure to replace the PDC and the DPN in the case of an assignment within 15 days from the date of receipt of intimation by the Borrower, the then outstanding loan amount shall become immediately payable in favour of the new Lender and the PDC and DPN provided already shall be valid for enforcement. However, the new Lender may at their sole discretion, agree to accept the PDCs and the DPN beyond the aforesaid 15 days and in which case the Loan Agreement shall continue without any further act or deed by any party.</li>
<li>Any assignment, shall not be construed as the creation of a new agreement with new obligations or rights, and the Borrower shall not be obliged to pay any person including the assigning or novating or transferring Lender and / or Assigned Lender any greater amount as a result of any such assignment or novation or transfer, as the case may be,than that which it would have been obliged to pay under this Agreement, if no such assignment or novation had taken place.</li>
</ol>
<p><strong>28.	Supersedes</strong></p>
<p>This Agreement constitutes the entire agreement between the Parties and revokes and supersedes all previous discussions/correspondences and agreements between the Parties, oral or implied.</p>

<p><strong>29.	Partial Validity</strong></p>
<p>If any provision of this Agreement or the application thereof to any circumstance shall be invalid, void or unenforceable to any extent, the remainder of this Agreement and the application of such provisions shall continue to be effective and each such provision of this Agreement shall be valid and enforceable to the fullest extent permitted by law. Notwithstanding anything contained hereinabove, if the Platform or services provided by Antworksbecomes illegal due to any legal imposition or change in law, then in such a situation the Borrower shall be liable to refund the then outstanding amount to the Lender or may enter into a separate loan agreement with the Lender and in neither case Antworks shall be responsible / liable in any manner whatsoever.</p>

<p><strong>30.	Alternative</strong></p>
<p>If any such provision is so held to be invalid, illegal or unenforceable, the Parties undertake to use their best efforts to reach a mutually acceptable alternative to give effect to such provision in a manner which is not invalid, illegal or unenforceable and to the extent feasible accurately represents the intention of the Parties.</p>

<p><strong>31.	Interpretation</strong></p>
<ol class='definations-numlist'>
<li>In these presents, where the context so requires, the singular includes the plural and vice versa; and words importing any gender include any other gender.</li>
<li>Title and headings of sections of these presents are for convenience of reference only and shall not affect the construction of any provision herein;</li>
<li>All Schedules, annexure, plans, memorandum or any other document that is attached hereto and bears the signatures and/or seals of the both the Parties hereto shall be deemed to be part of these presents.</li>
</ol>

<p><strong>32.	Waiver</strong></p>
<p>No failure or neglect of either party hereto in any instance to exercise any right, power or privilege hereunder or under law shall constitute a waiver of any other right, power or privilege or of the same right, power or privilege in any other instance. All waivers by either party hereto must be contained in a written instrument signed by the party to be charged or other person duly authorized by it. </p>

<p><strong>33.	Amendment or Modification</strong></p>
<p>Save as otherwise provided elsewhere in this Agreement, no amendment or modification of this Agreement or any part hereof shall be valid and effective unless it is by an instrument in writing executed by the Parties or their authorized representative and expressly referring to this Agreement.</p>

<p><strong>34.	Governance</strong></p>
<p>This Agreement shall be Governed by the Laws of India.</p>

<p><strong>35.	Mode of Service</strong></p>
<p>Any notice or other communication required or permitted hereunder shall be in writing and shall be addressed and delivered to in the respective address of the Parties herein as mentioned in the nomenclature clause - </p>

<p><strong>36.	Dispute Resolution</strong></p>
<p>Any dispute or claim arising from or in connection with this Agreement or breach, termination or invalidity thereof, shall be finally settled by arbitration in accordance with the Arbitration and Conciliation Act, 1996, as amended and/or enacted from time to time. The arbitration tribunal shall consist of one arbitrator, chosen by the parties in accordance with the said Act. The proceeding will be conducted in English and shall take place in Delhi. The award of the arbitrator shall be final and binding on all the Parties.</p>

<h4>IN WITNESS WHEREOF THE PARTIES HERETO HAVE EXECUTED THIS AGREEMENT FOR LOANON THE DAY MONTH AND YEAR FIRST ABOVE WRITTEN.</h4>
<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<td><span class='esign'>e-SIGN</span> <br> ".$current_time_stamp." <br>Borrower</td>
        <td>".$current_time_stamp." <br>Lender</td>
    </tr>
    <tr>
    	<td>Witness</td>
        <td>Witness</td>
    </tr>
    <tr>
    	<td>".$current_time_stamp." <br>Antworks</td>
        <td></td>
    </tr>
    <tr>
    	<td>Witness</td>
        <td>".$current_time_stamp."</td>
    </tr>
  </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FIRST SCHEDULE</h2>
<p>[Details of the Borrower]</p>
</div>

<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>SI</th>
        <th>Particulars</th>
        <th>Details</th>
    </tr>
    <tr>
    	<td>1.</td>
        <td>Name</td>
        <td>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "</td>
    </tr>
    <tr>
    	<td>2.</td>
        <td>Father's Name</td>
        <td>" . $result['BORROWERFATHERNAME'] . "</td>
    </tr>
    <tr>
    	<td>3.</td>
        <td>PAN</td>
        <td>" . $result['BORROWERR_pan'] . "</td>
    </tr>
    <tr>
    	<td>4.</td>
        <td>Aadhaar</td>
        <td>" . $result['BORROWERR_aadhaar'] . "</td>
    </tr>
    <tr>
    	<td>5.</td>
        <td>Address</td>
        <td>" . $result['BORROWERR_Address'] . " " . $result['BORROWERR_Address1'] . " " . $result['BORROWERR_City'] . " " . $result['BORROWERR_State'] . " " . $result['BORROWERR_Pincode'] . "</td>
    </tr>
    <tr>
    	<td>6.</td>
        <td>E-mail ID</td>
        <td>" . $result['BORROWEREMAIL'] . "</td>
    </tr>
    <tr>
    	<td>7.</td>
        <td>Mobile</td>
        <td>" . $result['BORROWERMOBILE'] . "</td>
    </tr>
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SECOND SCHEDULE</h2>
<p>[Details of the Lender]</p>
</div>

<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>SI</th>
        <th>Particulars</th>
        <th>Details</th>
    </tr>
    <tr>
    	<td>1.</td>
        <td>Name</td>
        <td>" . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . "</td>
    </tr>
    <tr>
    	<td>2.</td>
        <td>Father's Name</td>
        <td>" . $result['LENDER_fNAME'] . "</td>
    </tr>
    <tr>
    	<td>3.</td>
        <td>PAN</td>
        <td>" . $result['LENDER_PAN'] . "</td>
    </tr>
    <tr>
    	<td>4.</td>
        <td>Aadhaar</td>
        <td>" . $result['LENDER_PAN'] . "</td>
    </tr>
    <tr>
    	<td>5.</td>
        <td>Address</td>
        <td>" . $result['LENDER_address'] . " " . $result['LENDER_address1'] . " " . $result['LENDER_city'] . " " . $result['LENDER_state_code'] . "</td>
    </tr>
    <tr>
    	<td>6.</td>
        <td>E-mail ID</td>
        <td>" . $result['LENDER_email'] . "</td>
    </tr>
    <tr>
    	<td>7.</td>
        <td>Mobile</td>
        <td>" . $result['LENDER_mobile'] . "</td>
    </tr>
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>THIRD SCHEDULE</h2>
<p>[Format of the Amortization Schedule]</p>
</div>
<ul class='definations-numbrlist'>
<li>Loan Amount Rs.:" . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "</li>
<li>Loan Tenor " . $result['TENORMONTHS'] . "</li>
<li>Rate of Interest Per Annum " . $result['LOAN_Interest_rate'] . "%</li>
<li>Monthly Instalment (EMI) RS-" . round($emi) . "</li>
</li>
</ul>
<div class='table-responsive'>
  <table class='table table-bordered'>
  	<tr>
    	<th>Installment Number</th>
        <th>Monthly Instalment Amount</th>
        <th>Monthly Instalment Due Date</th>
        <th>Interest Component</th>
        <th>Principal Component</th>
        <th>Balance Principal Outstanding</th>
    </tr>
    <tr>
    	<th></th>
        <th>(INR)</th>
        <th></th>
        <th>(INR)</th>
        <th>(INR)</th>
        <th>(INR)</th>
    </tr>
   " . $table . "
   </table>
</div>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FOURTH SCHEDULE</h2>
<p>DEMAND PROMISSORY NOTE</p>
</div>

<p>On demand, I, Mr./Miss/Mrs. " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . " (Hereinafter the 'Borrower') S/o/D/o/W/o, " . $result['LENDER_fNAME'] . "hereby promise to pay to
Mr./Mrs./Miss " . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . " S/o/D/o/W/o, " . $result['BORROWERFATHERNAME'] . ", (referred to as the Lender in the Loan Agreement Dated ".$current_time_stamp." inter-alia between me as Borrower and the Lender) the sum of Rs. " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "(Rupees ".$loan_amount_inword." only) in " . $result['TENORMONTHS'] . " monthly instalments, to be paid every month together with interest at the rate of " . $result['LOAN_Interest_rate'] . "% per annum, from the date of these presents, payable in any part of India for value received.</p>
<p>In the event I default in making payment hereunder in any manner whatsoever, the entire balance then remaining outstanding shall immediately become due and payable.</p>
<div>
<p class='text-left'><strong>Borrower Name & Signature</strong></p>	<p class='text-right'><strong>Date</strong></p>

</div>
<p>.........................</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>FIFTH SCHEDULE</h2>
<p><strong>UNDERTAKING</strong></p>
</div>
<p>I, Sri " . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "(PAN: " . $result['BORROWERR_pan'] . "), S/o " . $result['BORROWERFATHERNAME'] . ", residing at do hereby undertake as under:</p>

<ol class='definations-numbrlist'>
	<li>THAT I have taken a Loan of an amount Rs. " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . "./- (Rupees ".$loan_amount_inword.") for a tenure of " . $result['TENORMONTHS'] . ".months from Sri " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . ".by virtue of Loan Agreement No. LAN ".$loan_amount_number." dated ".$current_time_stamp."</li>
    <li>THAT in the said Agreement Sri " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . ". has been identified as the Lender and myself as Borrower and <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> as Antworks</li>
    <li>THAT the personal data furnished by me to <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a> are true and correct at the time of submission</li>
    <li>THAT any change in my variable personal data like communication address etc. shall be intimated to the Lender and Antworks within 7 days from such change.</li>
    <li>THAT I shall not use the loan for any purpose other than the purpose mentioned in this agreement</li>
    <li>THAT I shall not use the loan for any unlawful purpose or for any purpose that is immoral or unethical.</li>
    <li>THAT I shall not use the loan for investment purpose or for the purpose of trading in the stock market.</li>
    <li>THAT Ishall reimburse and pay for all costs, charges and expenses, including stamp duty and legal costs on actual basis and other charges and expenses which may be incurred in preparation of these presents related to and or incidental documents including legal fees.</li>
<li>THAT I have read and understood all the terms and conditions of <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</li>
<li>THAT I shall have no objection if the Lender or Antworks takes any legal action against me including lodging of PDCs/DPN, in case I fail to repay the Loan as aforesaid</li>
</ol>
<p class='text-left'><strong>Borrower Name & Signature</strong></p>	<p class='text-right'><strong>Date</strong></p>
<p>.................................</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SIXTH SCHEDULE</h2>
<p>[Format of No Dues Certificate]</p>
</div>
<p>" . $result['BORROWERR_Address'] . "<br/>
" . $result['BORROWERR_Address1'] . "<br/>
" . $result['BORROWERR_City'] . "<br/>
" . $result['BORROWERR_State'] . "<br/>
" . $result['BORROWERR_Pincode'] . "</p>

<p>Dear Sir,</p>

<p>NO DUES CERTIFICATE</p>

<p>This has reference to the Loan of Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . ".for the tenure " . $result['TENORMONTHS'] . "at the rate of interest of " . $result['LOAN_Interest_rate'] . "% taken by you ('Borrower') from me ('Lender') by virtue of a Loan Agreement vide LAN ".$loan_amount_number." dated ".$current_time_stamp." ('the Loan') through <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</p>

<p>I hereby confirm that I have received all sums payable by you to me in connection with the Loan and I have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>
<p>(.....................)</p>
<pagebreak />
<div class='text-center'>
<h2 class='agrmnt-hd'>SEVENTH SCHEDULE</h2>
<p>[Format of Clearance Certificate]</p>
</div>
<p>" . $result['BORROWERNAME'] . " " . $result['BORROWERMIDDLENAME'] . " " . $result['BORROWERLASTNAME'] . "<br/>
" . $result['BORROWERR_Address'] . "<br/>
" . $result['BORROWERR_Address1'] . "<br/>
" . $result['BORROWERR_City'] . "  " . $result['BORROWERR_Pincode'] . "</strong><br/>
" . $result['BORROWERR_State'] . "</p>
<p>Dear Sir,</p>

<p><strong>Clearance Certificate</strong></p>

<p>This has reference to the Loan of Rs " . (($result['LOANAMOUNT'] * $result['APPROVERD_LOAN_AMOUNT']) / 100) . " for the tenure " . $result['TENORMONTHS'] . " at the rate of interest of " . $result['LOAN_Interest_rate'] . "% taken by you ('Borrower') from " . $result['LENDER_fNAME'] . " " . $result['LENDER_middle_name'] . " " . $result['LENDER_last_name'] . " ('Lender') by virtue of a Loan Agreement vide LAN ".$loan_amount_number." dated ".$current_time_stamp." ('the Loan') through us <a href='http://www.p2ploan.antworksmoney.com'>www.p2ploan.antworksmoney.com</a>.</p>

<p>We hereby confirm that there stands no amount payable by to us by you and we have no further claim whatsoever in connection with the aforesaid Loan.</p>

<p>Thanking you,</p>

<p>Yours faithfully,</p>
<p>(..................)</p>



</div>
</body>
</html>
";

					$file_name = $result['BORROWER_ID'] . '-' . $result['LENDER_ID'] . '.pdf';
					sleep(5);
					//echo $html;
					$mpdf = new \Mpdf\Mpdf();
					$stylesheet = file_get_contents($_SERVER["DOCUMENT_ROOT"].'/assets/css/loan-aggrement.css'); // external css
					$mpdf->WriteHTML($stylesheet,1);
					$mpdf->WriteHTML($html,2);
					$mpdf->Output('./borrower_loan_aggrement/' . $file_name, 'F');
					$arr = array(
						'bid_registration_id' => $result['bid_registration_id'],
						'borrower_id' => $result['BORROWER_ID'],
						'doc_name' => $file_name,
						'accept_or_not' => 1,
					);
					$this->db->insert('borrower_loan_aggrement', $arr);
					$this->email->clear(TRUE);
					$attched_file = $_SERVER["DOCUMENT_ROOT"] . "/borrower_loan_aggrement/" . $file_name . "";
					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'mail.antworksmoney.com',
						'smtp_port' => 465,
						'smtp_user' => 'hdfclead@antworksmoney.com',
						'smtp_pass' => 'TmEo3&Q=Wn%[',
						'mailtype' => 'html',
						'charset' => 'iso-8859-1'
					);
					$to_email_lender = $result['LENDER_email'];
					$to_email_borrower = $result['BORROWEREMAIL'];
					$subject = "P2P Antworks Money Loan Aggrement";
					$msg = "ANTWORKS P2P FINANCING PRIVATE LIMITED LOAN AGGREMENT";
					//$email = 'lingadurais@hdfcsales.com, anantharaja@hdfcsales.com';
					//$email = 'dinesh@antworksmoney.com';
					$this->load->library('email', $config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this->email->from('grievance.p2p@antworksmoney.com', 'ANTWORKS P2P FINANCING PRIVATE LIMITED LOAN AGGREMENT');
					$this->email->to($to_email_borrower, $to_email_lender);
					//$this->email->cc('dinesh@antworksmoney.com');
					$this->email->attach($attched_file);
					$this->email->subject($subject);
					$this->email->message($msg);
					if ($this->email->send()) {
						if($result['BORROWERR_gender'] == 'Male')
						{
							$title = 'Mr';
						}
						else
						{
                            $title = 'Ms';
						}
						$loan_amount = ($result['LOANAMOUNT']*$result['APPROVERD_LOAN_AMOUNT'])/100;
						$this->Smsmodule->Borrower_Sanctioned($title, $result['BORROWERNAME'], $loan_amount, $result['BORROWERMOBILE']);
					}
					else
					{
						echo $this->email->print_debugger(); exit;
					}
				}
				$msg="Sent Successfully, Thanks!";
				$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
				redirect(base_url().'management/disbursement_cases');
			}
		}
		else{

		}
	}

	public function repayment()
	{
		if ( $this->session->userdata('login_state') == TRUE ) {
			if ($this->session->userdata('role') == 16) {
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				$data['list'] = $this->Managementmodel->repayment_proposal();
				$data['pageTitle'] = "Approved Bid";
				$this->load->view('templates-admin/header');
				$this->load->view('templates-admin/nav',$data);
				$this->load->view('templates-admin/header-below',$data);
				$this->load->view('repayment',$data);
				$this->load->view('templates-admin/footer');
			}
		}
    }

	public function view_repayment()
	{
		if ( $this->session->userdata('login_state') == TRUE ) {
			if ($this->session->userdata('role') == 16) {
				$userdetails = $this->Loginmodel->userdetails($this->session->userdata('username'));
				$data['userdetails'] = $userdetails[0];
				$proposal_id = $_GET['proposal_id'];
				$data['list'] = $this->Managementmodel->repayment_proposal_view($proposal_id);
				$data['pageTitle'] = "Approved Bid";
				$this->load->view('templates-admin/header');
				$this->load->view('templates-admin/nav',$data);
				$this->load->view('templates-admin/header-below',$data);
				$this->load->view('repaymentdetails',$data);
				$this->load->view('templates-admin/footer');
			}
		}
	}

	public function send_to_escrow()
	{
		$id = $_POST['emi_id'];
		require_once APPPATH . "/third_party/excel/PHPExcel.php";
		 $sql = "SELECT
				APD.loan_account_number,
                'BR0383834' AS BORROWERVIRTUALAC,
 				DED.emi_date AS emi_date,
 				DED.emi_amount AS emi_amount,
 				BDT.first_name AS BORROWERNAME,
 				BDT.mobile AS BORROWERMOBILE,
 				BDT.mobile AS BORROWERMOBILE,
 				BDT.email AS BORROWEREMAIL,
 				BDT.pan AS BORROWERPAN,
 				BDT.pan AS BORROWERPAN,
 				BDT.aadhaar AS BORROWERAADHAAR,

 				'LENDER9484884' AS LENDERVIRTUALAC,
 				UI.first_name AS LENDERNAME,
 				UI.mobile AS LENDERMOBILE,
 				UI.email AS LENDEREMAIL,
 				LDT.pan AS LENDERPAN,
 				LDT.aadhaar AS LENDERaadhaar,
 				LDT.bank_name AS LENDERbank_name,
 				LDT.branch_name AS LENDERbranch_name,
 				LDT.account_number AS LENDERaccount_number,
 				LDT.account_number AS LENDERaccount_number,
 				LDT.ifsc_code AS LENDERifsc_code,
 				LDT.account_type AS LENDERaccount_type
 				FROM
				borrower_emi_details AS DED
                LEFT JOIN borrowers_details_table AS BDT
                ON BDT.borrower_id = DED.borrower_id
                LEFT JOIN user_info AS UI
                ON UI.user_id = DED.lender_id
                LEFT JOIN lenders_details_table AS LDT
                ON LDT.user_id = DED.lender_id
                LEFT JOIN approved_bidding_details AS APD
                ON APD.bid_registration_id = DED.loan_id
                WHERE DED.id=" . $id . "
               ";
		$query = $this->db->query($sql);
		if ($this->db->affected_rows() > 0) {
			$data = $query->result_array();

			if ($data) {
			$this->excel = new PHPExcel();
			$this->excel->setActiveSheetIndex(0);
			$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$this->excel->getActiveSheet()->getStyle("A1:G1")->applyFromArray(array("font" => array("bold" => true)));
			$this->excel->getActiveSheet()->setCellValue('A1', 'Loan Account No');
			$this->excel->getActiveSheet()->setCellValue('B1', 'Borrower Virtual AC');
			$this->excel->getActiveSheet()->setCellValue('C1', 'EMI	Date');
			$this->excel->getActiveSheet()->setCellValue('D1', 'EMI	AMOUNT');
			$this->excel->getActiveSheet()->setCellValue('E1', 'Borrower Name');
			$this->excel->getActiveSheet()->setCellValue('F1', 'Borrower Mobile');
			$this->excel->getActiveSheet()->setCellValue('G1', 'Borrower Email');
			$this->excel->getActiveSheet()->setCellValue('H1', 'Borrower Pan');
			$this->excel->getActiveSheet()->setCellValue('I1', 'Borrower Aadhar');
			$this->excel->getActiveSheet()->setCellValue('J1', 'Lender Virtual AC');
			$this->excel->getActiveSheet()->setCellValue('K1', 'Lender Name');
			$this->excel->getActiveSheet()->setCellValue('L1', 'Lender Mobile');
			$this->excel->getActiveSheet()->setCellValue('M1', 'Lender Email');
			$this->excel->getActiveSheet()->setCellValue('N1', 'Lender Pan');
			$this->excel->getActiveSheet()->setCellValue('O1', 'Lender Aadhar');
			$this->excel->getActiveSheet()->setCellValue('P1', 'Lender Bank Name');
			$this->excel->getActiveSheet()->setCellValue('Q1', 'Lender Branch Name');
			$this->excel->getActiveSheet()->setCellValue('R1', 'Lender Account Number');
			$this->excel->getActiveSheet()->setCellValue('S1', 'Lender Ifsc Code');
			$this->excel->getActiveSheet()->setCellValue('T1', 'Lender Account Type');
			$this->excel->getActiveSheet()->setTitle('Sheet 1');
			$date_current = 'ant_' . date('Y-m-d H:i:s');
			$this->excel->getActiveSheet()->fromArray($data, null, 'A2');
			//$filename=$date_current.'.xls'; //save our workbook as this file name
			$filename = 'sendemi.xls'; //save our workbook as this file name
			//header('Content-Type: application/vnd.ms-excel'); //mime type
			//header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			// header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

			//$objWriter->save('just_some_random_name.xls');
			if ($objWriter->save('uploads/emi/' . $filename)) ;
			{
				$attched_file = $_SERVER["DOCUMENT_ROOT"] . "/uploads/emi/sendemi.xls";
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.antworksmoney.com',
					'smtp_port' => 465,
					'smtp_user' => 'hdfclead@antworksmoney.com',
					'smtp_pass' => 'TmEo3&Q=Wn%[',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1'
				);
				$subject = "P2P Finance EMI Details";
				$msg = "P2P Finance EMI Details";
				$this->load->library('email', $config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");
				$this->email->from('followup@antworksmoney.com', 'P2P Finance');
				$this->email->to('dinesh@antworksmoney.com');
				//	$this->email->cc($result_bank_get->email_cc);
				$this->email->attach($attched_file);
				$this->email->subject($subject);
				$this->email->message($msg);
				if ($this->email->send()) {
//					$this->db->set('send_to_escrow',1);
//					$this->db->where('id',$id);
//					$this->db->update('borrower_emi_details',$id);
					$msg="Sent Successfully, Thanks!";
					$this->session->set_flashdata('notification',array('error'=>0,'message'=>$msg));
					redirect(base_url().'management/repayment');
				}
				else {
					$msg="Not Sent, Please Try Again!";
					$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
					redirect(base_url().'management/repayment');

				}
			}
		}
	     }
		else
		{
			$msg="Seems you are on a wrong place. Please Contact system administrator.";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'management/repayment');
		}
	}


}

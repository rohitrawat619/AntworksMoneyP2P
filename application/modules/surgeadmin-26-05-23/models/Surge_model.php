<?php 

class Surge_model extends CI_Model {
  
  public function __construct()
    {
        parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
    }

	function checkPassword($password,$email)
	{
		$query = $this->cldb->query("SELECT * FROM surge_admin WHERE password='$password' AND email='$email' AND status='1'");
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
	}

	

	

		


 
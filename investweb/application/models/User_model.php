<?php 

class User_model extends CI_Model {

	function insertuser($data)
	{
		$this->db->insert('users1',$data);
	}

	function checkPassword($password,$email)
	{
		$query = $this->db->query("SELECT * FROM invest_users1 WHERE password='$password' AND email='$email' AND status='1'");
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}

	function checkvenrep($password,$email)
	{
		$query = $this->db->query("SELECT * FROM authorised_users WHERE Password='$password' AND Repemail='$email'");
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			return false;
		}

	}

	// function loginteam($password,$email)
	// {
	// 	$query = $this->db->query("SELECT * FROM buisnessteam WHERE password='$password' AND email='$email' AND status='1'");
	// 	if($query->num_rows()==1)
	// 	{
	// 		return $query->row();
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}

	// }

}
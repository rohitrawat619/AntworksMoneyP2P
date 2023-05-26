<?php 

class Investmodel extends CI_Model {

 public function __construct()
    {
        parent::__construct();
		$this->cldb = $this->load->database('credit-line', TRUE);
    }
	

	public function allvendors_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_vendors');

		$res = $this->cldb->get();
		
			return $result = $res->result_array();
		
		}


		public function allrepersent_get()
		{
			$this->cldb->select('*');
			$this->cldb->from('invest_repessentative');
	
			$res = $this->cldb->get();
			
				return $result = $res->result_array();
			
			}

		
 public function allschemes_get()
	{
		$this->cldb->select('*');
		$this->cldb->from('invest_scheme_details');

		$res = $this->cldb->get();
		
			return $result = $res->result_array();
		
		}

  public function vend_addcheme_get()
		{
			$this->cldb->select('*');
			$this->cldb->from('invest_vendors');
	
			$res = $this->cldb->get();
			
				return $result = $res->result_array();
			
			}

			public function scheme_vend_get()
			{
				$this->cldb->select('*');
				$this->cldb->from('invest_vendors');
		
				$res = $this->cldb->get();
				
					return $result = $res->result_array();
				
				}
		
	public function edituser($VID)

		{
		  $query = $this->cldb->select('*')->from('invest_vendors')->where('VID',$VID)->get();
		  if($this->cldb->affected_rows()>0)
		  {
			  return (array)$query->row();
		  }
		  else{
			  return false;
		  }
	   }


	   public function updatescheme2($id)

	   {
		 $query = $this->cldb->select('*')->from('invest_scheme_details')->where('id',$id)->get();
		if($this->cldb->affected_rows()>0)
		{
			 return (array)$query->row();
		}
		else{
			return false;
		}
	  }
	
 public function update_user($data)
        {
            $this->cldb->where('VID', $this->input->post('VID'));
            return $this->cldb->update('invest_vendors', $data);
        }


	 public function editrepersents($rid)                      

	 {
	   $query = $this->cldb->select('*')->from('invest_repessentative')->where('rid',$rid)->get();
	   if($this->cldb->affected_rows()>0)
	   {
		   return (array)$query->row();
	   }
	   else{
		   return false;
	   }
	   
	   
	  }
	 
	  public function update_repersent($data)
	  {
		  $this->cldb->where('rid', $this->input->post('rid'));
		 $this->cldb->update('invest_repessentative', $data);
		
	  }


	  public function update_scheme($data)
	  {
		  $this->cldb->where('id', $this->input->post('id'));
		  return $this->cldb->update('invest_scheme_details', $data);
	  }
	 


public function insert_vendor()
{
	$data = array(
		'Company_Name'=>$this->input->post('Company_Name'),
		'Address'=>$this->input->post('Address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email')
	);
$this->cldb->insert('invest_vendors',$data);
 
return true;
 
	
}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Model {
	public function page($type)
	{
		if($type=='about'){
			$arr=array('title'=>'About','data'=>'About Data');
		}elseif($type=='contact'){
			$arr=array('title'=>'Contact','data'=>'Contact Data');
		}else{
			$arr=array('title'=>'Home','data'=>'Home Data');
		}
		return $arr;
	}
	public function insert_data($data)
	{
		$this->db->insert('test1',$data);
	}
	public function update_data($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('test1',$data);
	}
	public function delete_data($data)
	{
		$this->db->delete('test1',$data);
	}
	public function get_data($id)
	{
		//$query=$this->db->get('contact');
		
		$this->db->select('city,name');
		$this->db->from('test1');
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->result();
	}
	
	
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2precoverymodel');
    }
  
    public function index()
        {
            
            $data['week'] = $this->P2precoverymodel->getLast_week();
            $data['twoweek'] = $this->P2precoverymodel->getLast_Twoweek();
            $data['list'] = $this->P2precoverymodel->getEmilist_due();
            $data['bounced'] = $this->P2precoverymodel->getEmi_bounced();
            //echo "<pre>";
            //print_r($data);exit;
            $data['pageTitle'] = "Dashboard";
            $data['title'] = "Admin Dashboard";
            $this->load->view('p2precovery/header',$data);
            $this->load->view('p2precovery/nav',$data);
            $this->load->view('dashboard',$data);
            $this->load->view('p2precovery/footer',$data);
       
       }
  

 //*************************************************** 


 
}
?>

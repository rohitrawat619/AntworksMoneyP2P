<?php
class Misconverted extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $this->load->database();
        $this->db2= $this->load->database('money',true);
        $this->load->helper('path');
        $this->load->library('form_validation');
		 if( $this->session->userdata('admin_state') == TRUE &&  ( $this->session->userdata('role') == 'mis' || $this->session->userdata('role') == 'admin' )){

        }
        else{
            $msg="Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
            redirect(base_url().'login/admin-login');
        }
    }

    public function index()
    {
        
        //echo "<pre>";
       // print_r($data);exit;
        $data['pageTitle'] = "MIS List";

        $data['title'] = "MIS List";
        $this->load->view('templates-admin/header',$data);
        $this->load->view('templates-admin/mis-nav',$data);
        $this->load->view('mis1',$data);
        $this->load->view('templates-admin/footer',$data);
    }


  public function doenloadGoogleccCon()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','1');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                  $msg="We could not found any Data.";
                  $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                  redirect(base_url() . 'p2padmin/misconverted/');
              }
     }
    }

    public function doenloadOnlineccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','2');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                  $msg="We could not found any Data.";
                  $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                  redirect(base_url() . 'p2padmin/misconverted/');
              }
      }
    }

   public function doenloadFreeCraditScoreccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','3');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

     public function doenloadTransferFromUccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','4');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

   public function doenloadTransferFromMccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','5');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

    public function doenloadFacebookccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','6');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
              }
    }
    }

    public function doenloadScrubDataccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','7');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
              }
    }
    }

    public function doenloadFinancialBuddyccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','8');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
              }
    }
    }

    public function doenloadBlogWebsiteccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','9');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }
          else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
            }
    }
    }


  

     public function doenloadTransferfromPTPccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','10');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }
        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

     public function doenloadTransferFromCRMccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','11');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }


     public function doenloadLandingAddaccCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('status','11');
        $this->db2->where('source_of_lead','13');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }


  public function doenloadGoogleccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','1');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

    public function doenloadOnlineccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','2');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }


    public function doenloadFreeCraditScoreccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','3');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

    public function doenloadTransferFromUccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','4');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
             }
    }
    }

    public function doenloadTransferFromMccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','5');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                      $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                      redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

    public function doenloadFacebookccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','6');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }
         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
             }
    }
    }


    public function doenloadScrubDataccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','7');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }
            else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
              }
    }
    }

    public function doenloadFinancialBuddyccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','8');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }


    public function doenloadBlogWebsitecNoncCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','9');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }


    public function doenloadTransferFromP2PccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','10');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }

   public function doenloadTransferFromCRMccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','11');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                     $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                      redirect(base_url() . 'p2padmin/misconverted/');
            }
    }
    }

    public function doenloadLandingAddaccNonCon()
     {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where_not_in('status','11');
        $this->db2->where('source_of_lead','13');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
    }
    }
//*****************************************************************************************************
  public function doenloadGoogleccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','1');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    }    

//*****************************************************************************************************
  public function doenloadOnlineccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','2');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

       else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    }  

//*****************************************************************************************************
  public function doenloadFreeCraditScoreccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','3');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }
            else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
               }
     }
    } 
//*****************************************************************************************************
  public function doenloadTransferFromUccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','4');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 

//*****************************************************************************************************
  public function doenloadTransferFromMccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','5');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 


//*****************************************************************************************************
  public function doenloadFacebookccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','6');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    }
    
//*****************************************************************************************************
  public function doenloadScrubDataccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','7');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    }          
        

//*****************************************************************************************************
  public function doenloadFinancialBuddyccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','8');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

         else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 

//*****************************************************************************************************
  public function doenloadBlogWebsiteccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','9');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    }  
//*****************************************************************************************************
  public function doenloadTransferFromP2Pccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','10');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 
//*****************************************************************************************************
  public function doenloadTransferFromCRMccall()
    {

       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','11');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                     $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 
         
//*****************************************************************************************************
  public function doenloadLandingAddaccall()
    {
      
       $this->load->dbutil();
       $this->load->helper('file');
       $this->load->helper('download');
       $delimiter = ",";
       $newline = "\r\n";
       $filename = "Mis.csv";
       unset($_POST['submit']);
       $str = "";
      foreach ($_POST as $key => $value) 
        { 
     
          $str .= implode(',', $value);
     
        } 

     if(!empty($_POST))
        {
        $this->db2->select("$str");
        $this->db2->from('credit_score_query');
        $this->db2->where('source_of_lead','13');
        $result = $this->db2->get();
       if ($this->db2->affected_rows() > 0) 
         {
           $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
           force_download($filename, $data);
          }

        else {
                          $msg="We could not found any Data.";
                         $this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
                        redirect(base_url() . 'p2padmin/misconverted/');
          }
     }
    } 

//*****************************************************************************************************

}
?>
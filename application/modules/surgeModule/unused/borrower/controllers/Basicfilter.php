<?php

class Basicfilter extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        error_reporting(0);
        $this->load->model('Basicfiltermodel');
    }

    public function index()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $data['rule'] = $this->Basicfiltermodel->get_latest_rule();
            $data['occupation_list'] = $this->Basicfiltermodel->get_occupation();
            $data['qualification_list'] = $this->Basicfiltermodel->get_qualification();
            $data['company_category_list'] = $this->Basicfiltermodel->company_category_list();
//            pr($data['company_category_list']);
            $data['pageTitle'] = "Basic Filter Rules";
            $data['title'] = "Basic Filter Rules";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('basic-filter/basic-filter', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function report()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $where = array();
            $data['age_success_fail'] = $this->Basicfiltermodel->get_age_success_fail($where);
            $data['get_pan_success_fail'] = $this->Basicfiltermodel->get_pan_success_fail($where);
            $data['get_pincode_success_fail'] = $this->Basicfiltermodel->get_pincode_success_fail($where);
            $data['get_Qualification_success_fail'] = $this->Basicfiltermodel->get_Qualification_success_fail($where);
            $data['get_Occupation_success_fail'] = $this->Basicfiltermodel->get_Occupation_success_fail($where);
            $data['get_Company_success_fail'] = $this->Basicfiltermodel->get_Company_success_fail($where);
            $data['get_salary_success_fail'] = $this->Basicfiltermodel->get_salary_success_fail($where);
            $data['get_credit_score_success_fail'] = $this->Basicfiltermodel->get_credit_score_success_fail($where);
            $data['pageTitle'] = "Basic Filter Rules Report";
            $data['title'] = "Basic Filter Rules Report";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('basic-filter/basic', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function company_list()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $data['company_list'] = $this->Basicfiltermodel->company_list();
            $data['pageTitle'] = "Basic Filter Company List";
            $data['title'] = "Basic Filter Company List";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('basic-filter/company-list', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function negative_pincode_list()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $data['pincode_list'] = $this->Basicfiltermodel->negative_pincode_list();
            $data['pageTitle'] = "Basic Filter Negative Pincode List";
            $data['title'] = "Basic Filter Negative Pincode List";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('basic-filter/negative-pincode-list', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function action()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $response = $this->Basicfiltermodel->add_update_rule();
            $this->session->set_flashdata('notification', array('error' => 0, 'message' => $response['msg']));
            redirect(base_url() . 'p2padmin/basicfilter');
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }

    public function export_company_list()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Companylist.csv";
        $result = $this->db->get_where('p2p_list_company');
        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            $msg = "We could not found any Data.";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'p2padmin/basicfilter/company_list');
        }
    }

    public function export_pincode_list()
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "Negative_Pincode.csv";
        $result = $this->db->get_where('negative_pincode');
        if ($this->db->affected_rows() > 0) {
            $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
            force_download($filename, $data);
        } else {
            $msg = "We could not found any Data.";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'p2padmin/basicfilter/negative_pincode_list');
        }
    }

    public function filter_report()
    {
        if ($this->session->userdata('admin_state') == TRUE) {
            $where = array();

            if (!$this->input->post('start_date')){
                $msg = "Please select date";
                $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
                redirect(base_url() . 'p2padmin/basicfilter/report');
            }

            if ($this->input->post('View')){

                  $dates_arr = explode('-', $this->input->post('start_date'));
                  $where['date(created_date) >='] = date('Y-m-d', strtotime($dates_arr[0]));
                  $where['date(created_date) <='] = date('Y-m-d', strtotime($dates_arr[1]));
            }

            $data['age_success_fail'] = $this->Basicfiltermodel->get_age_success_fail($where);
            $data['get_pan_success_fail'] = $this->Basicfiltermodel->get_pan_success_fail($where);
            $data['get_pincode_success_fail'] = $this->Basicfiltermodel->get_pincode_success_fail($where);
            $data['get_Qualification_success_fail'] = $this->Basicfiltermodel->get_Qualification_success_fail($where);
            $data['get_Occupation_success_fail'] = $this->Basicfiltermodel->get_Occupation_success_fail($where);
            $data['get_Company_success_fail'] = $this->Basicfiltermodel->get_Company_success_fail($where);
            $data['get_salary_success_fail'] = $this->Basicfiltermodel->get_salary_success_fail($where);
            $data['get_credit_score_success_fail'] = $this->Basicfiltermodel->get_credit_score_success_fail($where);


            if ($this->input->post('Download')){
                error_reporting(0);
                $filename = date('Ymd') . '.csv';
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Type: application/csv; ");
                $handle = fopen('php://output', 'w');
                fputcsv($handle, array(
                    'Basic filtration criteria',
                    'Total Visitor',
                    'Count of Pass(After particular filtration criteria)',
                    'Count of Stop/Decline(After particular filtration criteria)',
                ));

                fputcsv($handle, array(
                    '1. DOB',
                    $data['age_success_fail']['success'] + $data['age_success_fail']['fail'],
                    $data['age_success_fail']['success'],
                    $data['age_success_fail']['fail'],
                ));
                /*fputcsv($handle, array(
                    '2. PAN not validate with filled details',
                    $data['get_pan_success_fail']['success'] + $data['get_pan_success_fail']['fail'],
                    $data['get_pan_success_fail']['success'],
                    $data['get_pan_success_fail']['fail'],
                ));*/
                fputcsv($handle, array(
                    '2. Negative PIN CODE',
                    $data['get_pincode_success_fail']['success'] + $data['get_pincode_success_fail']['fail'],
                    $data['get_pincode_success_fail']['success'],
                    $data['get_pincode_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '3. Qualification',
                    $data['get_Qualification_success_fail']['success'] + $data['get_Qualification_success_fail']['fail'],
                    $data['get_Qualification_success_fail']['success'],
                    $data['get_Qualification_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '4. Occupation',
                    $data['get_Occupation_success_fail']['success'] + $data['get_Occupation_success_fail']['fail'],
                    $data['get_Occupation_success_fail']['success'],
                    $data['get_Occupation_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '5. Company not match with our CAT list',
                    $data['get_Company_success_fail']['success'] + $data['get_Company_success_fail']['fail'],
                    $data['get_Company_success_fail']['success'],
                    $data['get_Company_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '6. Salary',
                    $data['get_salary_success_fail']['success'] + $data['get_salary_success_fail']['fail'],
                    $data['get_salary_success_fail']['success'],
                    $data['get_salary_success_fail']['fail'],
                ));
                fputcsv($handle, array(
                    '7. Experian',
                    $data['get_credit_score_success_fail']['success'] + $data['get_credit_score_success_fail']['fail'],
                    $data['get_credit_score_success_fail']['success'],
                    $data['get_credit_score_success_fail']['fail'],
                ));

                fclose($handle); exit;
            }

            $data['pageTitle'] = "Basic Filter Rules Report";
            $data['title'] = "Basic Filter Rules Report";
            $this->load->view('templates-admin/header', $data);
            $this->load->view('templates-admin/nav', $data);
            $this->load->view('basic-filter/basic', $data);
            $this->load->view('templates-admin/js/borrowerJS', $data);
            $this->load->view('templates-admin/footer', $data);
        } else {
            $msg = "Your session had expired. Please Re-Login";
            $this->session->set_flashdata('notification', array('error' => 1, 'message' => $msg));
            redirect(base_url() . 'login/admin-login');
        }
    }
}

?>
<?php
class Basicfiltermodel extends CI_Model{

    public function __construct()
    {
        parent::__construct();
      //  $this->cldb = $this->load->database('credit-line', TRUE);
	  $this->cldb = $this->load->database('', TRUE); // antworks_p2pdevelopment
    }

    public function get_occupation()
    {
        return $this->cldb->get_where('p2p_occupation_details_table')->result_array();
    }

    public function get_qualification()
    {
        return $this->cldb->get_where('p2p_qualification')->result_array();
    }

    public function company_category_list()
    {
        return $this->cldb->group_by('company_category')->get_where('p2p_list_company')->result_array();
    }

    public function add_update_rule()
    {
        $this->cldb->insert('basic_filter_rules', array(
           'min_age' => $this->input->post('min_age'),
           'max_age' => $this->input->post('max_age'),
           'qualification' => implode(',', $this->input->post('qualification')),
           'occupation' => implode(',', $this->input->post('occupation')),
           'salary_less_than' => $this->input->post('salary_less_than'),
           'credit_score' => $this->input->post('credit_score'),
           'company_category' => implode(',', $this->input->post('company_category')),
//           'pan_validate_with_filled_details' => $this->input->post('pan_validate_with_filled_details'),
       ));
            if ($_FILES["negative_pincode"]["size"] > 0) {
                $filename = $_FILES["negative_pincode"]["tmp_name"];
                $file = fopen($filename, "r");
                $firstRow = true;
                while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                    if ($firstRow) {
                        $firstRow = false;
                    } else {
                        $pincode = trim($importdata[0]);
                        $this->cldb->get_where('negative_pincode', array('pincode' => $pincode));
                        if ($this->cldb->affected_rows() <= 0)
                        {
                            $this->cldb->insert('negative_pincode', array('pincode' => $pincode));
                        }

                    }
                }
                fclose($file);
            }

        if ($_FILES["cat_list"]["size"] > 0) {
            $filename = $_FILES["cat_list"]["tmp_name"];
            $file = fopen($filename, "r");
            $firstRow = true;
            while (($importdata = fgetcsv($file, 10000, ",")) !== FALSE) {
                if ($firstRow) {
                    $firstRow = false;
                } else {
                    $company_name = trim($importdata[0]);
                    $company_category = trim($importdata[1]);
                    $this->cldb->get_where('p2p_list_company', array('company_name' => $company_name, 'company_category' => $company_category));
                    if ($this->cldb->affected_rows() <= 0) {
                        $this->cldb->insert('p2p_list_company', array('company_name' => $company_name, 'company_category' => $company_category));
                    }

                }
            }
            fclose($file);
        }
        return array(
            'status' => 1,
            'msg' => 'Rule added successfully'
        );
    }

    public function get_latest_rule()
    {
       $query = $this->cldb->order_by('id', 'desc')->limit(1)->get_where('basic_filter_rules');
       if ($this->cldb->affected_rows() > 0)
       {
         return  $query->row_array();
       }
       else{
           return false;
       }
    }

    public function negative_pincode_list()
    {
        $query = $this->cldb->get_where('negative_pincode');
        if ($this->cldb->affected_rows() > 0)
        {
           return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function company_list()
    {
        $query = $this->cldb->get_where('p2p_list_company');
        if ($this->cldb->affected_rows() > 0)
        {
            return $query->result_array();
        }
        else{
            return false;
        }
    }

    public function get_age_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, dob")->where($where)->group_by('dob')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
           $results = $query->result_array();
           $fail = 0;
           $success = 0;

           foreach ($results as $result)
           {
               if ($result['dob'] == 0)
               {
                   $fail = $result['total'];
               }
               if ($result['dob'] == 1)
               {
                   $success = $result['total'];
               }
           }
          return array(
              'fail' => $fail,
              'success' => $success,
          );
        }
    }

    public function get_pan_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, pan")->where($where)->group_by('pan')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['pan'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['pan'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_pincode_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, pincode")->where($where)->group_by('pincode')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['pincode'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['pincode'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_Qualification_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, Qualification")->where($where)->group_by('Qualification')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['Qualification'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['Qualification'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_Occupation_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, Occupation")->where($where)->group_by('Occupation')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['Occupation'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['Occupation'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_Company_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, Company")->where($where)->group_by('Company')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['Company'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['Company'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_salary_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, salary")->where($where)->group_by('salary')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['salary'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['salary'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }

    public function get_credit_score_success_fail($where)
    {
        $query = $this->cldb->select("COUNT(id) as total, credit_score")->where($where)->group_by('credit_score')->get_where('borrower_basic_filtration_criteria');
        if ($this->cldb->affected_rows() > 0)
        {
            $results = $query->result_array();
            $fail = 0;
            $success = 0;

            foreach ($results as $result)
            {
                if ($result['credit_score'] == 0)
                {
                    $fail = $result['total'];
                }
                if ($result['credit_score'] == 1)
                {
                    $success = $result['total'];
                }
            }
            return array(
                'fail' => $fail,
                'success' => $success,
            );
        }
    }
}
?>
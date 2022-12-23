<?php
class Updateoccuption extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        exit;
    }

    public function index()
    {
        $this->db->select('id, occuption_id AS occuption');
        $this->db->from('p2p_borrowers_list');
        $query = $this->db->get();
        if($this->db->affected_rows()>0)
        {
            $results = $query->result_array();
            foreach ($results AS $result){
                if($result['occuption'])
                {
                    $arr = '';
                    $occ = '';
                    if($result['occuption'] == 1){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_salaried_details');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0)
                        {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id'=>$result['id'],
                                'occuption_type'=>$result['occuption'],
                                'company_type'=>$occ['employed_company']?$occ['employed_company']:'',
                                'company_name'=>$occ['company_name']?$occ['company_name']:'',
                                'total_experience'=>$occ['total_experience']?$occ['total_experience']:'',
                                'net_monthly_income'=>$occ['net_monthly_income']?$occ['net_monthly_income']:'',
                                'current_emis'=>$occ['current_emis']?$occ['current_emis']:'',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);

                        }

                    }
                    if($result['occuption'] == 2){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_self_business_details');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0)
                        {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id'=>$result['id'],
                                'occuption_type'=>$result['occuption'],
                                'company_type'=>$occ['industry_type']?$occ['industry_type']:'',
                                'company_name'=>'',
                                'total_experience'=>$occ['total_experience']?$occ['total_experience']:'',
                                'net_monthly_income'=>$occ['net_worth']?$occ['net_worth']:'',
                                'current_emis'=>$occ['current_emis']?$occ['current_emis']:'',
                                'turnover_last_year'=>$occ['turnover_last_year']?$occ['turnover_last_year']:'',
                                'turnover_last2_year'=>$occ['turnover_last2_year']?$occ['turnover_last2_year']:'',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }

                    }
                    if($result['occuption'] == 3){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_self_professional_details');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0)
                        {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id'=>$result['id'],
                                'occuption_type'=>$result['occuption'],
                                'company_type'=>$occ['professional_type']?$occ['professional_type']:'',
                                'company_name'=>'',
                                'total_experience'=>$occ['total_experience']?$occ['total_experience']:'',
                                'net_monthly_income'=>$occ['net_worth']?$occ['net_worth']:'',
                                'current_emis'=>$occ['current_emis']?$occ['current_emis']:'',
                                'turnover_last_year'=>$occ['turnover_last_year']?$occ['turnover_last_year']:'',
                                'turnover_last2_year'=>$occ['turnover_last2_year']?$occ['turnover_last2_year']:'',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }

                    }
                    if($result['occuption'] == 4){
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_retired_details');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0) {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id' => $result['id'],
                                'occuption_type'=>$result['occuption'],
                                'company_type' => $occ['employed_company'] ? $occ['employed_company'] : '',
                                'company_name' => $occ['company_name'] ? $occ['company_name'] : '',
                                'total_experience' => $occ['total_experience'] ? $occ['total_experience'] : '',
                                'net_monthly_income' => $occ['net_monthly_income'] ? $occ['net_monthly_income'] : '',
                                'current_emis' => $occ['current_emis'] ? $occ['current_emis'] : '',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }
                        unset($occ);
                        unset($arr);
                    }
                    if($result['occuption'] == 5){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_student_details');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0) {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id' => $result['id'],
                                'occuption_type'=>$result['occuption'],
                                'company_type' => $occ['pursuing'] ? $occ['pursuing'] : '',
                                'company_name' => $occ['institute_name'] ? $occ['institute_name'] : '',
                                'net_monthly_income' => $occ['net_monthly_income'] ? $occ['net_monthly_income'] : '',
                                'current_emis' => $occ['current_emis'] ? $occ['current_emis'] : '',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }

                    }
                    if($result['occuption'] == 6){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_homemaker');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0) {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id' => $result['id'],
                                'occuption_type'=>$result['occuption'],
                                'net_monthly_income' => $occ['net_monthly_income'] ? $occ['net_monthly_income'] : '',
                                'current_emis' => $occ['current_emis'] ? $occ['current_emis'] : '',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }

                    }
                    if($result['occuption'] == 7){
                        unset($occ);
                        unset($arr);
                        $this->db->select('*');
                        $this->db->from('p2p_borrower_others');
                        $this->db->where('borrower_id', $result['id']);
                        $query = $this->db->get();
                        if($this->db->affected_rows()>0) {
                            $occ = (array)$query->row();
                            $arr = array(
                                'borrower_id' => $result['id'],
                                'occuption_type'=>$result['occuption'],
                                'net_monthly_income' => $occ['net_monthly_income'] ? $occ['net_monthly_income'] : '',
                                'current_emis' => $occ['current_emis'] ? $occ['current_emis'] : '',
                            );
                            $this->db->insert('p2p_borrower_occuption_details', $arr);
                        }

                    }
                    unset($arr);
                    unset($occ);
                }

            }
        }
        else{
            return false;
        }
    }
}
?>

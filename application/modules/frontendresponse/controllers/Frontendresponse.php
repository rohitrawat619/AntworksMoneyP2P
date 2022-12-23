<?php
class Frontendresponse extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Frontresponsemodel');
    }

    public function index()
    {
        echo "Direct access Not Access";  exit;
    }

    public function city_list()
    {

        $scode = $this->input->post('state');
        $citylist = $this->Frontresponsemodel->city_list_statcode($scode);
        if($citylist){
            echo '<option value="">Select City</option>';
            $aa="";
            foreach($citylist as $row)
            {
                echo '<option value="'.$row['city_name'].'">'.$row['city_name'].'</option>';
            }
        }


        exit;
    }

    public function company_list_search()
    {
        $this->load->database();
        $q=$_POST["q"];
        $hint="";

        $this->db->select('*');
        $this->db->from('p2p_list_company');
        $this->db->like('company_name',$q, 'after');
        $this->db->limit(4);
        $query = $this->db->get();
        if($this->db->affected_rows()>0) {
            $res = $query->result_array();
            $hint = "<ul>";
            $i = 1;
            if ($res) {
                foreach ($res as $row) {
                    $hint .= '<li id="ls1' . $i . '" onClick="livesearchbox1(' . $i . ')">' . $row['company_name'] . '</li>';
                    $i++;
                }
                $hint .= "</ul>";
                $response = $hint;
            } else {
                $response = '<li id="ls11" onClick="livesearchbox1(1)">' . $this->input->post('q') . '</li>';
            }
        }
        else {
            $response = '<ul><li id="ls11" onClick="livesearchbox1(1)">' . $this->input->post('q') . '</li></ul>';
        }

        //output the response
        echo $response;
    }

    public function sendOTP()
    {
        $this->load->database();
        if(!empty($_POST['mobile'])){
            $arr=array();
            $number = $_POST['mobile'];
            $otp = rand(100000,999999);

            $this->db->select('*');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->where('date_added >= now() - INTERVAL 1 DAY');
            $query = $this->db->get();
            if($this->db->affected_rows()>0)
            {
                $result = count($query->result_array());
                if($result>3)
                {

                    echo 3; exit;
                }
                else{
                    $arr["mobile"]=$number;
                    $arr["otp"]=$otp;
                    $query = $this->db-> insert('p2p_otp_details_table',$arr);
                }

            }
            else{
                $arr["mobile"]=$number;
                $arr["otp"]=$otp;
                $query = $this->db-> insert('p2p_otp_details_table',$arr);
            }



            $msg = "Your One Time Password (OTP) for Antworks P2P Mobile number Verification is $otp DO NOT SHARE THIS WITH ANYBODY - ANTWORKS P2P";
            $message = rawurlencode($msg);

            // Prepare data for POST request
            $data = array('username' => $this->username, 'hash' => $this->hash_api, 'numbers' => $number, "sender" => $this->sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            // Create session for verifying number


            echo 1; exit;
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }

    public function verify_mobile()
    {
        $this->load->database();
        if (!empty($_POST['mobile']) && !empty($_POST['otp'])) {
            $number = $_POST['mobile'];
            $otp = $_POST['otp'];
            $data = array(
                'csrf_token' => $this->security->get_csrf_hash(),
            );
            $this->db->select('otp, ROUND((UNIX_TIMESTAMP() - UNIX_TIMESTAMP(date_added)) / 60) AS MINUTE');
            $this->db->from('p2p_otp_details_table');
            $this->db->where('mobile', $number);
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $query = $this->db->get();
            if ($this->db->affected_rows() > 0) {
                $result = $query->row();
                if($otp == $result->otp)
                {
                    if ($result->MINUTE <= 10) {
                        $data['response'] = "verify";
                        $this->db->where('otp', $otp);
                        $this->db->where('mobile', $number);
                        $this->db->delete('p2p_otp_details_table');
                    } else {
                        $data['response'] = "OTP Expired, Please Resend and try again";
                    }
                }
                else{
                    $data['response'] = "OTP Not Verified";
                }

            } else {
                $data['response'] = "OTP Not Verified";
            }
            echo json_encode($data);
            exit;

        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
            exit;
        }
    }

    public function check_email_availability()
    {
        $this->load->database();
        if(!empty($_POST['email'])){
            $this->db->select('email');
            $this->db->from('p2p_borrowers_list');
            $this->db->where('email',$_POST['email']);
            $this->db->get();
            if($this->db->affected_rows()>0)
            {
                echo "No";
            }
            else
            {
                $this->db->select('email');
                $this->db->from('p2p_lender_list');
                $this->db->where('email',$_POST['email']);
                $this->db->get();
                if($this->db->affected_rows()>0)
                {
                    echo "No";
                }
                else{
                    echo "Yes";
                }

            }
        }
        else{
            echo "OOPS! You do not have Direct Access. Please Login";
        }
    }


}
?>
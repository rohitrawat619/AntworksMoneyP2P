<?php
require APPPATH.'third_party/razorpay-php/Razorpay.php';
use Razorpay\Api\Api;
class Repayment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('P2padminmodel');
        $this->load->model('Requestmodel');
		if( $this->session->userdata('admin_state') == TRUE &&  $this->session->userdata('role') == 'admin' ){

		}
		else{
			$msg="Your session had expired. Please Re-Login";
			$this->session->set_flashdata('notification',array('error'=>1,'message'=>$msg));
			redirect(base_url().'login/admin-login');
		}
    }

    public function index()
    {
        echo "OOPS! You do not have Direct Access. Please Login"; exit;
    }

    public function initiateEnach()
    {
        $query = $this->db->select('BL.email, BL.mobile, BL.name')
            ->from('p2p_borrowers_list AS BL')
            ->where('BL.id',$this->input->post('borrowerId'))
            ->get();
        if($this->db->affected_rows()>0)
        {
            $borrowerInfo = (array)$query->row();
            $query = $this->db->select('PB.bank_name, PB.account_number, PB.ifsc_code, PB.bank_account_response, WB.bank_code')
                ->join('p2p_whats_banks AS WB', 'WB.value = PB.bank_name')
                ->from('p2p_borrower_bank_details AS PB')
                ->where('PB.borrower_id',$this->input->post('borrowerId'))
//                ->where('PB.primary_account',1)
                ->where('WB.bank_code IS NOT NULL')
                ->get();
            if($this->db->affected_rows()>0)
            {
                $bank_details = (array)$query->row();
                $borrower_name_json = json_decode($bank_details['bank_account_response'], true);
                $borrower_name = $borrower_name_json['result']['accountName'];
                if(empty($borrower_name)){
                 $borrower_name = $borrowerInfo['name'];
                }
                if($borrower_name){
//                $query = $this->db->get_where('p2p_borrower_enach_response', array('borrower_id' => $this->input->post('borrowerId')));
//                $result = (array)$query->row();

                    $recurring_link = json_encode(array(
                                    'customer'=>array(
                                        "name"=> $borrower_name,
                                        "email"=> $borrowerInfo['email'],
                                        "contact"=> $borrowerInfo['mobile'],
                                    ),
                                    "type" => "link",
                                    "email_notify" => 1,
                                    "sms_notify" => 1,
                                    "expire_by" => strtotime("+30 minutes"),
                                    "description" => "test authorization link",
                                    "currency" => "INR",
                                    "amount" => 0,
                                    "subscription_registration" => array(
                                        "method" => "emandate",
                                        "max_amount" => 9999900,
                                        "auth_type" => "netbanking",
                                        "expire_at" => strtotime("+30 minutes"),
                                        "bank_account" => array(
                                            "bank_name" => $bank_details['bank_code'],
                                            "account_number" => $bank_details['account_number'],
                                            "ifsc_code" => $bank_details['ifsc_code'],
                                            "beneficiary_name" => $borrower_name
                                        )
                                    )
                                   ));

                    $query = $this->db->select('option_value')->get_where('p2p_admin_options', array('option_name'=>'razorpay_repayment_api_keys'));
                    $response_key = (array)$query->row();
                    $result = $this->Requestmodel->getRazorpayRepaymentkeys();
                    $json_key = json_decode($result, true);
                    $api_key = $json_key['razorpay_razorpay_Livekey']['key'];
                    $api_secret = $json_key['razorpay_razorpay_Livekey']['secret_key'];
                    //$data_string = '{"customer":{"name":"DINESH KUMAR SHARMA","email":"dinesh.knmiet@gmail.com","contact":"9910719994"},"type":"link","email_notify":1,"sms_notify":1,"expire_by":1576056403,"description":"test authorization link","currency":"INR","amount":0,"subscription_registration":{"method":"emandate","max_amount":9999900,"auth_type":"netbanking","expire_at":"1576056403","bank_account":{"bank_name":"ICIC","account_number":"025301577385","ifsc_code":"ICIC0000253","beneficiary_name":"DINESH KUMAR SHARMA"}}}';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/subscription_registration/auth_links");
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $recurring_link);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_USERPWD, $api_key.':'.$api_secret);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Accept: application/json',
                            'Content-Type: application/json')
                    );

                    if(curl_exec($ch) === false)
                    {
                        echo 'Curl error: ' . curl_error($ch);
                    }
                    $errors = curl_error($ch);
                    $result = curl_exec($ch);
                    $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    $subs_response = (json_decode($result, true));

                    if($subs_response['id'])
                    {
                      echo  json_encode(array(
                           'status'=>1,
                           'id'=>$subs_response['id'],
                           'short_url'=>$subs_response['short_url'],
                           'msg'=>'Link send successfully'.' Short URL- '.$subs_response['short_url'],
                       ));
						$borrowerId = $this->session->userdata('borrower_id');
						$email = $this->session->userdata('email');
						$name = $this->session->userdata('name');
						$this->Sendemailborrowermodel->information_activating_nach($borrowerId,$name,$email);
                    }
                    else{
                        echo  json_encode(array(
                            'status'=>0,
                            'id'=>'',
                            'short_url'=>'',
                            'msg'=>'Something went wrong'
                        ));
                    }
                   exit;
                }
                else{
                    echo  json_encode(array(
                        'status'=>0,
                        'id'=>'',
                        'short_url'=>'',
                        'msg'=>'Borrower Name Not Found'
                    )); exit;
                }
            }
            else{
                echo  json_encode(array(
                    'status'=>0,
                    'id'=>'',
                    'short_url'=>'',
                    'msg'=>'Bank is not found in razorpay'
                )); exit;
            }
        }
    }
}
?>

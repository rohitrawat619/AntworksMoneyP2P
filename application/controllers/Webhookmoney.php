<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/razorpay-php/Razorpay.php';

use Razorpay\Api\Api;

class Webhookmoney extends CI_Controller
{

	public function index()
	{
		$json = file_get_contents("php://input");
		$result = json_decode($json, true);
		$this->load->model('Requestmodel');
		$result_keys = $this->Requestmodel->getRazorpayRegistrationkeys();
		$keys = (json_decode($result_keys, true));
		if ($keys['razorpay_Testkey']['status'] == 1) {
			$api_key = $keys['razorpay_razorpay_Livekey']['key'];
			$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];
		}
		if ($keys['razorpay_razorpay_Livekey']['status'] == 1) {

			$api_key = $keys['razorpay_razorpay_Livekey']['key'];
			$api_secret = $keys['razorpay_razorpay_Livekey']['secret_key'];

		}
		$api = new Api($api_key, $api_secret);
		$response = $api->Payment->fetch($result['payload']['payment']['entity']['id']);
		if ($response['id'] == $result['payload']['payment']['entity']['id']) {
			$email = $result['payload']['payment']['entity']['email'];
			$mobile = substr($response['contact'], -10, '10');

			//P2P Steps//
			$borrower = (array)$this->db->select('id')->get_where('p2p_borrowers_list', array('email' => $email))->row();
			if ($this->db->affected_rows() > 0) {
				$borrower_id = $borrower['id'];
				$this->db->where('borrower_id', $borrower_id);
				$this->db->set('step_2', 1);
				$this->db->update('p2p_borrower_steps');
				$this->db->select('borrower_id')->get_where('p2p_borrower_registration_payment', array('borrower_id' => $borrower_id))->row();
				if ($this->db->affected_rows() > 0) {

				} else {
					$arr = array(
						'borrower_id' => $borrower_id,
						'razorpay_payment_id' => $result['payload']['payment']['entity']['id'],
						'channel' => 'membership',
					);
					$this->db->insert('p2p_borrower_registration_payment', $arr);
				}
			}
			//End P2P Steps//

			//Antworksmoney Steps
			$lead_id = '';
			$this->money = $this->load->database('money', true);
			$this->money->get_where('p2p_res_borrower_payment', array('payment_id' => $result['payload']['payment']['entity']['id']));
			if ($this->money->affected_rows() > 0) {
				$arr_response = array('status' => 0, 'msg' => 'Already Request done');
			} else {
				$query = $this->money->select('id')->get_where('ant_all_leads', array('mobile' => $mobile));
				if ($this->money->affected_rows() > 0) {
					$lead_id = $query->row()->id;

					$this->money->where('id', $lead_id);
					$this->money->set('status', 15);
					$this->money->update('ant_all_leads');
				}
				$arr_money = array(
					'lead_id' => $lead_id ? $lead_id : '',
					'payment_id' => $result['payload']['payment']['entity']['id'],
					'mobile' => $mobile,
					'email' => $email,
					'amount' => $result['payload']['payment']['entity']['amount'] / 100,
					'created_date' => date('Y-m-d H:i:s')
				);
				$this->money->insert('p2p_res_borrower_payment', $arr_money);
				//Antworksmoney Steps End
				$arr_response = array('status' => 1, 'msg' => 'Update Successfully');
			}

		} else {
			$arr_response = array('status' => 0, 'msg' => 'Invalid Request');
		}

		echo json_encode($arr_response);
		exit;

	}
}

?>

<?
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('valid_email'))
{
	/**
	 * Validate email address
	 *
	 * @deprecated	3.0.0	Use PHP's filter_var() instead
	 * @param	string	$email
	 * @return	bool
	 */
	function valid_email($email)
	{
		return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
	}
}

// ------------------------------------------------------------------------
if ( ! function_exists('unique_email'))
{
	/**
	 * Validate email address
	 *
	 * @deprecated	3.0.0	Use PHP's filter_var() instead
	 * @param	string	$email
	 * @return	bool
	 */
	function unique_email($str,$email)
	{
		$arr = explode(".",$str);
		$table = $arr[0];
		$field = $arr[1];
		$ci = & get_instance();
		$ci->load->database();
		$query = $ci->db->query("select ".$field." from ".$table." where ".$field."='$email'");
		$res = $query->result();
		if($res)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

if(!function_exists('getNotificationHtml'))
{
	function getNotificationHtml()
	{
		$ci = & get_instance();
		echo '<div class="mypop-alert">';
		if( $ci->session->flashdata('notification'))
		{

			$notificationData = $ci->session->flashdata('notification');
			if( $notificationData['error'] == 0 )
			{
				echo '<div class="alert mypop-alert-content alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$notificationData['message'].'</div>';
			}
			elseif( $notificationData['error'] == 1 )
			{
				echo '<div class="alert mypop-alert-content alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'.$notificationData['message'].'</div>';
			}
		}
		if( $ci->session->flashdata('validation_errors'))
		{
			$errorData = $ci->session->flashdata('validation_errors');
			if($errorData['error'] == 1)
			{
				echo '<div class="alert mypop-alert-content alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
				foreach($errorData['message'] as $key => $value)
				{
					echo $value."<br>";
				}
				echo '</div>';
			}
		}
		echo '</div>';
	}
}
if(!function_exists('create_lender_id'))
{
   function create_lender_id()
    {
		$ci = & get_instance();
		$ci->load->database();
        $ci->db->select("lender_id");
        $ci->db->from('p2p_lender_list');
        $ci->db->order_by('lender_id', 'DESC');
        $ci->db->limit(1);
        $query = $ci->db->get();
        $row = (array)$query->row();
        if($ci->db->affected_rows()>0)
        {
            $lid = $row['lender_id'];
            $lid++;
           return $lender_id = $lid;
        }
        else
        {
           return $lender_id = "LR10000001";
        }
    }
}
if(!function_exists('create_borrower_id'))
{
	 function create_borrower_id()
		{
			$ci = & get_instance();
		    $ci->load->database();
			
			$ci->db->select("id");
			$ci->db->order_by('id', 'DESC');
			$ci->db->limit(1);
			$query = $ci->db->get('p2p_borrowers_list');
			$row = (array)$query->row();
			if($ci->db->affected_rows()>0)
			{
				$borrwer_last_register_id = $row['id'];
				$bid = 10000000 + $borrwer_last_register_id + 1;
				return $borrower_id  = "BR".$bid;

			}
			else
			{
				return $borrower_id = "BR10000001";
			}
		}
}

if(!function_exists('pr'))
{
    function pr($request)
    {
        echo "<pre>";
        print_r($request); exit;
    }
}
#For credit-line 18-01-24
if(!function_exists('generateAnt_Order')){
    function generateAnt_Order($data){
        $ci = & get_instance();
        $last_transactionNo = $ci->db->select('transaction_no')->order_by('id', 'desc')->limit(1)->get_where('p2p_order_list')->row()->transaction_no;
        $last_6_digit = substr($last_transactionNo, -6);
        $last_6_digit = str_pad($last_6_digit + 1, 6, 0, STR_PAD_LEFT);
        $txn = 'ANT'. date('ymd'). $last_6_digit;
        $data['transaction_no'] = $txn;
        $data['status'] = $data['status'] ?? 'initialize';
        $data['ip_address'] = $ci->input->ip_address();
        $ci->db->insert('p2p_order_list', $data);
        return $txn;
    }
}


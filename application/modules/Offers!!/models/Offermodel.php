<?php

class Offermodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->app = $this->load->database('app', true);
	}

	public function getcategory()
	{
		$query = $this->app->get_where('offer_categories', array('category_status' => 1));
		if ($this->app->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getApppages()
	{
		$query = $this->app->get_where('offer_app_page', array('page_status' => 1));
		if ($this->app->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getOffers()
	{
		$results = $this->app->order_by('ol.id', 'desc')->select('ol.id, ol.offer_name, 
		oc.category_name, ol.offer_type, ol.coupon_code_type, 
		ol.offer_icon_img,
		ol.offer_banner_img,
		ol.company_icon_img,
		ol.offer_url,
		 ol.status')
			->join('offer_categories oc', 'on ol.category_id = oc.id', 'left')
			->get_where('offer_list ol')->result_array();
		foreach ($results as $result) {
			$response[] = array(
				'id' => $result['id'],
				'offer_name' => $result['offer_name'],
				'category_name' => $result['category_name'],
				'offer_type' => $result['offer_type'],
				'coupon_code_type' => $result['coupon_code_type'],
				'offer_icon_img' => $result['offer_icon_img'] ? base_url('offers-img/') . $result['offer_icon_img'] : "",
				'offer_banner_img' => $result['offer_banner_img'] ? base_url('offers-img/') . $result['offer_banner_img'] : "",
				'company_icon_img' => $result['company_icon_img'] ? base_url('offers-img/') . $result['company_icon_img'] : "",
				'offer_url' => $result['offer_url'],
				'status' => $result['status'],
			);
		}
		return $response;

	}

	public function getOfferdetails($id)
	{
		$result_offer = $this->app->get_where('offer_list', array('id' => $id))->row_array();
		$result['offer_details'] = array(
			'id' => $result_offer['id'],
			'offer_name' => $result_offer['offer_name'],
			'category_id' => $result_offer['category_id'],
			'offer_type' => $result_offer['offer_type'],
			'coupon_code_type' => $result_offer['coupon_code_type'],
			'offer_validity' => $result_offer['offer_validity'],
			'discount_reward_type' => $result_offer['discount_reward_type'],
			'min_transaction_amount' => $result_offer['min_transaction_amount'],
			'max_transaction_amount' => $result_offer['max_transaction_amount'],
			'discount_worth' => $result_offer['discount_worth'],
			'max_reward' => $result_offer['max_reward'],
			'payment_method' => $result_offer['payment_method'],
			'bank' => $result_offer['bank'],
			'bin_inn' => $result_offer['bin_inn'],
			'offer_short_description' => $result_offer['offer_short_description'],
			'offer_long_description' => $result_offer['offer_long_description'],
			'term_condition' => $result_offer['term_condition'],
			'about_company' => $result_offer['about_company'],
			'offer_icon_img' => $result_offer['offer_icon_img'] ? base_url('offers-img/') . $result_offer['offer_icon_img'] : "",
			'offer_banner_img' => $result_offer['offer_banner_img'] ? base_url('offers-img/') . $result_offer['offer_banner_img'] : "",
			'company_icon_img' => $result_offer['company_icon_img'] ? base_url('offers-img/') . $result_offer['company_icon_img'] : "",
			'offer_url' => $result_offer['offer_url'],
			'status' => $result_offer['status'],
		);

		$result['couponIds'] = $this->getCouponcode($id);

		return $result;
	}

	public function get_offer_bank()
	{
		$query = $this->app->get_where('offer_bank');
		if ($this->app->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function get_offer_payment_method()
	{
		$query = $this->app->get_where('offer_payment_method');
		if ($this->app->affected_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	public function getCouponcode($offerId)
	{
		return $this->app->select('coupon_code')->get_where('offer_coupon_code_list', array('offer_id' => $offerId))->result_array();
	}

	public function addOffer()
	{

		$config['upload_path'] = "offers-img";
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['encrypt_name'] = TRUE;
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		if ($this->upload->do_upload("offer_icon_img")) {
			$data_offer_icon_img = $this->upload->data();
		}
		if ($this->upload->do_upload("offer_banner_img")) {
			$data_offer_banner_img = $this->upload->data();
		}
		if ($this->upload->do_upload("company_icon_img")) {
			$data_company_icon_img = $this->upload->data();
		}
		$offer = array(
			"offer_name" => $this->input->post("offer_name"),
			"category_id" => $this->input->post("category_id"),
			"offer_type" => $this->input->post("offer_type"),
			"offer_validity" => $this->input->post("offer_validity"),
			"coupon_code_type" => $this->input->post("coupon_code_type"),
			"discount_reward_type" => $this->input->post("discount_reward_type"),
			"min_transaction_amount" => $this->input->post("min_transaction_amount"),
			"max_transaction_amount" => $this->input->post("max_transaction_amount"),
			"discount_worth" => $this->input->post("discount_worth"),
			"max_reward" => $this->input->post("max_reward"),
			"payment_method" => json_encode($this->input->post("payment_method")),
			"bank" => json_encode($this->input->post("bank")),
			"bin_inn" => $this->input->post("bin_inn"),
			"offer_short_description" => $this->input->post("offer_short_description"),
			"offer_long_description" => $this->input->post("offer_long_description"),
			"term_condition" => $this->input->post("term_condition"),
			"about_company" => $this->input->post("about_company"),
			"offer_url" => $this->input->post("offer_url"),
			"status" => $this->input->post("status"),
			"offer_icon_img" => $data_offer_icon_img['file_name'] ? $data_offer_icon_img['file_name'] : '',
			"offer_banner_img" => $data_offer_banner_img['file_name'] ? $data_offer_banner_img['file_name'] : '',
			"company_icon_img" => $data_company_icon_img['file_name'] ? $data_company_icon_img['file_name'] : '',
		);

		$this->app->insert('offer_list', $offer);
		if($this->app->affected_rows() > 0){
			$offer_id = $this->app->insert_id();
			if($this->input->post('home_position'))
			{
				$arr_home_position = array(
					'offer_id' => $offer_id,
					'app_page_name' => 'home',
					'offer_position' => $this->input->post("home_position"),
				);
                $this->app->insert('offer_app_display_position', $arr_home_position);
			}
			if($this->input->post('offer_page_position'))
			{
				$arr_offer_position = array(
					'offer_id' => $offer_id,
					'app_page_name' => 'offer',
					'offer_position' => $this->input->post("offer_page_position"),
				);
				$this->app->insert('offer_app_display_position', $arr_offer_position);
			}
			if($this->input->post('app_page_name'))
			{

				$page_count = count($this->input->post('app_page_name'));
				for ($i = 0; $i<= $page_count; $i++)
				{
					if($this->input->post('app_page_name')[$i] && $this->input->post('app_page_position')[$i])
					{
						$arr_page_position = array(
							'offer_id' => $offer_id,
							'app_page_name' => $this->input->post('app_page_name')[$i],
							'offer_position' => $this->input->post('app_page_position')[$i],
						);
						$this->app->insert('offer_app_display_position', $arr_page_position);
					}

				}
			}

			if($this->input->post("coupon_code_type") == 'Single')
			{
				$this->app->insert('offer_coupon_code_list', array('offer_id' => $offer_id, 'coupon_code' => $this->input->post('coupon_code')));
			}

			return true;
		}
		else{
			return false;
		}
	}

	public function updateOffer()
	{
		$config['upload_path'] = "offers-img";
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['encrypt_name'] = TRUE;
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		$offer = array(
			"offer_name" => $this->input->post("offer_name"),
			"category_id" => $this->input->post("category_id"),
			"offer_type" => $this->input->post("offer_type"),
			"offer_validity" => $this->input->post("offer_validity"),
			"coupon_code_type" => $this->input->post("coupon_code_type"),
			"discount_reward_type" => $this->input->post("discount_reward_type"),
			"min_transaction_amount" => $this->input->post("min_transaction_amount"),
			"max_transaction_amount" => $this->input->post("max_transaction_amount"),
			"discount_worth" => $this->input->post("discount_worth"),
			"max_reward" => $this->input->post("max_reward"),
			"payment_method" => json_encode($this->input->post("payment_method")),
			"bank" => json_encode($this->input->post("bank")),
			"bin_inn" => $this->input->post("bin_inn"),
			"offer_short_description" => $this->input->post("offer_short_description"),
			"offer_long_description" => $this->input->post("offer_long_description"),
			"term_condition" => $this->input->post("term_condition"),
			"about_company" => $this->input->post("about_company"),
			"offer_url" => $this->input->post("offer_url"),
			"status" => $this->input->post("status"),
		);

		if ($this->upload->do_upload("offer_icon_img")) {
			$data_offer_icon_img = $this->upload->data();
			$offer['offer_icon_img'] = $data_offer_icon_img['file_name'];
		}
		if ($this->upload->do_upload("offer_banner_img")) {
			$data_offer_banner_img = $this->upload->data();
			$offer['offer_banner_img'] = $data_offer_banner_img['file_name'];
		}
		if ($this->upload->do_upload("company_icon_img")) {
			$data_company_icon_img = $this->upload->data();
			$offer['company_icon_img'] = $data_company_icon_img['file_name'];
		}

		$this->app->where('id', $this->input->post('offer_id'));
		$this->app->update('offer_list', $offer);

		//Coupon --
		$this->app->where('offer_id', $this->input->post('offer_id'));
		$this->app->delete('offer_coupon_code_list');
		if($this->input->post("coupon_code_type") == 'Single')
		{
			$this->app->insert('offer_coupon_code_list', array('offer_id' => $this->input->post('offer_id'), 'coupon_code' => $this->input->post('coupon_code')));
		}
		//End Coupon
		//App Position
		$this->app->where('offer_id', $this->input->post('offer_id'));
		$this->app->delete('offer_app_display_position');
		if($this->input->post('home_position'))
		{
			$arr_home_position = array(
				'offer_id' => $this->input->post('offer_id'),
				'app_page_name' => 'home',
				'offer_position' => $this->input->post("home_position"),
			);
			$this->app->insert('offer_app_display_position', $arr_home_position);
		}
		if($this->input->post('offer_page_position'))
		{
			$arr_offer_position = array(
				'offer_id' => $this->input->post('offer_id'),
				'app_page_name' => 'offer',
				'offer_position' => $this->input->post("offer_page_position"),
			);
			$this->app->insert('offer_app_display_position', $arr_offer_position);
		}
		if($this->input->post('app_page_name'))
		{

			$page_count = count($this->input->post('app_page_name'));
			for ($i = 0; $i<= $page_count; $i++)
			{
				if($this->input->post('app_page_name')[$i] && $this->input->post('app_page_position')[$i])
				{
					$arr_page_position = array(
						'offer_id' => $this->input->post('offer_id'),
						'app_page_name' => $this->input->post('app_page_name')[$i],
						'offer_position' => $this->input->post('app_page_position')[$i],
					);
					$this->app->insert('offer_app_display_position', $arr_page_position);
				}

			}
		}
        //End
	    return true;
	}

	public function addCategory()
	{
		$this->app->get_where('offer_categories', array('category_name' => $this->input->post('add_category_name')));
		if ($this->app->affected_rows() > 0) {
			return $response = array(
				'status' => 0,
				'msg' => 'Category already exist',
			);
		} else {
			$this->app->insert('offer_categories', array('category_name' => $this->input->post('add_category_name'), 'category_status' => 1));
			if ($this->app->affected_rows() > 0) {
				return $response = array(
					'status' => 1,
					'msg' => 'Category added successfully',
				);
			} else {
				return $response = array(
					'status' => 0,
					'msg' => 'Something went wrong please try again',
				);
			}
		}

	}

	public function addApppage()
	{
		$this->app->get_where('offer_app_page', array('app_page' => $this->input->post('add_app_page')));
		if ($this->app->affected_rows() > 0) {
			return $response = array(
				'status' => 0,
				'msg' => 'Page already exist',
			);
		} else {
			$this->app->insert('offer_app_page', array('app_page' => $this->input->post('add_app_page'), 'page_status' => 1, 'created_date' => date('Y-m-d H:i:s')));
			if ($this->app->affected_rows() > 0) {
				return $response = array(
					'status' => 1,
					'msg' => 'Page added successfully',
				);
			} else {
				return $response = array(
					'status' => 0,
					'msg' => 'Something went wrong please try again',
				);
			}
		}

	}

	public function getHomeposition($offerId)
	{
		return $this->app->get_where('offer_app_display_position', array('offer_id' => $offerId, 'app_page_name' => 'home'))->row_array();
	}

	public function getOfferposition($offerId)
	{
		return $this->app->get_where('offer_app_display_position', array('offer_id' => $offerId, 'app_page_name' => 'offer'))->row_array();
	}

	public function getApppageposition($offerId)
	{
		return $this->app->where('app_page_name !=',  'offer')->get_where('offer_app_display_position', array('offer_id' => $offerId, 'app_page_name !=' =>  'home', ))->result_array();
		echo "<pre>"; echo $this->app->last_query(); exit;
	}

}

?>

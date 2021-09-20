<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller  {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('api');
		$this->load->model('api_modal', 'api');
	}

	private $table = 'students';

	public function send_otp()
	{
		post();
		verifyRequiredParams(['mobile']);
		$post = [
			'mobile' => $this->input->post('mobile'),
			'otp'	 => rand(1000, 9999),
			'otp'	 => 1234,
			'expiry' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
		];

		if ($this->main->check('otp_check', ['mobile' => $post['mobile']], 'mobile'))
		 	$id = $this->main->update(['mobile' => $post['mobile']], $post, 'otp_check');
		else
		 	$id = $this->main->add($post, 'otp_check');
		
		if ($id) {
			/*$sms = 'Your OTP is : '.$post['otp'];
			send_otp($post['mobile'], $sms);*/
			$response["valid"] = true;
            $response['message'] = "OTP send successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "OTP send not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function otp_check()
	{
		post();
		verifyRequiredParams(['mobile', 'otp']);
		$post = [
			'mobile' => $this->input->post('mobile'),
			'otp' => $this->input->post('otp'),
			'expiry >=' => date('Y-m-d H:i:s')
		];
		
		if ($this->main->check('otp_check', $post, 'mobile')) {
			$this->main->delete('otp_check', $post);
			$u_id = $this->main->get($this->table, 'id, name, mobile, email, address, free_membership, free_used', ['mobile' => $post['mobile']]);
			if (!$u_id) {
				$id = $this->main->add(['mobile' => $post['mobile']], $this->table);
				$u_id = $this->main->get($this->table, 'id, name, mobile, email, address, free_membership, free_used', ['id' => $id]);
			}
			$response["row"] = $u_id;
			$response["valid"] = true;
            $response['message'] = "OTP check successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Invalid OTP. Try again.";
            echoResponse(400, $response);
		}
	}

	public function banner_list()
	{
		get();
		if ($row = $this->api->banner_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Banner list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Banner list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function ebook_list()
	{
		get();
		if ($row = $this->api->ebook_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Ebook list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Ebook list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function profile()
	{
		get();
		$api = authenticate($this->table);
		$row = $this->main->get($this->table, 'name, mobile, email, address, free_membership, free_used', ['id' => $api]);
		$row['membership'] = $this->main->check('buy_membership', ['u_id' => $api, 'expiry >=' => date('Y-m-d H:i:s')], 'expiry');
		
		if ($row) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Profile successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Profile not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function update_profile()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['name', 'address', 'email', 'mobile']);
		
		if($this->main->check($this->table, ['mobile' => $this->input->post('mobile'), 'id != ' => $api], 'id')){
			$response["valid"] = false;
            $response['message'] = "Mobile already in use.";
            echoResponse(400, $response);
		}
		
		if($this->main->check($this->table, ['email' => $this->input->post('email'), 'id != ' => $api], 'id')){
			$response["valid"] = false;
            $response['message'] = "Email already in use.";
            echoResponse(400, $response);
		}
		
		$post = [
                    'name'     => $this->input->post('name'),
                    'mobile'   => $this->input->post('mobile'),
                    'email'    => $this->input->post('email'),
                    'address'  => $this->input->post('address')
                ];

		if ($row = $this->main->update(['id' => $api], $post, $this->table)) {
			$response["valid"] = true;
            $response['message'] = "Update profile successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Update profile not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function buy_ebook()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['name', 'address', 'pincode', 'mobile', 'city', 'book_id']);
		
		$book = $this->main->get('ebook', '(price * (100 - discount) / 100) price, del_charge', ['id' => $this->input->post('book_id')]);
		
		$post = [
					'mobile'  	 => $this->input->post('mobile'),
					'name'    	 => $this->input->post('name'),
					'address' 	 => $this->input->post('address'),
					'pincode' 	 => $this->input->post('pincode'),
					'city'    	 => $this->input->post('city'),
					'book_id' 	 => $this->input->post('book_id'),
					'price'	  	 => $book['price'],
					'del_charge' => $book['del_charge'],
					'u_id'    	 => $api
                ];

		if ($row = $this->main->add($post, 'buy_ebook')) {
			$response["valid"] = true;
            $response['message'] = "Buy ebook successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Buy ebook not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function membership_list()
	{
		get();
		if ($row = $this->api->membership_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Membership list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Membership list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function buy_membership()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['mem_id',	'payment', 'pay_type']);
		
		$expiry = $this->main->get('membership', 'CONCAT(duration, " ", duration_type) duration', ['id' => $this->input->post('mem_id')]);
		
		$post = [
			'pay_type' => $this->input->post('pay_type'),
			'payment'  => $this->input->post('payment'),
			'expiry'   => date('Y-m-d H:i:s', strtotime($expiry['duration'])),
			'mem_id'   => $this->input->post('mem_id'),
			'u_id'     => $api
		];

		if ($row = $this->main->add($post, 'buy_membership')) {
			$response["valid"] = true;
            $response['message'] = "Buy membership successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Buy membership not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function buy_free_membership()
	{
		get();
		$api = authenticate($this->table);
		
		$post = [
			'free_membership' => date('Y-m-d H:i:s', strtotime('+1 Day')),
			'free_used'		  => '1'
		];
		
		if ($row = $this->main->update(['id' => $api], $post, $this->table)) {
			$response["row"] = $post;
			$response["valid"] = true;
            $response['message'] = "Free membership successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Free membership not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function course()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->api->get('course', 'title, sub_title, price, dicount_price, discount, details', [])) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Course details successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Course details not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function module_list()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->api->getall('modules', 'id, title, sub_title, price, details', ['is_deleted' => 0])) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Module list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Module list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function video_list()
	{
		get();
		$api = authenticate($this->table);
		verifyRequiredParams(['module_id']);

		if ($row = $this->api->video_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Module list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Module list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function question_list()
	{
		get();
		$api = authenticate($this->table);
		verifyRequiredParams(['language', 'video_id', 'test_type']);

		if ($row = $this->api->question_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Question list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Question list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}
}
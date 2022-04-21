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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
		}
	}

	public function chapter_list()
	{
		get();
		verifyRequiredParams(['book_id']);

		if ($row = $this->api->chapter_list($this->input->get())) {
			/* re($row);
			$row = array_map(function($arr){
				// $ch_id = $arr['ch_id'] == 0 ? $arr['id'] : $arr['ch_id'];
				// $sc_id = $arr['ch_id'] == 0 ? $arr['ch_id'] : $arr['id'];
				
				$return = [
						'id' => $arr['id'],
						'title' => $arr['title'],
						// 'ch_id' => $arr['ch_id'],
						'books' => $this->api->get_book($arr['id']),
					];
				// $return['sub_ch'] = $arr['ch_id'] == 0 ? $this->api->chapter_list($arr['id']) : [];
				return $return;
			}, $row); */

			$response["base_url"] = base_url();
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Chapter list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Chapter list not successfull. Try again.";
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
		}
		
		if($this->main->check($this->table, ['email' => $this->input->post('email'), 'id != ' => $api], 'id')){
			$response["valid"] = false;
            $response['message'] = "Email already in use.";
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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
            echoResponse(200, $response);
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

		if ($row = $this->main->add($post, 'buy_membership') && $this->main->update(['id' => $api], ['registered' => 1], $this->table)) {
			$response["valid"] = true;
            $response['message'] = "Buy membership successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Buy membership not successfull. Try again.";
            echoResponse(200, $response);
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
            echoResponse(200, $response);
		}
	}

	public function course()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->api->get('course', "title, sub_title, details, CONCAT('".base_url('uploads/')."', video) video", [])) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Course details successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Course details not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function module_list()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->api->getall('modules', 'id, title, sub_title, details', ['is_deleted' => 0])) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Module list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Module list not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function video_list()
	{
		get();
		$api = authenticate($this->table);
		verifyRequiredParams(['module_id']);

		if ($row = $this->api->video_list()) {
			$html = "<!DOCTYPE html><html><head><link rel='stylesheet' type='text/css' href='".base_url()."assets/back/ckeditor/fonts.css'></head><body>";
			foreach ($row as $k => $v) {
				$row[$k]['hindi_pdf'] = $html.$row[$k]['hindi_pdf'].'</body></html>';
				$row[$k]['guj_pdf'] = $html.$row[$k]['guj_pdf'].'</body></html>';
			}
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Video list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Video list not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function free_video_list()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->api->free_video_list()) {
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Video list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Video list not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function question_list()
	{
		get();
		$api = authenticate($this->table);
		verifyRequiredParams(['video_id', 'test_type']);

		if ($row['question'] = $this->api->question_list($api)) {
			$row['repeat'] = explode(',', $this->main->check('multi_words', [], 'words'));
			$response["row"] = $row;
			$response["valid"] = true;
            $response['message'] = "Question list successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Question list not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function question_answer()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['que_id', 'result', 'video_id']);

		if ($this->api->question_answer($api)) {
			$response["valid"] = true;
            $response['message'] = "Answer save successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Answer save not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function question_reset()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['video_id']);
		
		$post = [
			'video_id' => $this->input->post('video_id'),
			'reset'	   => 0,
			'u_id' 	   => $api
		];

		if ($this->api->update($post, ['reset' => 1], 'que_user')) {
			$response["valid"] = true;
            $response['message'] = "Reset successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Reset not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function view_video()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['video_id']);

		if ($this->api->view_video($api)) {
			$response["valid"] = true;
            $response['message'] = "View video successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "View video not successfull. Try again.";
            echoResponse(200, $response);
		}
	}

	public function user_analysis()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['page_name']);
		
		$post = [
			'page_name'   => $this->input->post('page_name'),
			'u_id'	      => $api,
			'date_time'   => time()
		];

		if ($this->api->add($post, 'user_analysis')) {
			$response["valid"] = true;
            $response['message'] = "Data save successfull.";
            echoResponse(200, $response);
		}else{
			$response["valid"] = false;
            $response['message'] = "Data save not successfull. Try again.";
            echoResponse(200, $response);
		}
	}
}
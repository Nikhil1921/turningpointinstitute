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
			$u_id = $this->main->check($this->table, ['mobile' => $post['mobile']], 'id');
			$response["row"] = $u_id ? $u_id : (string) $this->main->add(['mobile' => $post['mobile']], $this->table);
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
                    'address'    => $this->input->post('address')
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
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller  {

	public function index()
	{
		return $this->template->load('template', 'home');
	}

	public function error_404()
	{
		return $this->load->view('error_404');
	}
}
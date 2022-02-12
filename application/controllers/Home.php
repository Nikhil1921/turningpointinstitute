<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller  {

	public function index()
	{
		// 336
		return $this->template->load('template', 'home');
	}
	
	public function word_game()
	{
		return $this->template->load('template', 'word_game');
	}
	
	public function pdf(int $id, string $pdf)
	{
		$data['data'] = $this->main->get('module_video', $pdf." pdf", ['id' => $id]);
		
		return $this->load->view('pdf', $data);
	}

	public function error_404()
	{
		return $this->load->view('error_404');
	}
}
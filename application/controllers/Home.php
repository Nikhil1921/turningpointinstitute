<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller  {

	public function index()
	{
		/*echo "sdsd";
	    $conn = mysqli_connect("localhost", "denseeqq_turnihyi_wp51634", "tpenglish@123", "denseeqq_turningapp");
	    
		$query = "SELECT * FROM core_users";
		$result = mysqli_query($conn, $query);
		while($data = mysqli_fetch_assoc($result))
		{
		    $post = [
    			'name' => $data['stunm'],
    			'mobile' => $data['stuphone'],
    			'address' => $data['address'],
    			'free_membership' => null,
    			'free_used' => 0,
    			'admin_id' => 0,
    			'assign_id' => 0,
    			'registered' => 1,
    			'is_deleted	' => 0,
    		];
    		
    		$this->main->add($post, 'students');
		}
		re($result);*/
		
	    return redirect(admin());
		return $this->template->load('template', 'home');
	}
	
	public function word_game()
	{
		return $this->template->load('template', 'word_game');
	}

	public function video(int $video)
	{
	    $data['video'] = $video;
		return $this->load->view('video', $data);
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
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Admin_Controller extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->auth = $this->session->auth;
		if (!$this->auth) 
			return redirect(admin('login'));

		$this->load->model('main_model', 'main');
		$this->redirect = admin($this->redirect);
		$this->user = $this->main->get('users', '*', ['id' => $this->auth]);
	}

    protected function uploadImage($upload)
    {
        $this->load->library('upload');
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => 'jpg|jpeg|png',
                'file_name'        => time(),
                'file_ext_tolower' => TRUE
            ];

        $this->upload->initialize($config);
        if ($this->upload->do_upload($upload)){
            $img = $this->upload->data("file_name");
            $name = $this->upload->data("raw_name");
            
            if (in_array($this->upload->data('file_ext'), ['.jpg', '.jpeg']))
                $image = imagecreatefromjpeg($this->path.$img);
            if ($this->upload->data('file_ext') == '.png')
                $image = imagecreatefrompng($this->path.$img);

            if (isset($image)){
                convert_webp($this->path, $image, $name);
                unlink($this->path.$img);
                $img = "$name.webp";
            }

            return ['error' => false, 'message' => $img];
        }else
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
    }

	public function getModuleVideos()
    {
        $videos = array_map(function($arr) {
            return ['id' => e_id($arr['id']), 'title' => $arr['title']];
        }, $this->main->getall('module_video', 'id, title', ['is_deleted' => 0, 'module_id' => d_id($this->input->get('module_id'))]));
        
        die(json_encode(['videos' => $videos]));
    }

	public function getSubChapters()
    {
        $chapters = array_map(function($arr) {
            return ['id' => e_id($arr['id']), 'title' => $arr['title']];
        }, $this->main->getall('chapters', 'id, title', ['is_deleted' => 0, 'ch_id' => d_id($this->input->get('ch_id'))]));
        
        die(json_encode(['chapters' => $chapters]));
    }

    public function followup_list($id)
    {
        check_ajax();

        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = 'view';
        $data['url'] = $this->redirect;
        $this->load->model('student_model');
        $data['follows'] = $this->student_model->followup_list($id);

        return $this->load->view("freeStudents/followup_list", $data);
    }

	public function error_404()
	{
		$data['name'] = 'error 404';
		$data['title'] = 'error 404';
		$data['url'] = $this->redirect;
		return $this->template->load('template', 'error_404', $data);
	}
}
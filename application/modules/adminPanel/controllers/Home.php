<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

	protected $redirect = '';
	protected $table = 'users';

	public function index()
	{
		$data['name'] = 'dashboard';
		$data['title'] = 'dashboard';
		$data['url'] = $this->redirect;
        $this->load->model('student_model');
        $data['student'] = $this->student_model->count();
        $this->load->model('ebook_model');
        $data['ebook'] = $this->ebook_model->count();
        $this->load->model('module_model');
        $data['module'] = $this->module_model->count();
        $this->load->model('module_video_model');
        $data['video'] = $this->module_video_model->count();
        
		return $this->template->load('template', 'dashboard', $data);
	}

	public function profile()
	{
        if (!$this->input->is_ajax_request()) {
            $data['name'] = 'profile';
            $data['title'] = 'profile';
            $data['url'] = $this->redirect;

            return $this->template->load('template', 'profile', $data);
        }else{
    		$this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
            	$post = [
                    'name'        => $this->input->post('name'),
                    'mobile'      => $this->input->post('mobile'),
                    'email'       => $this->input->post('email')
                ];

                if ($this->input->post('password'))
                    $post['password'] = my_crypt($this->input->post('password'));
            	
            	if ($this->main->update(['id' => $this->auth], $post, $this->table))
                	$response = [
                        'message' => "Profile updated successfully.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "Profile not updated. Try again.",
                        'status' => false
                    ];
                    
                die(json_encode($response));
            }
        }
	}

    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(admin('login'));
    }

	public function database()
	{
		// Load the DB utility class
        $this->load->dbutil();
        
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download(APP_NAME.'.zip', $backup);

        return redirect(admin());
	}

    public function mobile_check($str)
    {   
        if ($this->main->check($this->table, ['mobile' => $str, 'id != ' => $this->auth], 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        if ($this->main->check($this->table, ['email' => $str, 'id != ' => $this->auth], 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function query()
    {   
        if (!$this->input->is_ajax_request()) {
            $data['name'] = 'query';
            $data['title'] = 'query';
            $data['url'] = $this->redirect;

            return $this->template->load('template', 'query', $data);
        }else{
    		$this->form_validation->set_rules('query', '', 'required');
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                if ($this->main->run_query())
                	$response = [
                        'message' => "Query run successfully.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "Query not run. Try again.",
                        'status' => false
                    ];
            }
            
            die(json_encode($response));
        }
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'User Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|callback_email_check|valid_email',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile No.',
            'rules' => 'required|exact_length[10]|callback_mobile_check|numeric',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ]
        ]
    ];
}
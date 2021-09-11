<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModuleVideo extends Admin_Controller {

	protected $redirect = 'moduleVideo';
    protected $title = 'Module video';
	protected $table = 'module_video';
    protected $name = 'moduleVideo';
    protected $path = 'uploads/module_video/';

	public function index()
	{
        check_view_access($this->name);
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['url'] = $this->redirect;
        $data['dataTable'] = TRUE;

		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $add = check_access($this->name, 'add');
        $update = check_access($this->name, 'update');
        $delete = check_access($this->name, 'delete');
        $this->load->model('module_video_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->module;
            $sub_array[] = $row->title;
            $sub_array[] = $row->details;
            
            if ($add)
                $sub_array[] = file_exists($this->path.$row->hindi_pdf) ? '<div class="icon-btn">'.form_button(['content' => '<i class="fa fa-file-text-o" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/viewPdf/'.$row->hindi_pdf),
                'data-title' => "View PDF", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon'])."</div>" : 
                form_open_multipart("$this->redirect/pdfUpload", '', ['id' => e_id($row->id), 'lang' => 'hindi_pdf', 'file' => $row->hindi_pdf]).
                form_label('<i class="fa fa-upload" ></i>', 'hindi_'.$row->id, ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']).
                form_input([
                    'style' => "display: none;",
                    'type' => "file",
                    'id' => "hindi_".$row->id,
                    'name' => "pdf",
                    'onchange' => "bulkUpload(this.form)"
                ]).
                form_close();
            
            if ($add)
                $sub_array[] = file_exists($this->path.$row->guj_pdf) ? '<div class="icon-btn">'.form_button(['content' => '<i class="fa fa-file-text-o" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/viewPdf/'.$row->guj_pdf),
                'data-title' => "View PDF", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon'])."</div>" : 
                form_open_multipart("$this->redirect/pdfUpload", '', ['id' => e_id($row->id), 'lang' => 'guj_pdf', 'file' => $row->guj_pdf]).
                form_label('<i class="fa fa-upload" ></i>', 'guj_'.$row->id, ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']).
                form_input([
                    'style' => "display: none;",
                    'type' => "file",
                    'id' => "guj_".$row->id,
                    'name' => "pdf",
                    'onchange' => "bulkUpload(this.form)"
                ]).
                form_close();
            
            $action = '<div style="display: inline-flex;" class="icon-btn">';
            
            $action .= form_button(['content' => '<i class="fa fa-video-camera" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/view/'.e_id($row->id)),
            'data-title' => "View video", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
            
            if ($update)
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/update/'.e_id($row->id)),
                        'data-title' => "Update $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
                        
            if ($delete)
                $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                           form_button([ 'content' => '<i class="fa fa-trash"></i>',
                                'type'  => 'button',
                                'class' => 'btn btn-danger btn-outline-danger btn-icon', 
                                'onclick' => "script.delete(".e_id($row->id)."); return false;"]).
                           form_close();

            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];
        
        die(json_encode($output));
    }

    public function view($id)
    {
        check_ajax();
        $data['data'] = $this->main->get($this->table, 'CONCAT("'.$this->path.'", video) video', ['id' => d_id($id)]);
        return $this->load->view("$this->redirect/view", $data);
    }

    public function viewPdf($pdf)
    {
        check_ajax();
        return $this->load->view("$this->redirect/viewPdf", ['pdf' => $this->path.$pdf]);
    }
    
    public function add()
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'add';
            $data['url'] = $this->redirect;
            $data['modules'] = $this->main->getall('modules', 'id, title', ['is_deleted' => 0]);
            
            return $this->template->load("$this->redirect/add", "$this->redirect/form", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
                $response = [
                        'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                        'status' => false
                    ];
            else{
                $video = $this->uploadVideo();

                if ($video['error'])
                    $response = [
                            'message' => $video['message'],
                            'status' => false
                        ];
                else{
                    $post = [
                        'module_id'  => d_id($this->input->post('module_id')),
                        'title'      => $this->input->post('title'),
                        'details'    => $this->input->post('details'),
                        'hindi_pdf'  => time(),
                        'guj_pdf'    => time()+1,
                        'video'      => $video['message'],
                        'admin_id'   => $this->auth
                    ];

                    if ($id = $this->main->add($post, $this->table))
                        $response = [
                            'message'   => "$this->title added.",
                            'status'    => true
                        ];
                    else
                        $response = [
                            'message' => "$this->title not added. Try again.",
                            'status' => false
                        ];
                }
            }

            die(json_encode($response));
        }
    }

    public function update($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'update';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->main->get($this->table, 'title, details, video, module_id', ['id' => d_id($id)]);
            $data['modules'] = $this->main->getall('modules', 'id, title', ['is_deleted' => 0]);

            return $this->template->load("$this->redirect/update", "$this->redirect/form", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
                $response = [
                        'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                        'status' => false
                    ];
            else{
                if ($_FILES['video']['name']) {
                    $video = $this->uploadVideo();
                    if ($video['error'])
                        die(json_encode(['message' => $video['message'],'status' => false]));
                    else
                        if (file_exists($this->path.$this->input->post('video'))) 
                            unlink($this->path.$this->input->post('video'));
                }else
                    $video['message'] = $this->input->post('video');
                
                $post = [
                        'module_id'  => d_id($this->input->post('module_id')),
                        'title'      => $this->input->post('title'),
                        'details'    => $this->input->post('details'),
                        'video'      => $video['message'],
                        'admin_id'   => $this->auth
                    ];
                
                if ($this->main->update(['id' => d_id($id)], $post, $this->table))
                    $response = [
                        'message' => "$this->title updated.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "$this->title not updated. Try again.",
                        'status' => false
                    ];
            }

            die(json_encode($response));
        }
    }

    public function pdfUpload()
    {
        $this->load->library('upload');
        
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => 'pdf',
                'file_name'        => $this->input->post('file'),
                'file_ext_tolower' => TRUE
            ];

        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('pdf')){
            $post = [ $this->input->post('lang') => $this->upload->data("file_name") ];
            if ($this->main->update(['id' => d_id($this->input->post('id'))], $post, $this->table))
                $response = [
                    'message' => "$this->title deleted.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "$this->title not deleted. Try again.",
                    'status' => false
                ];
        }
        else
            $response = ['status' => false, 'message' => strip_tags($this->upload->display_errors())];
        
        die(json_encode($response));
    }

    public function delete()
    {
        check_ajax();
        $this->form_validation->set_rules('id', 'id', 'required|numeric');
        if ($this->form_validation->run() == FALSE)
            $response = [
                        'message' => "Some required fields are missing.",
                        'message' => validation_errors(),
                        'status' => false
                    ];
        else
            if ($this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1, 'admin_id' => $this->auth], $this->table))
                $response = [
                    'message' => "$this->title deleted.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "$this->title not deleted. Try again.",
                    'status' => false
                ];
        
        die(json_encode($response));
    }

    protected function uploadVideo()
    {
        $this->load->library('upload');
        
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => 'mp4',
                'file_name'        => time(),
                'file_ext_tolower' => TRUE
            ];

        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('video'))
            return ['error' => false, 'message' => $this->upload->data("file_name")];
        else
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
    }

    protected $validate = [
        [
            'field' => 'title',
            'label' => 'Video Title',
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'module_id',
            'label' => 'Module',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'details',
            'label' => 'Details',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}
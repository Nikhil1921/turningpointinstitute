<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends Admin_Controller {

	protected $redirect = 'book';
    protected $title = 'Book';
	protected $table = 'books';
    protected $name = 'book';

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
        $update = check_access($this->name, 'update');
        $delete = check_access($this->name, 'delete');
        $this->load->model('book_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->chapter;
            $sub_array[] = $row->sub_chapter;
            $sub_array[] = $row->language;

            $action = '<div style="display: inline-flex;" class="icon-btn">';

            if ($update) {
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/update/'.e_id($row->id)),
                        'data-title' => "Update $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
            }
            
            if ($delete) {
                $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                form_button([ 'content' => '<i class="fa fa-trash"></i>',
                    'type'  => 'button',
                    'class' => 'btn btn-danger btn-outline-danger btn-icon', 
                    'onclick' => "script.delete(".e_id($row->id)."); return false;"]).
                form_close();
            }

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

    public function add()
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'add';
            $data['url'] = $this->redirect;
            $data['chapters'] = $this->main->getall('chapters', 'id, title', ['is_deleted' => 0, 'ch_id' => 0]);
            
            return $this->template->load("$this->redirect/add", "$this->redirect/form", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                'status' => false
            ];
            else{
                $post = [
                    'description'  => $this->input->post('description'),
                    'ch_id'        => d_id($this->input->post('ch_id')),
                    'sub_ch_id'    => d_id($this->input->post('sub_ch_id')),
                    'language'     => $this->input->post('language')
                ];
                
                if ($this->main->add($post, $this->table))
                $response = [
                    'message' => "$this->title added.",
                    'status' => true
                ];
                else
                    $response = [
                        'message' => "$this->title not added. Try again.",
                        'status' => false
                    ];
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
            $data['data'] = $this->main->get($this->table, 'description, ch_id, sub_ch_id, language', ['id' => d_id($id)]);
            $data['chapters'] = $this->main->getall('chapters', 'id, title', ['is_deleted' => 0, 'ch_id' => 0]);
            
            return $this->template->load("$this->redirect/update", "$this->redirect/form", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'description'  => $this->input->post('description'),
                    'ch_id'        => d_id($this->input->post('ch_id')),
                    'sub_ch_id'    => d_id($this->input->post('sub_ch_id')),
                    'language'     => $this->input->post('language')
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
            if ($this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table))
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

    protected $validate = [
        [
            'field' => 'language',
            'label' => 'Language',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'ch_id',
            'label' => 'Chapter',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'sub_ch_id',
            'label' => 'Sub Chapter',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}
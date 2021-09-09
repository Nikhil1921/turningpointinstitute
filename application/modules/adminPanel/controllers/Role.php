<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Admin_Controller {

	protected $redirect = 'role';
    protected $title = 'Role';
	protected $table = 'role';
    protected $name = 'role';

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
        $this->load->model('role_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = ucwords($row->role);

            $action = '<div style="display: inline-flex;" class="icon-btn">';

            if ($update) {
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/update/'.e_id($row->id)),
                        'data-title' => "Update $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
                $action .= form_button(['content' => '<i class="fa fa-lock"></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/permissions/'.e_id($row->id)),
                        'data-title' => "Update permissions", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
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
            
            return $this->load->view("$this->redirect/add", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $navigation = array_map(function ($v) { return d_id($v); }, $this->input->post('navigation'));
                $post = [
                    'role'       => $this->input->post('role'),
                    'navigation' => implode(',', $navigation)
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
            $data['data'] = $this->main->get($this->table, 'role, navigation', ['id' => d_id($id)]);

            return $this->load->view("$this->redirect/update", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $navigation = array_map(function ($v) { return d_id($v); }, $this->input->post('navigation'));
                $post = [
                    'role'       => $this->input->post('role'),
                    'navigation' => implode(',', $navigation)
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

    public function permissions($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = 'permissions';
            $data['operation'] = 'permissions';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->main->get($this->table, 'role, navigation', ['id' => d_id($id)]);
            $nav = $data['data']['navigation'];
            $data['navigation'] = $this->main->getall('navigation', 'menu, url, sub_menu, permissions', 'id IN ('.$nav.')');
            
            return $this->load->view("$this->redirect/permissions", $data);
        }else{
            $this->form_validation->set_rules('permissions[]', 'permissions', 'required');
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                $i = 0;

                foreach ($this->input->post('permissions') as $sub_menu => $v) {
                    foreach ($v as $operation) {
                        $insert[$i]['sub_menu'] = $sub_menu;
                        $insert[$i]['operation'] = $operation;
                        $insert[$i]['role'] = d_id($id);
                    $i++;
                    }
                }
                
                $this->main->delete('access', ['role' => d_id($id)]);
                
                if ($this->main->insert_batch($insert, 'access'))
                    $response = [
                        'message' => "permissions updated.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "permissions not updated. Try again.",
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
            'field' => 'role',
            'label' => 'role',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'navigation[]',
            'label' => 'Navigation',
            'rules' => 'required',
            'errors' => [
                'required' => "Select at least one %s",
            ],
        ]
    ];
}
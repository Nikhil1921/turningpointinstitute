<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends Admin_Controller {

    protected $redirect = 'navigation';
    protected $title = 'Navigation';
	protected $table = 'navigation';
    protected $name = 'navigation';

    public $validate = [
            [
                'field' => 'menu',
                'label' => 'Menu Name',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'icon',
                'label' => 'Menu Icon',
                'rules' => 'required',
                'errors' => [
                    'required' => "%s is Required",
                ],
            ],
            [
                'field' => 'permissions[]',
                'label' => 'Permission',
                'rules' => 'required',
                'errors' => [
                    'required' => "Select at least one %s",
                ],
            ]
    ];
    
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
        $this->load->model('navigation_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = ucwords($row->menu);
            $sub_array[] = $row->url ? $row->url : "NA";
            $sub_array[] = $row->sub_menu ? $row->sub_menu : "NA";
            $sub_array[] = ucwords($row->permissions);

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
            
            return $this->load->view("$this->redirect/add", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'menu' => $this->input->post('menu'),
                    'url' => $this->input->post('url'),
                    'icon' => $this->input->post('icon'),
                    'permissions' => implode(', ', $this->input->post('permissions'))
                ];
                
                if (is_array($this->input->post('sub_menu'))) {
                    $post['sub_menu'] = json_encode(array_combine($this->input->post('sub_menu'), $this->input->post('sub_menu_url')));
                }
                
                if ($this->main->add($post, $this->table))
                    $response = [
                        'message' => "$this->title added.",
                        'status' => true,
                        'redirect' => $this->name
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
            $data['data'] = $this->main->get($this->table, 'menu, url, icon, sub_menu, permissions', ['id' => d_id($id)]);

            return $this->load->view("$this->redirect/update", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'menu' => $this->input->post('menu'),
                    'url' => $this->input->post('url'),
                    'icon' => $this->input->post('icon'),
                    'permissions' => implode(', ', $this->input->post('permissions'))
                ];
                
                if (is_array($this->input->post('sub_menu'))) {
                    $post['sub_menu'] = json_encode(array_combine($this->input->post('sub_menu'), $this->input->post('sub_menu_url')));
                }
                
                if ($this->main->update(['id' => d_id($id)], $post, $this->table))
                    $response = [
                        'message' => "$this->title updated.",
                        'status' => true,
                        'redirect' => $this->name
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
            if ($this->main->delete($this->table, ['id' => d_id($this->input->post('id'))]))
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
}
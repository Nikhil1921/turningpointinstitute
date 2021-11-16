<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FreeStudents extends Admin_Controller {

	protected $redirect = 'freeStudents';
    protected $title = 'Free Students';
	protected $table = 'students';
    protected $name = 'freeStudents';

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
        $this->load->model('student_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        $update = check_access($this->name, 'update');
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = ucwords($row->name);
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->address;
            $sub_array[] = $row->assigned ? $row->assigned : 'Not Assigned';

            $action = '<div style="display: inline-flex;" class="icon-btn">';
            $action .= form_button(['content' => '<i class="fa fa-eye" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/followup_list/'.e_id($row->id)),
                        'data-title' => "Followup history", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);

            if (auth()->role == 'Super Admin')
                $action .= form_button(['content' => '<i class="fa fa-user" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/assign/'.e_id($row->id)),
                        'data-title' => "Assign Student", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);

            if ($update) {
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/followup/'.e_id($row->id)),
                        'data-title' => "Add Followup", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
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

    public function assign($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'assign';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['users'] = $this->main->getall('users', 'id, name', ['is_deleted' => 0, 'role' => 'Admin']);

            return $this->load->view("$this->redirect/assign", $data);
        }else{
            if (!$this->input->post('assign_id'))
            $response = [
                    'message' => "Select staff user to assign.",
                    'status' => false
                ];
            else{
                $post = [
                    'assign_id' => d_id($this->input->post('assign_id'))
                ];
                
                if ($this->main->update(['id' => d_id($id)], $post, $this->table))
                    $response = [
                        'message' => "$this->title assigned.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "$this->title not assigned. Try again.",
                        'status' => false
                    ];
            }

            die(json_encode($response));
        }
    }

    public function followup($id)
    {
        check_ajax();

        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'Add followup';
            $data['url'] = $this->redirect;
            $data['id'] = $id;

            return $this->load->view("$this->redirect/followup", $data);
        }else{
            $this->form_validation->set_rules('remark', 'Remark', 'trim|required|max_length[255]', ['required' => '%s is required']);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $this->load->model('student_model');
                
                if ($this->student_model->followup($id))
                    $response = [
                        'message' => "Follow up added.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "Follow up not added. Try again.",
                        'status' => false
                    ];
            }
            die(json_encode($response));
        }
    }

    public function followup_list($id)
    {
        check_ajax();

        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = 'view';
        $data['url'] = $this->redirect;
        // $data['follows'] = $this->main->getall('follow_ups', 'id, remark, status');

        return $this->load->view("$this->redirect/followup_list", $data);
    }
}
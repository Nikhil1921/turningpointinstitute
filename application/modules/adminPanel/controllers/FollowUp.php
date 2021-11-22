<?php defined('BASEPATH') OR exit('No direct script access allowed');

class FollowUp extends Admin_Controller {

	protected $redirect = 'followUp';
    protected $title = 'Follow Up(s)';
	protected $table = 'follow_ups';
    protected $name = 'followUp';

	public function index()
	{
        check_view_access($this->name);
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['url'] = $this->redirect;
        $data['dataTable'] = TRUE;
        $data['users'] = $this->main->getall('users', 'id, name', ['is_deleted' => 0, 'role' => 'Admin']);
        
		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $this->load->model('follow_ups_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = ucwords($row->name);
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = $row->address;
            $sub_array[] = $row->created_by;
            if (auth()->role == 'Super Admin') $sub_array[] = $row->assigned ? $row->assigned : 'Not Assigned';

            $action = '<div style="display: inline-flex;" class="icon-btn">';
            $action .= form_button(['content' => '<i class="fa fa-eye" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/followup_list/'.e_id($row->id)),
                        'data-title' => "Followup history", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);

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
}
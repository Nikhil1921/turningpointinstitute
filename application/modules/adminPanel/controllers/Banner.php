<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banner extends Admin_Controller {

	protected $redirect = 'banner';
    protected $title = 'Banner';
	protected $table = 'banner';
    protected $name = 'banner';
    protected $path = 'uploads/banners/';

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
        $delete = check_access($this->name, 'delete');
        $this->load->model('banner_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = img(['src' => $this->path.$row->banner, 'height' => 100]);

            $action = '<div style="display: inline-flex;" class="icon-btn">';
            
            if ($delete)
                $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id), 'banner' => $row->banner]).
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

    public function add()
    {
        check_ajax();
        
        $img = $this->uploadImage('bulk_upload');
        if ($img['error'])
            $response = [
                    'message' => $img['message'],
                    'status' => false
                ];
        else
            if ($this->main->add(['banner' => $img['message']], $this->table))
                $response = [
                    'message' => "$this->title added.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "$this->title not added. Try again.",
                    'status' => false
                ];
        
        die(json_encode($response));
    }

    public function delete()
    {
        check_ajax();
        $this->form_validation->set_rules('id', 'id', 'required|numeric');
        $this->form_validation->set_rules('banner', 'banner', 'required');
        
        if ($this->form_validation->run() == FALSE)
            $response = [
                        'message' => "Some required fields are missing.",
                        'message' => validation_errors(),
                        'status' => false
                    ];
        else
            if ($this->main->delete($this->table, ['id' => d_id($this->input->post('id'))])){
                if (file_exists($this->path.$this->input->post('banner'))) unlink($this->path.$this->input->post('banner'));
                $response = [
                    'message' => "$this->title deleted.",
                    'status' => true
                ];
            }
            else
                $response = [
                    'message' => "$this->title not deleted. Try again.",
                    'status' => false
                ];
        die(json_encode($response));
    }
}
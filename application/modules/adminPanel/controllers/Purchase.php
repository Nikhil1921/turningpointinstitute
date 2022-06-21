<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends Admin_Controller {

	protected $redirect = 'purchase';
    protected $title = 'Purchase';
	protected $table = 'buy_ebook';
    protected $name = 'purchase';

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
        $this->load->model('purchase_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->title;
            $sub_array[] = $row->price;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->address;
            $sub_array[] = $row->pay_id;

            switch ($row->status) {
                case 'In Delivery':
                    $status = "Delivered";
                    break;
                
                default:
                    $status = "In Delivery";
                    break;
            }

            $action = '<div style="display: inline-flex;" class="icon-btn">';
                if($row->status !== 'Delivered')
                    $action .= form_open($this->redirect.'/status', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id), 'status' => $status]).
                            form_button([ 'content' => $status,
                                    'type'  => 'button',
                                    'class' => 'btn btn-primary btn-outline-primary', 
                                    'onclick' => "script.status(".e_id($row->id)."); return false;"]).
                            form_close();
                else
                    $action .= form_button([ 'content' => $row->status,
                                        'type'  => 'button',
                                        'class' => 'btn btn-danger btn-outline-danger'
                                    ]);
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

    public function status()
    {
        check_ajax();
        $this->form_validation->set_rules('id', 'id', 'required|numeric');
        $this->form_validation->set_rules('status', 'status', 'required');
        
        if ($this->form_validation->run() == FALSE)
            $response = [
                        'message' => "Some required fields are missing.",
                        'message' => validation_errors(),
                        'status' => false
                    ];
        else
            if ($this->main->update(['id' => d_id($this->input->post('id'))], ['status' => $this->input->post('status')], $this->table))
                $response = [
                    'message' => "Status updated.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "Status not updated. Try again.",
                    'status' => false
                ];
        die(json_encode($response));
    }
}
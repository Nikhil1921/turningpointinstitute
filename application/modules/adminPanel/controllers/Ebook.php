<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ebook extends Admin_Controller {

	protected $redirect = 'ebook';
    protected $title = 'Ebook';
	protected $table = 'ebook';
    protected $name = 'ebook';
    protected $path = 'uploads/ebooks/';

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
        $this->load->model('ebook_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->title;
            $sub_array[] = $row->price;
            $sub_array[] = $row->discount;
            $sub_array[] = $row->del_charge;
            $sub_array[] = img(['src' => $this->path.$row->image, 'height' => 75]);
            /* $sub_array[] = $row->book != 'Pending' ? 
                            form_button(['content' => 'View '.$this->title, 'type'  => 'button', 'data-url' => base_url($this->redirect.'/view/'.e_id($row->id)),
                        'data-title' => "$this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-round col-12']) 
                        : form_button(['content' => 'Upload '.$this->title, 'type'  => 'button', 'data-url' => base_url($this->redirect.'/upload/'.e_id($row->id)),
                        'data-title' => "Upload $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-round col-12']); */

            $action = '<div style="display: inline-flex;" class="icon-btn">';
            
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
        $data['data'] = $this->main->get($this->table, 'CONCAT("'.$this->path.'", book) book', ['id' => d_id($id)]);
        return $this->load->view("$this->redirect/view", $data);
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
                $img = $this->uploadImage('image');

                if ($img['error'])
                    $response = [
                            'message' => $img['message'],
                            'status' => false
                        ];
                else{
                    $post = [
                        'book'       => "Pending",
                        'title'      => $this->input->post('title'),
                        'price'      => $this->input->post('price'),
                        'discount'   => $this->input->post('discount'),
                        'del_charge' => $this->input->post('del_charge'),
                        'details'    => $this->input->post('details'),
                        'image'      => $img['message'],
                        'admin_id'   => $this->auth
                    ];
                    
                    if ($id = $this->main->add($post, $this->table))
                        $response = [
                            'message'   => "$this->title added.",
                            'next_step' => base_url($this->redirect.'/upload/'.e_id($id)),
                            'title'     => "Upload $this->title",
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
            $data['data'] = $this->main->get($this->table, 'title, price, discount, del_charge, details', ['id' => d_id($id)]);
            
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
                        'title'      => $this->input->post('title'),
                        'price'      => $this->input->post('price'),
                        'discount'   => $this->input->post('discount'),
                        'del_charge' => $this->input->post('del_charge'),
                        'details'    => $this->input->post('details'),
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

    public function upload($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'upload';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            
            return $this->load->view("$this->redirect/ebook", $data);
        }else{
            $img = $this->uploadBook();

            if ($img['error'])
                $response = [
                        'message' => $img['message'],
                        'status' => false
                    ];
            else
                if ($this->main->update(['id' => d_id($id)], ['book' => $img['message']], $this->table))
                    $response = [
                        'message' => "$this->title uploaded.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "$this->title not uploaded. Try again.",
                        'status' => false
                    ];
            
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

    protected function uploadBook()
    {
        $this->load->library('upload');
        
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => 'pdf',
                'file_name'        => time(),
                'file_ext_tolower' => TRUE
            ];

        $this->upload->initialize($config);
        
        if ($this->upload->do_upload('ebook'))
            return ['error' => false, 'message' => $this->upload->data("file_name")];
        else
            return ['error' => true, 'message' => strip_tags($this->upload->display_errors())];
    }

    protected $validate = [
        [
            'field' => 'title',
            'label' => 'Book Title',
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'required|max_length[10]|numeric',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'max_length' => "%s is Invalid"
            ]
        ],
        [
            'field' => 'discount',
            'label' => 'Discount',
            'rules' => 'required|less_than[100]|numeric',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'less_than' => "%s is must be less than 100"
            ]
        ],
        [
            'field' => 'del_charge',
            'label' => 'Delivery charge',
            'rules' => 'required|max_length[5]|numeric',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'max_length' => "%s is Invalid"
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
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends Admin_Controller {

	protected $redirect = 'course';
	protected $name = 'course';
	protected $title = 'Course';
	protected $table = 'course';

	public function index()
	{
        if (!$this->input->is_ajax_request()) {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get($this->table, 'title, sub_title, price, discount, details, dicount_price', []);
            
            return $this->template->load('template', "$this->name/home", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'title'         => $this->input->post('title'),
                    'sub_title'     => $this->input->post('sub_title'),
                    'discount'      => $this->input->post('discount'),
                    'details'       => $this->input->post('details'),
                    'price'         => $this->input->post('price'),
                    'dicount_price' => $this->input->post('dicount_price')
                ];
                
                if (!$this->main->get($this->table, 'title, sub_title, price, discount, details', []))
                    $id = $this->main->add($post, $this->table);
                else
                    $id = $this->main->update([], $post, $this->table);

                if ($id)
                    $response = [
                        'message' => "$this->title updated successfully.",
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

    protected $validate = [
        [
            'field' => 'title',
            'label' => 'Title',
            'rules' => 'required|max_length[255]',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'sub_title',
            'label' => 'Sub title',
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
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'discount',
            'label' => 'Discount',
            'rules' => 'required|max_length[2]|numeric',
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
        ],
    ];
}
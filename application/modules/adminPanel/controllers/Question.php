<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Question extends Admin_Controller {

	protected $redirect = 'question';
    protected $title = 'Question';
	protected $table = 'questions';
    protected $name = 'question';

	public function index()
	{
        /* $connect = mysqli_connect("localhost", "root", "", 'tpenglish_turningapp');
        $modules = $this->main->getall('modules', 'id', []);
        echo "<pre>";
        $i=0;
        foreach ($modules as $module) {
            $videos = $this->main->getall('module_video', 'id', ['module_id' => $module['id']]);
            foreach ($videos as $video) {
                $sql = "SELECT * FROM mcq_tbl WHERE test_id = ".$video['id'];
	            $run = mysqli_query($connect, $sql);
                
                while ($data = mysqli_fetch_assoc($run)) {
                    $answer = [];
                    $answer[] = $data['mcq_ans1'];
                    if ($data['mcq_ans2'] != '')
                        $answer[] = $data['mcq_ans2'];
                    if ($data['mcq_ans3'] != '')
                        $answer[] = $data['mcq_ans3'];

                    switch ($data['type']) {
                        case 'block':
                        case 'Block':
                            $type = 'Blocks';
                            break;
                        case 'voice':
                        case 'Voice':
                            $type = 'Speaking';
                            break;
                        case 'write':
                        case 'Write':
                            $type = 'Writing';
                            break;
                        
                        default:
                            $type = 'Blocks';
                            break;
                    }
                    $post = [
                        'question' => $data['mcq_que'],
                        'question_hindi' => $data['mcq_que1'],
                        'video_id' => $video['id'],
                        'module_id' => $module['id'],
                        'answer' => json_encode($answer),
                        'test_type' => $type,
                        'admin_id' => $this->auth,
                    ];
                    $this->main->add($post, 'questions');
                }
            }
        } */
        check_view_access($this->name);
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['url'] = $this->redirect;
        $data['dataTable'] = TRUE;
        $where = ['is_deleted' => 0];
        if (auth()->role != 'Super Admin') $where['admin_id'] = $this->auth;
        $data['modules'] = $this->main->getall('modules', 'id, title', $where);
        
		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $update = check_access($this->name, 'update');
        $delete = check_access($this->name, 'delete');
        $this->load->model('question_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->title;
            $sub_array[] = '<span class="gujarati-class" style="white-space: break-spaces;">'.$row->question.'</span>';
            $sub_array[] = '<span class="hindi-class" style="white-space: break-spaces;">'.$row->question_hindi.'</span>';
            $ans = json_decode(str_replace('","', '<br/ >', $row->answer));
            $sub_array[] = '<p id="sort_'.e_id($row->id).'">'.$ans[0].'</p>';
            $sub_array[] = $row->test_type;

            $action = '<div style="display: inline-flex;" class="icon-btn">';

            if ($update)
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/update/'.e_id($row->id)),
                        'data-title' => "Update $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
            
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
            $where = ['is_deleted' => 0];
            if (auth()->role != 'Super Admin') $where['admin_id'] = $this->auth;
            $data['modules'] = $this->main->getall('modules', 'id, title', $where);
            
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
                    'admin_id'  => $this->auth,
                    'question'  => $this->input->post('question'),
                    'question_hindi'  => $this->input->post('question_hindi'),
                    'module_id' => d_id($this->input->post('module_id')),
                    'video_id'  => d_id($this->input->post('video_id')),
                    'options'   => $this->input->post('options'),
                    /* 'language'  => $this->input->post('language'), */
                    'test_type' => $this->input->post('test_type'),
                    'answer'    => json_encode($this->input->post('answer'))
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
            $data['data'] = $this->main->get($this->table, 'question, module_id, video_id, options, language, test_type, answer, question_hindi', ['id' => d_id($id)]);
            $where = ['is_deleted' => 0];
            if (auth()->role != 'Super Admin') $where['admin_id'] = $this->auth;
            $data['modules'] = $this->main->getall('modules', 'id, title', $where);

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
                    'question'  => $this->input->post('question'),
                    'question_hindi'  => $this->input->post('question_hindi'),
                    'module_id' => d_id($this->input->post('module_id')),
                    'video_id'  => d_id($this->input->post('video_id')),
                    'options'   => $this->input->post('options'),
                    /* 'language'  => $this->input->post('language'), */
                    'test_type' => $this->input->post('test_type'),
                    'answer'    => json_encode($this->input->post('answer'))
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

    public function sort()
    {
        check_ajax();

        foreach ($this->input->post('sort') as $k => $v)
            $id = $this->main->update(['id' => d_id(str_replace('sort_', '', $v['id']))], ['position' => $v['position'], 'admin_id' => $this->auth], $this->table);
        
        if ($id)
            $response = [
                'message'  => "$this->title updated.",
                'status'   => true
            ];
        else
            $response = [
                'message'  => "$this->title not updated. Try again.",
                'status'   => false
            ];

        die(json_encode($response));
    }

    /* public function upload()
    {
        check_ajax();
        if(!empty($_FILES["bulk_upload"]["name"])):
            $type = explode('.', $_FILES["bulk_upload"]["type"]);
            if (end($type) !== 'sheet') {
                $response = [
                    'message' => "Invalid file type.",
                    'status' => false
                ];
                die(json_encode($response));
            }
            set_time_limit(0);
            $path = $_FILES["bulk_upload"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet):
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row <= $highestRow; $row++):
                    $options = [
                        "A" => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        "B" => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        "C" => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                        "D" => $worksheet->getCellByColumnAndRow(5, $row)->getValue()
                    ];

                    $data[] = [
                            'admin_id' => $this->auth,
                            'question' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                            'options'  => json_encode($options),
                            'answer'   => $worksheet->getCellByColumnAndRow(6, $row)->getValue()
                    ];
                endfor;
            endforeach;    

            if (count($data) > 0 && $this->main->insert_batch($data, $this->table))
                $response = [
                    'message' => "$this->title added.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "$this->title not added. Try again.",
                    'status' => false
                ];
        else:
            $response = [
                    'message' => "$this->title not added. Try again.",
                    'status' => false
                ];
        endif;
        die(json_encode($response));
    } */

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

    public function options_check($str)
    {   
        if ($this->input->post('test_type') == 'Blocks' && !$str)
        {
            $this->form_validation->set_message('options_check', '%s are required');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'module_id',
            'label' => 'Module',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'video_id',
            'label' => 'Module video',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'question',
            'label' => 'Question Gujarati',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'question',
            'label' => 'question_hindi',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'answer[]',
            'label' => 'Answer',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        /* [
            'field' => 'options',
            'label' => 'Options',
            'rules' => 'callback_options_check'
        ], */
        /* [
            'field' => 'language',
            'label' => 'Language',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ], */
        [
            'field' => 'test_type',
            'label' => 'Test type',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ]
    ];
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Question_model extends Admin_model
{
	public $table = "questions q";
	public $select_column = ['q.id', 'v.title', 'q.question', 'q.question_hindi', 'q.answer', 'q.test_type'];
	public $search_column = ['q.id', 'v.title', 'q.question', 'q.question_hindi', 'q.answer', 'q.test_type'];
    public $order_column = [null, 'v.title', 'q.question', 'q.question_hindi', null, 'q.test_type', null];
	public $order = ['q.position' => 'ASC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['q.is_deleted' => 0, 'v.is_deleted' => 0])
				 ->join('module_video v', 'v.id = q.video_id');

        if ($this->input->post('test_type'))
        	$this->db->where(['q.test_type' => $this->input->post('test_type')]);
        if ($this->input->post('module_id'))
        	$this->db->where(['q.module_id' => d_id($this->input->post('module_id'))]);
        if ($this->input->post('video_id'))
        	$this->db->where(['q.video_id' => d_id($this->input->post('video_id'))]);
        /* if (auth()->role !== "Super Admin")
        	$this->db->where(['q.admin_id' => $this->auth]); */

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('q.id')
		         ->from($this->table)
		         ->where(['q.is_deleted' => 0, 'v.is_deleted' => 0])
				 ->join('module_video v', 'v.id = q.video_id');

		if ($this->input->post('test_type'))
        	$this->db->where(['q.test_type' => $this->input->post('test_type')]);
        if ($this->input->post('module_id'))
        	$this->db->where(['q.module_id' => d_id($this->input->post('module_id'))]);
        if ($this->input->post('video_id'))
        	$this->db->where(['q.video_id' => d_id($this->input->post('video_id'))]);
		/* if (auth()->role !== "Super Admin")
        	$this->db->where(['q.admin_id' => $this->auth]); */
		            	
		return $this->db->get()->num_rows();
	}
}
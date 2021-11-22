<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Student_model extends Admin_model
{
	public $table = "students s";
	public $select_column = ['s.id', 's.name', 's.mobile', 's.email', 's.address', 'free_membership', 'assign_id', 'u.name assigned'];
	public $search_column = ['s.name', 's.mobile', 's.email', 's.address'];
    public $order_column = [null, 's.name', 's.mobile', 's.email', 's.address', null];
	public $order = ['s.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['s.is_deleted' => 0, 'registered' => $this->input->post('status')])
				 ->join('users u', 'u.id = s.assign_id', 'left');

		if (auth()->role != 'Super Admin')
			if ($this->input->post('status') == 0)
				$this->db->where('s.assign_id', $this->auth);
			else
				$this->db->where('s.admin_id', $this->auth);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('s.id')
				 ->from($this->table)
				 ->where(['s.is_deleted' => 0, 'registered' => $this->input->post('status')])
				 ->join('users u', 'u.id = s.assign_id', 'left');

		if (auth()->role != 'Super Admin')
			if ($this->input->post('status') == 0)
				$this->db->where('s.assign_id', $this->auth);
			else
				$this->db->where('s.admin_id', $this->auth);

		return $this->db->get()
						->num_rows();
	}

	public function followup($id)
	{
		$post = [
			'stu_id'     	=> d_id($id),
			'status'     	=> $this->input->post('status'),
			'remark'     	=> $this->input->post('remark'),
			'created_by' 	=> auth()->id,
			'created_date'	=> date('Y-m-d'),
			'created_time' 	=> date('H:i:s')
		];

		$this->db->trans_start();
		$this->db->insert("follow_ups", $post);
		if ($post['status'] != 'Follow Up')
			$this->db->where(['id' => d_id($id)])->update("students", ['registered' => 1]);

		return $this->db->trans_complete();
	}

	public function followup_list($id)
	{
		return $this->db->select('remark, f.status, created_date, created_time, u.name')
						->from('follow_ups f')
						->where(['stu_id' => d_id($id)])
						->join('users u', 'u.id = f.created_by')
						->order_by('f.id DESC')
						->get()
						->result_array();
	}

	public function counter($status)
	{
		$this->db->select('s.id')
				 ->from($this->table)
				 ->where(['s.is_deleted' => 0, 'registered' => $status]);

		if (auth()->role != 'Super Admin')
			if ($status == 0)
				$this->db->where('s.assign_id', $this->auth);
			else
				$this->db->where('s.admin_id', $this->auth);

		return $this->db->get()
						->num_rows();
	}
}
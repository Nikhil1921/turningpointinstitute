<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Follow_ups_model extends Admin_model
{
	public $table = "follow_ups f";
	public $select_column = ['s.id', 's.name', 's.mobile', 's.email', 's.address', 'f.status', 'c.name created_by', 'u.name assigned'];
	public $search_column = ['s.name', 's.mobile', 's.email', 's.address', 'c.name'];
    public $order_column = [null, 's.name', 's.mobile', 's.email', 's.address', 'c.name', null];
	public $order = ['s.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['s.is_deleted' => 0, 'f.status' => $this->input->post('status')])
				 ->join('students s', 's.id = f.stu_id', 'left')
				 ->join('users c', 'c.id = f.created_by', 'left')
				 ->join('users u', 'u.id = s.assign_id', 'left');
		
		if ($this->input->post('staff_id')) $this->db->where(['s.assign_id' => d_id($this->input->post('staff_id'))]);

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
				 ->where(['s.is_deleted' => 0, 'f.status' => $this->input->post('status')])
				 ->join('students s', 's.id = f.stu_id', 'left')
				 ->join('users c', 'c.id = f.created_by', 'left')
				 ->join('users u', 'u.id = s.assign_id', 'left');
		
		if ($this->input->post('staff_id')) $this->db->where(['s.assign_id' => d_id($this->input->post('staff_id'))]);

		if (auth()->role != 'Super Admin')
			if ($this->input->post('status') == 0)
				$this->db->where('s.assign_id', $this->auth);
			else
				$this->db->where('s.admin_id', $this->auth);

		return $this->db->get()
						->num_rows();
	}
}
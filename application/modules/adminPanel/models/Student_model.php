<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Student_model extends Admin_model
{
	public $table = "students s";
	public $select_column = ['s.id', 's.name', 's.mobile', 's.email', 's.address', 'free_membership'];
	public $search_column = ['s.name', 's.mobile', 's.email', 's.address'];
    public $order_column = [null, 's.name', 's.mobile', 's.email', 's.address', null];
	public $order = ['s.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['is_deleted' => 0, 'registered' => $this->input->post('status')]);

		/* if (auth()->role != 'Super Admin')
			$this->db->where('s.admin_id', $this->auth); */

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('s.id')
				 ->from($this->table)
				 ->where(['is_deleted' => 0, 'registered' => $this->input->post('status')]);

		/* if (auth()->role != 'Super Admin')
			$this->db->where('s.admin_id', $this->auth); */

		return $this->db->get()
						->num_rows();
	}
}
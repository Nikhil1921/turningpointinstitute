<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Student_model extends Admin_model
{
	public $table = "students s";
	public $select_column = ['s.id', 's.name', 's.mobile', 's.email', 's.address'];
	public $search_column = ['s.name', 's.mobile', 's.email', 's.address'];
    public $order_column = [null, 's.name', 's.mobile', 's.email', 's.address', null];
	public $order = ['s.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table);
        $this->datatable();
	}

	public function count()
	{
		$this->db->select('s.id')
				 ->from($this->table);

		return $this->db->get()
						->num_rows();
	}
}
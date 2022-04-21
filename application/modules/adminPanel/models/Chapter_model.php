<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Chapter_model extends Admin_model
{
	public $table = "chapters c";
	public $select_column = ['c.id', 'c.title'];
	public $search_column = ['c.id', 'c.title'];
    public $order_column = [null, 'c.title', null];
	public $order = ['c.id' => 'ASC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('c.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('c.id')
				 ->from($this->table)
				 ->where(['c.is_deleted' => 0]);

		return $this->db->get()
						->num_rows();
	}
}
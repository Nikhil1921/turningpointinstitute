<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Role_model extends Admin_model
{
	public $table = "role r";
	public $select_column = ['r.id', 'role'];
	public $search_column = ['r.role'];
    public $order_column = [null, 'r.role', null];
	public $order = ['r.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['is_deleted' => 0]);
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('r.id')
		            	 ->from($this->table)
		            	 ->where(['is_deleted' => 0])
		            	 ->get()
						 ->num_rows();
	}
}
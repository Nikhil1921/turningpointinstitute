<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Module_model extends Admin_model
{
	public $table = "modules m";
	public $select_column = ['m.id', 'm.title', 'm.sub_title', 'm.price'];
	public $search_column = ['m.id', 'm.title', 'm.sub_title', 'm.price'];
    public $order_column = [null, 'm.title', 'm.sub_title', 'm.price', null];
	public $order = ['m.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('m.is_deleted', 0);
        
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('m.id')
		            	->from($this->table)
						->where('m.is_deleted', 0)
		            	->get()
						->num_rows();
	}
}
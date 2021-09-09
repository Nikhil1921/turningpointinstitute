<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Membership_model extends Admin_model
{
	public $table = "membership m";
	public $select_column = ['m.id', 'm.title', 'm.price', 'CONCAT(m.duration, " ", m.duration_type) duration', 'm.features'];
	public $search_column = ['m.id', 'm.title', 'm.price', 'm.duration', 'm.features'];
    public $order_column = [null, 'm.title', 'm.price', 'm.duration', 'm.features', null];
	public $order = ['m.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
                 ->where('is_deleted', 0);
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('m.id')
		            	->from($this->table)
                        ->where('is_deleted', 0)
		            	->get()
						->num_rows();
	}
}
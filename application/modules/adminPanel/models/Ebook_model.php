<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Ebook_model extends Admin_model
{
	public $table = "ebook b";
	public $select_column = ['b.id', 'b.title', 'b.price', 'b.discount', 'b.del_charge', 'b.image', 'b.book'];
	public $search_column = ['b.id', 'b.title', 'b.price', 'b.discount', 'b.del_charge'];
    public $order_column = [null, 'b.title', 'b.price', 'b.discount', 'b.del_charge', null, null, null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('b.is_deleted', 0);
        
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('b.id')
		            	->from($this->table)
						->where('b.is_deleted', 0)
		            	->get()
						->num_rows();
	}
}
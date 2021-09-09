<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Navigation_model extends Admin_model
{
	public $table = "navigation n";
	public $select_column = ['n.id', 'n.menu', 'n.url', 'n.sub_menu', 'n.permissions'];
	public $search_column = ['n.id', 'n.menu', 'n.url', 'n.sub_menu', 'n.permissions'];
    public $order_column = [null, 'n.menu', 'n.url', null, null, null];
	public $order = ['n.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table);
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('n.id')
		            	->from($this->table)
		            	->get()
						->num_rows();
	}
}
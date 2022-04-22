<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Tpcloud_model extends Admin_model
{
	public $table = "tpcloud t";
	public $select_column = ['t.id', 't.cloud_type', 'c.title', 't.language'];
	public $search_column = ['t.cloud_type', 'c.title', 't.language'];
    public $order_column = [null, 't.cloud_type', 'c.title', 't.language', null];
	public $order = ['t.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['t.is_deleted' => 0])
                 ->join('chapters c', 'c.id = t.ch_id', 'left');

        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('t.id')
		            	 ->from($this->table)
		            	 ->where(['t.is_deleted' => 0])
                         ->join('chapters c', 'c.id = t.ch_id', 'left')
		            	 ->get()
						 ->num_rows();
	}
}
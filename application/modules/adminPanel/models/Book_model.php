<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Book_model extends Admin_model
{
	public $table = "books b";
	public $select_column = ['b.id', 'c.title chapter', 'sc.title sub_chapter', 'b.language'];
	public $search_column = ['b.id', 'c.title', 'sc.title', 'b.language'];
    public $order_column = [null, 'c.title', 'sc.title', 'b.language', null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
                 ->where(['c.is_deleted' => 0, 'sc.is_deleted' => 0, 'b.is_deleted' => 0])
                 ->join('chapters c', 'c.id = b.ch_id')
                 ->join('chapters sc', 'sc.id = b.sub_ch_id');

        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('b.id')
		            	->from($this->table)
                        ->where(['c.is_deleted' => 0, 'sc.is_deleted' => 0, 'b.is_deleted' => 0])
                        ->join('chapters c', 'c.id = b.ch_id')
                        ->join('chapters sc', 'sc.id = b.sub_ch_id')
		            	->get()
						->num_rows();
	}
}
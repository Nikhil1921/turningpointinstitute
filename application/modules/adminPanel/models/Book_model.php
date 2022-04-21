<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Book_model extends Admin_model
{
	public $table = "books b";
	public $select_column = ['b.id', 'c.title chapter', 'eb.title book'];
	public $search_column = ['b.id', 'c.title', 'eb.title'];
    public $order_column = [null, 'eb.title', 'c.title', null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
                 ->where(['c.is_deleted' => 0, 'b.is_deleted' => 0])
                 ->join('chapters c', 'c.id = b.ch_id', 'left')
                 ->join('ebook eb', 'eb.id = b.book_id', 'left');

        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('b.id')
		            	->from($this->table)
                        ->where(['c.is_deleted' => 0, 'b.is_deleted' => 0])
                        ->join('chapters c', 'c.id = b.ch_id', 'left')
                        ->join('ebook eb', 'eb.id = b.book_id', 'left')
		            	->get()
						->num_rows();
	}
}
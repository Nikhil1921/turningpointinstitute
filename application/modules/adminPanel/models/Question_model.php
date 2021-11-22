<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Question_model extends Admin_model
{
	public $table = "questions q";
	public $select_column = ['q.id', 'q.question', 'q.answer', 'q.language'];
	public $search_column = ['q.id', 'q.question', 'q.answer'];
    public $order_column = [null, 'q.question', 'q.answer', null];
	public $order = ['q.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['q.is_deleted' => 0]);

        /* if (auth()->role !== "Super Admin")
        	$this->db->where(['q.admin_id' => $this->auth]); */

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('q.id')
		         ->from($this->table)
		         ->where(['q.is_deleted' => 0]);

		/* if (auth()->role !== "Super Admin")
        	$this->db->where(['q.admin_id' => $this->auth]); */
		            	
		return $this->db->get()->num_rows();
	}
}
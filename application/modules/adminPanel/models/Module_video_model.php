<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Module_video_model extends Admin_model
{
	public $table = "module_video v";
	public $select_column = ['v.id', 'm.title module', 'v.title', 'v.details', 'v.hindi_pdf', 'v.guj_pdf', 'v.is_free'];
	public $search_column = ['v.id', 'm.title', 'v.title', 'v.details', 'v.hindi_pdf', 'v.guj_pdf'];
    public $order_column = [null, 'm.title', 'v.title', 'v.details', 'v.hindi_pdf', 'v.guj_pdf', null];
	public $order = ['v.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('v.is_deleted', 0)
				 ->join('modules m', 'm.id = v.module_id');
		/* if (auth()->role != 'Super Admin')
			$this->db->where('v.admin_id', $this->auth); */
        
        $this->datatable();
	}

	public function count()
	{
		$this->db->select('v.id')
				 ->from($this->table)
				 ->where('v.is_deleted', 0)
				 ->join('modules m', 'm.id = v.module_id');
		/* if (auth()->role != 'Super Admin')
			$this->db->where('v.admin_id', $this->auth); */

		return $this->db->get()
						->num_rows();
	}

	/* public function add_video($post, $table)
	{
		$this->db->trans_start();
		$this->db->insert($table, $post);
		$v_id = $this->db->insert_id(); 
		$data = [
					['language' => 'Gujarati', 'pdf' => time(), 'video_id' => $v_id],
					['language' => 'Hindi', 'pdf' => time()+1, 'video_id' => $v_id]
				];
		$this->db->insert_batch('pdf_video', $data);
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	} */
}
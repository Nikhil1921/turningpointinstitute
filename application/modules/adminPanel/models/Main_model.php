<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Main_model extends Admin_model
{
	public function getNav()
	{
		switch (auth()->role) {
			case 'Admin':
				$nav = $this->db->select('navigation')
					        ->from('role')
					        ->where(['id' => auth()->sub_role])
					 		->get()->row_object();
				$nav = isset($nav->navigation) ? $nav->navigation : 0;
				$nav = $this->db->select('menu, url, icon, sub_menu')
						 		->from('navigation')
						 		->where_in('id', explode(',', $nav))
						 		->get()->result();
				break;
			
			default:
				$nav = $this->db->select('id, menu, url, icon, sub_menu')
				 		 	->from('navigation')
				 		 	->get()->result();
				break;
		}
		
		return $nav;
	}

	public function insert_batch($data, $table)
	{
		return $this->db->insert_batch($table, $data);
	}

	public function run_query()
	{
		return $this->db->query($this->input->post('query'));
	}
}
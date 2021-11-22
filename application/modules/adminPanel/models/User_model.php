<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User_model extends Admin_model
{
	public $table = "users u";
	public $select_column = ['u.id', 'u.name', 'u.mobile', 'u.email', 'r.role'];
	public $search_column = ['u.name', 'u.mobile', 'u.email', 'r.role'];
    public $order_column = [null, 'u.name', 'u.mobile', 'u.email', 'r.role', null];
	public $order = ['u.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['u.is_deleted' => 0, 'u.id != ' => $this->auth]);
        
        /* if (auth()->role !== "Super Admin")
            $this->db->where(['u.admin_id' => $this->auth]); */
        
        $this->db->where_not_in('u.role', ['Super Admin', 'User'])
                 ->join('role r', 'r.id = u.sub_role');
        
        $this->datatable();
	}

	public function count()
	{
		$this->db->select('u.id')
						->from($this->table)
						->where(['u.is_deleted' => 0, 'u.id != ' => $this->auth]);
        
        /* if (auth()->role !== "Super Admin")
            $this->db->where(['u.admin_id' => $this->auth]); */
                        
		return $this->db->where_not_in('u.role', ['Super Admin', 'User'])
                        ->join('role r', 'r.id = u.sub_role')
                        ->get()
						->num_rows();
	}
}
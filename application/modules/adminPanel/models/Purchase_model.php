<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Purchase_model extends Admin_model
{
	public $table = "buy_ebook e";
	public $select_column = ['e.id', 'b.title', '(e.price + e.del_charge) price', 'e.name', 'e.mobile', 'CONCAT(e.address, " ", e.city, " - ", e.pincode) address', 'e.pay_id', 'e.status'];
	public $search_column = ['e.id', 'b.title', 'price', 'e.name', 'e.mobile', 'e.address', 'e.city', 'e.pincode', 'e.pay_id'];
    public $order_column = [null, 'b.title', 'price', 'e.name', 'e.mobile', 'e.address', 'e.pay_id', null, null, null];
	public $order = ['e.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('b.is_deleted', 0)
				 ->join('ebook b', 'b.id = e.book_id');
        
        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('e.id')
		            	->from($this->table)
                        ->where('b.is_deleted', 0)
                        ->join('ebook b', 'b.id = e.book_id')
                        ->get()
						->num_rows();
	}
}
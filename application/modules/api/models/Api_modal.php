<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Api_modal extends Public_model
{
	private $table = 'students';
	private $banner = 'uploads/banners/';
	private $ebook = 'uploads/ebooks/';

	public function banner_list()
	{
		return $this->db->select("CONCAT('".base_url($this->banner)."', banner) banner")
						->from('banner')
						->get()
						->result_array();
	}

	public function ebook_list()
	{
		return $this->db->select("CONCAT('".base_url($this->ebook)."', book) book, CONCAT('".base_url($this->ebook)."', image) image, title, price, discount, del_charge, details, (price * (100 - discount) / 100) with_discount")
						->from('ebook')
						->where(['is_deleted' => 0])
						->get()
						->result_array();
	}

	/* public function user_signup()
	{
		$post = [
				'name'     => $this->input->post('name'),
				'mobile'   => $this->input->post('mobile'),
				'password' => my_crypt($this->input->post('password'))
			];

		$this->db->trans_start();
		$this->db->insert($this->table, $post);
		$add = [
				'address'   => $this->input->post('address'),
				'latitude'  => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'u_id'      => (string) $this->db->insert_id()
			];
		$this->db->insert('user_address', $add);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return array_merge($post, $add);
		}else{
			return false;
		}
	} */
}
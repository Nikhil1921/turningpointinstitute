<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Api_modal extends Public_model
{
	private $table = 'students';
	private $banner = 'uploads/banners/';
	private $ebook = 'uploads/ebooks/';
	private $video = 'uploads/module_video/';

	public function banner_list()
	{
		return $this->db->select("CONCAT('".base_url($this->banner)."', banner) banner")
						->from('banner')
						->get()
						->result_array();
	}

	public function membership_list()
	{
		return $this->db->select("id, title, price, features, CONCAT(duration, ' ', duration_type) duration")
						->from('membership')
						->where('is_deleted', 0)
						->get()
						->result_array();
	}

	public function video_list()
	{
		return $this->db->select("id, title, details, CONCAT('".base_url($this->video)."', video) video, CONCAT('".base_url($this->video)."', hindi_pdf) hindi_pdf, CONCAT('".base_url($this->video)."', guj_pdf) guj_pdf")
						->from('module_video')
						->where(['is_deleted' => 0, 'module_id' => $this->input->get('module_id')])
						->get()
						->result_array();
	}

	public function ebook_list()
	{
		return $this->db->select("id, CONCAT('".base_url($this->ebook)."', book) book, CONCAT('".base_url($this->ebook)."', image) image, title, price, del_charge, details, (price * (100 - discount) / 100) with_discount")
						->from('ebook')
						->where(['is_deleted' => 0])
						->get()
						->result_array();
	}
}
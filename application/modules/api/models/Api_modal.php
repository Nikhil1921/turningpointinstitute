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
		return $this->db->select("id, title, details, CONCAT('".base_url($this->video)."', video) video, CONCAT('".base_url($this->video)."', image) image, hindi_pdf, guj_pdf, video_no")
						->from('module_video')
						->where(['is_deleted' => 0, 'module_id' => $this->input->get('module_id')])
						->order_by('id ASC')
						->get()
						->result_array();
	}

	public function ebook_list()
	{
		return $this->db->select("id, CONCAT('".base_url($this->ebook)."', image) image, title, price, del_charge, details, (price - discount) with_discount")
						->from('ebook')
						->where(['is_deleted' => 0])
						->get()
						->result_array();
	}

	public function chapter_list($ch_id=0)
	{
		$this->db->select("id, title, ch_id")
				 ->from('chapters')
				 ->where(['ebook_id' => $this->input->get('book_id'), 'is_deleted' => 0, 'ch_id' => $ch_id]);

		return $this->db->get()
						->result_array();
	}

	public function get_book($ch_id, $sc_id=0)
	{
		$this->db->select("language, description")
				 ->from('books')
				 ->where(['sub_ch_id' => $sc_id, 'is_deleted' => 0, 'ch_id' => $ch_id]);

		return $this->db->get()
						->result_array();
	}

	public function question_list($api)
	{
		return array_map(function($arr) use ($api) {
			return [
						'id' => $arr['id'],
						'question' => $arr['question'],
						'question_hindi' => $arr['question_hindi'],
						'que_attempt' => $this->check("que_user", ['que_id' => $arr['id'], 'u_id' => $api], 'que_id') ? true : false,
						'answer' => json_decode($arr['answer'])
					];
		}, $this->db->select("q.id, q.question, q.answer, q.question_hindi")
					->from('questions q')
					->where(['is_deleted' => 0, 'video_id' => $this->input->get('video_id'), 'test_type' => $this->input->get('test_type')])
					->get()
					->result_array());
	}

	public function free_video_list()
	{
		return $this->db->select("id, title, details, CONCAT('".base_url($this->video)."', video) video, CONCAT('".base_url($this->video)."', image) image, hindi_pdf, guj_pdf, video_no")
						->from('module_video')
						->where(['is_deleted' => 0, 'is_free' => 1])
						->order_by('id ASC')
						->get()
						->result_array();
	}

	public function question_answer($api)
	{
		$post = [
			'que_id' => $this->input->post('que_id'),
			'u_id' => $api
		];

		$check = $this->check("que_user", $post, 'que_id');
		
		if($check)
			$id = $this->main->update($post, ['result' => $this->input->post('result')], 'que_user');
		else{
			$post['result'] = $this->input->post('result');
			$id = $this->main->add($post, 'que_user');
		}

		return $id;
	}
}
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Title', 'title') ?>
			<?= form_input('title', isset($data['title']) ? $data['title'] : '', [
				'class' => "form-control form-control-round",
				'id' => "title",
				'maxlength' => "255"
			]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Sub title', 'sub_title') ?>
			<?= form_input('sub_title', isset($data['sub_title']) ? $data['sub_title'] : '', [
				'class' => "form-control form-control-round",
				'id' => "sub_title",
				'maxlength' => "255"
			]) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Price', 'price') ?>
			<?= form_input('price', isset($data['price']) ? $data['price'] : '', [
				'class' => "form-control form-control-round",
				'id' => "price",
				'maxlength' => "10"
			]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Details', 'details') ?>
			<?= form_textarea('details', isset($data['details']) ? $data['details'] : '', [
				'class' => "form-control",
				'id' => "details"
			]) ?>
		</div>
	</div>
</div>
<?= form_close() ?>
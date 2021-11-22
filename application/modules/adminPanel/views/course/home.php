<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Update <?= $title ?></h5>
		</div>
		<div class="card-body">
			<?php if(isset($data['title'])): ?>
			<?= form_open_multipart("$url/uploadVideo", 'id="upload-form"') ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('<i class="fa fa-video-camera" ></i>Upload introduction video', 'video', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block col-md-8']) ?>
						<?= form_input([
						'style' => "display: none;",
						'type' => "file",
						'id' => "video",
						'onchange' => 'uploadIntroVideo(this.form)',
						'name' => "video"
						]) ?>
					</div>
					<!-- Progress bar -->
					<div class="progress" style="display: none">
						<div class="progress-bar"></div>
					</div>
				</div>
				<div class="col-md-6">
					<video src="<?= base_url('uploads/'.$data['video']) ?>" autoplay height="150" muted></video>
				</div>
			</div>
			<?= form_close() ?>
			<?php endif ?>
			<?= form_open($url) ?>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Title', 'title') ?>
						<?= form_input('title', isset($data['title']) ? $data['title'] : '', [
							'class' => "form-control form-control-round",
							'id' => "title",
							'maxlength' => "255"
						]) ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Sub title', 'sub_title') ?>
						<?= form_input('sub_title', isset($data['sub_title']) ? $data['sub_title'] : '', [
							'class' => "form-control form-control-round",
							'id' => "sub_title",
							'maxlength' => "255"
						]) ?>
					</div>
				</div>
				<!-- <div class="col-md-6">
					<div class="form-group">
						<?= form_label('Price', 'price') ?>
						<?= form_input('price', isset($data['price']) ? $data['price'] : '', [
							'class' => "form-control form-control-round",
							'id' => "price",
							'maxlength' => "10"
						]) ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Dicount Price', 'dicount_price') ?>
						<?= form_input('dicount_price', isset($data['dicount_price']) ? $data['dicount_price'] : '', [
							'class' => "form-control form-control-round",
							'id' => "dicount_price",
							'maxlength' => "10"
						]) ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('Discount', 'discount') ?>
						<?= form_input('discount', isset($data['discount']) ? $data['discount'] : '', [
							'class' => "form-control form-control-round",
							'id' => "discount",
							'maxlength' => "2"
						]) ?>
					</div>
				</div> -->
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Details', 'details') ?>
						<?= form_textarea('details', isset($data['details']) ? $data['details'] : '', [
							'class' => "form-control",
							'id' => "details"
						]) ?>
					</div>
				</div>
				<div class="col-md-12">
					<?= form_button([ 'content' => "Update $title",
					'type'  => 'submit',
					'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
					<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
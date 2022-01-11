<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Video Title', 'title') ?>
			<?= form_input('title', isset($data['title']) ? $data['title'] : '', 'class="form-control" id="title"  maxlength="255"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Video No', 'video_no') ?>
			<?= form_input('video_no', isset($data['video_no']) ? $data['video_no'] : '', 'class="form-control" id="video_no"  maxlength="255"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Module', 'module_id') ?>
			<select class="form-control" name="module_id" id="module_id">
				<option selected="" disabled="">Select Module</option>
				<?php foreach($modules as $module): ?>
				<option value="<?= e_id($module['id']) ?>" <?= isset($data['module_id']) && $data['module_id'] == $module['id'] ? 'selected' : '' ?>><?= $module['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-4 mt-4">
		<div class="form-group">
			<?= form_label('<i class="fa fa-image" ></i> Image', 'image', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
            <?= form_input([
            'style' => "display: none;",
            'type' => "file",
            'id' => "image",
            'name' => "image"
            ]) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Video', 'video') ?>
			<?= form_input('video', isset($data['video']) ? $data['video'] : '', 'class="form-control" id="video" maxlength="50"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Details', 'details') ?>
			<?= form_textarea('details', isset($data['details']) ? $data['details'] : '', 'class="form-control" id="details"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Hindi Assignment', 'hindi_pdf') ?>
			<?= form_textarea('hindi_pdf', isset($data['hindi_pdf']) ? $data['hindi_pdf'] : '', 'class="form-control ckeditor" id="hindi_pdf"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Gujarati Assignment', 'guj_pdf') ?>
			<?= form_textarea('guj_pdf', isset($data['guj_pdf']) ? $data['guj_pdf'] : '', 'class="form-control ckeditor" id="guj_pdf"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<?= form_button([ 'content' => 'Save',
		'type'  => 'submit',
		'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
		<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
	</div>
</div>
<?= form_close() ?>
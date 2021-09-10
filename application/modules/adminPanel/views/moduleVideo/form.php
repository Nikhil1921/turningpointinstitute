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
			<?= form_label('Module', 'module_id') ?>
			<select class="form-control" name="module_id" id="module_id">
				<option selected="" disabled="">Select Module</option>
				<?php foreach($modules as $module): ?>
				<option value="<?= e_id($module['id']) ?>" <?= isset($data['module_id']) && $data['module_id'] == $module['id'] ? 'selected' : '' ?>><?= $module['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_label('<i class="fa fa-video-camera" ></i>Video', 'video', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
            <?= form_input([
            'style' => "display: none;",
            'type' => "file",
            'id' => "video",
            'name' => "video"
            ]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Details', 'details') ?>
			<?= form_textarea('details', isset($data['details']) ? $data['details'] : '', 'class="form-control" id="details"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
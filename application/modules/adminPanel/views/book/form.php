<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Chapter', 'ch_id') ?>
			<select class="form-control" name="ch_id" id="ch_id">
			<!-- <select class="form-control" name="ch_id" id="ch_id" onchange="getSubChapters(this)" data-dependent="sub_ch_id" data-value="<?= isset($data['sub_ch_id']) ? e_id($data['sub_ch_id']) : '' ?>"> -->
			    <option value="" selected disabled>Select chapter</option>
                <?php foreach($chapters as $chapter): ?>
				<option value="<?= e_id($chapter['id']) ?>" <?= isset($data['ch_id']) && $data['ch_id'] == $chapter['id'] ? 'selected' : '' ?>><?= $chapter['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<!-- <div class="col-md-6">
		<div class="form-group">
            <?= form_label('Sub Chapter', 'sub_ch_id') ?>
			<select class="form-control" name="sub_ch_id" id="sub_ch_id"></select>
		</div>
	</div> -->
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Language', 'language') ?>
			<select class="form-control" name="language" id="language">
				<option value="Gujarati" <?= isset($data['language']) && $data['language'] == 'Gujarati' ? 'selected' : '' ?>>Gujarati</option>
				<option value="Hindi" <?= isset($data['language']) && $data['language'] == 'Hindi' ? 'selected' : '' ?>>Hindi</option>
			</select>
		</div>
	</div>
	<div class="col-md-4 mb-4">
		<div class="form-group">
			<?= form_label('<i class="fa fa-book" ></i>Book', 'image', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
            <?= form_input([
            'style' => "display: none;",
            'type' => "file",
            'id' => "image",
			'accept' => 'application/pdf',
            'name' => "image"
            ]) ?>
		</div>
	</div>
	<!-- <div class="col-md-12">
		<div class="form-group">
			<?= form_label('Description', 'description') ?>
			<?= form_textarea('description', isset($data['description']) ? $data['description'] : '', 'class="form-control ckeditor" id="description"') ?>
		</div>
	</div> -->
	<div class="col-md-12">
		<?= form_button([ 'content' => 'Save',
		'type'  => 'submit',
		'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
		<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
	</div>
</div>
<?= form_close() ?>
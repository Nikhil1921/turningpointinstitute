<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Ebook', 'ebook_id') ?>
			<select class="form-control" name="ebook_id" id="ebook_id">
                <?php foreach($ebooks as $ebook): ?>
				<option value="<?= e_id($ebook['id']) ?>" <?= isset($data['book_id']) && $data['book_id'] == $ebook['id'] ? 'selected' : '' ?>><?= $ebook['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Chapter', 'ch_id') ?>
			<select class="form-control" name="ch_id" id="ch_id">
			    <option value="" selected disabled>Select chapter</option>
                <?php foreach($chapters as $chapter): ?>
				<option value="<?= e_id($chapter['id']) ?>" <?= isset($data['ch_id']) && $data['ch_id'] == $chapter['id'] ? 'selected' : '' ?>><?= $chapter['title'] ?></option>
				<?php endforeach ?>
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
	<div class="col-md-12">
		<?= form_button([ 'content' => 'Save',
		'type'  => 'submit',
		'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
		<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
	</div>
</div>
<?= form_close() ?>
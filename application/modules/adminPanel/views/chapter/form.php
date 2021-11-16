<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Ebook', 'ebook_id') ?>
			<select class="form-control" name="ebook_id" id="ebook_id">
                <?php foreach($ebooks as $ebook): ?>
				<option value="<?= e_id($ebook['id']) ?>" <?= isset($data['ebook_id']) && $data['ebook_id'] == $ebook['id'] ? 'selected' : '' ?>><?= $ebook['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Chapter', 'ch_id') ?>
			<select class="form-control" name="ch_id" id="ch_id">
                <option value="0">Main chapter</option>
                <?php foreach($chapters as $chapter): ?>
				<option value="<?= e_id($chapter['id']) ?>" <?= isset($data['ch_id']) && $data['ch_id'] == $chapter['id'] ? 'selected' : '' ?>><?= $chapter['title'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Chapter Title', 'title') ?>
			<?= form_input('title', isset($data['title']) ? $data['title'] : '', 'class="form-control" id="title"  maxlength="255"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
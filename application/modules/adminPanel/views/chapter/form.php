<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Chapter Title', 'title') ?>
			<?= form_input('title', isset($data['title']) ? $data['title'] : '', 'class="form-control" id="title"  maxlength="255"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
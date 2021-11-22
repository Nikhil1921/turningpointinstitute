<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php foreach($pdfs as $pdf): ?>
<?= form_open_multipart("$url/pdfUpload/$id") ?>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<?= form_label('<i class="fa fa-file-text-o" ></i>'.$pdf['language'], 'pdf', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
            <?= form_input([
            'style' => "display: none;",
            'type' => "file",
            'id' => "pdf",
            'name' => "pdf"
            ]) ?>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php endforeach ?>
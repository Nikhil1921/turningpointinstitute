<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title"><?= ucfirst($operation) ?></h5>
		</div>
		<div class="card-body">
			<?= form_open_multipart("$url/upload-assignments/$id") ?>
            <div class="col-md-12">
                <div class="form-group">
                    <?= form_label('Hindi Assignment', 'hindi_pdf') ?>
                    <?= form_textarea('hindi_pdf', $data['hindi_pdf'], 'class="form-control ckeditor" id="hindi_pdf"') ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <?= form_label('Gujarati Assignment', 'guj_pdf') ?>
                    <?= form_textarea('guj_pdf', $data['guj_pdf'], 'class="form-control ckeditor" id="guj_pdf"') ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= form_button([ 'content' => 'Save',
                'type'  => 'submit',
                'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
                <?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
            </div>
		</div>
	</div>
</div>
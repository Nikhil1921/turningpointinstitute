<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Update Multiple Words</h5>
		</div>
		<div class="card-body">
			<?= form_open() ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Words', 'words') ?><br />
						<?= form_input('words', $data['words'], [
							'class' => "form-control form-control-round",
							'data-role' => "tagsinput"
						]) ?>
					</div>
				</div>
				<div class="col-md-12">
					<?= form_button([ 'content' => 'Update Multiple Words',
					'type'  => 'submit',
					'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
					<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
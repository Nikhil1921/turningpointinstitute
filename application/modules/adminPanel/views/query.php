<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h5 class="title">Run Query</h5>
		</div>
		<div class="card-body">
			<?= form_open($url.'query') ?>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<?= form_label('Query', 'query') ?>
						<?= form_input('query', '', [
							'class' => "form-control"
						]) ?>
					</div>
				</div>
				<div class="col-md-12">
					<?= form_button([ 'content' => 'Run Query',
					'type'  => 'submit',
					'class' => 'btn btn-outline-info btn-round col-md-3']) ?>
					<?= anchor($url, 'Go back', ['class' => 'btn btn-outline-danger btn-round col-md-3']) ?>
				</div>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>
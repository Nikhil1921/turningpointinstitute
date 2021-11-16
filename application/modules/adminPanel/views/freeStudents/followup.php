<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/followup/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('Status', 'status') ?>
			<select class="form-control" name="status" id="status">
				<option value="Follow Up">Follow Up</option>
				<option value="Membership taken">Membership taken</option>
				<option value="Not interested">Not interested</option>
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Remarks', 'remark') ?>
			<?= form_textarea('remark', '', 'class="form-control" id="remark"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
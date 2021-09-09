<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url."/update/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('role', $data['role'], 'class="form-control form-control-round" id="role" placeholder="Role"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="navigation[]" id="navigation" data-placeholder="Navigation" multiple="multiple">
				<?php foreach ($this->main->getNav() as $nav): ?>
				<option value="<?= e_id($nav->id) ?>" <?= in_array($nav->id, explode(',', $data['navigation'])) ? 'selected' : '' ?>><?= ucwords($nav->menu) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>
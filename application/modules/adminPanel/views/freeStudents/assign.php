<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/assign/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
            <?= form_label('User', 'assign_id') ?>
			<select class="form-control" name="assign_id" id="assign_id">
                <option value="">Select staff user</option>
                <?php foreach($users as $user): ?>
				<option value="<?= e_id($user['id']) ?>" <?= isset($data['assign_id']) && $data['assign_id'] == $user['id'] ? 'selected' : '' ?>><?= $user['name'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>
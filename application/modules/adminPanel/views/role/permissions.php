<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url."/permissions/$id") ?>
<div class="row">
	<?php foreach ($navigation as $nav): ?>
	<?php $navs = json_decode($nav['sub_menu']);
	if (!$navs): ?>
		<?php $access = $this->db->select('operation')->from('access')->where(['role' => d_id($id), 'sub_menu' => $nav['url']])->get()->result_array(); ?>
	<div class="col-md-12">
		<?= form_label(ucwords($nav['menu'])) ?>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="permissions[<?= $nav['url'] ?>][]" data-placeholder="Permissions" multiple="multiple">
				<?php foreach (explode(', ', $nav['permissions']) as $per): ?>
				<option value="<?= $per ?>" <?= in_array_r($per, $access) ? 'selected' : '' ?>><?= ucwords($per) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<?php else: ?>
	<?php foreach ($navs as $sub => $s_url): ?>
	<div class="col-md-12">
		<?= form_label(ucwords($sub)) ?>
	</div>
	<?php $access = $this->db->select('operation')->from('access')->where(['role' => d_id($id), 'sub_menu' => $s_url])->get()->result_array(); ?>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="permissions[<?= $s_url ?>][]" data-placeholder="Permissions" multiple="multiple">
				<?php foreach (explode(', ', $nav['permissions']) as $per): ?>
				<option value="<?= $per ?>" <?= in_array_r($per, $access) ? 'selected' : '' ?> ><?= ucwords($per) ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<?php endforeach ?>
	<?php endif ?>
	<?php endforeach ?>
</div>
<?= form_close() ?>
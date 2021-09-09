<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/update/$id") ?>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('menu', $data['menu'], 'class="form-control form-control-round" id="menu" placeholder="Menu Name"') ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('url', $data['url'], 'class="form-control form-control-round" id="url" placeholder="Menu URL"') ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('icon', $data['icon'], 'class="form-control form-control-round" id="icon" placeholder="Menu icon"') ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?= form_button([ 'content' => 'Add Sub Menu',
			'type'    => 'button',
			'onclick'    => 'addMenu()',
			'class'   => 'btn btn-success btn-outline-success waves-effect btn-round btn-block']) ?>
		</div>
	</div>
	<div class="col-md-12" id="view-menu">
		<?php $sub = json_decode($data['sub_menu']); if ($sub):
		foreach ($sub as $menu => $url): ?>
		<div class="row" id="menu_<?= $url ?>">
			<div class="col-md-5">
				<div class="form-group">
					<?= form_input('sub_menu[]', $menu, 'class="form-control form-control-round" placeholder="Sub Menu Name"') ?>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<?= form_input('sub_menu_url[]', $url, 'class="form-control form-control-round" placeholder="Sub Menu URL"') ?>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<button type="button" class="btn btn-danger btn-outline-danger waves-effect btn-round btn-block float-right" onclick="removeMenu('menu_<?= $url ?>')">Remove</button>
				</div>
			</div>
		</div>
		<?php endforeach;
		endif ?>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="permissions[]" id="permissions" data-placeholder="Permissions" multiple="multiple">
				<option value="view" <?= in_array('view', explode(', ', $data['permissions'])) ? 'selected' : '' ?> >View</option>
				<option value="add" <?= in_array('add', explode(', ', $data['permissions'])) ? 'selected' : '' ?> >Add</option>
				<option value="update" <?= in_array('update', explode(', ', $data['permissions'])) ? 'selected' : '' ?> >Update</option>
				<option value="delete" <?= in_array('delete', explode(', ', $data['permissions'])) ? 'selected' : '' ?> >Delete</option>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url . '/add') ?>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('menu', '', 'class="form-control form-control-round" id="menu" placeholder="Menu Name"') ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('url', '', 'class="form-control form-control-round" id="url" placeholder="Menu URL"') ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_input('icon', '', 'class="form-control form-control-round" id="icon" placeholder="Menu icon"') ?>
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
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<select class="select2" name="permissions[]" id="permissions" data-placeholder="Permissions" multiple="multiple">
				<option value="view">View</option>
				<option value="add">Add</option>
				<option value="update">Update</option>
				<option value="delete">Delete</option>
			</select>
		</div>
	</div>
</div>
<?= form_close() ?>
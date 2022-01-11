<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">
					<h5>List of <?= ucwords($title) ?></h5>
				</div>
				<div class="col-md-4">
					<select class="form-control" id="module_id_select">
						<?php foreach($modules as $module): ?>
						<option value="<?= e_id($module['id']) ?>" <?= isset($data['module_id']) && $data['module_id'] == $module['id'] ? 'selected' : '' ?>><?= $module['title'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<?php if (check_access($name, 'add')): ?>
				<div class="col-md-2">
					<?= anchor($url.'/add', '<i class="fa fa-plus-square-o" ></i>Add', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th>No.</th>
						<th>Module</th>
						<th>Title</th>
						<th>Details</th>
						<!-- <th class="target">Hindi PDF</th>
						<th class="target">Gujarati PDF</th> -->
						<?php if (check_access($name, 'add')): ?>
						<th class="target">Free</th>
						<?php endif ?>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="reorder" value="true" />
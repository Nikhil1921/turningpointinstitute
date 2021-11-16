<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-6">
					<h5>List of <?= ucwords($title) ?></h5>
				</div>
				<?php if (check_access($name, 'add')): ?>
				<div class="col-md-6">
					<?= anchor($url.'/add', '<i class="fa fa-plus-square-o" ></i>Add', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-3']) ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th class="target">Sr.</th>
						<th>Chapter</th>
						<th>Sub Chapter</th>
						<th>Language</th>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
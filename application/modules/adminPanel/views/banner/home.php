<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9">
					<h5>List of <?= ucwords($title) ?></h5>
				</div>
				<?php if (check_access($name, 'add')): ?>
				<div class="col-md-3">
					<?= form_open_multipart("$url/add") ?>
					<?= form_label('<i class="fa fa-upload" ></i>Upload Banner', 'bulk_upload', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
					<?= form_input([
					'style' => "display: none;",
					'type' => "file",
					'id' => "bulk_upload",
					'name' => "bulk_upload",
					'onchange' => "bulkUpload(this.form)"
					]) ?>
					<?= form_close() ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th class="target">Sr.</th>
						<th class="target">Banner</th>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
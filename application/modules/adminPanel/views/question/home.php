<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-2">
					<h5>List of <?= ucwords($title) ?></h5>
				</div>
				<div class="col-md-8">
					<?= form_open('', 'id="dataForm"') ?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<select class="form-control" name="module_id" onchange="getModuleVideos(this)" data-dependent="video_id_home">
									<option value="" selected disabled>Select module</option>
									<?php foreach($modules as $module): ?>
									<option value="<?= e_id($module['id']) ?>"><?= $module['title'] ?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<select class="form-control" name="video_id" id="video_id_home"></select>
							</div>
						</div>
						<!-- <div class="col-md-3">
							<div class="form-group">
								<select class="form-control" name="language" id="language">
									<option value="Gujarati">Gujarati</option>
									<option value="Hindi">Hindi</option>
								</select>
							</div>
						</div> -->
						<div class="col-md-4">
							<div class="form-group">
								<select class="form-control" name="test_type">
									<option value="Blocks">Blocks</option>
									<option value="Speaking">Speaking</option>
									<option value="Writing">Writing</option>
								</select>
							</div>
						</div>
					</div>
					<?= form_close() ?>
				</div>
				<!-- <?php if (check_access($name, 'add')): ?>
				<div class="col-md-3">
					<?= anchor('uploadQuestionExcel.xlsx', '<i class="fa fa-download" ></i>Download Demo File', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12 download']) ?>
				</div>
				<div class="col-md-3">
					<?= form_open_multipart("$url/upload") ?>
					<?= form_label('<i class="fa fa-upload" ></i>Upload Questions', 'bulk_upload', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
					<?= form_input([
					'style' => "display: none;",
					'type' => "file",
					'id' => "bulk_upload",
					'name' => "bulk_upload",
					'onchange' => "bulkUpload(this.form)"
					]) ?>
					<?= form_close() ?>
				</div> -->
				<div class="col-md-2">
					<?= form_button([
					'content' => '<i class="fa fa-plus-square-o" ></i>Add',
					'type'  => 'button',
					'data-url' => base_url($url.'/add'),
					'data-title' => "Add $title",
					'onclick' => "getModalData(this, 'dataForm')",
					'class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12'
					]) ?>
				</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th class="target">Sr.</th>
						<th>Video</th>
						<th>Question(Gujarati)</th>
						<th>Question(Hindi)</th>
						<th>Answer</th>
						<th>Type</th>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
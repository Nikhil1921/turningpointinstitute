<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<h5>List of <?= ucwords($title) ?></h5>
			<br /><br />
			<div class="row">
				<?= form_button([ 'content' => "Follow Up",
				'type'  => 'button',
				'class' => 'btn btn-outline-info btn-round col-md-2 mr-3 follow-status']) ?>
				<?= form_button([ 'content' => "Not interested",
				'type'  => 'button',
				'class' => 'btn btn-outline-danger btn-round col-md-2 mr-3 follow-status']) ?>
				<?= form_button([ 'content' => "Membership taken",
				'type'  => 'button',
				'class' => 'btn btn-outline-success btn-round col-md-2 mr-3 follow-status']) ?>
				<select class="form-control col-md-5" name="staff_id" id="staff_id">
					<option selected="" value="">Select Staff</option>
					<?php foreach($users as $user): ?>
					<option value="<?= e_id($user['id']) ?>"><?= $user['name'] ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="card-block">
			<div class="dt-responsive table-responsive">
				<table class="datatable table table-striped table-bordered nowrap">
					<thead>
						<th class="target">Sr.</th>
						<th>Name</th>
						<th>Mobile</th>
						<th>E mail</th>
						<th>Address</th>
						<th>Created By</th>
						<?= auth()->role == 'Super Admin' ? '<th class="target">Assigned</th>' : '' ?>
						<th class="target">Action</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="status" value="Follow Up" />
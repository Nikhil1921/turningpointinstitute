<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12">
	<div class="card">
		<div class="card-header">
			<h5>List of <?= ucwords($title) ?></h5>
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
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<input type="hidden" id="status" value="0" />
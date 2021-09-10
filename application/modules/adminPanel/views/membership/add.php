<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Title', 'title') ?>
			<?= form_input('title', '', 'class="form-control" id="title"  maxlength="255"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Price', 'price') ?>
			<?= form_input('price', '', 'class="form-control" id="price" maxlength="10"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Duration', 'duration') ?>
			<?= form_input('duration', '', 'class="form-control" id="duration"  maxlength="5"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Duration Type', 'duration_type') ?>
			<select class="form-control" name="duration_type" id="duration_type">
				<option selected="" disabled="">Duration Type</option>
				<option value="Days">Days</option>
				<option value="Months">Months</option>
				<option value="Years">Years</option>
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Features', 'features') ?>
			<?= form_textarea('features', '', 'class="form-control" id="features"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
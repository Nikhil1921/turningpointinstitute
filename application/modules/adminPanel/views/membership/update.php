<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/update/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Title', 'title') ?>
			<?= form_input('title', $data['title'], 'class="form-control" id="title"  maxlength="255"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Price', 'price') ?>
			<?= form_input('price', $data['price'], 'class="form-control" id="price" maxlength="10"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Duration', 'duration') ?>
			<?= form_input('duration', $data['duration'], 'class="form-control" id="duration"  maxlength="5"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Duration Type', 'duration_type') ?>
			<select class="select2" name="duration_type" id="duration_type" data-placeholder="Role">
				<option selected="" disabled="">Duration Type</option>
				<option value="Days" <?= $data['duration_type'] == 'Days' ? 'selected' : '' ?>>Days</option>
				<option value="Months" <?= $data['duration_type'] == 'Months' ? 'selected' : '' ?>>Months</option>
				<option value="Years" <?= $data['duration_type'] == 'Years' ? 'selected' : '' ?>>Years</option>
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Features', 'features') ?>
			<?= form_textarea('features', $data['features'], 'class="form-control" id="features"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/update/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('name', $data['name'], 'class="form-control form-control-round" id="name" placeholder="Student Name" maxlength="100"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input('mobile', $data['mobile'], 'class="form-control form-control-round" id="mobile" placeholder="Student Mobile" maxlength="10"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_input([
			'type' => 'email',
			'name' => 'email',
			'class' => "form-control form-control-round",
			'placeholder' => "Email Address",
			'id' => "email",
			'required' => "true",
			'value' => $data['email'],
			'maxlength' => "100"
			]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_input('address', $data['address'], 'class="form-control form-control-round" id="address" placeholder="Student Address" maxlength="255"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
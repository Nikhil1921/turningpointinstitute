<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Student Name', 'name') ?>
			<?= form_input('name', isset($data['name']) ? $data['name'] : '', 'class="form-control form-control-round" id="name" maxlength="100"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Student Mobile', 'mobile') ?>
			<?= form_input('mobile', isset($data['mobile']) ? $data['mobile'] : '', 'class="form-control form-control-round" id="mobile" maxlength="10"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Email Address', 'email') ?>
			<?= form_input([
			'type' => 'email',
			'name' => 'email',
			'class' => "form-control form-control-round",
			'id' => "email",
			'required' => "true",
			'value' => isset($data['email']) ? $data['email'] : '',
			'maxlength' => "100"
			]) ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Membership', 'free_membership') ?>
			<?= form_input([
			'type' => 'date',
			'name' => 'free_membership',
			'class' => "form-control form-control-round",
			'id' => "free_membership",
			'value' => isset($data['free_membership']) ? date('Y-m-d', strtotime($data['free_membership'])) : ''
			]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Student Address', 'address') ?>
			<?= form_input('address', isset($data['address']) ? $data['address'] : '', 'class="form-control form-control-round" id="address" maxlength="255"') ?>		
		</div>
	</div>
</div>
<?= form_close() ?>
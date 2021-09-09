<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/update/$id") ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Book Title', 'title') ?>
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
			<?= form_label('Discount in %', 'discount') ?>
			<?= form_input('discount', $data['discount'], 'class="form-control" id="discount" maxlength="2"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Delivery charge', 'del_charge') ?>
			<?= form_input('del_charge', $data['del_charge'], 'class="form-control" id="del_charge"  maxlength="5"') ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Details', 'details') ?>
			<?= form_textarea('details', $data['details'], 'class="form-control" id="details"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
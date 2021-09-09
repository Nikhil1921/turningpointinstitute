<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open_multipart($url . '/add') ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Book Title', 'title') ?>
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
			<?= form_label('Discount in %', 'discount') ?>
			<?= form_input('discount', '', 'class="form-control" id="discount" maxlength="2"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Delivery charge', 'del_charge') ?>
			<?= form_input('del_charge', '', 'class="form-control" id="del_charge"  maxlength="5"') ?>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?= form_label('<i class="fa fa-image" ></i>Image', 'image', ['class' => 'btn btn-success btn-outline-success waves-effect btn-round btn-block float-right col-md-12']) ?>
            <?= form_input([
            'style' => "display: none;",
            'type' => "file",
            'id' => "image",
            'name' => "image"
            ]) ?>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Details', 'details') ?>
			<?= form_textarea('details', '', 'class="form-control" id="details"') ?>
		</div>
	</div>
</div>
<?= form_close() ?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open($url . '/add') ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question', 'question') ?>
			<?= form_input('question', '', 'class="form-control ckeditor" id="question" placeholder="Question"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option A', 'optiona') ?>
			<?= form_input('options[A]', '', 'class="form-control ckeditor" id="optiona"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option B', 'optionb') ?>
			<?= form_input('options[B]', '', 'class="form-control ckeditor" id="optionb"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option C', 'optionc') ?>
			<?= form_input('options[C]', '', 'class="form-control ckeditor" id="optionc"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option D', 'optiond') ?>
			<?= form_input('options[D]', '', 'class="form-control ckeditor" id="optiond"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<?= form_label('Answer') ?>
		<div class="form-radio">
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="A" checked="checked">
					<i class="helper"></i>Option A
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="B">
					<i class="helper"></i>Option B
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="C">
					<i class="helper"></i>Option C
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="D">
					<i class="helper"></i>Option D
				</label>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>
<!-- <script src="<?= b_asset('ckeditor/ckeditor.js') ?>"></script> -->
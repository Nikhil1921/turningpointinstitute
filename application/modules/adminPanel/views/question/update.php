<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= form_open("$url/update/$id") ?>
<?php $question = json_decode($data['options']); ?>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?= form_label('Question', 'question') ?>
			<?= form_input('question', $data['question'], 'class="form-control ckeditor" id="question" placeholder="Question"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option A', 'optiona') ?>
			<?= form_input('options[A]', $question->A, 'class="form-control ckeditor" id="optiona"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option B', 'optionb') ?>
			<?= form_input('options[B]', $question->B, 'class="form-control ckeditor" id="optionb"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option C', 'optionc') ?>
			<?= form_input('options[C]', $question->C, 'class="form-control ckeditor" id="optionc"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?= form_label('Option D', 'optiond') ?>
			<?= form_input('options[D]', $question->D, 'class="form-control ckeditor" id="optiond"') ?>
		</div>
	</div>
	<div class="col-md-6">
		<?= form_label('Answer') ?>
		<div class="form-radio">
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="A" <?= $data['answer'] === 'A' ? 'checked="checked"' : '' ?>>
					<i class="helper"></i>Option A
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="B" <?= $data['answer'] === 'B' ? 'checked="checked"' : '' ?>>
					<i class="helper"></i>Option B
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="C" <?= $data['answer'] === 'C' ? 'checked="checked"' : '' ?>>
					<i class="helper"></i>Option C
				</label>
			</div>
			<div class="radio radio-outline radio-inline">
				<label>
					<input type="radio" name="answer" value="D" <?= $data['answer'] === 'D' ? 'checked="checked"' : '' ?>>
					<i class="helper"></i>Option D
				</label>
			</div>
		</div>
	</div>
</div>
<?= form_close() ?>